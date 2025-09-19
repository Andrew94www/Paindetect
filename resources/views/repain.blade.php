<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RePain-AI: Прогноз рикошетного болю</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles for glowing effects and transitions */
        .risk-low { color: #22c55e; } /* green-500 */
        .risk-moderate { color: #f59e0b; } /* amber-500 */
        .risk-high { color: #ef4444; } /* red-500 */

        .result-card {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }
        .result-card.low { border-left: 5px solid #22c55e; }
        .result-card.moderate { border-left: 5px solid #f59e0b; }
        .result-card.high { border-left: 5px solid #ef4444; }

        .loader {
            border: 4px solid #f3f3f3; /* Light grey */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="container mx-auto p-4 md:p-8 max-w-4xl">

    <!-- Header -->
    <header class="text-center mb-8">
        <div class="flex justify-center items-center gap-4">
            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900">RePain-AI</h1>
        </div>
        <p class="mt-2 text-lg text-slate-600">Система підтримки прийняття рішень для прогнозування рикошетного болю після PNB</p>
    </header>

    <!-- Main Form -->
    <main class="bg-white p-6 md:p-8 rounded-2xl shadow-lg">
        <form id="risk-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Patient Factors -->
                <div class="space-y-4 p-4 border border-slate-200 rounded-lg">
                    <h3 class="font-semibold text-lg border-b pb-2 text-slate-700">Фактори пацієнта</h3>
                    <div>
                        <label for="age" class="block text-sm font-medium text-slate-600 mb-1">Вік</label>
                        <input type="number" id="age" required class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 45">
                    </div>
                    <div>
                        <label for="sex" class="block text-sm font-medium text-slate-600 mb-1">Стать</label>
                        <select id="sex" class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="male">Чоловіча</option>
                            <option value="female">Жіноча</option>
                        </select>
                    </div>
                    <div>
                        <label for="baseline_nrs" class="block text-sm font-medium text-slate-600 mb-1">Базовий біль (NRS 0-10)</label>
                        <input type="number" id="baseline_nrs" min="0" max="10" required class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 6">
                    </div>
                    <div>
                        <label for="chronic_pain" class="block text-sm font-medium text-slate-600 mb-1">Хронічний біль в анамнезі</label>
                        <select id="chronic_pain" class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="no">Ні</option>
                            <option value="yes">Так</option>
                        </select>
                    </div>
                </div>

                <!-- Procedural Factors -->
                <div class="space-y-4 p-4 border border-slate-200 rounded-lg">
                    <h3 class="font-semibold text-lg border-b pb-2 text-slate-700">Фактори процедури</h3>
                    <div>
                        <label for="surgery_type" class="block text-sm font-medium text-slate-600 mb-1">Тип операції</label>
                        <select id="surgery_type" class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="hand">Хірургія кисті</option>
                            <option value="shoulder">Артроскопія плеча</option>
                            <option value="knee">Ендопротезування коліна</option>
                            <option value="foot">Хірургія стопи</option>
                        </select>
                    </div>
                    <div>
                        <label for="la_agent" class="block text-sm font-medium text-slate-600 mb-1">Місцевий анестетик</label>
                        <select id="la_agent" class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="bupivacaine">Бупівакаїн</option>
                            <option value="ropivacaine">Ропівакаїн</option>
                            <option value="lidocaine">Лідокаїн</option>
                        </select>
                    </div>
                    <div>
                        <label for="la_dose_mg" class="block text-sm font-medium text-slate-600 mb-1">Доза анестетика (мг)</label>
                        <input type="number" id="la_dose_mg" required class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 150">
                    </div>
                    <div>
                        <label for="adjuvant_dexa" class="block text-sm font-medium text-slate-600 mb-1">Ад'ювант (Дексаметазон)</label>
                        <select id="adjuvant_dexa" class="w-full p-2 border border-slate-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="no">Ні</option>
                            <option value="yes">Так</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-8 text-center">
                <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform transform hover:scale-105">
                    Розрахувати ризик
                </button>
            </div>
        </form>
    </main>

    <!-- Results Section -->
    <section id="results-section" class="mt-8 hidden">
        <div id="loader" class="mx-auto loader hidden"></div>
        <div id="results-content" class="bg-white p-6 md:p-8 rounded-2xl result-card">
            <h2 class="text-2xl font-bold text-center mb-6 text-slate-800">Результат аналізу</h2>
            <div class="flex flex-col md:flex-row items-center justify-center md:justify-around gap-6 text-center">
                <div>
                    <p class="text-lg text-slate-600">Ризик "рикошетного" болю</p>
                    <p id="risk-percentage" class="text-6xl font-extrabold my-2">--%</p>
                    <p id="risk-band" class="text-2xl font-semibold capitalize py-1 px-4 rounded-full">--</p>
                </div>
                <div class="w-full md:w-px bg-slate-200 h-px md:h-32"></div>
                <div class="max-w-md text-left">
                    <h3 class="text-xl font-semibold mb-3 text-slate-700">Рекомендації з профілактики</h3>
                    <ul id="recommendations-list" class="list-disc list-inside space-y-2 text-slate-600">
                        <li>Завантаження рекомендацій...</li>
                    </ul>
                </div>
            </div>
            <p class="text-xs text-slate-400 text-center mt-8">*Цей інструмент є системою підтримки прийняття рішень. Остаточне клінічне рішення залишається за лікарем.</p>
        </div>
    </section>

</div>

<script>
    const form = document.getElementById('risk-form');
    const resultsSection = document.getElementById('results-section');
    const loader = document.getElementById('loader');
    const resultsContent = document.getElementById('results-content');
    const riskPercentageEl = document.getElementById('risk-percentage');
    const riskBandEl = document.getElementById('risk-band');
    const recommendationsListEl = document.getElementById('recommendations-list');

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // Show loader and hide previous results
        resultsSection.classList.remove('hidden');
        resultsContent.classList.add('hidden');
        loader.classList.remove('hidden');

        const patientData = {
            age: parseInt(document.getElementById('age').value, 10),
            sex: document.getElementById('sex').value,
            baseline_nrs: parseInt(document.getElementById('baseline_nrs').value, 10),
            chronic_pain: document.getElementById('chronic_pain').value,
            surgery_type: document.getElementById('surgery_type').value,
            la_agent: document.getElementById('la_agent').value,
            la_dose_mg: parseInt(document.getElementById('la_dose_mg').value, 10),
            adjuvant_dexa: document.getElementById('adjuvant_dexa').value
        };

        // Simulate API call delay
        setTimeout(() => {
            const risk = calculateRisk(patientData);
            displayResults(risk);
            loader.classList.add('hidden');
            resultsContent.classList.remove('hidden');
        }, 1000);
    });

    /**
     * Simulates the AI model prediction with a rule-based heuristic.
     * @param {object} data - The patient and procedure data.
     * @returns {object} - An object containing the probability and risk band.
     */
    function calculateRisk(data) {
        let riskScore = 0.05; // Base risk

        // Patient factors
        if (data.age > 60) riskScore += 0.08;
        if (data.age < 30) riskScore += 0.05;
        if (data.baseline_nrs >= 7) riskScore += 0.20;
        else if (data.baseline_nrs >= 4) riskScore += 0.10;
        if (data.chronic_pain === 'yes') riskScore += 0.15;

        // Procedural factors
        const surgeryRisk = { 'shoulder': 0.18, 'knee': 0.15, 'foot': 0.12, 'hand': 0.05 };
        riskScore += surgeryRisk[data.surgery_type] || 0;

        const agentDuration = { 'bupivacaine': 0.02, 'ropivacaine': 0.01, 'lidocaine': 0.10 };
        riskScore += agentDuration[data.la_agent] || 0;

        if(data.la_dose_mg > 200) riskScore += 0.05;

        if (data.adjuvant_dexa === 'yes') riskScore -= 0.10;

        // Clamp the score between 0.01 and 0.99
        riskScore = Math.max(0.01, Math.min(0.99, riskScore));

        let band = 'low';
        if (riskScore >= 0.30) band = 'high';
        else if (riskScore >= 0.10) band = 'moderate';

        return { probability: riskScore, band };
    }

    /**
     * Generates recommendations based on the risk band.
     * @param {string} band - The risk band ('low', 'moderate', 'high').
     * @returns {string[]} - An array of recommendation strings.
     */
    function getRecommendations(band) {
        const recommendations = {
            low: [
                "Стандартний протокол мультимодальної анальгезії.",
                "Надати пацієнту чіткі інструкції щодо прийому анальгетиків за потреби.",
                "Контроль болю через 8-12 годин."
            ],
            moderate: [
                "Розглянути додавання <strong>Дексаметазону</strong> (4-8 мг) до блоку для пролонгації.",
                "Запланувати прийом НПЗП/Парацетамолу <strong>за 1-2 години до очікуваного завершення блоку</strong>.",
                "Забезпечити пацієнта rescue-анальгетиками на виписку.",
                "Підвищена увага до оцінки болю в перші 24 години."
            ],
            high: [
                "<strong>Настійно рекомендується</strong> встановлення периневрального катетера для пролонгованої анальгезії.",
                "Обов'язкове призначення <strong>Дексаметазону</strong> для пролонгації ефекту блокади.",
                "Призначити НПЗП та/або Парацетамол за <strong>регулярною схемою</strong>, починаючи до завершення дії блоку.",
                "Розглянути ад'юванти (напр. Клонідин) та превентивну низьку дозу опіоїдів.",
                "Організувати SMS-нагадування пацієнту про прийом ліків за 2 години до offset."
            ]
        };
        return recommendations[band];
    }

    /**
     * Updates the UI with the calculated results.
     * @param {object} risk - The risk object from calculateRisk.
     */
    function displayResults(risk) {
        const percentage = (risk.probability * 100).toFixed(0);
        riskPercentageEl.textContent = `${percentage}%`;

        const riskClasses = {
            low: { text: 'Низький', color: 'risk-low', bg: 'bg-green-100', border: 'low' },
            moderate: { text: 'Помірний', color: 'risk-moderate', bg: 'bg-amber-100', border: 'moderate' },
            high: { text: 'Високий', color: 'risk-high', bg: 'bg-red-100', border: 'high' }
        };

        const currentClass = riskClasses[risk.band];

        // Reset classes
        riskPercentageEl.className = 'text-6xl font-extrabold my-2';
        riskBandEl.className = 'text-2xl font-semibold capitalize py-1 px-4 rounded-full';
        resultsContent.className = 'bg-white p-6 md:p-8 rounded-2xl result-card';

        // Apply new classes
        riskPercentageEl.classList.add(currentClass.color);
        riskBandEl.textContent = currentClass.text;
        riskBandEl.classList.add(currentClass.color, currentClass.bg);
        resultsContent.classList.add(currentClass.border);
        const recommendations = getRecommendations(risk.band);
        recommendationsListEl.innerHTML = recommendations.map(rec => `<li>${rec}</li>`).join('');
    }
</script>
</body>
</html>
