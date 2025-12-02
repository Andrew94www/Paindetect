<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-PAT Kids — Dark Mode (Vanilla JS)</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: { bg: '#0f172a', card: '#1e293b', border: '#334155', text: '#f1f5f9' }
                    },
                    fontFamily: { sans: ['Nunito', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
        }

        /* Анимации */
        .fade-in { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Эффекты для кнопок-лиц */
        .face-btn { transition: all 0.2s; }
        .face-btn:hover { transform: translateY(-3px); }
        .face-btn.active {
            transform: scale(1.1);
            background-color: rgba(245, 158, 11, 0.2); /* amber */
            border-color: #f59e0b;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.3);
        }

        /* Стили для карты тела */
        .body-part {
            fill: #334155; /* slate-700 */
            stroke: #475569; /* slate-600 */
            stroke-width: 2;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .body-part:hover { fill: #475569; }
        .body-part.active {
            fill: #f43f5e; /* rose-500 */
            stroke: #e11d48;
            filter: drop-shadow(0 0 8px rgba(244, 63, 94, 0.6));
        }

        /* Кастомный ползунок (Slider) */
        input[type=range] {
            -webkit-appearance: none;
            background: transparent;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #3b82f6;
            cursor: pointer;
            margin-top: -8px;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            cursor: pointer;
            background: #334155;
            border-radius: 2px;
        }

        /* Скрытие табов */
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .nav-btn.active {
            background-color: #2563eb; /* blue-600 */
            color: white;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.4);
            transform: translateX(5px);
        }

        /* Круговой прогресс */
        .progress-ring__circle {
            transition: stroke-dashoffset 0.5s ease-in-out;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        @media print {
            body { background: white; color: black; }
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            .card { border: 1px solid #ddd; background: white !important; color: black !important; }
        }
    </style>
</head>
<body>

<!-- Header -->
<header className="bg-slate-800/80 backdrop-blur-md border-b border-slate-700 sticky top-0 z-20">
    <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="bg-blue-600 p-2 rounded-lg shadow-lg shadow-blue-500/30">
                <i data-lucide="activity" class="text-white"></i>
            </div>
            <div>
                <h1 class="text-xl font-black tracking-tight text-white">R-PAT <span class="text-blue-400">Kids</span></h1>
                <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">Dark Medical Edition</p>
            </div>
        </div>

        <div id="header-risk-badge" class="hidden md:flex items-center gap-3 px-4 py-1.5 rounded-full border bg-emerald-500/10 border-emerald-500/20">
            <div class="text-xs font-bold text-slate-300 uppercase">Индекс риска</div>
            <div id="header-risk-val" class="text-lg font-black text-emerald-400">0%</div>
        </div>
    </div>
</header>

<main class="max-w-5xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-12 gap-8">

    <!-- Sidebar Navigation -->
    <div class="hidden md:block col-span-3">
        <div class="sticky top-24 space-y-2">
            <button onclick="switchTab(0)" class="nav-btn active w-full flex items-center gap-3 px-4 py-4 rounded-xl transition-all duration-300 font-bold text-sm text-slate-400 hover:bg-slate-800 hover:text-white" id="nav-0">
                <i data-lucide="baby"></i> FLACC
            </button>
            <button onclick="switchTab(1)" class="nav-btn w-full flex items-center gap-3 px-4 py-4 rounded-xl transition-all duration-300 font-bold text-sm text-slate-400 hover:bg-slate-800 hover:text-white" id="nav-1">
                <i data-lucide="smile"></i> Оценка
            </button>
            <button onclick="switchTab(2)" class="nav-btn w-full flex items-center gap-3 px-4 py-4 rounded-xl transition-all duration-300 font-bold text-sm text-slate-400 hover:bg-slate-800 hover:text-white" id="nav-2">
                <i data-lucide="moon"></i> Психо
            </button>
            <button onclick="switchTab(3)" class="nav-btn w-full flex items-center gap-3 px-4 py-4 rounded-xl transition-all duration-300 font-bold text-sm text-slate-400 hover:bg-slate-800 hover:text-white" id="nav-3">
                <i data-lucide="brain"></i> Когнитив
            </button>
            <button onclick="switchTab(4)" class="nav-btn w-full flex items-center gap-3 px-4 py-4 rounded-xl transition-all duration-300 font-bold text-sm text-slate-400 hover:bg-slate-800 hover:text-white" id="nav-4">
                <i data-lucide="eye"></i> Заметки
            </button>

            <!-- Sidebar Status Widget -->
            <div class="mt-8 pt-8 border-t border-slate-800">
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-5 border border-slate-700 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-500"></div>
                    <h4 class="text-slate-400 text-xs uppercase font-bold mb-4">Текущий статус</h4>
                    <div class="flex justify-center mb-2">
                        <!-- SVG Circle Mini -->
                        <svg class="w-24 h-24" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#1e293b" stroke-width="8" />
                            <circle id="mini-progress" class="progress-ring__circle" cx="50" cy="50" r="45" fill="none" stroke="#10b981" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="283" />
                            <text id="mini-val" x="50" y="55" text-anchor="middle" fill="white" font-size="20" font-weight="bold">0</text>
                        </svg>
                    </div>
                    <div id="mini-label" class="text-sm font-bold text-emerald-400 mt-2 py-1 px-3 bg-slate-950/30 rounded-full inline-block">Низкий</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="col-span-1 md:col-span-9 space-y-6 min-h-[500px]">

        <!-- MODULE 1: FLACC -->
        <div id="tab-content-0" class="tab-content active fade-in">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 mb-6">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-700">
                    <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg"><i data-lucide="baby"></i></div>
                    <h3 class="text-xl font-bold text-slate-100">Модуль 1: Выражение боли</h3>
                    <div class="ml-auto text-2xl font-mono font-bold text-blue-400"><span id="flacc-total-display">0</span><span class="text-slate-600 text-sm">/10</span></div>
                </div>

                <div id="flacc-container" class="space-y-4">
                    <!-- FLACC Categories generated by JS -->
                </div>
            </div>
        </div>

        <!-- MODULE 2: SELF REPORT -->
        <div id="tab-content-1" class="tab-content fade-in">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 mb-6">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-700">
                    <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg"><i data-lucide="smile"></i></div>
                    <h3 class="text-xl font-bold text-slate-100">Модуль 2: Самооценка</h3>
                </div>

                <div class="mb-8">
                    <div class="flex justify-between mb-4">
                        <h4 class="font-bold text-slate-300">Уровень боли</h4>
                        <span id="pain-level-display" class="text-amber-400 font-bold">0/10</span>
                    </div>
                    <div id="faces-container" class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                        <!-- Generated by JS -->
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8 border-t border-slate-700 pt-8">
                    <div>
                        <h4 class="font-bold text-slate-300 mb-4">Локализация (Нажмите на тело)</h4>
                        <div class="flex flex-col items-center">
                            <div class="relative">
                                <svg viewBox="0 0 260 320" class="w-64 h-80 drop-shadow-2xl">
                                    <!-- Glow BG -->
                                    <foreignObject width="100%" height="100%">
                                        <div class="w-full h-full bg-blue-500/5 blur-3xl rounded-full -z-10 absolute"></div>
                                    </foreignObject>
                                    <path id="part-head" d="M100,50 Q100,20 130,20 T160,50 Q160,80 130,80 T100,50" class="body-part" onclick="toggleBodyPart('head')"></path>
                                    <path id="part-chest" d="M100,90 L160,90 L170,160 L90,160 Z" class="body-part" onclick="toggleBodyPart('chest')"></path>
                                    <path id="part-stomach" d="M90,160 L170,160 L160,210 L100,210 Z" class="body-part" onclick="toggleBodyPart('stomach')"></path>
                                    <path id="part-l_arm" d="M90,90 L60,150 L80,160 L100,100 Z" class="body-part" onclick="toggleBodyPart('l_arm')"></path>
                                    <path id="part-r_arm" d="M170,90 L200,150 L180,160 L160,100 Z" class="body-part" onclick="toggleBodyPart('r_arm')"></path>
                                    <path id="part-l_leg" d="M100,210 L90,300 L120,300 L125,210 Z" class="body-part" onclick="toggleBodyPart('l_leg')"></path>
                                    <path id="part-r_leg" d="M160,210 L170,300 L140,300 L135,210 Z" class="body-part" onclick="toggleBodyPart('r_leg')"></path>
                                </svg>
                            </div>
                            <div id="selected-parts-list" class="flex flex-wrap gap-2 mt-6 justify-center min-h-[40px] text-xs text-slate-500 italic">
                                Ничего не выбрано
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-300 mb-4">Характер боли</h4>
                        <div id="pain-types-container" class="flex flex-wrap gap-2">
                            <!-- JS Generated -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODULE 3: PSYCHO -->
        <div id="tab-content-2" class="tab-content fade-in">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 mb-6">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-700">
                    <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg"><i data-lucide="moon"></i></div>
                    <h3 class="text-xl font-bold text-slate-100">Модуль 3: Психофизиология</h3>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <!-- Sleep Slider -->
                        <div class="mb-8 relative">
                            <div class="flex justify-between items-end mb-3">
                                <label class="text-sm font-semibold text-slate-300">Качество сна</label>
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-700 border border-slate-600 text-blue-400 font-bold shadow-inner" id="sleep-val">2</div>
                            </div>
                            <input type="range" min="0" max="10" value="2" class="w-full" oninput="updateSlider('sleep', this.value)">
                            <div class="flex justify-between mt-2 text-xs text-slate-500 font-medium">
                                <span>Отлично</span><span>Бессонница</span>
                            </div>
                        </div>
                        <!-- Stress Slider -->
                        <div class="mb-8 relative">
                            <div class="flex justify-between items-end mb-3">
                                <label class="text-sm font-semibold text-slate-300">Тревожность</label>
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-700 border border-slate-600 text-blue-400 font-bold shadow-inner" id="stress-val">2</div>
                            </div>
                            <input type="range" min="0" max="10" value="2" class="w-full" oninput="updateSlider('stress', this.value)">
                            <div class="flex justify-between mt-2 text-xs text-slate-500 font-medium">
                                <span>Спокоен</span><span>Паника</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-amber-500/5 border border-amber-500/20 p-5 rounded-xl flex gap-4 items-start">
                        <div class="text-amber-500 mt-1"><i data-lucide="alert-circle"></i></div>
                        <div>
                            <h4 class="text-amber-400 font-bold text-sm mb-1">Физические маркеры</h4>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Проверьте частоту пульса и потливость ладоней. Высокий уровень стресса может искажать восприятие боли.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODULE 4: COGNITIVE -->
        <div id="tab-content-3" class="tab-content fade-in">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 mb-6">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-700">
                    <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg"><i data-lucide="brain"></i></div>
                    <h3 class="text-xl font-bold text-slate-100">Модуль 4: Когнитивная оценка</h3>
                </div>
                <!-- Coping Slider -->
                <div class="mb-8 relative">
                    <div class="flex justify-between items-end mb-3">
                        <label class="text-sm font-semibold text-slate-300">Катастрофизация (Восприятие)</label>
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-slate-700 border border-slate-600 text-blue-400 font-bold shadow-inner" id="coping-val">3</div>
                    </div>
                    <input type="range" min="0" max="10" value="3" class="w-full" oninput="updateSlider('coping', this.value)">
                    <div class="flex justify-between mt-2 text-xs text-slate-500 font-medium">
                        <span>Я справлюсь</span><span>Безнадежность</span>
                    </div>
                </div>
                <div class="space-y-3 mt-6">
                    <label class="flex items-center gap-4 p-4 bg-slate-900/50 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800 transition-colors">
                        <input type="checkbox" class="w-5 h-5 accent-blue-500 bg-slate-700 border-slate-600 rounded">
                        <span class="text-slate-300 text-sm font-medium">Чувство несправедливости ("За что мне это?")</span>
                    </label>
                    <label class="flex items-center gap-4 p-4 bg-slate-900/50 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800 transition-colors">
                        <input type="checkbox" class="w-5 h-5 accent-blue-500 bg-slate-700 border-slate-600 rounded">
                        <span class="text-slate-300 text-sm font-medium">Недоверие к врачам</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- MODULE 5: NOTES -->
        <div id="tab-content-4" class="tab-content fade-in">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6 mb-6">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-slate-700">
                    <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg"><i data-lucide="eye"></i></div>
                    <h3 class="text-xl font-bold text-slate-100">Модуль 5: Наблюдение</h3>
                </div>
                <textarea class="w-full bg-slate-900 border border-slate-700 rounded-xl p-4 text-slate-200 placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" rows="6" placeholder="Введите клинические заметки..."></textarea>
            </div>
        </div>

        <!-- DASHBOARD / ANALYTICS (Fixed Bottom Section in Card) -->
        <div class="mt-8 p-1 rounded-3xl bg-gradient-to-r from-blue-600 to-purple-600 shadow-2xl print-only">
            <div class="bg-slate-900 rounded-[22px] p-6 md:p-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-slate-800">
                    <div>
                        <h2 class="text-3xl font-black text-white mb-1">Сводный отчет</h2>
                        <p class="text-slate-400 text-sm">R-PAT Kids Analytical Dashboard</p>
                    </div>
                    <div id="main-risk-badge" class="mt-4 md:mt-0 px-6 py-2 rounded-full border bg-emerald-500/10 border-emerald-500/20 text-emerald-400 font-bold uppercase tracking-wider">
                        Низкий риск
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">

                    <!-- Main Chart -->
                    <div class="flex flex-col items-center justify-center p-6 bg-slate-950/50 rounded-2xl border border-slate-800 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors duration-500"></div>

                        <!-- Main SVG Circle -->
                        <svg class="w-40 h-40 transform -rotate-90" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#1e293b" stroke-width="10" />
                            <circle id="main-progress" class="progress-ring__circle" cx="60" cy="60" r="54" fill="none" stroke="#10b981" stroke-width="10" stroke-dasharray="339" stroke-dashoffset="339" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span id="main-val" class="text-3xl font-bold text-white">0</span>
                            <span class="text-[10px] text-slate-400 uppercase">из 100</span>
                        </div>

                        <div class="mt-4 text-center">
                            <div class="text-slate-500 text-xs font-bold uppercase">Общий индекс боли</div>
                            <div class="text-white font-mono text-sm opacity-50" id="current-date">--.--.----</div>
                        </div>
                    </div>

                    <!-- Metrics Breakdown -->
                    <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                        <!-- FLACC Bar -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-400">Объективно (FLACC)</span>
                                <span id="bar-flacc-val" class="text-slate-200 font-mono">0/10</span>
                            </div>
                            <div class="h-2 w-full bg-slate-700 rounded-full overflow-hidden">
                                <div id="bar-flacc" class="h-full bg-blue-500 transition-all duration-500" style="width: 0%"></div>
                            </div>
                        </div>
                        <!-- Self Bar -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-400">Самооценка (Scale)</span>
                                <span id="bar-pain-val" class="text-slate-200 font-mono">0/10</span>
                            </div>
                            <div class="h-2 w-full bg-slate-700 rounded-full overflow-hidden">
                                <div id="bar-pain" class="h-full bg-indigo-500 transition-all duration-500" style="width: 0%"></div>
                            </div>
                        </div>
                        <!-- Psycho Bar -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-400">Психо (Stress/Sleep)</span>
                                <span id="bar-psy-val" class="text-slate-200 font-mono">2/10</span>
                            </div>
                            <div class="h-2 w-full bg-slate-700 rounded-full overflow-hidden">
                                <div id="bar-psy" class="h-full bg-purple-500 transition-all duration-500" style="width: 20%"></div>
                            </div>
                        </div>
                        <!-- Cog Bar -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-400">Когнитив (Coping)</span>
                                <span id="bar-cog-val" class="text-slate-200 font-mono">3/10</span>
                            </div>
                            <div class="h-2 w-full bg-slate-700 rounded-full overflow-hidden">
                                <div id="bar-cog" class="h-full bg-pink-500 transition-all duration-500" style="width: 30%"></div>
                            </div>
                        </div>

                        <div class="col-span-1 sm:col-span-2 mt-4 p-4 bg-slate-800 rounded-xl border-l-4 border-l-blue-500">
                            <h5 class="text-blue-400 font-bold text-sm mb-1 flex items-center gap-2">
                                <i data-lucide="activity" class="w-4 h-4"></i> Рекомендация ИИ
                            </h5>
                            <p id="ai-advice" class="text-slate-300 text-sm leading-relaxed">
                                Продолжать текущую терапию. Повторная оценка через 12 часов.
                            </p>
                        </div>
                    </div>
                </div>

                <button onclick="window.print()" class="w-full mt-6 py-4 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition-colors border border-slate-700 no-print">
                    Экспорт в PDF
                </button>
            </div>
        </div>

    </div>
</main>

<!-- Mobile Bottom Nav -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-slate-900/90 backdrop-blur-lg border-t border-slate-800 px-6 py-3 flex justify-between z-50 no-print">
    <button onclick="switchTab(0)" class="flex flex-col items-center gap-1 text-slate-500 hover:text-blue-500" id="mob-0">
        <i data-lucide="baby" class="w-5 h-5"></i>
        <span class="text-[9px] font-bold uppercase tracking-wider">FLACC</span>
    </button>
    <button onclick="switchTab(1)" class="flex flex-col items-center gap-1 text-slate-500 hover:text-blue-500" id="mob-1">
        <i data-lucide="smile" class="w-5 h-5"></i>
        <span class="text-[9px] font-bold uppercase tracking-wider">Scale</span>
    </button>
    <button onclick="switchTab(2)" class="flex flex-col items-center gap-1 text-slate-500 hover:text-blue-500" id="mob-2">
        <i data-lucide="moon" class="w-5 h-5"></i>
        <span class="text-[9px] font-bold uppercase tracking-wider">Psy</span>
    </button>
    <button onclick="switchTab(3)" class="flex flex-col items-center gap-1 text-slate-500 hover:text-blue-500" id="mob-3">
        <i data-lucide="brain" class="w-5 h-5"></i>
        <span class="text-[9px] font-bold uppercase tracking-wider">Cog</span>
    </button>
</div>

<script>
    // STATE
    const state = {
        activeTab: 0,
        flacc: { face: 0, legs: 0, activity: 0, cry: 0, consolability: 0 },
        painLevel: 0,
        selectedBodyParts: [],
        selectedPainTypes: [],
        sleep: 2,
        stress: 2,
        coping: 3
    };

    // CONSTANTS
    const FLACC_DATA = [
        { id: 'face', name: 'Лицо', options: ['Нет особого выражения', 'Иногда гримаса', 'Частое дрожание/сжатые челюсти'] },
        { id: 'legs', name: 'Ноги', options: ['Нормальные/расслабленные', 'Беспокойные', 'Поджатые/брыкающиеся'] },
        { id: 'activity', name: 'Активность', options: ['Лежит спокойно', 'Извивается', 'Выгибается дугой'] },
        { id: 'cry', name: 'Плач', options: ['Не плачет', 'Стонет/хнычет', 'Постоянный плач/крик'] },
        { id: 'consolability', name: 'Утешаемость', options: ['Расслаблен', 'Успокаивается', 'Трудно успокоить'] }
    ];

    const FACES_DATA = [
        { val: 0, emoji: "😃", label: "Нет" },
        { val: 2, emoji: "🙂", label: "Чуть" },
        { val: 4, emoji: "😐", label: "Мало" },
        { val: 6, emoji: "🙁", label: "Сильно" },
        { val: 8, emoji: "😢", label: "Очень" },
        { val: 10, emoji: "😭", label: "Макс" },
    ];

    const PAIN_TYPES = ['Колющая', 'Жгучая', 'Тупая', 'Давящая', 'Пульсирующая', 'Внезапная'];

    const BODY_LABELS = {
        'head': 'Голова', 'chest': 'Грудь', 'stomach': 'Живот',
        'l_arm': 'Левая рука', 'r_arm': 'Правая рука',
        'l_leg': 'Левая нога', 'r_leg': 'Правая нога'
    };

    // INIT
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        renderFlacc();
        renderFaces();
        renderPainTypes();
        document.getElementById('current-date').innerText = new Date().toLocaleDateString();
        updateDashboard();
    });

    // --- NAVIGATION ---
    function switchTab(id) {
        state.activeTab = id;
        // Hide all
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.nav-btn').forEach(el => {
            el.classList.remove('active', 'bg-blue-600', 'text-white');
            el.classList.add('text-slate-400');
        });
        document.querySelectorAll('[id^="mob-"]').forEach(el => el.classList.remove('text-blue-500'));

        // Show active
        document.getElementById(`tab-content-${id}`).classList.add('active');

        // Highlight Desktop Nav
        const btn = document.getElementById(`nav-${id}`);
        if(btn) {
            btn.classList.add('active', 'bg-blue-600', 'text-white');
            btn.classList.remove('text-slate-400');
        }

        // Highlight Mobile Nav
        const mobBtn = document.getElementById(`mob-${id}`);
        if(mobBtn) mobBtn.classList.add('text-blue-500');
    }

    // --- MODULE 1: FLACC LOGIC ---
    function renderFlacc() {
        const container = document.getElementById('flacc-container');
        container.innerHTML = '';

        FLACC_DATA.forEach(cat => {
            const catDiv = document.createElement('div');
            catDiv.className = 'bg-slate-900/50 p-4 rounded-xl border border-slate-700/50';

            const title = document.createElement('h4');
            title.className = 'font-bold text-slate-300 mb-3 text-sm uppercase tracking-wide';
            title.innerText = cat.name;
            catDiv.appendChild(title);

            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-1 sm:grid-cols-3 gap-2';

            cat.options.forEach((opt, idx) => {
                const btn = document.createElement('button');
                btn.className = `text-left text-sm p-3 rounded-lg border transition-all ${state.flacc[cat.id] === idx ? 'bg-blue-600 border-blue-500 text-white' : 'bg-slate-800 text-slate-400 border-slate-700 hover:border-slate-500'}`;
                btn.onclick = () => setFlacc(cat.id, idx);
                btn.innerHTML = `<div class="font-bold mb-1 opacity-70 text-xs">БАЛЛ: ${idx}</div>${opt}`;
                grid.appendChild(btn);
            });

            catDiv.appendChild(grid);
            container.appendChild(catDiv);
        });
    }

    function setFlacc(catId, score) {
        state.flacc[catId] = score;
        renderFlacc();
        updateDashboard();
    }

    // --- MODULE 2: SELF REPORT LOGIC ---
    function renderFaces() {
        const container = document.getElementById('faces-container');
        container.innerHTML = '';
        FACES_DATA.forEach(face => {
            const btn = document.createElement('button');
            const isActive = state.painLevel === face.val;
            btn.className = `face-btn flex flex-col items-center p-3 rounded-xl border ${isActive ? 'active border-amber-500 bg-amber-500/10' : 'border-slate-700 bg-slate-800/50 hover:bg-slate-800'}`;
            btn.onclick = () => { state.painLevel = face.val; renderFaces(); updateDashboard(); };
            btn.innerHTML = `
                    <span class="text-3xl mb-2 drop-shadow-md">${face.emoji}</span>
                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wide">${face.label}</span>
                    <div class="text-[10px] font-bold mt-1 px-2 rounded-full ${isActive ? 'bg-amber-500 text-slate-900' : 'bg-slate-700 text-slate-500'}">${face.val}</div>
                `;
            container.appendChild(btn);
        });
        document.getElementById('pain-level-display').innerText = `${state.painLevel}/10`;
    }

    function toggleBodyPart(id) {
        const el = document.getElementById(`part-${id}`);
        if (state.selectedBodyParts.includes(id)) {
            state.selectedBodyParts = state.selectedBodyParts.filter(p => p !== id);
            el.classList.remove('active');
        } else {
            state.selectedBodyParts.push(id);
            el.classList.add('active');
        }
        updateBodyLabel();
    }

    function updateBodyLabel() {
        const listEl = document.getElementById('selected-parts-list');
        if(state.selectedBodyParts.length === 0) {
            listEl.innerHTML = 'Ничего не выбрано';
            return;
        }
        listEl.innerHTML = '';
        state.selectedBodyParts.forEach(id => {
            const span = document.createElement('span');
            span.className = 'text-xs bg-rose-500/20 text-rose-300 px-3 py-1 rounded-full border border-rose-500/30';
            span.innerText = BODY_LABELS[id];
            listEl.appendChild(span);
        });
    }

    function renderPainTypes() {
        const container = document.getElementById('pain-types-container');
        container.innerHTML = '';
        PAIN_TYPES.forEach(type => {
            const btn = document.createElement('button');
            const isActive = state.selectedPainTypes.includes(type);
            btn.className = `px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide border transition-all ${isActive ? 'bg-indigo-500 text-white border-indigo-400' : 'bg-slate-800 text-slate-400 border-slate-700'}`;
            btn.innerText = type;
            btn.onclick = () => {
                if(state.selectedPainTypes.includes(type)) state.selectedPainTypes = state.selectedPainTypes.filter(t => t!==type);
                else state.selectedPainTypes.push(type);
                renderPainTypes();
            };
            container.appendChild(btn);
        });
    }

    // --- SLIDERS ---
    function updateSlider(key, val) {
        state[key] = parseInt(val);
        document.getElementById(`${key}-val`).innerText = val;
        updateDashboard();
    }

    // --- DASHBOARD / CALCULATIONS ---
    function updateDashboard() {
        const flaccTotal = Object.values(state.flacc).reduce((a,b) => a+b, 0);
        document.getElementById('flacc-total-display').innerText = flaccTotal;

        const sum = flaccTotal + state.painLevel + state.stress + state.sleep + state.coping;
        // Approx Formula: Sum / 50 * 100
        const index = Math.min(100, Math.round((sum / 50) * 100));

        // Determine Risk Level & Colors
        let levelLabel = 'Низкий';
        let mainColor = '#10b981'; // emerald
        let bgClass = 'bg-emerald-500/10 border-emerald-500/20';
        let textClass = 'text-emerald-400';
        let advice = 'Продолжать текущую терапию. Повторная оценка через 12 часов.';

        if (index > 30) {
            levelLabel = 'Средний';
            mainColor = '#f59e0b'; // amber
            bgClass = 'bg-amber-500/10 border-amber-500/20';
            textClass = 'text-amber-400';
            advice = 'Мониторинг каждые 4 часа. Примените методы отвлечения (игры, дыхание).';
        }
        if (index > 60) {
            levelLabel = 'Высокий';
            mainColor = '#f43f5e'; // rose
            bgClass = 'bg-rose-500/10 border-rose-500/20';
            textClass = 'text-rose-400';
            advice = 'Рекомендуется немедленная консультация специалиста по боли. Рассмотрите мультимодальную аналгезию.';
        }

        // Update Header Badge
        const hBadge = document.getElementById('header-risk-badge');
        hBadge.className = `hidden md:flex items-center gap-3 px-4 py-1.5 rounded-full border ${bgClass}`;
        document.getElementById('header-risk-val').className = `text-lg font-black ${textClass}`;
        document.getElementById('header-risk-val').innerText = index + '%';

        // Update Mini Sidebar Widget
        const circumference = 2 * Math.PI * 45; // r=45
        const miniOffset = circumference - (index / 100) * circumference;
        const miniCircle = document.getElementById('mini-progress');
        miniCircle.style.stroke = mainColor;
        miniCircle.style.strokeDashoffset = miniOffset;

        document.getElementById('mini-val').innerText = index;
        const miniLabel = document.getElementById('mini-label');
        miniLabel.innerText = levelLabel;
        miniLabel.className = `text-sm font-bold ${textClass} mt-2 py-1 px-3 bg-slate-950/30 rounded-full inline-block`;

        // Update Main Dashboard Badge & Chart
        const mBadge = document.getElementById('main-risk-badge');
        mBadge.className = `mt-4 md:mt-0 px-6 py-2 rounded-full border ${bgClass} ${textClass} font-bold uppercase tracking-wider`;
        mBadge.innerText = levelLabel + ' риск';

        const mainCircumference = 2 * Math.PI * 54; // r=54
        const mainOffset = mainCircumference - (index / 100) * mainCircumference;
        const mainCircle = document.getElementById('main-progress');
        mainCircle.style.stroke = mainColor;
        mainCircle.style.strokeDashoffset = mainOffset;
        document.getElementById('main-val').innerText = index;

        // Update Bars
        updateBar('bar-flacc', flaccTotal, 10);
        updateBar('bar-pain', state.painLevel, 10);
        updateBar('bar-psy', Math.round((state.stress + state.sleep)/2), 10);
        updateBar('bar-cog', state.coping, 10);

        // Update Advice
        document.getElementById('ai-advice').innerText = advice;
    }

    function updateBar(id, val, max) {
        document.getElementById(`${id}-val`).innerText = `${val}/${max}`;
        document.getElementById(id).style.width = `${(val/max)*100}%`;
    }
</script>
</body>
</html>
