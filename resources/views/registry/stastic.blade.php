<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика по госпіталю</title>
    <!-- Підключаємо Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Підключаємо Chart.js для графіків -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-900 min-h-screen text-gray-200 antialiased font-sans pb-12">

<div class="container mx-auto px-4 sm:px-8 max-w-7xl">
    <div class="py-8">
        <!-- Верхня панель -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-gray-800 p-4 rounded-lg shadow-md border border-gray-700">
            <div>
                <h2 class="text-2xl font-bold leading-tight text-white">
                    Аналітика та статистика
                </h2>
                <p class="text-sm text-gray-400 mt-1">Детальний аналіз записів пацієнтів госпіталю</p>
            </div>

            <div>
                <!-- Кнопка назад -->
                <a href="{{ route('registry.list',  ['id' => Auth::guard('hospital')->id() ?? 1]) }}"
                   class="inline-flex justify-center items-center px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg border border-gray-600 shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    До списку пацієнтів
                </a>
            </div>
        </div>

        <!-- Ключові показники (KPIs) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <!-- KPI 1 -->
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Всього пацієнтів</h3>
                <p class="text-2xl font-bold text-white mt-1" id="kpi-total">0</p>
            </div>

            <!-- KPI 2 -->
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-green-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Середній вік</h3>
                <p class="text-2xl font-bold text-green-400 mt-1" id="kpi-age">0</p>
            </div>

            <!-- KPI 3 -->
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-red-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Високий ризик болю</h3>
                <p class="text-2xl font-bold text-red-400 mt-1" id="kpi-pain">0</p>
            </div>

            <!-- KPI 4 -->
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-yellow-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Ризик реабілітації</h3>
                <p class="text-2xl font-bold text-yellow-400 mt-1" id="kpi-rehab">0</p>
            </div>

            <!-- KPI 5 -->
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-purple-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Ризик протезування</h3>
                <p class="text-2xl font-bold text-purple-400 mt-1" id="kpi-pros">0</p>
            </div>
        </div>

        <!-- Графіки Ряд 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Розподіл Ризиків -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Розподіл пацієнтів за рівнем ризику</h3>
                <div class="h-72">
                    <canvas id="risksChart"></canvas>
                </div>
            </div>

            <!-- Основні травми -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Структура основних травм (ICD Codes)</h3>
                <div class="h-72 flex justify-center">
                    <canvas id="traumasChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Графіки Ряд 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Демографія та статус -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <h3 class="text-md font-semibold text-white mb-4 text-center">Статус пацієнтів</h3>
                    <div class="h-56 flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-md font-semibold text-white mb-4 text-center">Механізм травми</h3>
                    <div class="h-56 flex justify-center">
                        <canvas id="mechanismsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Ампутації та протезування -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Рівні ампутацій</h3>
                <div class="h-64">
                    <canvas id="amputationsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Графіки Ряд 3 -->
        <div class="grid grid-cols-1 gap-6 mb-6">
            <!-- Клінічні предиктори -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Частота клінічних предикторів</h3>
                <div class="h-80">
                    <canvas id="predictorsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Графіки Ряд 4 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Фактори інфекції -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Фактори інфекції</h3>
                <div class="h-80">
                    <canvas id="infectionFactorsChart"></canvas>
                </div>
            </div>

            <!-- Хірургічна складність -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Хірургічна складність</h3>
                <div class="h-80">
                    <canvas id="surgicalFactorsChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Блок для безпечної передачі даних з Laravel у JS без помилок SyntaxError у прев'ю -->
<script id="records-data" type="application/json">
    @json($records ?? [])
</script>

