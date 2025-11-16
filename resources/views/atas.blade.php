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
            white-space: pre-wrap; /* Сохраняет форматирование ответа */
            font-size: 0.875rem;
            line-height: 1.6;
            color: #d1d5db;
        }
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
        <!-- AI Summary -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">3. AI ATAS Summary</h2>
            </div>
            <div class="card-content">
                <p class="text-sm text-gray-400 mb-4">Click for the AI to analyze the current ATAS score and provide a clinical summary and recommendations.</p>
                <button id="ai-summary-btn" class="btn w-full">
                    <span class="loading-spinner hidden"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 icon"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zM8 12h8M12 8v8"/></svg>
                    <span class="btn-text">Generate AI Summary</span>
                </button>
                <div id="ai-summary-output" class="ai-response mt-4" placeholder="AI summary will appear here..."></div>
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
                    <!-- ИЗМЕНЕНИЕ: Добавлен list="antibiotic-suggestions" -->
                    <input type="text" id="drug-input" class="form-input" list="antibiotic-suggestions" placeholder="e.g., 'Amoxicillin' or 'Ciprofloxacin'">
                    <button id="ai-drug-btn" class="btn">
                        <span class="loading-spinner hidden"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 icon"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.3"/></svg>
                        <span class="btn-text">Search</span>
                    </button>
                </div>

                <!-- ИЗМЕНЕНИЕ: Добавлен <datalist> -->
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
    const API_KEY = ""; // Canvas will provide this.
    const GENERATE_CONTENT_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key=${API_KEY}`;

    // --- Chart.js Instances ---
    let radarChartInstance = null;
    let historyChartInstance = null;

    // --- Application State ---
    let atasHistory = []; // Array to store score history

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

    /**
     * Shows the API error modal
     * @param {string} message - The error message
     */
    function showApiError(message) {
        console.error("API Error:", message);
        errorModalMessage.textContent = message || "Failed to execute request. Please try again later.";
        errorModal.classList.remove('hidden');
    }

    /**
     * Hides the API error modal
     */
    function hideApiError() {
        errorModal.classList.add('hidden');
    }

    /**
     * Manages the button loading state
     * @param {HTMLElement} button - The button element
     * @param {boolean} isLoading - The loading state
     */
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
                if (button.id === 'ai-summary-btn') text.textContent = 'Generate AI Summary';
                else if (button.id === 'ai-drug-btn') text.textContent = 'Search';
            }
        }
    }

    /**
     * Performs a Gemini API call with exponential backoff
     * @param {object} payload - The request payload
     * @param {number} maxRetries - Maximum number of retries
     * @returns {Promise<object>} - The JSON response
     */
    async function fetchWithExponentialBackoff(payload, maxRetries = 5) {
        let delay = 1000;
        for (let i = 0; i < maxRetries; i++) {
            try {
                const response = await fetch(GENERATE_CONTENT_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`HTTP error! status: ${response.status}, ${errorText}`);
                }

                const result = await response.json();

                if (!result.candidates || !result.candidates[0].content || !result.candidates[0].content.parts[0].text) {
                    if (result.candidates && result.candidates[0].finishReason === 'SAFETY') {
                        throw new Error("Request was blocked for safety reasons.");
                    }
                    throw new Error("Unexpected API response structure.");
                }

                return result;

            } catch (error) {
                console.warn(`Attempt ${i + 1} failed: ${error.message}. Retrying in ${delay}ms...`);
                if (i === maxRetries - 1) throw error; // Last attempt failed
                await new Promise(resolve => setTimeout(resolve, delay));
                delay *= 2; // Exponential backoff
            }
        }
    }

    // --- Core Application Logic ---

    /**
     * Calculates the ATAS score based on the form
     * @returns {object} - Object with category scores, total, and interpretation
     */
    function calculateATAS() {
        const getVal = (id) => parseInt(document.getElementById(id).value, 10);

        // 1. Clinical Efficacy (max 6)
        const s1 = getVal('s1_infection') + getVal('s1_temp') + getVal('s1_labs');

        // 2. Microbiological Control (max 4)
        const s2 = Math.min(4, getVal('s2_pathogen') + getVal('s2_sensitivity'));

        // 3. Therapy Rationality (max 5)
        const s3 = Math.min(5, getVal('s3_protocol') + getVal('s3_dosage') + getVal('s3_deescalation'));

        // 4. Safety (max 5)
        // Adding +1 for "Interactions" (assuming +1 for no issues by default)
        const s4 = Math.min(5, getVal('s4_side_effects') + getVal('s4_toxicity') + getVal('s4_cdiff') + 1);

        // 5. Impact on Disease Course (max 5)
        // Adding +1 for "Prophylaxis" and +1 for something else (up to 5)
        const s5 = Math.min(5, getVal('s5_reoperation') + getVal('s5_wound') + 1 + 1);

        // 6. Impact on Rehab & Pain (max 5)
        // Adding +2 for "Functional Status" (up to 5)
        const s6 = Math.min(5, getVal('s6_rehab_delay') + getVal('s6_neurotoxicity') + getVal('s6_neuropathic') + 2);

        const total = s1 + s2 + s3 + s4 + s5 + s6;

        let interpretation = "";
        if (total <= 10) interpretation = "Ineffective/Unsafe Treatment";
        else if (total <= 18) interpretation = "Doubtful Result — Correction Needed";
        else if (total <= 25) interpretation = "Good, but Monitoring Required";
        else interpretation = "Effective and Safe";

        return {
            scores: {
                clinical: s1,
                microbiology: s2,
                rationality: s3,
                safety: s4,
                course: s5,
                rehab: s6
            },
            total: total,
            interpretation: interpretation
        };
    }

    /**
     * Updates the UI (score and charts)
     */
    function updateUI() {
        const { scores, total, interpretation } = calculateATAS();

        scoreTotalEl.textContent = total;
        scoreInterpretationEl.textContent = interpretation;

        // Update Radar Chart
        if (radarChartInstance) {
            radarChartInstance.data.datasets[0].data = Object.values(scores);
            // Update labels to reflect new scores
            radarChartInstance.data.labels = [
                `Clinical (${scores.clinical}/6)`,
                `Microbio (${scores.microbiology}/4)`,
                `Rationality (${scores.rationality}/5)`,
                `Safety (${scores.safety}/5)`,
                `Course (${scores.course}/5)`,
                `Rehab (${scores.rehab}/5)`
            ];
            radarChartInstance.update();
        }
    }

    /**
     * Adds the current score to history and updates the history chart
     */
    function handleAddToHistory() {
        const { total } = calculateATAS();
        const label = `Day ${atasHistory.length + 1}`;

        atasHistory.push({ label, total });

        // Update Line Chart
        if (historyChartInstance) {
            historyChartInstance.data.labels = atasHistory.map(h => h.label);
            historyChartInstance.data.datasets[0].data = atasHistory.map(h => h.total);
            historyChartInstance.update();
        }
    }

    // --- AI Handlers ---

    /**
     * Handler for the "Generate AI Summary" button
     */
    async function handleAiSummary() {
        setButtonLoading(aiSummaryBtn, true);
        aiSummaryOutput.textContent = 'Generating report...';

        const { scores, total, interpretation } = calculateATAS();
        const formData = {
            totalScore: total,
            interpretation: interpretation,
            details: {
                "Clinical Efficacy": `${scores.clinical}/6`,
                "Microbiology": `${scores.microbiology}/4`,
                "Rationality": `${scores.rationality}/5`,
                "Safety": `${scores.safety}/5`,
                "Disease Course": `${scores.course}/5`,
                "Rehab & Pain": `${scores.rehab}/5`,
            }
        };

        const systemPrompt = "You are an experienced clinical pharmacologist. Analyze the provided ATAS (Antibiotic Treatment Assessment Score) data. Provide a brief, structured summary in English. You must include: 1. Overall assessment (based on interpretation). 2. Strengths (categories with high scores). 3. Risk areas (categories with low scores). 4. A brief recommendation (e.g., 'Continue monitoring', 'Therapy correction required', 'Optimal therapy').";
        const userQuery = `Analyze this ATAS data: ${JSON.stringify(formData)}`;

        const payload = {
            contents: [{ parts: [{ text: userQuery }] }],
            systemInstruction: { parts: [{ text: systemPrompt }] }
        };

        try {
            const result = await fetchWithExponentialBackoff(payload);
            const text = result.candidates[0].content.parts[0].text;
            aiSummaryOutput.textContent = text;
        } catch (error) {
            aiSummaryOutput.textContent = 'Error generating summary.';
            showApiError(error.message);
        } finally {
            setButtonLoading(aiSummaryBtn, false);
        }
    }

    /**
     * Handler for the "Search" button (Drug Info) - USES OpenFDA API
     */
    async function handleAiDrugInfo() {
        const drugName = drugInput.value.trim();
        if (!drugName) {
            aiDrugOutput.textContent = 'Please enter a drug name.';
            return;
        }

        setButtonLoading(aiDrugBtn, true);
        aiDrugOutput.textContent = `Searching OpenFDA for "${drugName}"...`;

        // Using OpenFDA API - no key required.
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

            // Helper to safely extract and truncate array data
            const getField = (field, fallback = 'N/A',
                              maxLength = 300) => {
                if (result[field] && Array.isArray(result[field]) && result[field][0]) {
                    const text = result[field][0].replace(/[\r\n]+/g, ' '); // Clean up newlines
                    return text.length > maxLength ? `${text.substring(0, maxLength)}...` : text;
                }
                return fallback;
            };

            const brandName = result.openfda?.brand_name?.[0] || drugName;
            const genericName = result.openfda?.generic_name?.[0] || 'N/A';

            const output = `
