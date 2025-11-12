<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wound AI Assessment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Import Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #030712; /* gray-950 */
        }
        /* Glassmorphism card style with glow */
        .glass-card {
            background: rgba(17, 24, 39, 0.7); /* gray-900 with 70% opacity */
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.15), 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        /* Custom styles for range input */
        input[type=range] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            background: #374151; /* gray-700 */
            border-radius: 5px;
            outline: none;
            transition: opacity .2s;
        }
        input[type=range]:hover {
            opacity: 1;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #3b82f6; /* blue-600 */
            cursor: pointer;
            border-radius: 50%;
            transition: background .2s;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }
        input[type=range]:active::-webkit-slider-thumb {
            background: #2563eb; /* blue-700 */
        }
        input[type=range]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #3b82f6; /* blue-600 */
            cursor: pointer;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        /* Custom checkbox style */
        .custom-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .custom-checkbox:checked ~ .tick-mark {
            display: block;
        }

        /* Form input/select dark style */
        .form-input {
            background-color: rgba(31, 41, 55, 0.5); /* gray-800 with 50% opacity */
            border: 1px solid #4b5563; /* gray-600 */
            color: #d1d5db; /* gray-300 */
            border-radius: 0.375rem; /* rounded-md */
        }
        .form-input:focus {
            border-color: #3b82f6; /* blue-600 */
            ring: 1px;
            ring-color: #3b82f6;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1f2937; /* gray-800 */
        }
        ::-webkit-scrollbar-thumb {
            background: #374151; /* gray-700 */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #4b5563; /* gray-600 */
        }

        /* Loading spinner */
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* SVG Gauge styles */
        .gauge-track {
            stroke: #374151; /* gray-700 */
            stroke-width: 10;
            fill: none;
        }
        .gauge-value {
            stroke-width: 10;
            fill: none;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.5s ease-out, stroke 0.5s ease;
        }

        /* Composition Donut styles */
        .donut-segment {
            stroke-width: 15;
            fill: none;
            stroke-linecap: butt;
            transition: stroke-dashoffset 0.5s ease-out, stroke-dasharray 0.5s ease-out;
            transform-origin: center;
        }

        /* Image Scan Animation */
        .scan-overlay {
            position: absolute;
            inset: 0;
            background: rgba(3, 7, 18, 0.5); /* gray-950/50 */
            overflow: hidden;
            display: none;
        }
        .scan-line {
            position: absolute;
            left: 0;
            right: 0;
            height: 3px;
            background: #f87171; /* red-400 */
            box-shadow: 0 0 15px #f87171, 0 0 5px #fff;
            animation: scan 2s ease-in-out;
        }
        .scan-overlay.scanning {
            display: block;
        }
        @keyframes scan {
            0% { top: 0; }
            100% { top: 100%; }
        }
    </style>
</head>
<body class="text-gray-200 min-h-screen">

<!-- Background Gradient Aurora -->
<div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
    <div class="fixed top-1/4 left-1/4 w-96 h-96 bg-blue-900 rounded-full filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="fixed bottom-1/4 right-1/4 w-96 h-96 bg-purple-900 rounded-full filter blur-3xl opacity-30 animate-pulse animation-delay-3000"></div>
</div>

