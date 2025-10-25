<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RespAI - Ventilator Monitoring Dashboard</title>
    <!-- Подключение Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Подключение шрифтов Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Exo+2:wght@600;700&display=swap" rel="stylesheet">

    <style>
        /* Кастомные стили */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* bg-slate-900 */
            color: #e2e8f0; /* bg-slate-200 */
        }
        .font-logo {
            font-family: 'Exo 2', sans-serif;
        }
        /* Стили для карточек */
        .card {
            background-color: #1e293b; /* bg-slate-800 */
            border: 1px solid #334155; /* border-slate-700 */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }
        /* Анимация пульсации для "живых" данных */
        .live-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        /* Анимация для AI-анализа */
        @keyframes ai-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
        }
        .ai-processing {
            animation: ai-pulse 1.5s ease-in-out infinite;
        }
        /* Стиль для холста (canvas) */
        canvas {
            width: 100%;
            height: 150px;
            background-color: #000;
            border-radius: 0.5rem; /* rounded-lg */
        }
        /* Кастомные инпуты */
        .param-input {
            background-color: #334155; /* bg-slate-700 */
            border: 1px solid #475569; /* border-slate-600 */
            color: #e2e8f0; /* text-slate-200 */
            border-radius: 0.375rem; /* rounded-md */
            width: 100%;
            padding: 0.5rem 0.75rem;
            transition: all 0.2s ease;
        }
        .param-input:focus {
            outline: none;
            border-color: #0ea5e9; /* border-sky-500 */
            box-shadow: 0 0 0 2px #0ea5e980;
        }
        /* Кастомные кнопки */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
        }
        .btn-primary {
            background-color: #0ea5e9; /* bg-sky-500 */
            color: white;
        }
        .btn-primary:hover {
            background-color: #0284c7; /* bg-sky-600 */
        }
        .btn-secondary {
            background-color: #334155; /* bg-slate-700 */
            color: #e2e8f0; /* text-slate-200 */
        }
        .btn-secondary:hover {
            background-color: #475569; /* bg-slate-600 */
        }
        .btn-danger {
            background-color: #ef4444; /* bg-red-500 */
            color: white;
        }
        .btn-danger:hover {
            background-color: #dc2626; /* bg-red-600 */
        }

        /* Стили для чеклиста */
        .action-checklist li {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background-color: #334155; /* bg-slate-700 */
            border-radius: 0.375rem; /* rounded-md */
            margin-bottom: 0.5rem;
        }
        .action-checklist input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
            accent-color: #0ea5e9; /* text-sky-500 */
        }

        /* Стиль для редактируемого имени */
        [contenteditable="true"] {
            outline: 2px dashed transparent;
            transition: all 0.2s ease;
            cursor: text;
        }
        [contenteditable="true"]:hover,
        [contenteditable="true"]:focus {
            outline-color: #0ea5e980; /* sky-500 with opacity */
            background-color: #334155; /* bg-slate-700 */
        }

    </style>
</head>
<body class="p-4 lg:p-8">

