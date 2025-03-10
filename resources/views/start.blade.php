<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .button-link {
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 15px 30px;
            margin: 10px;
            border-radius: 25px;
            font-size: 38px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px; /* Фиксированная ширина */
            text-align: center; /* Центрирование текста */
            display: inline-block; /* Чтобы размер зависел только от стилей */
        }

        .button-link:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<a href="{{route('detect')}}" class="button-link">Rapid Pain</a>
{{--<a href="{{route('indexPatient')}}" class="button-link">Pain Mechanism</a>--}}
</body>
</html>