<div class="container mx-auto p-4 md:p-8">
    <!-- Header -->
    <header class="text-center mb-8 md:mb-12">
        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-400 to-teal-300 bg-clip-text text-transparent">
            Wound AI Assessment
        </h1>
        <p class="text-gray-400 mt-2 text-lg">Enter comprehensive wound data for advanced analysis and metric visualization.</p>
    </header>

    <main class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2 glass-card p-6 md:p-8 rounded-2xl h-fit">
            <form id="woundForm" class="space-y-8">
                <!-- Patient Information -->
                <fieldset>
                    <legend class="text-xl font-semibold mb-4 text-blue-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Patient Information
                    </legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="patientId" class="block text-sm font-medium text-gray-400">Patient ID</label>
                            <input type="text" id="patientId" class="form-input mt-1 block w-full sm:text-sm" placeholder="e.g., 12345">
                        </div>
                        <div>
                            <label for="assessmentDate" class="block text-sm font-medium text-gray-400">Assessment Date</label>
                            <input type="date" id="assessmentDate" class="form-input mt-1 block w-full sm:text-sm">
                        </div>
                    </div>
                </fieldset>

                <!-- 1. Wound Dimensions -->
                <fieldset>
                    <legend class="text-xl font-semibold mb-4 text-blue-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M21 3 3 21"></path><path d="M3 3h18v18"></path></svg>
                        Wound Dimensions
                    </legend>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="length" class="block text-sm font-medium text-gray-400">Length (cm)</label>
                            <input type="number" id="length" class="form-input mt-1 block w-full sm:text-sm" placeholder="0.0" step="0.1">
                        </div>
                        <div>
                            <label for="width" class="block text-sm font-medium text-gray-400">Width (cm)</label>
                            <input type="number" id="width" class="form-input mt-1 block w-full sm:text-sm" placeholder="0.0" step="0.1">
                        </div>
                        <div>
                            <label for="depth" class="block text-sm font-medium text-gray-400">Depth (cm)</label>
                            <input type="number" id="depth" class="form-input mt-1 block w-full sm:text-sm" placeholder="0.0" step="0.1">
                        </div>
                    </div>
                </fieldset>

                <!-- 2. Wound Bed Composition (%) -->
                <fieldset>
                    <legend class="text-xl font-semibold mb-4 text-blue-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M3 2v6h6"></path><path d="M3.63 13.37A9 9 0 1 1 21.9 10.34"></path></svg>
                        Wound Bed Composition
                    </legend>
                    <div class="space-y-4">
                        <div>
                            <label for="granulation" class="block text-sm font-medium text-gray-400">Granulation Tissue: <span id="granulationValue" class="font-bold text-blue-400">50</span>%</label>
                            <input type="range" id="granulation" min="0" max="100" value="50" class="mt-2 w-full">
                        </div>
                        <div>
                            <label for="slough" class="block text-sm font-medium text-gray-400">Slough/Fibrin: <span id="sloughValue" class="font-bold text-yellow-400">30</span>%</label>
                            <input type="range" id="slough" min="0" max="100" value="30" class="mt-2 w-full" style="--thumb-color: #facc15;">
                        </div>
                        <div>
                            <label for="necrotic" class="block text-sm font-medium text-gray-400">Necrotic Tissue/Eschar: <span id="necroticValue" class="font-bold text-gray-400">20</span>%</label>
                            <input type="range" id="necrotic" min="0" max="100" value="20" class="mt-2 w-full" style="--thumb-color: #9ca3af;">
                        </div>
                        <div id="tissueTotalWarning" class="text-sm text-yellow-400 font-medium text-center">Total: <span id="tissueTotal">100</span>%</div>
                    </div>
                </fieldset>

                <!-- 3. Exudate Characteristics -->
                <fieldset>
                    <legend class="text-xl font-semibold mb-4 text-blue-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><path d="m8 10 4 4 4-4"></path></svg>
                        Exudate Characteristics
                    </legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="exudateAmount" class="block text-sm font-medium text-gray-400">Exudate Amount</label>
                            <select id="exudateAmount" class="form-input mt-1 block w-full sm:text-sm">
                                <option value="1">None</option>
                                <option value="2">Scant</option>
                                <option value="3">Small/Minimal</option>
                                <option value="4">Moderate</option>
                                <option value="5">Large/Copious</option>
                            </select>
                        </div>
                        <div>
                            <label for="exudateType" class="block text-sm font-medium text-gray-400">Exudate Type</label>
                            <select id="exudateType" class="form-input mt-1 block w-full sm:text-sm">
                                <option value="1">None</option>
                                <option value="2">Serous</option>
                                <option value="3">Sanguineous</option>
                                <option value="4">Serosanguineous</option>
                                <option value="5">Purulent</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- 4. Periwound & Edges -->
                <fieldset>
                    <legend class="text-xl font-semibold mb-4 text-blue-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        Periwound & Edges
                    </legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="woundEdges" class="block text-sm font-medium text-gray-400">Wound Edges</label>
                            <select id="woundEdges" class="form-input mt-1 block w-full sm:text-sm">
                                <option value="1">Defined / Attached</option>
                                <option value="2">Indistinct / Diffuse</option>
                                <option value="3">Rolled / Epibole</option>
                                <option value="4">Hyperkeratotic</option>
                                <option value="5">Fibrotic / Scarred</option>
                            </select>
                        </div>
                        <div>
                            <label for="undermining" class="block text-sm font-medium text-gray-400">Undermining / Tunneling</label>
                            <select id="undermining" class="form-input mt-1 block w-full sm:text-sm">
                                <option value="1">None</option>
                                <option value="2">&lt; 2 cm</option>
                                <option value="3">2 - 4 cm</option>
                                <option value="4">&gt; 4 cm</option>
                                <option value="5">Tunneling Present</option>
                            </select>
                        </div>
                        <div>
                            <label for="periwoundEdema" class="block text-sm font-medium text-gray-400">Periwound Edema</label>
                            <select id="periwoundEdema" class="form-input mt-1 block w-full sm:text-sm">
                                <option value="1">None</option>
                                <option value="2">Non-Pitting</option>
                                <option value="3">Pitting (+1)</option>
                                <option value="4">Pitting (2+)</option>
                                <option value="5">Deep Pitting (3+)</option>
                            </select>
                        </div>
                        <div>
                            <label for="periwoundInduration" class="block text-sm font-medium text-gray-400">Periwound Induration</label>
                            <select id="periwoundInduration" class="form-input mt-1 block w-full sm:text-sm">
                                <option value="1">None</option>
                                <option value="3">Present (&lt; 2 cm)</option>
                                <option value="5">Present (&gt; 2 cm)</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- 5. Infection & Pain -->
                <fieldset>
                    <legend class="text-xl font-semibold mb-4 text-blue-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        Infection & Pain
                    </legend>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Local Signs of Infection (NERDS)</label>
                        <div id="infectionSigns" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <!-- Checkboxes will be dynamically inserted here -->
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="odor" class="block text-sm font-medium text-gray-400">Odor</label>
                            <select id="odor" class="form-input mt-1 block w-full sm:text-sm">
                                <option value="1">None</option>
                                <option value="3">Slight / Foul</option>
                                <option value="5">Strong / Pungent</option>
                            </select>
                        </div>
                        <div>
                            <label for="painLevel" class="block text-sm font-medium text-gray-400">Pain Level: <span id="painValue" class="font-bold text-blue-400">5</span>/10</label>
                            <input type="range" id="painLevel" min="0" max="10" value="5" class="mt-2 w-full">
                        </div>
                    </div>
                </fieldset>

                <!-- 6. Photo Upload -->
                <fieldset>
                    <legend class="text-xl font-semibold mb-4 text-blue-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        Wound Photograph
                    </legend>
                    <label for="woundImage" class="block w-full cursor-pointer border-2 border-dashed border-gray-600 rounded-lg p-8 text-center hover:border-blue-500 transition-colors relative">
                        <span id="uploadText" class="text-gray-400">Click to upload an image for AI Scan</span>
                        <input type="file" id="woundImage" class="hidden" accept="image/*">
                        <!-- Scan overlay -->
                        <div id="scanOverlay" class="scan-overlay rounded-lg">
                            <div class="scan-line"></div>
                        </div>
                    </label>
                    <div class="mt-4">
                        <img id="imagePreview" src="https://placehold.co/600x400/030712/374151?text=Wound+Image+Preview" alt="Wound preview" class="w-full h-auto rounded-lg object-cover aspect-[4/3] hidden">
                    </div>
                </fieldset>
            </form>
        </div>

        <!-- Metrics Dashboard Section -->
        <div class="lg:col-span-1 flex flex-col gap-8">
            <div class="sticky top-8 glass-card p-6 md:p-8 rounded-2xl">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-100">Metrics Dashboard</h2>

                <!-- Score Gauge (SVG) -->
                <div class="text-center mb-6">
                    <div class="relative w-40 h-40 mx-auto">
                        <svg class="w-full h-full" viewBox="0 0 100 100">
                            <!-- Background Track -->
                            <circle class="gauge-track" cx="50" cy="50" r="40"></circle>
                            <!-- Value Circle -->
                            <circle id="scoreGaugeValue" class="gauge-value" cx="50" cy="50" r="40"
                                    transform="rotate(-90 50 50)"
                                    stroke="#22c55e"
                                    style="stroke-dasharray: 0, 251.2; stroke-dashoffset: 0;"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <div id="scoreValue" class="text-5xl font-bold text-green-400">0</div>
                            <div class="text-sm text-gray-400 font-medium">Severity Index</div>
                        </div>
                    </div>
                    <p id="scoreDescription" class="mt-4 font-semibold text-green-400 text-lg">Calculating...</p>
                </div>

                <!-- Key Metrics Grid -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-300">Key Metrics</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                            <div class="text-xs text-blue-400 uppercase">Area (cm²)</div>
                            <div id="metricArea" class="text-xl font-semibold">0.0</div>
                        </div>
                        <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                            <div class="text-xs text-blue-400 uppercase">Depth (cm)</div>
                            <div id="metricDepth" class="text-xl font-semibold">0.0</div>
                        </div>
                        <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                            <div class="text-xs text-blue-400 uppercase">Infection Risk</div>
                            <div id="metricInfectionRisk" class="text-xl font-semibold text-green-400">None</div>
                        </div>
                        <div class="bg-gray-800/50 p-3 rounded-lg">
                            <div class="text-xs text-blue-400 uppercase mb-1 text-center">Pain Level</div>
                            <div class="w-full bg-gray-700 rounded-full h-2.5">
                                <div id="metricPainBar" class="bg-red-500 h-2.5 rounded-full transition-all duration-300" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NEW: Exudate Metrics -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-300">Exudate</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                            <div class="text-xs text-blue-400 uppercase">Amount</div>
                            <div id="metricExudateAmount" class="text-lg font-medium truncate">None</div>
                        </div>
                        <div class="bg-gray-800/50 p-3 rounded-lg text-center">
                            <div class="text-xs text-blue-400 uppercase">Type</div>
                            <div id="metricExudateType" class="text-lg font-medium truncate">None</div>
                        </div>
                    </div>
                </div>

                <!-- Wound Bed Composition (SVG Donut) -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-300">Wound Bed</h3>
                    <div class="flex items-center gap-4">
                        <div class="relative w-24 h-24 flex-shrink-0">
                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                <circle class="gauge-track" cx="50" cy="50" r="40" stroke-width="15"></circle>
                                <circle id="granulationDonut" class="donut-segment" cx="50" cy="50" r="40" transform="rotate(-90 50 50)" stroke="#3b82f6"></circle>
                                <circle id="sloughDonut" class="donut-segment" cx="50" cy="50" r="40" transform="rotate(-90 50 50)" stroke="#facc15"></circle>
                                <circle id="necroticDonut" class="donut-segment" cx="50" cy="50" r="40" transform="rotate(-90 50 50)" stroke="#9ca3af"></circle>
                            </svg>
                        </div>
                        <div class="flex-grow text-xs text-gray-400 space-y-2">
                            <span class="flex items-center justify-between"><span class="flex items-center"><span class="w-2 h-2 rounded-full bg-blue-500 mr-1.5"></span>Gran.</span> <strong id="granDonutValue" class="text-gray-200">50%</strong></span>
                            <span class="flex items-center justify-between"><span class="flex items-center"><span class="w-2 h-2 rounded-full bg-yellow-400 mr-1.5"></span>Slough</span> <strong id="sloughDonutValue" class="text-gray-200">30%</strong></span>
                            <span class="flex items-center justify-between"><span class="flex items-center"><span class="w-2 h-2 rounded-full bg-gray-400 mr-1.5"></span>Necrotic</span> <strong id="necroticDonutValue" class="text-gray-200">20%</strong></span>
                        </div>
                    </div>
                </div>

                <!-- AI Analysis -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 text-teal-300"><path d="M12 8V4H8"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><path d="M12 12v4h4"></path><path d="M16 8h4v4"></path></svg>
                        AI Analysis & Recommendations
                    </h3>
                    <div id="aiSpinner" class="flex items-center justify-center h-24 text-gray-500">
                        <svg class="spinner w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Analyzing data...</span>
                    </div>
                    <div id="aiSummary" class="text-sm text-gray-300 p-4 bg-gray-800/50 rounded-lg h-24 overflow-y-auto" style="display: none;">
                        <!-- AI content goes here -->
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <button id="saveButton" class="w-full bg-teal-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-teal-500 transition-all transform hover:scale-105 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13H7v8"></polyline><polyline points="7 3 7 8H3"></polyline></svg>
                        Save Assessment
                    </button>
                    <button id="copyButton" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-blue-500 transition-all transform hover:scale-105 flex items-center justify-center" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        Copy Report
                    </button>
                </div>
                <div id="copyFeedback" class="text-center text-sm text-green-500 mt-2 h-4"></div>
            </div>

            <!-- Assessment History -->
            <div class="glass-card p-6 md:p-8 rounded-2xl">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-100">Assessment History</h2>
                <div class="h-64">
                    <canvas id="historyChart"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- DOM Element Selectors ---
        const form = document.getElementById('woundForm');
        const allInputs = form.querySelectorAll('input, select');

        // Patient Info
        const patientIdEl = document.getElementById('patientId');
        const assessmentDateEl = document.getElementById('assessmentDate');

        // Dimensions
        const lengthEl = document.getElementById('length');
        const widthEl = document.getElementById('width');
        const depthEl = document.getElementById('depth');

        // Composition Sliders
        const granulationEl = document.getElementById('granulation');
        const sloughEl = document.getElementById('slough');
        const necroticEl = document.getElementById('necrotic');
        const granulationValueEl = document.getElementById('granulationValue');
        const sloughValueEl = document.getElementById('sloughValue');
        const necroticValueEl = document.getElementById('necroticValue');
        const tissueTotalEl = document.getElementById('tissueTotal');
        const tissueTotalWarningEl = document.getElementById('tissueTotalWarning');

        // Selects
        const exudateAmountEl = document.getElementById('exudateAmount');
        const exudateTypeEl = document.getElementById('exudateType');
        const woundEdgesEl = document.getElementById('woundEdges');
        const underminingEl = document.getElementById('undermining');
        const periwoundEdemaEl = document.getElementById('periwoundEdema');
        const periwoundIndurationEl = document.getElementById('periwoundInduration');
        const odorEl = document.getElementById('odor');

        // Infection & Pain
        const infectionSignsContainer = document.getElementById('infectionSigns');
        const painLevelEl = document.getElementById('painLevel');
        const painValueEl = document.getElementById('painValue');

        // Image
        const woundImageEl = document.getElementById('woundImage');
        const imagePreviewEl = document.getElementById('imagePreview');
        const uploadTextEl = document.getElementById('uploadText');
        const scanOverlayEl = document.getElementById('scanOverlay');

        // --- Metrics Dashboard Elements ---
        const scoreGaugeValueEl = document.getElementById('scoreGaugeValue');
        const scoreValueEl = document.getElementById('scoreValue');
        const scoreDescriptionEl = document.getElementById('scoreDescription');

        const metricAreaEl = document.getElementById('metricArea');
        const metricDepthEl = document.getElementById('metricDepth');
        const metricInfectionRiskEl = document.getElementById('metricInfectionRisk');
        const metricPainBarEl = document.getElementById('metricPainBar');
        const metricExudateAmountEl = document.getElementById('metricExudateAmount');
        const metricExudateTypeEl = document.getElementById('metricExudateType');

        // Composition Donut
        const granulationDonutEl = document.getElementById('granulationDonut');
        const sloughDonutEl = document.getElementById('sloughDonut');
        const necroticDonutEl = document.getElementById('necroticDonut');
        const granDonutValueEl = document.getElementById('granDonutValue');
        const sloughDonutValueEl = document.getElementById('sloughDonutValue');
        const necroticDonutValueEl = document.getElementById('necroticDonutValue');

        const aiSpinnerEl = document.getElementById('aiSpinner');
        const aiSummaryEl = document.getElementById('aiSummary');

        const saveButton = document.getElementById('saveButton');
        const copyButton = document.getElementById('copyButton');
        const copyFeedback = document.getElementById('copyFeedback');

        // History Chart
        const historyChartCtx = document.getElementById('historyChart').getContext('2d');
        let historyChart;
        const DB_KEY = 'woundHistoryDB';

        // --- Constants ---
        const INFECTION_SIGNS_LIST = [
            { id: 'inf-nonhealing', label: 'Non-healing', score: 2 },
            { id: 'inf-erythema', label: 'Erythema', score: 1 },
            { id: 'inf-discharge', label: 'Discharge (new)', score: 3 },
            { id: 'inf-edema', label: 'Edema', score: 1 },
            { id: 'inf-smell', label: 'Smell', score: 2 },
        ];
        const MAX_SCORE = (10 * 5) + 9 + 5; // 10 items (5pts), infection (9pts), pain (5pts) = 64
        const GAUGE_CIRCUMFERENCE = 2 * Math.PI * 40; // 2 * pi * radius (40)
        let analysisTimeout;

        // --- Initialization ---

        assessmentDateEl.valueAsDate = new Date();

        infectionSignsContainer.innerHTML = INFECTION_SIGNS_LIST.map(sign => `
            <label for="${sign.id}" class="flex items-center space-x-2 text-sm cursor-pointer text-gray-300">
                <div class="relative flex items-center">
                    <input type="checkbox" id="${sign.id}" data-score="${sign.score}" class="custom-checkbox appearance-none h-5 w-5 border border-gray-600 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                    <svg class="tick-mark hidden absolute text-white w-4 h-4 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                </div>
                <span>${sign.label}</span>
            </label>
        `).join('');

        // --- Core Functions ---

        const calculateScore = (formData) => {
            let score = 0;
            if (formData.area < 4) score += 1;
            else if (formData.area < 16) score += 2;
            else if (formData.area < 36) score += 3;
            else if (formData.area < 80) score += 4;
            else if (formData.area >= 80) score += 5;

            if (formData.depth === 0) score += 1;
            else if (formData.depth < 0.5) score += 2;
            else if (formData.depth < 1.5) score += 3;
            else if (formData.depth >= 1.5) score += 4;
            else score += 5;

            const necrotic = formData.necrotic;
            if (necrotic === 0) score += 1;
            else if (necrotic < 25) score += 2;
            else if (necrotic < 50) score += 3;
            else if (necrotic < 75) score += 4;
            else score += 5;

            score += parseInt(formData.exudateAmount, 10);
            score += parseInt(formData.exudateType, 10);
            score += parseInt(formData.woundEdges, 10);
            score += parseInt(formData.undermining, 10);
            score += parseInt(formData.periwoundEdema, 10);
            score += parseInt(formData.periwoundInduration, 10);
            score += parseInt(formData.odor, 10);
            score += formData.infectionScore;
            score += Math.ceil(parseInt(formData.painLevel, 10) / 2);

            return score;
        };

        const generateAISummary = (score, formData) => {
            let summary = "";
            let recommendations = "";

            if (score <= 15) {
                summary = "Wound appears to be in a healthy healing phase (Low Severity). ";
                recommendations = "Focus on moisture balance and protection.";
            } else if (score <= 30) {
                summary = "Wound shows signs of delayed healing (Moderate Severity). ";
                recommendations = "Re-evaluate moisture, bacterial load, and periwound status.";
            } else {
                summary = "Wound is critical and at high risk of non-healing (High Severity). ";
                recommendations = "Aggressive intervention required. Consult wound specialist.";
            }

            if (formData.infectionScore > 3 || formData.exudateType === "5") {
                summary += "High likelihood of infection detected. ";
                recommendations += " Consider topical antimicrobials or systemic antibiotics after culture.";
            }
            if (formData.necrotic > 30) {
                summary += "Significant necrotic tissue is present, impeding healing. ";
                recommendations += " Debridement is a high priority.";
            }
            if (formData.slough > 50) {
                summary += "High volume of slough indicates heavy biofilm or poor autolysis. ";
                recommendations += " Consider cleansing or enzymatic debridement.";
            }
            if (formData.exudateAmount > 3) {
                summary += "Exudate levels are moderate to high. ";
                recommendations += " Utilize a more absorbent primary dressing to manage moisture and protect periwound skin.";
            }
            if (formData.undermining > 1 || formData.woundEdges > 2) {
                summary += "Wound edges are compromised (undermining or epibole). ";
                recommendations += " Address edge non-adherence, consider packing if necessary.";
            }

            return `<strong>Summary:</strong> ${summary}<br><br><strong>Recommendations:</strong> ${recommendations}`;
        };

        const getFormData = () => {
            const length = parseFloat(lengthEl.value) || 0;
            const width = parseFloat(widthEl.value) || 0;
            const depth = parseFloat(depthEl.value) || 0;

            let infectionScore = 0;
            infectionSignsContainer.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
                infectionScore += parseInt(cb.dataset.score, 10);
            });

            return {
                patientId: patientIdEl.value,
                assessmentDate: assessmentDateEl.value,
                length: length,
                width: width,
                depth: depth,
                area: length * width,
                granulation: parseInt(granulationEl.value, 10),
                slough: parseInt(sloughEl.value, 10),
                necrotic: parseInt(necroticEl.value, 10),
                exudateAmount: exudateAmountEl.value,
                exudateAmountText: exudateAmountEl.options[exudateAmountEl.selectedIndex].text,
                exudateType: exudateTypeEl.value,
                exudateTypeText: exudateTypeEl.options[exudateTypeEl.selectedIndex].text,
                woundEdges: woundEdgesEl.value,
                undermining: underminingEl.value,
                periwoundEdema: periwoundEdemaEl.value,
                periwoundInduration: periwoundIndurationEl.value,
                odor: odorEl.value,
                painLevel: painLevelEl.value,
                infectionScore: infectionScore,
                infectionSigns: Array.from(infectionSignsContainer.querySelectorAll('input:checked'))
                    .map(cb => cb.parentElement.querySelector('span').textContent)
                    .join(', ') || 'None',
            };
        };

        /**
         * Updates the main SVG Score Gauge
         */
        const updateSvgGauge = (scorePercent, scoreColor, scoreTextColor, description) => {
            const offset = GAUGE_CIRCUMFERENCE - (scorePercent / 100) * GAUGE_CIRCUMFERENCE;
            scoreGaugeValueEl.style.strokeDasharray = `${GAUGE_CIRCUMFERENCE} ${GAUGE_CIRCUMFERENCE}`;
            scoreGaugeValueEl.style.strokeDashoffset = offset;
            scoreGaugeValueEl.style.stroke = scoreColor;

            scoreValueEl.className = `text-5xl font-bold ${scoreTextColor}`;
            scoreDescriptionEl.textContent = description;
            scoreDescriptionEl.className = `mt-4 font-semibold text-lg ${scoreTextColor}`;
        };

        /**
         * Updates the SVG Composition Donut Chart
         */
        const updateCompositionDonut = (gran, slough, nec) => {
            const total = (gran + slough + nec) || 100;
            const granPercent = gran / total;
            const sloughPercent = slough / total;

            const granOffset = 0;
            const sloughOffset = GAUGE_CIRCUMFERENCE * granPercent;
            const necroticOffset = GAUGE_CIRCUMFERENCE * (granPercent + sloughPercent);

            granulationDonutEl.style.strokeDasharray = `${GAUGE_CIRCUMFERENCE * granPercent} ${GAUGE_CIRCUMFERENCE}`;
            granulationDonutEl.style.strokeDashoffset = -granOffset;

            sloughDonutEl.style.strokeDasharray = `${GAUGE_CIRCUMFERENCE * sloughPercent} ${GAUGE_CIRCUMFERENCE}`;
            sloughDonutEl.style.strokeDashoffset = -sloughOffset;

            necroticDonutEl.style.strokeDasharray = `${GAUGE_CIRCUMFERENCE * (1 - granPercent - sloughPercent)} ${GAUGE_CIRCUMFERENCE}`;
            necroticDonutEl.style.strokeDashoffset = -necroticOffset;

            granDonutValueEl.textContent = `${gran}%`;
            sloughDonutValueEl.textContent = `${slough}%`;
            necroticDonutValueEl.textContent = `${nec}%`;
        };

        /**
         * Main function to update the entire metrics dashboard.
         */
        const updateDashboard = () => {
            const formData = getFormData();
            const score = calculateScore(formData);
            const scorePercent = Math.min(100, Math.max(0, (score / MAX_SCORE) * 100));

            // 1. Update Score Gauge
            let scoreColor = '#22c55e'; // green-500
            let scoreTextColor = 'text-green-400';
            let description = 'Low Severity';

            if (scorePercent > 33 && scorePercent <= 66) {
                scoreColor = '#facc15'; // yellow-400
                scoreTextColor = 'text-yellow-400';
                description = 'Moderate Severity';
            } else if (scorePercent > 66) {
                scoreColor = '#f87171'; // red-400
                scoreTextColor = 'text-red-400';
                description = 'High Severity';
            }

            scoreValueEl.textContent = score;
            updateSvgGauge(scorePercent, scoreColor, scoreTextColor, description);

            // 2. Update Key Metrics Grid
            metricAreaEl.textContent = formData.area.toFixed(1);
            metricDepthEl.textContent = formData.depth.toFixed(1);

            // 2a. Update Pain Bar
            const painPercent = (formData.painLevel / 10) * 100;
            metricPainBarEl.style.width = `${painPercent}%`;

            // 2b. Update Infection Risk
            let infectionRisk = 'None';
            let infectionColor = 'text-green-400';
            if (formData.infectionScore > 0 && formData.infectionScore <= 3) {
                infectionRisk = 'Low';
                infectionColor = 'text-yellow-400';
            } else if (formData.infectionScore > 3 && formData.infectionScore <= 6) {
                infectionRisk = 'Moderate';
                infectionColor = 'text-orange-400';
            } else if (formData.infectionScore > 6) {
                infectionRisk = 'High';
                infectionColor = 'text-red-400';
            }
            metricInfectionRiskEl.textContent = infectionRisk;
            metricInfectionRiskEl.className = `text-xl font-semibold ${infectionColor}`;

            // 3. Update Exudate Metrics
            metricExudateAmountEl.textContent = formData.exudateAmountText;
            metricExudateTypeEl.textContent = formData.exudateTypeText;

            // 4. Update Wound Bed Chart
            updateCompositionDonut(formData.granulation, formData.slough, formData.necrotic);

            // 5. Update AI Summary (simulated)
            const aiSummaryText = generateAISummary(score, formData);
            aiSummaryEl.innerHTML = aiSummaryText;

            aiSpinnerEl.style.display = 'none';
            aiSummaryEl.style.display = 'block';

            copyButton.disabled = false;
        };

        const handleFormInput = () => {
            aiSpinnerEl.style.display = 'flex';
            aiSummaryEl.style.display = 'none';
            copyButton.disabled = true;

            // Update sliders immediately
            granulationValueEl.textContent = granulationEl.value;
            sloughValueEl.textContent = sloughEl.value;
            necroticValueEl.textContent = necroticEl.value;
            painValueEl.textContent = painLevelEl.value;

            const total = parseInt(granulationEl.value) + parseInt(sloughEl.value) + parseInt(necroticEl.value);
            tissueTotalEl.textContent = total;
            tissueTotalWarningEl.className = total === 100 ? 'text-sm text-green-400 font-medium text-center' : 'text-sm text-yellow-400 font-medium text-center';

            clearTimeout(analysisTimeout);
            analysisTimeout = setTimeout(updateDashboard, 500);
        };

        /**
         * --- History Chart Functions ---
         */
        const getHistory = () => {
            return JSON.parse(localStorage.getItem(DB_KEY) || '[]');
        };

        const saveHistory = (data) => {
            localStorage.setItem(DB_KEY, JSON.stringify(data));
        };

        const renderHistoryChart = () => {
            const data = getHistory();
            const labels = data.map(item => new Date(item.date).toLocaleDateString('en-US')); // Changed to en-US
            const scores = data.map(item => item.score);

            if (historyChart) {
                historyChart.destroy();
            }

            historyChart = new Chart(historyChartCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Severity Index', // Translated
                        data: scores,
                        borderColor: '#3b82f6', // blue-600
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#3b82f6',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: MAX_SCORE,
                            grid: { color: 'rgba(255, 255, 255, 0.1)' },
                            ticks: { color: '#9ca3af' } // gray-400
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' } // gray-400
                        }
                    }
                }
            });
        };

        const onSaveAssessment = () => {
            const formData = getFormData();
            const score = calculateScore(formData);
            const history = getHistory();

            history.push({
                date: new Date().toISOString(),
                score: score,
                patientId: formData.patientId
            });

            saveHistory(history);
            renderHistoryChart();

            // Feedback
            copyFeedback.textContent = 'Assessment Saved!'; // Translated
            setTimeout(() => { copyFeedback.textContent = ''; }, 2000);
        };

        /**
         * --- Image Scan Simulation ---
         */
        const simulateImageScan = () => {
            scanOverlayEl.classList.add('scanning');
            uploadTextEl.textContent = "AI scanning image..."; // Translated

            setTimeout(() => {
                scanOverlayEl.classList.remove('scanning');
                uploadTextEl.textContent = "AI analysis complete!"; // Translated

                // AI "suggests" values
                granulationEl.value = 40;
                sloughEl.value = 50;
                necroticEl.value = 10;

                // Trigger form update
                handleFormInput();

            }, 2000); // 2 second scan
        };

        // --- Event Listeners ---
        allInputs.forEach(input => {
            input.addEventListener('input', handleFormInput);
        });

        woundImageEl.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    imagePreviewEl.src = event.target.result;
                    imagePreviewEl.style.display = 'block';
                };
                reader.readAsDataURL(file);
                uploadTextEl.textContent = file.name;

                simulateImageScan();
            }
        });

        saveButton.addEventListener('click', onSaveAssessment);

        copyButton.addEventListener('click', () => {
            const formData = getFormData();
            const score = calculateScore(formData);

            let reportText = `WOUND ASSESSMENT REPORT\n=====================\n`;
            reportText += `Patient ID: ${formData.patientId || 'N/A'}\n`;
            reportText += `Date: ${new Date(formData.assessmentDate).toLocaleDateString('en-US') || 'N/A'}\n`; // en-US
            reportText += `\n--- METRICS ---\n`;
            reportText += `Severity Index: ${score} / ${MAX_SCORE}\n`;
            reportText += `Assessment: ${scoreDescriptionEl.textContent}\n`;
            reportText += `Dimensions (LxWxD): ${formData.length} x ${formData.width} x ${formData.depth} cm\n`;
            reportText += `Area: ${formData.area.toFixed(1)} cm²\n`;
            reportText += `Pain: ${formData.painLevel}/10\n`;

            reportText += `\n--- WOUND BED ---\n`;
            reportText += `Granulation: ${formData.granulation}%\n`;
            reportText += `Slough/Fibrin: ${formData.slough}%\n`;
            reportText += `Necrotic/Eschar: ${formData.necrotic}%\n`;

            reportText += `\n--- CHARACTERISTICS ---\n`;
            reportText += `Exudate Amount: ${formData.exudateAmountText}\n`;
            reportText += `Exudate Type: ${formData.exudateTypeText}\n`;
            reportText += `Wound Edges: ${woundEdgesEl.options[woundEdgesEl.selectedIndex].text}\n`;
            reportText += `Undermining/Tunneling: ${underminingEl.options[underminingEl.selectedIndex].text}\n`;
            reportText += `Periwound Edema: ${periwoundEdemaEl.options[periwoundEdemaEl.selectedIndex].text}\n`;
            reportText += `Periwound Induration: ${periwoundIndurationEl.options[periwoundIndurationEl.selectedIndex].text}\n`;
            reportText += `Odor: ${odorEl.options[odorEl.selectedIndex].text}\n`;
            reportText += `Infection Signs: ${formData.infectionSigns}\n`;

            reportText += `\n--- AI ANALYSIS ---\n`;
            reportText += aiSummaryEl.innerHTML.replace(/<br>/g, '\n').replace(/<strong>/g, '').replace(/<\/strong>/g, '');

            const tempTextArea = document.createElement('textarea');
            tempTextArea.value = reportText;
            document.body.appendChild(tempTextArea);
            tempTextArea.select();
            try {
                document.execCommand('copy');
                copyFeedback.textContent = 'Report copied!';
            } catch (err) {
                copyFeedback.textContent = 'Copy failed.';
                console.error('Fallback: Oops, unable to copy', err);
            }
            document.body.removeChild(tempTextArea);

            setTimeout(() => {
                copyFeedback.textContent = '';
            }, 2000);
        });

        // --- Initial Call ---
        handleFormInput();
        renderHistoryChart();
    });
</script>
</body>
</html>
