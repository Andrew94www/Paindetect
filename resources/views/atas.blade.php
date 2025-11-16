<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI ATAS Dashboard</title>
    <!-- Подключение Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Подключение Chart.js для графиков -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Кастомный стиль для темного режима */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827; /* Темно-серый/синий */
            color: #e5e7eb; /* Светло-серый текст */
        }
        .card {
            background-color: #1f2937; /* Средне-темный */
            border-radius: 0.75rem; /* 12px */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        .card-header {
            background-color: #374151; /* Темно-серый */
            color: #f9fafb; /* Ярко-белый */
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #374151;
        }
        .card-title {
            font-size: 1.25rem; /* 20px */
            font-weight: 600;
        }
        .card-content {
            padding: 1.5rem;
        }
        .form-section {
            border-top: 1px solid #374151;
            padding-top: 1rem;
            margin-top: 1rem;
        }
        .form-section-title {
            font-size: 1rem; /* 16px */
            font-weight: 600;
            color: #3b82f6; /* Ярко-синий */
            margin-bottom: 0.75rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem; /* 14px */
            font-weight: 500;
            color: #d1d5db; /* Светло-серый */
            margin-bottom: 0.25rem;
        }
        .form-select, .form-input {
            width: 100%;
            background-color: #374151; /* Темно-серый */
            color: #ffffff;
            border-radius: 0.375rem; /* 6px */
            border: 1px solid #4b5563; /* Средне-серый */
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .form-select:focus, .form-input:focus {
            border-color: #3b82f6; /* Голубой при фокусе */
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            outline: none;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem; /* 10px 20px */
            border-radius: 0.5rem; /* 8px */
            font-weight: 600;
            font-size: 0.875rem;
            color: #ffffff;
            background-color: #3b82f6; /* Голубой */
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn:hover {
            background-color: #2563eb; /* Голубой темнее */
        }
        .btn-secondary {
            background-color: #64748b; /* Серый */
        }
        .btn-secondary:hover {
            background-color: #475569; /* Серый темнее */
        }
        .btn:disabled {
            background-color: #4b5563;
            cursor: not-allowed;
        }
        .score-display {
            text-align: center;
            padding: 2rem;
            background-color: #1e3a8a; /* Темно-синий */
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .score-total {
            font-size: 3rem; /* 48px */
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
        }
        .score-interpretation {
            font-size: 1.125rem; /* 18px */
            font-weight: 500;
            color: #bfdbfe; /* Светло-голубой */
            margin-top: 0.5rem;
        }
        .ai-response {
            background-color: #111827; /* Базовый темный */
            border: 1px solid #374151;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            min-height: 100px;
            /* white-space: pre-wrap;  УБРАНО, так как мы используем HTML */
            font-size: 0.875rem;
            line-height: 1.6;
            color: #d1d5db;
        }
        /* Стили для HTML-отчета */
        .ai-response h4 {
            font-size: 1.125rem; /* 18px */
            font-weight: 600;
            color: #60a5fa; /* Светло-синий */
            margin-bottom: 0.75rem;
        }
        .ai-response h5 {
            font-size: 1rem; /* 16px */
            font-weight: 600;
            color: #d1d5db; /* Светло-серый */
            border-bottom: 1px solid #4b5563;
            padding-bottom: 0.25rem;
            margin-top: 0.75rem;
            margin-bottom: 0.5rem;
        }
        .ai-response p {
            margin-bottom: 0.5rem;
        }
        .ai-response .text-red-400 { color: #f87171; }
        .ai-response .text-red-300 { color: #fca5a5; font-weight: 600; }
        .ai-response .text-yellow-400 { color: #facc15; }
        .ai-response .text-yellow-300 { color: #fde047; font-weight: 600; }
        .ai-response .text-green-400 { color: #4ade80; }
        .ai-response .text-green-300 { color: #86efac; font-weight: 600; }
        .ai-response .text-gray-400 { color: #9ca3af; }
        .ai-response .text-gray-300 { color: #d1d5db; font-weight: 600; }
        .ai-response .italic { font-style: italic; }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        /* Стили для Chart.js в темном режиме */
        .chart-container {
            position: relative;
            width: 100%;
            height: 256px; /* 16rem */
        }
        @media (min-width: 768px) {
            .chart-container {
                height: 320px; /* 20rem */
            }
        }
    </style>
</head>
<body class="p-4 md:p-8">

<header class="max-w-7xl mx-auto mb-6">
    <h1 class="text-3xl font-bold text-gray-100">ATAS AI Dashboard: Antibiotic Treatment Assessment</h1>
    <p class="text-lg text-gray-400">Intelligent tool for ATAS calculation and analysis</p>
</header>

<main class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- COLUMN 1: ATAS CALCULATOR -->
    <div class="lg:col-span-1 space-y-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">1. ATAS Calculator</h2>
            </div>
            <form id="atas-form" class="card-content">

                <!-- 1. Clinical Efficacy (0-6) -->
                <div class="form-section !mt-0 !pt-0 !border-0">
                    <h3 class="form-section-title">Clinical Efficacy (0-6)</h3>
                    <div>
                        <label for="s1_infection" class="form-label">Infection Symptom Regression</label>
                        <select id="s1_infection" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – None</option>
                            <option value="1">1 – Partial</option>
                            <option value="2" selected>2 – Complete</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s1_temp" class="form-label">Temperature Normalization</label>
                        <select id="s1_temp" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – &gt;38.5°C</option>
                            <option value="1">1 – 37.5-38.5°C</option>
                            <option value="2" selected>2 – &lt;37.5°C</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s1_labs" class="form-label">Lab Dynamics (WBC/CRP/PCT)</label>
                        <select id="s1_labs" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – Progression</option>
                            <option value="1">1 – Stable</option>
                            <option value="2" selected>2 – Improvement</option>
                        </select>
                    </div>
                </div>

                <!-- 2. Microbiological Control (0-4) -->
                <div class="form-section">
                    <h3 class="form-section-title">Microbiological Control (0-4)</h3>
                    <div>
                        <label for="s2_pathogen" class="form-label">Pathogen Identified</label>
                        <select id="s2_pathogen" class="form-select" data-scores="0,1">
                            <option value="0">0 – No</option>
                            <option value="1" selected>1 – Yes</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s2_sensitivity" class="form-label">Tactic (AB Sensitivity)</label>
                        <select id="s2_sensitivity" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – Empirically Incorrect</option>
                            <option value="1">1 – Correction</option>
                            <option value="2" selected>2 – Initially Correct</option>
                        </select>
                    </div>
                </div>

                <!-- 3. Therapy Rationality (0-5) -->
                <div class="form-section">
                    <h3 class="form-section-title">Therapy Rationality (0-5)</h3>
                    <div>
                        <label for="s3_protocol" class="form-label">AB Choice (Guidelines)</label>
                        <select id="s3_protocol" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – No</option>
                            <option value="1">1 – Partial</option>
                            <option value="2" selected>2 – Yes</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s3_dosage" class="form-label">Dosage/Duration</label>
                        <select id="s3_dosage" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – Incorrect</option>
                            <option value="1">1 – Doubtful</option>
                            <option value="2" selected>2 – Optimal</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s3_deescalation" class="form-label">De-escalation (if possible)</label>
                        <select id="s3_deescalation" class="form-select" data-scores="0,1">
                            <option value="0">0 – No</option>
                            <option value="1" selected>1 – Yes (+1)</option>
                        </select>
                    </div>
                </div>

                <!-- 4. Safety (0-5) -->
                <div class="form-section">
                    <h3 class="form-section-title">Safety (0-5)</h3>
                    <div>
                        <label for="s4_side_effects" class="form-label">Adverse Reactions</label>
                        <select id="s4_side_effects" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – Severe</option>
                            <option value="1">1 – Moderate</option>
                            <option value="2" selected>2 – None</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s4_toxicity" class="form-label">Nephro/Hepatotoxicity</label>
                        <select id="s4_toxicity" class="form-select" data-scores="0,1">
                            <option value="0">0 – Yes</option>
                            <option value="1" selected>1 – No</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s4_cdiff" class="form-label">C. difficile / Dysbiosis Risk</label>
                        <select id="s4_cdiff" class="form-select" data-scores="0,1">
                            <option value="0">0 – High</option>
                            <option value="1" selected>1 – Low</option>
                        </select>
                    </div>
                </div>

                <!-- 5. Impact on Disease Course (0-5) -->
                <div class="form-section">
                    <h3 class="form-section-title">Impact on Disease Course (0-5)</h3>
                    <div>
                        <label for="s5_reoperation" class="form-label">Need for Re-operation</label>
                        <select id="s5_reoperation" class="form-select" data-scores="0,1">
                            <option value="0">0 – Yes</option>
                            <option value="1" selected>1 – No</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s5_wound" class="form-label">Wound Infection Control</label>
                        <select id="s5_wound" class="form-select" data-scores="0,1,2">
                            <option value="0">0 – None</option>
                            <option value="1">1 – Partial</option>
                            <option value="2" selected>2 – Complete</option>
                        </select>
                    </div>
                </div>

                <!-- 6. Impact on Rehab & Pain (0-5) -->
                <div class="form-section">
                    <h3 class="form-section-title">Impact on Rehab & Pain (0-5)</h3>
                    <div>
                        <label for="s6_rehab_delay" class="form-label">Rehab Delay >7 days (due to AB)</label>
                        <select id="s6_rehab_delay" class="form-select" data-scores="0,1">
                            <option value="0">0 – Yes</option>
                            <option value="1" selected>1 – No</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s6_neurotoxicity" class="form-label">AB Impact on Pain Chronicity (Neurotoxicity)</label>
                        <select id="s6_neurotoxicity" class="form-select" data-scores="0,1">
                            <option value="0">0 – Risk factors present</option>
                            <option value="1" selected>1 – No</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="s6_neuropathic" class="form-label">Inflammation -> Neuropathic Pain</label>
                        <select id="s6_neuropathic" class="form-select" data-scores="0,1">
                            <option value="0">0 – Yes</option>
                            <option value="1" selected>1 – No</option>
                        </select>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- COLUMN 2: RESULTS & METRICS -->
    <div class="lg:col-span-1 space-y-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">2. Result and Metrics</h2>
            </div>
            <div class="card-content">
                <div class="score-display">
                    <div id="score-total" class="score-total">30</div>
                    <div id="score-interpretation" class="score-interpretation">Effective and Safe</div>
                </div>

                <!-- Button to add to history -->
                <button id="add-to-history-btn" class="btn w-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Add to History & Update Charts
                </button>

                <h3 class="form-section-title mt-4">ATAS Score Distribution</h3>
                <div class="chart-container">
                    <canvas id="radar-chart"></canvas>
                </div>

                <h3 class="form-section-title mt-6">ATAS History</h3>
                <div class="chart-container">
                    <canvas id="history-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- COLUMN 3: AI ASSISTANT -->
    <div class="lg:col-span-1 space-y-6">
        <!-- ИЗМЕНЕНИЕ: Логика этого блока полностью обновлена -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">3. Drug Heuristic Analysis</h2>
            </div>
            <div class="card-content">
                <p class="text-sm text-gray-400 mb-4">First, search for a drug in block 4. Then, click here for an automated summary of its risks and interactions.</p>
                <button id="ai-summary-btn" class="btn w-full">
                    <span class="loading-spinner hidden"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 icon"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zM8 12h8M12 8v8"/></svg>
                    <span class="btn-text">Generate Analysis</span>
                </button>
                <div id="ai-summary-output" class="ai-response mt-4" placeholder="Analysis results will appear here after searching for a drug."></div>
            </div>
        </div>

        <!-- Real API Drug Info -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">4. Antibiotic Information (OpenFDA)</h2>
            </div>
            <div class="card-content">
                <p class="text-sm text-gray-400 mb-4">Enter a drug name (start typing for suggestions) to get information from the free OpenFDA API.</p>
                <div class="flex gap-2">
                    <input type="text" id="drug-input" class="form-input" list="antibiotic-suggestions" placeholder="e.g., 'Amoxicillin' or 'Ciprofloxacin'">
                    <button id="ai-drug-btn" class="btn">
                        <span class="loading-spinner hidden"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 icon"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.3"/></svg>
                        <span class="btn-text">Search</span>
                    </button>
                </div>

                <datalist id="antibiotic-suggestions">
                    <option value="Amoxicillin"></option>
                    <option value="Azithromycin"></option>
                    <option value="Ciprofloxacin"></option>
                    <option value="Cephalexin"></option>
                    <option value="Clindamycin"></option>
                    <option value="Doxycycline"></option>
                    <option value="Levofloxacin"></option>
                    <option value="Meropenem"></option>
                    <option value="Metronidazole"></option>
                    <option value="Penicillin"></option>
                    <option value="Sulfamethoxazole"></option>
                    <option value="Trimethoprim"></option>
                    <option value="Vancomycin"></option>
                    <option value="Gentamicin"></option>
                    <option value="Piperacillin"></option>
                </datalist>

                <div id="ai-drug-output" class="ai-response mt-4" placeholder="Drug information will appear here..."></div>
            </div>
        </div>
    </div>

</main>

<!-- API Error Modal -->
<div id="api-error-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
        <h3 class="text-xl font-bold text-red-600 mb-4">API Error</h3>
        <p id="api-error-message" class="text-gray-700 mb-6">Failed to execute request. Please check the console for details.</p>
        <button id="close-error-modal-btn" class="btn w-full bg-red-600 hover:bg-red-700">Close</button>
    </div>
</div>


<script type="module">
    // --- Gemini API Configuration ---
    // УБРАНО: API_KEY, GENERATE_CONTENT_URL и fetchWithExponentialBackoff
    // Приложение больше не использует Google Gemini AI.

    // --- Chart.js Instances ---
    let radarChartInstance = null;
    let historyChartInstance = null;

    // --- Application State ---
    let atasHistory = []; // Array to store score history
    let currentDrugData = null; // ИЗМЕНЕНИЕ: Хранит полные данные из OpenFDA

    // --- DOM Elements ---
    const form = document.getElementById('atas-form');
    const scoreTotalEl = document.getElementById('score-total');
    const scoreInterpretationEl = document.getElementById('score-interpretation');
    const aiSummaryBtn = document.getElementById('ai-summary-btn');
    const aiSummaryOutput = document.getElementById('ai-summary-output');
    const aiDrugBtn = document.getElementById('ai-drug-btn');
    const drugInput = document.getElementById('drug-input');
    const aiDrugOutput = document.getElementById('ai-drug-output');
    const addToHistoryBtn = document.getElementById('add-to-history-btn');

    // --- Error Modal Elements ---
    const errorModal = document.getElementById('api-error-modal');
    const errorModalMessage = document.getElementById('api-error-message');
    const closeErrorModalBtn = document.getElementById('close-error-modal-btn');

    // --- Utility Functions ---

    function showApiError(message) {
        console.error("API Error:", message);
        errorModalMessage.textContent = message || "Failed to execute request. Please try again later.";
        errorModal.classList.remove('hidden');
    }

    function hideApiError() {
        errorModal.classList.add('hidden');
    }

    function setButtonLoading(button, isLoading) {
        const spinner = button.querySelector('.loading-spinner');
        const icon = button.querySelector('.icon');
        const text = button.querySelector('.btn-text');

        button.disabled = isLoading;
        if (isLoading) {
            spinner?.classList.remove('hidden');
            icon?.classList.add('hidden');
            if (text) text.textContent = 'Loading...';
        } else {
            spinner?.classList.add('hidden');
            icon?.classList.remove('hidden');
            if (text) {
                // Restore original text
                if (button.id === 'ai-summary-btn') text.textContent = 'Generate Analysis'; // ИЗМЕНЕНИЕ
                else if (button.id === 'ai-drug-btn') text.textContent = 'Search';
            }
        }
    }

    // УБРАНО: функция fetchWithExponentialBackoff

    // --- Core Application Logic (ATAS Calculator) ---

    function calculateATAS() {
        const getVal = (id) => parseInt(document.getElementById(id).value, 10);
        const s1 = getVal('s1_infection') + getVal('s1_temp') + getVal('s1_labs');
        const s2 = Math.min(4, getVal('s2_pathogen') + getVal('s2_sensitivity'));
        const s3 = Math.min(5, getVal('s3_protocol') + getVal('s3_dosage') + getVal('s3_deescalation'));
        const s4 = Math.min(5, getVal('s4_side_effects') + getVal('s4_toxicity') + getVal('s4_cdiff') + 1);
        const s5 = Math.min(5, getVal('s5_reoperation') + getVal('s5_wound') + 1 + 1);
        const s6 = Math.min(5, getVal('s6_rehab_delay') + getVal('s6_neurotoxicity') + getVal('s6_neuropathic') + 2);
        const total = s1 + s2 + s3 + s4 + s5 + s6;

        let interpretation = "";
        if (total <= 10) interpretation = "Ineffective/Unsafe Treatment";
        else if (total <= 18) interpretation = "Doubtful Result — Correction Needed";
        else if (total <= 25) interpretation = "Good, but Monitoring Required";
        else interpretation = "Effective and Safe";

        return {
            scores: { clinical: s1, microbiology: s2, rationality: s3, safety: s4, course: s5, rehab: s6 },
            total: total,
            interpretation: interpretation
        };
    }

    function updateUI() {
        const { scores, total, interpretation } = calculateATAS();
        scoreTotalEl.textContent = total;
        scoreInterpretationEl.textContent = interpretation;
        if (radarChartInstance) {
            radarChartInstance.data.datasets[0].data = Object.values(scores);
            radarChartInstance.data.labels = [
                `Clinical (${scores.clinical}/6)`, `Microbio (${scores.microbiology}/4)`, `Rationality (${scores.rationality}/5)`,
                `Safety (${scores.safety}/5)`, `Course (${scores.course}/5)`, `Rehab (${scores.rehab}/5)`
            ];
            radarChartInstance.update();
        }
    }

    function handleAddToHistory() {
        const { total } = calculateATAS();
        const label = `Day ${atasHistory.length + 1}`;
        atasHistory.push({ label, total });
        if (historyChartInstance) {
            historyChartInstance.data.labels = atasHistory.map(h => h.label);
            historyChartInstance.data.datasets[0].data = atasHistory.map(h => h.total);
            historyChartInstance.update();
        }
    }

    // --- AI Handlers (ИЗМЕНЕННАЯ ЛОГИКА) ---

    /**
     * НОВАЯ ЛОГИКА: Эта функция СЕЙЧАС анализирует данные OpenFDA локально
     * с помощью JavaScript и выводит структурированный HTML.
     */
    async function handleAiSummary() {
        // Проверяем, были ли данные загружены из OpenFDA
        if (!currentDrugData) {
            aiSummaryOutput.textContent = 'Please search for a drug in block 4 first.';
            showApiError('No drug data to analyze. Please use the search in block 4.');
            return;
        }

        setButtonLoading(aiSummaryBtn, true);
        // ИЗМЕНЕНИЕ: Используем innerHTML для индикатора загрузки
        aiSummaryOutput.innerHTML = '<p class="text-gray-400 italic">Analyzing drug data (Heuristic Analysis)...</p>';

        // --- Начало "Локального ИИ" (Логика на JavaScript) ---

        // Ключевые слова для поиска
        const adverseKeywords = [
            "anaphylaxis", "severe", "fatal", "hepatotoxicity", "nephrotoxicity",
            "cardiac", "arrhythmia", "tendon", "rupture", "seizure",
            "clostridium difficile", "sjs", "stevens-johnson", "renal failure"
        ];

        const interactionKeywords = [
            "cyp450", "p-gp", "warfarin", "qt prolongation", "theophylline",
            "antacids", "dairy", "multivalent cations", "cyp3a4", "cyp2c9",
            "inhibitor", "inducer"
        ];

        /**
         * Вспомогательная функция для анализа текстового раздела (ГЕНЕРИРУЕТ HTML)
         * @param {string[]} textArray - Массив строк из OpenFDA (например, currentDrugData.adverse_reactions)
         * @param {string[]} keywords - Список ключевых слов для поиска
         * @param {string} sectionName - Имя раздела для отчета
         * @returns {string} - Отформатированный HTML-результат анализа
         */
        function analyzeSection(textArray, keywords, sectionName) {
            let report = `<h5>${sectionName}</h5>`; // Используем h5 для подзаголовка

            if (!textArray || !Array.isArray(textArray) || textArray.length === 0 || !textArray[0]) {
                report += `<p class="text-gray-400 italic">Data N/A (Not provided in OpenFDA response).</p>`;
                return report;
            }

            const text = textArray[0].toLowerCase();
            const findings = [];

            keywords.forEach(keyword => {
                if (text.includes(keyword)) {
                    findings.push(`<strong>${keyword}</strong>`); // Выделяем найденное слово
                }
            });

            if (findings.length > 0) {
                report += `<p class="text-red-400"><span class="text-red-300">Critical keywords found:</span> ${findings.join(', ')}</p>`;
                report += `<p class="text-yellow-400"><span class="text-yellow-300">Recommendation:</span> High priority for review. Check full text for context.</p>`;
            } else {
                report += `<p class="text-green-400"><span class="text-green-300">Analysis:</span> No critical keywords detected by local heuristics.</p>`;
                report += `<p class="text-gray-400"><span class="text-gray-300">Recommendation:</span> Review full text for details.</p>`;
            }
            return report;
        }

        // --- Создание отчета ---
        // ИЗМЕНЕНИЕ: Убран заголовок "Local Heuristic..."
        let finalReport = '<h4 class="text-lg font-bold text-blue-300 mb-3">Heuristic Analysis Report</h4>';

        // Анализ побочных реакций
        finalReport += analyzeSection(
            currentDrugData.adverse_reactions,
            adverseKeywords,
            "Adverse Reactions"
        );

        // Анализ взаимодействий
        finalReport += analyzeSection(
            currentDrugData.drug_interactions,
            interactionKeywords,
            "Drug Interactions"
        );

        // --- Конец "Локального ИИ" ---

        // Имитируем задержку, чтобы это выглядело как "анализ"
        await new Promise(resolve => setTimeout(resolve, 500));

        // ИЗМЕНЕНИЕ: Используем innerHTML для вставки HTML-разметки
        aiSummaryOutput.innerHTML = finalReport.trim();
        setButtonLoading(aiSummaryBtn, false);
    }

    /**
     * ИЗМЕНЕНИЕ: Эта функция теперь сохраняет данные в currentDrugData и активирует кнопку ИИ
     */
    async function handleAiDrugInfo() {
        const drugName = drugInput.value.trim();
        if (!drugName) {
            aiDrugOutput.textContent = 'Please enter a drug name.';
            return;
        }

        setButtonLoading(aiDrugBtn, true);
        aiDrugOutput.textContent = `Searching OpenFDA for "${drugName}"...`;

        // Сбрасываем предыдущие данные
        currentDrugData = null;
        aiSummaryBtn.disabled = true;
        aiSummaryOutput.innerHTML = ''; // Очищаем HTML
        aiSummaryOutput.setAttribute('placeholder', 'Analysis results will appear here after searching for a drug.');


        const url = `https://api.fda.gov/drug/label.json?search=(openfda.brand_name:"${drugName}"+OR+openfda.generic_name:"${drugName}")&limit=1`;

        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`OpenFDA API error! status: ${response.status}`);
            }
            const data = await response.json();

            if (!data.results || data.results.length === 0) {
                aiDrugOutput.textContent = `No information found for "${drugName}" on OpenFDA.`;
                return;
            }

            const result = data.results[0];

            // ИЗМЕНЕНИЕ: Сохраняем все данные для ИИ-анализа
            currentDrugData = result;

            // Helper to safely extract and truncate array data
            const getField = (field, fallback = 'N/A', maxLength = 300) => {
                if (result[field] && Array.isArray(result[field]) && result[field][0]) {
                    const text = result[field][0].replace(/[\r\n]+/g, ' '); // Clean up newlines
                    return text.length > maxLength ? `${text.substring(0, maxLength)}...` : text;
                }
                return fallback;
            };

            const brandName = result.openfda?.brand_name?.[0] || drugName;
            const genericName = result.openfda?.generic_name?.[0] || 'N/A';

            // ИЗМЕНЕНИЕ: Добавлено поле drug_interactions
            const output = `
Drug: ${brandName}
Generic: ${genericName}

--- Indications & Usage ---
${getField('indications_and_usage')}

--- Dosage & Administration ---
${getField('dosage_and_administration')}

--- Adverse Reactions ---
${getField('adverse_reactions')}

--- Drug Interactions ---
${getField('drug_interactions')}

--- Warnings & Cautions ---
${getField('warnings_and_cautions')}

(Data sourced from OpenFDA)
                `;

            aiDrugOutput.textContent = output.trim();

            // ИЗМЕНЕНИЕ: Активируем кнопку ИИ-анализа
            aiSummaryBtn.disabled = false;
            // ИЗМЕНЕНИЕ: Обновляем placeholder (который теперь виден как текст)
            aiSummaryOutput.innerHTML = `<p class="text-gray-400 italic">Data for "${brandName}" loaded. Click "Generate Analysis" above to summarize risks.</p>`;


        } catch (error) {
            aiDrugOutput.textContent = 'Error fetching drug information.';
            showApiError(error.message);
            currentDrugData = null;
            aiSummaryBtn.disabled = true;
        } finally {
            setButtonLoading(aiDrugBtn, false);
        }
    }

    // --- Chart Initialization ---

    function initCharts() {
        // 1. Radar Chart
        const radarCtx = document.getElementById('radar-chart').getContext('2d');
        const initialData = calculateATAS();

        radarChartInstance = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: [
                    `Clinical (${initialData.scores.clinical}/6)`, `Microbio (${initialData.scores.microbiology}/4)`, `Rationality (${initialData.scores.rationality}/5)`,
                    `Safety (${initialData.scores.safety}/5)`, `Course (${initialData.scores.course}/5)`, `Rehab (${initialData.scores.rehab}/5)`
                ],
                datasets: [{
                    label: 'ATAS Score',
                    data: Object.values(initialData.scores),
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: '#4b5563' },
                        grid: { color: '#4b5563' },
                        pointLabels: { font: { size: 10 }, color: '#d1d5db' },
                        ticks: { beginAtZero: true, max: 6, stepSize: 1, color: '#9ca3af', backdropColor: 'transparent' }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });

        // 2. History Chart
        const historyCtx = document.getElementById('history-chart').getContext('2d');
        historyChartInstance = new Chart(historyCtx, {
            type: 'line',
            data: { labels: [], datasets: [{ label: 'Total ATAS Score', data: [], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', fill: true, tension: 0.1, borderWidth: 2 }] },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, max: 30, grid: { color: '#4b5563' }, ticks: { color: '#9ca3af' } },
                    x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }


    // --- Event Listeners ---
    form.addEventListener('input', updateUI);
    aiSummaryBtn.addEventListener('click', handleAiSummary);
    aiDrugBtn.addEventListener('click', handleAiDrugInfo);
    addToHistoryBtn.addEventListener('click', handleAddToHistory);
    closeErrorModalBtn.addEventListener('click', hideApiError);

    // --- Initial Load ---
    document.addEventListener('DOMContentLoaded', () => {
        initCharts();
        updateUI();
        handleAddToHistory(); // Add the initial state to history

        // ИЗМЕНЕНИЕ: Блокируем кнопку ИИ-анализа при загрузке
        aiSummaryBtn.disabled = true;
    });

</script>
</body>
</html>
