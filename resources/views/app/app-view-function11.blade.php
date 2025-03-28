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
            width: 100%;
            justify-content: space-evenly;
        }

        .container .sidebar {
            width: 20%;
        }

        .container .sidebar .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .container .sidebar .function {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .box {
            width: 400px;
            height: 500px;
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
            padding: 10px;
        }

        .upload-section label {
            text-align: center;
        }

        .upload-section .form-input label {
            width: 20%;
            display: inline-block;
            text-align: start;
        }

        .upload-section .form-input input {
            width: 50%;
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
            margin: auto;
            margin-top: 10px;
            width: 30%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar"></div>
        <div class="box">
            <h3>Telegram</h3>
            <div class="upload-section">
                <label>Login</label>
                <div class="form-input">
                    <label>Phone</label>
                    <input type="input" id="phoneInput" @if($isLogin) disabled @endif>
                    <span class="isPhone">X</span>
                    <button onclick="createChannel()">Send code</button>
                </div>
                <div class="form-input">
                    <label>Code</label>
                    <input type="input" id="codeInput" @if($isLogin) disabled @endif>
                    <span class="isCode">X</span>
                </div>
                <button id="actionButton" onclick="createChannel()" @if($isLogin) disabled @endif>{{ $isLogin ? "Logged in" : "Login" }}</button>
                <label>Create channel</label>
                <div class="form-input">
                    <label>Channel</label>
                    <input type="input" id="channelInput">
                    <span class="isChannel"></span>
                </div>
                <button id="actionButton" onclick="createChannel()">Create channel</button>
            </div>

            <div class="upload-section">
                <label>Get channel</label>
                <div class="form-input">
                    <label>Bot token</label>
                    <input type="text" id="bot_token">
                </div>
                <p class="chat_id">Channel:</p>
                <button id="actionButton" onclick="getChatId()">Submit</button>
            </div>
        </div>
        <div class="sidebar">
            <p class="title">Guide</p>
            <p class="function">Login</p>
            <ul>
                <li>Input phone</li>
                <li>Click send code</li>
                <li>Code send to telegram</li>
                <br>
                <li>Input code from telegram</li>
                <li>Click login</li>
            </ul>
            <p class="function">Create channel</p>
            <ul>
                <li>Input channel name</li>
                <li>Click channel</li>
            </ul>
            <p class="function">Get channel</p>
            <ul>
                <li>Input bot token</li>
                <li>Click submit</li>
            </ul>

        </div>
    </div>

    <script>
        function createChannel() {
            // Gọi AJAX để xử lý file
            fetch('{{ route("process.data11") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        phone: document.getElementById('phoneInput').value,
                        code: document.getElementById('codeInput').value,
                        channel: document.getElementById('channelInput').value,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.phone) {
                        document.querySelector('.isPhone').innerHTML = data.phone == "done" ? 'O' : 'X';
                    }

                    if (data.code) {
                        document.querySelector('.isCode').innerHTML = data.code == "done" ? 'O' : 'X';
                    }

                    if (data.channel) {
                        document.querySelector('.isChannel').innerHTML = data.channel == "done" ? 'O' : 'X';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred while processing the file.');
                });
        }

        function getChatId() {
            // Gọi AJAX để xử lý file
            fetch('{{ route("process.data15") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        bot_token: document.getElementById('bot_token').value,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    let text = 'Channel: <br>';

                    Object.entries(data.chat_id).forEach(([key, value]) => {
                        text += 'Channel name: ' + key + '<br>' + 'Chat id: ' + value + '<br><br>';
                    });

                    document.querySelector('.chat_id').innerHTML = text;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred while processing the file.');
                });
        }
    </script>
</body>

</html>