<script>
    // Налаштування теми для Chart.js
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.scale.grid.color = '#374151';
    Chart.defaults.plugins.legend.labels.color = '#d1d5db';

    document.addEventListener('DOMContentLoaded', function() {
        let rawRecords = [];

        // --- БЕЗПЕЧНЕ ОТРИМАННЯ ДАНИХ ---
        try {
            const rawText = document.getElementById('records-data').textContent.trim();

            // Якщо ми у середовищі локального прев'ю (Blade не відпрацював)
            if (rawText === '@json($records ?? [])' || rawText === '@json($records)') {
                console.log('Режим прев\'ю: Blade не оброблено, генеруються тестові дані.');
                rawRecords = [
                    {
                        patient_data: { age: 34, status: "military", injury_mechanism: "blast" },
                        icd_codes: { mainTrauma: "S88" },
                        predictors: { amputation: true, infection: true, tourniquet: true },
                        prosthetics_data: { amputation_level: "transtibial", phantom_pain: true, revisions: false },
                        scores: { painScore: 8, rehabScore: 5, prostheticScore: 2 },
                        infection_factors: { mdro: false, npwt: true, openWound: true, openFracture: true },
                        surgical_factors: { osteomyelitis: false, tissueNecrosis: true, woundDehiscence: true }
                    },
                    {
                        patient_data: { age: 28, status: "military", injury_mechanism: "drone" },
                        icd_codes: { mainTrauma: "S02" },
                        predictors: { amputation: false, infection: false, tourniquet: false },
                        scores: { painScore: 4, rehabScore: 2, prostheticScore: 0 },
                        infection_factors: { openWound: true },
                        surgical_factors: null
                    },
                    {
                        patient_data: { age: 45, status: "civilian", injury_mechanism: "blast" },
                        icd_codes: { mainTrauma: "S48" },
                        predictors: { amputation: true, infection: true, tourniquet: false },
                        prosthetics_data: { amputation_level: "upper", phantom_pain: false, revisions: true },
                        scores: { painScore: 6, rehabScore: 8, prostheticScore: 5 },
                        infection_factors: { mdro: true, npwt: false, openWound: true, woundContamination: true },
                        surgical_factors: { osteomyelitis: true, readmission: true, repeatedDebridement: true }
                    }
                ];
            } else if (rawText) {
                // Якщо Blade успішно згенерував JSON
                rawRecords = JSON.parse(rawText);
            }
        } catch (e) {
            console.error('Помилка парсингу даних з Laravel:', e);
        }

        if (!rawRecords || rawRecords.length === 0) {
            console.log('Немає даних для відображення статистики.');
            return;
        }

        // Безпечний парсинг всіх JSON-полів
        const safeParse = (data) => {
            if (!data) return {};
            if (typeof data === 'string') {
                if (data === 'null') return {};
                try {
                    return JSON.parse(data) || {};
                } catch (e) {
                    return {};
                }
            }
            return data;
        };

        const records = rawRecords.map(r => ({
            ...r,
            pat: safeParse(r.patient_data),
            pros: safeParse(r.prosthetics_data),
            icd: safeParse(r.icd_codes),
            pred: safeParse(r.predictors),
            scr: safeParse(r.scores),
            inf: safeParse(r.infection_factors),
            surg: safeParse(r.surgical_factors)
        }));

        // --- 1. ПІДРАХУНОК KPI ---
        const total = records.length;

        const validAges = records.map(r => parseInt(r.pat.age)).filter(a => !isNaN(a));
        const avgAge = validAges.length ? (validAges.reduce((a, b) => a + b, 0) / validAges.length).toFixed(1) : 'Н/Д';

        let highPainCount = 0;
        let highRehabCount = 0;
        let highProsCount = 0;

        records.forEach(r => {
            if ((r.scr.painScore || 0) >= 7) highPainCount++;
            if ((r.scr.rehabScore || 0) >= 7) highRehabCount++;
            if ((r.scr.prostheticScore || 0) >= 4) highProsCount++;
        });

        document.getElementById('kpi-total').textContent = total;
        document.getElementById('kpi-pain').textContent = highPainCount;
        document.getElementById('kpi-rehab').textContent = highRehabCount;
        document.getElementById('kpi-pros').textContent = highProsCount;
        document.getElementById('kpi-age').innerHTML = avgAge + (avgAge !== 'Н/Д' ? ' <span class="text-sm font-medium text-gray-500">років</span>' : '');

        // --- 2. ГРАФІК: РОЗПОДІЛ РИЗИКІВ ---
        const riskData = { pain: [0, 0, 0], rehab: [0, 0, 0], pros: [0, 0, 0] };

        records.forEach(r => {
            let p = parseInt(r.scr.painScore) || 0;
            if (p <= 3) riskData.pain[0]++; else if (p <= 6) riskData.pain[1]++; else riskData.pain[2]++;

            let re = parseInt(r.scr.rehabScore) || 0;
            if (re <= 3) riskData.rehab[0]++; else if (re <= 6) riskData.rehab[1]++; else riskData.rehab[2]++;

            let pr = parseInt(r.scr.prostheticScore) || 0;
            if (pr <= 1) riskData.pros[0]++; else if (pr <= 3) riskData.pros[1]++; else riskData.pros[2]++;
        });

        new Chart(document.getElementById('risksChart'), {
            type: 'bar',
            data: {
                labels: ['Низький', 'Середній', 'Високий'],
                datasets: [
                    { label: 'Біль (CPRS)', data: riskData.pain, backgroundColor: 'rgba(239, 68, 68, 0.7)', borderRadius: 4 },
                    { label: 'Реабілітація', data: riskData.rehab, backgroundColor: 'rgba(234, 179, 8, 0.7)', borderRadius: 4 },
                    { label: 'Протезування', data: riskData.pros, backgroundColor: 'rgba(168, 85, 247, 0.7)', borderRadius: 4 }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } } }
        });

        // --- 3. ГРАФІК: ОСНОВНІ ТРАВМИ ---
        const traumasMap = {};
        records.forEach(r => {
            let t = r.icd.mainTrauma || 'Не вказано';
            traumasMap[t] = (traumasMap[t] || 0) + 1;
        });

        new Chart(document.getElementById('traumasChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(traumasMap),
                datasets: [{
                    data: Object.values(traumasMap),
                    backgroundColor: ['rgba(99, 102, 241, 0.8)', 'rgba(16, 185, 129, 0.8)', 'rgba(245, 158, 11, 0.8)', 'rgba(236, 72, 153, 0.8)', 'rgba(107, 114, 128, 0.8)'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } } }
        });

        // --- 4. ГРАФІК: СТАТУС ПАЦІЄНТІВ ---
        const statusMap = { 'military': 0, 'civilian': 0, 'other': 0 };
        records.forEach(r => {
            let s = r.pat.status || 'other';
            if (statusMap[s] !== undefined) statusMap[s]++; else statusMap['other']++;
        });

        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: ['Військові', 'Цивільні', 'Не вказано'],
                datasets: [{
                    data: [statusMap.military, statusMap.civilian, statusMap.other],
                    backgroundColor: ['rgba(16, 185, 129, 0.8)', 'rgba(56, 189, 248, 0.8)', 'rgba(107, 114, 128, 0.8)'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        // --- 5. ГРАФІК: МЕХАНІЗМ ТРАВМИ ---
        const mechMap = { 'blast': 0, 'drone': 0, 'gunshot': 0, 'other': 0 };
        const mechLabels = { 'blast': 'Вибух', 'drone': 'Дрон/Скид', 'gunshot': 'Вогнепальне', 'other': 'Інше/Не вказано' };
        records.forEach(r => {
            let m = r.pat.injury_mechanism || 'other';
            if (mechMap[m] !== undefined) mechMap[m]++; else mechMap['other']++;
        });

        new Chart(document.getElementById('mechanismsChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(mechMap).map(k => mechLabels[k]),
                datasets: [{
                    data: Object.values(mechMap),
                    backgroundColor: ['rgba(249, 115, 22, 0.8)', 'rgba(139, 92, 246, 0.8)', 'rgba(239, 68, 68, 0.8)', 'rgba(107, 114, 128, 0.8)'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        // --- 6. ГРАФІК: АМПУТАЦІЇ ---
        const ampMap = { 'transfemoral': 0, 'transtibial': 0, 'upper': 0, 'not_specified': 0 };
        const ampLabels = { 'transfemoral': 'Трансфеморальна', 'transtibial': 'Транстибіальна', 'upper': 'Верхня кінцівка', 'not_specified': 'Не вказано рівень' };
        let totalAmputations = 0;

        records.forEach(r => {
            const isAmp = r.pred.amputation === true || r.pred.amputation === 'true' || r.pred.amputation == 1;
            if (isAmp) {
                totalAmputations++;
                let lvl = r.pros.amputation_level || 'not_specified';
                if (ampMap[lvl] !== undefined) ampMap[lvl]++; else ampMap['not_specified']++;
            }
        });

        new Chart(document.getElementById('amputationsChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(ampMap).map(k => ampLabels[k]),
                datasets: [{
                    label: 'Кількість ампутацій',
                    data: Object.values(ampMap),
                    backgroundColor: ['rgba(217, 70, 239, 0.7)', 'rgba(168, 85, 247, 0.7)', 'rgba(99, 102, 241, 0.7)', 'rgba(75, 85, 99, 0.7)'],
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: `Всього пацієнтів з ампутаціями: ${totalAmputations}`, color: '#d1d5db' }
                },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // --- 7. ГРАФІК: КЛІНІЧНІ ПРЕДИКТОРИ ---
        let infectionCount = 0;
        let tourniquetCount = 0;
        let phantomPainCount = 0;
        let revisionCount = 0;

        records.forEach(r => {
            if (r.pred.infection === true || r.pred.infection === 'true' || r.pred.infection == 1) infectionCount++;
            if (r.pred.tourniquet === true || r.pred.tourniquet === 'true' || r.pred.tourniquet == 1) tourniquetCount++;
            if (r.pros.phantom_pain === true || r.pros.phantom_pain === 'true' || r.pros.phantom_pain == 1) phantomPainCount++;
            if (r.pros.revisions === true || r.pros.revisions === 'true' || r.pros.revisions == 1) revisionCount++;
        });

        new Chart(document.getElementById('predictorsChart'), {
            type: 'bar',
            data: {
                labels: ['Використання турнікету', 'Наявність інфекції', 'Фантомний біль', 'Повторні ревізії кукси'],
                datasets: [{
                    label: 'Кількість пацієнтів',
                    data: [tourniquetCount, infectionCount, phantomPainCount, revisionCount],
                    backgroundColor: 'rgba(56, 189, 248, 0.7)',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // --- 8. ГРАФІК: ФАКТОРИ ІНФЕКЦІЇ ---
        const infLabelsMap = {
            'openWound': 'Відкрита рана',
            'woundContamination': 'Забруднення рани',
            'openFracture': 'Відкритий перелом',
            'npwt': 'NPWT',
            'positiveCulture': 'Позитивний посів',
            'mdro': 'MDRO'
        };
        const infData = Object.keys(infLabelsMap).map(k => 0);

        records.forEach(r => {
            if (r.inf && Object.keys(r.inf).length > 0) {
                Object.keys(infLabelsMap).forEach((key, index) => {
                    if (r.inf[key] === true || r.inf[key] === 'true' || r.inf[key] == 1) infData[index]++;
                });
            }
        });

        new Chart(document.getElementById('infectionFactorsChart'), {
            type: 'bar',
            data: {
                labels: Object.values(infLabelsMap),
                datasets: [{
                    label: 'Кількість випадків',
                    data: infData,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)', // Emerald 500
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // --- 9. ГРАФІК: ХІРУРГІЧНА СКЛАДНІСТЬ ---
        const surgLabelsMap = {
            'repeatedDebridement': 'Повторний дебридмент',
            'tissueNecrosis': 'Некроз тканин',
            'woundDehiscence': 'Розходження рани',
            'osteomyelitis': 'Остеомієліт',
            'vascularInjury': 'Судинне ушкодження',
            'flapReconstruction': 'Flap/Реконструкція',
            'readmission': 'Повторна госпіталізація'
        };
        const surgData = Object.keys(surgLabelsMap).map(k => 0);

        records.forEach(r => {
            if (r.surg && Object.keys(r.surg).length > 0) {
                Object.keys(surgLabelsMap).forEach((key, index) => {
                    if (r.surg[key] === true || r.surg[key] === 'true' || r.surg[key] == 1) surgData[index]++;
                });
            }
        });

        new Chart(document.getElementById('surgicalFactorsChart'), {
            type: 'bar',
            data: {
                labels: Object.values(surgLabelsMap),
                datasets: [{
                    label: 'Кількість випадків',
                    data: surgData,
                    backgroundColor: 'rgba(245, 158, 11, 0.7)', // Amber 500
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    });
</script>
</body>
</html>
