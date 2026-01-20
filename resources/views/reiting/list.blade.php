<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рейтинг викладачів</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* Slate 900 */
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="text-slate-200 min-h-screen py-8 px-4 sm:px-6">

<div class="max-w-5xl mx-auto">

    <!-- Кнопка Повернутися (Оновлена, більш помітна) -->
    <div class="mb-8">
        <button onclick="window.history.back()" class="group inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 border border-slate-600 hover:border-blue-500/50 rounded-xl transition-all duration-300 shadow-lg hover:shadow-blue-500/10 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Назад до списку
        </button>
    </div>

    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Рейтинг викладачів</h1>
            <p class="text-slate-400 mt-1">Кафедра анатомії людини</p>
        </div>
        <div class="flex items-center gap-3 bg-slate-800/50 p-1 rounded-lg border border-slate-700">
            <span class="px-4 py-2 text-sm font-medium text-blue-400">Всього: <span id="total-count">0</span></span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="glass-card rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="border-b border-slate-700/50 bg-slate-800/30">
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">№</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">ПІБ</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Посада</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400 text-right">Бал</th>
                </tr>
                </thead>
                <tbody id="data-table-body" class="divide-y divide-slate-700/50">
                @isset($reitingsList)
                    @foreach ($reitingsList as $index => $item)
                        <tr class="hover:bg-slate-700/30 transition-colors duration-200 group">
                            <td class="px-6 py-4 text-sm text-slate-500 font-medium">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold mr-3 shadow-lg group-hover:scale-110 transition-transform uppercase">
                                        {{ mb_substr($item->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-white group-hover:text-blue-400 transition-colors">
                                            {{ $item->name ?? 'Невідомо' }}
                                        </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-slate-300 border border-slate-600">
                                        {{ $item->position ?? '-' }}
                                    </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold {{ (isset($item->totalScore) && (int)$item->totalScore > 0) ? 'text-emerald-400' : 'text-slate-500' }}">
                                        {{ number_format($item->totalScore ?? 0, 0, ',', ' ') }}
                                    </span>
                            </td>
                        </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="mt-6 text-center text-slate-500 text-sm">
        Дані оновлено: <span id="current-date"></span>
    </div>
</div>

</body>
</html>
