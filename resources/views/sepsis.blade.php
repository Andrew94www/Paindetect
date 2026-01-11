<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepsis-3</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- LaTeX Math Rendering (KaTeX) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        slate: {
                            850: '#151e2e',
                            900: '#0f172a',
                            950: '#020617',
                        },
                        medical: {
                            blue: '#3b82f6',
                            red: '#ef4444',
                            green: '#10b981',
                            yellow: '#f59e0b',
                            purple: '#8b5cf6'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #020617;
            color: #e2e8f0;
        }
        .glass-panel {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(148, 163, 184, 0.1);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .input-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 0.25rem;
            display: block;
            font-weight: 600;
        }
        .input-control {
            width: 100%;
            background-color: #0f172a;
            border: 1px solid #334155;
            color: white;
            padding: 0.5rem;
            font-size: 0.9rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
            font-family: 'JetBrains Mono', monospace;
        }
        .input-control:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #020617;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
        .math-formula {
            font-size: 0.9rem;
            color: #cbd5e1;
            padding: 0.5rem;
            background: rgba(0,0,0,0.2);
            border-radius: 0.25rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body class="h-screen flex flex-col md:flex-row overflow-hidden selection:bg-medical-blue selection:text-white">

<!-- SIDEBAR: CLINICAL INPUTS -->
<aside class="w-full md:w-80 bg-slate-900 border-r border-slate-800 flex flex-col h-full overflow-y-auto shrink-0 z-20 shadow-xl">
    <div class="p-5 border-b border-slate-800 bg-slate-900/50 backdrop-blur sticky top-0 z-10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded bg-medical-blue flex items-center justify-center text-white font-bold">
                <i class="fa-solid fa-dna"></i>
            </div>
            <div>
                <h1 class="font-bold text-white tracking-tight leading-tight">Sepsis-3 AI</h1>
                <p class="text-[10px] text-slate-400 font-mono">STANDARDS: SEPSIS-3</p>
            </div>
        </div>
    </div>

    <div class="p-5 space-y-6">

        <!-- Demographics -->
        <div>
            <h3 class="text-xs font-bold text-medical-blue mb-3 uppercase flex items-center gap-2">
                <i class="fa-solid fa-user-tag"></i> Демографія
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="input-label">Вік (років)</label>
                    <input type="number" id="age" value="68" min="18" max="120" class="input-control">
                </div>
                <div>
                    <label class="input-label">Інфекція?</label>
                    <select id="infection_suspected" class="input-control border-l-4 border-l-medical-purple">
                        <option value="0">Ні</option>
                        <option value="1" selected>Так</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Vitals & Hemodynamics -->
        <div>
            <h3 class="text-xs font-bold text-medical-red mb-3 uppercase flex items-center gap-2">
                <i class="fa-solid fa-heart-pulse"></i> Вітальні (qSOFA)
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="input-label">САТ (мм рт.ст.)</label>
                    <input type="number" id="sbp" value="95" class="input-control">
                </div>
                <div>
                    <label class="input-label">ДАТ (мм рт.ст.)</label>
                    <input type="number" id="dbp" value="55" class="input-control">
                </div>
                <div>
                    <label class="input-label">ЧСС (уд/хв)</label>
                    <input type="number" id="hr" value="112" class="input-control">
                </div>
                <div>
                    <label class="input-label">ЧД (рух/хв)</label>
                    <input type="number" id="rr" value="24" class="input-control text-medical-red">
                </div>
            </div>
            <div class="mt-3">
                <label class="input-label">ШКГ (Свідомість)</label>
                <select id="gcs" class="input-control">
                    <option value="15">15 (Ясна)</option>
                    <option value="13" selected>13-14 (Сплутана)</option>
                    <option value="10">10-12</option>
                    <option value="6">6-9</option>
                    <option value="3">< 6</option>
                </select>
            </div>
        </div>

        <!-- Organ Dysfunction (SOFA) -->
        <div>
            <h3 class="text-xs font-bold text-medical-yellow mb-3 uppercase flex items-center gap-2">
                <i class="fa-solid fa-flask"></i> Лабораторні (SOFA)
            </h3>
            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="input-label">PaO2/FiO2</label>
                        <input type="number" id="pao2_fio2" value="250" class="input-control" placeholder="Індекс">
                    </div>
                    <div>
                        <label class="input-label">Тромбоцити</label>
                        <input type="number" id="platelets" value="130" class="input-control" placeholder="x10^9/L">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="input-label">Білірубін</label>
                        <input type="number" id="bilirubin" value="1.8" step="0.1" class="input-control" placeholder="мг/дл">
                    </div>
                    <div>
                        <label class="input-label">Креатинін</label>
                        <input type="number" id="creatinine" value="1.5" step="0.1" class="input-control" placeholder="мг/дл">
                    </div>
                </div>
            </div>
        </div>

        <!-- Shock Markers -->
        <div>
            <h3 class="text-xs font-bold text-white mb-3 uppercase flex items-center gap-2">
                <i class="fa-solid fa-bolt"></i> Маркери шоку
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="input-label">Лактат (ммоль/л)</label>
                    <input type="number" id="lactate" value="3.5" step="0.1" class="input-control text-medical-red">
                </div>
                <div>
                    <label class="input-label">Вазопресори?</label>
                    <select id="vasopressors" class="input-control">
                        <option value="0">Ні</option>
                        <option value="1" selected>Так</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="flex-1 flex flex-col h-full relative overflow-y-auto bg-slate-950">

    <!-- Top Bar -->
    <header class="p-6 border-b border-slate-800 flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-bold text-white">Панель Аналізу Пацієнта</h2>
            <div class="flex items-center gap-2 text-slate-400 text-sm mt-1">
                <span class="bg-slate-800 px-2 py-0.5 rounded text-xs font-mono">ID: PT-8392</span>
                <span>&bull;</span>
                <span>Стратифікація ризику в реальному часі</span>
            </div>
        </div>
        <button onclick="calculateMetrics()" class="bg-medical-blue hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded shadow-lg shadow-blue-500/20 transition-all flex items-center gap-2">
            <i class="fa-solid fa-rotate"></i> Оновити Розрахунок
        </button>
    </header>

    <div class="p-6 space-y-6">

        <!-- DIAGNOSTIC ALERTS (Top Priority) -->
        <div id="diagnostic_panel" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Filled via JS -->
        </div>

        <!-- MATHEMATICAL METRICS ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">

            <!-- Mortality Prediction Card -->
            <div class="glass-panel p-5 col-span-1 lg:col-span-2 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="fa-solid fa-brain text-6xl text-white"></i>
                </div>
                <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Ймовірність Летальності</h4>

                <div class="flex items-end gap-4 mt-2">
                    <span id="mortality_display" class="text-5xl font-bold text-white">--%</span>
                    <div id="mortality_badge" class="px-3 py-1 rounded bg-slate-700 text-xs text-white mb-2">Розрахунок...</div>
                </div>

                <!-- Math Visualization -->
                <div class="mt-4 p-3 bg-slate-900/80 rounded border border-slate-800">
                    <p class="text-xs text-slate-500 mb-1 font-mono">ЛОГІСТИЧНА РЕГРЕСІЯ:</p>
                    <div id="formula_logit" class="math-formula text-xs overflow-x-auto whitespace-nowrap">
                        $$ P(x) = \frac{1}{1 + e^{-(\beta_0 + \beta_1 \cdot SOFA + \beta_2 \cdot Вік + ...)}} $$
                    </div>
                </div>
            </div>

            <!-- Hemodynamics Card -->
            <div class="glass-panel p-5 col-span-1">
                <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Гемодинаміка (Формули)</h4>

                <div class="mt-4 space-y-4">
                    <div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">САД (Середній)</span>
                            <span id="val_map" class="font-mono text-medical-blue font-bold">--</span>
                        </div>
                        <div class="text-[10px] text-slate-500 font-mono mt-0.5">$$ (САТ + 2 \cdot ДАТ) / 3 $$</div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400">Шоковий Індекс</span>
                            <span id="val_si" class="font-mono text-medical-red font-bold">--</span>
                        </div>
                        <div class="text-[10px] text-slate-500 font-mono mt-0.5">$$ ЧСС / САТ $$ (Норма: 0.5-0.7)</div>
                    </div>
                </div>
            </div>

            <!-- Scores Card -->
            <div class="glass-panel p-5 col-span-1">
                <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Клінічні Шкали</h4>

                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between p-2 bg-slate-800/50 rounded">
                        <span class="text-sm font-semibold">qSOFA</span>
                        <span id="score_qsofa" class="text-xl font-bold font-mono">--</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-slate-800/50 rounded">
                        <span class="text-sm font-semibold">SOFA Загальна</span>
                        <span id="score_sofa" class="text-xl font-bold font-mono text-medical-yellow">--</span>
                    </div>
                    <div class="text-[10px] text-slate-500 text-center mt-2">
                        $\Delta$SOFA $\ge 2$ вказує на органну дисфункцію
                    </div>
                </div>
            </div>
        </div>

        <!-- CHARTS ROW -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Radar Chart: Organ Dysfunction -->
            <div class="glass-panel p-5 col-span-1">
                <h3 class="text-sm font-bold text-white mb-4"><i class="fa-solid fa-chart-radar mr-2 text-medical-purple"></i>Профіль Органів (SOFA)</h3>
                <div class="relative h-64">
                    <canvas id="sofaRadarChart"></canvas>
                </div>
            </div>

            <!-- Main Explanation / Trend -->
            <div class="glass-panel p-5 col-span-1 lg:col-span-2">
                <h3 class="text-sm font-bold text-white mb-4"><i class="fa-solid fa-chart-line mr-2 text-medical-blue"></i>Зв'язок Лактату та Летальності</h3>
                <div class="flex h-64 gap-4">
                    <div class="w-2/3 h-full relative">
                        <canvas id="trendChart"></canvas>
                    </div>
                    <div class="w-1/3 h-full flex flex-col justify-center space-y-4 border-l border-slate-800 pl-4">
                        <div class="p-3 bg-red-500/10 border border-red-500/20 rounded">
                            <h5 class="text-xs text-medical-red font-bold uppercase">Септичний Шок (Критерії)</h5>
                            <ul class="text-[10px] text-slate-300 list-disc ml-3 mt-1 space-y-1">
                                <li>Вазопресори для САД $\ge 65$</li>
                                <li>Лактат $> 2$ ммоль/л</li>
                            </ul>
                            <div id="shock_status" class="mt-2 text-xs font-bold text-center bg-slate-900 py-1 rounded">--</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="p-4 text-center text-slate-600 text-[10px] font-mono border-t border-slate-900">
    </footer>
</main>

<script>
    // --- State & Chart Instances ---
    let sofaRadarChart = null;
    let trendChart = null;

    // --- On Load ---
    document.addEventListener('DOMContentLoaded', () => {
        // Render Math
        renderMathInElement(document.body, {
            delimiters: [
                {left: '$$', right: '$$', display: true},
                {left: '$', right: '$', display: false}
            ]
        });

        // Event Listeners for inputs
        document.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('input', calculateMetrics);
        });

        // Initial Calculation
        calculateMetrics();
    });

    // --- Core Logic ---
    function calculateMetrics() {
        // 1. Get Values
        const inputs = {
            age: parseFloat(document.getElementById('age').value),
            infection: document.getElementById('infection_suspected').value === "1",
            sbp: parseFloat(document.getElementById('sbp').value),
            dbp: parseFloat(document.getElementById('dbp').value),
            hr: parseFloat(document.getElementById('hr').value),
            rr: parseFloat(document.getElementById('rr').value),
            gcs: parseFloat(document.getElementById('gcs').value),
            pao2_fio2: parseFloat(document.getElementById('pao2_fio2').value),
            platelets: parseFloat(document.getElementById('platelets').value),
            bilirubin: parseFloat(document.getElementById('bilirubin').value),
            creatinine: parseFloat(document.getElementById('creatinine').value),
            lactate: parseFloat(document.getElementById('lactate').value),
            vasopressors: document.getElementById('vasopressors').value === "1"
        };

        // 2. Hemodynamic Calculations
        const map = (inputs.sbp + (2 * inputs.dbp)) / 3;
        const shockIndex = inputs.hr / inputs.sbp;

        document.getElementById('val_map').innerText = map.toFixed(0) + " мм рт.ст.";
        document.getElementById('val_si').innerText = shockIndex.toFixed(2);

        // 3. qSOFA Calculation (Screening)
        // Criteria: RR >= 22, Altered Mentation (GCS < 15), SBP <= 100
        let qsofaScore = 0;
        if(inputs.rr >= 22) qsofaScore++;
        if(inputs.gcs < 15) qsofaScore++;
        if(inputs.sbp <= 100) qsofaScore++;

        document.getElementById('score_qsofa').innerText = qsofaScore + "/3";

        // 4. SOFA Score Calculation (Detailed)
        // Simplified Logic based on Sepsis-3 tables
        let sofa = { total: 0, resp: 0, coag: 0, liver: 0, cardio: 0, cns: 0, renal: 0 };

        // Respiration (PaO2/FiO2)
        if(inputs.pao2_fio2 < 100) sofa.resp = 4;
        else if(inputs.pao2_fio2 < 200) sofa.resp = 3;
        else if(inputs.pao2_fio2 < 300) sofa.resp = 2;
        else if(inputs.pao2_fio2 < 400) sofa.resp = 1;

        // Coagulation (Platelets)
        if(inputs.platelets < 20) sofa.coag = 4;
        else if(inputs.platelets < 50) sofa.coag = 3;
        else if(inputs.platelets < 100) sofa.coag = 2;
        else if(inputs.platelets < 150) sofa.coag = 1;

        // Liver (Bilirubin)
        if(inputs.bilirubin > 12.0) sofa.liver = 4;
        else if(inputs.bilirubin > 6.0) sofa.liver = 3;
        else if(inputs.bilirubin > 2.0) sofa.liver = 2;
        else if(inputs.bilirubin > 1.2) sofa.liver = 1;

        // Cardiovascular (MAP & Meds)
        if(inputs.vasopressors) sofa.cardio = 3; // Simplified: assuming low dose
        else if(map < 70) sofa.cardio = 1;

        // CNS (GCS)
        if(inputs.gcs < 6) sofa.cns = 4;
        else if(inputs.gcs < 10) sofa.cns = 3;
        else if(inputs.gcs < 13) sofa.cns = 2;
        else if(inputs.gcs < 15) sofa.cns = 1;

        // Renal (Creatinine)
        if(inputs.creatinine > 5.0) sofa.renal = 4;
        else if(inputs.creatinine > 3.5) sofa.renal = 3;
        else if(inputs.creatinine > 2.0) sofa.renal = 2;
        else if(inputs.creatinine > 1.2) sofa.renal = 1;

        sofa.total = sofa.resp + sofa.coag + sofa.liver + sofa.cardio + sofa.cns + sofa.renal;
        document.getElementById('score_sofa').innerText = sofa.total;

        // 5. Determine Clinical Status (Sepsis-3 Definitions)
        let status = "Норма";
        let statusColor = "bg-slate-700 border-slate-600";
        let message = "Значущої органної дисфункції не виявлено.";

        // Sepsis: Infection + SOFA >= 2
        const isSepsis = inputs.infection && sofa.total >= 2;

        // Septic Shock: Sepsis + Vasopressors + Lactate > 2
        const isSepticShock = isSepsis && inputs.vasopressors && inputs.lactate > 2;

        if (isSepticShock) {
            status = "СЕПТИЧНИЙ ШОК";
            statusColor = "bg-red-900/40 border-red-500 text-red-200";
            message = "КРИТИЧНО: Стійка гіпотензія, потреба у вазопресорах та Лактат > 2. Ризик летальності >40%.";
        } else if (isSepsis) {
            status = "СЕПСИС";
            statusColor = "bg-orange-900/40 border-orange-500 text-orange-200";
            message = "УВАГА: Інфекція з життєзагрозливою органною дисфункцією (SOFA ≥ 2).";
        } else if (inputs.infection) {
            status = "Інфекція (Неускладнена)";
            statusColor = "bg-blue-900/40 border-blue-500 text-blue-200";
            message = "Підозра на інфекцію, але органної недостатності (SOFA) не виявлено.";
        }

        // 6. AI Mortality Prediction (Simulated Logistic Regression)
        // Intercept + w1*SOFA + w2*Age + w3*Lactate + w4*ShockIndex
        let logit = -6.5 + (0.35 * sofa.total) + (0.04 * inputs.age) + (0.5 * inputs.lactate) + (1.5 * shockIndex);
        if(inputs.vasopressors) logit += 1.2;

        const probability = 1 / (1 + Math.exp(-logit));
        const percentage = (probability * 100).toFixed(1);

        // Update UI
        updateDiagnosticPanel(status, statusColor, message);
        updateMortalityUI(percentage);
        updateShockStatus(isSepticShock);

        // Update Charts
        updateCharts(sofa, inputs, percentage);
    }

    function updateDiagnosticPanel(title, colorClass, msg) {
        const panel = document.getElementById('diagnostic_panel');
        panel.innerHTML = `
            <div class="col-span-1 md:col-span-3 border p-4 rounded-lg flex items-start gap-4 ${colorClass}">
                <div class="mt-1 text-2xl"><i class="fa-solid fa-notes-medical"></i></div>
                <div>
                    <h3 class="font-bold text-lg uppercase tracking-wide">${title}</h3>
                    <p class="text-sm opacity-90">${msg}</p>
                </div>
            </div>
        `;
    }

    function updateMortalityUI(pct) {
        const display = document.getElementById('mortality_display');
        const badge = document.getElementById('mortality_badge');

        display.innerText = `${pct}%`;

        // Color coding for risk
        if(pct > 50) {
            display.className = "text-5xl font-bold text-medical-red";
            badge.className = "px-3 py-1 rounded bg-red-500 text-white font-bold mb-2 animate-pulse";
            badge.innerText = "ВИСОКИЙ РИЗИК";
        } else if (pct > 20) {
            display.className = "text-5xl font-bold text-medical-yellow";
            badge.className = "px-3 py-1 rounded bg-yellow-600 text-white font-bold mb-2";
            badge.innerText = "СЕРЕДНІЙ РИЗИК";
        } else {
            display.className = "text-5xl font-bold text-medical-green";
            badge.className = "px-3 py-1 rounded bg-green-600 text-white font-bold mb-2";
            badge.innerText = "НИЗЬКИЙ РИЗИК";
        }
    }

    function updateShockStatus(isShock) {
        const el = document.getElementById('shock_status');
        if(isShock) {
            el.innerHTML = "<i class='fa-solid fa-circle-exclamation mr-1'></i> КРИТЕРІЇ ВИКОНАНІ";
            el.className = "mt-2 text-xs font-bold text-center bg-red-600 text-white py-1 rounded";
        } else {
            el.innerHTML = "КРИТЕРІЇ НЕ ВИКОНАНІ";
            el.className = "mt-2 text-xs font-bold text-center bg-slate-800 text-slate-400 py-1 rounded";
        }
    }

    // --- Chart.js Functions ---
    function updateCharts(sofa, inputs, risk) {
        updateRadar(sofa);
        updateTrend(inputs.lactate, risk);
    }

    function updateRadar(sofa) {
        const ctx = document.getElementById('sofaRadarChart').getContext('2d');
        const dataValues = [sofa.resp, sofa.cardio, sofa.cns, sofa.renal, sofa.liver, sofa.coag];

        if(sofaRadarChart) {
            sofaRadarChart.data.datasets[0].data = dataValues;
            sofaRadarChart.update();
            return;
        }

        sofaRadarChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Дихання (PaO2)', 'Гемодинаміка', 'ЦНС (ШКГ)', 'Нирки (Кр)', 'Печінка', 'Коагуляція'],
                datasets: [{
                    label: 'Бал дисфункції (0-4)',
                    data: dataValues,
                    backgroundColor: 'rgba(59, 130, 246, 0.4)',
                    borderColor: '#3b82f6',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: '#334155' },
                        grid: { color: '#334155' },
                        pointLabels: { color: '#cbd5e1', font: {size: 10, family: 'Inter'} },
                        suggestedMin: 0,
                        suggestedMax: 4,
                        ticks: { backdropColor: 'transparent', color: '#94a3b8' }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    function updateTrend(currentLactate, currentRisk) {
        const ctx = document.getElementById('trendChart').getContext('2d');

        let projectedLactate = Math.max(0.5, currentLactate * 0.8);

        if(trendChart) {
            trendChart.data.datasets[0].data = [currentLactate, projectedLactate];
            trendChart.data.datasets[1].data = [currentRisk, currentRisk * 0.9];
            trendChart.update();
            return;
        }

        trendChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Поточний', 'Прогноз (6г)'],
                datasets: [
                    {
                        label: 'Лактат (ммоль/л)',
                        data: [currentLactate, projectedLactate],
                        backgroundColor: '#ef4444',
                        yAxisID: 'y',
                        barPercentage: 0.5
                    },
                    {
                        label: 'Ризик смертності (%)',
                        type: 'line',
                        data: [currentRisk, currentRisk * 0.9],
                        borderColor: '#fbbf24',
                        backgroundColor: '#fbbf24',
                        yAxisID: 'y1',
                        borderWidth: 2,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Лактат (ммоль/л)', color: '#94a3b8' },
                        grid: { color: '#334155' },
                        ticks: { color: '#94a3b8' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Ризик (%)', color: '#fbbf24' },
                        grid: { drawOnChartArea: false },
                        ticks: { color: '#fbbf24' },
                        suggestedMax: 100
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#cbd5e1' }
                    }
                }
            }
        });
    }
</script>
</body>
</html>
