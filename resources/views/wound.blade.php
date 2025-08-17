<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wound Assessment Tool</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .form-section {
            transition: background-color 0.3s ease;
        }
        .summary-card {
            transition: all 0.3s ease;
        }
        /* Custom styles for range input */
        input[type=range] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 8px;
            background: #e2e8f0;
            border-radius: 5px;
            outline: none;
            opacity: 0.7;
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
            background: #3b82f6;
            cursor: pointer;
            border-radius: 50%;
        }
        input[type=range]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #3b82f6;
            cursor: pointer;
            border-radius: 50%;
        }
        /* Custom checkbox style */
        .custom-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .custom-checkbox:checked ~ .tick-mark {
            display: block;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="container mx-auto p-4 md:p-8">
    <!-- Header -->
    <header class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900">Wound Assessment System</h1>
        <p class="text-slate-600 mt-2 text-lg">Fill in the details for a comprehensive assessment and severity index calculation.</p>
    </header>

    <main class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl shadow-lg">
            <form id="woundForm">
                <!-- Patient Information -->
                <fieldset class="mb-8 form-section">
                    <legend class="text-xl font-semibold mb-4 text-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Patient Information
                    </legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="patientId" class="block text-sm font-medium text-slate-700">Patient ID</label>
                            <input type="text" id="patientId" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="e.g., 12345">
                        </div>
                        <div>
                            <label for="assessmentDate" class="block text-sm font-medium text-slate-700">Assessment Date</label>
                            <input type="date" id="assessmentDate" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>
                </fieldset>

                <!-- Wound Characteristics -->
                <fieldset class="mb-8 form-section">
                    <legend class="text-xl font-semibold mb-4 text-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M15.5 2.5a2.5 2.5 0 0 0-3.5 0L8.5 6H5a2 2 0 0 0-2 2v3.5a2.5 2.5 0 0 0 0 3.5L6.5 19H10a2 2 0 0 0 2-2v-3.5a2.5 2.5 0 0 0 0-3.5L8.5 6H12a2 2 0 0 0 2-2V2.5a2.5 2.5 0 0 0 0 3.5z"></path></svg>
                        Wound Characteristics
                    </legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Dimensions -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Dimensions (cm)</label>
                            <div class="flex items-center space-x-2">
                                <input type="number" id="length" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Length">
                                <span class="text-slate-500">×</span>
                                <input type="number" id="width" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Width">
                                <span class="text-slate-500">×</span>
                                <input type="number" id="depth" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Depth">
                            </div>
                        </div>
                        <!-- Exudate Amount -->
                        <div>
                            <label for="exudateAmount" class="block text-sm font-medium text-slate-700">Exudate Amount</label>
                            <select id="exudateAmount" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="0">None</option>
                                <option value="1">Scant</option>
                                <option value="2">Moderate</option>
                                <option value="3">Copious</option>
                            </select>
                        </div>
                        <!-- Tissue Type -->
                        <div>
                            <label for="tissueType" class="block text-sm font-medium text-slate-700">Wound Bed Tissue Type</label>
                            <select id="tissueType" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="0">Epithelializing</option>
                                <option value="1">Granulating</option>
                                <option value="2">Sloughy (Yellow)</option>
                                <option value="3">Necrotic (Black)</option>
                            </select>
                        </div>
                        <!-- Periwound Skin -->
                        <div>
                            <label for="periwoundSkin" class="block text-sm font-medium text-slate-700">Periwound Skin</label>
                            <select id="periwoundSkin" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="0">Healthy</option>
                                <option value="1">Macerated</option>
                                <option value="2">Erythematous</option>
                                <option value="3">Indurated</option>
                            </select>
                        </div>
                        <!-- Wound Edges -->
                        <div>
                            <label for="woundEdges" class="block text-sm font-medium text-slate-700">Wound Edges</label>
                            <select id="woundEdges" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="0">Defined / Attached</option>
                                <option value="2">Undermining</option>
                                <option value="3">Tunneling</option>
                            </select>
                        </div>
                        <!-- Odor -->
                        <div>
                            <label for="odor" class="block text-sm font-medium text-slate-700">Odor</label>
                            <select id="odor" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="0">None</option>
                                <option value="1">Slight</option>
                                <option value="2">Foul</option>
                            </select>
                        </div>
                        <!-- Pain Level -->
                        <div class="md:col-span-2">
                            <label for="painLevel" class="block text-sm font-medium text-slate-700">Pain Level: <span id="painValue" class="font-bold text-blue-600">5</span>/10</label>
                            <input type="range" id="painLevel" min="0" max="10" value="5" class="mt-2 w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        </div>
                    </div>
                </fieldset>

                <!-- Infection Signs -->
                <fieldset class="mb-8 form-section">
                    <legend class="text-xl font-semibold mb-4 text-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        Signs of Infection
                    </legend>
                    <div id="infectionSigns" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <!-- Checkboxes will be dynamically inserted here -->
                    </div>
                </fieldset>

                <!-- Photo Upload -->
                <fieldset class="form-section">
                    <legend class="text-xl font-semibold mb-4 text-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        Wound Photograph
                    </legend>
                    <label for="woundImage" class="block w-full cursor-pointer border-2 border-dashed border-slate-300 rounded-lg p-8 text-center hover:border-blue-500 transition">
                        <span id="uploadText" class="text-slate-500">Click to upload an image</span>
                        <input type="file" id="woundImage" class="hidden" accept="image/*">
                    </label>
                </fieldset>
            </form>
        </div>

        <!-- Summary Section -->
        <div class="lg:col-span-1">
            <div class="sticky top-8 bg-white p-6 md:p-8 rounded-2xl shadow-lg summary-card">
                <h2 class="text-2xl font-bold mb-6 text-slate-900 text-center">Assessment Summary</h2>

                <!-- Score Display -->
                <div class="text-center mb-6">
                    <div id="scoreCircle" class="mx-auto w-32 h-32 rounded-full flex items-center justify-center bg-green-100 border-4 border-green-500 transition-all duration-300">
                        <div>
                            <div id="scoreValue" class="text-4xl font-bold text-green-600">0</div>
                            <div class="text-sm text-green-700 font-medium">Index</div>
                        </div>
                    </div>
                    <p id="scoreDescription" class="mt-3 font-semibold text-green-700 text-lg">Low Severity</p>
                </div>

                <!-- Image Preview -->
                <div class="mb-6">
                    <img id="imagePreview" src="https://placehold.co/400x300/e2e8f0/cbd5e1?text=Preview" alt="Wound preview" class="w-full h-auto rounded-lg object-cover aspect-[4/3]">
                </div>

                <!-- Details -->
                <div id="summaryDetails" class="space-y-3 text-sm">
                    <p class="text-center text-slate-500">Fill out the form to see the details.</p>
                </div>

                <!-- Copy Button -->
                <button id="copyButton" class="mt-6 w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-105 flex items-center justify-center" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    Copy Report
                </button>
                <div id="copyFeedback" class="text-center text-sm text-green-600 mt-2 h-4"></div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // DOM Elements
        const form = document.getElementById('woundForm');
        const patientIdEl = document.getElementById('patientId');
        const assessmentDateEl = document.getElementById('assessmentDate');
        const lengthEl = document.getElementById('length');
        const widthEl = document.getElementById('width');
        const depthEl = document.getElementById('depth');
        const exudateAmountEl = document.getElementById('exudateAmount');
        const tissueTypeEl = document.getElementById('tissueType');
        const periwoundSkinEl = document.getElementById('periwoundSkin');
        const woundEdgesEl = document.getElementById('woundEdges');
        const odorEl = document.getElementById('odor');
        const painLevelEl = document.getElementById('painLevel');
        const painValueEl = document.getElementById('painValue');
        const woundImageEl = document.getElementById('woundImage');
        const imagePreviewEl = document.getElementById('imagePreview');
        const uploadTextEl = document.getElementById('uploadText');
        const infectionSignsContainer = document.getElementById('infectionSigns');

        const scoreCircleEl = document.getElementById('scoreCircle');
        const scoreValueEl = document.getElementById('scoreValue');
        const scoreDescriptionEl = document.getElementById('scoreDescription');
        const summaryDetailsEl = document.getElementById('summaryDetails');
        const copyButton = document.getElementById('copyButton');
        const copyFeedback = document.getElementById('copyFeedback');

        const infectionSignsList = [
            { id: 'inf-pain', label: 'Increased Pain', score: 1 },
            { id: 'inf-erythema', label: 'Erythema', score: 1 },
            { id: 'inf-edema', label: 'Edema', score: 1 },
            { id: 'inf-heat', label: 'Heat', score: 1 },
            { id: 'inf-purulent', label: 'Purulent Discharge', score: 2 },
        ];

        // Dynamically create infection sign checkboxes
        infectionSignsContainer.innerHTML = infectionSignsList.map(sign => `
                <label for="${sign.id}" class="flex items-center space-x-2 text-sm cursor-pointer">
                    <div class="relative flex items-center">
                        <input type="checkbox" id="${sign.id}" data-score="${sign.score}" class="custom-checkbox appearance-none h-5 w-5 border border-slate-300 rounded-md checked:bg-blue-600 checked:border-transparent focus:outline-none">
                        <svg class="tick-mark hidden absolute text-white w-4 h-4 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    </div>
                    <span>${sign.label}</span>
                </label>
            `).join('');

        const allInputs = form.querySelectorAll('input, select');

        // Set today's date as default
        assessmentDateEl.valueAsDate = new Date();

        // Function to calculate score
        const calculateScore = () => {
            let score = 0;

            // 1. Area Score
            const length = parseFloat(lengthEl.value) || 0;
            const width = parseFloat(widthEl.value) || 0;
            const area = length * width;
            if (area > 0 && area < 1) score += 1;
            else if (area >= 1 && area < 5) score += 2;
            else if (area >= 5 && area < 15) score += 3;
            else if (area >= 15 && area < 30) score += 4;
            else if (area >= 30) score += 5;

            // 2. Depth Score
            const depth = parseFloat(depthEl.value) || 0;
            if (depth > 0 && depth < 0.5) score += 1;
            else if (depth >= 0.5 && depth < 1.5) score += 2;
            else if (depth >= 1.5) score += 3;

            // 3. Score from selects
            score += parseInt(exudateAmountEl.value, 10);
            score += parseInt(tissueTypeEl.value, 10);
            score += parseInt(periwoundSkinEl.value, 10);
            score += parseInt(woundEdgesEl.value, 10);
            score += parseInt(odorEl.value, 10);

            // 4. Pain Score
            score += Math.ceil(parseInt(painLevelEl.value, 10) / 2); // Pain 0-10 -> Score 0-5

            // 5. Infection Score
            infectionSignsContainer.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
                score += parseInt(cb.dataset.score, 10);
            });

            return score;
        };

        // Function to update the summary UI
        const updateSummary = () => {
            const score = calculateScore();

            // Update score circle and text
            scoreValueEl.textContent = score;

            const scoreClasses = {
                circle: {
                    low: 'bg-green-100 border-green-500',
                    medium: 'bg-yellow-100 border-yellow-500',
                    high: 'bg-red-100 border-red-500',
                },
                text: {
                    low: 'text-green-600',
                    medium: 'text-yellow-600',
                    high: 'text-red-600',
                },
                description: {
                    low: 'Low Severity',
                    medium: 'Moderate Severity',
                    high: 'High Severity',
                }
            };

            // Adjusted severity thresholds for the more detailed scoring
            let severity = 'low';
            if (score > 10 && score <= 20) severity = 'medium';
            else if (score > 20) severity = 'high';

            scoreCircleEl.className = `mx-auto w-32 h-32 rounded-full flex items-center justify-center transition-all duration-300 ${scoreClasses.circle[severity]}`;
            scoreValueEl.className = `text-4xl font-bold ${scoreClasses.text[severity]}`;
            scoreDescriptionEl.className = `mt-3 font-semibold text-lg ${scoreClasses.text[severity]}`;
            scoreDescriptionEl.textContent = scoreClasses.description[severity];

            // Update summary details
            const checkedInfectionSigns = Array.from(infectionSignsContainer.querySelectorAll('input:checked'))
                .map(cb => cb.parentElement.querySelector('span').textContent)
                .join(', ') || 'None';

            const summaryData = {
                'Patient ID': patientIdEl.value || 'N/A',
                'Date': new Date(assessmentDateEl.value).toLocaleDateString('en-US') || 'N/A',
                'Dimensions': `${lengthEl.value || 0} x ${widthEl.value || 0} x ${depthEl.value || 0} cm`,
                'Exudate': exudateAmountEl.options[exudateAmountEl.selectedIndex].text,
                'Tissue Type': tissueTypeEl.options[tissueTypeEl.selectedIndex].text,
                'Periwound Skin': periwoundSkinEl.options[periwoundSkinEl.selectedIndex].text,
                'Wound Edges': woundEdgesEl.options[woundEdgesEl.selectedIndex].text,
                'Odor': odorEl.options[odorEl.selectedIndex].text,
                'Pain': `${painLevelEl.value}/10`,
                'Infection Signs': checkedInfectionSigns,
            };

            summaryDetailsEl.innerHTML = Object.entries(summaryData)
                .map(([key, value]) => `
                        <div class="flex justify-between items-start">
                            <span class="font-medium text-slate-600">${key}:</span>
                            <span class="font-semibold text-slate-800 text-right ml-2">${value}</span>
                        </div>
                    `).join('');

            copyButton.disabled = false;
        };

        // Event Listeners
        allInputs.forEach(input => {
            input.addEventListener('input', updateSummary);
        });

        painLevelEl.addEventListener('input', (e) => {
            painValueEl.textContent = e.target.value;
        });

        woundImageEl.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    imagePreviewEl.src = event.target.result;
                };
                reader.readAsDataURL(file);
                uploadTextEl.textContent = file.name;
            }
        });

        copyButton.addEventListener('click', () => {
            let reportText = `WOUND ASSESSMENT REPORT\n=====================\n`;
            const summaryDivs = summaryDetailsEl.querySelectorAll('div');
            summaryDivs.forEach(div => {
                const key = div.children[0].textContent;
                const value = div.children[1].textContent;
                reportText += `${key} ${value}\n`;
            });
            reportText += `\nSEVERITY INDEX: ${scoreValueEl.textContent}\n`;
            reportText += `Assessment: ${scoreDescriptionEl.textContent}\n`;

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

        // Initial call to set up the summary
        updateSummary();
    });
</script>
</body>
</html>
