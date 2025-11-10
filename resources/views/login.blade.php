<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back!</title>
    <!-- Tailwind CSS CDN inclusion -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Базовый темный фон */
            background-color: #111827; /* gray-900 */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1.5rem;
            box-sizing: border-box;
        }

        /* Контейнер, который разделяет экран */
        .split-container {
            display: grid;
            grid-template-columns: 1fr; /* Одна колонка по умолчанию (мобильные) */
            width: 100%;
            max-width: 64rem; /* 1024px */
            background-color: #1f2937; /* gray-800 */
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            overflow: hidden; /* Важно для скругленных углов */
            border: 1px solid #374151; /* gray-700 */
        }

        /* На средних экранах и больше - две колонки */
        @media (min-width: 768px) {
            .split-container {
                grid-template-columns: 1fr 1fr; /* Две равные колонки */
            }
        }

        /* Левая часть (Форма) */
        .form-section {
            padding: 3rem 2.5rem; /* Больше отступов */
        }
        @media (min-width: 768px) {
            .form-section {
                padding: 4rem;
            }
        }

        /* Правая часть (Брендинг) */
        .branding-section {
            /* Скрываем на мобильных */
            display: none;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); /* Яркий градиент */
            padding: 4rem;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        @media (min-width: 768px) {
            .branding-section {
                display: flex; /* Показываем на десктопе */
            }
        }

        /* Стили для полей ввода */
        .form-input {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border-radius: 0.5rem; /* Стандартные скругления */
            background-color: #374151; /* gray-700 */
            border: 1px solid #4b5563; /* gray-600 */
            color: #ffffff;
            transition: all 0.2s ease-in-out;
        }
        .form-input::placeholder {
            color: #9ca3af; /* gray-400 */
        }
        .form-input:focus {
            outline: none;
            border-color: #6366f1; /* indigo-500 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.4); /* Кольцо фокуса */
            background-color: #374151;
        }

        /* Стили для кнопки */
        .btn-primary {
            background-color: #6366f1; /* indigo-500 */
            color: #ffffff;
            padding: 0.875rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600; /* semibold */
            transition: all 0.2s ease-in-out;
            width: 100%; /* Кнопка на всю ширину */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .btn-primary:hover {
            background-color: #4f46e5; /* indigo-600 */
            transform: translateY(-1px);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        /* Стили для ссылок */
        .link-text {
            color: #818cf8; /* indigo-400 */
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }
        .link-text:hover {
            color: #a5b4fc; /* indigo-300 */
            text-decoration: underline;
        }

        /* Сообщение об ошибке */
        .error-message {
            color: #f87171; /* red-400 */
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="split-container">

    <!-- Левая часть: Форма -->
    <div class="form-section">
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-white">Welcome Back!</h2>
            <p class="text-gray-400 mt-2">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <label for="email" class="block text-gray-300 text-sm font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-300 text-sm font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password">
                @error('password')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-500 focus:ring-indigo-400 border-gray-600 rounded bg-gray-700">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-300">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="text-sm link-text" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <div class="mb-6">
                <button type="submit" class="btn-primary">
                    Login
                </button>
            </div>
        </form>

        <p class="text-center text-gray-400 text-sm">
            Don't have an account? <a href="{{ route('register') }}" class="link-text">Register here</a>
        </p>

        <!-- Баннер поддержки -->
        <a href="https://novaukraine.org/" target="_blank" rel="noopener noreferrer" class="group mt-8 flex flex-col items-center text-center px-4">
            <p class="text-sm text-gray-500 font-medium mb-2">
                За підтримки
            </p>
            <img src="img/novaukr.png" alt="Nova Ukraine Logo" class="h-10 opacity-70 group-hover:opacity-100 transition-opacity duration-200">
        </a>
    </div>

    <!-- Правая часть: Брендинг -->
    <div class="branding-section">
        <div>
            <svg class="mx-auto h-20 w-20 text-white mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            <h2 class="text-4xl font-extrabold text-white">Join Our Community</h2>
            <p class="text-indigo-200 mt-4 text-lg max-w-xs mx-auto">
                Access your account and connect with us.
            </p>
        </div>
    </div>

</div>

</body>
</html>