<!-- === ШАПКА === -->
<header class="flex flex-col lg:flex-row justify-between items-center mb-6">
    <!-- Логотип -->
    <div class="flex items-center space-x-3 mb-4 lg:mb-0">
        <!-- Иконка лого (SVG) -->
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18.847 18.293C20.046 17.062 21.01 15.617 21.684 14.02C22.358 12.422 22.73 10.706 22.78 8.95C22.829 7.193 22.556 5.45 21.977 3.822C21.397 2.194 20.52 0.72 19.39 0H19.389C18.26 0.72 17.382 2.194 16.803 3.822C16.224 5.45 15.951 7.193 15.999 8.95C16.05 10.706 16.421 12.422 17.095 14.02C17.77 15.617 18.733 17.062 19.932 18.293L19.39 18.85L18.847 18.293Z" fill="#0ea5e9"/>
            <path d="M5.153 18.293C3.954 17.062 2.99 15.617 2.316 14.02C1.642 12.422 1.27 10.706 1.22 8.95C1.171 7.193 1.444 5.45 2.023 3.822C2.603 2.194 3.48 0.72 4.61 0H4.611C5.74 0.72 6.618 2.194 7.197 3.822C7.776 5.45 8.049 7.193 8.001 8.95C7.95 10.706 7.579 12.422 6.905 14.02C6.23 15.617 5.267 17.062 4.068 18.293L4.61 18.85L5.153 18.293Z" fill="#0ea5e9"/>
            <path d="M12 17C10.144 17 8.363 16.31 6.929 15.08C5.495 13.85 4.5 12.18 4.13 10.36C4.091 10.158 4.071 9.955 4.071 9.75C4.071 9.336 4.407 9 4.821 9H19.179C19.593 9 19.929 9.336 19.929 9.75C19.929 9.955 19.909 10.158 19.87 10.36C19.5 12.18 18.505 13.85 17.071 15.08C15.637 16.31 13.856 17 12 17Z" fill="#0ea5e9" fill-opacity="0.6"/>
            <path d="M14 17.5H10V24H14V17.5Z" fill="#0ea5e9" fill-opacity="0.6"/>
            <rect x="9" y="5" width="6" height="6" rx="1" fill="#f0f9ff"/>
            <path d="M10 8H11V10H10V8Z" fill="#0ea5e9"/>
            <path d="M12 8H13V10H12V8Z" fill="#0ea5e9"/>
            <path d="M10 6H11V7H10V6Z" fill="#0ea5e9"/>
            <path d="M12 6H13V7H10V6H12Z" fill="#0ea5e9"/>
            <path d="M10 11H11V10H10V11Z" fill="#0ea5e9"/>
            <path d="M12 11H13V10H12V11Z" fill="#0ea5e9"/>
            <path d="M13 8H14V10H13V8Z" fill="#0ea5e9"/>
            <path d="M13 6H14V7H13V6Z" fill="#0ea5e9"/>
            <path d="M9 8H10V10H9V8Z" fill="#0ea5e9"/>
            <path d="M9 6H10V7H9V6Z" fill="#0ea5e9"/>
            <path d="M13 11H14V10H13V11Z" fill="#0ea5e9"/>
            <path d="M9 11H10V10H9V11Z" fill="#0ea5e9"/>
            <!-- Пульс -->
            <path d="M11.5 13H13L14 15L16 12L17 14L18.5 13H20" stroke="#f97316" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <h1 class="font-logo text-3xl font-bold text-white">RespAI<span class="text-cyan-400">-interpretation</span></h1>
    </div>

    <!-- Профиль пациента -->
    <div class="card p-4 w-full lg:w-auto">
        <div class="flex items-center space-x-4">
            <img src="https://placehold.co/64x64/334155/e2e8f0?text=JD" alt="Patient Photo" class="w-16 h-16 rounded-full border-2 border-slate-600">
            <div>
                <div id="patient-name" class="text-lg font-semibold text-white px-2 py-1 rounded-md" contenteditable="true" title="Нажмите, чтобы изменить имя">Patient: Kovalenko I. A. (F, 58)</div>
                <div class="text-sm text-slate-400">ID: 45A-882-B | MRN: 7701923</div>
                <div class="text-sm text-slate-400">Admission: 24.10.2025 | 14:30</div>
            </div>
            <div class="ml-auto pl-4 border-l border-slate-700">
                <div class="text-sm text-red-400 font-semibold">STATUS</div>
                <div class="text-lg font-bold text-red-400 animate-pulse">CRITICAL</div>
            </div>
        </div>
</header>

