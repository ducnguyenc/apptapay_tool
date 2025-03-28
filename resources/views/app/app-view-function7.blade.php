<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>File Upload and Process</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            gap: 20px;
            width: 50%;
        }
        .box {
            width: 100%;
            height: 300px;
            border: 1px solid #ccc;
            background-color: white;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }
        .box h3 {
            margin: 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }
        .upload-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .upload-section input[type="file"] {
            margin-bottom: 20px;
        }
        .action {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .action button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .action button:hover {
            background-color: #0056b3;
        }
        .action button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        input[type="file"] {
            display: none;
        }

        /* Custom style for the file input container */
        .file-upload-wrapper {
            display: flex;
            align-items: center;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            border-radius: 0.25rem;
            cursor: pointer;
            text-align: center;
        }

        /* Hover effect similar to Bootstrap button */
        .custom-file-upload:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Style for displaying the file name */
        .file-name {
            margin-left: 10px;
            font-size: 1rem;
            color: #333;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .upload-section .form-input {
            border: 1px solid #ccc;
            width: 50%;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="box">
        <h3>Input</h3>
        <div class="upload-section">
            <div class="form-input">
                <input type="file" id="fileInput" onchange="handleFileUpload()">
                <label for="fileInput" class="custom-file-upload">
                    Choose File
                </label>
                <span class="file-name" id="fileName">No file chosen</span>
            </div>
            <button id="actionButton" onclick="processFile()" disabled>Convert</button>
        </div>
    </div>
</div>

<script>
    let uploadedFileName = null;

    function handleFileUpload() {
        const fileInput = document.getElementById('fileInput');
        const actionButton = document.getElementById('actionButton');

        const fileNameDisplay = document.getElementById('fileName');
        const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
        fileNameDisplay.textContent = fileName;

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const formData = new FormData();
            formData.append('file', file);

            // Gọi AJAX để upload file
            fetch('{{ route("upload.file_crt") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        uploadedFileName = data.filename;
                        actionButton.disabled = false; // Kích hoạt nút Action
                    } else {
                        alert('File upload failed: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred while uploading the file.');
                });
        }
    }

    function processFile() {
        if (!uploadedFileName) {
            alert('Please upload a file first.');
            return;
        }

        // Gọi AJAX để xử lý file
        fetch('{{ route("process.data7") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ filename: uploadedFileName })
        })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'publickey.pem'; // Set the downloaded file name
                a.click(); // Simulate a click to download the file
                window.URL.revokeObjectURL(url);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error occurred while processing the file.');
            });
    }
</script>
</body>
</html>
