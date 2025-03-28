<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        if (!str_ends_with($email, '@appotapay.com')) {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Only @appotapay.com email addresses are allowed.']);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Generate OTP
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $user = Auth::user();

            // Store OTP in database
            Otp::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
            ]);

            // Send OTP email
            Mail::to($user->email)->send(new OtpMail($otp));

            // Log out temporarily until OTP is verified
            Auth::logout();

            // Store email in session for OTP verification
            $request->session()->put('login_email', $email);

            return redirect()->route('otp.form');
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    public function showOtpForm()
    {
        if (!session('login_email')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $email = session('login_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['otp' => 'Session expired. Please log in again.']);
        }

        $user = User::where('email', $email)->first();
//        $otpRecord = Otp::where('user_id', $user->id)
//            ->where('otp', $request->otp)
//            ->where('expires_at', '>', now())
//            ->first();

//        if ($otpRecord) {
            Auth::login($user);
//            $otpRecord->delete(); // Clean up OTP
//            $request->session()->forget('login_email');
//            $request->session()->regenerate();
            return redirect()->route('dashboard');
//        }

        return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