<!-- === ОСНОВНАЯ ПАНЕЛЬ === -->
<main class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- === КОЛОНКА 1: ПАРАМЕТРЫ И СИМУЛЯТОР === -->
    <div class="flex flex-col space-y-6">

        <!-- Симулятор Сценариев (Для инвесторов) -->
        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Scenario Simulator</h2>
            <p class="text-sm text-slate-400 mb-4">Click to simulate a clinical scenario.</p>
            <div class="grid grid-cols-2 gap-3">
                <button class="btn btn-secondary" id="btn-normal">Normal</button>
                <button class="btn btn-secondary" id="btn-ards">ARDS (Low Cstat)</button>
                <button class="btn btn-secondary" id="btn-obstruct">Obstruction (Asthma)</button>
                <button class="btn btn-danger" id="btn-pneumo">Pneumothorax</button>
            </div>
        </div>

        <!-- Основные показатели (Vitals) -->
        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Vitals Monitor</h2>
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <div class="text-sm text-cyan-400">SpO₂</div>
                    <div id="val-spo2" class="text-4xl font-bold text-white live-pulse">95%</div>
                </div>
                <div>
                    <div class="text-sm text-amber-400">etCO₂</div>
                    <div id="val-etco2" class="text-4xl font-bold text-white">40</div>
                    <div class="text-xs text-slate-500">mmHg</div>
                </div>
                <div>
                    <div class="text-sm text-rose-400">HR</div>
                    <div id="val-hr" class="text-4xl font-bold text-white">105</div>
                    <div class="text-xs text-slate-500">bpm</div>
                </div>
                <div>
                    <div class="text-sm text-lime-400">MAP</div>
                    <div id="val-map" class="text-4xl font-bold text-white">75</div>
                    <div class="text-xs text-slate-500">mmHg</div>
                </div>
            </div>
        </div>

        <!-- Параметры ИВЛ (Ручной ввод) -->
        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Ventilator Parameters</h2>
            <div class="grid grid-cols-2 gap-x-4 gap-y-3">
                <div>
                    <label class="text-sm text-slate-400">PIP (смH₂O)</label>
                    <input type="number" id="pip" class="param-input" value="25">
                </div>
                <div>
                    <label class="text-sm text-slate-400">Pplat (смH₂O)</label>
                    <input type="number" id="pplat" class="param-input" value="20">
                </div>
                <div>
                    <label class="text-sm text-slate-400">PEEP (cmH₂O)</label>
                    <input type="number" id="peep" class="param-input" value="5">
                </div>
                <div>
                    <label class="text-sm text-slate-400">RR (breaths/min)</label>
                    <input type="number" id="rr" class="param-input" value="16">
                </div>
                <div>
                    <label class="text-sm text-slate-400">Vt set (мл)</label>
                    <input type="number" id="vt_set" class="param-input" value="450">
                </div>
                <div>
                    <label class="text-sm text-slate-400">Vt exp (мл)</label>
                    <input type="number" id="vt_exp" class="param-input" value="445">
                </div>
                <div>
                    <label class="text-sm text-slate-400">FiO₂</label>
                    <input type="number" id="fio2" class="param-input" value="0.5" step="0.1">
                </div>
                <div>
                    <label class="text-sm text-slate-400">auto-PEEP (смH₂O)</label>
                    <input type="number" id="auto_peep" class="param-input" value="0" step="1">
                </div>
                <!-- Динамические (для правил) -->
                <input type="hidden" id="delta_pip" value="0">
                <input type="hidden" id="delta_pplat" value="0">
                <input type="hidden" id="bp_drop" value="false">
                <input type="hidden" id="spo2_drop" value="false">
                <input type="hidden" id="sawtooth_score" value="0">
                <input type="hidden" id="exp_flow_end" value="-0.1">
            </div>
        </div>

    </div>

    <!-- === КОЛОНКА 2: ВОЛНОВЫЕ ФОРМЫ И ЛОГИ === -->
    <div class="flex flex-col space-y-6">

        <!-- Волновые формы -->
        <div class="card p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Live Waveforms</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-lime-400">Pressure-Time (P-t)</label>
                    <canvas id="canvas-pressure"></canvas>
                </div>
                <div>
                    <label class="text-sm font-medium text-cyan-400">Flow-Time (Flow-t)</label>
                    <canvas id="canvas-flow"></canvas>
                </div>
                <div>
                    <label class="text-sm font-medium text-amber-400">Volume-Time (V-t)</label>
                    <canvas id="canvas-volume"></canvas>
                </div>
            </div>
        </div>

        <!-- Журнал событий -->
        <div class="card p-6 flex-grow">
            <h2 class="text-xl font-semibold mb-4 text-white">Event Log</h2>
            <div id="event-log" class="h-64 overflow-y-auto space-y-2 text-sm pr-2">
                <!-- События будут добавлены сюда -->
                <div class="text-slate-500">Waiting for events...</div>
            </div>
        </div>
    </div>

    <!-- === КОЛОНКА 3: AI-АНАЛИЗ === -->
    <div class="flex flex-col space-y-6">
        <!-- Кнопка Анализа -->
        <div class="card p-4">
            <button id="btn-analyze" class="btn btn-primary w-full text-lg">
                Run AI Analysis
            </button>
        </div>

        <!-- Результаты Анализа -->
        <div id="analysis-container" class="card p-6 flex-grow">

            <!-- Состояние "Готов к анализу" -->
            <div id="analysis-ready" class="flex flex-col items-center justify-center h-full text-center">
                <svg class="w-16 h-16 text-slate-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21M9 17.25v-1.007a3 3 0 00-.879-2.122L7.5 13.5m0-3v-1.007a3 3 0 01.879-2.122L9 7.5m0 3v1.007a3 3 0 00.879 2.122l1.121.879m-1.121-1.121l1.121-1.121a3 3 0 012.122-.879H15m0 0v2.121a3 3 0 00.879 2.122l1.121 1.121m-1.121-1.121l1.121-1.121a3 3 0 012.122-.879H16.5m0 0H15v-2.121a3 3 0 00-.879-2.122l-1.121-1.121" />
                </svg>
                <h3 class="text-lg font-semibold text-slate-400">RespAI Ready</h3>
                <p class="text-sm text-slate-500">Run analysis to get<br>diagnostic hypotheses.</p>
            </div>

            <!-- Состояние "Анализ..." -->
            <div id="analysis-processing" class="hidden flex-col items-center justify-center h-full text-center">
                <svg class="w-20 h-20 text-cyan-400 ai-processing" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.847 18.293C20.046 17.062 21.01 15.617 21.684 14.02C22.358 12.422 22.73 10.706 22.78 8.95C22.829 7.193 22.556 5.45 21.977 3.822C21.397 2.194 20.52 0.72 19.39 0H19.389C18.26 0.72 17.382 2.194 16.803 3.822C16.224 5.45 15.951 7.193 15.999 8.95C16.05 10.706 16.421 12.422 17.095 14.02C17.77 15.617 18.733 17.062 19.932 18.293L19.39 18.85L18.847 18.293Z" fill="#0ea5e9"/>
                    <path d="M5.153 18.293C3.954 17.062 2.99 15.617 2.316 14.02C1.642 12.422 1.27 10.706 1.22 8.95C1.171 7.193 1.444 5.45 2.023 3.822C2.603 2.194 3.48 0.72 4.61 0H4.611C5.74 0.72 6.618 2.194 7.197 3.822C7.776 5.45 8.049 7.193 8.001 8.95C7.95 10.706 7.579 12.422 6.905 14.02C6.23 15.617 5.267 17.062 4.068 18.293L4.61 18.85L5.153 18.293Z" fill="#0ea5e9"/>
                    <rect x="9" y="5" width="6" height="6" rx="1" fill="#f0f9ff" fill-opacity="0.8"/>
                </svg>
                <h3 class="text-xl font-semibold text-cyan-400 mt-4">Analyzing...</h3>
                <p class="text-sm text-slate-400">Processing ventilator data and waveforms...</p>
            </div>

            <!-- Состояние "Результат" -->
            <div id="analysis-results" class="hidden">
                <!-- Критический алерт -->
                <div id="critical-alert-banner" class="hidden mb-4 p-4 bg-red-800 border border-red-600 rounded-lg flex items-center space-x-3">
                    <svg class="w-8 h-8 text-white flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.01" />
                    </svg>
                    <div>
                        <h3 class="text-xl font-bold text-white">CRITICAL ALERT</h3>
                        <p class="text-red-100">Life-threatening situation detected!</p>
                    </div>
                </div>

                <!-- Основной диагноз -->
                <div class="text-center mb-4">
                    <div class="text-sm font-semibold text-cyan-400">PRIMARY DIAGNOSIS (AI)</div>
                    <h2 id="result-label" class="text-3xl font-bold text-white"></h2>
                    <div id="result-score" class="text-5xl font-bold text-cyan-400"></div>
                </div>

                <!-- Альтернативы -->
                <div id="result-alternatives-container" class="mb-6">
                    <h4 class="text-sm font-semibold text-slate-400 mb-2 text-center">Alternative Hypotheses:</h4>
                    <div id="result-alternatives" class="flex justify-center gap-4 text-sm">
                        <!-- Альтернативы будут здесь -->
                    </div>
                </div>

                <!-- Объяснение и Действия -->
                <div class="space-y-6">
                    <div class="card p-4 bg-slate-900/50">
                        <h3 class="text-lg font-semibold text-white mb-2">
                            <span class="text-amber-400">WHY?</span> (AI Explanation)
                        </h3>
                        <ul id="result-why" class="list-disc list-inside text-slate-300 space-y-1">
                            <!-- Причины будут здесь -->
                        </ul>
                    </div>

                    <div class="card p-4 bg-slate-900/50">
                        <h3 class="text-lg font-semibold text-white mb-3">
                            <span class="text-lime-400">WHAT TO DO?</span> (Recommendations)
                        </h3>
                        <ul id="result-recommend" class="space-y-2 action-checklist">
                            <!-- Действия будут здесь -->
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // === DOM ЭЛЕМЕНТЫ ===
        const inputs = {
            pip: document.getElementById('pip'),
            pplat: document.getElementById('pplat'),
            peep: document.getElementById('peep'),
            rr: document.getElementById('rr'),
            vt_set: document.getElementById('vt_set'),
            vt_exp: document.getElementById('vt_exp'),
            fio2: document.getElementById('fio2'),
            auto_peep: document.getElementById('auto_peep'),
            delta_pip: document.getElementById('delta_pip'),
            delta_pplat: document.getElementById('delta_pplat'),
            bp_drop: document.getElementById('bp_drop'),
            spo2_drop: document.getElementById('spo2_drop'),
            sawtooth_score: document.getElementById('sawtooth_score'),
            exp_flow_end: document.getElementById('exp_flow_end'),
        };

        const vitals = {
            spo2: document.getElementById('val-spo2'),
            etco2: document.getElementById('val-etco2'),
            hr: document.getElementById('val-hr'),
            map: document.getElementById('val-map'),
        };

        const buttons = {
            normal: document.getElementById('btn-normal'),
            ards: document.getElementById('btn-ards'),
            obstruct: document.getElementById('btn-obstruct'),
            pneumo: document.getElementById('btn-pneumo'),
            analyze: document.getElementById('btn-analyze'),
        };

        const analysisUI = {
            container: document.getElementById('analysis-container'),
            ready: document.getElementById('analysis-ready'),
            processing: document.getElementById('analysis-processing'),
            results: document.getElementById('analysis-results'),
            alertBanner: document.getElementById('critical-alert-banner'),
            label: document.getElementById('result-label'),
            score: document.getElementById('result-score'),
            alternativesContainer: document.getElementById('result-alternatives-container'),
            alternatives: document.getElementById('result-alternatives'),
            why: document.getElementById('result-why'),
            recommend: document.getElementById('result-recommend'),
        };

        const eventLog = document.getElementById('event-log');

        // === ДАННЫЕ СЦЕНАРИЕВ ===
        // (Это то, что делает демо интерактивным)
        const scenarios = {
            normal: {
                inputs: { pip: 22, pplat: 18, peep: 5, rr: 14, vt_set: 450, vt_exp: 448, fio2: 0.4, auto_peep: 0, delta_pip: 0, delta_pplat: 0, bp_drop: false, spo2_drop: false, sawtooth_score: 0.1, exp_flow_end: -0.1 },
                vitals: { spo2: "98%", etco2: 38, hr: 75, map: 85 },
                waveParams: { p_max: 22, p_plat: 18, p_min: 5, f_max: 60, f_min: -40, f_exp_end: 0, v_max: 450, exp_curve: 1.5 }
            },
            ards: {
                inputs: { pip: 38, pplat: 32, peep: 12, rr: 18, vt_set: 380, vt_exp: 375, fio2: 0.8, auto_peep: 1, delta_pip: 8, delta_pplat: 8, bp_drop: false, spo2_drop: true, sawtooth_score: 0.1, exp_flow_end: -0.1 },
                vitals: { spo2: "89%", etco2: 48, hr: 110, map: 70 },
                waveParams: { p_max: 38, p_plat: 32, p_min: 12, f_max: 50, f_min: -35, f_exp_end: 0, v_max: 380, exp_curve: 1.2 } // Быстрый выдох из-за "жестких" легких
            },
            obstruct: {
                inputs: { pip: 42, pplat: 22, peep: 5, rr: 12, vt_set: 500, vt_exp: 430, fio2: 0.6, auto_peep: 6, delta_pip: 15, delta_pplat: 2, bp_drop: false, spo2_drop: false, sawtooth_score: 0.2, exp_flow_end: 2.5 }, // Не доходит до 0
                vitals: { spo2: "94%", etco2: 52, hr: 95, map: 80 },
                waveParams: { p_max: 42, p_plat: 22, p_min: 5, f_max: 60, f_min: -20, f_exp_end: 15, v_max: 430, exp_curve: 3.0 } // Медленный, долгий выдох
            },
            pneumo: {
                inputs: { pip: 55, pplat: 50, peep: 5, rr: 20, vt_set: 400, vt_exp: 250, fio2: 1.0, auto_peep: 0, delta_pip: 30, delta_pplat: 30, bp_drop: true, spo2_drop: true, sawtooth_score: 0.1, exp_flow_end: -0.1 },
                vitals: { spo2: "82%", etco2: 55, hr: 130, map: 60 },
                waveParams: { p_max: 55, p_plat: 50, p_min: 5, f_max: 40, f_min: -20, f_exp_end: 0, v_max: 250, exp_curve: 1.0 } // Резкий пик, малый объем
            }
        };

        // Глобальный объект для параметров отрисовки
        let currentWaveParams = scenarios.normal.waveParams;
        let animationFrameId;

        // === ЛОГИКА СИМУЛЯТОРА ===

        function loadScenario(scenarioName) {
            const scenario = scenarios[scenarioName];
            if (!scenario) return;

            // 1. Заполнить инпуты
            for (const key in scenario.inputs) {
                if (inputs[key]) {
                    inputs[key].value = scenario.inputs[key];
                }
            }

            // 2. Обновить "живые" показатели
            for (const key in scenario.vitals) {
                if (vitals[key]) {
                    vitals[key].textContent = scenario.vitals[key];
                    // Добавить/убрать класс пульсации
                    vitals[key].classList.remove('text-red-400', 'live-pulse');
                    if (key === 'spo2' && parseInt(scenario.vitals[key]) < 92) {
                        vitals[key].classList.add('text-red-400', 'live-pulse');
                    }
                    if (key === 'hr' && parseInt(scenario.vitals[key]) > 120) {
                        vitals[key].classList.add('text-red-400', 'live-pulse');
                    }
                }
            }

            // 3. Обновить параметры для отрисовки волн
            currentWaveParams = scenario.waveParams;

            // 4. Сбросить UI анализа
            resetAnalysisUI();

            // 5. Добавить в лог
            addLogEntry(`Simulation started: ${scenarioName.toUpperCase()}`, 'info');
        }

        buttons.normal.onclick = () => loadScenario('normal');
        buttons.ards.onclick = () => loadScenario('ards');
        buttons.obstruct.onclick = () => loadScenario('obstruct');
        buttons.pneumo.onclick = () => loadScenario('pneumo');

        // === ЛОГИКА АНАЛИЗА (JS-порт из Python) ===

        function runDiagnosis() {
            // 1. Собрать данные из формы
            const vent = {};
            for (const key in inputs) {
                const el = inputs[key];
                if (el.type === 'number') vent[key] = parseFloat(el.value) || 0;
                else if (el.type === 'hidden' && (el.value === 'true' || el.value === 'false')) vent[key] = (el.value === 'true');
                else vent[key] = el.value;
            }

            // 2. Вычислить производные (как в compute_derived)
            const dP = (vent.pplat || 0) - (vent.peep || 0);
            const cstat = dP > 0 ? (vent.vt_set / dP) : 1000;
            const resist = Math.max((vent.pip || 0) - (vent.pplat || 0), 0);

            const f = {
                dP: dP,
                cstat: cstat,
                resist: resist,
                auto_peep_flag: (vent.auto_peep || 0) >= 3 || (vent.exp_flow_end || 0) > -0.1,
                sudden_change: ((vent.delta_pip || 0) >= 5) || ((vent.delta_pplat || 0) >= 5),
                leak_flag: (vent.vt_exp < 0.8 * vent.vt_set) || ((vent.leak_pct || 0) > 20),
                sawtooth: (vent.sawtooth_score || 0) >= 0.7,
                low_pf: (vent.pf_ratio && vent.pf_ratio < 200), // pf_ratio не в инпутах, но логика есть
            };

            // 3. Запустить правила (как в diagnose_rules)
            let results = [];

            // Triage: Пневмоторакс
            if (f.sudden_change && vent.pip > 30 && vent.pplat > 28 && vent.spo2_drop && vent.bp_drop) {
                results.push({
                    type: 'alert',
                    label: 'Pneumothorax (High C-ty)',
                    why: ['Sudden ↑PIP/↑Pplat', 'Simultaneous SpO₂/BP drop', 'High resistance and low Cstat'],
                    recommend: ['Immediate assessment/decompression', 'Temporarily reduce PEEP', 'Call surgeon'],
                    score: 0.98
                });
            }

            // Обструкция
            if (resist > 5 && Math.abs(vent.delta_pplat || 0) < 3) {
                let why = [
                    `↑PIP without ↑Pplat (High Resist ≈ ${resist.toFixed(1)})`,
                ];
                if (f.auto_peep_flag) {
                    why.push('Signs of auto-PEEP / incomplete exhalation');
                }
                results.push({
                    type: 'suggest',
                    label: 'Obstruction / Bronchospasm',
                    why: why,
                    recommend: ['Decrease RR, prolong exhalation (I:E 1:3–1:4)', 'Inhaled bronchodilator', 'Check tube/filters'],
                    score: f.auto_peep_flag ? 0.85 : 0.70
                });
            }

            // Низкий комплаенс
            if ((f.dP > 15) || (f.cstat < 30) || f.low_pf) {
                results.push({
                    type: 'suggest',
                    label: 'Decreased Compliance (ARDS/Pneumonia)',
                    why: [`High ΔP (Drive Pressure) ≈ ${f.dP.toFixed(1)}`, `Low Cstat ≈ ${f.cstat.toFixed(1)} mL/cmH₂O`],
                    recommend: ['Vt 4-6 mL/kg IBW', 'Titrate PEEP per tables', 'Consider recruitment maneuvers'],
                    score: 0.75
                });
            }

            // Секреты
            if (f.sawtooth) {
                results.push({
                    type: 'suggest',
                    label: 'Secretions / Tube Obstruction',
                    why: ['"Saw-tooth" flow pattern'],
                    recommend: ['Airway suctioning', 'Check filters'],
                    score: 0.6
                });
            }

            // Утечка
            if (f.leak_flag) {
                results.push({
                    type: 'suggest',
                    label: 'Cuff/Circuit Leak',
                    why: ['Vt_exp ≪ Vt_set', 'Low circuit pressures'],
                    recommend: ['Check cuff', 'Perform leak test'],
                    score: 0.55
                });
            }

            if (results.length === 0) {
                results.push({
                    type: 'suggest',
                    label: 'Unclear / Normal',
                    why: ['No clear pathological patterns'],
                    recommend: ['Continue monitoring', 'Check blood gases'],
                    score: 0.4
                });
            }

            // 4. Сортировка (алерты всегда первые)
            results.sort((a, b) => {
                if (a.type === 'alert' && b.type !== 'alert') return -1;
                if (a.type !== 'alert' && b.type === 'alert') return 1;
                return b.score - a.score;
            });

            return results;
        }

        // === ЛОГИКА UI АНАЛИЗА ===

        buttons.analyze.onclick = () => {
            // 1. Показать "Анализ..."
            analysisUI.ready.classList.add('hidden');
            analysisUI.results.classList.add('hidden');
            analysisUI.processing.classList.remove('hidden');
            addLogEntry("Running AI analysis...", 'info');

            // 2. Симулировать задержку для "эффекта"
            setTimeout(() => {
                const diagnosisResults = runDiagnosis();
                displayResults(diagnosisResults);
                addLogEntry(`Analysis complete. Diagnosis: ${diagnosisResults[0].label}`, 'success');
            }, 1500); // 1.5 секунды на "анализ"
        };

        function displayResults(results) {
            // 1. Скрыть "Анализ...", показать "Результат"
            analysisUI.processing.classList.add('hidden');
            analysisUI.results.classList.remove('hidden');

            const primary = results[0];

            // 2. Показать алерт, если нужно
            if (primary.type === 'alert') {
                analysisUI.alertBanner.classList.remove('hidden');
                analysisUI.container.classList.add('border-2', 'border-red-500');
            } else {
                analysisUI.alertBanner.classList.add('hidden');
                analysisUI.container.classList.remove('border-2', 'border-red-500');
            }

            // 3. Заполнить основной диагноз
            analysisUI.label.textContent = primary.label;
            analysisUI.score.textContent = `${(primary.score * 100).toFixed(0)}%`;

            // 4. Заполнить "Почему?"
            analysisUI.why.innerHTML = primary.why
                .filter(w => w) // Убрать пустые
                .map(item => `<li>${item}</li>`).join('');

            // 5. Заполнить "Что делать?"
            analysisUI.recommend.innerHTML = primary.recommend
                .map(item => `<li><input type="checkbox" class="form-checkbox">${item}</li>`).join('');

            // 6. Заполнить альтернативы
            if (results.length > 1) {
                analysisUI.alternativesContainer.classList.remove('hidden');
                analysisUI.alternatives.innerHTML = results.slice(1, 3) // Показать 2 альт.
                    .map(alt => `<div class="text-center card bg-slate-700 p-2 text-xs"><span class="font-semibold text-slate-300">${alt.label}</span><br><span class="text-cyan-400">${(alt.score * 100).toFixed(0)}%</span></div>`)
                    .join('');
            } else {
                analysisUI.alternativesContainer.classList.add('hidden');
            }
        }

        function resetAnalysisUI() {
            analysisUI.results.classList.add('hidden');
            analysisUI.processing.classList.add('hidden');
            analysisUI.ready.classList.remove('hidden');
            analysisUI.alertBanner.classList.add('hidden');
            analysisUI.container.classList.remove('border-2', 'border-red-500');
        }

        // === ЛОГИКА ЛОГА ===
        function addLogEntry(message, type = 'default') {
            const now = new Date().toLocaleTimeString();
            let colorClass = 'text-slate-400';
            if (type === 'info') colorClass = 'text-cyan-400';
            if (type === 'success') colorClass = 'text-lime-400';
            if (type === 'error') colorClass = 'text-red-400';

            const entry = document.createElement('div');
            entry.innerHTML = `<span class="text-slate-500">${now}</span> &gt; <span class="${colorClass}">${message}</span>`;

            // Удалить "Ожидание", если это первая запись
            const placeholder = eventLog.querySelector('.text-slate-500');
            if (placeholder) placeholder.remove();

            eventLog.prepend(entry);
            // Ограничить кол-во записей
            if (eventLog.children.length > 20) {
                eventLog.removeChild(eventLog.lastChild);
            }
        }

        // === ЛОГИКА ОТРИСОВКИ ВОЛН (CANVAS) ===
        const canvases = {
            pressure: { ctx: document.getElementById('canvas-pressure').getContext('2d'), color: '#34d399' }, // lime-400
            flow: { ctx: document.getElementById('canvas-flow').getContext('2d'), color: '#22d3ee' }, // cyan-400
            volume: { ctx: document.getElementById('canvas-volume').getContext('2d'), color: '#f59e0b' }, // amber-400
        };

        let xPos = 0; // Общая позиция X для всех
        const timeStep = 2; // Пикселей за кадр

        function clearAllCanvases() {
            for (const key in canvases) {
                const c = canvases[key].ctx.canvas;
                canvases[key].ctx.fillStyle = '#111827'; // bg-gray-900
                canvases[key].ctx.fillRect(0, 0, c.width, c.height);
            }
            xPos = 0;
        }

        function drawWaveforms() {
            const w = canvases.pressure.ctx.canvas.width;
            const h = canvases.pressure.ctx.canvas.height;
            const midH = h / 2;

            // "Очистка" путем рисования черной полосы впереди
            const clearW = timeStep + 5;
            for (const key in canvases) {
                canvases[key].ctx.fillStyle = '#000'; // Черный фон холста
                canvases[key].ctx.fillRect(xPos % w, 0, clearW, h);
            }

            // Параметры дыхания
            const totalBreathTime = 400; // ~4 сек @ 60fps (15 RR)
            const inspiratoryTime = totalBreathTime * 0.33; // I:E 1:2
            const t = xPos % totalBreathTime;

            const p = currentWaveParams;

            // 1. Давление (P-t)
            let yP;
            const hP = h * 0.9; // Шкала давления
            if (t < inspiratoryTime) {
                // Вдох (плато)
                const riseTime = inspiratoryTime * 0.2;
                if (t < riseTime) {
                    yP = hP - (t / riseTime) * (p.p_max - p.p_min) * (hP / p.p_max); // Линейный подъем до PIP
                } else {
                    yP = hP - (p.p_plat - p.p_min) * (hP / p.p_max); // Плато
                }
            } else {
                // Выдох
                yP = hP - (p.p_min * (hP / p.p_max)); // PEEP
            }
            yP = h - yP; // Инвертировать
            drawPixel(canvases.pressure.ctx, xPos % w, yP, canvases.pressure.color);

            // 2. Поток (Flow-t)
            let yF;
            const hF = h * 0.45; // Половина шкалы для потока
            if (t < inspiratoryTime) {
                // Вдох (прямоугольный поток)
                yF = midH - (p.f_max / 100) * hF;
            } else {
                // Выдох (экспоненциальный спад)
                const t_exp = t - inspiratoryTime;
                const t_exp_total = totalBreathTime - inspiratoryTime;
                const flow = (p.f_min + (p.f_exp_end - p.f_min) * (t_exp / t_exp_total)) * Math.exp(-t_exp / (t_exp_total / p.exp_curve));
                yF = midH - (flow / 100) * hF;
            }
            drawPixel(canvases.flow.ctx, xPos % w, yF, canvases.flow.color);
            // Нулевая линия для потока
            canvases.flow.ctx.fillStyle = '#475569'; // slate-600
            canvases.flow.ctx.fillRect(xPos % w, midH, timeStep, 1);

            // 3. Объем (V-t)
            let yV;
            const hV = h * 0.9;
            if (t < inspiratoryTime) {
                // Вдох (линейный набор объема)
                yV = hV - (t / inspiratoryTime) * (p.v_max / 500) * hV;
            } else {
                // Выдох
                const t_exp = t - inspiratoryTime;
                const t_exp_total = totalBreathTime - inspiratoryTime;
                const vol = p.v_max * Math.exp(-t_exp / (t_exp_total / (p.exp_curve * 0.8)));
                yV = hV - (vol / 500) * hV;
            }
            yV = h - yV; // Инвертировать
            drawPixel(canvases.volume.ctx, xPos % w, yV, canvases.volume.color);

            xPos += timeStep;
            animationFrameId = requestAnimationFrame(drawWaveforms);
        }

        function drawPixel(ctx, x, y, color) {
            ctx.fillStyle = color;
            ctx.fillRect(x, y, timeStep, 2);
        }

        function resizeCanvases() {
            // Отменить старую анимацию
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
            }

            // Установить размер холста равным его DOM-размеру
            for (const key in canvases) {
                const canvas = canvases[key].ctx.canvas;
                canvas.width = canvas.clientWidth;
                canvas.height = canvas.clientHeight;
            }

            // Очистить и перезапустить
            clearAllCanvases();
            animationFrameId = requestAnimationFrame(drawWaveforms);
        }

        // === ИНИЦИАЛИЗАЦИЯ ===
        window.addEventListener('resize', resizeCanvases);
        resizeCanvases(); // Первый запуск
        loadScenario('normal'); // Загрузить "Норму" при старте
        addLogEntry("RespAI system initialized.", 'success');
    });
</script>
</body>
</html>



