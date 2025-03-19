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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #72edf2 10%, #d2d2e6 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .button-container {
            width: 400px;
            height: 200px;
            position: relative;
            margin: 20px;
            display: flex; /* Добавляем flex для центрирования */
            justify-content: center; /* Центрируем по горизонтали */
            align-items: center; /* Центрируем по вертикали */
        }

        .button-link {
            display: block;
            width: 65%; /* Занимает всю ширину контейнера */
            height: 100%; /* Занимает всю высоту контейнера */
            text-decoration: none;
            color: transparent;
            background-image: url('img/logo_pain.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 25px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Плавные переходы */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Улучшенная тень */
        }

        .button-link:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3); /* Усиленная тень при наведении */
        }

        /* Мобильная адаптивность */
        @media (max-width: 600px) {
            .button-container {
                width: 90%; /* Занимает 90% ширины экрана */
                height: 150px; /* Уменьшаем высоту */
            }
        }
    </style>
</head>
<body>
<div class="button-container">
    <a href="{{route('detect')}}" class="button-link"></a>
</div>
</body>
</html>
