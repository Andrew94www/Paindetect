<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доступ обмежений | Введіть код</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top left, #1a1a2e, #16213e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #fff;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .custom-input {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            50% { transform: translateX(8px); }
            75% { transform: translateX(-8px); }
        }
    </style>
</head>
<body>

<div class="max-w-md w-full px-6 animate-fade-in">
    <div class="glass-card rounded-3xl p-8 md:p-10">
        <!-- Заголовок -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-600/20 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold mb-2">Потрібен доступ</h1>
            <p class="text-slate-400 text-sm">Введіть код доступу: <span class="text-indigo-400 font-semibold">{{$department->name }}</span></p>
        </div>

        <!-- Форма для Laravel -->
        <form action="{{ route('departments.verify', ['code' => $department->code]) }}" method="POST" id="unlock-form" class="space-y-6">
            @csrf

            <div class="relative">
                <input
                    type="text"
                    name="access_code"
                    id="access_code"
                    placeholder="Введіть ваш код..."
                    class="custom-input w-full px-5 py-4 rounded-xl text-lg font-medium tracking-wide placeholder:text-slate-500 text-white"
                    required
                    autocomplete="off"
                >
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-4 rounded-xl shadow-lg shadow-indigo-600/30 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <span>Розблокувати</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>

        <div class="mt-8 text-center border-t border-white/5 pt-6">
            <a href="{{ route('startPage') }}" class="text-xs text-slate-500 hover:text-slate-300 transition-colors uppercase tracking-widest font-semibold">
                Повернутися на головну
            </a>
        </div>
    </div>

    <!-- Повідомлення про помилку -->
    @if($errors->any())
        <div class="mt-4 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm text-center animate-shake">
            Неправильний код доступу. Будь ласка, перевірте дані та спробуйте ще раз.
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('unlock-form');
        const input = document.getElementById('access_code');

        // Додаємо візуальний ефект при відправці пустої форми
        form.addEventListener('submit', (e) => {
            if (!input.value.trim()) {
                e.preventDefault();
                form.classList.add('animate-shake');
                setTimeout(() => form.classList.remove('animate-shake'), 400);
            }
        });
    });
</script>
</body>
</html>
