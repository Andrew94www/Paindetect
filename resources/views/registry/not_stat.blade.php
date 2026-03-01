<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Недостатньо даних</title>
    <!-- Підключення Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Підключення Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Додаткові стилі для плавного темного фону */
        body {
            background-image: radial-gradient(circle at top right, #1e293b 0%, #0f172a 100%);
            background-attachment: fixed;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 antialiased selection:bg-indigo-500/30 selection:text-indigo-200">

<!-- Головна картка -->
<div class="max-w-md w-full bg-slate-800/80 backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-black/50 p-8 sm:p-10 text-center border border-slate-700/50 relative overflow-hidden">

    <!-- Декоративний елемент (блік) на фоні картки -->
    <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-600 rounded-full blur-3xl opacity-20 pointer-events-none"></div>

    <!-- Контейнер для ілюстрації з анімацією плавання -->
    <div class="relative w-48 h-48 mx-auto mb-8 animate-float">

        <!-- Фоновий круг ілюстрації -->
        <div class="absolute inset-0 bg-gradient-to-tr from-slate-700 to-slate-800 rounded-full shadow-inner border border-slate-600"></div>

        <!-- Пульсуючі елементи (символізують очікування даних) -->
        <div class="absolute top-4 right-6 w-3 h-3 bg-indigo-500 rounded-full animate-pulse-slow"></div>
        <div class="absolute bottom-8 left-4 w-4 h-4 bg-blue-500 rounded-full animate-pulse-slow" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 -right-2 w-2 h-2 bg-indigo-400 rounded-full animate-pulse-slow" style="animation-delay: 2s;"></div>

        <!-- Центральна ілюстрація (Графік без даних / Лупа) -->
        <div class="absolute inset-0 flex items-center justify-center text-indigo-400">
            <svg class="w-24 h-24 drop-shadow-md" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Основа графіка -->
                <path d="M3 20H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 4V20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>

                <!-- Порожні / пунктирні колонки -->
                <rect x="7" y="14" width="3" height="6" rx="1" stroke="currentColor" stroke-width="2" stroke-dasharray="2 2" fill="transparent"/>
                <rect x="13" y="10" width="3" height="10" rx="1" stroke="currentColor" stroke-width="2" stroke-dasharray="2 2" fill="transparent"/>

                <!-- Знак питання / пошуку -->
                <circle cx="15" cy="7" r="4" stroke="#818cf8" stroke-width="2"/>
                <path d="M18 10L20.5 12.5" stroke="#818cf8" stroke-width="2" stroke-linecap="round"/>
                <path d="M15 5.5C15 5.5 16 5.5 16.5 6" stroke="#818cf8" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>
    </div>

    <!-- Текстова частина -->
    <h1 class="text-2xl sm:text-3xl font-bold text-slate-100 mb-4 tracking-tight leading-tight">
        Недостатньо даних <br/> <span class="text-indigo-400">для статистики</span>
    </h1>

    <p class="text-slate-400 mb-8 leading-relaxed text-sm sm:text-base px-2">
        Ми ще не зібрали достатньо інформації для відображення аналітики. Спробуйте змінити період або поверніться сюди трохи пізніше.
    </p>

    <!-- Кнопки дій -->
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button onclick="window.history.back()" class="px-8 py-3 bg-slate-700 border border-slate-600 hover:border-slate-500 text-slate-200 font-medium rounded-xl transition-all duration-200 flex items-center justify-center gap-2 hover:bg-slate-600 shadow-lg shadow-black/20 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Назад
        </button>
    </div>

</div>

</body>
</html>
