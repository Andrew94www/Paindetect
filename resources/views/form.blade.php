<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vision</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #72edf2 10%, #d2d2e6 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        canvas {
            border: none;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }

        .button-container {
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #c2d2e3;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #bacee3;
        }

        button:active {
            background-color: #ced7e1;
        }

        @media (max-width: 768px) {
            button {
                width: 100%;
                padding: 15px;
                font-size: 18px;
            }

            canvas {
                max-width: 90%;
            }
        }

        .center-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #upload-button {
            margin-bottom: 20px;
        }
        #custom-file-upload {
            background-color: #4CAF50; /* Зеленый цвет */
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;

        border: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<form id="upload-form" enctype="multipart/form-data">
    <input type="file" id="image-upload" name="image" accept="image/*">
    <button type="submit">Upload</button>
</form>

<script>
    document.getElementById('upload-form').addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData();
        let imageFile = document.getElementById('image-upload').files[0];
        formData.append('image', imageFile);

        fetch('/upload-image', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.redirect) {
                    window.location.href = data.url;
                }
            })
            .catch(error => {
                console.error(error);
                alert('Image upload failed!');
            });
    });
</script>
</body>
</html>
