<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детальна аналітика та маршрутизація</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-900 min-h-screen text-gray-200 antialiased font-sans pb-12">

<div class="container mx-auto px-4 sm:px-8 max-w-7xl">
    <div class="py-8">
        <!-- Верхня панель -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-gray-800 p-4 rounded-lg shadow-md border border-gray-700">
            <div>
                <h2 class="text-2xl font-bold leading-tight text-white">
                    Глобальна аналітика та маршрутизація
                </h2>
                <p class="text-sm text-gray-400 mt-1">Детальний аналіз мережі госпіталів та профілювання пацієнтів</p>
            </div>

            <div>
                <a href="#" onclick="history.back()"
                   class="inline-flex justify-center items-center px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg border border-gray-600 shadow-sm transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Назад
                </a>
            </div>
        </div>

        <!-- ПРОФІЛЮВАННЯ ТА РЕКОМЕНДАЦІЇ ДЛЯ КОЖНОГО ГОСПІТАЛЮ -->
        <div class="mb-12">
            <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">
                Спеціалізація госпіталів (Рекомендації для направлення)
            </h3>
            <p class="text-sm text-gray-400 mb-6">Динамічний аналіз домінуючих патологій, що формує індивідуальний цільовий профіль пацієнта для кожного закладу.</p>

            <!-- Контейнер для карток госпіталів (генерується через JS) -->
            <div id="hospitals-profile-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Картки будуть додані сюди -->
            </div>
        </div>

        <h3 class="text-xl font-bold text-white mb-6 border-b border-gray-700 pb-2">Розширена зведена статистика по всій мережі</h3>

        <!-- Ключові показники (KPIs) - 2 ряди -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <!-- Ряд 1 -->
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Всього пацієнтів</h3>
                <p class="text-2xl font-bold text-white mt-1" id="kpi-total">0</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Середній вік</h3>
                <p class="text-2xl font-bold text-green-400 mt-1" id="kpi-age">0</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Військовослужбовці</h3>
                <p class="text-2xl font-bold text-blue-400 mt-1" id="kpi-military">0%</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Мінно-вибухові</h3>
                <p class="text-2xl font-bold text-orange-400 mt-1" id="kpi-blast">0%</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Сер. бал болю</h3>
                <p class="text-2xl font-bold text-red-400 mt-1" id="kpi-avg-pain">0</p>
            </div>

            <!-- Ряд 2 -->
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Високий ризик болю</h3>
                <p class="text-2xl font-bold text-red-500 mt-1" id="kpi-pain">0</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Важка реабілітація</h3>
                <p class="text-2xl font-bold text-yellow-400 mt-1" id="kpi-rehab">0</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Виконано ампутацій</h3>
                <p class="text-2xl font-bold text-purple-400 mt-1" id="kpi-amputations">0</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Складні інфекції</h3>
                <p class="text-2xl font-bold text-emerald-400 mt-1" id="kpi-infections">0</p>
            </div>
            <div class="bg-gray-800 rounded-xl p-5 border border-gray-700 shadow-lg relative overflow-hidden">
                <h3 class="text-xs font-medium text-gray-400 uppercase tracking-wider">Реконструкцій/Клаптів</h3>
                <p class="text-2xl font-bold text-amber-400 mt-1" id="kpi-surgeries">0</p>
            </div>
        </div>

        <!-- Графіки Ряд 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Розподіл пацієнтів за рівнем ризику</h3>
                <div class="h-72"><canvas id="risksChart"></canvas></div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Структура основних травм (МКХ-10)</h3>
                <div class="h-72 flex justify-center"><canvas id="traumasChart"></canvas></div>
            </div>
        </div>

        <!-- Графіки Ряд 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <h3 class="text-md font-semibold text-white mb-4 text-center">Статус пацієнтів</h3>
                    <div class="h-56 flex justify-center"><canvas id="statusChart"></canvas></div>
                </div>
                <div class="flex-1">
                    <h3 class="text-md font-semibold text-white mb-4 text-center">Механізм травми</h3>
                    <div class="h-56 flex justify-center"><canvas id="mechanismsChart"></canvas></div>
                </div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Рівні ампутацій</h3>
                <div class="h-64"><canvas id="amputationsChart"></canvas></div>
            </div>
        </div>

        <!-- Графіки Ряд 3 та 4 -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Клінічні предиктори</h3>
                <div class="h-80"><canvas id="predictorsChart"></canvas></div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Фактори інфекції</h3>
                <div class="h-80"><canvas id="infectionFactorsChart"></canvas></div>
            </div>
            <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 shadow-lg">
                <h3 class="text-lg font-semibold text-white mb-4">Хірургічна складність</h3>
                <div class="h-80"><canvas id="surgicalFactorsChart"></canvas></div>
            </div>
        </div>

    </div>
