<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Презентация логотипа</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    
    <style>
        /* Базовые стили и сброс */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #312e81, #1e3a8a);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            overflow: hidden;
            color: #ffffff;
        }

        /* Анимация фона */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Контейнер-карточка (Glassmorphism) */
        .card-container {
            perspective: 1000px;
            padding: 20px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 60px 80px;
            text-align: center;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4), 
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: transform 0.1s ease-out;
            transform-style: preserve-3d;
            max-width: 500px;
            width: 100%;
        }

        /* Обертка для логотипа с анимацией парения */
        .logo-wrapper {
            margin-bottom: 30px;
            animation: float 6s ease-in-out infinite;
            transform: translateZ(50px); /* 3D эффект при наклоне карточки */
            display: flex;
            justify-content: center;
        }

        @keyframes float {
            0% { transform: translateY(0px) translateZ(50px); }
            50% { transform: translateY(-15px) translateZ(50px); }
            100% { transform: translateY(0px) translateZ(50px); }
        }

        /* Стили для текста */
        .brand-name {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transform: translateZ(30px);
        }

        .brand-slogan {
            font-size: 1rem;
            font-weight: 300;
            color: #94a3b8;
            letter-spacing: 1px;
            transform: translateZ(20px);
        }

        /* Стили для вставленного изображения */
        .header-image {
            max-width: 100%;
            height: auto;
            border-radius: 12px; /* Добавляем скругление, чтобы соответствовать стилю */
        }

        /* Свечение позади логотипа */
        .glow {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(99, 102, 241, 0.4);
            border-radius: 50%;
            filter: blur(60px);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        /* Адаптивность для мобильных устройств */
        @media (max-width: 600px) {
            .glass-card {
                padding: 40px 30px;
            }
            .brand-name {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="card-container">
        <div class="glass-card" id="tilt-card">
            <div class="glow"></div>
            
            <div class="logo-wrapper">
                <!-- Вставленное изображение -->
              <img src="{{ asset('img/logotip.png') }}" width="400px" alt="UF Logo">
            </div>
            
            <h1 class="brand-name">PAINDETECT</h1>
            <p class="brand-slogan">Іновації в кожному пікселі</p>
        </div>
    </div>

    <script>
        // JS для эффекта 3D наклона карточки при движении мыши
        const card = document.getElementById('tilt-card');
        const container = document.querySelector('.card-container');

        // Отслеживаем движение мыши внутри контейнера
        container.addEventListener('mousemove', (e) => {
            // Получаем координаты мыши относительно контейнера
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            // Вычисляем центр карточки
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            // Вычисляем угол наклона (делитель определяет силу эффекта)
            const rotateX = ((y - centerY) / 15) * -1;
            const rotateY = (x - centerX) / 15;

            // Применяем трансформацию
            card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        // Сбрасываем наклон, когда мышь покидает карточку
        container.addEventListener('mouseleave', () => {
            card.style.transform = 'rotateX(0deg) rotateY(0deg)';
            card.style.transition = 'transform 0.5s ease-out'; // Плавный возврат
        });

        // Убираем плавный переход при активном движении (чтобы не было задержки)
        container.addEventListener('mouseenter', () => {
            card.style.transition = 'none';
        });
    </script>
</body>
</html>