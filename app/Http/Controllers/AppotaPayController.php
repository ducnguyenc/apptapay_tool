<?php

namespace App\Http\Controllers;

use App\Exports\CsvToExcelExport;
use App\Exports\ExcelToCsvExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;
use danog\MadelineProto\API;
use Illuminate\Support\Facades\Http;

class AppotaPayController extends Controller
{

    public function __construct() {}

    public function dashboard()
    {
        return view('app.dashboard');
    }

    public function base64Decode()
    {
        return view('app.app-view-function1');
    }

    public function processBase64Decode(Request $request)
    {
        try {
            $input = $request->input('input');
            if (empty($input)) {
                return response()->json(['result' => "Input không được để trống"]);
            }

            $result = base64_decode($input);
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            Log::debug("processBase64Decode Exception", ['exception' => $e->getMessage()]);
            return response()->json(['result' => "Lỗi hệ thống"]);
        }
    }

    public function base64Encode()
    {
        return view('app.app-view-function2');
    }

    public function processBase64Encode(Request $request)
    {
        try {
            $input = $request->input('input');
            if (empty($input)) {
                return response()->json(['result' => "Input không được để trống"]);
            }

            $result = base64_encode($input);
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            Log::debug("processBase64Decode Exception", ['exception' => $e->getMessage()]);
            return response()->json(['result' => "Lỗi hệ thống"]);
        }
    }

    public function arrayToJson()
    {
        return view('app.app-view-function3');
    }

    public function jsonToArray()
    {
        return view('app.app-view-function4');
    }

    public function jsonFormat()
    {
        return view('app.app-view-function5');
    }

    public function processJsonFormat(Request $request)
    {
        try {
            $input = $request->input('input');
            if (empty($input)) {
                return response()->json(['result' => "Input không được để trống"]);
            }

            $parseToArray = json_decode($input, true) ?? [];
            if (empty($parseToArray)) {
                return response()->json(['result' => "Data không đúng định dạng JSON"]);
            }

            $resultData = json_encode($parseToArray, JSON_PRETTY_PRINT);
            return response()->json(['result' => $resultData]);
        } catch (\Exception $e) {
            Log::debug("processBase64Decode Exception", ['exception' => $e->getMessage()]);
            return response()->json(['result' => "Lỗi hệ thống"]);
        }
    }