</div>

<!-- Зберігаємо масив госпіталів -->
<script id="hospitals-data" type="application/json">
    @json($hospitals ?? [])
</script>

<script>
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.scale.grid.color = '#374151';
    Chart.defaults.plugins.legend.labels.color = '#d1d5db';

    document.addEventListener('DOMContentLoaded', function() {
        let rawHospitals = [];
        try {
            const rawText = document.getElementById('hospitals-data').textContent.trim();
            if (rawText && rawText !== '@json($hospitals ?? [])' && rawText !== '@json($hospitals)') {
                rawHospitals = JSON.parse(rawText);
            }
        } catch (e) {
            console.error('Помилка парсингу даних:', e);
        }

        if (!rawHospitals || rawHospitals.length === 0) return;

        const safeParse = (data) => {
            if (!data) return {};
            if (typeof data === 'string') {
                if (data === 'null') return {};
                try { return JSON.parse(data) || {}; } catch (e) { return {}; }
            }
            return data;
        };

        let allRecords = [];
        const profilesContainer = document.getElementById('hospitals-profile-container');
        profilesContainer.innerHTML = '';

        // --- ОБРОБКА КОЖНОГО ГОСПІТАЛЮ ТА СТВОРЕННЯ ДЕТАЛІЗОВАНИХ КАРТОК ---
        rawHospitals.forEach(hospital => {
            const hospitalRecords = (hospital.records || []).map(r => ({
                pat: safeParse(r.patient_data),
                pros: safeParse(r.prosthetics_data),
                icd: safeParse(r.icd_codes),
                pred: safeParse(r.predictors),
                scr: safeParse(r.scores),
                inf: safeParse(r.infection_factors),
                surg: safeParse(r.surgical_factors)
            }));

            allRecords.push(...hospitalRecords);

            const total = hospitalRecords.length;
            if (total === 0) return; // Пропускаємо порожні госпіталі

            let counts = { amputation: 0, infection: 0, complex_surgery: 0, rehab: 0, military: 0, blast: 0 };

            hospitalRecords.forEach(r => {
                if (r.pred.amputation == 1 || r.pred.amputation === true) counts.amputation++;
                if (r.pred.infection == 1 || r.pred.infection === true) counts.infection++;
                if (r.surg && (r.surg.tissueNecrosis == 1 || r.surg.osteomyelitis == 1 || r.surg.flapReconstruction == 1)) counts.complex_surgery++;
                if ((r.scr.rehabScore || 0) >= 7) counts.rehab++;

                if (r.pat.status === 'military') counts.military++;
                if (r.pat.injury_mechanism === 'blast') counts.blast++;
            });

            // Розрахунок відсотків для аналізу
            const pAmp = Math.round((counts.amputation / total) * 100);
            const pInf = Math.round((counts.infection / total) * 100);
            const pSurg = Math.round((counts.complex_surgery / total) * 100);
            const pRehab = Math.round((counts.rehab / total) * 100);
            const pMil = Math.round((counts.military / total) * 100);

            let maxCount = Math.max(counts.amputation, counts.infection, counts.complex_surgery, counts.rehab);

            let profileInfo = {
                title: "Загальна травматологія",
                colorBg: "bg-gray-800",
                colorBorder: "border-gray-600",
                textColor: "text-gray-300",
                icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`
            };

            // Динамічний генератор тексту
            let descriptionParts = [];

            // 1. Контекст закладу
            if (pMil >= 60) {
                descriptionParts.push(`<strong>Військово-медичне спрямування:</strong> Основний контингент складають військовослужбовці (${pMil}%).`);
            } else if (pMil <= 30 && total > 5) {
                descriptionParts.push(`<strong>Цивільна травматологія:</strong> Переважна більшість пацієнтів – цивільні особи.`);
            }

            // 2. Головна спеціалізація
            if (maxCount > 0) {
                if (maxCount === counts.amputation) {
                    profileInfo.title = "Центр ампутацій та протезування";
                    profileInfo.colorBg = "bg-purple-900/20";
                    profileInfo.colorBorder = "border-purple-500/50";
                    profileInfo.textColor = "text-purple-400";
                    profileInfo.icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />`;

                    descriptionParts.push(`Головний пріоритет закладу – формування кукси, лікування фантомних болів та підготовка до протезування.`);
                } else if (maxCount === counts.infection) {
                    profileInfo.title = "Гнійна та інфекційна хірургія";
                    profileInfo.colorBg = "bg-emerald-900/20";
                    profileInfo.colorBorder = "border-emerald-500/50";
                    profileInfo.textColor = "text-emerald-400";
                    profileInfo.icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />`;

                    descriptionParts.push(`Експертиза зосереджена на санації відкритих ран, застосуванні ВАК-терапії та лікуванні мультирезистентних інфекцій (MDRO).`);
                } else if (maxCount === counts.complex_surgery) {
                    profileInfo.title = "Реконструктивна хірургія";
                    profileInfo.colorBg = "bg-amber-900/20";
                    profileInfo.colorBorder = "border-amber-500/50";
                    profileInfo.textColor = "text-amber-400";
                    profileInfo.icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />`;

                    descriptionParts.push(`Заклад найкраще підходить для пацієнтів із масивними дефектами тканин, некрозом, остеомієлітом або потребою в пластиці клаптями.`);
                } else if (maxCount === counts.rehab) {
                    profileInfo.title = "Центр інтенсивної реабілітації";
                    profileInfo.colorBg = "bg-blue-900/20";
                    profileInfo.colorBorder = "border-blue-500/50";
                    profileInfo.textColor = "text-blue-400";
                    profileInfo.icon = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />`;

                    descriptionParts.push(`Оптимально підходить для переведення пацієнтів зі стабілізованим хірургічним станом для інтенсивного відновлення функцій та подолання больових синдромів.`);
                }
            } else {
                descriptionParts.push(`Надає базову стабілізаційну та хірургічну допомогу пацієнтам із загальними травмами.`);
            }

            // 3. Супутні спеціалізації
            let secondary = [];
            if (maxCount !== counts.amputation && pAmp >= 20) secondary.push(`<span class="text-purple-400">ампутаціями (${pAmp}%)</span>`);
            if (maxCount !== counts.infection && pInf >= 30) secondary.push(`<span class="text-emerald-400">інфекціями (${pInf}%)</span>`);
            if (maxCount !== counts.complex_surgery && pSurg >= 25) secondary.push(`<span class="text-amber-400">реконструкцією (${pSurg}%)</span>`);
            if (maxCount !== counts.rehab && pRehab >= 40) secondary.push(`<span class="text-blue-400">важкою реабілітацією (${pRehab}%)</span>`);

            if (secondary.length > 0) {
                descriptionParts.push(`Також госпіталь має значний досвід роботи з ускладненими випадками: ${secondary.join(', ')}.`);
            }

            // Отримуємо реальну назву з об'єкта (пробуємо name або title)
            const realHospitalName = hospital.hospital_name || hospital.title || `Госпіталь #${hospital.id}`;

            // Генерація HTML картки
            const cardHTML = `
                <div class="rounded-xl p-6 border shadow-lg flex flex-col h-full ${profileInfo.colorBg} ${profileInfo.colorBorder}">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h4 class="text-xl font-bold text-white mb-2 leading-tight">${realHospitalName}</h4>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-900 shadow-sm ${profileInfo.textColor} border ${profileInfo.colorBorder}">
                                ${profileInfo.title}
                            </span>
                        </div>
                        <div class="p-2 rounded-lg bg-gray-900 border ${profileInfo.colorBorder} ${profileInfo.textColor}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                ${profileInfo.icon}
                            </svg>
                        </div>
                    </div>

                    <div class="mb-4 flex-grow bg-gray-900/50 rounded-lg p-4 border border-gray-700/50">
                        <p class="text-sm text-gray-300 leading-relaxed space-y-2">
                            ${descriptionParts.map(part => `<span>${part}</span>`).join('<br><br>')}
                        </p>
                    </div>

                    <div class="grid grid-cols-4 gap-2 text-center border-t border-gray-700/50 pt-4">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wide">Пацієнтів</p>
                            <p class="text-lg font-bold text-white">${total}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wide">Ампутації</p>
                            <p class="text-lg font-bold text-white">${pAmp}%</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wide">Інфекції</p>
                            <p class="text-lg font-bold text-white">${pInf}%</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wide">Складні</p>
                            <p class="text-lg font-bold text-white">${pSurg}%</p>
                        </div>
                    </div>
                </div>
            `;
            profilesContainer.insertAdjacentHTML('beforeend', cardHTML);
        });

        // --- ГЛОБАЛЬНА СТАТИСТИКА ПО ВСІХ ЗАПИСАХ ---
        const records = allRecords;
        const globalTotal = records.length;
        document.getElementById('kpi-total').textContent = globalTotal;

        if (globalTotal === 0) return;

        // Збір розширених даних
        let sumAge = 0, ageCount = 0;
        let hPain = 0, hRehab = 0, hPros = 0;
        let sumPain = 0, sumRehabScore = 0;
        let militaryCount = 0, blastCount = 0;
        let totalAmps = 0, totalInfs = 0, totalSurgs = 0;

        records.forEach(r => {
            let age = parseInt(r.pat.age);
            if (!isNaN(age)) { sumAge += age; ageCount++; }

            let painScore = parseInt(r.scr.painScore) || 0;
            let rehabScore = parseInt(r.scr.rehabScore) || 0;

            sumPain += painScore;
            sumRehabScore += rehabScore;

            if (painScore >= 7) hPain++;
            if (rehabScore >= 7) hRehab++;
            if ((r.scr.prostheticScore || 0) >= 4) hPros++;

            if (r.pat.status === 'military') militaryCount++;
            if (r.pat.injury_mechanism === 'blast') blastCount++;

            if (r.pred.amputation == 1 || r.pred.amputation === true) totalAmps++;
            if (r.pred.infection == 1 || r.pred.infection === true) totalInfs++;
            if (r.surg && (r.surg.tissueNecrosis == 1 || r.surg.osteomyelitis == 1 || r.surg.flapReconstruction == 1)) totalSurgs++;
        });

        // Оновлення KPI DOM елементів
        document.getElementById('kpi-age').textContent = ageCount ? (sumAge / ageCount).toFixed(1) : 'Н/Д';
        document.getElementById('kpi-military').textContent = Math.round((militaryCount / globalTotal) * 100) + '%';
        document.getElementById('kpi-blast').textContent = Math.round((blastCount / globalTotal) * 100) + '%';
        document.getElementById('kpi-avg-pain').textContent = (sumPain / globalTotal).toFixed(1) + ' / 10';

        document.getElementById('kpi-pain').textContent = hPain;
        document.getElementById('kpi-rehab').textContent = hRehab;
        document.getElementById('kpi-amputations').textContent = totalAmps;
        document.getElementById('kpi-infections').textContent = totalInfs;
        document.getElementById('kpi-surgeries').textContent = totalSurgs;

        // --- ГРАФІК: РОЗПОДІЛ РИЗИКІВ ---
        const rData = { pain: [0,0,0], rehab: [0,0,0], pros: [0,0,0] };
        records.forEach(r => {
            let p=r.scr.painScore||0, re=r.scr.rehabScore||0, pr=r.scr.prostheticScore||0;
            if(p<=3) rData.pain[0]++; else if(p<=6) rData.pain[1]++; else rData.pain[2]++;
            if(re<=3) rData.rehab[0]++; else if(re<=6) rData.rehab[1]++; else rData.rehab[2]++;
            if(pr<=1) rData.pros[0]++; else if(pr<=3) rData.pros[1]++; else rData.pros[2]++;
        });

        new Chart(document.getElementById('risksChart'), {
            type: 'bar',
            data: {
                labels: ['Низький', 'Середній', 'Високий'],
                datasets: [
                    { label: 'Біль (CPRS)', data: rData.pain, backgroundColor: 'rgba(239, 68, 68, 0.7)'},
                    { label: 'Реабілітація', data: rData.rehab, backgroundColor: 'rgba(234, 179, 8, 0.7)'},
                    { label: 'Протезування', data: rData.pros, backgroundColor: 'rgba(168, 85, 247, 0.7)'}
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // --- ГРАФІК: ОСНОВНІ ТРАВМИ ---
        const tMap = {};
        records.forEach(r => { let t = r.icd.mainTrauma || 'Не вказано'; tMap[t] = (tMap[t] || 0) + 1; });
        new Chart(document.getElementById('traumasChart'), {
            type: 'doughnut',
            data: { labels: Object.keys(tMap), datasets: [{ data: Object.values(tMap), backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ec4899', '#6b7280'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } } }
        });

        // --- ГРАФІК: СТАТУС ---
        const sMap = { 'military': 0, 'civilian': 0, 'other': 0 };
        records.forEach(r => { let s = r.pat.status || 'other'; sMap[s]!==undefined ? sMap[s]++ : sMap['other']++; });
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: { labels: ['Військові', 'Цивільні', 'Не вказано'], datasets: [{ data: Object.values(sMap), backgroundColor: ['#10b981', '#38bdf8', '#6b7280'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // --- МЕХАНІЗМ ---
        const mMap = { 'blast': 0, 'drone': 0, 'gunshot': 0, 'other': 0 };
        records.forEach(r => { let m = r.pat.injury_mechanism || 'other'; mMap[m]!==undefined ? mMap[m]++ : mMap['other']++; });
        new Chart(document.getElementById('mechanismsChart'), {
            type: 'doughnut',
            data: { labels: ['Вибух', 'Дрон', 'Вогнепальне', 'Інше'], datasets: [{ data: Object.values(mMap), backgroundColor: ['#f97316', '#8b5cf6', '#ef4444', '#6b7280'], borderWidth: 0 }] },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // --- АМПУТАЦІЇ ---
        const ampMap = { 'transfemoral': 0, 'transtibial': 0, 'upper': 0, 'not_specified': 0 };
        records.forEach(r => {
            if (r.pred.amputation == true || r.pred.amputation == 1) {
                let lvl = r.pros.amputation_level || 'not_specified';
                ampMap[lvl]!==undefined ? ampMap[lvl]++ : ampMap['not_specified']++;
            }
        });
        new Chart(document.getElementById('amputationsChart'), {
            type: 'bar',
            data: { labels: ['Трансфеморальна', 'Транстибіальна', 'Верхня кінцівка', 'Не вказано'], datasets: [{ data: Object.values(ampMap), backgroundColor: '#a855f7' }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: {display: false} } }
        });

        // --- ІНШІ ФАКТОРИ ---
        let infC=0, trnC=0, phC=0, revC=0;
        records.forEach(r => {
            if (r.pred.infection == 1) infC++;
            if (r.pred.tourniquet == 1) trnC++;
            if (r.pros.phantom_pain == 1) phC++;
            if (r.pros.revisions == 1) revC++;
        });
        new Chart(document.getElementById('predictorsChart'), {
            type: 'bar', data: { labels: ['Турнікет', 'Інфекція', 'Фантом. біль', 'Ревізії'], datasets: [{ data: [trnC, infC, phC, revC], backgroundColor: '#38bdf8' }] },
            options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: {display: false} } }
        });

        const iLabels = ['openWound', 'woundContamination', 'openFracture', 'npwt', 'mdro'];
        const iData = [0,0,0,0,0];
        records.forEach(r => { if(r.inf) iLabels.forEach((k,i) => { if(r.inf[k]==1) iData[i]++; }); });
        new Chart(document.getElementById('infectionFactorsChart'), {
            type: 'bar', data: { labels: ['Відкрита рана', 'Забруднення', 'Відкр. перелом', 'NPWT', 'MDRO'], datasets: [{ data: iData, backgroundColor: '#10b981' }] },
            options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: {display: false} } }
        });

        const sLabels = ['repeatedDebridement', 'tissueNecrosis', 'woundDehiscence', 'osteomyelitis', 'vascularInjury'];
        const sData = [0,0,0,0,0];
        records.forEach(r => { if(r.surg) sLabels.forEach((k,i) => { if(r.surg[k]==1) sData[i]++; }); });
        new Chart(document.getElementById('surgicalFactorsChart'), {
            type: 'bar', data: { labels: ['Повторний дебридмент', 'Некроз', 'Розходження рани', 'Остеомієліт', 'Судинні травми'], datasets: [{ data: sData, backgroundColor: '#f59e0b' }] },
            options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: {display: false} } }
        });
    });
</script>
</body>
</html>
