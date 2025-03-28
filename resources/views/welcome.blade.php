<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Hide the default file input */
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
    </style>
</head>
<body>

    <!-- Container for the custom file upload button and file name -->
    <div class="file-upload-wrapper">
        <!-- Hidden file input -->
        <input type="file" id="fileInput" onchange="displayFileName()" />

        <!-- Custom file upload button -->
        <label for="fileInput" class="custom-file-upload">
            Choose File
        </label>

        <!-- Display the selected file name -->
        <span class="file-name" id="fileName">No file chosen</span>
    </div>

    <script>
        // Display the selected file name when a file is chosen
        function displayFileName() {
            const fileInput = document.getElementById('fileInput');
            const fileNameDisplay = document.getElementById('fileName');
            const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
            fileNameDisplay.textContent = fileName;
        }
    </script>
</body>
</html>