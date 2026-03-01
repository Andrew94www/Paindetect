<!DOCTYPE html>
<html lang="uk" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід у систему</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">

<div class="max-w-md w-full bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
    <!-- Декоративна шапка -->
    <div class="bg-gray-900/50 p-6 text-center border-b border-gray-700">
        <div class="w-16 h-16 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white">Вхід у систему</h2>
        <p class="text-gray-400 mt-1 text-sm">Введіть ваші дані для доступу</p>
    </div>

    <!-- Форма -->
    <div class="p-8">
        <form action="{{ route('registry.entranceUser') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Поле: Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email адреса</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" required
                           class="block w-full pl-10 pr-3 py-2.5 bg-gray-700 border border-gray-600 text-white rounded-lg placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                           placeholder="admin@hospital.com">
                </div>
            </div>

            <!-- Поле: Пароль -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-300">Пароль</label>
                    <a href="#" class="text-xs font-medium text-indigo-400 hover:text-indigo-300">Забули пароль?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                           class="block w-full pl-10 pr-3 py-2.5 bg-gray-700 border border-gray-600 text-white rounded-lg placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                           placeholder="••••••••">
                </div>
            </div>

            <!-- Кнопка відправки -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500 transition-colors duration-200">
                    Увійти
                </button>
            </div>

        </form>
    </div>

    <!-- Підвал картки -->
    <div class="bg-gray-900/50 px-8 py-4 border-t border-gray-700 text-center">
        <p class="text-sm text-gray-400">
            Немає аккаунту? <a href="#" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">Створити зараз</a>
        </p>
    </div>
</div>

</body>
</html>
