<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-RI: Rehab Recovery Index (CDSS)</title>
    <!-- Tailwind CSS and Inter Font -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Icon Library (Lucide) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* General Dark Mode and Typography */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0d1117; /* GitHub Dark BG */
            color: #c9d1d9; /* Light Gray Text */
        }
        /* Styling for inputs and cards */
        input[type=range]::-webkit-slider-thumb { background: #58a6ff; }
        input[type=range]::-moz-range-thumb { background: #58a6ff; }
        .card { background-color: #161b22; border: 1px solid #30363d; }
        .metric-value { font-size: 2.75rem; font-weight: 700; }
        /* R-RI Status Colors */
        .good { background-color: #2A9D8F; color: #fff; } /* Teal/Success */
        .fair { background-color: #E9C46A; color: #161b22; } /* Yellow/Warning */
        .poor { background-color: #E76F51; color: #fff; } /* Red/Danger */
        /* Phenotype Colors */
        .nociceptive-bar { background-color: #58a6ff; }
        .neuropathic-bar { background-color: #E9C46A; }
        .nociplastic-bar { background-color: #E76F51; }
        /* Heatmap Grid */
        #pain-heatmap-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(5, 1fr);
            gap: 4px;
            width: 100%;
            aspect-ratio: 3 / 5;
            max-width: 400px;
            margin: 0 auto;
        }
        .region-box {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: background-color 0.3s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        /* Tab Styles */
        .tab-button.active {
            border-bottom: 3px solid #58a6ff;
            color: #58a6ff;
        }
        .tab-button {
            transition: all 0.3s;
        }
        /* Recommendation Box */
        .recommendation-box {
            border-left-width: 4px;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .rec-success { border-left-color: #2A9D8F; background-color: #1e2329; }
        .rec-warning { border-left-color: #E9C46A; background-color: #1e2329; }
        .rec-danger { border-left-color: #E76F51; background-color: #1e2329; }

    </style>
</head>
<body class="p-4 md:p-8">

<header class="mb-6">
    <h1 class="text-4xl font-extrabold text-[#58a6ff] flex items-center">
        <i data-lucide="activity" class="w-8 h-8 mr-3 text-[#2A9D8F]"></i>
        R-RI: Rehab Recovery Index <span class="text-xl ml-2 text-gray-400">(CDSS)</span>
    </h1>
    <p class="text-gray-400 mt-1">Global Standard: Objective Metrics, AI Phenotyping, and Personalized Recommendations.</p>
</header>

<div class="card p-6 rounded-xl shadow-2xl">
    <!-- Tab Navigation -->
    <div class="border-b border-[#30363d] mb-6">
        <nav class="flex space-x-4 overflow-x-auto">
            <button class="tab-button py-2 px-4 text-lg font-medium active" data-tab="input">1. Data Entry</button>
            <button class="tab-button py-2 px-4 text-lg font-medium" data-tab="analysis">2. R-RI Analysis</button>
            <button class="tab-button py-2 px-4 text-lg font-medium" data-tab="recommendations">3. AI Recommendations</button>
        </nav>
    </div>

    <!-- Tab Content Container -->
    <div id="app-tabs">

        <!-- Tab 1: Data Entry -->
        <div class="tab-content" id="tab-input">
            <div class="grid lg:grid-cols-3 gap-8">

                <!-- Clinical Context -->
                <div class="lg:col-span-3 pb-4 border-b border-[#30363d]">
                    <h2 class="text-xl font-semibold mb-3 text-[#E9C46A] flex items-center">
                        <i data-lucide="clipboard-list" class="w-5 h-5 mr-2"></i> Clinical Context
                    </h2>
                    <div class="grid md:grid-cols-4 gap-4">
                        <label class="block">
                            <span class="text-gray-400 text-sm">Primary Diagnosis</span>
                            <input type="text" id="diagnosis" value="LBP" oninput="updateAll()" placeholder="e.g., L5-S1 Herniation" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                        </label>
                        <label class="block">
                            <span class="text-gray-400 text-sm">Age (years)</span>
                            <input type="number" id="age" value="45" min="18" max="120" step="1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                        </label>
                        <label class="block">
                            <span class="text-gray-400 text-sm">Gender</span>
                            <select id="gender" onchange="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </label>
                    </div>
                </div>

                <!-- Pain Map -->
                <div>
                    <h2 class="text-xl font-semibold mb-3 text-white flex items-center">
                        <i data-lucide="map" class="w-5 h-5 mr-2 text-white"></i> 1. Pain Map (NRS 0–10)
                    </h2>
                    <div id="pain-sliders" class="space-y-3 mb-6">
                        <!-- Sliders dynamically generated -->
                    </div>
                    <div class="bg-[#1e2329] p-4 rounded-lg flex flex-col items-center border border-[#30363d]">
                        <h3 class="text-lg font-medium mb-3 text-[#58a6ff]">Body Heatmap</h3>
                        <div id="pain-heatmap-container" class="w-full">
                            <!-- Heatmap boxes dynamically generated -->
                        </div>
                    </div>
                </div>

                <!-- PROMs, Function, and Wearables -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- PROMS -->
                    <div class="border border-[#30363d] p-4 rounded-lg">
                        <h3 class="text-xl font-medium mb-3 text-[#E9C46A] flex items-center">
                            <i data-lucide="bar-chart-2" class="w-5 h-5 mr-2"></i> Subjective Assessments (PROMs)
                        </h3>
                        <div class="grid md:grid-cols-3 gap-4">
                            <label class="block">
                                <span class="text-gray-400 text-sm">NRS: Pain (Rest)</span>
                                <input type="range" id="pain_rest" min="0" max="10" value="3" oninput="updateAll()" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                <span id="pain_rest_value" class="font-bold text-white">3</span>
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">NRS: Pain (Motion)</span>
                                <input type="range" id="pain_motion" min="0" max="10" value="5" oninput="updateAll()" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                <span id="pain_motion_value" class="font-bold text-white">5</span>
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">DN4 (Neuropathic Pain, 0-4)</span>
                                <input type="range" id="dn4_short" min="0" max="4" value="1" oninput="updateAll()" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                <span id="dn4_short_value" class="font-bold text-white">1</span>
                            </label>
                        </div>
                    </div>

                    <!-- FUNCTION -->
                    <div class="border border-[#30363d] p-4 rounded-lg">
                        <h3 class="text-xl font-medium mb-3 text-[#2A9D8F] flex items-center">
                            <i data-lucide="footprints" class="w-5 h-5 mr-2"></i> Objective Function (Tests)
                        </h3>
                        <div class="grid md:grid-cols-3 gap-4">
                            <label class="block">
                                <span class="text-gray-400 text-sm">ROM (degrees)</span>
                                <input type="number" id="rom_deg" value="90.0" min="0" max="180" step="0.1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">TUG (sec)</span>
                                <input type="number" id="tug_s" value="12.0" min="0" max="60" step="0.1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">6MWT (meters)</span>
                                <input type="number" id="sixmwt_m" value="400.0" min="0" max="1000" step="10" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">Strength (% of 100% Norm)</span>
                                <input type="number" id="strength_pct" value="90.0" min="0" max="200" step="1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">Balance: Single Leg Stance (sec)</span>
                                <input type="number" id="single_leg_s" value="20.0" min="0" max="120" step="1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                        </div>
                    </div>

                    <!-- WEARABLES/SLEEP -->
                    <div class="border border-[#30363d] p-4 rounded-lg">
                        <h3 class="text-xl font-medium mb-3 text-[#58a6ff] flex items-center">
                            <i data-lucide="watch" class="w-5 h-5 mr-2"></i> Wearables / Recovery
                        </h3>
                        <div class="grid md:grid-cols-4 gap-4">
                            <label class="block">
                                <span class="text-gray-400 text-sm">Steps/day</span>
                                <input type="number" id="steps" value="6000" min="0" max="60000" step="100" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">HRV RMSSD (ms)</span>
                                <input type="number" id="hrv_rmssd_ms" value="35.0" min="0" max="200" step="1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">Sleep Duration (h)</span>
                                <input type="number" id="sleep_duration_h" value="7.0" min="0" max="14" step="0.1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                            <label class="block">
                                <span class="text-gray-400 text-sm">Sleep Efficiency (%)</span>
                                <input type="number" id="sleep_efficiency_pct" value="85.0" min="0" max="100" step="1" oninput="updateAll()" class="w-full p-2 bg-[#1e2329] border border-gray-600 rounded-lg">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: R-RI Analysis -->
        <div class="tab-content hidden" id="tab-analysis">
            <div class="grid lg:grid-cols-4 gap-8">

                <!-- R-RI Gauge & Trend (Col 1) -->
                <div class="lg:col-span-1 text-center card p-5 rounded-xl shadow-lg">
                    <h2 class="text-xl font-semibold mb-3 text-white flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-5 h-5 mr-2"></i> R-RI Score
                    </h2>
                    <div id="rri-gauge-container" class="w-full max-w-sm mx-auto">
                        <!-- SVG Gauge will be drawn here -->
                    </div>
                    <div id="rri-status" class="mt-4 text-lg font-bold"></div>
                    <div id="trend-info" class="mt-2 text-sm text-gray-400"></div>

                    <div class="mt-6 pt-4 border-t border-[#30363d]">
                        <h3 class="text-md font-semibold mb-2 text-[#2A9D8F]">Baseline Comparison</h3>
                        <input type="file" id="baseline_file_input" accept=".json" onchange="loadBaseline()" class="text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#2A9D8F] file:text-white hover:file:bg-[#2A9D8F]/80">
                        <p id="baseline-message" class="text-xs mt-2 text-gray-500"></p>
                    </div>
                </div>

                <!-- Phenotype and Decomposition (Col 2 & 3) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="card p-5 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-white flex items-center">
                            <i data-lucide="brain" class="w-5 h-5 mr-2"></i> Pain Phenotype (AI Heuristics)
                        </h2>
                        <p class="text-gray-400 mb-4">Predicting the dominant pain mechanism for targeted therapy.</p>
                        <div id="phenotype-chart" class="space-y-3">
                            <!-- Phenotype bars will be generated here -->
                        </div>
                    </div>

                    <div class="card p-5 rounded-xl shadow-lg">
                        <h2 class="text-xl font-semibold mb-4 text-white flex items-center">
                            <i data-lucide="pie-chart" class="w-5 h-5 mr-2"></i> R-RI Decomposition
                        </h2>
                        <p class="text-gray-400 mb-4">Contribution of each weighted component to the total index score.</p>
                        <div id="decomposition-chart" class="space-y-3">
                            <!-- Decomposition bars will be generated here -->
                        </div>
                    </div>
                </div>

                <!-- KPI Block (Col 4) -->
                <div class="lg:col-span-1 space-y-4">
                    <div class="card p-5 rounded-xl shadow-lg">
                        <h3 class="text-lg font-semibold mb-3 text-[#58a6ff]">Key Performance Indicators (KPIs)</h3>
                        <div id="kpi-block" class="space-y-3">
                            <!-- Dynamic KPI metrics here -->
                        </div>
                    </div>
                    <!-- Export Button in Analysis Tab -->
                    <div class="card p-5 rounded-xl shadow-lg text-center">
                        <h2 class="text-xl font-semibold mb-4 text-white">Export Session Data</h2>
                        <button onclick="exportJSON()" class="w-full py-2 px-6 rounded-lg font-semibold bg-[#2A9D8F] text-white hover:bg-[#2A9D8F]/80 transition duration-150 flex items-center justify-center">
                            <i data-lucide="download" class="w-5 h-5 mr-2"></i> Download JSON
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 3: AI Recommendations -->
        <div class="tab-content hidden" id="tab-recommendations">
            <h2 class="text-3xl font-bold mb-6 text-[#E9C46A] flex items-center">
                <i data-lucide="lightbulb" class="w-7 h-7 mr-3"></i> Personalized Recommendations (CDSS)
            </h2>
            <p class="text-gray-400 mb-6">AI-driven suggestions for adjusting the patient's treatment plan based on objective data and clinical heuristics.</p>
            <div id="recommendation-content" class="space-y-6">
                <!-- Dynamic recommendations will be placed here -->
            </div>
            <div class="mt-10 border-t border-[#30363d] pt-6">
                <p class="text-sm text-gray-500">
                    *Recommendations are based on R-RI weighting and dominant phenotype. They are designed to inform clinical decisions, not replace them.
                </p>
            </div>
        </div>
    </div>
</div>

<footer class="mt-8 text-center text-gray-500 text-sm">
    <p>⚠️ **Disclaimer:** This is a Clinical Decision Support System (CDSS) prototype (MVP), NOT a medical device. Always use professional clinical judgment.</p>
</footer>

<!-- Initialize Lucide Icons -->
<script>
    lucide.createIcons();
</script>
<script>
    // Global Constants
    const RRI_COLORS = {
        "Poor": ["#E76F51", "Low Progress (< 40)", "danger"],
        "Fair": ["#E9C46A", "Moderate Progress (40–70)", "warning"],
        "Good": ["#2A9D8F", "Excellent Progress (> 70)", "success"],
    };

    const PAIN_REGIONS = [
        {code: "head", name: "Head/Neck", r: 0, c: 1}, {code: "l_shoulder", name: "Left Shoulder", r: 1, c: 0},
        {code: "chest", name: "Chest/Upper Back", r: 1, c: 1}, {code: "r_shoulder", name: "Right Shoulder", r: 1, c: 2},
        {code: "l_arm", name: "Left Arm", r: 2, c: 0}, {code: "abdomen", name: "Abdomen/Lower Back", r: 2, c: 1},
        {code: "r_arm", name: "Right Arm", r: 2, c: 2}, {code: "l_thigh", name: "Left Thigh", r: 3, c: 0},
        {code: "pelvis", name: "Pelvis", r: 3, c: 1}, {code: "r_thigh", name: "Right Thigh", r: 3, c: 2},
        {code: "l_leg", name: "Left Leg/Foot", r: 4, c: 0}, {code: "knees", name: "Knees", r: 4, c: 1},
        {code: "r_leg", name: "Right Leg/Foot", r: 4, c: 2},
    ];

    const WEIGHTS = {
        "pain": 0.30,
        "function": 0.40,
        "sleep_hrv": 0.20,
        "adherence": 0.10,
    };

    const MCID = {
        "nrs": 2.0, "tug": 2.0, "sixmwt": 40.0, "rom": 15.0, "strength_pct": 10.0,
    };

    // --- Global State ---
    let baselineSession = null;
    let currentSession = null;

    // --- Data Classes ---
    class PainMap { constructor(regions) { this.regions = regions || {}; } }
    class Phenotype {
        constructor(nociceptive, neuropathic, nociplastic) {
            this.nociceptive = nociceptive;
            this.neuropathic = neuropathic;
            this.nociplastic = nociplastic;
        }
    }
    class Session {
        constructor(data) {
            this.ts = data.ts || new Date().toISOString();
            this.diagnosis = data.diagnosis;
            this.age = data.age;
            this.gender = data.gender;
            this.pain_rest = data.pain_rest;
            this.pain_motion = data.pain_motion;
            this.pain_map = data.pain_map;
            this.phenotype = data.phenotype;
            this.rom_deg = data.rom_deg;
            this.tug_s = data.tug_s;
            this.sixmwt_m = data.sixmwt_m;
            this.strength_pct = data.strength_pct;
            this.single_leg_s = data.single_leg_s;
            this.steps = data.steps;
            this.hrv_rmssd_ms = data.hrv_rmssd_ms;
            this.sleep_duration_h = data.sleep_duration_h;
            this.sleep_efficiency_pct = data.sleep_efficiency_pct;
            this.dn4_short = data.dn4_short;
            this.trend_status = data.trend_status || null;
            this.delta_nrs = data.delta_nrs || null;
            this.rri_score = data.rri_score || null;
            this.rri_decomposition = data.rri_decomposition || {};
        }
    }

    // --- Helper Functions ---
    function normalize01(x, xmin, xmax) {
        if (x === null || x === undefined) return null;
        if (xmax === xmin) return 0.0;
        return Math.max(0.0, Math.min(1.0, (x - xmin) / (xmax - xmin)));
    }

    function getInputValue(id, type = 'float') {
        const el = document.getElementById(id);
        if (!el) return null;
        const value = el.value.trim();
        if (value === "") return null;

        if (type === 'int' || type === 'slider') return parseInt(value);
        if (type === 'float') return parseFloat(value);
        return value;
    }

    function estimatePhenotype(painRest, painMotion, dn4Short) {
        const neu = dn4Short === null ? 0.0 : Math.max(0.0, Math.min(1.0, dn4Short / 4.0));
        let noc = 0.0;
        if (painMotion !== null && painRest !== null) {
            const diff = Math.max(painMotion - painRest, 0);
            noc = Math.max(0.0, Math.min(1.0, diff / 5.0));
        }
        const base = neu + noc;
        let ncp = Math.max(0.0, 1.0 - base);
        const s = neu + noc + ncp;
        if (s === 0) return new Phenotype(0.33, 0.33, 0.34);

        return new Phenotype(
            nociceptive = noc / s,
            neuropathic = neu / s,
            nociplastic = ncp / s
        );
    }

    function computeRRI(current, baseline) {
        const decomposition = {};

        // 1. Pain component (30%)
        let painScore = 0.5;
        if (baseline && current.pain_motion !== null && baseline.pain_motion !== null) {
            const delta = baseline.pain_motion - current.pain_motion;
            painScore = Math.max(-1.0, Math.min(1.0, delta / MCID.nrs));
            painScore = (painScore + 1) / 2;
        } else if (current.pain_motion !== null) {
            painScore = 1.0 - normalize01(current.pain_motion, 0, 10);
        }
        decomposition.pain = painScore;

        // 2. Function composite (40%)
        let comp = [];
        if (baseline && current.rom_deg !== null && baseline.rom_deg !== null) comp.push(Math.max(-1, Math.min(1, (current.rom_deg - baseline.rom_deg) / MCID.rom)));
        if (baseline && current.tug_s !== null && baseline.tug_s !== null) comp.push(Math.max(-1, Math.min(1, (baseline.tug_s - current.tug_s) / MCID.tug)));
        if (baseline && current.sixmwt_m !== null && baseline.sixmwt_m !== null) comp.push(Math.max(-1, Math.min(1, (current.sixmwt_m - baseline.sixmwt_m) / MCID.sixmwt)));
        if (baseline && current.strength_pct !== null && baseline.strength_pct !== null) comp.push(Math.max(-1, Math.min(1, (current.strength_pct - baseline.strength_pct) / MCID.strength_pct)));

        let funcScore = 0.5;
        if (comp.length > 0) {
            const meanComp = comp.reduce((a, b) => a + b, 0) / comp.length;
            funcScore = (meanComp + 1) / 2;
        } else {
            let funcNorms = [];
            if (current.rom_deg !== null) funcNorms.push(normalize01(current.rom_deg, 0, 140));
            if (current.tug_s !== null) funcNorms.push(1.0 - normalize01(current.tug_s, 6, 20));
            if (current.sixmwt_m !== null) funcNorms.push(normalize01(current.sixmwt_m, 200, 600));
            if (current.strength_pct !== null) funcNorms.push(normalize01(current.strength_pct, 50, 150));
            if (funcNorms.length > 0) funcScore = funcNorms.reduce((a, b) => a + b, 0) / funcNorms.length;
        }
        decomposition.function = funcScore;

        // 3. Sleep/HRV (20%)
        let sleepVec = [];
        if (current.sleep_duration_h !== null) {
            let sNorm = 1.0 - Math.abs(current.sleep_duration_h - 8.0) / 4.0;
            sNorm = Math.max(0.0, Math.min(1.0, sNorm));
            sleepVec.push(sNorm * 2 - 1);
        }
        if (baseline && current.hrv_rmssd_ms !== null && baseline.hrv_rmssd_ms !== null) {
            sleepVec.push(Math.max(-1, Math.min(1, (current.hrv_rmssd_ms - baseline.hrv_rmssd_ms) / 20.0)));
        } else if (current.hrv_rmssd_ms !== null) {
            sleepVec.push(normalize01(current.hrv_rmssd_ms, 15.0, 70.0) * 2 - 1);
        }

        let sleepScore = 0.5;
        if (sleepVec.length > 0) {
            const meanSleep = sleepVec.reduce((a, b) => a + b, 0) / sleepVec.length;
            sleepScore = (meanSleep + 1) / 2;
        }
        decomposition.sleep_hrv = sleepScore;

        // 4. Adherence (10%)
        const checkFields = [
            current.rom_deg, current.tug_s, current.sixmwt_m, current.strength_pct,
            current.single_leg_s, current.steps, current.hrv_rmssd_ms,
            current.sleep_duration_h, current.sleep_efficiency_pct
        ];
        const filled = checkFields.filter(v => v !== null && v !== undefined).length;
        const adherence = Math.min(1, filled / checkFields.length);
        decomposition.adherence = adherence;

        // Final RRI calculation
        const rri = (
            WEIGHTS.pain * painScore +
            WEIGHTS.function * funcScore +
            WEIGHTS.sleep_hrv * sleepScore +
            WEIGHTS.adherence * adherence
        ) * 100.0;

        return { rri: parseFloat(rri.toFixed(1)), decomposition };
    }

    // --- UI / Visualization ---
    function getRRIStatus(rriValue) {
        if (rriValue >= 70) return RRI_COLORS.Good;
        if (rriValue >= 40) return RRI_COLORS.Fair;
        return RRI_COLORS.Poor;
    }

    function drawBodyHeatmap(painMap) {
        const container = document.getElementById('pain-heatmap-container');
        if (!container) return;
        container.innerHTML = '';

        const getColor = (v) => {
            const norm = Math.max(0, Math.min(1, v / 10.0));
            const r = Math.round(255 * norm);
            const g = Math.round(255 * (1 - 0.5 * norm));
            const b = Math.round(255 * (1 - norm));
            return `rgba(${r}, ${g}, ${b}, 0.85)`;
        };

        PAIN_REGIONS.forEach(region => {
            const intensity = painMap.regions[region.code] || 0;
            const box = document.createElement('div');
            box.className = 'region-box border border-[#30363d]';
            box.style.backgroundColor = getColor(intensity);
            box.style.gridRow = `${region.r + 1}`;
            box.style.gridColumn = `${region.c + 1}`;
            const shortName = region.name.split('/')[0];
            box.textContent = `${shortName} (${intensity})`;

            box.style.color = intensity < 5 ? '#161b22' : '#fff';
            container.appendChild(box);
        });
        // Re-render Lucide icons if any were used here (though none are now)
        lucide.createIcons();
    }

    function drawRRIGauge(rriValue) {
        const container = document.getElementById('rri-gauge-container');
        if (!container) return;
        container.innerHTML = '';

        const [color, description] = getRRIStatus(rriValue);

        const size = 250;
        const radius = 100;
        const strokeWidth = 20;
        const cx = size / 2;
        const cy = size / 2;

        const getArcPath = (startAngle, endAngle) => {
            const start = (startAngle * Math.PI) / 180;
            const end = (endAngle * Math.PI) / 180;
            const startX = cx + radius * Math.cos(start);
            const startY = cy + radius * Math.sin(start);
            const endX = cx + radius * Math.cos(end);
            const endY = cy + radius * Math.sin(end);
            const largeArcFlag = endAngle - startAngle <= 180 ? 0 : 1;
            return `M ${startX} ${startY} A ${radius} ${radius} 0 ${largeArcFlag} 1 ${endX} ${endY}`;
        };

        const angle = Math.max(0, Math.min(180, (rriValue / 100) * 180));

        const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        svg.setAttribute('viewBox', `0 0 ${size} ${size}`);
        svg.setAttribute('width', '100%');
        svg.setAttribute('height', '100%');
        svg.style.transform = 'rotate(-90deg)';

        const backgroundPath = getArcPath(0, 180);
        const track = document.createElementNS("http://www.w3.org/2000/svg", "path");
        track.setAttribute('d', backgroundPath);
        track.setAttribute('fill', 'none');
        track.setAttribute('stroke', '#30363d');
        track.setAttribute('stroke-width', strokeWidth);
        svg.appendChild(track);

        const progressPath = getArcPath(180 - angle, 180);
        const progress = document.createElementNS("http://www.w3.org/2000/svg", "path");
        progress.setAttribute('d', progressPath);
        progress.setAttribute('fill', 'none');
        progress.setAttribute('stroke', color);
        progress.setAttribute('stroke-width', strokeWidth + 2);
        progress.setAttribute('stroke-linecap', 'round');
        svg.appendChild(progress);

        container.appendChild(svg);

        document.getElementById('rri-status').innerHTML = `
                <div class="metric-value" style="color: ${color};">${rriValue.toFixed(1)}</div>
                <div class="inline-block px-3 py-1 rounded-full text-xs font-semibold mt-2" style="background-color: ${color}; color: ${color === RRI_COLORS.Fair[0] ? '#161b22' : '#fff'};">
                    ${description}
                </div>
            `;
    }

    function updatePhenotypeChart(phenotype) {
        const container = document.getElementById('phenotype-chart');
        if (!container) return;

        const phenotypes = [
            {name: "Nociceptive", value: phenotype.nociceptive, color: "#58a6ff"},
            {name: "Neuropathic", value: phenotype.neuropathic, color: "#E9C46A"},
            {name: "Nociplastic", value: phenotype.nociplastic, color: "#E76F51"},
        ];

        container.innerHTML = phenotypes.map(p => `
                <div class="text-sm">
                    <div class="flex justify-between mb-1">
                        <span class="font-medium">${p.name}</span>
                        <span class="font-bold" style="color: ${p.color};">${(p.value * 100).toFixed(1)}%</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-3">
                        <div class="h-3 rounded-full" style="width: ${p.value * 100}%; background-color: ${p.color};"></div>
                    </div>
                </div>
            `).join('');
    }

    function updateDecompositionChart(decomposition) {
        const container = document.getElementById('decomposition-chart');
        if (!container) return;

        const components = [
            {key: "function", name: "Function (40%)", value: decomposition.function, color: "#2A9D8F"},
            {key: "pain", name: "Pain (30%)", value: decomposition.pain, color: "#E76F51"},
            {key: "sleep_hrv", name: "Recovery (20%)", value: decomposition.sleep_hrv, color: "#58a6ff"},
            {key: "adherence", name: "Adherence (10%)", value: decomposition.adherence, color: "#E9C46A"},
        ];

        container.innerHTML = components.map(c => {
            const percentage = c.value * 100;
            return `
                    <div class="text-sm">
                        <div class="flex justify-between mb-1">
                            <span class="font-medium">${c.name}</span>
                            <span class="font-bold text-white">${percentage.toFixed(1)}%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-3">
                            <div class="h-3 rounded-full" style="width: ${percentage}%; background-color: ${c.color};"></div>
                        </div>
                    </div>
                `;
        }).join('');
    }

    function updateTrendInfo(current, baseline) {
        const trendInfoEl = document.getElementById('trend-info');
        if (!trendInfoEl) return;

        if (!baseline) {
            trendInfoEl.innerHTML = '<span class="text-gray-500">No baseline session loaded for trend.</span>';
            current.trend_status = null;
            current.delta_nrs = null;
            return;
        }

        let deltaNRS = null;
        let statusText = "Awaiting data...";
        let statusColor = "text-gray-400";

        if (baseline.pain_motion !== null && current.pain_motion !== null) {
            deltaNRS = baseline.pain_motion - current.pain_motion;
            current.delta_nrs = parseFloat(deltaNRS.toFixed(1));

            if (deltaNRS > MCID.nrs * 0.5) {
                statusText = "Significant Improvement";
                statusColor = "text-[#2A9D8F]";
                current.trend_status = "better";
            } else if (deltaNRS < -MCID.nrs * 0.5) {
                statusText = "Significant Decline";
                statusColor = "text-[#E76F51]";
                current.trend_status = "worse";
            } else {
                statusText = "Stable/Minimal Trend";
                statusColor = "text-[#E9C46A]";
                current.trend_status = "stable";
            }
        }

        trendInfoEl.innerHTML = `
                <div class="text-sm ${statusColor} font-semibold mt-1">Trend: ${statusText}</div>
                ${deltaNRS !== null ? `<div class="text-md font-bold mt-1">Δ Pain (motion): ${deltaNRS > 0 ? '+' : ''}${deltaNRS.toFixed(1)}</div>` : ''}
            `;
    }

    function updateKPIs(session) {
        const kpiBlock = document.getElementById('kpi-block');
        if (!kpiBlock) return;

        const kpiData = [
            {
                label: "NRS Motion",
                value: session.pain_motion,
                icon: "thermometer",
                unit: "/10",
                color: session.pain_motion > 6 ? "#E76F51" : session.pain_motion > 3 ? "#E9C46A" : "#2A9D8F"
            },
            {
                label: "Sleep Duration",
                value: session.sleep_duration_h,
                icon: "bed",
                unit: "h",
                color: session.sleep_duration_h < 6 || session.sleep_duration_h > 9 ? "#E76F51" : "#2A9D8F"
            },
            {
                label: "HRV RMSSD",
                value: session.hrv_rmssd_ms,
                icon: "heart",
                unit: "ms",
                color: session.hrv_rmssd_ms < 30 ? "#E76F51" : "#2A9D8F"
            },
            {
                label: "6MWT",
                value: session.sixmwt_m,
                icon: "gauge",
                unit: "m",
                color: session.sixmwt_m < 300 ? "#E76F51" : "#2A9D8F"
            },
        ];

        kpiBlock.innerHTML = kpiData.map(kpi => `
                <div class="flex items-center justify-between p-3 rounded-lg border border-[#30363d]">
                    <div class="flex items-center">
                        <i data-lucide="${kpi.icon}" class="w-5 h-5 mr-3" style="color: ${kpi.color}"></i>
                        <span class="text-gray-400 text-sm">${kpi.label}</span>
                    </div>
                    <span class="font-bold" style="color: ${kpi.color}">${kpi.value.toFixed(1)}${kpi.unit}</span>
                </div>
            `).join('');
        lucide.createIcons();
    }

    // --- Recommendation Module (CDSS) ---

    function generateRecommendations(session) {
        const container = document.getElementById('recommendation-content');
        if (!container) return;

        container.innerHTML = '';

        const phenotype = session.phenotype;
        let recommendations = [];

        // 1. R-RI Based Recommendations (Intensity Adjustment)

        if (session.rri_score >= 80) {
            recommendations.push({
                type: 'success',
                title: '✅ Excellent Recovery!',
                text: `R-RI is at a high level (${session.rri_score.toFixed(1)}). Recommended to **gradually increase functional load** and prepare for discharge or transition to sport-specific training. Maintain vigilance on sleep/HRV.`
            });
        } else if (session.rri_score < 40) {
            recommendations.push({
                type: 'danger',
                title: '🛑 Low Therapy Effectiveness',
                text: `R-RI is below the threshold (${session.rri_score.toFixed(1)}). The current plan is ineffective. **Urgent strategy change is required** — either reduce load to decrease pain, or shift the therapy focus based on the pain phenotype.`
            });
        }

        // 2. Phenotype Based Recommendations (Therapy Type Adjustment)

        const maxPh = Math.max(phenotype.nociceptive, phenotype.neuropathic, phenotype.nociplastic);

        if (phenotype.nociceptive === maxPh && maxPh > 0.45) {
            recommendations.push({
                type: 'warning',
                title: '🛠️ Dominant Nociceptive Phenotype',
                text: `(Probability ${(phenotype.nociceptive * 100).toFixed(1)}%). Pain is linked to tissue load/inflammation. **Focus:** Temporarily decrease mechanical loading intensity. Apply anti-inflammatory modalities. Avoid provocative positions.`
            });
        } else if (phenotype.neuropathic === maxPh && maxPh > 0.45) {
            recommendations.push({
                type: 'danger',
                title: '⚡ Dominant Neuropathic Phenotype',
                text: `(Probability ${(phenotype.neuropathic * 100).toFixed(1)}%). **Focus:** **Neuromodulation**. Incorporate Nerve Gliding/Tensioners. Consider pharmacological intervention (if allowed). Use light aerobic activity.`
            });
        } else if (phenotype.nociplastic === maxPh && maxPh > 0.45) {
            recommendations.push({
                type: 'warning',
                title: '🧠 Dominant Nociplastic Phenotype',
                text: `(Probability ${(phenotype.nociplastic * 100).toFixed(1)}%). High central sensitization/anxiety. **Focus:** Emphasize Pain Neuroscience Education (PNE), multidisciplinary approach (psychology referral), and graded exposure to aerobic activity.`
            });
        }

        // 3. Weak Link Recommendations (Decomposition)
        const decomp = session.rri_decomposition;
        const componentNames = {
            'function': 'Function/Tests', 'pain': 'Pain Control',
            'sleep_hrv': 'Recovery/Sleep', 'adherence': 'Adherence',
        };
        const weakLink = Object.keys(decomp).reduce((a, b) => decomp[a] < decomp[b] ? a : b);

        if (decomp[weakLink] < 0.4) {
            recommendations.push({
                type: 'warning',
                title: '📉 Weak Link: ' + componentNames[weakLink],
                text: `The **${componentNames[weakLink]}** component has the lowest contribution (${(decomp[weakLink] * 100).toFixed(1)}%). Dedicate 25% of the next session to addressing this factor. E.g., if 'Recovery', discuss sleep hygiene. If 'Function', increase exercise intensity.`
            });
        }


        container.innerHTML = recommendations.map(rec => `
                <div class="recommendation-box rec-${rec.type}">
                    <h4 class="text-lg font-bold mb-1">${rec.title}</h4>
                    <p class="text-sm text-gray-300">${rec.text}</p>
                </div>
            `).join('');

        if (recommendations.length === 0) {
            container.innerHTML = '<p class="text-center text-gray-500 py-8">No critical adjustments needed. Maintain the current plan.</p>';
        }
    }

    // --- Core Application Logic ---

    function getCurrentSessionData() {
        const painMapRegions = {};
        PAIN_REGIONS.forEach(r => {
            const slider = document.getElementById(`pm_slider_${r.code}`);
            if (slider) painMapRegions[r.code] = getInputValue(`pm_slider_${r.code}`, 'slider');
        });

        return {
            ts: new Date().toISOString(),
            diagnosis: getInputValue('diagnosis', 'string'),
            age: getInputValue('age', 'int'),
            gender: getInputValue('gender', 'string'),
            pain_rest: getInputValue('pain_rest', 'slider'),
            pain_motion: getInputValue('pain_motion', 'slider'),
            dn4_short: getInputValue('dn4_short', 'slider'),

            rom_deg: getInputValue('rom_deg'),
            tug_s: getInputValue('tug_s'),
            sixmwt_m: getInputValue('sixmwt_m'),
            strength_pct: getInputValue('strength_pct'),
            single_leg_s: getInputValue('single_leg_s'),

            steps: getInputValue('steps', 'int'),
            hrv_rmssd_ms: getInputValue('hrv_rmssd_ms'),
            sleep_duration_h: getInputValue('sleep_duration_h'),
            sleep_efficiency_pct: getInputValue('sleep_efficiency_pct'),

            pain_map: new PainMap(painMapRegions),
        };
    }

    function updateAll() {
        const data = getCurrentSessionData();

        // Update slider text values
        document.getElementById('pain_rest_value').textContent = data.pain_rest;
        document.getElementById('pain_motion_value').textContent = data.pain_motion;
        document.getElementById('dn4_short_value').textContent = data.dn4_short;
        PAIN_REGIONS.forEach(r => {
            const slider = document.getElementById(`pm_slider_${r.code}`);
            const valueEl = document.getElementById(`pm_value_${r.code}`);
            if(valueEl && slider) valueEl.textContent = slider.value;
        });

        const phenotype = estimatePhenotype(data.pain_rest, data.pain_motion, data.dn4_short);
        data.phenotype = phenotype;

        const rriResult = computeRRI(data, baselineSession);
        data.rri_score = rriResult.rri;
        data.rri_decomposition = rriResult.decomposition;

        currentSession = new Session(data);

        // Re-render all visuals
        drawBodyHeatmap(data.pain_map);
        drawRRIGauge(currentSession.rri_score);
        updatePhenotypeChart(phenotype);
        updateDecompositionChart(rriResult.decomposition);
        updateTrendInfo(currentSession, baselineSession);
        updateKPIs(currentSession);
        generateRecommendations(currentSession);
    }

    // --- Load/Export Handlers ---
    function loadBaseline() {
        const input = document.getElementById('baseline_file_input');
        const messageEl = document.getElementById('baseline-message');

        if (input.files.length === 0) {
            messageEl.textContent = 'No file selected.';
            baselineSession = null;
            updateAll();
            return;
        }

        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            try {
                const rawData = JSON.parse(e.target.result);
                baselineSession = new Session({
                    ...rawData,
                    pain_map: new PainMap(rawData.pain_map ? rawData.pain_map.regions : {}),
                    phenotype: rawData.phenotype ? new Phenotype(rawData.phenotype.nociceptive, rawData.phenotype.neuropathic, rawData.phenotype.nociplastic) : new Phenotype(0, 0, 0),
                });

                messageEl.textContent = `Baseline session loaded from ${new Date(baselineSession.ts).toLocaleDateString()}.`;
                messageEl.className = 'text-xs mt-2 text-[#2A9D8F]';
                updateAll();
            } catch (error) {
                messageEl.textContent = `Error reading file: ${error.message}. Please ensure it is a valid R-RI JSON file.`;
                messageEl.className = 'text-xs mt-2 text-[#E76F51]';
                baselineSession = null;
                updateAll();
            }
        };

        reader.readAsText(file);
    }

    function exportJSON() {
        if (!currentSession) return;
        updateAll(); // Final update to ensure all calculated fields are current

        const cleanData = JSON.parse(JSON.stringify(currentSession));

        const jsonStr = JSON.stringify(cleanData, null, 2);
        const blob = new Blob([jsonStr], { type: 'application/json' });
        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.download = `R-RI_Session_${new Date().toISOString().substring(0, 10)}.json`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }

    // --- Initialization and Tab Management ---

    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });

        document.getElementById(`tab-${tabId}`).classList.remove('hidden');
        document.querySelector(`.tab-button[data-tab="${tabId}"]`).classList.add('active');

        if (tabId !== 'input') {
            updateAll(); // Ensure visuals are refreshed when viewing results
        }
    }

    function initializePainSliders() {
        const container = document.getElementById('pain-sliders');
        if (!container) return;

        PAIN_REGIONS.forEach(r => {
            const code = r.code;
            const label = document.createElement('label');
            label.className = 'block';
            label.innerHTML = `
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-sm">${r.name}</span>
                        <span id="pm_value_${code}" class="font-bold text-white text-md">0</span>
                    </div>
                    <input type="range" id="pm_slider_${code}" min="0" max="10" value="0" oninput="updateAll()" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                `;
            container.appendChild(label);
        });
    }

    window.onload = function() {
        initializePainSliders();

        // Set up listeners
        const inputs = document.querySelectorAll('input[type="number"], input[type="text"], select');
        inputs.forEach(input => input.addEventListener('input', updateAll));
        inputs.forEach(input => input.addEventListener('change', updateAll));

        // Tab listeners
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', (e) => {
                const tabId = e.target.getAttribute('data-tab');
                switchTab(tabId);
            });
        });

        switchTab('input');
        updateAll(); // Initial run
    };

</script>
</body>
</html>
