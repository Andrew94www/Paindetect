<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prothesys - Stump Pain Prognosis with Pain Drawing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles for slider thumb */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: #facc15; /* yellow-400 */
            cursor: pointer;
            border-radius: 50%;
            margin-top: -6px;
        }
        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: #facc15; /* yellow-400 */
            cursor: pointer;
            border-radius: 50%;
        }
        /* Styles for the drawing canvas */
        #canvas-container {
            position: relative;
            width: 100%;
            max-width: 300px; /* Control max size */
            margin: 0 auto; /* Center the canvas */
            border-radius: 0.5rem;
            overflow: hidden;
        }
        #pain-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: crosshair;
            touch-action: none; /* Prevents scrolling on touch devices while drawing */
        }
        #bg-image {
            display: block;
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">

<div class="w-full max-w-4xl bg-slate-800 rounded-2xl shadow-2xl p-6 md:p-10 text-gray-200">

    <!-- Header -->
    <header class="text-center mb-8">
        <div class="flex items-center justify-center gap-4 mb-2">
            <svg class="w-10 h-10 text-yellow-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.6338 5.14882C11.2435 4.34015 10.1558 4.34015 9.76551 5.14882L8.23218 8.33649C8.03158 8.75053 7.5925 9.01515 7.12838 8.95666L3.65582 8.52416C2.79373 8.4143 2.25973 9.42153 2.76672 10.1501L5.05191 13.4357C5.35246 13.882 5.35246 14.4735 5.05191 14.9198L2.76672 18.2054C2.25973 18.9339 2.79373 19.9412 3.65582 19.8313L7.12838 19.3988C7.5925 19.3403 8.03158 19.605 8.23218 20.019L9.76551 23.2067C10.1558 24.0154 11.2435 24.0154 11.6338 23.2067L12.5 21.419V17C12.5 15.8954 13.3954 15 14.5 15H17.5C18.8807 15 20 13.8807 20 12.5V8.5C20 6.01472 17.9853 4 15.5 4H13.5L11.6338 5.14882Z" fill="currentColor"/></svg>
            <h1 class="text-3xl md:text-4xl font-bold text-yellow-400">Prothesys</h1>
        </div>
        <p class="text-gray-400 text-lg">Stump Pain and Prosthesis Need Prognosis</p>
    </header>

    <form id="prognosis-form">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Left Column: Patient History -->
            <div class="space-y-6">
                <fieldset class="border-t-2 border-slate-700 pt-4">
                    <legend class="text-xl font-semibold text-yellow-300 mb-4">1️⃣ Medical History</legend>

                    <div>
                        <label for="days_since_amputation" class="flex justify-between text-sm font-medium text-gray-300 mb-2">
                            <span>Time since amputation (days)</span>
                            <span id="days_value" class="font-bold text-yellow-400">30</span>
                        </label>
                        <input type="range" id="days_since_amputation" min="0" max="1000" value="30" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <div>
                        <label for="type_amputation" class="block text-sm font-medium text-gray-300 mb-2">Amputation Type</label>
                        <select id="type_amputation" class="w-full bg-slate-700 border border-slate-600 text-white text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 p-2.5">
                            <option>Traumatic</option>
                            <option>Planned</option>
                        </select>
                    </div>

                    <div>
                        <label for="healing_status" class="block text-sm font-medium text-gray-300 mb-2">Healing Status</label>
                        <select id="healing_status" class="w-full bg-slate-700 border border-slate-600 text-white text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 p-2.5">
                            <option value="Первичное натяжение">Primary intention</option>
                            <option value="Вторичное заживление">Secondary intention</option>
                            <option value="Осложненное">Complicated</option>
                        </select>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-300 mb-2">Phantom Limb Pain</span>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 text-sm"><input type="radio" name="phantom_pain" value="Yes" class="w-4 h-4 text-yellow-400 bg-gray-700 border-gray-600 focus:ring-yellow-500">Yes</label>
                            <label class="flex items-center gap-2 text-sm"><input type="radio" name="phantom_pain" value="No" checked class="w-4 h-4 text-yellow-400 bg-gray-700 border-gray-600 focus:ring-yellow-500">No</label>
                        </div>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-300 mb-2">Previous Analgesia</span>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center gap-2 text-sm"><input type="radio" name="previous_therapy" value="Effective" class="w-4 h-4 text-yellow-400 bg-gray-700 border-gray-600 focus:ring-yellow-500">Effective</label>
                            <label class="flex items-center gap-2 text-sm"><input type="radio" name="previous_therapy" value="Insufficient" checked class="w-4 h-4 text-yellow-400 bg-gray-700 border-gray-600 focus:ring-yellow-500">Insufficient</label>
                            <label class="flex items-center gap-2 text-sm"><input type="radio" name="previous_therapy" value="None" class="w-4 h-4 text-yellow-400 bg-gray-700 border-gray-600 focus:ring-yellow-500">None</label>
                        </div>
                    </div>
                </fieldset>
            </div>

            <!-- Right Column: Clinical Factors -->
            <div class="space-y-6">
                <fieldset class="border-t-2 border-slate-700 pt-4">
                    <legend class="text-xl font-semibold text-yellow-300 mb-4">2️⃣ Clinical Factors</legend>

                    <div>
                        <label for="local_pain" class="flex justify-between text-sm font-medium text-gray-300 mb-2">
                            <span>Stump Pain Intensity (0-10)</span>
                            <span id="pain_intensity_value" class="font-bold text-yellow-400">4</span>
                        </label>
                        <input type="range" id="local_pain" min="0" max="10" value="4" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer">
                    </div>

                    <!-- Pain Drawing Area -->
                    <div class="space-y-3 text-center">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            Pain Drawing Area: <span id="pain_area_value" class="font-bold text-yellow-400">0</span> %
                        </label>
                        <div id="canvas-container">
                            <img id="bg-image" src="img/protesys.jpg" alt="Body silhouette for pain drawing">
                            <canvas id="pain-canvas"></canvas>
                        </div>
                        <button type="button" id="clear-canvas-btn" class="text-sm bg-slate-700 hover:bg-slate-600 text-yellow-300 font-semibold py-2 px-4 rounded-lg transition-colors">Clear Drawing</button>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-300 mb-2">Patient uses a prosthesis</span>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 text-sm"><input type="radio" name="prosthesis_ready" value="Yes" class="w-4 h-4 text-yellow-400 bg-gray-700 border-gray-600 focus:ring-yellow-500">Yes</label>
                            <label class="flex items-center gap-2 text-sm"><input type="radio" name="prosthesis_ready" value="No" checked class="w-4 h-4 text-yellow-400 bg-gray-700 border-gray-600 focus:ring-yellow-500">No</label>
                        </div>
                    </div>
                </fieldset>

                <!-- Results Section -->
                <div id="results-container" class="pt-4 mt-6 border-t-2 border-slate-700">
                    <h2 class="text-xl font-semibold text-yellow-300 mb-4">🔎 Result</h2>
                    <div id="results" class="space-y-4">
                        <!-- Prognosis will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- DOM Element References ---
        const form = document.getElementById('prognosis-form');
        const resultsDiv = document.getElementById('results');

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
        let painAreaPercentForCalculation = 0; // The 0-20 value for the model
        let silhouettePixelCount = 0; // Total pixels of the silhouette itself

        // Analyze the silhouette image to get the total drawable area
        function analyzeSilhouette() {
            // Ensure image is loaded before analysis
            if (!bgImage.complete || bgImage.naturalWidth === 0) {
                setTimeout(analyzeSilhouette, 100); // Try again shortly
                return;
            }

            // Use a temporary canvas to draw the image and count its pixels
            const tempCanvas = document.createElement('canvas');
            const tempCtx = tempCanvas.getContext('2d');
            tempCanvas.width = bgImage.naturalWidth;
            tempCanvas.height = bgImage.naturalHeight;
            tempCtx.drawImage(bgImage, 0, 0);

            const imageData = tempCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height);
            const data = imageData.data;
            let pixelCount = 0;
            // The background is black (R,G,B = 0). Count any non-black pixel.
            for (let i = 0; i < data.length; i += 4) {
                if (data[i] > 0 || data[i + 1] > 0 || data[i + 2] > 0) {
                    pixelCount++;
                }
            }
            silhouettePixelCount = pixelCount;
        }

        // Set canvas size based on the background image's displayed size
        function setCanvasSize() {
            canvas.width = bgImage.clientWidth;
            canvas.height = bgImage.clientHeight;
            ctx.lineJoin = 'round';
            ctx.lineCap = 'round';
            ctx.lineWidth = 15; // Brush size
            ctx.strokeStyle = 'rgba(255, 0, 0, 0.6)'; // Semi-transparent red
        }

        // Initial setup once the image is loaded
        bgImage.onload = () => {
            setCanvasSize();
            analyzeSilhouette();
        };
        // If image is already cached/loaded, run setup
        if (bgImage.complete) {
            setCanvasSize();
            analyzeSilhouette();
        }
        // Recalculate on window resize
        window.addEventListener('resize', setCanvasSize);

        function getEventPosition(event) {
            const rect = canvas.getBoundingClientRect();
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;

            if (event.touches && event.touches.length > 0) {
                return {
                    x: (event.touches[0].clientX - rect.left) * scaleX,
                    y: (event.touches[0].clientY - rect.top) * scaleY
                };
            }
            return {
                x: (event.clientX - rect.left) * scaleX,
                y: (event.clientY - rect.top) * scaleY
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
            e.preventDefault(); // prevent scrolling on touch
            const { x, y } = getEventPosition(e);
            ctx.lineTo(x, y);
            ctx.stroke();
        }

        function stopDrawing() {
            if (!isDrawing) return;
            isDrawing = false;
            ctx.closePath();
            calculatePainArea(); // Calculate area and update prognosis
        }

        function calculatePainArea() {
            if (silhouettePixelCount === 0) return; // Avoid division by zero

            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;
            let drawnPixels = 0;

            for (let i = 0; i < data.length; i += 4) {
                if (data[i + 3] > 0) { // Check alpha channel of the drawing
                    drawnPixels++;
                }
            }

            // Calculate the percentage of the SILHOUETTE that is covered
            const visualPercentage = Math.min(100, (drawnPixels / silhouettePixelCount) * 100);

            // Update the UI to show the 0-100% visual value
            painAreaValue.textContent = Math.round(visualPercentage);

            // Map the 0-100% visual value to the 0-20% clinical value for the calculation
            painAreaPercentForCalculation = visualPercentage * 0.2;

            calculatePrognosis();
        }

        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            calculatePainArea(); // Recalculate to set area to 0 and update
        }

        // Event Listeners for drawing
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        window.addEventListener('touchend', stopDrawing);

        clearBtn.addEventListener('click', clearCanvas);

        // --- Function to Calculate and Display Prognosis ---
        function calculatePrognosis() {
            const daysSinceAmputation = parseInt(daysSlider.value);
            const healingStatus = document.getElementById('healing_status').value;
            const phantomPain = document.querySelector('input[name="phantom_pain"]:checked').value;
            const previousTherapy = document.querySelector('input[name="previous_therapy"]:checked').value;
            const localPain = parseInt(painIntensitySlider.value);
            const prosthesisReady = document.querySelector('input[name="prosthesis_ready"]:checked').value;

            // --- Risk Score Calculation ---
            let riskScore = 0;
            if (localPain >= 6) riskScore += 2;
            if (painAreaPercentForCalculation >= 5) riskScore += 2; // Uses correctly scaled value
            if (healingStatus === 'Осложненное') riskScore += 1;
            if (phantomPain === 'Yes') riskScore += 1;
            if (previousTherapy !== 'Effective') riskScore += 1;
            if (prosthesisReady === 'No' && daysSinceAmputation > 60) riskScore += 2;

            // --- Risk Level Interpretation ---
            let riskLevelHTML = '';
            if (riskScore >= 6) {
                riskLevelHTML = `<div class="p-4 rounded-lg border border-red-500 bg-red-900/50 text-red-300">
                                        <p class="font-bold text-lg">🔴 High risk of chronic pain</p>
                                     </div>`;
            } else if (riskScore >= 3) {
                riskLevelHTML = `<div class="p-4 rounded-lg border border-orange-500 bg-orange-900/50 text-orange-300">
                                        <p class="font-bold text-lg">🟠 Moderate risk</p>
                                     </div>`;
            } else {
                riskLevelHTML = `<div class="p-4 rounded-lg border border-green-500 bg-green-900/50 text-green-300">
                                        <p class="font-bold text-lg">🟢 Low risk</p>
                                     </div>`;
            }

            // --- Prosthesis Prognosis ---
            let prosthesisPrognosisHTML = '';
            if (prosthesisReady === "Yes") {
                prosthesisPrognosisHTML = `<div class="p-4 rounded-lg border border-sky-500 bg-sky-900/50 text-sky-300">
                                                 <p class="font-semibold">✅ Prosthesis use has started</p>
                                               </div>`;
            } else if (daysSinceAmputation < 60 && healingStatus === "Первичное натяжение") {
                prosthesisPrognosisHTML = `<div class="p-4 rounded-lg border border-sky-500 bg-sky-900/50 text-sky-300">
                                                 <p class="font-semibold">🕒 Prosthesis fitting possible in the next 2-4 weeks</p>
                                               </div>`;
            } else {
                prosthesisPrognosisHTML = `<div class="p-4 rounded-lg border border-yellow-500 bg-yellow-900/50 text-yellow-300">
                                                 <p class="font-semibold">⚠️ Prosthesis fitting should be postponed / preparation needed</p>
                                               </div>`;
            }

            resultsDiv.innerHTML = riskLevelHTML + prosthesisPrognosisHTML;
        }

        // --- Other Event Listeners ---
        daysSlider.addEventListener('input', (e) => {
            daysValue.textContent = e.target.value;
            calculatePrognosis();
        });
        painIntensitySlider.addEventListener('input', (e) => {
            painIntensityValue.textContent = e.target.value;
            calculatePrognosis();
        });

        form.addEventListener('change', calculatePrognosis);

        // Initial calculation on page load
        calculatePrognosis();
    });
</script>
</body>
</html>
