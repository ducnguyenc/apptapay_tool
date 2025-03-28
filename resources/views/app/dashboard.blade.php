<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .button-container {
            display: flex;
            justify-content: space-evenly;
            gap: 10px;
        }

        .row {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        button {
            width: 300px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: 1px solid #000;
            background-color: #fff;
            border-radius: 5px;
        }

        button:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="button-container">
                        <div class="row">
                            <a href="{{ route('appotapay1') }}">
                                <button>Base64 decode</button>
                            </a>
                            <a href="{{ route('appotapay2') }}">
                                <button>Base64 encode</button>
                            </a>
                            {{-- <a href="{{ route('appotapay3') }}">--}}
                            {{-- <button>Convert Array to Json</button>--}}
                            {{-- </a>--}}
                            {{-- <a href="{{ route('appotapay4') }}">--}}
                            {{-- <button>Convert Json to array</button>--}}
                            {{-- </a>--}}
                            <a href="{{ route('appotapay5') }}">
                                <button>Json Format</button>
                            </a>
                            <a href="{{ route('appotapay6') }}" onclick="return confirmDownload()">
                                <button>Gen cặp RSA KEY (.pem)</button>
                            </a>
                            <a href="{{ route('appotapay7') }}">
                                <button>Convert .crt to pem</button>
                            </a>
                            <a href="{{ route('appotapay8') }}">
                                <button>Convert .cer to pem</button>
                            </a>
                        </div>
                        <div class="row">
                            <a href="{{ route('appotapay9') }}" onclick="return confirmDownload()">
                                <button>Gen file .cer</button>
                            </a>
                            <a href="{{ route('appotapay10') }}" onclick="return confirmDownload()">
                                <button>Gen file .crt</button>
                            </a>
                            <a href="{{ route('appotapay11') }}">
                                <button>Create Tele Channel</button>
                            </a>
                            <a href="{{ route('appotapay12') }}">
                                <button>Gen signature</button>
                            </a>
                            <a href="{{ route('appotapay13') }}">
                                <button>CSV to Excel</button>
                            </a>
                            <a href="{{ route('appotapay14') }}">
                                <button>Excel to CSV</button>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>

<script>
    function confirmDownload() {
        // Show a confirmation dialog
        return confirm("Bạn có chắc chắn muốn tải xuống không?");
    }
</script>