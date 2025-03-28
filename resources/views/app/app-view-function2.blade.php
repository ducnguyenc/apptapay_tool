<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Input and Result</title>
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
            justify-content: space-around;
        }

        .box {
            width: 100%;
            height: 100vh;
            border: 1px solid #ccc;
            background-color: white;
            display: flex;
            flex-direction: column;
        }

        .box h3 {
            margin: 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ccc;
            text-align: center;
        }

        .box textarea {
            flex: 1;
            margin: 10px;
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
        <div class="box">
            <h3>Input</h3>
            <textarea id="inputData" placeholder="Enter your input here..."></textarea>
        </div>
        <div class="action">
            <button onclick="processData()">Action</button>
        </div>
        <div class="box">
            <h3>Result</h3>
            <textarea id="resultData" readonly placeholder="Result will appear here..."></textarea>
        </div>
    </div>

    <script>
        function processData() {
            // Lấy dữ liệu từ ô Input
            const inputData = document.getElementById('inputData').value;

            // Lấy CSRF token từ meta tag
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Gọi AJAX
            fetch('{{ route("process.data2") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        input: inputData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Hiển thị kết quả vào ô Result
                    document.getElementById('resultData').value = data.result;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('resultData').value = 'Có lỗi xảy ra trong quá trình xử lý';
                });
        }
    </script>
</body>

</html>