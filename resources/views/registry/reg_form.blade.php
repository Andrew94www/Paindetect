<!DOCTYPE html>
<html lang="uk" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація медичного закладу</title>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white">Реєстрація клініки</h2>
        <p class="text-gray-400 mt-1 text-sm">Додавання нової установи в систему</p>
    </div>

    <!-- Форма -->
    <div class="p-8">
        <form action="{{ route('registry.createUser') }}" method="POST" class="space-y-6">
            @csrf


            <!-- Поле: Назва лікарні -->
            <div>
                <label for="hospital_name" class="block text-sm font-medium text-gray-300 mb-1">Назва лікарні</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <input type="text" id="hospital_name" name="hospital_name" required
                           class="block w-full pl-10 pr-3 py-2.5 bg-gray-700 border border-gray-600 text-white rounded-lg placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                           placeholder="Наприклад: Міська лікарня №1">
                </div>
            </div>

            <!-- Поле: Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email адреса</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" required
                           class="block w-full pl-10 pr-3 py-2.5 bg-gray-700 border border-gray-600 text-white rounded-lg placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors"
                           placeholder="admin@hospital.com">
                </div>
            </div>

            <!-- Поле: Пароль -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Пароль</label>
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
                    Зареєструвати лікарню
                </button>
            </div>

        </form>
    </div>

    <!-- Підвал картки -->
    <div class="bg-gray-900/50 px-8 py-4 border-t border-gray-700 text-center">
        <p class="text-sm text-gray-400">
            Виникли проблеми? <a href="#" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">Зверніться до підтримки</a>
        </p>
    </div>
</div>

</body>
</html>
