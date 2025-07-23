<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Измерение зрачка</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .pulsing {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .7;
            }
        }
    </style>
</head>
<body class="bg-slate-900 text-white flex items-center justify-center min-h-screen p-4">

<div class="w-full max-w-2xl mx-auto bg-slate-800 rounded-2xl shadow-2xl p-6 md:p-8 space-y-6">

    <!-- Заголовок -->
    <div class="text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-cyan-400">Анализатор зрачка</h1>
        <p id="instruction" class="text-slate-400 mt-2">Нажмите "Включить камеру", чтобы начать.</p>
    </div>

    <!-- Контейнер для видео и холста -->
    <div id="media-container" class="relative w-full aspect-video bg-slate-900 rounded-xl overflow-hidden shadow-inner">
        <video id="video" playsinline autoplay muted class="w-full h-full object-cover hidden"></video>
        <canvas id="canvas" class="w-full h-full object-cover hidden cursor-crosshair"></canvas>
        <div id="placeholder" class="w-full h-full flex items-center justify-center">
            <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
        </div>
    </div>

    <!-- Контейнер для результатов -->
    <div id="result-container" class="hidden text-center bg-slate-700/50 p-4 rounded-lg">
        <h2 class="text-xl font-semibold text-cyan-400">Результат измерения:</h2>
        <p id="result" class="text-2xl font-bold mt-2">-</p>
        <p class="text-xs text-slate-400 mt-2">Примечание: измерение производится в пикселях. Точность зависит от расстояния до камеры и разрешения.</p>
    </div>

    <!-- Кнопки управления -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <button id="startButton" class="w-full sm:w-auto flex-1 bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 shadow-lg">Включить камеру</button>
        <button id="captureButton" class="w-full sm:w-auto flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 shadow-lg hidden">Сделать фото</button>
        <button id="resetButton" class="w-full sm:w-auto flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 shadow-lg hidden">Сбросить</button>
    </div>
</div>

<script>
    // Получаем доступ к элементам DOM
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');

    const startButton = document.getElementById('startButton');
    const captureButton = document.getElementById('captureButton');
    const resetButton = document.getElementById('resetButton');

    const instruction = document.getElementById('instruction');
    const resultContainer = document.getElementById('result-container');
    const resultText = document.getElementById('result');
    const placeholder = document.getElementById('placeholder');

    let stream;
    let measurementPoints = [];

    // --- Функции управления UI ---

    function showVideo() {
        placeholder.classList.add('hidden');
        video.classList.remove('hidden');
        canvas.classList.add('hidden');
        startButton.classList.add('hidden');
        captureButton.classList.remove('hidden');
        resetButton.classList.remove('hidden');
        resultContainer.classList.add('hidden');
        instruction.textContent = 'Расположите глаз перед камерой и сделайте фото.';
    }

    function showCanvas() {
        video.classList.add('hidden');
        canvas.classList.remove('hidden');
        captureButton.classList.add('hidden');
        instruction.textContent = 'Кликните на левый и правый края зрачка, чтобы измерить его.';
        instruction.classList.add('pulsing');
    }

    function resetState() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        placeholder.classList.remove('hidden');
        video.classList.add('hidden');
        canvas.classList.add('hidden');
        startButton.classList.remove('hidden');
        captureButton.classList.add('hidden');
        resetButton.classList.add('hidden');
        resultContainer.classList.add('hidden');
        instruction.textContent = 'Нажмите "Включить камеру", чтобы начать.';
        instruction.classList.remove('pulsing');
        measurementPoints = [];
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    // --- Основная логика ---

    // 1. Запуск камеры
    startButton.addEventListener('click', async () => {
        try {
            // Запрашиваем доступ к камере
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user', // Предпочтительно фронтальная камера
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            });
            video.srcObject = stream;
            showVideo();
        } catch (err) {
            console.error("Ошибка доступа к камере: ", err);
            instruction.textContent = 'Ошибка: не удалось получить доступ к камере. Проверьте разрешения в браузере.';
        }
    });

    // 2. Создание снимка
    captureButton.addEventListener('click', () => {
        // Устанавливаем размеры холста равными размерам видеопотока
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        // Отрисовываем текущий кадр видео на холсте
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Останавливаем видеопоток
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }

        showCanvas();
    });

    // 3. Измерение на холсте
    canvas.addEventListener('click', (event) => {
        if (measurementPoints.length >= 2) return; // Позволяем измерять только один раз

        // Получаем координаты клика относительно холста
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        const x = (event.clientX - rect.left) * scaleX;
        const y = (event.clientY - rect.top) * scaleY;

        measurementPoints.push({ x, y });

        // Рисуем точку в месте клика
        context.fillStyle = 'cyan';
        context.beginPath();
        context.arc(x, y, 10, 0, 2 * Math.PI); // Увеличим радиус для лучшей видимости
        context.fill();

        if (measurementPoints.length === 2) {
            instruction.classList.remove('pulsing');
            const [p1, p2] = measurementPoints;

            // Рисуем линию между точками
            context.strokeStyle = 'cyan';
            context.lineWidth = 4; // Увеличим толщину линии
            context.beginPath();
            context.moveTo(p1.x, p1.y);
            context.lineTo(p2.x, p2.y);
            context.stroke();

            // Рассчитываем расстояние (дистанцию)
            const distance = Math.sqrt(Math.pow(p2.x - p1.x, 2) + Math.pow(p2.y - p1.y, 2));

            // Отображаем результат
            resultText.textContent = `${distance.toFixed(2)} пикселей`;
            resultContainer.classList.remove('hidden');
            instruction.textContent = 'Измерение завершено. Нажмите "Сбросить" для нового анализа.';
        }
    });

    // 4. Сброс
    resetButton.addEventListener('click', resetState);

    // Инициализация при загрузке
    resetState();
</script>
</body>
</html>
