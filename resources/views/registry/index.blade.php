<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Національний Реєстр Травм</title>
    <!-- Підключаємо Tailwind CSS для швидкого стилізування -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Підключаємо іконки Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* Темний фон */
        }

        /* Анімація для фонових елементів */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Скло (Glassmorphism) для темної теми */
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="antialiased text-slate-300 bg-slate-900 min-h-screen flex flex-col relative overflow-hidden">

<!-- Фонові декоративні елементи (адаптовано для темного) -->
<div class="absolute top-0 -left-4 w-72 h-72 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-blob"></div>
<div class="absolute top-0 -right-4 w-72 h-72 bg-teal-600 rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-blob animation-delay-2000"></div>
<div class="absolute -bottom-8 left-20 w-72 h-72 bg-sky-600 rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-blob animation-delay-4000"></div>

<!-- Навігація -->
<header class="relative z-10 w-full px-6 py-4 sm:px-10 flex justify-between items-center glass-card border-b-0 shadow-sm">
    <div class="flex items-center gap-3 cursor-pointer">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-teal-400 flex items-center justify-center shadow-lg text-white">
            <i data-lucide="activity" class="w-6 h-6"></i>
        </div>
        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-teal-300">
                Реєстр Травм
            </span>
    </div>

    <div class="hidden md:flex items-center gap-4">
        <!-- В Laravel використовуйте href="{{ route('registry.entrance') }}" -->
        <a href="/registry/entrance" class="text-slate-300 hover:text-white font-medium transition-colors px-4 py-2">
            Вхід
        </a>
        <!-- В Laravel використовуйте href="{{ route('registration.form') }}" -->
        <a href="/registry/registration" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-medium transition-all shadow-md hover:shadow-lg shadow-blue-900/20 flex items-center gap-2">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Створити акаунт
        </a>
    </div>

    <!-- Мобільне меню (кнопка) -->
    <button class="md:hidden text-slate-300 p-2">
        <i data-lucide="menu" class="w-6 h-6"></i>
    </button>
</header>

<!-- Головний екран -->
<main class="flex-grow relative z-10 container mx-auto px-6 sm:px-10 py-12 lg:py-20 flex flex-col lg:flex-row items-center justify-center gap-12 lg:gap-20">

    <!-- Текстова частина -->
    <div class="flex-1 text-center lg:text-left">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-900/30 border border-blue-800/50 text-blue-400 text-sm font-semibold mb-6">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            Захищена система даних
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight text-white">
            Єдина база <br class="hidden lg:block" />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-300">
                    клінічних даних
                </span>
        </h1>

        <p class="text-lg text-slate-400 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
            Надійна платформа для обліку, моніторингу та аналітики травматологічних випадків. Забезпечуємо високий рівень безпеки даних та зручний інтерфейс для медичних фахівців.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
            <!-- Кнопка Реєстрації -->
            <!-- В Laravel: href="{{ route('registration.form') }}" -->
            <a href="/registry/registration" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-500 hover:to-teal-400 text-white rounded-2xl font-semibold text-lg transition-all shadow-lg shadow-blue-900/20 hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                Почати роботу
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            </a>

            <!-- Кнопка Входу -->
            <!-- В Laravel: href="{{ route('registry.entrance') }}" -->
            <a href="/registry/entrance" class="w-full sm:w-auto px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 hover:border-slate-600 rounded-2xl font-semibold text-lg transition-all shadow-sm hover:shadow flex items-center justify-center gap-2">
                <i data-lucide="log-in" class="w-5 h-5"></i>
                Увійти в систему
            </a>
        </div>

        <!-- Переваги під кнопками -->
        <div class="mt-12 flex items-center justify-center lg:justify-start gap-8 text-sm font-medium text-slate-400">
            <div class="flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-teal-400"></i>
                Надійний захист
            </div>
            <div class="flex items-center gap-2">
                <i data-lucide="database" class="w-5 h-5 text-blue-400"></i>
                Хмарне збереження
            </div>
        </div>
    </div>

    <!-- Візуальна частина (Графіка) -->
    <div class="flex-1 w-full max-w-lg lg:max-w-none relative">
        <div class="relative w-full aspect-square md:aspect-auto md:h-[500px] flex items-center justify-center">

            <!-- Центральна велика картка -->
            <div class="absolute z-20 w-3/4 bg-slate-800 p-6 rounded-3xl shadow-2xl border border-slate-700 transform transition-transform hover:scale-105 duration-500">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-white">Статистика травматизму</h3>
                    <div class="p-2 bg-slate-700 rounded-lg text-blue-400">
                        <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                    </div>
                </div>

                <!-- Імітація графіку -->
                <div class="flex items-end gap-3 h-32 mb-4">
                    <div class="flex-1 bg-slate-700 rounded-t-md h-1/3 relative"><div class="absolute inset-x-0 bottom-0 bg-blue-500 rounded-t-md h-full w-full opacity-50"></div></div>
                    <div class="flex-1 bg-slate-700 rounded-t-md h-2/3 relative"><div class="absolute inset-x-0 bottom-0 bg-blue-500 rounded-t-md h-full w-full opacity-75"></div></div>
                    <div class="flex-1 bg-slate-700 rounded-t-md h-1/2 relative"><div class="absolute inset-x-0 bottom-0 bg-teal-400 rounded-t-md h-full w-full opacity-60"></div></div>
                    <div class="flex-1 bg-slate-700 rounded-t-md h-full relative"><div class="absolute inset-x-0 bottom-0 bg-blue-500 rounded-t-md h-full w-full"></div></div>
                    <div class="flex-1 bg-slate-700 rounded-t-md h-3/4 relative"><div class="absolute inset-x-0 bottom-0 bg-teal-400 rounded-t-md h-full w-full"></div></div>
                </div>
                <div class="flex justify-between text-xs text-slate-400 font-medium">
                    <span>Пн</span><span>Вв</span><span>Ср</span><span>Чт</span><span>Пт</span>
                </div>
            </div>
            

        </div>
    </div>

</main>

<!-- Ініціалізація іконок -->
<script>
    lucide.createIcons();
</script>
</body>
</html>
