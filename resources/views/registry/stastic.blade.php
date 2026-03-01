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
{{--                <a href="{{ route('registry.index') }}"--}}
                <a href="{{ route('registry.list',  ['id' => Auth::guard('hospital')->id()]) }}"
                   class="inline-flex justify-center items-center px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg border border-gray-600 shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    До списку пацієнтів
                </a>
            </div>
        </div>

        <!-- Ключові показники (KPIs) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- KPI 1 -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <h3 class="text-sm font-medium text-gray-400">Всього пацієнтів</h3>
                <p class="text-3xl font-bold text-white mt-2" id="kpi-total">0</p>
            </div>

            <!-- KPI 2 -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-red-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-sm font-medium text-gray-400">Високий ризик болю (≥7)</h3>
                <p class="text-3xl font-bold text-red-400 mt-2" id="kpi-pain">0</p>
            </div>

            <!-- KPI 3 -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-yellow-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-sm font-medium text-gray-400">Високий ризик реабілітації (≥7)</h3>
                <p class="text-3xl font-bold text-yellow-400 mt-2" id="kpi-rehab">0</p>
            </div>

            <!-- KPI 4 -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 mt-4 mr-4 text-green-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-sm font-medium text-gray-400">Середній вік</h3>
                <p class="text-3xl font-bold text-green-400 mt-2" id="kpi-age">0 <span class="text-lg font-medium text-gray-500">років</span></p>
            </div>
        </div>

        <!-- Графіки -->
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

        <div class="grid grid-cols-1 gap-6">
            <!-- Клінічні предиктори -->
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Частота клінічних предикторів</h3>
                <div class="h-80">
                    <canvas id="predictorsChart"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Налаштування теми для Chart.js (світлі шрифти для темного фону)
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.scale.grid.color = '#374151';
    Chart.defaults.plugins.legend.labels.color = '#d1d5db';

    // --- ДАНІ З LARAVEL ---
    // Отримуємо колекцію $records з бекенду (передану через compact('records'))
    const rawRecords = @json($records);

    document.addEventListener('DOMContentLoaded', function() {
        // Запобіжник: якщо даних немає, ініціалізуємо порожній масив
        if (!rawRecords || rawRecords.length === 0) {
            console.log('Немає даних для відображення статистики.');
            return;
        }

        // Безпечний парсинг JSON-полів, якщо вони приходять як строки
        const records = rawRecords.map(r => ({
            ...r,
            icd: typeof r.icd_codes === 'string' ? JSON.parse(r.icd_codes || '{}') : (r.icd_codes || {}),
            pred: typeof r.predictors === 'string' ? JSON.parse(r.predictors || '{}') : (r.predictors || {}),
            scr: typeof r.scores === 'string' ? JSON.parse(r.scores || '{}') : (r.scores || {})
        }));

        // --- 1. ПІДРАХУНОК KPI ---
        const total = records.length;

        // Вік
        const validAges = records.map(r => parseInt(r.age)).filter(a => !isNaN(a));
        const avgAge = validAges.length ? (validAges.reduce((a, b) => a + b, 0) / validAges.length).toFixed(1) : 'Н/Д';

        // Ризики (Високий >= 7)
        let highPainCount = 0;
        let highRehabCount = 0;

        records.forEach(r => {
            if ((r.scr.painScore || 0) >= 7) highPainCount++;
            if ((r.scr.rehabScore || 0) >= 7) highRehabCount++;
        });

        // Оновлення DOM
        document.getElementById('kpi-total').textContent = total;
        document.getElementById('kpi-pain').textContent = highPainCount;
        document.getElementById('kpi-rehab').textContent = highRehabCount;
        document.getElementById('kpi-age').innerHTML = avgAge + (avgAge !== 'Н/Д' ? ' <span class="text-lg font-medium text-gray-500">років</span>' : '');

        // --- 2. ГРАФІК: РОЗПОДІЛ РИЗИКІВ ---
        // Категорії: Низький (0-3), Середній (4-6), Високий (7-10)
        const riskData = {
            pain: [0, 0, 0],
            rehab: [0, 0, 0]
        };

        records.forEach(r => {
            let p = parseInt(r.scr.painScore) || 0;
            if (p <= 3) riskData.pain[0]++; else if (p <= 6) riskData.pain[1]++; else riskData.pain[2]++;

            let re = parseInt(r.scr.rehabScore) || 0;
            if (re <= 3) riskData.rehab[0]++; else if (re <= 6) riskData.rehab[1]++; else riskData.rehab[2]++;
        });

        new Chart(document.getElementById('risksChart'), {
            type: 'bar',
            data: {
                labels: ['Низький (0-3)', 'Середній (4-6)', 'Високий (7-10)'],
                datasets: [
                    {
                        label: 'Біль (CPRS)',
                        data: riskData.pain,
                        backgroundColor: 'rgba(239, 68, 68, 0.7)', // Red
                        borderRadius: 4
                    },
                    {
                        label: 'Реабілітація',
                        data: riskData.rehab,
                        backgroundColor: 'rgba(234, 179, 8, 0.7)', // Yellow
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } }
            }
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
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.8)', // Indigo
                        'rgba(16, 185, 129, 0.8)', // Emerald
                        'rgba(245, 158, 11, 0.8)', // Amber
                        'rgba(236, 72, 153, 0.8)', // Pink
                        'rgba(107, 114, 128, 0.8)' // Gray
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });

        // --- 4. ГРАФІК: КЛІНІЧНІ ПРЕДИКТОРИ ---
        let infectionCount = 0;
        let amputationCount = 0;
        let tourniquetCount = 0;

        records.forEach(r => {
            // Врахування як boolean true/false, так і стрічкових 'true'/'false' та '1'/'0'
            const hasInfection = r.pred.infection === true || r.pred.infection === 'true' || r.pred.infection == 1;
            const hasAmputation = r.pred.amputation === true || r.pred.amputation === 'true' || r.pred.amputation == 1;
            const hasTourniquet = r.pred.tourniquet === true || r.pred.tourniquet === 'true' || r.pred.tourniquet == 1;

            if (hasInfection) infectionCount++;
            if (hasAmputation) amputationCount++;
            if (hasTourniquet) tourniquetCount++;
        });

        new Chart(document.getElementById('predictorsChart'), {
            type: 'bar',
            data: {
                labels: ['Наявність інфекції', 'Ампутація', 'Використання турнікету'],
                datasets: [{
                    label: 'Кількість пацієнтів',
                    data: [infectionCount, amputationCount, tourniquetCount],
                    backgroundColor: 'rgba(56, 189, 248, 0.7)', // Sky blue
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // Робимо графік горизонтальним
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    });
</script>
</body>
</html>
