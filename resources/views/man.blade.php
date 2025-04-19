<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-PAT with AI Support</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align to top */
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #eef2ff, #c3dafe);
            padding: 20px 0; /* Add vertical padding */
            box-sizing: border-box; /* Include padding in height calculation */
        }
        .container {
            display: grid;
            grid-template-columns: 1fr; /* 1 column on mobile */
            gap: 30px; /* Increased gap */
            background: white;
            box-shadow: 0 25px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 20px; /* Increased padding */
            width: 95%;
            max-width: 1600px;
            box-sizing: border-box;
        }
        @media (min-width: 992px) { /* Adjusted breakpoint for larger screens */
            .container {
                grid-template-columns: 1fr 1fr; /* 2 columns on desktop */
            }
        }

        /* Canvas and Face Picker Section */
        .canvas-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px; /* Add some padding */
            border-radius: 15px;
            background-color: #f8f9fa; /* Light background */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
        }

        canvas {
            border: 1px solid #444;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background: url('img/R_PAT_.png'); /* Ensure this path is correct */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            touch-action: none;
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            aspect-ratio: 2 / 1.5; /* Define aspect ratio */
            margin-bottom: 15px; /* Space below canvas */
        }
        .face-picker {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px; /* Increased gap */
            margin-bottom: 20px; /* Space below face picker */
        }
        .face-option-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 60px; /* Fixed width for each face option column */
        }
        .face-option {
            width: 50px;
            height: 50px;
            cursor: pointer;
            border-radius: 50%;
            border: 2px solid transparent;
            transition: transform 0.3s ease, border-color 0.3s ease;
            object-fit: cover; /* Ensure image covers the circle */
        }
        .face-option:hover, .face-option.active {
            transform: scale(1.1);
            border-color: #007bff; /* Highlight color */
        }
        .face-option-wrapper span {
            font-size: 12px; /* Smaller font for labels */
            margin-top: 5px;
            color: #555;
            font-weight: 500;
        }

        /* Controls Section */
        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Space between control groups */
            padding: 15px; /* Add padding */
            border-radius: 15px;
            background-color: #f8f9fa; /* Light background */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
        }

        .control-group {
            border: 1px solid #e0e0e0; /* Optional: Group border */
            border-radius: 10px;
            padding: 15px;
            background-color: #ffffff; /* White background for groups */
        }

        .controls label {
            font-size: 1rem; /* Standard font size */
            font-weight: 500; /* Medium weight */
            color: #333;
            margin-bottom: 5px; /* Space below label */
            display: block; /* Make label a block element */
        }

        .text-area {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            resize: vertical;
            box-sizing: border-box; /* Include padding and border in width */
        }

        .pain-index-group {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
            gap: 15px; /* Space between pain index inputs */
            margin-top: 10px;
        }

        .pain-index-group > div {
            flex: 1; /* Allow items to grow */
            min-width: 150px; /* Minimum width before wrapping */
            display: flex;
            flex-direction: column;
        }
        .pain-index-group label {
            font-size: 0.9rem; /* Slightly smaller label */
            margin-bottom: 3px;
            font-weight: 400;
        }

        .pain-index-group input[type="text"] {
            width: 100%; /* Make input fill its container */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: #f9f9f9; /* Light background */
        }


        /* Range Slider Styles */
        .range-group {
            margin-top: 10px;
        }
        .range-group label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
        }
        .range-group input[type="range"] {
            width: 100%;
            -webkit-appearance: none;
            height: 10px;
            border-radius: 20px;
            background: linear-gradient(to right, #007bff, #0056b3); /* Blue gradient */
            outline: none;
            transition: background 0.3s;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 5px;
        }
        .range-group input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #ffffff; /* White thumb */
            border: 2px solid #007bff;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .range-group input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        /* Adjuvants/Medication Styles */
        .medication-group {
            display: flex;
            flex-direction: column;
            gap: 10px; /* Space between rows in medication group */
            margin-top: 10px;
        }

        .medication-row {
            display: flex;
            gap: 10px; /* Space between inputs in a row */
            align-items: center;
            flex-wrap: wrap; /* Allow wrapping on small screens */
        }
        .medication-row label {
            margin-right: auto; /* Push other elements to the right */
            margin-bottom: 0; /* Remove bottom margin */
            flex-basis: 80px; /* Give label a base width */
            flex-shrink: 0; /* Prevent label from shrinking */
        }

        .medication-row select {
            flex-grow: 1; /* Select takes available space */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            appearance: none; /* Remove default arrow */
            background-color: #f9f9f9;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }
        .medication-row input[type="text"] {
            flex-basis: 60px; /* Base width for dose/multiplicity */
            flex-grow: 1; /* Allow growing */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }
        .medication-row .dosa {
            flex-basis: 50px; /* Fixed width for unit select */
            flex-shrink: 0; /* Prevent shrinking */
        }
        .medication-row .dosa select {
            width: 100%;
            padding: 10px 5px; /* Adjust padding for smaller select */
            background-position: right 5px center; /* Adjust arrow position */
        }


        /* Button Styles */
        .button {
            padding: 12px 20px; /* Increased padding */
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease, opacity 0.3s ease;
            margin-top: 10px; /* Space above buttons */
        }
        .button:hover {
            opacity: 0.9;
        }
        .clear-button { background-color: #dc3545; color: white; } /* Danger red */
        .clear-button:hover { background-color: #c82333; }
        .calc-button { background-color: #ffc107; color: #212529; } /* Warning yellow */
        .calc-button:hover { background-color: #e0a800; }
        .send-button { background-color: #28a745; color: white; } /* Success green */
        .send-button:hover { background-color: #218838; }

    </style>
</head>
<body>
<div class="container">
    <div class="canvas-section">
        <canvas id="canvas"></canvas> <div class="face-picker">
            <div class="face-option-wrapper">
                <img class="face-option" src="img/face_0.jpg" alt="No Pain" data-color="#006400">
                <span>No Pain</span>
            </div>
            <div class="face-option-wrapper">
                <img class="face-option" src="img/face_1.jpg" alt="Very Mild Pain" data-color="#ADFF2F">
                <span>Very Mild</span>
            </div>
            <div class="face-option-wrapper">
                <img class="face-option" src="img/face_2.jpg" alt="Mild Pain" data-color="#FFFF00">
                <span>Mild Pain</span>
            </div>
            <div class="face-option-wrapper">
                <img class="face-option" src="img/face_3.jpg" alt="Moderate Pain" data-color="#FFA500">
                <span>Moderate</span>
            </div>
            <div class="face-option-wrapper">
                <img class="face-option" src="img/face_4.jpg" alt="Severe Pain" data-color="#8B4513">
                <span>Severe Pain</span>
            </div>
            <div class="face-option-wrapper">
                <img class="face-option" src="img/face_5.jpg" alt="Worst Pain" data-color="#FF0000">
                <span>Worst Pain</span>
            </div>
        </div>

        <label for="type-input">Type of Pain:</label>
        <textarea id="type-input" class="text-area" rows="3" placeholder="e.g., Sharp, dull, throbbing"></textarea>

        <label for="pain-input" style="margin-top: 15px;">Current Pain Level (Based on Face Selection):</label>
        <input type="text" id="pain-input" class="text-area" readonly placeholder="Select face above">

        <div class="pain-index-group">
            <div>
                <label for="indexPain">Pain Index:</label>
                <input type="text" id="indexPain" readonly placeholder="Calculated PI">
            </div>
            <div>
                <label for="analgeticIndexPain">Analgetic Index:</label>
                <input type="text" id="analgeticIndexPain" readonly placeholder="Calculated AI">
            </div>
            <div>
                <label for="pain_control">Pain Control Degree:</label>
                <input type="text" id="pain_control" readonly placeholder="Control status">
            </div>
        </div>

    </div>
    <div class="controls">
        <div class="control-group">
            <div class="range-group">
                <label for="ageSlider">Age: <span id="ageValue">25</span> years</label>
                <input type="range" id="ageSlider" min="10" max="100" value="25">
            </div>
            <div class="range-group">
                <label for="weightSlider">Weight: <span id="weightValue">70</span> kg</label>
                <input type="range" id="weightSlider" min="30" max="150" value="70">
            </div>
            <div class="range-group">
                <label for="heightSlider">Height: <span id="heightValue">170</span> cm</label>
                <input type="range" id="heightSlider" min="100" max="220" value="170">
            </div>
        </div>

        <div class="control-group">
            <label>Current Medications:</label>
            <div class="medication-group">
                <div class="medication-row">
                    <label for="adjuvants">Adjuvant:</label>
                    <select id="adjuvants" name="adjuvants">
                        <option value="not_selected">Not selected</option>
                        <option value="gabapentin">Gabapentin</option>
                        <option value="pregabalin">Pregabalin</option>
                        <option value="duloxetine">Duloxetine</option>
                        <option value="amitriptyline">Amitriptyline</option>
                        <option value="dexamethasone">Dexamethasone</option>
                    </select>
                    <input type="text" id="adjuvantsDose" class="adjuvantsInput" placeholder="Dose">
                    <div class="dosa">
                        <select id="adjuvantsDosa" name="adjuvantsDosa">
                            <option value="g">g</option>
                            <option value="mg">mg</option>
                            <option value="mkg">mkg</option>
                        </select>
                    </div>
                    <input type="text" id="adjuvantsInput" class="adjuvantsInput" placeholder="Times/day">
                </div>
                <div class="medication-row">
                    <label for="nsaid">NSAID:</label>
                    <select id="nsaid" name="nsaid">
                        <option value="not_selected">Not selected</option>
                        <option value="paracetamolum">Paracetamolum</option>
                        <option value="ibuprofen">Ibuprofen</option>
                        <option value="aspirin">Aspirin</option>
                        <option value="analgin">Analgin</option>
                        <option value="dexamethasone">Dexamethasone</option>
                        <option value="diclofenac">Diclofenac</option>
                        <option value="nimesulide">Nimesulide</option>
                        <option value="ketorolac">Ketorolac</option>
                    </select>
                    <input type="text" id="nsaidInput" class="adjuvantsInput" placeholder="Dose" name="nsaidInput">
                    <div class="dosa">
                        <select id="nsaidDosa" name="nsaidDosa">
                            <option value="g">g</option>
                            <option value="mg">mg</option>
                            <option value="mkg">mkg</option>
                        </select>
                    </div>
                    <input type="text" id="nsaidInputMultiplicity" class="adjuvantsInput" placeholder="Times/day">
                </div>
                <div class="medication-row">
                    <label for="weak_opioids">Weak Opioid:</label>
                    <select id="weak_opioids" name="weak_opioids">
                        <option value="not_selected">Not selected</option>
                        <option value="codeine">Codeine</option>
                        <option value="dihydrocodeine">Dihydrocodeine</option>
                        <option value="tramadol">Tramadol</option>
                    </select>
                    <input type="text" id="weak_opioidsDose" class="adjuvantsInput" placeholder="Dose">
                    <div class="dosa">
                        <select id="weak_opioidsDosa" name="weak_opioidsDosa">
                            <option value="g">g</option>
                            <option value="mg">mg</option>
                            <option value="mkg">mkg</option>
                        </select>
                    </div>
                    <input type="text" id="weak_opioidsMultiplicity" class="adjuvantsInput" placeholder="Times/day">
                </div>
                <div class="medication-row">
                    <label for="strong_opioids">Strong Opioid:</label>
                    <select id="strong_opioids" name="strong_opioids">
                        <option value="not_selected">Not selected</option>
                        <option value="morphine">Morphine</option>
                        <option value="fentanyl">Fentanyl</option>
                        <option value="oxycodone">Oxycodone</option>
                    </select>
                    <input type="text" id="strong_opioidsDose" class="adjuvantsInput" placeholder="Dose">
                    <div class="dosa">
                        <select id="strong_opioidsDosa" name="strong_opioidsDosa">
                            <option value="g">g</option>
                            <option value="mg">mg</option>
                            <option value="mkg">mkg</option>
                        </select>
                    </div>
                    <input type="text" id="strong_opioidsInputMultiplicity" class="adjuvantsInput" placeholder="Times/day">
                </div>
            </div>
        </div>

        <button class="calc-button button" id="calcButton">Calculate Metrics</button>
        <button class="send-button button" id="sendData">Send Data</button>
        <button class="clear-button button" id="clearCanvas">Clear All</button>
    </div>
</div>
<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let usedColors = new Set();
    let lineWidth = 5; // Increased line width for better visibility
    ctx.lineWidth = lineWidth;
    ctx.strokeStyle = '#006400'; // Default color (Green for No Pain)

    // --- Canvas Drawing Logic ---
    document.querySelectorAll('.face-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.face-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            ctx.strokeStyle = option.getAttribute('data-color');
            // Update pain level text immediately on face selection
            document.getElementById('pain-input').value = option.alt;
        });
    });

    let isDrawing = false;

    function resizeCanvas() {
        // Get the current displayed size of the canvas
        const rect = canvas.getBoundingClientRect();
        // Set the canvas drawing buffer size to match the display size
        canvas.width = rect.width;
        canvas.height = rect.height;
        // Restore drawing settings after resize
        ctx.lineWidth = lineWidth;
        ctx.strokeStyle = document.querySelector('.face-option.active')?.getAttribute('data-color') || '#006400'; // Restore selected color or default
        // Note: Existing drawings will be cleared on resize.
        // For persistent drawing, you would need to save and redraw paths.
    }

    // Resize canvas initially and on window resize
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);


    function startDrawing(x, y) {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(x, y);
        // Add the current stroke color to the set of used colors
        usedColors.add(ctx.strokeStyle);
    }

    function draw(x, y) {
        if (isDrawing) {
            ctx.lineTo(x, y);
            ctx.stroke();
        }
    }

    function stopDrawing() {
        isDrawing = false;
        ctx.closePath();
    }

    function getRelativePos(canvas, event) {
        const rect = canvas.getBoundingClientRect();
        let x, y;

        if (event.touches) {
            x = (event.touches[0].clientX - rect.left) * (canvas.width / rect.width);
            y = (event.touches[0].clientY - rect.top) * (canvas.height / rect.height);
        } else {
            x = (event.clientX - rect.left) * (canvas.width / rect.width);
            y = (event.clientY - rect.top) * (canvas.height / rect.height);
        }
        return { x, y };
    }

    canvas.addEventListener('mousedown', (e) => {
        e.preventDefault();
        const pos = getRelativePos(canvas, e);
        startDrawing(pos.x, pos.y);
    });

    canvas.addEventListener('mousemove', (e) => {
        if (isDrawing) {
            const pos = getRelativePos(canvas, e);
            draw(pos.x, pos.y);
        }
    });

    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseleave', stopDrawing);

    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        const pos = getRelativePos(canvas, e);
        startDrawing(pos.x, pos.y);
    });

    canvas.addEventListener('touchmove', (e) => {
        e.preventDefault();
        const pos = getRelativePos(canvas, e);
        draw(pos.x, pos.y);
    });

    canvas.addEventListener('touchend', stopDrawing);

    // --- Color Mapping and Coefficients (Simplified for RGB) ---
    // Function to convert hex to rgb string
    function hexToRgb(hex) {
        const bigint = parseInt(hex.slice(1), 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
        return `rgb(${r}, ${g}, ${b})`;
    }

    // Map face colors (hex) to friendly names and coefficients
    const colorInfo = {
        '#006400': { name: 'No Pain (Green)', coefficient: 1, level: 'No Pain' },
        '#ADFF2F': { name: 'Very Mild Pain (Lime Green)', coefficient: 2, level: 'Very Mild Pain' },
        '#FFFF00': { name: 'Mild Pain (Yellow)', coefficient: 3, level: 'Mild Pain' },
        '#FFA500': { name: 'Moderate Pain (Orange)', coefficient: 4, level: 'Moderate Pain' },
        '#8B4513': { name: 'Severe Pain (Brown)', coefficient: 5, level: 'Severe Pain' },
        '#FF0000': { name: 'Worst Pain (Red)', coefficient: 6, level: 'Worst Pain' },
    };

    // Convert hex keys to rgb keys for lookup based on getImageData
    const colorInfoRgb = {};
    for (const hex in colorInfo) {
        colorInfoRgb[hexToRgb(hex)] = colorInfo[hex];
    }


    function calculateDrawnArea(canvas) {
        const ctx = canvas.getContext('2d');
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;
        const totalPixels = canvas.width * canvas.height;
        const colorPixels = {};
        const drawnPixels = new Set(); // To count only the pixels we drew on

        // Iterate over pixels
        for (let i = 0; i < data.length; i += 4) {
            const r = data[i];
            const g = data[i + 1];
            const b = data[i + 2];
            const a = data[i + 3];

            // Check if the pixel is not fully transparent (part of drawing)
            // and not the original background color (if applicable, though with clearRect it's transparent)
            // and is one of our drawing colors
            const color = `rgb(${r}, ${g}, ${b})`;
            if (a > 0 && colorInfoRgb[color]) {
                // Use a string representation of the pixel coordinates as a unique identifier
                const pixelKey = `${i/4}`;
                if (!drawnPixels.has(pixelKey)) {
                    colorPixels[color] = (colorPixels[color] || 0) + 1;
                    drawnPixels.add(pixelKey);
                }
            }
        }

        const colorPercentages = {};
        const totalDrawnPixels = drawnPixels.size;

        if (totalDrawnPixels === 0) {
            // No drawing was made
            return {};
        }

        for (const color in colorPixels) {
            // Calculate percentage based on the total *drawn* pixels, not total canvas pixels
            colorPercentages[color] = (colorPixels[color] / totalDrawnPixels) * 100;
        }

        return colorPercentages;
    }


    function updatePainMetrics() {
        const colorPercentages = calculateDrawnArea(canvas);
        console.log("Color percentage ratio:", colorPercentages);

        let totalWeightedArea = 0;
        let highestCoefficient = 0;
        let calculatedPainLevel = 'No Pain'; // Default

        // Find the highest coefficient among the drawn colors
        for (const colorRgb in colorPercentages) {
            const info = colorInfoRgb[colorRgb];
            if (info && colorPercentages[colorRgb] > 0) { // Ensure color was actually drawn
                if (info.coefficient > highestCoefficient) {
                    highestCoefficient = info.coefficient;
                    calculatedPainLevel = info.level; // Update based on the color with the highest coefficient
                }
            }
        }

        // Calculate total weighted area using the coefficients of drawn colors
        for (const colorRgb in colorPercentages) {
            const info = colorInfoRgb[colorRgb];
            if (info) {
                const percentage = colorPercentages[colorRgb];
                const coefficient = info.coefficient;
                const weightedArea = (percentage / 100) * coefficient; // Use percentage as a fraction of the drawn area
                totalWeightedArea += weightedArea;
            }
        }


        // Update input fields
        document.getElementById('indexPain').value = totalWeightedArea.toFixed(2);
        // Set the pain level based on the color with the highest coefficient drawn
        document.getElementById('pain-input').value = calculatedPainLevel;

        calculateAnalgeticIndex(); // Also calculate analgesic index when pain metrics are updated
    }


    // --- Analgetic Index and Pain Control Calculation (Simplified) ---
    function calculateAnalgeticIndex(){
        // Retrieve selected medications and doses
        const adjuvantDrug = document.getElementById('adjuvants').value;
        const adjuvantDoseValue = parseFloat(document.getElementById('adjuvantsDose').value) || 0;
        const adjuvantMultiplicity = parseFloat(document.getElementById('adjuvantsInput').value) || 0; // Assuming "Times/day" means frequency per day

        const nsaidDrug = document.getElementById('nsaid').value;
        const nsaidDoseValue = parseFloat(document.getElementById('nsaidInput').value) || 0;
        const nsaidMultiplicity = parseFloat(document.getElementById('nsaidInputMultiplicity').value) || 0;

        const weakOpioidsDrug = document.getElementById('weak_opioids').value;
        const weakOpioidsDoseValue = parseFloat(document.getElementById('weak_opioidsDose').value) || 0;
        const weakOpioidsMultiplicity = parseFloat(document.getElementById('weak_opioidsMultiplicity').value) || 0;

        const strongOpioidsDrug = document.getElementById('strong_opioids').value;
        const strongOpioidsDoseValue = parseFloat(document.getElementById('strong_opioidsDose').value) || 0;
        const strongOpioidsMultiplicity = parseFloat(document.getElementById('strong_opioidsInputMultiplicity').value) || 0;


        // Determine Analgetic Index based on medication combination (Simplified Logic)
        let analgeticIndex = 'N/A'; // Not Applicable by default

        const isAdjuvantSelected = adjuvantDrug !== 'not_selected' && adjuvantDoseValue > 0 && adjuvantMultiplicity > 0;
        const isNsaidSelected = nsaidDrug !== 'not_selected' && nsaidDoseValue > 0 && nsaidMultiplicity > 0;
        const isWeakOpioidSelected = weakOpioidsDrug !== 'not_selected' && weakOpioidsDoseValue > 0 && weakOpioidsMultiplicity > 0;
        const isStrongOpioidSelected = strongOpioidsDrug !== 'not_selected' && strongOpioidsDoseValue > 0 && strongOpioidsMultiplicity > 0;

        if (isAdjuvantSelected && isNsaidSelected) {
            if (isStrongOpioidSelected) {
                analgeticIndex = '>80%'; // Corresponds to Step 3 (Strong Opioid + Adjuvant + NSAID)
            } else if (isWeakOpioidSelected) {
                analgeticIndex = '50%-70%'; // Corresponds to Step 2 (Weak Opioid + Adjuvant + NSAID)
            } else {
                analgeticIndex = '30%'; // Corresponds to Step 1 (Adjuvant + NSAID only)
            }
        } else if (isAdjuvantSelected || isNsaidSelected) {
            // If only one of Adjuvant or NSAID is selected (and others are not strong/weak opioids)
            if (!isWeakOpioidSelected && !isStrongOpioidSelected) {
                analgeticIndex = '<30%'; // Less coverage with just one type + no opioids
            } else if (isWeakOpioidSelected && !isStrongOpioidSelected) {
                analgeticIndex = '40%-60%'; // Weak Opioid + one of Adjuvant/NSAID
            } else if (isStrongOpioidSelected) {
                analgeticIndex = '70%-80%'; // Strong Opioid + one of Adjuvant/NSAID
            }
        } else if (isWeakOpioidSelected && !isStrongOpioidSelected) {
            analgeticIndex = '20%-40%'; // Only Weak Opioid
        } else if (isStrongOpioidSelected) {
            analgeticIndex = '60%-70%'; // Only Strong Opioid
        }


        document.getElementById('analgeticIndexPain').value = analgeticIndex;

        // Determine Pain Control Degree (Simplified Logic based on Morphine Equivalence)
        let painControl = 'Controlled Pain'; // Default

        // This is a very basic example. A real calculation requires a comprehensive OMEDD conversion table.
        // Example: If daily oral morphine equivalent is high (> 60mg/day, a common threshold),
        // and pain is still significant, it might indicate uncontrolled pain.
        // This requires converting ALL opioid doses (and potentially other drugs) to OMEDD.
        // For this example, let's just check for a high dose of oral morphine as a simplified indicator.
        const totalOralMorphineMgPerDay = (strongOpioidsDrug === 'morphine' && document.getElementById('strong_opioidsDosa').value === 'mg') ?
            (strongOpioidsDoseValue * strongOpioidsMultiplicity) : 0;

        // You would add similar calculations for other opioids and routes (e.g., Fentanyl patch, IV Morphine)
        // using appropriate conversion factors to get a total OMEDD.

        // Simplified check: If high dose oral morphine AND high pain level selected
        const currentPainLevel = document.getElementById('pain-input').value;
        const highPainLevels = ['Severe Pain', 'Worst Pain', 'Very Severe Pain', 'Moderate Pain']; // Consider which levels indicate potential uncontrolled pain

        if (totalOralMorphineMgPerDay > 60 && highPainLevels.includes(currentPainLevel)) {
            painControl = 'Potentially Uncontrolled Pain'; // Indicate potential issue
        } else if (totalOralMorphineMgPerDay > 60) {
            painControl = 'High Dose Opioids'; // Indicate high dose even if pain is controlled
        }
        // Add other logic based on other medication combinations and pain levels

        document.getElementById('pain_control').value = painControl;
    }


    // --- Event Listeners ---
    document.getElementById('clearCanvas').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        usedColors.clear();
        document.getElementById('type-input').value = '';
        document.getElementById('pain-input').value = '';
        document.getElementById('indexPain').value = '';
        document.getElementById('analgeticIndexPain').value = '';
        document.getElementById('pain_control').value = '';

        // Reset face selection visual
        document.querySelectorAll('.face-option').forEach(opt => opt.classList.remove('active'));
        ctx.strokeStyle = '#006400'; // Reset stroke color to default

        // Reset medication selects and inputs
        document.querySelectorAll('.medication-group select').forEach(select => {
            select.value = 'not_selected';
        });
        document.querySelectorAll('.medication-group input[type="text"]').forEach(input => {
            input.value = '';
        });
        document.querySelectorAll('.medication-group .dosa select').forEach(select => {
            select.value = 'mg'; // Reset dose unit to mg
        });

        // Reset sliders to default values
        document.getElementById('ageSlider').value = 25;
        document.getElementById('ageValue').textContent = 25;
        document.getElementById('weightSlider').value = 70;
        document.getElementById('weightValue').textContent = 70;
        document.getElementById('heightSlider').value = 170;
        document.getElementById('heightValue').textContent = 170;
    });

    document.getElementById('calcButton').addEventListener('click', updatePainMetrics);


    document.getElementById('ageSlider').addEventListener('input', function() {
        document.getElementById('ageValue').textContent = this.value;
    });

    document.getElementById('weightSlider').addEventListener('input', function() {
        document.getElementById('weightValue').textContent = this.value;
    });

    document.getElementById('heightSlider').addEventListener('input', function() {
        document.getElementById('heightValue').textContent = this.value;
    });

    // Add event listeners to medication inputs/selects to trigger analgesic calculation
    document.querySelectorAll('.medication-group select, .medication-group input[type="text"]').forEach(element => {
        element.addEventListener('change', calculateAnalgeticIndex); // Use 'change' event
        element.addEventListener('input', calculateAnalgeticIndex); // Also use 'input' for text fields
    });


    document.getElementById('sendData').addEventListener('click', () => {
        // Ensure metrics are calculated before sending
        updatePainMetrics(); // This also calls calculateAnalgeticIndex

        const canvasData = canvas.toDataURL();
        const painLevel = document.getElementById('pain-input').value;
        const analgeticIndexPain = document.getElementById('analgeticIndexPain').value;
        const pain_control = document.getElementById('pain_control').value;
        const painIndex =document.getElementById('indexPain').value;
        const age =document.getElementById('ageSlider').value;
        const weight =document.getElementById('weightSlider').value;
        const height =document.getElementById('heightSlider').value;
        const typePain = document.getElementById('type-input').value;

        // Collect medication data
        const medications = {
            adjuvant: {
                drug: document.getElementById('adjuvants').value,
                dose: document.getElementById('adjuvantsDose').value,
                unit: document.getElementById('adjuvantsDosa').value,
                multiplicity: document.getElementById('adjuvantsInput').value
            },
            nsaid: {
                drug: document.getElementById('nsaid').value,
                dose: document.getElementById('nsaidInput').value,
                unit: document.getElementById('nsaidDosa').value,
                multiplicity: document.getElementById('nsaidInputMultiplicity').value
            },
            weak_opioid: {
                drug: document.getElementById('weak_opioids').value,
                dose: document.getElementById('weak_opioidsDose').value,
                unit: document.getElementById('weak_opioidsDosa').value,
                multiplicity: document.getElementById('weak_opioidsMultiplicity').value
            },
            strong_opioid: {
                drug: document.getElementById('strong_opioids').value,
                dose: document.getElementById('strong_opioidsDose').value,
                unit: document.getElementById('strong_opioidsDosa').value,
                multiplicity: document.getElementById('strong_opioidsInputMultiplicity').value
            }
        };


        fetch('/save-level-pain', { // Ensure this is the correct endpoint
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                image: canvasData,
                pain_level: painLevel,
                analgeticIndexPain: analgeticIndexPain,
                pain_control: pain_control,
                painIndex: painIndex,
                age: age,
                weight: weight,
                height: height,
                typePain: typePain,
                medications: medications // Include medication data
            })
        }).then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        }).then(data => {
            console.log('Success:', data);
            alert('Data saved successfully!');
        }).catch(error => {
            console.error('Error sending data:', error);
            alert('Failed to save data. Check console for details.');
        });
    });

    // Initial calculation on page load (optional, depends on desired behavior)
    // updatePainMetrics(); // Calculate on load if canvas might have initial state or default values

</script>
</body>
</html>
