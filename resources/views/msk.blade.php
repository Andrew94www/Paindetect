<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PainUS — AI-based MSK Pain Predictor</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* bg-slate-900 */
            color: #f1f5f9; /* text-slate-100 */
        }

        /* Custom Sliders */
        input[type='range'] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            background: #334155; /* bg-slate-700 */
            border-radius: 5px;
            outline: none;
            opacity: 0.7;
            transition: opacity .2s;
        }
        input[type='range']:hover {
            opacity: 1;
        }
        input[type='range']::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #38bdf8; /* bg-sky-500 */
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #0f172a; /* bg-slate-900 */
        }
        input[type='range']::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #38bdf8; /* bg-sky-500 */
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #0f172a; /* bg-slate-900 */
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1e293b; /* bg-slate-800 */
        }
        ::-webkit-scrollbar-thumb {
            background: #334155; /* bg-slate-700 */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569; /* bg-slate-600 */
        }
    </style>
</head>
<body class="min-h-screen">

<div class="container mx-auto max-w-screen-2xl p-4 md:p-8">

    <!-- === HEADER === -->
    <header class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <!-- SVG Logo (Waves -> Target) -->
            <svg width="48" height="48" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20.5 17.218C23.0649 18.847 25.153 21.657 26.352 24.9995C25.153 28.342 23.0649 31.152 20.5 32.781" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M15.5 13.1499C19.8211 15.7532 23.2093 20.0817 24.819 24.9994C23.2093 29.9172 19.8211 34.2457 15.5 36.849" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round" stroke-opacity="0.6"/>
                <path d="M10.5 9.08179C16.5772 12.6593 21.2655 18.5273 23.286 24.9995C21.2655 31.4717 16.5772 37.3397 10.5 40.9172" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round" stroke-opacity="0.3"/>
                <circle cx="36" cy="25" r="9" stroke="#f43f5e" stroke-width="2.5"/>
                <circle cx="36" cy="25" r="4" fill="#f43f5e"/>
            </svg>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">🩺 PainUS</h1>
                <p class="text-sm md:text-base text-slate-400">From Echo to Pain Insight</p>
            </div>
        </div>
        <p class="hidden md:block text-sm text-slate-500">AI-based MSK Pain Prediction Tool</p>
    </header>

    <!-- === MAIN CONTAINER (INPUT | OUTPUT) === -->
    <div class="flex flex-col lg:flex-row gap-6">

        <!-- === LEFT COLUMN: DATA INPUT === -->
        <div class="lg:w-2/5 w-full">
            <div class="lg:sticky lg:top-6 flex flex-col gap-6">

                <!-- 1. US-Scan Module -->
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg">
                    <h2 class="text-xl font-semibold p-4 border-b border-slate-700 text-sky-400">1. US-Scan Module</h2>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Inputs -->
                        <div>
                            <label for="muscle_tendon_thickness_mm" class="text-sm font-medium text-slate-300">Muscle/Tendon Thickness (mm)</label>
                            <input type="number" id="muscle_tendon_thickness_mm" value="10.0" step="0.5" class="mt-1 w-full bg-slate-700 border border-slate-600 rounded-md p-2 text-white shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        </div>
                        <div>
                            <label for="echogenicity" class="text-sm font-medium text-slate-300">Echogenicity</label>
                            <select id="echogenicity" class="mt-1 w-full bg-slate-700 border border-slate-600 rounded-md p-2 text-white shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                <option value="normal">Normal</option>
                                <option value="hypo">Hypo</option>
                                <option value="hyper">Hyper</option>
                                <option value="heterogeneous">Heterogeneous</option>
                            </select>
                        </div>
                        <div>
                            <label for="nerve_thickness_mm" class="text-sm font-medium text-slate-300">Nerve Thickness (mm)</label>
                            <input type="number" id="nerve_thickness_mm" value="2.6" step="0.1" class="mt-1 w-full bg-slate-700 border border-slate-600 rounded-md p-2 text-white shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        </div>
                        <div>
                            <label for="elastography_kpa" class="text-sm font-medium text-slate-300">Elastography (kPa)</label>
                            <input type="number" id="elastography_kpa" value="0.0" step="1.0" class="mt-1 w-full bg-slate-700 border border-slate-600 rounded-md p-2 text-white shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="doppler_grade" class="text-sm font-medium text-slate-300">Doppler Activity: <span id="doppler_grade_value" class="font-bold text-sky-400">0</span></label>
                            <input type="range" id="doppler_grade" min="0" max="3" value="0" step="1" class="w-full mt-2">
                        </div>
                        <!-- Checkboxes -->
                        <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="edema" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Edema</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="fibrosis" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Fibrosis</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="calcifications" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Calcifications</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="nerve_hypoechoic" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Nerve Hypoechoic</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="perineural_edema" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Perineural Edema</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 2. Pain-Area Module -->
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg">
                    <h2 class="text-xl font-semibold p-4 border-b border-slate-700 text-sky-400">2. Pain-Area Module</h2>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="body_region" class="text-sm font-medium text-slate-300">Body Region</label>
                            <select id="body_region" class="mt-1 w-full bg-slate-700 border border-slate-600 rounded-md p-2 text-white shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                <option>Shoulder</option>
                                <option>Cervical</option>
                                <option>Lumbar</option>
                                <option>Knee</option>
                                <option>Hip</option>
                                <option>Stump</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="flex flex-col justify-center gap-2">
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="spread_multisegment" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Multi-segment Spread</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="asymmetry" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Asymmetry</span>
                            </label>
                        </div>
                        <div class="md:col-span-2">
                            <label for="area_percent_region" class="text-sm font-medium text-slate-300">Pain Area (% of region): <span id="area_percent_region_value" class="font-bold text-sky-400">20</span>%</label>
                            <input type="range" id="area_percent_region" min="0" max="100" value="20" step="1" class="w-full mt-2">
                        </div>
                    </div>
                </div>

                <!-- 3. Clinical-Psych Module -->
                <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg">
                    <h2 class="text-xl font-semibold p-4 border-b border-slate-700 text-sky-400">3. Clinical-Psych Module</h2>
                    <div class="p-4 flex flex-col gap-4">
                        <div>
                            <label for="duration_weeks" class="text-sm font-medium text-slate-300">Pain Duration (weeks)</label>
                            <input type="number" id="duration_weeks" value="8.0" step="1.0" class="mt-1 w-full bg-slate-700 border border-slate-600 rounded-md p-2 text-white shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        </div>
                        <div>
                            <label for="nrs_now" class="text-sm font-medium text-slate-300">NRS (Now): <span id="nrs_now_value" class="font-bold text-sky-400">5</span> / 10</label>
                            <input type="range" id="nrs_now" min="0" max="10" value="5" step="1" class="w-full mt-2">
                        </div>
                        <div>
                            <label for="pcs" class="text-sm font-medium text-slate-300">PCS: <span id="pcs_value" class="font-bold text-sky-400">16</span> / 52</label>
                            <input type="range" id="pcs" min="0" max="52" value="16" step="1" class="w-full mt-2">
                        </div>
                        <div>
                            <label for="hads_a" class="text-sm font-medium text-slate-300">HADS-A: <span id="hads_a_value" class="font-bold text-sky-400">6</span> / 21</label>
                            <input type="range" id="hads_a" min="0" max="21" value="6" step="1" class="w-full mt-2">
                        </div>
                        <div>
                            <label for="hads_d" class="text-sm font-medium text-slate-300">HADS-D: <span id="hads_d_value" class="font-bold text-sky-400">5</span> / 21</label>
                            <input type="range" id="hads_d" min="0" max="21" value="5" step="1" class="w-full mt-2">
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="traumatic_origin" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Traumatic Origin</span>
                            </label>
                            <label class="flex items-center gap-2 p-2 bg-slate-700 rounded-md cursor-pointer hover:bg-slate-600">
                                <input type="checkbox" id="sleep_quality_poor" class="h-5 w-5 rounded text-sky-500 bg-slate-600 border-slate-500 focus:ring-sky-600">
                                <span class="text-sm text-slate-200">Poor Sleep</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Analysis Button -->
                <button id="analyze-button" class="w-full text-lg font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-lg p-4 shadow-lg transition-all duration-300 transform hover:scale-102">
                    Run AI Analysis & Add to History
                </button>

                <button id="export-csv-button" class="w-full text-base font-medium text-sky-400 bg-slate-700 hover:bg-slate-600 rounded-lg p-3 shadow-md transition-all duration-300">
                    Export History (CSV)
                </button>

            </div>
        </div>

        <!-- === RIGHT COLUMN: ANALYSIS RESULTS === -->
        <div class="lg:w-3/5 w-full">

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">PainUS Analysis Results</h2>

            <!-- === Loading / AI Simulation State === -->
            <div id="loading-state" class="hidden flex-col items-center justify-center h-[500px] bg-slate-800 border border-slate-700 rounded-xl p-8 shadow-lg">
                <!-- "Neural Net" SVG Icon -->
                <svg class="w-24 h-24 text-sky-500 pulse-animation" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 15V19M12 9V5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15 12H19M9 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.6568 17.6568L19.071 19.071M4.9289 4.92896L6.34311 6.34317" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.6568 6.34317L19.071 4.92896M4.9289 19.071L6.34311 17.6568" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="text-center mt-6">
                    <p class="text-2xl font-semibold text-slate-200">Analyzing data...</p>
                    <p class="text-lg text-slate-400 mt-1">Simulating neural network</p>
                </div>
            </div>

            <!-- === Results State === -->
            <div id="results-state" class="hidden">
                <div class="flex flex-col gap-6">

                    <!-- Main Metrics (Risk + Duration) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- 1. Risk (Gauge) -->
                        <div class="md:col-span-2 bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-6 flex flex-col md:flex-row items-center justify-center gap-6">
                            <!-- SVG Donut Chart -->
                            <div class="relative w-48 h-48">
                                <svg class="w-full h-full" viewBox="0 0 120 120">
                                    <!-- Background Circle -->
                                    <circle cx="60" cy="60" r="50" fill="none" stroke="#334155" stroke-width="12" />
                                    <!-- Progress Circle -->
                                    <circle id="risk-circle" cx="60" cy="60" r="50" fill="none"
                                            stroke="#f43f5e" <!-- red-500 -->
                                    stroke-width="12"
                                    stroke-linecap="round"
                                    transform="rotate(-90 60 60)"
                                    style="stroke-dasharray: 314; stroke-dashoffset: 314; transition: stroke-dashoffset 1s ease-out;"
                                    />
                                </svg>
                                <!-- Text Inside -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span id="risk-percent" class="text-4xl font-bold text-white">0%</span>
                                    <span class="text-sm text-slate-400">Risk</span>
                                </div>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-2xl font-bold text-white">Chronic Pain Risk</h3>
                                <p class="text-lg text-slate-300 mt-2">Probability that the pain will become chronic (>3 months).</p>
                                <p id="risk-level-text" class="text-xl font-semibold mt-4 text-slate-400">Low Risk</p>
                            </div>
                        </div>

                        <!-- 2. Duration -->
                        <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-6 flex flex-col items-center justify-center text-center">
                            <h3 class="text-lg font-semibold text-slate-400">Estimated Rehab Duration</h3>
                            <div class="my-4">
                                <span id="rehab-duration" class="text-6xl font-bold text-sky-400">0.0</span>
                                <span class="text-2xl text-slate-400 ml-1">wks</span>
                            </div>
                            <p class="text-sm text-slate-500">Forecast based on US-data and clinical factors.</p>
                        </div>

                    </div>

                    <!-- NEW: Prognosis Trend (Line Chart) -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Prognosis Trend (Patient History)</h3>
                        <div class="relative h-64">
                            <canvas id="line-chart"></canvas>
                        </div>
                    </div>

                    <!-- NEW: Key Risk Factors (Horizontal Bar) -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Key Risk Factors (Explainable AI)</h3>
                        <div class="relative h-48">
                            <canvas id="bar-chart"></canvas>
                        </div>
                    </div>

                    <!-- AI Pain Profile (Radar Chart) -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">AI Pain Profile (Radar)</h3>
                        <div class="relative h-64 md:h-80">
                            <canvas id="radar-chart"></canvas>
                        </div>
                    </div>

                    <!-- Pain Mechanism (Bar Chart) -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Pain Mechanism — Probabilities</h3>
                        <div class="space-y-4">
                            <!-- Nociceptive -->
                            <div class="w-full">
                                <div class="flex justify-between mb-1">
                                    <span class="text-base font-medium text-slate-300">Nociceptive</span>
                                    <span id="prob-nociceptive-text" class="text-base font-medium text-slate-300">0%</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-4">
                                    <div id="prob-nociceptive-bar" class="bg-emerald-500 h-4 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- Neuropathic -->
                            <div class="w-full">
                                <div class="flex justify-between mb-1">
                                    <span class="text-base font-medium text-slate-300">Neuropathic</span>
                                    <span id="prob-neuropathic-text" class="text-base font-medium text-slate-300">0%</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-4">
                                    <div id="prob-neuropathic-bar" class="bg-yellow-500 h-4 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- Nociplastic -->
                            <div class="w-full">
                                <div class="flex justify-between mb-1">
                                    <span class="text-base font-medium text-slate-300">Nociplastic</span>
                                    <span id="prob-nociplastic-text" class="text-base font-medium text-slate-300">0%</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-4">
                                    <div id="prob-nociplastic-bar" class="bg-purple-500 h-4 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Indices (Progress Bars) -->
                    <div class="bg-slate-800 border border-slate-700 rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Calculated Indices (0–10)</h3>
                        <div class="space-y-4">
                            <!-- US-Index -->
                            <div class="w-full">
                                <div class="flex justify-between mb-1">
                                    <span class="text-base font-medium text-slate-300">US-Index (Morphology)</span>
                                    <span id="index-us-text" class="text-base font-medium text-sky-400">0.0 / 10</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2.5">
                                    <div id="index-us-bar" class="bg-sky-500 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- Pain Field Index -->
                            <div class="w-full">
                                <div class="flex justify-between mb-1">
                                    <span class="text-base font-medium text-slate-300">Pain Field Index (Area)</span>
                                    <span id="index-pain-text" class="text-base font-medium text-sky-400">0.0 / 10</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2.5">
                                    <div id="index-pain-bar" class="bg-sky-500 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                                </div>
                            </div>
                            <!-- Psychosocial Index -->
                            <div class="w-full">
                                <div class="flex justify-between mb-1">
                                    <span class="text-base font-medium text-slate-300">Psychosocial Index (Factors)</span>
                                    <span id="index-psych-text" class="text-base font-medium text-sky-400">0.0 / 10</span>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-2.5">
                                    <div id="index-psych-bar" class="bg-sky-500 h-2.5 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    // === JAVASCRIPT LOGIC PORT FROM PYTHON ===

    // --- Helper Functions (ported from numpy/math) ---
    function clamp(x, lo, hi) {
        return Math.max(lo, Math.min(hi, x));
    }

    function logistic(x) {
        return 1.0 / (1.0 + Math.exp(-x));
    }

    function zscore(x, mean, sd) {
        if (sd <= 0) return 0.0;
        return (x - mean) / sd;
    }

    function softmax(vec) {
        const v = vec.map(x => x - Math.max(...vec));
        const e = v.map(x => Math.exp(x));
        const sum = e.reduce((a, b) => a + b, 0);
        return e.map(x => x / sum);
    }

    // --- 1. US-Scan Module ---
    function computeUsIndex(p) {
        const t_z = Math.abs(zscore(p.muscle_tendon_thickness_mm, 10.0, 4.0));
        const nerve_z = zscore(p.nerve_thickness_mm, 2.5, 0.8);
        const echo_map = {"normal": 0.0, "hypo": 0.8, "hyper": 0.6, "heterogeneous": 1.0};
        const echo_score = echo_map[p.echogenicity] || 0.0;
        const comp_inflammation = (0.4 * echo_score + 0.3 * (p.edema ? 1 : 0) + 0.2 * (p.doppler_grade / 3.0) + 0.1 * (p.elastography_kpa > 45 ? 1 : 0));
        const comp_fibrosis = 0.6 * (p.fibrosis ? 1 : 0) + 0.4 * clamp(p.elastography_kpa / 80.0, 0.0, 1.0);
        const comp_calc = p.calcifications ? 1.0 : 0.0;
        const comp_nerve = clamp(0.5 * Math.max(0.0, nerve_z / 2.0) + 0.5 * (p.nerve_hypoechoic ? 1 : 0) + 0.3 * (p.perineural_edema ? 1 : 0), 0.0, 2.0);
        const raw = (2.0 * t_z + 3.0 * comp_inflammation + 2.0 * comp_fibrosis + 1.0 * comp_calc + 3.0 * comp_nerve);
        const us_index = clamp(raw * (10.0 / 12.0), 0.0, 10.0);
        const dbg = { t_z, nerve_z, echo_score, comp_inflammation, comp_fibrosis, comp_calc, comp_nerve, raw };
        return { us_index, dbg };
    }

    // --- 2. Pain-Area Module ---
    function computePainFieldIndex(p) {
        const area_score = clamp(p.area_percent_region / 100.0, 0.0, 1.0);
        const spread_score = p.spread_multisegment ? 0.6 : 0.0;
        const asym_score = p.asymmetry ? 0.3 : 0.0;
        const raw = 5.0 * area_score + 3.0 * spread_score + 2.0 * asym_score;
        const pfi = clamp(raw, 0.0, 10.0);
        const dbg = { area_score, spread_score, asym_score, raw };
        return { pfi, dbg };
    }

    // --- 3. Clinical-Psych Module ---
    function computePsychosocialIndex(p) {
        const nrs_norm = clamp(p.nrs_now / 10.0, 0.0, 1.0);
        const dur_score = clamp(Math.log1p(p.duration_weeks) / Math.log1p(52), 0.0, 1.0); // 1-year scale
        const pcs_score = clamp(p.pcs / 52.0, 0.0, 1.0);
        const hads_score = clamp((p.hads_a + p.hads_d) / 42.0, 0.0, 1.0);
        const sleep_score = p.sleep_quality_poor ? 0.2 : 0.0;
        const trauma_bonus = p.traumatic_origin ? 0.1 : 0.0;
        const raw = 3.0 * nrs_norm + 2.0 * dur_score + 2.0 * pcs_score + 2.0 * hads_score + 0.7 * sleep_score + 0.3 * trauma_bonus;
        const psi = clamp(raw, 0.0, 10.0);
        const dbg = { nrs_norm, dur_score, pcs_score, hads_score, sleep_score, trauma_bonus, raw };
        return { psi, dbg };
    }

    // --- 4. Integration & Predictions ---
    function predictOutcomes(indices, us_dbg, pfi_dbg, psy_dbg) {
        const { us_index, pain_field_index, psychosocial_index } = indices;
        const composite = 0.45 * us_index + 0.35 * pain_field_index + 0.40 * psychosocial_index;
        const x = (composite - 9.0) / 2.8;
        const risk_chronic_pain_pct = logistic(x) * 100.0;

        const inflam = us_dbg.comp_inflammation || 0.0;
        const nerve = us_dbg.comp_nerve || 0.0;
        const area_w = pfi_dbg.area_score || 0.0;
        const psycho = (psy_dbg.pcs_score || 0.0) + (psy_dbg.hads_score || 0.0);
        const nociceptive_signal = 1.2 * inflam + 0.5 * us_index;
        const neuropathic_signal = 1.5 * nerve + 0.4 * us_index;
        const nociplastic_signal = 1.0 * (area_w * 2.0 + pain_field_index / 2.0) + 1.2 * psycho;
        const probs = softmax([nociceptive_signal, neuropathic_signal, nociplastic_signal]);

        const base = 4.0;
        let dur = base + 0.12 * risk_chronic_pain_pct + 0.6 * pain_field_index + 0.5 * us_index;
        const rehab_duration_weeks = clamp(dur, 2.0, 52.0);

        return {
            risk_chronic_pain_pct,
            rehab_duration_weeks,
            pain_type_probs: {
                nociceptive: probs[0],
                neuropathic: probs[1],
                nociplastic: probs[2],
            }
        };
    }

    // === INTERFACE (DOM) MANAGEMENT ===

    // Global variables for chart instances
    let radarChartInstance = null;
    let lineChartInstance = null;
    let barChartInstance = null;

    // Global history
    let prognosisHistory = [];

    // Chart.js global styling
    Chart.defaults.color = '#cbd5e1'; // slate-300
    Chart.defaults.font.family = 'Inter, sans-serif';

    document.addEventListener('DOMContentLoaded', () => {

        // --- Get DOM Elements ---
        const inputs = {
            muscle_tendon_thickness_mm: document.getElementById('muscle_tendon_thickness_mm'),
            echogenicity: document.getElementById('echogenicity'),
            edema: document.getElementById('edema'),
            fibrosis: document.getElementById('fibrosis'),
            calcifications: document.getElementById('calcifications'),
            nerve_thickness_mm: document.getElementById('nerve_thickness_mm'),
            nerve_hypoechoic: document.getElementById('nerve_hypoechoic'),
            perineural_edema: document.getElementById('perineural_edema'),
            doppler_grade: document.getElementById('doppler_grade'),
            elastography_kpa: document.getElementById('elastography_kpa'),
            body_region: document.getElementById('body_region'),
            area_percent_region: document.getElementById('area_percent_region'),
            spread_multisegment: document.getElementById('spread_multisegment'),
            asymmetry: document.getElementById('asymmetry'),
            nrs_now: document.getElementById('nrs_now'),
            duration_weeks: document.getElementById('duration_weeks'),
            traumatic_origin: document.getElementById('traumatic_origin'),
            pcs: document.getElementById('pcs'),
            hads_a: document.getElementById('hads_a'),
            hads_d: document.getElementById('hads_d'),
            sleep_quality_poor: document.getElementById('sleep_quality_poor'),
        };

        const valueSpans = {
            doppler_grade_value: document.getElementById('doppler_grade_value'),
            area_percent_region_value: document.getElementById('area_percent_region_value'),
            nrs_now_value: document.getElementById('nrs_now_value'),
            pcs_value: document.getElementById('pcs_value'),
            hads_a_value: document.getElementById('hads_a_value'),
            hads_d_value: document.getElementById('hads_d_value'),
        };

        const outputs = {
            loadingState: document.getElementById('loading-state'),
            resultsState: document.getElementById('results-state'),
            riskCircle: document.getElementById('risk-circle'),
            riskPercent: document.getElementById('risk-percent'),
            riskLevelText: document.getElementById('risk-level-text'),
            rehabDuration: document.getElementById('rehab-duration'),
            probNociceptiveText: document.getElementById('prob-nociceptive-text'),
            probNociceptiveBar: document.getElementById('prob-nociceptive-bar'),
            probNeuropathicText: document.getElementById('prob-neuropathic-text'),
            probNeuropathicBar: document.getElementById('prob-neuropathic-bar'),
            probNociplasticText: document.getElementById('prob-nociplastic-text'),
            probNociplasticBar: document.getElementById('prob-nociplastic-bar'),
            indexUsText: document.getElementById('index-us-text'),
            indexUsBar: document.getElementById('index-us-bar'),
            indexPainText: document.getElementById('index-pain-text'),
            indexPainBar: document.getElementById('index-pain-bar'),
            indexPsychText: document.getElementById('index-psych-text'),
            indexPsychBar: document.getElementById('index-psych-bar'),
            radarChart: document.getElementById('radar-chart'),
            lineChart: document.getElementById('line-chart'),
            barChart: document.getElementById('bar-chart'),
        };

        const analyzeButton = document.getElementById('analyze-button');
        const exportButton = document.getElementById('export-csv-button');

        const radius = outputs.riskCircle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;
        outputs.riskCircle.style.strokeDasharray = circumference;

        // --- Update Slider Values ---
        function updateSliderValue(e) {
            const id = e.target.id;
            const value = e.target.value;
            if (id === 'doppler_grade') valueSpans.doppler_grade_value.textContent = value;
            if (id === 'area_percent_region') valueSpans.area_percent_region_value.textContent = `${value}`;
            if (id === 'nrs_now') valueSpans.nrs_now_value.textContent = `${value}`;
            if (id === 'pcs') valueSpans.pcs_value.textContent = `${value}`;
            if (id === 'hads_a') valueSpans.hads_a_value.textContent = `${value}`;
            if (id === 'hads_d') valueSpans.hads_d_value.textContent = `${value}`;
        }

        [inputs.doppler_grade, inputs.area_percent_region, inputs.nrs_now, inputs.pcs, inputs.hads_a, inputs.hads_d].forEach(slider => {
            slider.addEventListener('input', updateSliderValue);
        });

        // --- Function: Read data from form ---
        function readInputs() {
            const usParams = {
                muscle_tendon_thickness_mm: parseFloat(inputs.muscle_tendon_thickness_mm.value),
                echogenicity: inputs.echogenicity.value,
                edema: inputs.edema.checked,
                fibrosis: inputs.fibrosis.checked,
                calcifications: inputs.calcifications.checked,
                nerve_thickness_mm: parseFloat(inputs.nerve_thickness_mm.value),
                nerve_hypoechoic: inputs.nerve_hypoechoic.checked,
                perineural_edema: inputs.perineural_edema.checked,
                doppler_grade: parseInt(inputs.doppler_grade.value),
                elastography_kpa: parseFloat(inputs.elastography_kpa.value),
            };
            const areaParams = {
                body_region: inputs.body_region.value,
                area_percent_region: parseFloat(inputs.area_percent_region.value),
                spread_multisegment: inputs.spread_multisegment.checked,
                asymmetry: inputs.asymmetry.checked,
            };
            const cpParams = {
                nrs_now: parseInt(inputs.nrs_now.value),
                duration_weeks: parseFloat(inputs.duration_weeks.value),
                traumatic_origin: inputs.traumatic_origin.checked,
                pcs: parseInt(inputs.pcs.value),
                hads_a: parseInt(inputs.hads_a.value),
                hads_d: parseInt(inputs.hads_d.value),
                sleep_quality_poor: inputs.sleep_quality_poor.checked,
            };
            return { usParams, areaParams, cpParams };
        }

        // --- Chart Update Functions ---

        function updateRadarChart(indices, psy_dbg) {
            const ctx = outputs.radarChart.getContext('2d');
            const { nrs_norm, dur_score } = psy_dbg;
            const data = [
                indices.us_index,
                indices.pain_field_index,
                indices.psychosocial_index,
                (nrs_norm || 0) * 10,
                (dur_score || 0) * 10
            ];

            if (radarChartInstance) radarChartInstance.destroy();
            radarChartInstance = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['Morphology (US)', 'Pain Field', 'Psychosocial', 'Intensity (NRS)', 'Chronicity'],
                    datasets: [{
                        label: 'Pain Profile',
                        data: data,
                        fill: true,
                        backgroundColor: 'rgba(56, 189, 248, 0.2)', // sky-500/20
                        borderColor: '#0ea5e9', // sky-500
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0ea5e9',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: { color: 'rgba(255, 255, 255, 0.2)' },
                            grid: { color: 'rgba(255, 255, 255, 0.2)' },
                            pointLabels: { color: '#f1f5f9', font: { size: 12 } },
                            ticks: { backdropColor: '#0f172a', color: '#cbd5e1', stepSize: 2.5, max: 10, min: 0, font: { size: 10 } }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        function updateLineChart(history) {
            const ctx = outputs.lineChart.getContext('2d');
            const labels = history.map(h => `Session ${h.session}`);
            const data = history.map(h => h.risk.toFixed(1));

            if (lineChartInstance) lineChartInstance.destroy();
            lineChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Chronic Pain Risk (%)',
                        data: data,
                        fill: true,
                        borderColor: '#38bdf8', // sky-500
                        backgroundColor: 'rgba(56, 189, 248, 0.1)',
                        tension: 0.1,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#38bdf8',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            ticks: { color: '#cbd5e1' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#cbd5e1' }
                        }
                    },
                    plugins: { legend: { labels: { color: '#f1f5f9' } } }
                }
            });
        }

        function updateBarChart(indices) {
            const ctx = outputs.barChart.getContext('2d');
            // Weights from the prediction model
            const us_contrib = indices.us_index * 0.45;
            const pain_contrib = indices.pain_field_index * 0.35;
            const psych_contrib = indices.psychosocial_index * 0.40;

            const data = [us_contrib, pain_contrib, psych_contrib];

            if (barChartInstance) barChartInstance.destroy();
            barChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['US-Index (Morphology)', 'Pain Field (Area)', 'Psychosocial (Factors)'],
                    datasets: [{
                        label: 'Weighted Contribution to Risk',
                        data: data,
                        backgroundColor: [
                            'rgba(56, 189, 248, 0.7)', // sky-500
                            'rgba(234, 179, 8, 0.7)',  // yellow-500
                            'rgba(168, 85, 247, 0.7)' // purple-500
                        ],
                        borderColor: [
                            '#38bdf8',
                            '#eab308',
                            '#a855f7'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Makes it a horizontal bar chart
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            ticks: { color: '#cbd5e1' }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { color: '#cbd5e1' }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }


        // --- Function: Display Results ---
        function displayResults(indices, predictions, psy_dbg) {
            // 1. Risk (Gauge)
            const risk = predictions.risk_chronic_pain_pct;
            const offset = circumference * (1 - (risk / 100));
            outputs.riskCircle.style.strokeDashoffset = offset;
            outputs.riskPercent.textContent = `${Math.round(risk)}%`;

            let riskLevel, riskColor;
            if (risk < 33) {
                riskLevel = 'Low Risk'; riskColor = '#22c55e'; // emerald-500
            } else if (risk < 66) {
                riskLevel = 'Medium Risk'; riskColor = '#eab308'; // yellow-500
            } else {
                riskLevel = 'High Risk'; riskColor = '#ef4444'; // red-500
            }
            outputs.riskLevelText.textContent = riskLevel;
            outputs.riskCircle.style.stroke = riskColor;

            // 2. Duration
            outputs.rehabDuration.textContent = predictions.rehab_duration_weeks.toFixed(1);

            // 3. Pain Mechanism
            const probs = predictions.pain_type_probs;
            outputs.probNociceptiveBar.style.width = `${probs.nociceptive * 100}%`;
            outputs.probNociceptiveText.textContent = `${(probs.nociceptive * 100).toFixed(0)}%`;
            outputs.probNeuropathicBar.style.width = `${probs.neuropathic * 100}%`;
            outputs.probNeuropathicText.textContent = `${(probs.neuropathic * 100).toFixed(0)}%`;
            outputs.probNociplasticBar.style.width = `${probs.nociplastic * 100}%`;
            outputs.probNociplasticText.textContent = `${(probs.nociplastic * 100).toFixed(0)}%`;

            // 4. Indices
            outputs.indexUsBar.style.width = `${indices.us_index * 10}%`;
            outputs.indexUsText.textContent = `${indices.us_index.toFixed(1)} / 10`;
            outputs.indexPainBar.style.width = `${indices.pain_field_index * 10}%`;
            outputs.indexPainText.textContent = `${indices.pain_field_index.toFixed(1)} / 10`;
            outputs.indexPsychBar.style.width = `${indices.psychosocial_index * 10}%`;
            outputs.indexPsychText.textContent = `${indices.psychosocial_index.toFixed(1)} / 10`;

            // 5. Update Charts
            updateRadarChart(indices, psy_dbg);
            updateLineChart(prognosisHistory); // Pass the full history
            updateBarChart(indices);
        }

        // --- Main Function: Run Analysis ---
        function runAnalysis() {
            // 1. Show loader
            outputs.loadingState.classList.remove('hidden');
            outputs.loadingState.classList.add('flex');
            outputs.resultsState.classList.add('hidden');
            outputs.resultsState.classList.remove('fade-in');

            // 2. Read inputs
            const { usParams, areaParams, cpParams } = readInputs();

            // 3. Perform calculations
            const { us_index, dbg: us_dbg } = computeUsIndex(usParams);
            const { pfi, dbg: pfi_dbg } = computePainFieldIndex(areaParams);
            const { psi, dbg: psy_dbg } = computePsychosocialIndex(cpParams);

            const indices = {
                us_index: us_index,
                pain_field_index: pfi,
                psychosocial_index: psi
            };

            const predictions = predictOutcomes(indices, us_dbg, pfi_dbg, psy_dbg);

            // 4. ADD TO HISTORY
            prognosisHistory.push({
                session: prognosisHistory.length + 1,
                risk: predictions.risk_chronic_pain_pct,
                us_index: indices.us_index,
                pain_field_index: indices.pain_field_index,
                psychosocial_index: indices.psychosocial_index,
                nrs: cpParams.nrs_now,
                duration: cpParams.duration_weeks
            });

            // 5. Simulate AI delay
            setTimeout(() => {
                // 6. Display results
                displayResults(indices, predictions, psy_dbg);

                // 7. Hide loader, show results
                outputs.loadingState.classList.add('hidden');
                outputs.loadingState.classList.remove('flex');
                outputs.resultsState.classList.remove('hidden');
                // Add fade-in animation
                requestAnimationFrame(() => {
                    outputs.resultsState.classList.add('fade-in');
                });

            }, 1500); // 1.5 second simulation
        }

        // --- Function: Export CSV ---
        function exportCSV() {
            if (prognosisHistory.length === 0) {
                // You might want to show a custom modal/alert here
                console.log("No history to export.");
                return;
            }

            let csvContent = "data:text/csv;charset=utf-8,";
            // Add Headers
            const headers = Object.keys(prognosisHistory[0]).join(",");
            csvContent += headers + "\r\n";

            // Add Rows
            prognosisHistory.forEach(session => {
                // Format values (e.g., toFixed)
                let row = [
                    session.session,
                    session.risk.toFixed(2),
                    session.us_index.toFixed(2),
                    session.pain_field_index.toFixed(2),
                    session.psychosocial_index.toFixed(2),
                    session.nrs,
                    session.duration
                ].join(",");
                csvContent += row + "\r\n";
            });

            // Create and Trigger Download
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "painus_history.csv");
            document.body.appendChild(link); // Required for Firefox
            link.click();
            document.body.removeChild(link);
        }

        // --- Assign Handlers ---
        analyzeButton.addEventListener('click', runAnalysis);
        exportButton.addEventListener('click', exportCSV);

        // --- Run analysis on initial load ---
        runAnalysis();
    });
</script>
</body>
</html>