Drug: ${brandName}
Generic: ${genericName}

--- Indications & Usage ---
${getField('indications_and_usage')}

--- Dosage & Administration ---
${getField('dosage_and_administration')}

--- Adverse Reactions ---
${getField('adverse_reactions')}

--- Warnings & Cautions ---
${getField('warnings_and_cautions')}

(Data sourced from OpenFDA)
                `;

            aiDrugOutput.textContent = output.trim();

        } catch (error) {
            aiDrugOutput.textContent = 'Error fetching drug information.';
            showApiError(error.message);
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
                    `Clinical (${initialData.scores.clinical}/6)`,
                    `Microbio (${initialData.scores.microbiology}/4)`,
                    `Rationality (${initialData.scores.rationality}/5)`,
                    `Safety (${initialData.scores.safety}/5)`,
                    `Course (${initialData.scores.course}/5)`,
                    `Rehab (${initialData.scores.rehab}/5)`
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
                        pointLabels: {
                            font: { size: 10 },
                            color: '#d1d5db'
                        },
                        ticks: {
                            beginAtZero: true,
                            max: 6, // Max score of any category
                            stepSize: 1,
                            color: '#9ca3af',
                            backdropColor: 'transparent'
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // 2. History Chart
        const historyCtx = document.getElementById('history-chart').getContext('2d');
        historyChartInstance = new Chart(historyCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total ATAS Score',
                    data: [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.1,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 30, // Max ATAS score
                        grid: { color: '#4b5563' },
                        ticks: { color: '#9ca3af' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9ca3af' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
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
    });

</script>
</body>
</html>
