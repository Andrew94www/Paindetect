<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-CaRe - Chronic Pain Risk Assessment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .pain-zone {
            fill: rgba(0, 112, 240, 0.1);
            stroke: rgba(0, 82, 178, 0.5);
            stroke-width: 2px;
            cursor: pointer;
            transition: fill 0.2s ease-in-out;
        }
        .pain-zone:hover {
            fill: rgba(255, 165, 0, 0.4);
        }
        .pain-zone.selected {
            fill: rgba(217, 48, 37, 0.7);
            stroke: rgba(154, 23, 16, 1);
        }
        .view-toggle-btn {
            transition: background-color 0.3s, color 0.3s;
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
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="container mx-auto p-4 md:p-8">
    <!-- Header -->
    <header class="text-center mb-8">
        <div class="flex justify-center items-center gap-4">
            <svg class="w-16 h-16 text-blue-600" viewBox="0 0 64 64" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.8,4.8C18.4,4.8,13,10.1,13,16.5v1.6c0,2.3,1.9,4.2,4.2,4.2s4.2-1.9,4.2-4.2v-1.6c0-1.8,1.5-3.3,3.3-3.3s3.3,1.5,3.3,3.3v1.6c0,2.3,1.9,4.2,4.2,4.2s4.2-1.9,4.2-4.2v-1.6C40.5,10.1,35.1,4.8,28.7,4.8H24.8z M14.6,25.5c-2.3,0-4.2,1.9-4.2,4.2v19.8c0,2.3,1.9,4.2,4.2,4.2h1.6c2.3,0,4.2-1.9,4.2-4.2V29.7c0-2.3-1.9-4.2-4.2-4.2H14.6z M24.8,25.5c-2.3,0-4.2,1.9-4.2,4.2v19.8c0,2.3,1.9,4.2,4.2,4.2h1.6c2.3,0,4.2-1.9,4.2-4.2V29.7c0-2.3-1.9-4.2-4.2-4.2H24.8z M34.9,25.5c-2.3,0-4.2,1.9-4.2,4.2v19.8c0,2.3,1.9,4.2,4.2,4.2h1.6c2.3,0,4.2-1.9,4.2-4.2V29.7c0-2.3-1.9-4.2-4.2-4.2H34.9z"/>
                <path class="text-yellow-400" d="M45.5,16.1c-5.5,0-10,4.5-10,10s4.5,10,10,10s10-4.5,10-10S51,16.1,45.5,16.1z M49.7,30.3c-0.8,0.8-2.1,0.8-2.8,0c-0.8-0.8-0.8-2.1,0-2.8c0.8-0.8,2.1-0.8,2.8,0C50.5,28.2,50.5,29.5,49.7,30.3z M41.3,30.3c-0.8,0.8-2.1,0.8-2.8,0c-0.8-0.8-0.8-2.1,0-2.8c0.8-0.8,2.1-0.8,2.8,0C42.1,28.2,42.1,29.5,41.3,30.3z M49.5,37.5c-1.5,1.5-3.5,2.3-5.5,2.3s-4-0.8-5.5-2.3c-0.4-0.4-0.4-1,0-1.4c0.4-0.4,1-0.4,1.4,0c1.2,1.2,2.8,1.8,4.1,1.8s2.9-0.6,4.1-1.8c0.4-0.4,1-0.4,1.4,0C49.9,36.5,49.9,37.1,49.5,37.5z"/>
            </svg>
            <div>
                <h1 class="text-4xl font-bold text-blue-700">T-CaRe</h1>
                <p class="text-lg text-gray-600">Thoracic – Chronification Pain Assessment and Recovery Engine</p>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Left Column: Inputs and Results -->
        <div class="space-y-6">
            <!-- Patient Profile -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold mb-4 border-b pb-2 text-blue-700">1. Patient Profile & Clinical Risk Profiler</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input id="age" type="number" placeholder="Age" class="p-2 border rounded-md">
                    <select id="sex" class="p-2 border rounded-md">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                    <input id="weight" type="number" placeholder="Weight (kg)" class="p-2 border rounded-md">
                    <input id="height" type="number" placeholder="Height (cm)" class="p-2 border rounded-md">
                    <div class="bg-gray-100 p-2 rounded-md text-center">
                        <span class="text-sm font-medium text-gray-600">Calculated BMI:</span>
                        <span id="bmi-display" class="font-bold text-gray-800">-</span>
                    </div>
                    <input id="pain_score_72h" type="number" placeholder="Pain Score 72h (NRS 0-10)" class="p-2 border rounded-md">
                    <input id="pcs" type="number" placeholder="PCS (Pain Catastrophizing Scale)" class="p-2 border rounded-md">
                    <input id="opioid_days" type="number" placeholder="Opioid Use (days)" class="p-2 border rounded-md">
                    <input id="icu_days" type="number" placeholder="ICU Stay (days)" class="p-2 border rounded-md">
                    <input id="gcs" type="number" placeholder="Glasgow Coma Scale (GCS)" class="p-2 border rounded-md">
                    <input id="spo2" type="number" placeholder="Oxygen Saturation O₂ (%)" class="p-2 border rounded-md">
                    <div class="flex items-center space-x-2">
                        <input id="anticoagulants" type="checkbox" class="h-5 w-5 rounded">
                        <label for="anticoagulants">On Anticoagulants</label>
                    </div>
                </div>
            </div>

            <!-- CT Imaging Interpreter -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-2xl font-bold mb-4 border-b pb-2 text-blue-700">2. Thoracic CT Imaging Interpreter</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input id="rib_fractures" type="number" placeholder="Number of Rib Fractures" class="p-2 border rounded-md">
                    <input id="deformity_index" type="number" placeholder="Deformity Index (0-3)" class="p-2 border rounded-md">
                    <div class="flex items-center space-x-2"><input id="bilateral" type="checkbox" class="h-5 w-5"><label for="bilateral">Bilateral Involvement</label></div>
                    <div class="flex items-center space-x-2"><input id="sternal_fracture" type="checkbox" class="h-5 w-5"><label for="sternal_fracture">Sternal Fracture</label></div>
                    <div class="flex items-center space-x-2"><input id="spine_fracture" type="checkbox" class="h-5 w-5"><label for="spine_fracture">Spine Fracture</label></div>
                    <div class="flex items-center space-x-2"><input id="hemothorax" type="checkbox" class="h-5 w-5"><label for="hemothorax">Hemothorax</label></div>
                    <div class="flex items-center space-x-2"><input id="pneumothorax" type="checkbox" class="h-5 w-5"><label for="pneumothorax">Pneumothorax</label></div>
                    <div class="flex items-center space-x-2"><input id="nerve_contact" type="checkbox" class="h-5 w-5"><label for="nerve_contact">Nerve Contact</label></div>
                </div>
            </div>

            <!-- Calculation Button and Results -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <button id="calculate-btn" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 text-xl">
                    Calculate Chronification Risk
                </button>
                <div id="results" class="mt-6 space-y-4 hidden">
                    <h3 class="text-2xl font-bold text-center text-blue-800">Assessment Results</h3>
                    <!-- STUMBL Score -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-lg font-semibold">STUMBL Score: <span id="stumbl-score" class="font-bold text-blue-700 text-xl"></span></p>
                    </div>
                    <!-- Clinical Risk Flags -->
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <p class="text-lg font-semibold">Clinical Risk Flags:</p>
                        <ul id="risk-flags" class="list-disc list-inside text-yellow-800 mt-2"></ul>
                    </div>
                    <!-- Imaging Risk Score -->
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-lg font-semibold">Imaging Risk Score: <span id="imaging-score" class="font-bold text-green-700 text-xl"></span> / 10</p>
                    </div>
                    <!-- Final Chronification Risk -->
                    <div id="final-risk-container" class="p-6 rounded-lg text-center text-white">
                        <p class="text-lg font-semibold">Predicted Chronification Risk:</p>
                        <p id="final-risk" class="font-bold text-3xl mt-1"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Pain Map -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">4. ThoracoMap: Interactive Pain Map</h2>
            <div class="flex justify-center mb-4">
                <div class="inline-flex rounded-md shadow-sm">
                    <button id="view-anterior-btn" class="view-toggle-btn active px-6 py-2 text-sm font-medium border border-gray-200 rounded-l-lg">Anterior View</button>
                    <button id="view-posterior-btn" class="view-toggle-btn inactive px-6 py-2 text-sm font-medium border border-gray-200 rounded-r-lg">Posterior View</button>
                </div>
            </div>

            <div id="pain-map-container" class="w-full max-w-lg mx-auto aspect-square relative">
                <!-- Anterior View SVG -->
                <svg id="anterior-view" class="w-full h-full" viewBox="0 0 350 400">
                    <image href="" x="0" y="0" height="400" width="350" />
                    <path id="A1-left" data-zone-id="A1" class="pain-zone" d="M 105,95 L 60,115 L 60,150 L 105,140 Z"></path>
                    <path id="A2-left" data-zone-id="A2" class="pain-zone" d="M 105,142 L 60,152 L 60,195 L 105,190 Z"></path>
                    <path id="A3-left" data-zone-id="A3" class="pain-zone" d="M 105,192 L 60,197 L 60,230 L 105,235 Z"></path>
                    <path id="B1-right" data-zone-id="B1" class="pain-zone" d="M 245,95 L 290,115 L 290,150 L 245,140 Z"></path>
                    <path id="B2-right" data-zone-id="B2" class="pain-zone" d="M 245,142 L 290,152 L 290,195 L 245,190 Z"></path>
                    <path id="B3-right" data-zone-id="B3" class="pain-zone" d="M 245,192 L 290,197 L 290,230 L 245,235 Z"></path>
                    <path id="C-sternum" data-zone-id="C" class="pain-zone" d="M 140,90 L 210,90 L 210,240 L 140,240 Z"></path>
                    <path id="D-epigastric" data-zone-id="D" class="pain-zone" d="M 100,245 L 250,245 L 220,310 L 130,310 Z"></path>
                </svg>

                <!-- Posterior View SVG -->
                <svg id="posterior-view" class="w-full h-full hidden" viewBox="0 0 350 400">
                    <image href="" x="0" y="0" height="400" width="350" />
                    <path id="E1-left-scap" data-zone-id="E1" class="pain-zone" d="M 65,110 a 40,50 0 0 1 70,0 V 200 a 40,50 0 0 1 -70,0 Z"></path>
                    <path id="E2-right-scap" data-zone-id="E2" class="pain-zone" d="M 215,110 a 40,50 0 0 1 70,0 V 200 a 40,50 0 0 1 -70,0 Z"></path>
                    <path id="F1-left-para" data-zone-id="F1" class="pain-zone" d="M 140,100 L 160,100 L 160,280 L 140,280 Z"></path>
                    <path id="F2-right-para" data-zone-id="F2" class="pain-zone" d="M 190,100 L 210,100 L 210,280 L 190,280 Z"></path>
                    <path id="G-spine" data-zone-id="G" class="pain-zone" d="M 165,90 L 185,90 L 185,290 L 165,290 Z"></path>
                    <path id="H-lumbar" data-zone-id="H" class="pain-zone" d="M 100,290 L 250,290 L 240,360 L 110,360 Z"></path>
                </svg>
            </div>
            <div class="mt-4 bg-gray-100 p-4 rounded-lg">
                <h3 class="font-semibold">Selected Pain Zones:</h3>
                <p id="selected-zones-list" class="text-gray-700 mt-2">No zones selected</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

        // Module 1: Patient Profile & Clinical Risk Profiler
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

        // Module 2: Thoracic CT Imaging Interpreter
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
            return Math.min(score, 10).toFixed(1); // Cap at 10 and format
        }

        // Module 3: Chronification Risk Estimator
        function predictChronificationRisk(stumblScore, imagingScore, inputs) {
            let totalScore = 0;
            totalScore += stumblScore * 0.6;
            totalScore += imagingScore * 0.8;
            if (inputs.pcs > 30) totalScore += 2;
            if (inputs.opioid_days > 7) totalScore += 1.5;
            if (inputs.icu_days > 3) totalScore += 1.5;

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
                li.textContent = 'None identified';
                li.className = 'text-gray-500';
                riskFlagsEl.appendChild(li);
            }

            imagingScoreEl.textContent = imagingScore;

            finalRiskEl.textContent = finalRisk.level;
            finalRiskContainer.className = `p-6 rounded-lg text-center text-white ${finalRisk.color}`;

            resultsDiv.classList.remove('hidden');
        });

        // Pain Map Logic
        viewAnteriorBtn.addEventListener('click', () => {
            anteriorView.classList.remove('hidden');
            posteriorView.classList.add('hidden');
            viewAnteriorBtn.classList.replace('inactive', 'active');
            viewPosteriorBtn.classList.replace('active', 'inactive');
        });

        viewPosteriorBtn.addEventListener('click', () => {
            posteriorView.classList.remove('hidden');
            anteriorView.classList.add('hidden');
            viewPosteriorBtn.classList.replace('inactive', 'active');
            viewAnteriorBtn.classList.replace('active', 'inactive');
        });

        painZones.forEach(zone => {
            zone.addEventListener('click', () => {
                const zoneId = zone.dataset.zoneId;
                zone.classList.toggle('selected');
                if (selectedPainZones.has(zoneId)) {
                    selectedPainZones.delete(zoneId);
                } else {
                    selectedPainZones.add(zoneId);
                }
                updateSelectedZonesList();
            });
        });

        function updateSelectedZonesList() {
            if (selectedPainZones.size === 0) {
                selectedZonesList.textContent = 'No zones selected';
            } else {
                selectedZonesList.textContent = Array.from(selectedPainZones).sort().join(', ');
            }
        }
    });
</script>
</body>
</html>