    public function genRsaPem()
    {
        // Define paths for the keys
        $privateKeyPath = storage_path('app/private_key.pem');
        $publicKeyPath = storage_path('app/public_key.pem');

        try {
            // Command 1: Generate a 2048-bit RSA private key
            $command1 = "openssl genrsa -out " . $privateKeyPath . " 2048";
            exec($command1, $output1, $returnVar1);

            if ($returnVar1 !== 0) {
                throw new \Exception("Failed to generate private key: " . implode("\n", $output1));
            }

            // Command 2: Generate public key from private key
            $command2 = "openssl rsa -in " . $privateKeyPath . " -pubout -out " . $publicKeyPath;
            exec($command2, $output2, $returnVar2);

            if ($returnVar2 !== 0) {
                throw new \Exception("Failed to generate public key: " . implode("\n", $output2));
            }

            // Create a ZIP file containing both keys
            $zipPath = storage_path('app/keys.zip');
            $zip = new \ZipArchive();

            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \Exception("Cannot create ZIP file.");
            }

            // Add the private and public keys to the ZIP
            $zip->addFile($privateKeyPath, 'private_key.pem');
            $zip->addFile($publicKeyPath, 'public_key.pem');
            $zip->close();

            // Download the ZIP file
            return response()->download($zipPath, 'keys.zip')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            // Clean up files in case of error
            if (file_exists($privateKeyPath)) {
                unlink($privateKeyPath);
            }
            if (file_exists($publicKeyPath)) {
                unlink($publicKeyPath);
            }
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function crtToPem()
    {
        return view('app.app-view-function7');
    }

    public function processCrtToPem(Request $request)
    {
        $fileName = $request->input('filename');
        if (empty($fileName)) {
            return response()->json(['result' => "Upload file lỗi, file không tồn tại!"]);
        }
        $inputFile = storage_path('app/private/uploads/' . $fileName); // Path to the input file
        $outputFile = storage_path('app/publickey.pem'); // Path for the output file

        try {
            // Check if the input file exists
            if (!file_exists($inputFile)) {
                throw new \Exception("Input file publickey.cer not found in storage/app directory.");
            }

            // Command to convert the certificate to PEM format
            $command = "openssl x509 -in " . escapeshellarg($inputFile) . " -pubkey -noout -out " . escapeshellarg($outputFile);
            exec($command, $output, $returnVar);

            // Check if the command executed successfully
            if ($returnVar !== 0) {
                throw new \Exception("Failed to convert certificate: " . implode("\n", $output));
            }

            // Check if the output file was created
            if (!file_exists($outputFile)) {
                throw new \Exception("Output file publickey.pem was not created.");
            }

            unlink($inputFile);

            // Download the file
            return response()->download($outputFile, 'publickey.pem')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::debug("aaaaa", ['exception' => $e->getMessage()]);
            // Clean up the output file if it exists
            if (file_exists($outputFile)) {
                unlink($outputFile);
            }

            // Clean up the input file if it exists
            if (file_exists($inputFile)) {
                unlink($inputFile);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cerToPem()
    {
        return view('app.app-view-function8');
    }

    public function processCerToPem(Request $request)
    {
        $fileName = $request->input('filename');
        if (empty($fileName)) {
            return response()->json(['result' => "Upload file lỗi, file không tồn tại!"]);
        }
        $inputFile = storage_path('app/private/uploads/' . $fileName); // Path to the input file
        $outputFile = storage_path('app/publickey.pem'); // Path for the output file

        try {
            // Check if the input file exists
            if (!file_exists($inputFile)) {
                throw new \Exception("Input file publickey.cer not found in storage/app directory.");
            }

            // Command to convert the certificate to PEM format
            $command = "openssl x509 -inform der -in " . escapeshellarg($inputFile) . " -pubkey -noout > " . escapeshellarg($outputFile);
            exec($command, $output, $returnVar);

            // Check if the command executed successfully
            if ($returnVar !== 0) {
                throw new \Exception("Failed to convert certificate: " . implode("\n", $output));
            }

            // Check if the output file was created
            if (!file_exists($outputFile)) {
                throw new \Exception("Output file publickey.pem was not created.");
            }

            unlink($inputFile);

            // Download the file
            return response()->download($outputFile, 'publickey.pem')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::debug("aaaaa", ['exception' => $e->getMessage()]);
            // Clean up the output file if it exists
            if (file_exists($outputFile)) {
                unlink($outputFile);
            }

            // Clean up the input file if it exists
            if (file_exists($inputFile)) {
                unlink($inputFile);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function genCer()
    {
        $privateKeyPath = storage_path('app/private.key');
        $certificatePath = storage_path('app/publickey.cer');

        try {
            // Step 1: Generate a 2048-bit RSA private key
            $command1 = "openssl genrsa -out " . $privateKeyPath . " 2048";
            exec($command1, $output1, $returnVar1);

            if ($returnVar1 !== 0) {
                throw new \Exception("Failed to generate private key: " . implode("\n", $output1));
            }

            // Step 2: Generate a self-signed certificate in DER format
            // Using -subj to avoid interactive prompts
            $command2 = "openssl req -new -x509 -key " . $privateKeyPath . " -outform der -out " . $certificatePath . " -days 365 -subj '/C=US/ST=State/L=City/O=Organization/OU=Unit/CN=example.com'";
            exec($command2, $output2, $returnVar2);

            if ($returnVar2 !== 0) {
                throw new \Exception("Failed to generate certificate: " . implode("\n", $output2));
            }

            // Create a ZIP file containing both keys
            $zipPath = storage_path('app/keys.zip');
            $zip = new \ZipArchive();

            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \Exception("Cannot create ZIP file.");
            }

            // Add the private and public keys to the ZIP
            $zip->addFile($privateKeyPath, 'private.key');
            $zip->addFile($certificatePath, 'publickey.cer');
            $zip->close();

            unlink($privateKeyPath);
            unlink($certificatePath);

            // Download the ZIP file
            return response()->download($zipPath, 'keys.zip')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::debug("aaaaa", ['exception' => $e->getMessage()]);

            // Clean up files in case of error
            if (file_exists($privateKeyPath)) {
                unlink($privateKeyPath);
            }
            if (file_exists($certificatePath)) {
                unlink($certificatePath);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function genCrt()
    {
        $privateKeyPath = storage_path('app/private.key');
        $certificatePath = storage_path('app/publickey.crt');
        $CSRPath = storage_path('app/keyrequest.csr');

        try {
            // Step 1: Generate a 2048-bit RSA private key
            $command1 = "openssl genrsa -out " . $privateKeyPath . " 2048";
            exec($command1, $output1, $returnVar1);

            if ($returnVar1 !== 0) {
                throw new \Exception("Failed to generate private key: " . implode("\n", $output1));
            }

            // Step 2: Generate a CSR (Certificate Signing Request) 
            // Using -subj to avoid interactive prompts
            $commandGenCSR = "openssl req -new -key " . $privateKeyPath . " -out " . $CSRPath . " -subj '/C=US/ST=State/L=City/O=Organization/OU=Unit/CN=example.com'";
            exec($commandGenCSR, $outputGenCSR, $returnGenCSR);

            if ($returnGenCSR !== 0) {
                throw new \Exception("Failed to generate CSR: " . implode("\n", $outputGenCSR));
            }

            // Step 3: Generate a self-signed certificate
            $command2 = "openssl x509 -req -days 365 -in " . $CSRPath . " -signkey " . $privateKeyPath . " -out " . $certificatePath . "";
            exec($command2, $output2, $returnVar2);

            if ($returnVar2 !== 0) {
                throw new \Exception("Failed to generate certificate: " . implode("\n", $output2));
            }

            // Create a ZIP file containing both keys
            $zipPath = storage_path('app/keys.zip');
            $zip = new \ZipArchive();

            if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
                throw new \Exception("Cannot create ZIP file.");
            }

            // Add the private and public keys to the ZIP
            $zip->addFile($privateKeyPath, 'private.key');
            $zip->addFile($certificatePath, 'publickey.crt');
            $zip->close();

            unlink($privateKeyPath);
            unlink($certificatePath);
            unlink($CSRPath);

            // Download the ZIP file
            return response()->download($zipPath, 'keys.zip')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::debug("aaaaa", ['exception' => $e->getMessage()]);

            // Clean up files in case of error
            if (file_exists($privateKeyPath)) {
                unlink($privateKeyPath);
            }
            if (file_exists($certificatePath)) {
                unlink($certificatePath);
            }
            if (file_exists($CSRPath)) {
                unlink($CSRPath);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function createTeleChannel()
    {
        // Create a Settings object
        $settings = (new \danog\MadelineProto\Settings\AppInfo)
            ->setApiId(29105606)
            ->setApiHash('4a04107845bfe705b8b8d990ab0a7b2d');

        $MadelineProto = new API('madeline.proto', $settings);

        $me = $MadelineProto->getSelf();

        if ($me) {
            return view('app.app-view-function11', ['isLogin' => true]);
        }

        return view('app.app-view-function11', ['isLogin' => false]);
    }

    public function processCreateTeleChannel(Request $request)
    {
        try {
            // Create a Settings object
            $settings = (new \danog\MadelineProto\Settings\AppInfo)
                ->setApiId(29105606)
                ->setApiHash('4a04107845bfe705b8b8d990ab0a7b2d');

            $MadelineProto = new API('madeline.proto', $settings);

            if ($request->code && !$request->channel) {
                $MadelineProto->completePhoneLogin((string)$request->code);

                return response()->json([
                    'code' => 'done',
                ]);
            }

            $me = $MadelineProto->getSelf();

            if ($me) {
                if (!$request->channel) {
                    return response()->json();
                }

                // Create a new channel
                $MadelineProto->channels->createChannel(
                    title: $request->channel,
                );

                return response()->json([
                    'channel' => 'done',
                ]);
            }

            if ($request->phone) {
                $MadelineProto->phoneLogin((string)$request->phone);
            }

            return response()->json([
                'phone' => 'done',
            ]);
        } catch (\Exception $e) {
            Log::error('aa', [$e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function processGetChatId(Request $request)
    {
        $botToken = $request->input('bot_token');
        $res = Http::get('https://api.telegram.org/bot' . $botToken . '/getUpdates');
        if ($res->ok() && $res->json()['ok']) {
            $chatIds = collect($res->json()['result'])
                ->where('my_chat_member.chat.type', 'channel')
                ->pluck('my_chat_member.chat.id', 'my_chat_member.chat.title')
                ->filter()
                ?? [];
        }

        return response()->json(['chat_id' => $chatIds ?? []]);
    }

    public function genSignature()
    {
        return view('app.app-view-function12');
    }

    public function processGenSignature(Request $request)
    {
        try {
            $secretKey = $request->input('key');
            $params = $request->input('data');

            if (empty($secretKey) || empty($params)) {
                return response()->json(['result' => "Input không được để trống"]);
            }

            ksort($params);
            array_walk($params, function (&$item, $key) {
                $item = $key . '=' . $item;
            });
            $signData = implode('&', $params);
            $signature = hash_hmac('sha256', $signData, $secretKey);

            return response()->json(['result' => $signature]);
        } catch (\Exception $e) {
            Log::debug("processGenSignature Exception", ['exception' => $e->getMessage()]);
            return response()->json(['result' => "Lỗi hệ thống"]);
        }
    }

    private function isValidJson($data)
    {
        if (!is_string($data) || empty($data)) {
            return false;
        }

        // Thử decode JSON
        json_decode($data);

        // Kiểm tra lỗi JSON
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function uploadFileCer(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid file'], 400);
        }

        // Lưu file vào storage/app/uploads
        $filename = $file->getClientOriginalName();
        $file->storeAs('uploads', $filename);

        return response()->json(['success' => true, 'filename' => $filename]);
    }

    public function uploadFileCrt(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid file'], 400);
        }

        // Lưu file vào storage/app/uploads
        $filename = $file->getClientOriginalName();
        $file->storeAs('uploads', $filename);

        return response()->json(['success' => true, 'filename' => $filename]);
    }

    public function uploadFileCSV(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid file'], 400);
        }

        // Lưu file vào storage/app/uploads
        $filename = $file->getClientOriginalName();
        $file->storeAs('uploads', $filename);

        return response()->json(['success' => true, 'filename' => $filename]);
    }

    public function uploadFileExcel(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json(['success' => false, 'message' => 'Invalid file'], 400);
        }

        // Lưu file vào storage/app/uploads
        $filename = $file->getClientOriginalName();
        $file->storeAs('uploads', $filename);

        return response()->json(['success' => true, 'filename' => $filename]);
    }

    public function csvToExcel()
    {
        return view('app.app-view-function13');
    }

    public function processCsvToExcel(Request $request)
    {
        $fileName = $request->input('filename');
        if (empty($fileName)) {
            return response()->json(['result' => "Upload file lỗi, file không tồn tại!"]);
        }

        $csvFile = storage_path('app/private/uploads/' . $fileName); // Path to the input file
        $excelFile = storage_path('app/public/excel.xlsx'); // Path to the input file

        try {
            Excel::store(new CsvToExcelExport($csvFile), 'excel.xlsx', 'public');
            unlink($csvFile);
            return response()->download($excelFile, 'excel.xlsx')->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            Log::debug("aaaaa", ['exception' => $th->getMessage()]);

            if (file_exists($csvFile)) {
                unlink($csvFile);
            }
        }
    }

    public function excelToCsv()
    {
        return view('app.app-view-function14');
    }

    public function processExcelToCsv(Request $request)
    {
        $fileName = $request->input('filename');
        if (empty($fileName)) {
            return response()->json(['result' => "Upload file lỗi, file không tồn tại!"]);
        }

        $excelFile = storage_path('app/private/uploads/' . $fileName); // Path to the input file
        $csvFile = storage_path('app/public/csv.csv'); // Path to the input file

        try {
            Excel::store(new ExcelToCsvExport($excelFile), 'csv.csv', 'public');
            unlink($excelFile);
            return response()->download($csvFile, 'csv.csv')->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            Log::debug("aaaaa", ['exception' => $th->getMessage()]);

            if (file_exists($excelFile)) {
                unlink($excelFile);
            }
        }
    }
}
