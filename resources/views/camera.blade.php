<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Открыть камеру</title>
    <style>
        #camera-feed {
            width: 100%;
            max-width: 640px;
            height: auto;
            border: 1px solid black;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Пример открытия камеры</h1>

<button id="open-camera">Открыть камеру</button>

<video id="camera-feed" autoplay playsinline></video>

<script>
    const openCameraButton = document.getElementById('open-camera');
    const cameraFeed = document.getElementById('camera-feed');

    openCameraButton.addEventListener('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            cameraFeed.srcObject = stream;
        } catch (error) {
            console.error('Ошибка доступа к камере:', error);
            alert('Не удалось получить доступ к камере. Проверьте разрешения.');
        }
    });
</script>

</body>
</html>
