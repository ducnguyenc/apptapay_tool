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
        }
        .box {
            width: 300px;
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
        #actionButton {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="box">
        <h3>Login</h3>
        <div class="upload-section">
            <label>Phone</label>
            <input type="input" id="nameInput">
            <button id="actionButton" onclick="createChannel()">Send code</button>
        </div>
    </div>
</div>

<script>
    function createChannel() {
        // Gọi AJAX để xử lý file
        fetch('{{ route("process.data15") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ name: document.getElementById('nameInput').value })
        })
            .then(response => response.json())
            .then(data => {
                document.getElementById('resultData').value = data.result;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error occurred while processing the file.');
            });
    }
</script>
</body>
</html>
