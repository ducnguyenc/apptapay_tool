<!DOCTYPE html>
<html>
<head>
    <title>Enter OTP</title>
</head>
<body>
<h1>Verify OTP</h1>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<p>An OTP has been sent to your email.</p>
<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    <div>
        <label for="otp">OTP:</label>
        <input type="text" name="otp" id="otp" required maxlength="6">
    </div>
    <div>
        <button type="submit">Verify</button>
    </div>
</form>
</body>
</html>
