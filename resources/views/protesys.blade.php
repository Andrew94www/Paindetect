<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prothesys AI - Stump Pain Prognosis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* slate-900 */
        }

        /* Custom scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1e293b; /* slate-800 */
        }
        ::-webkit-scrollbar-thumb {
            background: #334155; /* slate-700 */
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569; /* slate-600 */
        }

        /* Custom styles for slider thumb */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #38bdf8; /* sky-500 */
            cursor: pointer;
            border-radius: 50%;
            margin-top: -8px;
            transition: background-color 0.2s ease;
        }
        input[type="range"]::-webkit-slider-thumb:hover {
            background: #7dd3fc; /* sky-300 */
        }
        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #38bdf8; /* sky-500 */
            cursor: pointer;
            border-radius: 50%;
        }
        input[type="range"] {
            height: 4px;
            background: #334155; /* slate-700 */
        }

        /* Styles for the drawing canvas */
        #canvas-container {
            position: relative;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #334155; /* slate-700 */
        }
        #pain-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: crosshair;
            touch-action: none;
        }
        #bg-image {
            display: block;
            width: 100%;
            height: auto;
            /* The placeholder image has a dark background to fit the theme */
        }

        /* Custom radio/checkbox styles */
        .form-radio, .form-checkbox {
            appearance: none;
            -webkit-appearance: none;
            height: 1.25rem;
            width: 1.25rem;
            background-color: #334155; /* slate-700 */
            border: 1px solid #475569; /* slate-600 */
            display: inline-block;
            vertical-align: middle;
            position: relative;
            cursor: pointer;
        }
        .form-radio {
            border-radius: 50%;
        }
        .form-checkbox {
            border-radius: 0.25rem;
        }
        .form-radio:checked, .form-checkbox:checked {
            background-color: #38bdf8; /* sky-500 */
            border-color: #38bdf8; /* sky-500 */
        }
        .form-radio:checked::after {
            content: '';
            display: block;
            width: 0.5rem;
            height: 0.5rem;
            background: #0f172a; /* slate-900 */
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .form-checkbox:checked::after {
            content: '✓';
            display: block;
            color: #0f172a; /* slate-900 */
            font-weight: 900;
            font-size: 0.8rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* AI Results Panel Styling */
        #results-panel {
            background: #1e293b; /* slate-800 */
            border: 1px solid #334155; /* slate-700 */
            border-radius: 0.75rem;
            overflow: hidden;
        }

        /* Loading Spinner */
        .spinner {
            border: 4px solid #334155; /* slate-700 */
            border-top: 4px solid #38bdf8; /* sky-500 */
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
<body class="bg-slate-900 text-gray-300 p-4 lg:p-8">

<div class="w-full max-w-7xl mx-auto">
    <!-- Header -->
    <header class="text-center mb-8">
        <div class="flex items-center justify-center gap-3 mb-2">
            <!-- AI-style icon -->
            <svg class="w-10 h-10 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L1.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.25 12l2.846.813a4.5 4.5 0 013.09 3.09L24.99 18.75l-.813-2.846a4.5 4.5 0 01-3.09-3.09L18.25 12zM18.25 12l-2.846-.813a4.5 4.5 0 01-3.09-3.09L11.51 5.25l.813 2.846a4.5 4.5 0 013.09 3.09L18.25 12z" />
            </svg>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-100">Prothesys <span class="text-sky-400">AI</span></h1>
        </div>
        <p class="text-gray-400 text-lg">AI-Powered Stump Pain & Prosthesis Prognosis</p>
    </header>

    <!-- Main Content Area: Split View -->
    <div class="flex flex-col lg:flex-row gap-6">

        <!-- Left Panel: Patient Data Inputs -->
        <div class="lg:w-1/2 w-full h-full">
            <form id="prognosis-form" class="space-y-6">

                <h2 class="text-2xl font-semibold text-gray-100 border-b border-slate-700 pb-2">Patient Data</h2>

                <!-- Module 1: Core Metrics -->
                <div class="bg-slate-800 p-5 rounded-lg border border-slate-700 space-y-6">
                    <h3 class="text-lg font-semibold text-sky-400">1. Core Metrics</h3>

                    <div>
                        <label for="days_since_amputation" class="flex justify-between text-sm font-medium text-gray-300 mb-2">
                            <span>Time Since Amputation (days)</span>
                            <span id="days_value" class="font-bold text-sky-400">30</span>
                        </label>
                        <input type="range" id="days_since_amputation" min="0" max="1000" value="30" class="w-full rounded-lg appearance-none cursor-pointer">
                    </div>

                    <div>
                        <label for="local_pain" class="flex justify-between text-sm font-medium text-gray-300 mb-2">
                            <span>Stump Pain Intensity (0-10)</span>
                            <span id="pain_intensity_value" class="font-bold text-sky-400">4</span>
                        </label>
                        <input type="range" id="local_pain" min="0" max="10" value="4" class="w-full rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Pain Drawing Area -->
                    <div class="space-y-3 text-center">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            Pain Drawing Area: <span id="pain_area_value" class="font-bold text-sky-400">0</span> %
                        </label>
                        <div id="canvas-container">
                            <!-- Placeholder image to represent the stump/leg silhouette -->
                            <img id="bg-image" src="img/protesys.jpg" alt="Body silhouette for pain drawing"
                                 onerror="this.src='https://placehold.co/300x500/1e293b/334155?text=Image+Load+Error';">
                            <canvas id="pain-canvas"></canvas>
                        </div>
                        <button type="button" id="clear-canvas-btn" class="text-sm bg-slate-700 hover:bg-slate-600 text-sky-300 font-semibold py-2 px-4 rounded-lg transition-colors">
                            Clear Drawing
                        </button>
                    </div>
                </div>

                <!-- Module 2: Medical History -->
                <div class="bg-slate-800 p-5 rounded-lg border border-slate-700 space-y-6">
                    <h3 class="text-lg font-semibold text-sky-400">2. Medical History</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="type_amputation" class="block text-sm font-medium text-gray-300 mb-2">Amputation Type</label>
                            <select id="type_amputation" class="w-full bg-slate-700 border border-slate-600 text-white text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5">
                                <option>Traumatic</option>
                                <option>Planned</option>
                            </select>
                        </div>
                        <div>
                            <label for="healing_status" class="block text-sm font-medium text-gray-300 mb-2">General Healing Status</label>
                            <select id="healing_status" class="w-full bg-slate-700 border border-slate-600 text-white text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5">
                                <option value="Primary intention">Primary intention</option>
                                <option value="Secondary intention">Secondary intention</option>
                                <option value="Complicated">Complicated</option>
                                <option value="Chronic wound">Chronic wound</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-300 mb-2">🧠 Phantom Phenomena</span>
                        <div class="flex gap-6">
                            <div>
                                <span class="block text-sm font-medium text-gray-400 mb-1">Phantom Pain</span>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 text-sm"><input type="radio" name="phantom_pain" value="Yes" class="form-radio">Yes</label>
                                    <label class="flex items-center gap-2 text-sm"><input type="radio" name="phantom_pain" value="No" checked class="form-radio">No</label>
                                </div>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-400 mb-1">Phantom Sensation</span>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2 text-sm"><input type="radio" name="phantom_sensation" value="Yes" class="form-radio">Yes</label>
                                    <label class="flex items-center gap-2 text-sm"><input type="radio" name="phantom_sensation" value="No" checked class="form-radio">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Module 3: Clinical Factors -->
                <div class="bg-slate-800 p-5 rounded-lg border border-slate-700 space-y-6">
                    <h3 class="text-lg font-semibold text-sky-400">3. Clinical Factors</h3>

                    <!-- Inspection -->
                    <div class="space-y-4">
                        <h4 class="text-md font-semibold text-gray-200">Inspection</h4>
                        <div class="space-y-2">
                            <span class="block text-sm font-medium text-gray-300">Skin Condition</span>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="skin_condition" value="Edema" class="form-checkbox">Edema</label>
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="skin_condition" value="Hyperemia" class="form-checkbox">Hyperemia</label>
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="skin_condition" value="Scars" class="form-checkbox">Scars</label>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <span class="block text-sm font-medium text-gray-300">Deformations</span>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="deformations" value="Bone prominences" class="form-checkbox">Bone prominences</label>
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="deformations" value="Contractures" class="form-checkbox">Contractures</label>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <span class="block text-sm font-medium text-gray-300">Prosthesis Usage</span>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 text-sm"><input type="radio" name="prosthesis_usage" value="Regular" class="form-radio">Regular</label>
                                <label class="flex items-center gap-2 text-sm"><input type="radio" name="prosthesis_usage" value="Sometimes" class="form-radio">Sometimes</label>
                                <label class="flex items-center gap-2 text-sm"><input type="radio" name="prosthesis_usage" value="None" checked class="form-radio">None</label>
                            </div>
                        </div>
                    </div>

                    <!-- Palpation -->
                    <div class="space-y-4 border-t border-slate-700 pt-4">
                        <h4 class="text-md font-semibold text-gray-200">Palpation</h4>
                        <div class="space-y-2">
                            <span class="block text-sm font-medium text-gray-300">Soft Tissues</span>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="soft_tissue" value="Tenderness" class="form-checkbox">Tenderness</label>
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="soft_tissue" value="Induration" class="form-checkbox">Induration</label>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <input type="checkbox" name="bone_tenderness" value="Yes" class="form-checkbox">
                            Bone structures: tenderness of bone edges
                        </label>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <input type="checkbox" name="neuroma_pain" value="Yes" class="form-checkbox">
                            🔎 Neuroma search: pinpoint pain
                        </label>
                    </div>

                    <!-- Sensory Tests -->
                    <div class="space-y-4 border-t border-slate-700 pt-4">
                        <h4 class="text-md font-semibold text-gray-200">Sensory Tests</h4>
                        <div class="space-y-2">
                            <span class="block text-sm font-medium text-gray-300">Tactile Hypersensitivity</span>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="tactile_hypersensitivity" value="Hyperalgesia" class="form-checkbox">Hyperalgesia</label>
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="tactile_hypersensitivity" value="Allodynia" class="form-checkbox">Allodynia</label>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <input type="checkbox" name="temperature_sensitivity" value="Yes" class="form-checkbox">
                            Temperature sensitivity
                        </label>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <input type="checkbox" name="trigger_point" value="Yes" class="form-checkbox">
                            Trigger point detection
                        </label>
                    </div>

                    <!-- Dynamic Tests -->
                    <div class="space-y-4 border-t border-slate-700 pt-4">
                        <h4 class="text-md font-semibold text-gray-200">Dynamic Tests</h4>
                        <div class="space-y-2">
                            <span class="block text-sm font-medium text-gray-300">Pain during prosthetics</span>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="prosthesis_pain" value="Static" class="form-checkbox">Static</label>
                                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="prosthesis_pain" value="Dynamic" class="form-checkbox">Dynamic</label>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-300">
                            <input type="checkbox" name="movement_pain" value="Yes" class="form-checkbox">
                            Hip/knee movements — change in pain
                        </label>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="sticky bottom-0 bg-slate-900 py-4">
                    <button type="button" id="analyze-btn" class="w-full text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:ring-sky-800 font-medium rounded-lg text-lg px-5 py-3 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L1.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.25 12l2.846.813a4.5 4.5 0 013.09 3.09L24.99 18.75l-.813-2.846a4.5 4.5 0 01-3.09-3.09L18.25 12zM18.25 12l-2.846-.813a4.5 4.5 0 01-3.09-3.09L11.51 5.25l.813 2.846a4.5 4.5 0 013.09 3.09L18.25 12z" />
                        </svg>
                        Analyze Prognosis
                    </button>
                </div>

            </form>
        </div>

        <!-- Right Panel: AI Prognosis Output -->
        <div class="lg:w-1/2 w-full lg:sticky top-8" style="align-self: flex-start;">
            <div id="results-panel" class="h-full min-h-[600px]">
                <div class="p-4 border-b border-slate-700">
                    <h2 class="text-2xl font-semibold text-gray-100">AI Prognosis</h2>
                </div>

                <div id="results-content" class="p-6">
                    <!-- Initial State -->
                    <div id="results-initial" class="text-center text-gray-400 mt-20">
                        <svg class="w-16 h-16 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688 0-1.25-.563-1.25-1.25s.563-1.25 1.25-1.25c.688 0 1.25.563 1.25 1.25s-.563 1.25-1.25 1.25zm0 0c-.688 0-1.25-.563-1.25-1.25s.563-1.25 1.25-1.25c.688 0 1.25.563 1.25 1.25s-.563 1.25-1.25 1.25zm0 0c-.688 0-1.25-.563-1.25-1.25s.563-1.25 1.25-1.25c.688 0 1.25.563 1.25 1.25s-.563 1.25-1.25 1.25z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25c0 .621-.504 1.125-1.125 1.125-.621 0-1.125-.504-1.125-1.125s.504-1.125 1.125-1.125c.621 0 1.125.504 1.125 1.125zM19.5 14.25c0 .621-.504 1.125-1.125 1.125-.621 0-1.125-.504-1.125-1.125s.504-1.125 1.125-1.125c.621 0 1.125.504 1.125 1.125zM19.5 14.25c0 .621-.504 1.125-1.125 1.125-.621 0-1.125-.504-1.125-1.125s.504-1.125 1.125-1.125c.621 0 1.125.504 1.125 1.125z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.66 14.25c0 .621-.504 1.125-1.125 1.125-.621 0-1.125-.504-1.125-1.125s.504-1.125 1.125-1.125c.621 0 1.125.504 1.125 1.125z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.66 14.25c0 .621-.504 1.125-1.125 1.125-.621 0-1.125-.504-1.125-1.125s.504-1.125 1.125-1.125c.621 0 1.125.504 1.125 1.125z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.66 14.25c0 .621-.504 1.125-1.125 1.125-.621 0-1.125-.504-1.125-1.125s.504-1.125 1.125-1.125c.621 0 1.125.504 1.125 1.125z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.34 15.75c-.688 0-1.25-.563-1.25-1.25s.563-1.25 1.25-1.25c.688 0 1.25.563 1.25 1.25s-.563 1.25-1.25 1.25z" />
                        </svg>
                        <p class="text-lg font-medium">Results will appear here</p>
                        <p class="text-sm">Complete the patient data and click "Analyze Prognosis" to generate an AI report.</p>
                    </div>

                    <!-- Loading State -->
                    <div id="results-loading" class="text-center text-gray-400 mt-20 hidden">
                        <div class="spinner mx-auto mb-4"></div>
                        <p class="text-lg font-medium text-sky-400 animate-pulse">AI is analyzing patient data...</p>
                        <p class="text-sm">Please wait a moment.</p>
                    </div>

                    <!-- Results State -->
                    <div id="results-output" class="hidden space-y-6">
                        <!-- NEW STRUCTURE -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                                <h4 class="text-md font-semibold text-gray-100 mb-3 text-center">Pain Prognosis</h4>
                                <div class="relative w-full max-w-[250px] mx-auto">
                                    <canvas id="riskScoreChart"></canvas>
                                    <div id="riskScoreText" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                        <!-- JS will populate this -->
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-900 p-4 rounded-lg border border-slate-700 space-y-3">
                                <h4 class="text-md font-semibold text-gray-100 mb-2">Prosthesis Readiness</h4>
                                <div id="prosthesis-readiness-output">
                                    <!-- JS will populate this -->
                                </div>
                                <h4 class="text-md font-semibold text-gray-100 pt-3 border-t border-slate-700 mt-3">Key Metrics</h4>
                                <div id="key-metrics-output" class="space-y-2 text-sm">
                                    <!-- JS will populate this -->
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                            <h4 class="text-md font-semibold text-gray-100 mb-3">Key Risk Factors</h4>
                            <div class="w-full min-h-[150px] max-h-[300px] relative">
                                <canvas id="factorsChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-slate-900 p-4 rounded-lg border border-slate-700 space-y-3">
                            <h4 class="text-md font-semibold text-gray-100">AI Recommendations</h4>
                            <div id="recommendations-output">
                                <!-- JS will populate this -->
                            </div>
                        </div>
                        <!-- END NEW STRUCTURE -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- DOM Element References ---
        const form = document.getElementById('prognosis-form');
        const resultsInitial = document.getElementById('results-initial');
        const resultsLoading = document.getElementById('results-loading');
        const resultsOutput = document.getElementById('results-output');
        const analyzeBtn = document.getElementById('analyze-btn');

        const daysSlider = document.getElementById('days_since_amputation');
        const daysValue = document.getElementById('days_value');
        const painIntensitySlider = document.getElementById('local_pain');
        const painIntensityValue = document.getElementById('pain_intensity_value');

        // --- Canvas Drawing Functionality ---
        const canvas = document.getElementById('pain-canvas');
        const ctx = canvas.getContext('2d');
        const bgImage = document.getElementById('bg-image');
        const clearBtn = document.getElementById('clear-canvas-btn');
        const painAreaValue = document.getElementById('pain_area_value');

        let isDrawing = false;
        let painAreaPercentForCalculation = 0; // Scaled value for the model
        let silhouettePixelCount = 0; // To be calculated

        let riskChartInstance = null; // Chart.js instance for risk gauge
        let factorsChartInstance = null; // Chart.js instance for factors bar chart

        // Analyze the silhouette image (placeholder) to get a base for calculation
        // Since it's a solid block placeholder, we'll just use total pixels.
        function analyzeSilhouette() {
            if (!bgImage.complete || bgImage.naturalWidth === 0) {
                setTimeout(analyzeSilhouette, 100);
                return;
            }
            // For the placeholder, total drawable area is just its dimensions.
            // In a real app with a complex silhouette, you'd scan for non-transparent pixels.
            silhouettePixelCount = bgImage.naturalWidth * bgImage.naturalHeight;
            setCanvasSize();
        }

        // Set canvas size based on the background image's displayed size
        function setCanvasSize() {
            const rect = bgImage.getBoundingClientRect();
            if (rect.width > 0 && rect.height > 0) {
                canvas.width = rect.width;
                canvas.height = rect.height;
                ctx.lineJoin = 'round';
                ctx.lineCap = 'round';
                ctx.lineWidth = 20; // Thicker brush for easier drawing
                ctx.strokeStyle = 'rgba(239, 68, 68, 0.6)'; // Semi-transparent red-500
                ctx.globalCompositeOperation = 'source-over';
            }
        }

        bgImage.onload = analyzeSilhouette;
        if (bgImage.complete) {
            analyzeSilhouette();
        }
        window.addEventListener('resize', setCanvasSize);

        // Helper to get correct coordinates on canvas
        function getEventPosition(event) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;

            const clientX = (event.touches && event.touches[0]) ? event.touches[0].clientX : event.clientX;
            const clientY = (event.touches && event.touches[0]) ? event.touches[0].clientY : event.clientY;

            return {
                x: (clientX - rect.left) * scaleX,
                y: (clientY - rect.top) * scaleY
            };
        }

        function startDrawing(e) {
            isDrawing = true;
            const { x, y } = getEventPosition(e);
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        function draw(e) {
            if (!isDrawing) return;
            e.preventDefault();
            const { x, y } = getEventPosition(e);
            ctx.lineTo(x, y);
            ctx.stroke();
        }

        function stopDrawing() {
            if (!isDrawing) return;
            isDrawing = false;
            ctx.closePath();
            calculatePainArea();
            // In this new flow, drawing *automatically* triggers re-analysis
            runAnalysis();
        }

        function calculatePainArea() {
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;
            let drawnPixels = 0;
            for (let i = 0; i < data.length; i += 4) {
                if (data[i + 3] > 0) { // Check alpha channel
                    drawnPixels++;
                }
            }

            const totalCanvasPixels = canvas.width * canvas.height;
            let rawVisualPercentage = 0;
            if (totalCanvasPixels > 0) {
                rawVisualPercentage = (drawnPixels / totalCanvasPixels) * 100;
            }

            // This logic seems intended to scale a small drawing area to a larger %
            // Let's keep it but cap it at 100.
            const thresholdPercentage = 10;
            let displayPercentage = (rawVisualPercentage / thresholdPercentage) * 100;
            if (displayPercentage > 100) {
                displayPercentage = 100;
            }

            painAreaValue.textContent = Math.round(displayPercentage);
            // Scale the 0-100 display % to a 0-20 value for the model
            painAreaPercentForCalculation = displayPercentage * 0.2;
        }

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            calculatePainArea();
            runAnalysis(); // Also trigger re-analysis on clear
        }

        // Canvas Event Listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);
        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        window.addEventListener('touchend', stopDrawing);
        clearBtn.addEventListener('click', clearCanvas);

        // --- Main Analysis Logic ---

        // This is the new function that shows the loader
        function runAnalysis() {
            resultsInitial.classList.add('hidden');
            resultsOutput.classList.add('hidden');
            resultsLoading.classList.remove('hidden');

            // Destroy old charts before re-analysis
            if (riskChartInstance) {
                riskChartInstance.destroy();
                riskChartInstance = null;
            }
            if (factorsChartInstance) {
                // Need to clear the parent HTML in case we're replacing it with a 'no factors' message
                document.getElementById('factorsChart').parentElement.innerHTML = '<canvas id="factorsChart"></canvas>';
                factorsChartInstance.destroy();
                factorsChartInstance = null;
            }

            // Simulate AI processing time
            setTimeout(() => {
                // This function now handles all calculations AND rendering
                generatePrognosisReport();

                resultsLoading.classList.add('hidden');
                resultsOutput.classList.remove('hidden');
            }, 1500); // 1.5 second delay
        }

        // --- NEW CHART FUNCTIONS ---

        function createRiskScoreChart(score, maxScore, riskLevel, riskColorClass) {
            const chartEl = document.getElementById('riskScoreChart');
            if (!chartEl) return;
            const ctx = chartEl.getContext('2d');
            const remaining = maxScore - score;
            const riskColor = riskColorClass.includes('red') ? '#f87171' : (riskColorClass.includes('orange') ? '#fb923c' : '#34d399');

            const scoreTextEl = document.getElementById('riskScoreText');
            scoreTextEl.innerHTML = `
                <div class="text-4xl font-bold ${riskColorClass}">${score}</div>
                <div class="text-sm text-gray-400">of ${maxScore}</div>
                <div class="mt-1 text-lg font-semibold ${riskColorClass}">${riskLevel}</div>
            `;

            riskChartInstance = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Risk Score', 'Remaining'],
                    datasets: [{
                        data: [score, remaining > 0 ? remaining : 0.001], // Cannot have 0 in doughnut
                        backgroundColor: [riskColor, '#334155'], // slate-700
                        borderColor: ['#1e293b', '#1e293b'], // slate-800
                        borderWidth: 2,
                        cutout: '70%',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        }

        function createFactorsChart(factors) {
            const chartEl = document.getElementById('factorsChart');
            if (!chartEl) return;

            // Sort factors by score descending
            factors.sort((a, b) => b.score - a.score);

            const labels = factors.map(f => f.name);
            const data = factors.map(f => f.score);

            if (factors.length === 0) {
                document.getElementById('factorsChart').parentElement.innerHTML = '<p class="text-gray-400 text-sm text-center mt-8">No significant risk factors detected.</p>';
                return;
            }

            const ctx = chartEl.getContext('2d');
            factorsChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Factor Impact',
                        data: data,
                        backgroundColor: 'rgba(56, 189, 248, 0.6)', // sky-500 with alpha
                        borderColor: 'rgba(56, 189, 248, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Horizontal bar chart
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: '#334155' }, // slate-700
                            ticks: {
                                color: '#9ca3af', // gray-400
                                precision: 0
                            }
                        },
                        y: {
                            grid: { color: 'transparent' },
                            ticks: { color: '#9ca3af' } // gray-400
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a', // slate-900
                            titleColor: '#e2e8f0', // slate-200
                            bodyColor: '#e2e8f0', // slate-200
                        }
                    }
                }
            });
        }


        // This function does the actual calculation and builds the report
        // REBUILT FUNCTION
        function generatePrognosisReport() {
            // 1. Gather all data
            const daysSinceAmputation = parseInt(daysSlider.value);
            const healingStatus = document.getElementById('healing_status').value;
            const phantomPain = document.querySelector('input[name="phantom_pain"]:checked').value;
            const phantomSensation = document.querySelector('input[name="phantom_sensation"]:checked').value;
            const localPain = parseInt(painIntensitySlider.value);
            const skinConditions = Array.from(document.querySelectorAll('input[name="skin_condition"]:checked')).map(cb => cb.value);
            const deformations = Array.from(document.querySelectorAll('input[name="deformations"]:checked')).map(cb => cb.value);
            const prosthesisUsage = document.querySelector('input[name="prosthesis_usage"]:checked').value;
            const softTissueConditions = Array.from(document.querySelectorAll('input[name="soft_tissue"]:checked')).map(cb => cb.value);
            const boneTenderness = document.querySelector('input[name="bone_tenderness"]').checked;
            const neuromaPain = document.querySelector('input[name="neuroma_pain"]').checked;
            const tactileHypersensitivity = Array.from(document.querySelectorAll('input[name="tactile_hypersensitivity"]:checked')).map(cb => cb.value);
            const temperatureSensitivity = document.querySelector('input[name="temperature_sensitivity"]').checked;
            const triggerPoint = document.querySelector('input[name="trigger_point"]').checked;
            const prosthesisPain = Array.from(document.querySelectorAll('input[name="prosthesis_pain"]:checked')).map(cb => cb.value);
            const movementPain = document.querySelector('input[name="movement_pain"]').checked;

            // 2. --- Risk Score Calculation ---
            let riskScore = 0;
            const maxScore = 24;
            let keyFactors = []; // Now an array of objects: { name: '...', score: X }

            // Core Metrics
            if (localPain >= 6) {
                riskScore += 3;
                keyFactors.push({ name: `High Pain (${localPain}/10)`, score: 3 });
            } else if (localPain >= 4) {
                riskScore += 1;
                keyFactors.push({ name: `Moderate Pain (${localPain}/10)`, score: 1 });
            }

            if (painAreaPercentForCalculation >= 10) { // 50% of display
                riskScore += 3;
                keyFactors.push({ name: `Large Pain Area (${Math.round(painAreaPercentForCalculation * 5)}%)`, score: 3 });
            } else if (painAreaPercentForCalculation >= 4) { // 20% of display
                riskScore += 1;
                keyFactors.push({ name: `Medium Pain Area (${Math.round(painAreaPercentForCalculation * 5)}%)`, score: 1 });
            }

            // Medical History
            if (healingStatus === 'Complicated' || healingStatus === 'Chronic wound') {
                riskScore += 2;
                keyFactors.push({ name: `Complicated Healing`, score: 2 });
            }
            if (phantomPain === 'Yes') {
                riskScore += 2;
                keyFactors.push({ name: `Phantom Pain`, score: 2 });
            }
            if (phantomSensation === 'Yes') {
                riskScore += 1;
                keyFactors.push({ name: `Phantom Sensation`, score: 1 });
            }

            // Clinical Factors
            if (prosthesisUsage === 'None' && daysSinceAmputation > 60) {
                riskScore += 2;
                keyFactors.push({ name: `Delayed Use (>60 days)`, score: 2 });
            }
            if (skinConditions.includes('Edema')) {
                riskScore += 1;
                keyFactors.push({ name: `Edema`, score: 1 });
            }
            if (skinConditions.includes('Hyperemia')) {
                riskScore += 1;
                keyFactors.push({ name: `Hyperemia`, score: 1 });
            }
            if (skinConditions.includes('Scars')) {
                riskScore += 1;
                keyFactors.push({ name: `Scars`, score: 1 });
            }

            if (deformations.includes('Bone prominences')) {
                riskScore += 1;
                keyFactors.push({ name: `Bone Prominences`, score: 1 });
            }
            if (deformations.includes('Contractures')) {
                riskScore += 1;
                keyFactors.push({ name: `Contractures`, score: 1 });
            }
            if (softTissueConditions.includes('Tenderness')) {
                riskScore += 1;
                keyFactors.push({ name: `Soft Tissue Tenderness`, score: 1 });
            }
            if (softTissueConditions.includes('Induration')) {
                riskScore += 1;
                keyFactors.push({ name: `Induration`, score: 1 });
            }

            if (boneTenderness) {
                riskScore += 1;
                keyFactors.push({ name: `Bone Tenderness`, score: 1 });
            }
            if (neuromaPain) {
                riskScore += 3;
                keyFactors.push({ name: `Neuroma Pain`, score: 3 });
            }

            if (tactileHypersensitivity.includes('Hyperalgesia')) {
                riskScore += 1;
                keyFactors.push({ name: `Hyperalgesia`, score: 1 });
            }
            if (tactileHypersensitivity.includes('Allodynia')) {
                riskScore += 1;
                keyFactors.push({ name: `Allodynia`, score: 1 });
            }
            if (temperatureSensitivity) {
                riskScore += 1;
                keyFactors.push({ name: `Temp. Sensitivity`, score: 1 });
            }
            if (triggerPoint) {
                riskScore += 1;
                keyFactors.push({ name: `Trigger Points`, score: 1 });
            }

            if (prosthesisPain.includes('Static')) {
                riskScore += 1;
                keyFactors.push({ name: `Static Prosthesis Pain`, score: 1 });
            }
            if (prosthesisPain.includes('Dynamic')) {
                riskScore += 1;
                keyFactors.push({ name: `Dynamic Prosthesis Pain`, score: 1 });
            }
            if (movementPain) {
                riskScore += 1;
                keyFactors.push({ name: `Movement Pain`, score: 1 });
            }

            // Ensure score doesn't exceed max
            if (riskScore > maxScore) {
                riskScore = maxScore;
            }

            // 3. --- Interpret Results ---
            let riskLevel, riskColor, riskIcon;
            if (riskScore >= 12) {
                riskLevel = "High Risk";
                riskColor = "text-red-400";
                riskIcon = "🔴";
            } else if (riskScore >= 6) {
                riskLevel = "Moderate Risk";
                riskColor = "text-orange-400";
                riskIcon = "🟠";
            } else {
                riskLevel = "Low Risk";
                riskColor = "text-green-400";
                riskIcon = "🟢";
            }

            let prosthesisPrognosis, prosthesisColor, prosthesisIcon;
            let recommendations = [];

            // Prosthesis Readiness
            const readinessEl = document.getElementById('prosthesis-readiness-output');
            if (prosthesisUsage === "Regular") {
                prosthesisPrognosis = "In Regular Use";
                prosthesisColor = "text-green-400";
                prosthesisIcon = "✅";
                recommendations.push("Continue monitoring prosthesis fit and comfort.");
                if (riskScore >= 6) {
                    recommendations.push("Address new pain points to maintain regular use.");
                }
            } else if (daysSinceAmputation < 60 && healingStatus === "Primary intention" && riskScore < 6) {
                prosthesisPrognosis = "Ready for Fitting";
                prosthesisColor = "text-sky-400";
                prosthesisIcon = "🕒";
                recommendations.push("Prosthesis fitting possible in the next 2-4 weeks.");
                recommendations.push("Begin pre-prosthetic conditioning.");
            } else {
                prosthesisPrognosis = "Fitting Postponed / Prep Needed";
                prosthesisColor = "text-yellow-400";
                prosthesisIcon = "⚠️";
                if (riskScore >= 6) {
                    recommendations.push("Focus on pain management and desensitization before fitting.");
                }
                if (healingStatus !== "Primary intention") {
                    recommendations.push("Prioritize wound healing and edema control.");
                }
                if (deformations.includes("Contractures")) {
                    recommendations.push("Address contractures with physical therapy.");
                }
            }
            readinessEl.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="text-3xl">${prosthesisIcon}</span>
                    <div>
                        <div class="text-lg font-bold ${prosthesisColor}">${prosthesisPrognosis}</div>
                    </div>
                </div>
            `;

            // Key Metrics
            const metricsEl = document.getElementById('key-metrics-output');
            metricsEl.innerHTML = `
                <div class="flex justify-between"><span>Pain:</span> <span class="font-medium ${localPain >= 6 ? 'text-red-400' : (localPain >= 4 ? 'text-orange-400' : 'text-green-400')}">${localPain}/10</span></div>
                <div class="flex justify-between"><span>Healing:</span> <span class="font-medium ${healingStatus.includes('Complicated') || healingStatus.includes('Chronic') ? 'text-red-400' : 'text-green-400'}">${healingStatus}</span></div>
                <div class="flex justify-between"><span>Days Since Amp.:</span> <span class="font-medium text-gray-300">${daysSinceAmputation}</span></div>
            `;

            // Add key factor recommendations
            if (keyFactors.find(f => f.name.includes("Neuroma"))) {
                recommendations.push("Strongly consider neuroma-specific diagnostic and treatment plan.");
            }
            if (keyFactors.find(f => f.name.includes("Hyperalgesia") || f.name.includes("Allodynia"))) {
                recommendations.push("Implement desensitization program (e.g., tapping, massage).");
            }

            // 4. --- Render Report ---

            // Render Charts
            createRiskScoreChart(riskScore, maxScore, riskLevel, riskColor);
            createFactorsChart(keyFactors);

            // Render Recommendations
            const recommendationsEl = document.getElementById('recommendations-output');
            recommendationsEl.innerHTML = `
                ${recommendations.length > 0
                ? `<ul class="list-decimal list-inside text-gray-300 space-y-2">` + recommendations.map(rec => `<li>${rec}</li>`).join('') + `</ul>`
                : `<p class="text-gray-400 text-sm">Standard follow-up recommended.</p>`
            }
            `;
        }

        // --- Other Event Listeners ---
        // Update slider values live
        daysSlider.addEventListener('input', (e) => {
            daysValue.textContent = e.target.value;
        });
        painIntensitySlider.addEventListener('input', (e) => {
            painIntensityValue.textContent = e.target.value;
        });

        // Main button to trigger analysis
        analyzeBtn.addEventListener('click', runAnalysis);

        // Initial "cold start" - don't run analysis until user clicks
        // (The canvas events will trigger the first run if used)
    });
</script>
</body>
</html>
