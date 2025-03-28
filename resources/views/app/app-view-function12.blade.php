<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Key-Value Processing</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            gap: 20px;
            width: 100%;
        }
        .key-value-section {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }
        .input-box {
            height: auto;
            width: 60%;
        }
        .box {
            border: 1px solid #ccc;
            background-color: white;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }
        .result-box {
            height: auto;
            width: 30%;
        }
        .box h3, .box h4 {
            margin: 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }
        .key-section {
            height: 60px;
        }

        .key-value-section div {
            display: flex;
            flex-direction: column;
        }
        .key-value-section label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .key-value-section textarea, .box textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            resize: none;
            font-size: 16px;
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
    </style>
</head>
<body>
<div class="container">
    <div class="box input-box">
        <h3>Input</h3>
        <div class="key-section" style="display: flex; justify-content: space-between; flex-direction: row">
            <h4>Secret Key</h4>
            <textarea id="keyData" placeholder="Enter your secret key here..."></textarea>
        </div>
        <br>
        <div class="key-value-section">
            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>

            <div style="display: flex; justify-content: space-between; flex-direction: row">
                <div style="width: 200px">
                    <label>Key</label>
                    <input style="height:50px;" id="key1" placeholder="Enter key...">
                </div>
                <div style="flex: 1;padding-left: 15px">
                    <label>Value</label>
                    <input style="height:50px;" id="value1" placeholder="Enter value...">
                </div>
            </div>
            <br>
        </div>
    </div>
    <div class="action">
        <button onclick="processData()">Action</button>
    </div>
    <div class="box result-box">
        <h3>Result</h3>
        <textarea id="resultData" readonly placeholder="Result will appear here..."></textarea>
    </div>
</div>

<script>
    function processData() {
        // Lấy dữ liệu từ các ô input
        const keyData = document.getElementById('keyData').value;
        const key1 = document.getElementById('key1').value;
        const value1 = document.getElementById('value1').value;
        const key2 = document.getElementById('key2').value;
        const value2 = document.getElementById('value2').value;

        // Tạo mảng key-value theo định dạng yêu cầu
        const keyValueData = {};
        if (key1 && value1) {
            keyValueData[key1] = value1;
        }
        if (key2 && value2) {
            keyValueData[key2] = value2;
        }

        // Lấy CSRF token từ meta tag
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Gọi AJAX
        fetch('{{ route("process.data12") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ key: keyData, data: keyValueData })
        })
            .then(response => response.json())
            .then(data => {
                // Hiển thị kết quả vào ô Result
                document.getElementById('resultData').value = data.result;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('resultData').value = 'Error occurred while processing.';
            });
    }
</script>
</body>
</html>
