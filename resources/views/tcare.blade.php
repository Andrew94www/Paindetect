<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-CaRe - Advanced Pain Risk Assessment</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js for graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Base styling */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0d1117; /* GitHub dark bg */
            color: #c9d1d9;
            /* Custom scrollbar for a modern look */
            scrollbar-width: thin;
            scrollbar-color: #4b5563 #1f2937;
        }

        body::-webkit-scrollbar {
            width: 8px;
        }
        body::-webkit-scrollbar-track {
            background: #1f2937;
        }
        body::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 4px;
            border: 2px solid #1f2937;
        }

        /* "Glassmorphism" Card Style */
        .glass-card {
            background: rgba(31, 41, 55, 0.5); /* bg-gray-800 with 50% opacity */
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(75, 85, 99, 0.3); /* border-gray-700 with 30% opacity */
            border-radius: 1rem; /* rounded-2xl */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Custom styles for form inputs in dark mode */
        .form-input {
            background-color: #1f2937; /* bg-gray-800 */
            border: 1px solid #374151; /* border-gray-700 */
            color: #e5e7eb; /* text-gray-200 */
            border-radius: 0.5rem; /* rounded-lg */
            transition: all 0.3s ease;
        }
        .form-input::placeholder {
            color: #6b7280; /* text-gray-500 */
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6; /* border-blue-500 */
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .form-select {
            background-color: #1f2937;
            border: 1px solid #374151;
            color: #e5e7eb;
            border-radius: 0.5rem;
        }

        .form-checkbox {
            background-color: #374151;
            border: 1px solid #4b5563;
            color: #3b82f6; /* text-blue-500 */
        }

        /* --- Pain Map Styles (Dark Theme) --- */
        .pain-zone {
            fill: rgba(59, 130, 246, 0.05); /* Faint blue fill */
            stroke: rgba(59, 130, 246, 0.3); /* Blue border */
            stroke-width: 1px;
            cursor: pointer;
            transition: fill 0.2s ease-in-out, stroke 0.2s ease-in-out;
            pointer-events: all;
        }
        .pain-zone:hover {
            fill: rgba(59, 130, 246, 0.15); /* Brighter blue on hover */
            stroke: rgba(96, 165, 250, 0.7);
        }
        .pain-zone.selected {
            fill: rgba(239, 68, 68, 0.4); /* Red for "pain" */
            stroke: #ef4444; /* Solid red border */
            stroke-width: 2px;
        }
        .segment-label {
            pointer-events: none;
            font-weight: 700;
            font-size: 14px;
            text-anchor: middle;
            fill: #e5e7eb; /* Light text */
            stroke: #0d1117; /* Dark outline for contrast */
            stroke-width: 0.5px;
            paint-order: stroke;
        }
        .special-label {
            font-size: 12px;
            font-weight: 500;
            fill: #9ca3af; /* gray-400 */
        }

        /* --- View Toggle Button Styles --- */
        .view-toggle-btn {
            transition: all 0.3s;
            background-color: transparent;
            border: 1px solid #374151; /* border-gray-700 */
            color: #9ca3af; /* text-gray-400 */
        }
        .view-toggle-btn.active {
            background-color: #3b82f6; /* bg-blue-600 */
            color: white;
            border-color: #3b82f6;
        }
        .view-toggle-btn.inactive:hover {
            background-color: #374151; /* bg-gray-700 */
            color: #e5e7eb;
        }

        /* --- Loading Overlay --- */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 17, 23, 0.8);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        #loading-overlay.visible {
            opacity: 1;
            pointer-events: all;
        }
        .spinner {
            width: 64px;
            height: 64px;
            border: 6px solid #4b5563; /* border-gray-600 */
            border-top-color: #3b82f6; /* border-blue-500 */
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Chart.js container */
        .chart-container {
            position: relative;
            height: 250px; /* Adjusted height */
            width: 100%;
        }
        .chart-container-radar {
            position: relative;
            height: 320px;
            width: 100%;
        }

    </style>
</head>
<body class="min-h-screen p-4 md:p-8">

<!-- Loading Overlay -->
<div id="loading-overlay" class="">
    <div class="text-center">
        <div class="spinner mx-auto"></div>
        <p class="text-lg font-semibold mt-4 text-gray-200">Running AI Analysis...</p>
        <p class="text-sm text-gray-400">Please wait while we process the patient data.</p>
    </div>
</div>

<!-- Main 2-Column Grid (lg:grid-cols-3 -> 1 col for sidebar, 2 cols for main) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-screen-2xl mx-auto">

    <!-- Column 1: Patient Inputs (Sidebar) -->
    <!-- This column comes first in HTML for correct mobile stacking -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-3 px-2">
            <svg class="w-10 h-10 text-blue-500" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM10.25 15.1893C10.2443 15.1831 10.2386 15.177 10.233 15.1708L10.2301 15.1673C9.83981 14.686 9.5 14.153 9.5 13.5C9.5 12.1193 10.6193 11 12 11C13.3807 11 14.5 12.1193 14.5 13.5C14.5 14.153 14.1602 14.686 13.7699 15.1673L13.767 15.1708C13.7614 15.177 13.7557 15.1831 13.75 15.1893V15.5C13.75 16.3284 13.0784 17 12.25 17H11.75C10.9216 17 10.25 16.3284 10.25 15.5V15.1893ZM12 7C12.5523 7 13 7.44772 13 8C13 8.55228 12.5523 9 12 9C11.4477 9 11 8.55228 11 8C11 7.44772 11.4477 7 12 7ZM15 13.5C15 11.8431 13.6569 10.5 12 10.5C10.3431 10.5 9 11.8431 9 13.5C9 14.316 9.42361 15.0447 10.0911 15.5H13.9089C14.5764 15.0447 15 14.316 15 13.5Z" fill="currentColor"/>
            </svg>
            <h1 class="text-3xl font-bold text-white">T-CaRe</h1>
        </div>

        <!-- Patient Profile -->
        <div class="glass-card p-6 space-y-4">
            <h2 class="text-xl font-bold text-white border-b border-gray-700 pb-2">Patient Profile</h2>
            <input id="age" type="number" placeholder="Age" class="form-input w-full p-2">
            <select id="sex" class="form-select w-full p-2">
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
            <div class="grid grid-cols-2 gap-4">
                <input id="weight" type="number" placeholder="Weight (kg)" class="form-input w-full p-2">
                <input id="height" type="number" placeholder="Height (cm)" class="form-input w-full p-2">
            </div>
            <div class="bg-gray-800 p-3 rounded-lg text-center">
                <span class="text-sm font-medium text-gray-400">BMI:</span>
                <span id="bmi-display" class="font-bold text-white text-lg ml-2">-</span>
            </div>
        </div>

        <!-- Clinical Risk Assessment -->
        <div class="glass-card p-6">
            <h2 class="text-xl font-bold mb-4 border-b border-gray-700 pb-2 text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                1. Clinical Risk Assessment
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input id="pain_score_72h" type="number" placeholder="72h Pain Score (NRS 0-10)" class="form-input p-2">
                <input id="pcs" type="number" placeholder="Pain Catastrophizing (PCS)" class="form-input p-2">
                <input id="opioid_days" type="number" placeholder="Opioid Use Days" class="form-input p-2">
                <input id="icu_days" type="number" placeholder="ICU Days" class="form-input p-2">
                <input id="gcs" type="number" placeholder="Glasgow Coma Scale (GCS)" class="form-input p-2">
                <input id="spo2" type="number" placeholder="Oxygen Saturation O₂ (%)" class="form-input p-2">
            </div>
            <div class="mt-4 pt-4 border-t border-gray-700">
                <div class="flex items-center space-x-3 p-2">
                    <input id="anticoagulants" type="checkbox" class="h-5 w-5 rounded form-checkbox focus:ring-blue-500">
                    <label for="anticoagulants" class="text-base text-gray-200">Patient is on Anticoagulants</label>
                </div>
            </div>
        </div>

        <!-- CT Interpretation -->
        <div class="glass-card p-6">
            <h2 class="text-xl font-bold mb-4 border-b border-gray-700 pb-2 text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                2. Chest CT Interpretation
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input id="rib_fractures" type="number" placeholder="# Rib Fractures" class="form-input p-2">
                <input id="deformity_index" type="number" placeholder="Deformity Index (0-3)" class="form-input p-2">
                <div class="flex items-center space-x-3 p-2 rounded-lg bg-gray-800/50"><input id="bilateral" type="checkbox" class="h-5 w-5 form-checkbox"><label for="bilateral">Bilateral</label></div>
                <div class="flex items-center space-x-3 p-2 rounded-lg bg-gray-800/50"><input id="sternal_fracture" type="checkbox" class="h-5 w-5 form-checkbox"><label for="sternal_fracture">Sternal Fx</label></div>
                <div class="flex items-center space-x-3 p-2 rounded-lg bg-gray-800/50"><input id="spine_fracture" type="checkbox" class="h-5 w-5 form-checkbox"><label for="spine_fracture">Spine Fx</label></div>
                <div class="flex items-center space-x-3 p-2 rounded-lg bg-gray-800/50"><input id="hemothorax" type="checkbox" class="h-5 w-5 form-checkbox"><label for="hemothorax">Hemothorax</label></div>
                <div class="flex items-center space-x-3 p-2 rounded-lg bg-gray-800/50"><input id="pneumothorax" type="checkbox" class="h-5 w-5 form-checkbox"><label for="pneumothorax">Pneumothorax</label></div>
                <div class="flex items-center space-x-3 p-2 rounded-lg bg-gray-800/50"><input id="nerve_contact" type="checkbox" class="h-5 w-5 form-checkbox"><label for="nerve_contact">Nerve Contact</label></div>
            </div>
        </div>

        <!-- CT Scan Upload -->
        <div class="glass-card p-6">
            <h2 class="text-xl font-bold mb-4 border-b border-gray-700 pb-2 text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                3. Upload CT Scan
            </h2>
            <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <button id="upload-ct-btn" type="button" class="w-full sm:w-auto flex-shrink-0 bg-blue-600 text-white font-medium py-2.5 px-5 rounded-lg hover:bg-blue-700 transition duration-300 shadow-md flex items-center justify-center border border-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Select Scan File
                </button>
                <input type="file" id="ct-file-input" class="hidden" accept=".dcm, .jpg, .png, .nii, .stl">
                <span id="file-name-display" class="text-sm text-gray-400 truncate mt-1 sm:mt-0">No file selected.</span>
            </div>
        </div>

        <!-- Selected Pain Zones (Moved to Sidebar) -->
        <div class="glass-card p-6">
            <h3 class="text-lg font-semibold text-white mb-3">Selected Pain Zones</h3>
            <div class="min-h-[60px] bg-gray-800/50 rounded-lg p-3">
                <p id="selected-zones-list" class="text-gray-300 font-medium text-sm">No Zones Selected</p>
            </div>
        </div>
    </div>

    <!-- Column 2: Map & AI Results (Main Content) -->
    <!-- This column comes second for correct desktop layout -->
    <div class="lg:col-span-2 space-y-6">
        <!-- ThoracoMap -->
        <div class="glass-card p-6">
            <h2 class="text-2xl font-bold mb-4 text-center text-white flex items-center justify-center gap-2">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                4. ThoracoMap
            </h2>
            <div class="flex justify-center mb-4">
                <div class="inline-flex rounded-lg overflow-hidden shadow-lg">
                    <button id="view-anterior-btn" class="view-toggle-btn active px-6 py-2 text-sm font-medium">Anterior</button>
                    <button id="view-posterior-btn" class="view-toggle-btn inactive px-6 py-2 text-sm font-medium">Posterior</button>
                </div>
            </div>

            <!-- Map Container -->
            <!-- Note: The map container is now centered within its column -->
            <div id="pain-map-container" class="w-full max-w-sm mx-auto relative bg-gray-900 border border-gray-700 rounded-xl overflow-hidden p-0" style="height: 650px; width: 400px;">
                <!-- Background Image Element -->
                <img id="anatomical-image" class="absolute inset-0 w-full h-full object-contain pointer-events-none"
                     src="img/anterior.jpg"
                     alt="Anatomical Torso Diagram" />

                <!-- SVG Overlay -->
                <div class="absolute inset-0">
                    <!-- Anterior View -->
                    <svg id="anterior-view" class="w-full h-full" viewBox="0 0 400 650">
                        <rect id="C-all" data-zone-id="C" class="pain-zone" x="160" y="100" width="80" height="280" rx="10"/>
                        <text x="200" y="240" class="segment-label">C</text>
                        <rect id="A3-top" data-zone-id="A3" class="pain-zone" x="80" y="100" width="80" height="140" rx="10"/>
                        <text x="120" y="170" class="segment-label">A3</text>
                        <rect id="B3-top" data-zone-id="B3" class="pain-zone" x="240" y="100" width="80" height="140" rx="10"/>
                        <text x="280" y="170" class="segment-label">B3</text>
                        <rect id="A2-mid" data-zone-id="A2" class="pain-zone" x="80" y="240" width="80" height="140" rx="10"/>
                        <text x="120" y="310" class="segment-label">A2</text>
                        <rect id="B2-mid" data-zone-id="B2" class="pain-zone" x="240" y="240" width="80" height="140" rx="10"/>
                        <text x="280" y="310" class="segment-label">B2</text>
                        <rect id="D-all" data-zone-id="D" class="pain-zone" x="80" y="380" width="240" height="70" rx="10"/>
                        <text x="200" y="415" class="segment-label">D</text>
                        <text x="200" y="640" class="special-label">Anterior View</text>
                    </svg>
                    <!-- Posterior View -->
                    <svg id="posterior-view" class="w-full h-full hidden" viewBox="0 0 400 650">
                        <rect id="E1-left" data-zone-id="E1" class="pain-zone" x="80" y="100" width="50" height="300" rx="10"/>
                        <text x="105" y="250" class="segment-label">E1</text>
                        <rect id="E2-right" data-zone-id="E2" class="pain-zone" x="270" y="100" width="50" height="300" rx="10"/>
                        <text x="295" y="250" class="segment-label">E2</text>
                        <rect id="F1-left" data-zone-id="F1" class="pain-zone" x="130" y="100" width="40" height="300" rx="10"/>
                        <text x="150" y="250" class="segment-label">F1</text>
                        <rect id="F2-right" data-zone-id="F2" class="pain-zone" x="230" y="100" width="40" height="300" rx="10"/>
                        <text x="250" y="250" class="segment-label">F2</text>
                        <rect id="G-spine" data-zone-id="G" class="pain-zone" x="170" y="100" width="60" height="300" rx="10"/>
                        <text x="200" y="250" class="segment-label">G</text>
                        <rect id="H-all" data-zone-id="H" class="pain-zone" x="80" y="400" width="240" height="150" rx="10"/>
                        <text x="200" y="475" class="segment-label">H</text>
                        <text x="200" y="580" class="special-label">Lower thoracic/lumbar</text>
                        <text x="200" y="640" class="special-label">Posterior View</text>
                    </svg>
                </div>
            </div>
        </div>

        <!-- AI Control -->
        <div class="glass-card p-6">
            <h2 class="text-2xl font-bold text-white mb-4 text-center">AI Analysis</h2>
            <button id="calculate-btn" class="w-full md:w-3/4 lg:w-1/2 bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 text-lg shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mx-auto gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Run AI Assessment
            </button>
        </div>

        <!-- Placeholder for AI results -->
        <div id="results-placeholder" class="glass-card p-6 text-center">
            <svg class="w-16 h-16 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <h3 class="text-xl font-semibold text-gray-400 mt-4">AI Report Pending</h3>
            <p class="text-gray-500 mt-2">Click "Run AI Assessment" to generate the patient's risk report.</p>
        </div>

        <!-- AI Analysis Report Section (Hidden by default) -->
        <div id="results" class="glass-card p-6 space-y-6 hidden">
            <!-- Header -->
            <h3 class="text-2xl font-bold text-white text-center border-b border-gray-700 pb-3">AI Analysis Report</h3>

            <!-- Final Risk Gauge -->
            <div>
                <h3 class="text-xl font-bold text-white mb-3 text-center">Chronification Risk</h3>
                <!-- Chart Container: relative positioning for overlay -->
                <div class="chart-container relative">
                    <canvas id="risk-gauge-chart"></canvas>
                    <!-- Text Overlay -->
                    <div id="final-risk-overlay" class="absolute inset-0 flex items-center justify-center pointer-events-none" style="top: 55%;"> <!-- Adjust top offset as needed -->
                        <p id="final-risk" class="font-bold text-4xl text-center"></p>
                    </div>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-gray-800 p-3 rounded-lg text-center">
                    <p class="text-xs font-medium text-gray-400">STUMBL</p>
                    <p id="stumbl-score" class="font-extrabold text-blue-400 text-3xl mt-1">-</p>
                </div>
                <div class="bg-gray-800 p-3 rounded-lg text-center">
                    <p class="text-xs font-medium text-gray-400">Imaging</p>
                    <p id="imaging-score" class="font-extrabold text-green-400 text-3xl mt-1">-</p>
                </div>
                <div class="bg-gray-800 p-3 rounded-lg text-center">
                    <p class="text-xs font-medium text-gray-400">Flags</p>
                    <p id="risk-flag-count" class="font-extrabold text-yellow-400 text-3xl mt-1">-</p>
                </div>
            </div>

            <!-- AI-Generated Summary -->
            <div>
                <h3 class="text-xl font-bold text-white mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    AI-Generated Summary
                </h3>
                <p id="ai-summary" class="text-gray-300 leading-relaxed text-sm bg-gray-800/50 p-3 rounded-lg">Analysis results will appear here...</p>
            </div>

            <!-- Risk Factor Breakdown -->
            <div>
                <h3 class="text-xl font-bold text-white mb-3 text-center">Risk Factor Breakdown</h3>
                <div class="chart-container-radar">
                    <canvas id="risk-radar-chart"></canvas>
                </div>
            </div>

            <!-- Risk Flags Details -->
            <div>
                <h3 class="text-xl font-bold text-white mb-2">Clinical Risk Flags</h3>
                <ul id="risk-flags" class="list-disc list-inside text-yellow-300 mt-2 ml-4 space-y-1 text-sm font-medium">
                    <li>No flags detected.</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- Image URLs ---
        // IMPORTANT: Replace these placeholders with actual URLs to your anatomical images.
        const ANTERIOR_IMAGE_URL = "img/anterior.jpg";
        const POSTERIOR_IMAGE_URL = "img/posterior.jpg";

        // --- DOM Element References ---
        // Inputs
        const weightInput = document.getElementById('weight');
        const heightInput = document.getElementById('height');
        const bmiDisplay = document.getElementById('bmi-display');
        const calculateBtn = document.getElementById('calculate-btn');
        const loadingOverlay = document.getElementById('loading-overlay');

        // Results
        const resultsDiv = document.getElementById('results');
        const resultsPlaceholder = document.getElementById('results-placeholder');
        const stumblScoreEl = document.getElementById('stumbl-score');
        const riskFlagsEl = document.getElementById('risk-flags');
        const riskFlagCountEl = document.getElementById('risk-flag-count');
        const imagingScoreEl = document.getElementById('imaging-score');
        const finalRiskEl = document.getElementById('final-risk');
        const aiSummaryEl = document.getElementById('ai-summary');

        // File Upload
        const ctFileInput = document.getElementById('ct-file-input');
        const uploadCtBtn = document.getElementById('upload-ct-btn');
        const fileNameDisplay = document.getElementById('file-name-display');

        // Pain Map
        const viewAnteriorBtn = document.getElementById('view-anterior-btn');
        const viewPosteriorBtn = document.getElementById('view-posterior-btn');
        const anteriorView = document.getElementById('anterior-view');
        const posteriorView = document.getElementById('posterior-view');
        const anatomicalImageEl = document.getElementById('anatomical-image');
        const painZones = document.querySelectorAll('.pain-zone');
        const selectedZonesList = document.getElementById('selected-zones-list');

        let selectedPainZones = new Set();
        let calculatedBmi = 0;

        // Chart.js Instances
        let riskGaugeChart = null;
        let riskRadarChart = null;
        const riskGaugeCanvas = document.getElementById('risk-gauge-chart');
        const riskRadarCanvas = document.getElementById('risk-radar-chart');

        // --- Chart.js Setup ---

        /**
         * Initializes the charts with default/empty data.
         */
        function createCharts() {
            const defaultChartOptions = {
                plugins: {
                    legend: {
                        labels: {
                            color: '#c9d1d9' // Light text
                        }
                    }
                }
            };

            // Risk Gauge (Doughnut Chart)
            if (riskGaugeCanvas) {
                const ctx = riskGaugeCanvas.getContext('2d');
                riskGaugeChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Risk', 'Remainder'],
                        datasets: [{
                            data: [0, 100],
                            backgroundColor: ['#4b5563', '#374151'],
                            borderColor: ['#0d1117'],
                            borderWidth: 2,
                            circumference: 180, // Half circle
                            rotation: 270,      // Start at the bottom
                        }]
                    },
                    options: {
                        ...defaultChartOptions,
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        },
                        cutout: '70%',
                    }
                });
            }

            // Risk Factor Breakdown (Radar Chart)
            if (riskRadarCanvas) {
                const ctx = riskRadarCanvas.getContext('2d');
                riskRadarChart = new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: ['Clinical', 'Imaging', 'Psychosocial', 'Injury Severity'],
                        datasets: [{
                            label: 'Risk Contribution',
                            data: [0, 0, 0, 0],
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(59, 130, 246, 1)',
                        }]
                    },
                    options: {
                        ...defaultChartOptions,
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                angleLines: { color: 'rgba(201, 209, 217, 0.2)' },
                                grid: { color: 'rgba(201, 209, 217, 0.2)' },
                                pointLabels: {
                                    color: '#c9d1d9',
                                    font: { size: 12 }
                                },
                                ticks: {
                                    color: '#0d1117', // Hide ticks
                                    backdropColor: '#0d1117',
                                    stepSize: 2,
                                    max: 10,
                                    min: 0
                                }
                            }
                        }
                    }
                });
            }
        }

        /**
         * Updates all charts with new calculation data.
         */
        function updateCharts(riskValue, riskColor, radarData) {
            // Update Gauge Chart
            if (riskGaugeChart) {
                riskGaugeChart.data.datasets[0].data = [riskValue, 100 - riskValue];
                riskGaugeChart.data.datasets[0].backgroundColor = [riskColor, '#374151'];
                riskGaugeChart.update();
            }

            // Update Radar Chart
            if (riskRadarChart) {
                riskRadarChart.data.datasets[0].data = [
                    radarData.clinical,
                    radarData.imaging,
                    radarData.psychosocial,
                    radarData.severity
                ];
                riskRadarChart.update();
            }
        }

        // --- Calculation Logic (Hypothetical, from original) ---

        function calculateBmi() {
            const weight = parseFloat(weightInput.value);
            const height = parseFloat(heightInput.value);
            if (weight > 0 && height > 0) {
                const heightInMeters = height / 100;
                calculatedBmi = weight / (heightInMeters * heightInMeters);
                bmiDisplay.textContent = calculatedBmi.toFixed(1);
            } else {
                calculatedBmi = 0;
                bmiDisplay.textContent = '-';
            }
        }

        function calculateStumblScore(inputs) {
            let score = 0;
            if (inputs.age >= 65) score += 2;
            if (inputs.rib_fractures >= 3) score += 5;
            if (inputs.anticoagulants) score += 3;
            if (inputs.spo2 < 95) score += 2;
            if (inputs.gcs < 15) score += 2;
            return score;
        }

        function getClinicalRiskFlags(inputs) {
            const flags = [];
            if (inputs.pcs > 30) flags.push("High Pain Catastrophizing (PCS > 30)");
            if (inputs.opioid_days > 7) flags.push("Prolonged Opioid Use (> 7 days)");
            if (inputs.icu_days > 3) flags.push("Prolonged ICU Stay (> 3 days)");
            if (inputs.pain_score_72h >= 6) flags.push("Severe Early Pain (NRS ≥ 6)");
            return flags;
        }

        function calculateImagingRiskScore(inputs) {
            let score = 0;
            score += (inputs.rib_fractures || 0) * 0.5;
            if (inputs.bilateral) score += 2;
            if (inputs.sternal_fracture) score += 1.5;
            if (inputs.spine_fracture) score += 2;
            if (inputs.hemothorax) score += 1;
            if (inputs.pneumothorax) score += 1;
            if (inputs.nerve_contact) score += 1.5;
            score += inputs.deformity_index || 0;
            return Math.min(score, 10);
        }

        function predictChronificationRisk(stumblScore, imagingScore, inputs, flags) {
            let totalScore = 0;
            totalScore += stumblScore * 0.6;
            totalScore += imagingScore * 0.8;
            if (flags.includes("High Pain Catastrophizing (PCS > 30)")) totalScore += 2;
            if (flags.includes("Prolonged Opioid Use (> 7 days)")) totalScore += 1.5;
            if (flags.includes("Prolonged ICU Stay (> 3 days)")) totalScore += 1.5;

            // Normalize to a 0-20 scale for this example
            const maxScore = 20; // Hypothetical max score
            let riskValue = Math.min((totalScore / maxScore) * 100, 100);

            if (riskValue < 33) return { level: "Low Risk", color: "#22c55e", hex: "#22c55e", value: riskValue };
            if (riskValue < 66) return { level: "Moderate Risk", color: "#f59e0b", hex: "#f59e0b", value: riskValue };
            return { level: "High Risk", color: "#ef4444", hex: "#ef4444", value: riskValue };
        }

        /**
         * Generates a natural language summary of the findings.
         */
        function generateAiSummary(risk, stumbl, imagingScore, flags) {
            let summary = `The AI model predicts a <strong class="font-bold" style="color:${risk.hex};">${risk.level}</strong> of pain chronification (Risk Score: ${risk.value.toFixed(0)}/100). `;

            if (risk.level === "High Risk") {
                summary += "This is primarily driven by ";
                let drivers = [];
                if (stumbl > 7) drivers.push("a high STUMBL score");
                if (imagingScore > 5) drivers.push("severe imaging findings");
                if (flags.length > 2) drivers.push("multiple clinical risk flags");
                if (drivers.length === 0) drivers.push("a combination of moderate risk factors.");
                summary += drivers.join(', ') + ". ";
            } else if (risk.level === "Moderate Risk") {
                summary += "This is based on a balance of factors. ";
                if (flags.length > 0) {
                    summary += `While the STUMBL (${stumbl}) and Imaging (${imagingScore.toFixed(1)}) scores are moderate, the presence of ${flags.length} clinical flag(s) (e.g., ${flags[0] || '...'}) elevates the risk. `;
                } else {
                    summary += `The STUMBL (${stumbl}) and Imaging (${imagingScore.toFixed(1)}) scores indicate a notable, but not severe, risk. `;
                }
            } else {
                summary += "The patient profile shows favorable indicators. ";
                summary += `The STUMBL score (${stumbl}), Imaging score (${imagingScore.toFixed(1)}), and lack of major clinical flags (${flags.length}) all suggest a positive prognosis for recovery. `;
            }

            summary += "Pain map analysis shows " + (selectedPainZones.size > 0 ? `${selectedPainZones.size} zones affected, including [${Array.from(selectedPainZones).sort().join(', ')}].` : "no specific pain zones manually selected.");

            return summary;
        }

        /**
         * Creates the data object for the radar chart based on scores.
         */
        function getRadarData(stumbl, imagingScore, inputs, flags) {
            let psychosocial = 0;
            if (flags.includes("High Pain Catastrophizing (PCS > 30)")) psychosocial += 5;
            if (flags.includes("Prolonged Opioid Use (> 7 days)")) psychosocial += 3;

            let clinical = 0;
            if (inputs.age >= 65) clinical += 3;
            if (inputs.spo2 < 95) clinical += 3;
            if (inputs.gcs < 15) clinical += 2;
            if (flags.includes("Severe Early Pain (NRS ≥ 6)")) clinical += 4;

            // Scale 0-10
            return {
                clinical: Math.min(clinical, 10),
                imaging: Math.min(imagingScore, 10),
                psychosocial: Math.min(psychosocial, 10),
                severity: Math.min(stumbl * 0.8, 10) // STUMBL is a mix, use as severity
            };
        }

        // --- Event Handlers ---

        // BMI
        weightInput.addEventListener('input', calculateBmi);
        heightInput.addEventListener('input', calculateBmi);

        // File Upload
        uploadCtBtn.addEventListener('click', () => ctFileInput.click());
        ctFileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                fileNameDisplay.textContent = file.name;
                fileNameDisplay.classList.remove('text-gray-400');
                fileNameDisplay.classList.add('text-blue-400', 'font-medium');
            } else {
                fileNameDisplay.textContent = 'No file selected.';
                fileNameDisplay.classList.add('text-gray-400');
                fileNameDisplay.classList.remove('text-blue-400', 'font-medium');
            }
        });

        // Main Calculation
        calculateBtn.addEventListener('click', () => {
            // Show loading spinner
            loadingOverlay.classList.add('visible');

            // Simulate AI processing time (e.g., 1.5 seconds)
            setTimeout(() => {
                // 1. Get all input values
                const inputs = {
                    age: parseInt(document.getElementById('age').value) || 0,
                    bmi: calculatedBmi,
                    pain_score_72h: parseInt(document.getElementById('pain_score_72h').value) || 0,
                    pcs: parseInt(document.getElementById('pcs').value) || 0,
                    opioid_days: parseInt(document.getElementById('opioid_days').value) || 0,
                    icu_days: parseInt(document.getElementById('icu_days').value) || 0,
                    gcs: parseInt(document.getElementById('gcs').value) || 15,
                    spo2: parseInt(document.getElementById('spo2').value) || 99,
                    anticoagulants: document.getElementById('anticoagulants').checked,
                    rib_fractures: parseInt(document.getElementById('rib_fractures').value) || 0,
                    deformity_index: parseFloat(document.getElementById('deformity_index').value) || 0,
                    bilateral: document.getElementById('bilateral').checked,
                    sternal_fracture: document.getElementById('sternal_fracture').checked,
                    spine_fracture: document.getElementById('spine_fracture').checked,
                    hemothorax: document.getElementById('hemothorax').checked,
                    pneumothorax: document.getElementById('pneumothorax').checked,
                    nerve_contact: document.getElementById('nerve_contact').checked,
                };

                // 2. Perform calculations
                const stumbl = calculateStumblScore(inputs);
                const flags = getClinicalRiskFlags(inputs);
                const imagingScore = parseFloat(calculateImagingRiskScore(inputs));
                const finalRisk = predictChronificationRisk(stumbl, imagingScore, inputs, flags);
                const summary = generateAiSummary(finalRisk, stumbl, imagingScore, flags);
                const radarData = getRadarData(stumbl, imagingScore, inputs, flags);

                // 3. Display results
                // Metrics
                stumblScoreEl.textContent = stumbl;
                imagingScoreEl.textContent = imagingScore.toFixed(1);
                riskFlagCountEl.textContent = flags.length;

                // Risk Flags
                riskFlagsEl.innerHTML = '';
                if (flags.length > 0) {
                    flags.forEach(flag => {
                        const li = document.createElement('li');
                        li.textContent = flag;
                        riskFlagsEl.appendChild(li);
                    });
                } else {
                    const li = document.createElement('li');
                    li.textContent = 'None Detected';
                    li.className = 'text-gray-400';
                    riskFlagsEl.appendChild(li);
                }

                // Final Risk & Summary
                finalRiskEl.textContent = finalRisk.level;
                finalRiskEl.style.color = finalRisk.hex;
                aiSummaryEl.innerHTML = summary;

                // 4. Update Charts
                updateCharts(finalRisk.value, finalRisk.hex, radarData);

                // 5. Show results and hide loader
                resultsPlaceholder.classList.add('hidden');
                resultsDiv.classList.remove('hidden');
                loadingOverlay.classList.remove('visible');

                // Scroll to results
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });

            }, 1500); // 1.5 second delay
        });

        // Pain Map Logic
        viewAnteriorBtn.addEventListener('click', () => {
            anteriorView.classList.remove('hidden');
            posteriorView.classList.add('hidden');
            viewAnteriorBtn.classList.replace('inactive', 'active');
            viewPosteriorBtn.classList.replace('active', 'inactive');
            anatomicalImageEl.src = ANTERIOR_IMAGE_URL;
        });

        viewPosteriorBtn.addEventListener('click', () => {
            posteriorView.classList.remove('hidden');
            anteriorView.classList.add('hidden');
            viewPosteriorBtn.classList.replace('inactive', 'active');
            viewAnteriorBtn.classList.replace('active', 'inactive');
            anatomicalImageEl.src = POSTERIOR_IMAGE_URL;
        });

        painZones.forEach(zone => {
            zone.addEventListener('click', () => {
                const zoneId = zone.dataset.zoneId;
                const segments = document.querySelectorAll(`[data-zone-id="${zoneId}"]`);

                if (zone.classList.contains('selected')) {
                    segments.forEach(seg => seg.classList.remove('selected'));
                    selectedPainZones.delete(zoneId);
                } else {
                    segments.forEach(seg => seg.classList.add('selected'));
                    selectedPainZones.add(zoneId);
                }
                updateSelectedZonesList();
            });
        });

        function updateSelectedZonesList() {
            if (selectedPainZones.size === 0) {
                selectedZonesList.textContent = 'No Zones Selected';
            } else {
                selectedZonesList.textContent = Array.from(selectedPainZones).sort().join(', ');
            }
        }

        // --- Initial Setup ---
        anatomicalImageEl.src = ANTERIOR_IMAGE_URL; // Set initial image
        createCharts(); // Initialize empty charts on load

    });
</script>
</body>
</html>
