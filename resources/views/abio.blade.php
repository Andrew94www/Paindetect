<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIBioDisk - AI Analyzer</title>
    <!-- Підключення Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Підключення шрифту Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Налаштування шрифту за замовчуванням */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Стилізація кастомного інпуту файлу */
        input[type="file"]::file-selector-button {
            background-color: #3b82f6; /* bg-blue-500 */
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem; /* rounded-md */
            cursor: pointer;
            transition: background-color 0.2s;
        }
        input[type="file"]::file-selector-button:hover {
            background-color: #2563eb; /* bg-blue-600 */
        }

        /* Стилі для S/I/R значків */
        .sir-badge {
            display: inline-block;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px; /* rounded-full */
            text-align: center;
            width: 2.5rem; /* w-10 */
        }
        .sir-s { background-color: #10b981; color: white; } /* bg-emerald-500 */
        .sir-i { background-color: #f59e0b; color: white; } /* bg-amber-500 */
        .sir-r { background-color: #ef4444; color: white; } /* bg-red-500 */
        .sir-none { background-color: #6b7280; color: white; } /* bg-gray-500 */

        /* Анімація завантажувача */
        .loader {
            border: 4px solid #f3f3f3; /* light grey */
            border-top: 4px solid #3b82f6; /* blue */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 2rem auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Простий бар-чарт для метрик */
        .chart-bar {
            transition: width 0.5s ease-in-out;
            text-align: right;
            padding-right: 0.5rem;
            white-space: nowrap;
            color: white;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 p-4 md:p-8">

<div class="max-w-7xl mx-auto">
    <!-- Заголовок -->
    <header class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-white mb-2">AIBioDisk</h1>
        <p class="text-lg text-blue-300">AI-система для кількісного аналізу антибіотикорезистентності</p>
    </header>

    <!-- Основна сітка -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Ліва колонка: Управління та Метрики -->
        <div class="lg:col-span-1 flex flex-col gap-6">

            <!-- Картка: Управління -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 border-b border-gray-700 pb-2">1. Налаштування аналізу</h2>

                <!-- Інпут файлу -->
                <div class="mb-4">
                    <label for="image-upload" class="block text-sm font-medium text-gray-300 mb-2">Завантажте фото чашки Петрі</label>
                    <input id="image-upload" type="file" accept="image/*" class="block w-full text-sm text-gray-400 file:mr-4 file:rounded-md file:border-0 file:bg-blue-500 file:py-2 file:px-4 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-600">
                </div>

                <!-- Вибір мікроорганізму -->
                <div class="mb-4">
                    <label for="species-select" class="block text-sm font-medium text-gray-300 mb-2">Мікроорганізм (для брейкпоінтів)</label>
                    <select id="species-select" class="w-full bg-gray-700 border-gray-600 text-white rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="E.coli">E. coli</option>
                        <option value="S.aureus">S. aureus</option>
                    </select>
                </div>

                <!-- Вибір стандарту -->
                <div class="mb-4">
                    <label for="standard-select" class="block text-sm font-medium text-gray-300 mb-2">Стандарт</label>
                    <select id="standard-select" class="w-full bg-gray-700 border-gray-600 text-white rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="EUCAST">EUCAST</option>
                        <option value="CLSI" disabled>CLSI (демо)</option>
                    </select>
                </div>

                <!-- Кнопка аналізу -->
                <button id="analyze-button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 text-lg">
                    Запустити AI-аналіз
                </button>
            </div>

            <!-- Картка: Метрики роботи -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 border-b border-gray-700 pb-2">Метрики системи</h2>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-700 p-4 rounded-lg text-center">
                        <div id="metric-analyses" class="text-3xl font-bold text-blue-400">0</div>
                        <div class="text-sm text-gray-300">Всього аналізів</div>
                    </div>
                    <div class="bg-gray-700 p-4 rounded-lg text-center">
                        <div id="metric-t-index" class="text-3xl font-bold text-blue-400">0.00</div>
                        <div class="text-sm text-gray-300">Середній T-Індекс</div>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mb-2">Розподіл S/I/R</h3>
                <div id="sir-chart" class="space-y-2">
                    <div class="w-full bg-gray-700 rounded-full h-6">
                        <div id="chart-s" class="chart-bar h-6 rounded-full bg-emerald-500" style="width: 0%">S (0%)</div>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-6">
                        <div id="chart-i" class="chart-bar h-6 rounded-full bg-amber-500" style="width: 0%">I (0%)</div>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-6">
                        <div id="chart-r" class="chart-bar h-6 rounded-full bg-red-500" style="width: 0%">R (0%)</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Права колонка: Результати та Лог -->
        <div class="lg:col-span-2 flex flex-col gap-6">

            <!-- Картка: Результати -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg min-h-[300px]">
                <h2 class="text-2xl font-semibold mb-4 border-b border-gray-700 pb-2">2. Результати аналізу</h2>

                <!-- Повідомлення про помилку -->
                <div id="error-message" class="hidden text-center text-red-400 bg-red-900 p-4 rounded-lg">
                    <p class="font-bold">Помилка</p>
                    <p>Будь ласка, завантажте файл зображення перед початком аналізу.</p>
                </div>

                <!-- Завантажувач -->
                <div id="loader" class="hidden">
                    <div class="loader"></div>
                    <p class="text-center text-gray-300">AI аналізує зображення...</p>
                </div>

                <!-- Контейнер для результатів -->
                <div id="results-container" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Антибіотик</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">D_eff (мм)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">A_eff (мм²)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">A_partial (мм²)</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">T-Індекс</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">E-Індекс</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">S/I/R</th>
                            </tr>
                            </thead>
                            <tbody id="results-table-body" class="bg-gray-800 divide-y divide-gray-700">
                            <!-- Дані будуть вставлені сюди -->
                            </tbody>
                        </table>
                    </div>
                    <div id="results-comments" class="mt-4 p-4 bg-gray-900 rounded-md text-sm text-gray-400 space-y-2">
                        <!-- Коментарі S/I/R будуть тут -->
                    </div>
                </div>
            </div>

            <!-- Картка: AI-Журнал -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-4 border-b border-gray-700 pb-2">AI-Журнал</h2>
                <div class="h-64 bg-gray-900 rounded-md p-4 overflow-y-auto font-mono text-sm text-gray-300">
                    <pre id="ai-log">Система готова. Очікування завантаження файлу...</pre>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // === ГЛОБАЛЬНИЙ СТАН ДОДАТКУ ===
    const appState = {
        metrics: {
            totalAnalyses: 0,
            tIndexSum: 0,
            totalDisks: 0,
            sCount: 0,
            iCount: 0,
            rCount: 0,
        }
    };

    // === БАЗА ДАНИХ БРЕЙКПОІНТІВ (Портовано з Python) ===
    // Це "API", про яке ви питали. Дані про антибіотики вбудовані тут.
    class BreakpointDB {
        constructor() {
            // Ключ: (standard, species, antibiotic)
            this._db = {};
            this._initDemoData();
        }

        _initDemoData() {
            // Демонстраційні дані (НЕ реальні офіційні значення!)
            // Приклади для E. coli
            this._db["EUCAST_E.coli_CIP"] = { s_ge: 25.0, r_lt: 22.0, standard: "EUCAST", comment: "DEMO: Ciprofloxacin, E. coli" };
            this._db["EUCAST_E.coli_CTX"] = { s_ge: 20.0, r_lt: 17.0, standard: "EUCAST", comment: "DEMO: Cefotaxime, E. coli" };
            this._db["EUCAST_E.coli_AMC"] = { s_ge: 18.0, r_lt: 18.0, standard: "EUCAST", comment: "DEMO: Amoxicillin-clavulanic acid, E. coli" };
            this._db["EUCAST_E.coli_OXA"] = { s_ge: null, r_lt: null, standard: "EUCAST", comment: "DEMO: Oxacillin not relevant for E. coli" };


            // Приклади для S. aureus
            this._db["EUCAST_S.aureus_CIP"] = { s_ge: 22.0, r_lt: 19.0, standard: "EUCAST", comment: "DEMO: Ciprofloxacin, S. aureus" };
            this._db["EUCAST_S.aureus_CTX"] = { s_ge: null, r_lt: null, standard: "EUCAST", comment: "DEMO: Cefotaxime not relevant for S. aureus" };
            this._db["EUCAST_S.aureus_OXA"] = { s_ge: 22.0, r_lt: 21.0, standard: "EUCAST", comment: "DEMO: Oxacillin, S. aureus" };
            this._db["EUCAST_S.aureus_AMC"] = { s_ge: 16.0, r_lt: 16.0, standard: "EUCAST", comment: "DEMO: Amoxicillin-clavulanic acid, S. aureus" };
        }

        getBreakpoint(standard, species, ab) {
            const key = `${standard}_${species}_${ab}`;
            return this._db[key] || null;
        }

        interpret(D_eff, standard, species, ab) {
            const bp = this.getBreakpoint(standard, species, ab);
            if (!bp) {
                return { sir: null, comment: `No breakpoint for ${standard}/${species}/${ab}` };
            }

            const { s_ge, r_lt } = bp;
            const d = parseFloat(D_eff.toFixed(1));

            if (s_ge !== null && d >= s_ge) {
                return { sir: "S", comment: `${bp.standard}: D=${d} ≥ ${s_ge} → Sensitive (${bp.comment})` };
            }
            if (r_lt !== null && d < r_lt) {
                return { sir: "R", comment: `${bp.standard}: D=${d} < ${r_lt} → Resistant (${bp.comment})` };
            }
            if (s_ge !== null && r_lt !== null) {
                return { sir: "I", comment: `${bp.standard}: ${r_lt} ≤ D=${d} < ${s_ge} → Intermediate (${bp.comment})` };
            }

            // Випадок, коли S/I/R не визначено (напр., OXA для E.coli)
            return { sir: null, comment: `S/I/R not applicable for ${standard}/${species}/${ab}` };
        }
    }
    const breakpointDB = new BreakpointDB();

    // === DOM ЕЛЕМЕНТИ ===
    document.addEventListener('DOMContentLoaded', () => {
        const analyzeButton = document.getElementById('analyze-button');
        const imageUpload = document.getElementById('image-upload');
        const speciesSelect = document.getElementById('species-select');
        const standardSelect = document.getElementById('standard-select');

        const loader = document.getElementById('loader');
        const errorMessage = document.getElementById('error-message');
        const resultsContainer = document.getElementById('results-container');
        const resultsTableBody = document.getElementById('results-table-body');
        const resultsComments = document.getElementById('results-comments');

        const aiLog = document.getElementById('ai-log');

        // === ЛОГІКА ===

        /**
         * Додає повідомлення до AI-Журналу
         */
        function logAi(message) {
            const timestamp = new Date().toLocaleTimeString();
            aiLog.textContent = `[${timestamp}] ${message}\n` + aiLog.textContent;
        }

        /**
         * Генерує випадкове число у діапазоні
         */
        function random(min, max) {
            return Math.random() * (max - min) + min;
        }

        /**
         * Повертає HTML-значок для S/I/R
         */
        function getSirBadge(sir) {
            if (sir === 'S') return '<span class="sir-badge sir-s">S</span>';
            if (sir === 'I') return '<span class="sir-badge sir-i">I</span>';
            if (sir === 'R') return '<span class="sir-badge sir-r">R</span>';
            return '<span class="sir-badge sir-none">-</span>';
        }

        /**
         * Основна функція запуску аналізу
         */
        analyzeButton.addEventListener('click', () => {
            if (!imageUpload.files || imageUpload.files.length === 0) {
                errorMessage.classList.remove('hidden');
                return;
            }

            // Скидання UI
            errorMessage.classList.add('hidden');
            resultsContainer.classList.add('hidden');
            loader.classList.remove('hidden');
            resultsTableBody.innerHTML = '';
            resultsComments.innerHTML = '';

            const species = speciesSelect.value;
            const standard = standardSelect.value;
            const fileName = imageUpload.files[0].name;

            logAi(`Запуск аналізу для "${fileName}"...`);
            logAi(`Параметри: Вид=${species}, Стандарт=${standard}`);

            // Запуск симуляції AI
            simulateAnalysis(species, standard);
        });

        /**
         * СИМУЛЯЦІЯ AI-АНАЛІЗУ
         */
        function simulateAnalysis(species, standard) {

            const simulationSteps = [
                { delay: 1000, fn: () => logAi("Крок 1/5: Детекція чашки Петрі (HoughCircles)...") },
                { delay: 1500, fn: () => logAi("Крок 2/5: Розрахунок масштабу (S = D_mm / D_px)...") },
                { delay: 2000, fn: () => logAi("Крок 3/5: Детекція дисків (YOLOv8) та OCR...") },
                { delay: 3000, fn: () => logAi("Крок 4/5: Сегментація зон (U-Net) та розрахунок...") },
                { delay: 4000, fn: () => runCalculations(species, standard) },
            ];

            let cumulativeDelay = 0;
            simulationSteps.forEach(step => {
                cumulativeDelay += step.delay;
                setTimeout(step.fn, cumulativeDelay);
            });
        }

        /**
         * СИМУЛЯЦІЯ: Розрахунок метрик
         * Тут генеруються фальшиві дані, які потім ОБРОБЛЯЮТЬСЯ
         * за реальною логікою з вашого документа.
         */
        function runCalculations(species, standard) {
            logAi("Крок 5/5: Інтерпретація результатів...");

            const demoDisks = ["CIP", "CTX", "OXA", "AMC"];
            const results = [];

            demoDisks.forEach(ab => {
                // 1. Генерація "сирих" даних AI (начебто з U-Net)
                // A_eff (чиста зона) - від 50 до 450 мм²
                const A_eff = random(50, 450);
                // A_partial (часткова зона) - від 10 до 150 мм²
                const A_partial = random(10, 150);

                // 2. Розрахунок метрик за вашими формулами
                const A_total_inhibition = A_eff + A_partial;

                // D_eff = 2 * sqrt(A_eff / PI)
                const D_eff = 2 * Math.sqrt(A_eff / Math.PI);
                // D_partial = 2 * sqrt((A_eff + A_partial) / PI)
                const D_partial = 2 * Math.sqrt(A_total_inhibition / Math.PI);

                // E_index = A_eff / (A_eff + A_partial)
                const E_index = (A_total_inhibition > 0) ? (A_eff / A_total_inhibition) : 0;

                // T_index (симуляція) - від 0.3 (погано) до 1.0 (чисто)
                // Робимо його залежним від E_index для реалістичності
                const T_index = E_index * 0.8 + random(0.1, 0.2); // Базовий T-індекс

                // 3. Інтерпретація S/I/R
                const interpretation = breakpointDB.interpret(D_eff, standard, species, ab);

                results.push({
                    ab,
                    D_eff,
                    A_eff,
                    A_partial,
                    T_index: Math.min(1.0, T_index), // обмежуємо 1.0
                    E_index,
                    sir: interpretation.sir,
                    comment: interpretation.comment
                });
            });

            // Відображення результатів
            displayResults(results);
            updateAppMetrics(results);
            logAi("Аналіз завершено. Результати готові.");
        }

        /**
         * Відображення результатів у таблиці
         */
        function displayResults(results) {
            loader.classList.add('hidden');
            resultsContainer.classList.remove('hidden');

            results.forEach(res => {
                const row = document.createElement('tr');
                row.innerHTML = `
                        <td class="px-4 py-3 whitespace-nowrap"><span class="font-bold text-white">${res.ab}</span></td>
                        <td class="px-4 py-3 whitespace-nowrap"><span class="font-semibold text-lg text-blue-300">${res.D_eff.toFixed(1)}</span></td>
                        <td class="px-4 py-3 whitespace-nowrap">${res.A_eff.toFixed(1)}</td>
                        <td class="px-4 py-3 whitespace-nowrap">${res.A_partial.toFixed(1)}</td>
                        <td class="px-4 py-3 whitespace-nowrap">${res.T_index.toFixed(2)}</td>
                        <td class="px-4 py-3 whitespace-nowrap">${res.E_index.toFixed(2)}</td>
                        <td class="px-4 py-3 whitespace-nowrap">${getSirBadge(res.sir)}</td>
                    `;
                resultsTableBody.appendChild(row);

                const commentEl = document.createElement('p');
                commentEl.textContent = `[${res.ab}]: ${res.comment}`;
                resultsComments.appendChild(commentEl);
            });
        }

        /**
         * Оновлення картки "Метрики системи"
         */
        function updateAppMetrics(results) {
            appState.metrics.totalAnalyses++;

            let currentTIndexSum = 0;
            results.forEach(res => {
                currentTIndexSum += res.T_index;
                if (res.sir === 'S') appState.metrics.sCount++;
                if (res.sir === 'I') appState.metrics.iCount++;
                if (res.sir === 'R') appState.metrics.rCount++;
            });

            appState.metrics.totalDisks += results.length;
            appState.metrics.tIndexSum += currentTIndexSum;

            // Оновлення DOM
            document.getElementById('metric-analyses').textContent = appState.metrics.totalAnalyses;

            const avgTIndex = (appState.metrics.totalDisks > 0) ? (appState.metrics.tIndexSum / appState.metrics.totalDisks) : 0;
            document.getElementById('metric-t-index').textContent = avgTIndex.toFixed(2);

            // Оновлення чарту
            const totalSir = appState.metrics.sCount + appState.metrics.iCount + appState.metrics.rCount;
            if (totalSir > 0) {
                const sPerc = (appState.metrics.sCount / totalSir) * 100;
                const iPerc = (appState.metrics.iCount / totalSir) * 100;
                const rPerc = (appState.metrics.rCount / totalSir) * 100;

                const sBar = document.getElementById('chart-s');
                const iBar = document.getElementById('chart-i');
                const rBar = document.getElementById('chart-r');

                sBar.style.width = `${sPerc}%`;
                sBar.textContent = `S (${sPerc.toFixed(0)}%)`;

                iBar.style.width = `${iPerc}%`;
                iBar.textContent = `I (${iPerc.toFixed(0)}%)`;

                rBar.style.width = `${rPerc}%`;
                rBar.textContent = `R (${rPerc.toFixed(0)}%)`;
            }
        }
    });
</script>
</body>
</html>
