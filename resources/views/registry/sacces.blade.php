<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація завершена</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#020617] text-slate-200 flex items-center justify-center min-h-screen p-4 overflow-hidden">

<!-- Декоративні елементи фону (світіння) -->
<div class="fixed top-0 left-0 w-full h-full -z-10 pointer-events-none">
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-indigo-500/10 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-blue-500/10 rounded-full blur-[120px]"></div>
</div>

<div class="max-w-md w-full bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-3xl shadow-2xl p-8 text-center transition-all transform hover:scale-[1.01]">

    <!-- Контейнер іконки з пульсацією -->
    <div class="relative mx-auto mb-8">
        <div class="absolute inset-0 bg-emerald-500/20 rounded-full blur-xl animate-pulse"></div>
        <div class="relative mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-emerald-500/10 border border-emerald-500/20">
            <svg class="h-10 w-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
    </div>

    <!-- Заголовок -->
    <h2 class="text-3xl font-bold text-white mb-3 tracking-tight">
        Вітаємо!
    </h2>

    <!-- Опис -->
    <p class="text-slate-400 mb-10 leading-relaxed">
        Ваш акаунт успішно створено. <br>
        Тепер ви можете увійти в систему та почати роботу.
    </p>

    <!-- Посилання замість форми -->
    <a href="{{ route('registry.entrance') }}"
       class="group relative flex items-center justify-center w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_30px_rgba(79,70,229,0.5)] active:scale-[0.98]">
        <span class="relative z-10">Увійти в акаунт</span>
        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-transparent via-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
    </a>

    <!-- Додаткове посилання -->
    <div class="mt-8">
        <a href="{{ route('registration.index') }}" class="text-sm text-slate-500 hover:text-indigo-400 transition-colors duration-300 flex items-center justify-center gap-2 group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Повернутися на головну
        </a>
    </div>
</div>

</body>
</html>

