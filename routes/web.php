<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AppotaPayController;

Route::get('/welcome', function (){
    return view('welcome');
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/otp', [LoginController::class, 'showOtpForm'])->name('otp.form');
Route::post('/otp', [LoginController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AppotaPayController::class, 'dashboard'])->name('dashboard');
    Route::post('/upload-file', [AppotaPayController::class, 'uploadFileCer'])->name('upload.file_cer');
    Route::post('/upload-file-crt', [AppotaPayController::class, 'uploadFileCrt'])->name('upload.file_crt');
    Route::post('/upload-file-csv', [AppotaPayController::class, 'uploadFileCSV'])->name('upload.file_csv');
    Route::post('/upload-file-excel', [AppotaPayController::class, 'uploadFileExcel'])->name('upload.file_excel');

    Route::get('/base64-decode', [AppotaPayController::class, 'base64Decode'])->name('appotapay1');
    Route::post('/base64-decode', [AppotaPayController::class, 'processBase64Decode'])->name('process.data1');

    Route::get('/base64-encode', [AppotaPayController::class, 'base64Encode'])->name('appotapay2');
    Route::post('/base64-encode', [AppotaPayController::class, 'processBase64Encode'])->name('process.data2');

    Route::get('/array-to-json', [AppotaPayController::class, 'arrayToJson'])->name('appotapay3');
    Route::post('/array-to-json', [AppotaPayController::class, 'processArrayToJson'])->name('process.data3');

    Route::get('/json-to-array', [AppotaPayController::class, 'jsonToArray'])->name('appotapay4');
    Route::post('/json-to-array', [AppotaPayController::class, 'processJsonToArray'])->name('process.data4');

    Route::get('/json-format', [AppotaPayController::class, 'jsonFormat'])->name('appotapay5');
    Route::post('/json-format', [AppotaPayController::class, 'processJsonFormat'])->name('process.data5');

    Route::get('/gen-rsa-pem', [AppotaPayController::class, 'genRsaPem'])->name('appotapay6');
    Route::post('/gen-rsa-pem', [AppotaPayController::class, 'processGenRsaPem'])->name('process.data6');

    Route::get('/crt-to-pem', [AppotaPayController::class, 'crtToPem'])->name('appotapay7');
    Route::post('/crt-to-pem', [AppotaPayController::class, 'processCrtToPem'])->name('process.data7');

    Route::get('/cer-to-pem', [AppotaPayController::class, 'cerToPem'])->name('appotapay8');
    Route::post('/cer-to-pem', [AppotaPayController::class, 'processCerToPem'])->name('process.data8');

    Route::get('/gen-cer', [AppotaPayController::class, 'genCer'])->name('appotapay9');
    Route::post('/gen-cer', [AppotaPayController::class, 'processGenCer'])->name('process.data9');

    Route::get('/gen-crt', [AppotaPayController::class, 'genCrt'])->name('appotapay10');
    Route::post('/gen-crt', [AppotaPayController::class, 'processGenCrt'])->name('process.data10');

    Route::get('/create-tele-channel', [AppotaPayController::class, 'createTeleChannel'])->name('appotapay11');
    Route::post('/create-tele-channel', [AppotaPayController::class, 'processCreateTeleChannel'])->name('process.data11');
    Route::post('/get-chat-id', [AppotaPayController::class, 'processGetChatId'])->name('process.data15');

    Route::get('/gen-signature', [AppotaPayController::class, 'genSignature'])->name('appotapay12');
    Route::post('/gen-signature', [AppotaPayController::class, 'processGenSignature'])->name('process.data12');

    Route::get('/csv-to-excel', [AppotaPayController::class, 'csvToExcel'])->name('appotapay13');
    Route::post('/csv-to-excel', [AppotaPayController::class, 'processCsvToExcel'])->name('process.data13');

    Route::get('/excel-to-csv', [AppotaPayController::class, 'excelToCsv'])->name('appotapay14');
    Route::post('/excel-to-csv', [AppotaPayController::class, 'processExcelToCsv'])->name('process.data14');
});
