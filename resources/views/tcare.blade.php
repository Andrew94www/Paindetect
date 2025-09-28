<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Calculator - Chronic Pain Risk Assessment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom CSS for the interactive pain zones */
        .pain-zone {
            fill: rgba(0, 82, 178, 0.05); /* Slightly visible light blue fill when inactive */
            stroke: rgba(0, 82, 178, 0.3); /* Slightly visible light blue border */
            stroke-width: 1px;
            cursor: pointer;
            transition: fill 0.2s ease-in-out, stroke 0.2s ease-in-out;
            pointer-events: all;
        }

        /* HOVER EFFECT: Clearly show the user where they are pointing */
        .pain-zone:hover {
            fill: rgba(0, 82, 178, 0.15); /* More visible blue on hover */
            stroke: rgba(0, 82, 178, 0.7);
        }

        /* SELECTED ZONE STYLE: Clearly highlighted */
        .pain-zone.selected {
            fill: rgba(220, 38, 38, 0.4); /* Highlight with a distinct color (Red/Pain) */
            stroke: #dc2626; /* Solid red border */
            stroke-width: 2px;
        }

        .view-toggle-btn {
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }
        .view-toggle-btn.active {
            background-color: #0052B2;
            color: white;
            border-color: #0052B2;
        }
        .view-toggle-btn.inactive {
            background-color: #E0E0E0;
            color: #333;
            border-color: #E0E0E0;
        }
        /* Styling for segment labels overlaying the map */
        .segment-label {
            pointer-events: none; /* Ignore clicks on labels */
            font-weight: 700;
            font-size: 14px;
            text-anchor: middle;
            fill: #1f2937; /* Dark text for contrast */
            /* Add outline for visibility against various fills */
            stroke: white;
            stroke-width: 0.5px;
            paint-order: stroke;
        }
        .special-label {
            font-size: 12px;
            font-weight: 500;
            fill: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="container mx-auto p-4 md:p-8">
    <!-- Header -->
    <header class="text-center mb-8">
        <div class="flex justify-center items-center gap-4">
            <!-- Icon/Logo -->
            <svg class="w-16 h-16 text-blue-600" viewBox="0 0 64 64" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.8,4.8C18.4,4.8,13,10.1,13,16.5v1.6c0,2.3,1.9,4.2,4.2,4.2s4.2-1.9,4.2-4.2v-1.6c0-1.8,1.5-3.3,3.3-3.3s3.3,1.5,3.3,3.3v1.6c0,2.3,1.9,4.2,4.2,4.2s4.2-1.9,4.2-4.2v-1.6C40.5,10.1,35.1,4.8,28.7,4.8H24.8z M14.6,25.5c-2.3,0-4.2,1.9-4.2,4.2v19.8c0,2.3,1.9,4.2,4.2,4.2h1.6c2.3,0,4.2-1.9,4.2-4.2V29.7c0-2.3-1.9-4.2-4.2-4.2H14.6z M24.8,25.5c-2.3,0-4.2,1.9-4.2,4.2v19.8c0,2.3,1.9,4.2,4.2,4.2h1.6c2.3,0,4.2-1.9,4.2-4.2V29.7c0-2.3-1.9-4.2-4.2-4.2H24.8z M34.9,25.5c-2.3,0-4.2,1.9-4.2,4.2v19.8c0,2.3,1.9,4.2,4.2,4.2h1.6c2.3,0,4.2-1.9,4.2-4.2V29.7c0-2.3-1.9-4.2-4.2-4.2H34.9z"/>
                <path class="text-yellow-400" d="M45.5,16.1c-5.5,0-10,4.5-10,10s4.5,10,10,10s10-4.5,10-10S51,16.1,45.5,16.1z M49.7,30.3c-0.8,0.8-2.1,0.8-2.8,0c-0.8-0.8-0.8-2.1,0-2.8c0.8-0.8,2.1-0.8,2.8,0C50.5,28.2,50.5,29.5,49.7,30.3z M41.3,30.3c-0.8,0.8-2.1,0.8-2.8,0c-0.8-0.8-0.8-2.1,0-2.8c0.8-0.8,2.1-0.8,2.8,0C42.1,28.2,42.1,29.5,41.3,30.3z M49.5,37.5c-1.5,1.5-3.5,2.3-5.5,2.3s-4-0.8-5.5-2.3c-0.4-0.4-0.4-1,0-1.4c0.4-0.4,1-0.4,1.4,0c1.2,1.2,2.8,1.8,4.1,1.8s2.9-0.6,4.1-1.8c0.4-0.4,1-0.4,1.4,0C49.9,36.5,49.9,37.1,49.5,37.5z"/>
            </svg>
            <div>
                <h1 class="text-4xl font-bold text-blue-700">E-Calculator</h1>
                <p class="text-lg text-gray-600">Thoracic – Chronification Pain Assessment and Recovery E-Calculator</p>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Left Column: Inputs and Results -->
        <div class="space-y-6">
            <!-- Patient Profile -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold mb-4 border-b pb-2 text-blue-700">1. Patient Profile and Clinical Risk Assessment</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input id="age" type="number" placeholder="Age" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <select id="sex" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                    <input id="weight" type="number" placeholder="Weight (kg)" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input id="height" type="number" placeholder="Height (cm)" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <div class="bg-gray-100 p-2 rounded-md text-center">
                        <span class="text-sm font-medium text-gray-600">BMI:</span>
                        <span id="bmi-display" class="font-bold text-gray-800">-</span>
                    </div>
                    <input id="pain_score_72h" type="number" placeholder="72h Pain Score (NRS 0-10)" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input id="pcs" type="number" placeholder="Pain Catastrophizing Scale (PCS)" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input id="opioid_days" type="number" placeholder="Opioid Use Days" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input id="icu_days" type="number" placeholder="ICU Days" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input id="gcs" type="number" placeholder="Glasgow Coma Scale (GCS)" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input id="spo2" type="number" placeholder="Oxygen Saturation O₂ (%)" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <div class="flex items-center space-x-2">
                        <input id="anticoagulants" type="checkbox" class="h-5 w-5 rounded text-blue-600 focus:ring-blue-500">
                        <label for="anticoagulants" class="text-sm md:text-base">On Anticoagulants</label>
                    </div>
                </div>
            </div>

            <!-- CT Imaging Interpreter -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold mb-4 border-b pb-2 text-blue-700">2. Chest CT Interpretation</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input id="rib_fractures" type="number" placeholder="Number of Rib Fractures" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input id="deformity_index" type="number" placeholder="Deformity Index (0-3)" class="p-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <div class="flex items-center space-x-2"><input id="bilateral" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500"><label for="bilateral" class="text-sm md:text-base">Bilateral Involvement</label></div>
                    <div class="flex items-center space-x-2"><input id="sternal_fracture" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500"><label for="sternal_fracture" class="text-sm md:text-base">Sternal Fracture</label></div>
                    <div class="flex items-center space-x-2"><input id="spine_fracture" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500"><label for="spine_fracture" class="text-sm md:text-base">Spine Fracture</label></div>
                    <div class="flex items-center space-x-2"><input id="hemothorax" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500"><label for="hemothorax" class="text-sm md:text-base">Hemothorax</label></div>
                    <div class="flex items-center space-x-2"><input id="pneumothorax" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500"><label for="pneumothorax" class="text-sm md:text-base">Pneumothorax</label></div>
                    <div class="flex items-center space-x-2"><input id="nerve_contact" type="checkbox" class="h-5 w-5 text-blue-600 focus:ring-blue-500"><label for="nerve_contact" class="text-sm md:text-base">Nerve Contact</label></div>
                </div>
            </div>

            <!-- Calculation Button and Results -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <button id="calculate-btn" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 text-xl shadow-lg hover:shadow-xl">
                    Calculate Chronification Risk
                </button>
                <div id="results" class="mt-6 space-y-4 hidden border-t pt-4">
                    <h3 class="text-2xl font-bold text-center text-blue-800">Assessment Results</h3>
                    <!-- STUMBL Score -->
                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                        <p class="text-lg font-semibold flex justify-between items-center">
                            <span>STUMBL Score:</span>
                            <span id="stumbl-score" class="font-extrabold text-blue-700 text-2xl"></span>
                        </p>
                    </div>
                    <!-- Clinical Risk Flags -->
                    <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                        <p class="text-lg font-semibold">Clinical Risk Flags:</p>
                        <ul id="risk-flags" class="list-disc list-inside text-yellow-800 mt-2 ml-4 space-y-1"></ul>
                    </div>
                    <!-- Imaging Risk Score -->
                    <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                        <p class="text-lg font-semibold flex justify-between items-center">
                            <span>Imaging Risk Score:</span>
                            <span id="imaging-score" class="font-extrabold text-green-700 text-2xl"></span>
                        </p>
                    </div>
                    <!-- Final Chronification Risk -->
                    <div id="final-risk-container" class="p-6 rounded-lg text-center text-white shadow-xl">
                        <p class="text-lg font-semibold">Predicted Chronification Risk:</p>
                        <p id="final-risk" class="font-bold text-4xl mt-1"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Pain Map -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">4. ThoracoMap: Interactive Pain Map</h2>
            <div class="flex justify-center mb-4">
                <div class="inline-flex rounded-lg overflow-hidden shadow-lg">
                    <button id="view-anterior-btn" class="view-toggle-btn active px-6 py-2 text-sm font-medium border-none">Anterior View</button>
                    <button id="view-posterior-btn" class="view-toggle-btn inactive px-6 py-2 text-sm font-medium border-none">Posterior View</button>
                </div>
            </div>

            <!-- Map Container: Set position relative for absolute children (image and svg overlay) -->
            <!-- Note: Fixed width and height are set here to match the 400x650 SVG viewBox -->
            <div id="pain-map-container" class="w-full max-w-sm mx-auto relative border border-gray-300 rounded-xl overflow-hidden p-0" style="height: 650px; width: 400px;">

                <!-- Background Image Element (The actual anatomical diagram) -->
                <!-- Set the initial image source to the user's file path -->
                <img id="anatomical-image" class="absolute inset-0 w-full h-full object-contain pointer-events-none"
                     src="img/anterior.jpg"
                     alt="Anatomical Torso Diagram" />

                <!-- SVG Container for interactivity (overlay) -->
                <div class="absolute inset-0">

                    <!-- Anterior View -->
                    <svg id="anterior-view" class="w-full h-full" viewBox="0 0 400 650">

                        <!-- INTERACTIVE PAIN ZONES (Coordinates adjusted for better coverage) -->

                        <!-- Zone C (Central, Sternum area) - Wider and longer central column -->
                        <rect id="C-all" data-zone-id="C" class="pain-zone" x="160" y="100" width="80" height="280" />
                        <text x="200" y="240" class="segment-label">C</text>

                        <!-- Zone A3 (Upper Left Lateral) - Wider coverage -->
                        <rect id="A3-top" data-zone-id="A3" class="pain-zone" x="80" y="100" width="80" height="140" />
                        <text x="120" y="170" class="segment-label">A3</text>

                        <!-- Zone B3 (Upper Right Lateral) - Wider coverage -->
                        <rect id="B3-top" data-zone-id="B3" class="pain-zone" x="240" y="100" width="80" height="140" />
                        <text x="280" y="170" class="segment-label">B3</text>

                        <!-- Zone A2 (Lower Left Lateral) - Wider coverage -->
                        <rect id="A2-mid" data-zone-id="A2" class="pain-zone" x="80" y="240" width="80" height="140" />
                        <text x="120" y="310" class="segment-label">A2</text>

                        <!-- Zone B2 (Lower Right Lateral - Corrected from B3 to B2 for a more logical bilateral segmentation) -->
                        <rect id="B2-mid" data-zone-id="B2" class="pain-zone" x="240" y="240" width="80" height="140" />
                        <text x="280" y="310" class="segment-label">B2</text>

                        <!-- Zone D (Epigastric/Lower Thoracic) - Spanning full lower width -->
                        <rect id="D-all" data-zone-id="D" class="pain-zone" x="80" y="380" width="240" height="70" />
                        <text x="200" y="415" class="segment-label">D</text>

                        <!-- Label for Anterior View -->
                        <text x="200" y="640" class="special-label">Anterior View</text>

                    </svg>

                    <!-- Posterior View -->
                    <svg id="posterior-view" class="w-full h-full hidden" viewBox="0 0 400 650">

                        <!-- INTERACTIVE PAIN ZONES (Coordinates adjusted for better coverage) -->

                        <!-- E1/E2 (Lateral) - Wider coverage -->
                        <rect id="E1-left" data-zone-id="E1" class="pain-zone" x="80" y="100" width="50" height="300" />
                        <text x="105" y="250" class="segment-label">E1</text>
                        <rect id="E2-right" data-zone-id="E2" class="pain-zone" x="270" y="100" width="50" height="300" />
                        <text x="295" y="250" class="segment-label">E2</text>

                        <!-- F1/F2 (Paraspinal) - Wider coverage -->
                        <rect id="F1-left" data-zone-id="F1" class="pain-zone" x="130" y="100" width="40" height="300" />
                        <text x="150" y="250" class="segment-label">F1</text>
                        <rect id="F2-right" data-zone-id="F2" class="pain-zone" x="230" y="100" width="40" height="300" />
                        <text x="250" y="250" class="segment-label">F2</text>

                        <!-- G (Spine) - Wider spine coverage -->
                        <rect id="G-spine" data-zone-id="G" class="pain-zone" x="170" y="100" width="60" height="300" />
                        <text x="200" y="250" class="segment-label">G</text>


                        <!-- H (Lower Thoracic/Lumbar) - Wider coverage -->
                        <rect id="H-all" data-zone-id="H" class="pain-zone" x="80" y="400" width="240" height="150" />
                        <text x="200" y="475" class="segment-label">H</text>
                        <text x="200" y="580" class="special-label">Lower thoracic/lumbar back</text>

                        <!-- Label for Posterior View -->
                        <text x="200" y="640" class="special-label">Posterior View</text>
                    </svg>
                </div>
            </div>

            <div class="mt-4 bg-gray-100 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-700">Selected Pain Zones (Click on the diagram):</h3>
                <p id="selected-zones-list" class="text-gray-700 mt-2 font-medium">No Zones Selected</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Image URLs (Using the user-provided local file) ---
        // NOTE: If you don't have these images in your directory, the map will still function, but the background image won't load.
        const ANTERIOR_IMAGE_URL = "img/anterior.jpg";
        const POSTERIOR_IMAGE_URL = "img/posterior.jpg";

        // --- DOM Element References ---
        const calculateBtn = document.getElementById('calculate-btn');
        const resultsDiv = document.getElementById('results');
        const stumblScoreEl = document.getElementById('stumbl-score');
        const riskFlagsEl = document.getElementById('risk-flags');
        const imagingScoreEl = document.getElementById('imaging-score');
        const finalRiskContainer = document.getElementById('final-risk-container');
        const finalRiskEl = document.getElementById('final-risk');

        // BMI Elements
        const weightInput = document.getElementById('weight');
        const heightInput = document.getElementById('height');
        const bmiDisplay = document.getElementById('bmi-display');

        // Pain Map Elements
        const viewAnteriorBtn = document.getElementById('view-anterior-btn');
        const viewPosteriorBtn = document.getElementById('view-posterior-btn');
        const anteriorView = document.getElementById('anterior-view');
        const posteriorView = document.getElementById('posterior-view');
        const anatomicalImageEl = document.getElementById('anatomical-image');
        // Select all pain zones across both SVGs
        const painZones = document.querySelectorAll('.pain-zone');
        const selectedZonesList = document.getElementById('selected-zones-list');

        let selectedPainZones = new Set();
        let calculatedBmi = 0;

        // --- Calculation Logic ---
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

        // Module 1: Patient Profile & Clinical Risk Profiler (Example logic)
        function calculateStumblScore(inputs) {
            let score = 0;
            // Scoring based on general clinical risk indicators (hypothetical model)
            if (inputs.age >= 65) score += 2;
            if (inputs.rib_fractures >= 3) score += 5;
            if (inputs.anticoagulants) score += 3;
            if (inputs.spo2 < 95) score += 2;
            if (inputs.gcs < 15) score += 2;
            return score;
        }

        function getClinicalRiskFlags(inputs) {
            const flags = [];
            // Psychosocial and early management risk factors
            if (inputs.pcs > 30) flags.push("High Pain Catastrophizing (PCS > 30)");
            if (inputs.opioid_days > 7) flags.push("Prolonged Opioid Use (> 7 days)");
            if (inputs.icu_days > 3) flags.push("Prolonged ICU Stay (> 3 days)");
            if (inputs.pain_score_72h >= 6) flags.push("Severe Early Pain (NRS ≥ 6)");
            return flags;
        }

        // Module 2: Thoracic CT Imaging Interpreter (Example logic)
        function calculateImagingRiskScore(inputs) {
            let score = 0;
            // Scoring based on severity of injury
            score += (inputs.rib_fractures || 0) * 0.5;
            if (inputs.bilateral) score += 2;
            if (inputs.sternal_fracture) score += 1.5;
            if (inputs.spine_fracture) score += 2;
            if (inputs.hemothorax) score += 1;
            if (inputs.pneumothorax) score += 1;
            if (inputs.nerve_contact) score += 1.5;
            score += inputs.deformity_index || 0;
            return Math.min(score, 10).toFixed(1); // Cap at 10 and format
        }

        // Module 3: Chronification Risk Estimator (Example logic)
        function predictChronificationRisk(stumblScore, imagingScore, inputs) {
            let totalScore = 0;
            // Weighting clinical and imaging factors
            totalScore += stumblScore * 0.6;
            totalScore += imagingScore * 0.8;
            if (inputs.pcs > 30) totalScore += 2;
            if (inputs.opioid_days > 7) totalScore += 1.5;
            if (inputs.icu_days > 3) totalScore += 1.5;

            // Risk thresholds (hypothetical)
            if (totalScore < 6) return { level: "Low Risk", color: "bg-green-500" };
            if (totalScore < 10) return { level: "Moderate Risk", color: "bg-yellow-500" };
            return { level: "High Risk", color: "bg-red-600" };
        }

        // --- Event Handlers ---
        weightInput.addEventListener('input', calculateBmi);
        heightInput.addEventListener('input', calculateBmi);

        calculateBtn.addEventListener('click', () => {
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
            const imagingScore = calculateImagingRiskScore(inputs);
            const finalRisk = predictChronificationRisk(stumbl, parseFloat(imagingScore), inputs);

            // 3. Display results
            stumblScoreEl.textContent = stumbl;

            riskFlagsEl.innerHTML = ''; // Clear previous flags
            if (flags.length > 0) {
                flags.forEach(flag => {
                    const li = document.createElement('li');
                    li.textContent = flag;
                    riskFlagsEl.appendChild(li);
                });
            } else {
                const li = document.createElement('li');
                li.textContent = 'None Detected';
                li.className = 'text-gray-500';
                riskFlagsEl.appendChild(li);
            }

            imagingScoreEl.textContent = imagingScore;

            finalRiskEl.textContent = finalRisk.level;
            finalRiskContainer.className = `p-6 rounded-lg text-center text-white shadow-xl ${finalRisk.color}`;

            resultsDiv.classList.remove('hidden');
            calculateBtn.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Scroll to results
        });

        // Pain Map Logic
        viewAnteriorBtn.addEventListener('click', () => {
            anteriorView.classList.remove('hidden');
            posteriorView.classList.add('hidden');
            viewAnteriorBtn.classList.replace('inactive', 'active');
            viewPosteriorBtn.classList.replace('active', 'inactive');
            anatomicalImageEl.src = ANTERIOR_IMAGE_URL; // Change background image
        });

        viewPosteriorBtn.addEventListener('click', () => {
            posteriorView.classList.remove('hidden');
            anteriorView.classList.add('hidden');
            viewPosteriorBtn.classList.replace('inactive', 'active');
            viewAnteriorBtn.classList.replace('active', 'inactive');
            anatomicalImageEl.src = POSTERIOR_IMAGE_URL; // Change background image
        });

        painZones.forEach(zone => {
            zone.addEventListener('click', () => {
                const zoneId = zone.dataset.zoneId;

                // Get all elements sharing this zoneId (for bilateral/multi-part zones)
                const segments = document.querySelectorAll(`[data-zone-id="${zoneId}"]`);

                let isSelected = false;

                // Check if the current element is selected
                if (zone.classList.contains('selected')) {
                    // If selected, deselect all segments with this ID
                    segments.forEach(seg => seg.classList.remove('selected'));
                    selectedPainZones.delete(zoneId);
                } else {
                    // If not selected, select all segments with this ID
                    segments.forEach(seg => seg.classList.add('selected'));
                    selectedPainZones.add(zoneId);
                    isSelected = true;
                }

                updateSelectedZonesList();
            });
        });

        function updateSelectedZonesList() {
            if (selectedPainZones.size === 0) {
                selectedZonesList.textContent = 'No Zones Selected';
            } else {
                // Display unique zone IDs, sorted
                selectedZonesList.textContent = Array.from(selectedPainZones).sort().join(', ');
            }
        }
    });
</script>
</body>
</html>
