<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pain Level</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Изменено на min-height */
            margin: 0;
            background: linear-gradient(135deg, #eef2ff, #c3dafe);
            overflow: auto;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr; /* 1 колонка на мобильных */
            gap: 20px;
            background: white;
            box-shadow: 0 25px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 15px; /* Уменьшен отступ */
            width: 95%;
            max-width: 1600px;
            box-sizing: border-box;
            margin: 10px; /* Уменьшен отступ */
        }
        @media (min-width: 768px) {
            .container {
                grid-template-columns: 4fr 4fr; /* 2 колонки на десктопе */
                gap: 40px;
                padding: 20px;
                margin: 20px;
            }
        }
        .canvas-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        canvas {
            border: 1px solid #444;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: url('img/chelovek.jpg');
            background-size: cover;
            touch-action: none;
            width: 100%;
            height: auto;
            aspect-ratio: 2 / 1.5;
        }
        .controls {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 700px; /* Задайте желаемую высоту */
            overflow-y: auto;
        }

        .text-area {
            width: 100%;
            padding: 8px; /* Уменьшен отступ */
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            text-align: center;
            resize: vertical;
        }
        .face-picker {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        .face-picker span {
            font-size: 14px;
            margin-top: 8px;
            color: #333;
            font-weight: 500;
            text-align: center;
            padding: 5px 10px;
            background-color: #f0f0f0;
            border-radius: 15px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .face-option {
            width: 50px;
            height: 50px;
            cursor: pointer;
            border-radius: 50%;
            border: 2px solid transparent;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .face-option:hover, .face-option.active {
            transform: scale(1.1);
            border-color: #444;
        }
        .button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }
        .clear-button { background-color: #ff4d4d; color: white; }
        .clear-button:hover { background-color: #cc0000; }
        .calc-button { background-color: #978e52; color: white; }
        .calc-button:hover { background-color: #897b44; }
        .send-button { background-color: #4CAF50; color: white; }
        .send-button:hover { background-color: #388E3C; }
        .controls label {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        .controls input[type="range"] {
            width: 100%;
            -webkit-appearance: none;
            height: 10px;
            border-radius: 20px;
            background: linear-gradient(to right, #ddd, #eee);
            outline: none;
            transition: background 0.3s;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .controls input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .controls input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .indexPain{
            height: 35px;
            border-radius: 7px;
        }
        /* Modern стили для select и input в одну линию */
        .adjuvants {
            display: flex;
            align-items: center;
            gap: 10px; /* Добавляем расстояние между select и input */
        }

        .adjuvants label {
            font-size: 16px;
            font-weight: bold;
            margin-right: 10px; /* Отступ справа от label */
        }

        .adjuvants select {
            appearance: none;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            font-size: 1rem;
            color: #333;
            cursor: pointer;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            flex-grow: 1; /* Селект занимает большую часть места */
            flex-shrink: 1;
            min-width: 0;
            width: 85%; /* Занимает 90% ширины */
        }

        .adjuvants select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .adjuvants select::-ms-expand {
            display: none;
        }
        .dosa{
            width: 30%;
        }

       .adjuvants input.adjuvantsInput {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            font-size: 1rem;
            color: #333;
            width: 15%;
            flex-grow: 1; /* Инпут может занимать оставшееся место */
            flex-shrink: 0;
        }

        .adjuvants input.adjuvantsInput:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        /* Конец стилей для select и input */
    </style>
</head>
<body>
<div class="container">
    <div class="canvas-container">
        <canvas id="canvas" width="300" height="800"></canvas>
        <div class="face-picker">
            <div style="display: flex; flex-direction: column; align-items: center;">
                <img class="face-option" src="img/face_0.jpg" alt="No Pain" data-color="#006400">
                <span>No Pain</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center;">
                <img class="face-option" src="img/face_1.jpg" alt="Mild Pain" data-color="#ADFF2F">
                <span>Mild Pain</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center;">
                <img class="face-option" src="img/face_2.jpg" alt="Moderate Pain" data-color="#FFFF00">
                <span>Moderate Pain</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center;">
                <img class="face-option" src="img/face_3.jpg" alt="Severe Pain" data-color="#FFA500">
                <span>Severe Pain</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center;">
                <img class="face-option" src="img/face_4.jpg" alt="Very Severe Pain" data-color="#8B4513">
                <span>Very Severe Pain</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center;">
                <img class="face-option" src="img/face_5.jpg" alt="Worst Pain" data-color="#FF0000">
                <span>Worst Pain</span>
            </div>
            <label for="typePain">Type of Pain:</label>
            <textarea id="type-input" class="text-area"></textarea>
            <label for="levelPain">Level Pain:</label>
            <textarea id="pain-input" class="text-area">No Pain</textarea>
            <label for="indexPain">Index Pain:</label>
            <input id="indexPain" class="indexPain">
        </div>
    </div>
    <div class="controls">
        <label for="ageSlider">Age: <span id="ageValue">25</span> years</label>
        <input type="range" id="ageSlider" min="10" max="100" value="25">
        <label for="weightSlider">Weight: <span id="weightValue">70</span> kg</label>
        <input type="range" id="weightSlider" min="30" max="150" value="70">
        <label for="heightSlider">Height: <span id="heightValue">170</span> cm</label>
        <input type="range" id="heightSlider" min="100" max="220" value="170">
        <label for="adjuvants">Select Adjuvant:</label>
        <div class="adjuvants">
            <select id="adjuvants" name="adjuvants">
                <option value="not_selected">Not selected</option>
                <option value="gabapentin">Gabapentin</option>
                <option value="pregabalin">Pregabalin</option>
                <option value="duloxetine">Duloxetine</option>
                <option value="amitriptyline">Amitriptyline</option>
                <option value="dexamethasone">Dexamethasone</option>
            </select>
            <input id="adjuvantsDose" class="adjuvantsInput" placeholder="Dose">
            <div class="dosa">
                <select id="adjuvantsDosa" name="adjuvantsDosa" class="adjuvantsDosa">
                    <option value="g">g</option>
                    <option value="mg">mg</option>
                    <option value="mkg">mkg</option>
                </select>
            </div>
            <input id="adjuvantsInput" class="adjuvantsInput" placeholder="Multiplicity">
        </div>
        <label for="adjuvants">NSAID:</label>
        <div class="adjuvants">
            <select id="nsaid" name="nsaid">
                <option value="not_selected">Not selected</option>
                <option value="paracetamolum">Paracetamolum</option>
                <option value="ibuprofen">Ibuprofen</option>
                <option value="aspirin">Aspirin</option>
                <option value="analgin">Analgin</option>
                <option value="dexamethasone">Dexamethasone</option>
                <option value="diclofenac">Diclofenac</option>
                <option value="nimesulide">Nimesulide</option>
                <option value="dexamethasone">Dexamethasone</option>
                <option value="ketorolac">Ketorolac</option>
            </select>
            <input id="nsaidInput" class="adjuvantsInput" placeholder="Dose" name="nsaidInput">
            <div class="dosa">
                <select id="nsaidDosa" name="nsaidDosa" class="adjuvantsDosa">
                    <option value="g">g</option>
                    <option value="mg">mg</option>
                    <option value="mkg">mkg</option>
                </select>
            </div>
            <input id="nsaidInputMultiplicity" class="adjuvantsInput" placeholder="Multiplicity">
        </div>
        <label for="adjuvants">Weak opioids:</label>
        <div class="adjuvants">
            <select id="weak_opioids" name="weak_opioids">
                <option value="not_selected">Not selected</option>
                <option value="codeine">Codeine</option>
                <option value="dihydrocodeine">Dihydrocodeine</option>
                <option value="tramadol">Tramadol</option>
            </select>
            <input id="weak_opioidsDose" class="adjuvantsInput" placeholder="Dose">
            <div class="dosa">
                <select id="weak_opioidsDosa" name="weak_opioidsDosa" class="adjuvantsDosa">
                    <option value="g">g</option>
                    <option value="mg">mg</option>
                    <option value="mkg">mkg</option>
                </select>
            </div>
            <input id="weak_opioidsMultiplicity" class="adjuvantsInput" placeholder="Multiplicity">
        </div>
        <label for="adjuvants">Strong opioids:</label>
        <div class="adjuvants">
            <select id="strong_opioids" name="strong_opioids">
                <option value="not_selected">Not selected</option>
                <option value="morphine">Morphine</option>
                <option value="fentanyl">Fentanyl</option>
                <option value="oxycodone ">Oxycodone </option>
            </select>
            <input id="strong_opioidsDose" class="adjuvantsInput" placeholder="Dose">
            <div class="dosa">
                <select id="strong_opioidsDosa" name="strong_opioidsDosa" class="adjuvantsDosa">
                    <option value="g">g</option>
                    <option value="mg">mg</option>
                    <option value="mkg">mkg</option>
                </select>
            </div>
            <input id="strong_opioidsInputMultiplicity" class="adjuvantsInput" placeholder="Multiplicity">
        </div>
        <button class="clear-button button" id="clearCanvas">Clear</button>
        <button class="calc-button button" id="calcButton">Calc Pain</button>
        <button class="send-button button" id="sendData">Send Data</button>
    </div>
</div>
<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let usedColors = new Set();
    let lineWidth = 2; // Толщина линии по умолчанию
    ctx.lineWidth = lineWidth;
    ctx.strokeStyle = '#006400'; // Зеленый цвет по умолчанию


    document.querySelectorAll('.face-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.face-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            ctx.strokeStyle = option.getAttribute('data-color');
        });
    });

    let isDrawing = false;

    function startDrawing(x, y) {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(x, y);
        usedColors.add(ctx.strokeStyle);
    }
    function updatePainInput() {
        let level=usedColors;
        const colorPercentages = calculateDrawnArea(canvas);
        console.log("Процентное соотношение цветов:", colorPercentages);

        let message = "Color percentage ratio:\n";
        let totalWeightedArea = 0; // Сумма произведений


        if (level.has("#ff0000")) { // Красный - шестой приоритет
            level = new Set(["#ff0000"]);
        } else if (level.has("#8b4513")) { // Коричневый - самый высокий приоритет
            level = new Set(["#8b4513"]);
        } else if (level.has("#ffa500")) { // Желтый - четвертый приоритет
            level = new Set(["#ffa500"]);
        } else if (level.has("#ffff00")) { // Желтый - четвертый приоритет
            level = new Set(["#ffff00"]);
        } else if (level.has("#adff2f")) { // Оранжевый - пятый приоритет
            level = new Set(["#adff2f"]);
        } else if (level.has("#006400")) { // Красный - шестой приоритет
            level = new Set(["#006400"]);
        }
        const myArray = Array.from(level);
        levelPain = myArray[0];
        if (levelPain  === "#ff0000") { // Красный - шестой приоритет
            level = 'Very severe or unbearable pain';
            document.getElementById('pain-input').value=level
        } else if (levelPain==="#8b4513") { // Коричневый - самый высокий приоритет
            level = 'Severe pain';
            document.getElementById('pain-input').value=level
        } else if (levelPain==="#ffa500") { // Желтый - четвертый приоритет
            level = 'Moderate pain';
            document.getElementById('pain-input').value=level
        } else if (levelPain==="#ffff00") { // Желтый - четвертый приоритет
            level = 'Mild pain';
            document.getElementById('pain-input').value=level
        } else if (levelPain==="#adff2f") { // Оранжевый - пятый приоритет
            level = 'Very mild pain';
            document.getElementById('pain-input').value=level
        } else { // Красный - шестой приоритет
            level = 'No pain';
            document.getElementById('pain-input').value=level
        }
        console.log(level)

        for (const color in colorPercentages) {
            const colorName = colorNames[color];
            const percentage = colorPercentages[color];
            const coefficient = colorCoefficients[color];
            const weightedArea = percentage * coefficient;

            totalWeightedArea += weightedArea;
            message += `${colorName}: ${percentage.toFixed(2)}%, product: ${weightedArea.toFixed(2)}\n`;
        }

        message += `Total weighted area: ${totalWeightedArea.toFixed(2)}`;
        document.getElementById('indexPain').value=totalWeightedArea.toFixed(2);
        // alert(message);


        return level; // Возвращаем level для дальнейшего использования
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
            // Сенсорный ввод
            x = (event.touches[0].clientX - rect.left) * (canvas.width / rect.width);
            y = (event.touches[0].clientY - rect.top) * (canvas.height / rect.height);
        } else {
            // Мышь
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


    document.getElementById('clearCanvas').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        usedColors.clear();
        document.getElementById('pain-input').value='';
        document.getElementById('medications').value='';
        document.getElementById('indexPain').value='';
    });
    document.getElementById('calcButton').addEventListener('click', () => {
        updatePainInput()
    });
    document.getElementById('ageSlider').addEventListener('input', function() {
        document.getElementById('ageValue').textContent = this.value;
    });

    document.getElementById('weightSlider').addEventListener('input', function() {
        document.getElementById('weightValue').textContent = this.value;
    });

    document.getElementById('heightSlider').addEventListener('input', function() {
        document.getElementById('heightValue').textContent = this.value;
    });
    function calculateDrawnArea(canvas) {
        const ctx = canvas.getContext('2d');
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;
        const totalPixels = canvas.width * canvas.height;
        const colorPixels = {};

        for (let i = 0; i < data.length; i += 4) {
            const r = data[i];
            const g = data[i + 1];
            const b = data[i + 2];
            const a = data[i + 3];

            if (a !== 0 && (r !== 255 || g !== 255 || b !== 255)) {
                const color = `rgb(${r}, ${g}, ${b})`;
                if (colorNames[color]) {
                    colorPixels[color] = (colorPixels[color] || 0) + 1;
                }
            }
        }

        const colorPercentages = {};
        for (const color in colorPixels) {
            colorPercentages[color] = (colorPixels[color] / totalPixels) * 100;
        }

        return colorPercentages;
    }

    const colorNames = {
        'rgb(0, 100, 0)': 'Green',
        'rgb(173, 255, 47)': 'Lime Green',
        'rgb(255, 255, 0)': 'Yellow',
        'rgb(255, 165, 0)': 'Orange',
        'rgb(139, 69, 19)': 'Brown',
        'rgb(255, 0, 0)': 'Red',
        // Add other colors if needed
    };

    const colorCoefficients = {
        'rgb(0, 100, 0)': 1, // Пример коэффициента для зеленого
        'rgb(173, 255, 47)': 2, // Пример коэффициента для салатового
        'rgb(255, 255, 0)': 3, // Пример коэффициента для желтого
        'rgb(255, 165, 0)': 4, // Пример коэффициента для оранжевого
        'rgb(139, 69, 19)': 5, // Пример коэффициента для коричневого
        'rgb(255, 0, 0)': 6, // Пример коэффициента для красного
        // Добавьте коэффициенты для других цветов
    };

    document.getElementById('calcButton').addEventListener('click', () => {
        updatePainInput();

    });



    document.getElementById('sendData').addEventListener('click', () => {
        updatePainInput()
        const canvasData = canvas.toDataURL();
        const painLevel = document.getElementById('pain-input').value;
        const medications = document.getElementById('medications').value;
        const painIndex =document.getElementById('indexPain').value;
        const age =document.getElementById('ageSlider').value;
        const weight =document.getElementById('weightSlider').value;
        const height =document.getElementById('heightSlider').value;
        const typePain = document.getElementById('type-input').value;
        const adjuvantsSelect = document.getElementById('adjuvants').value;
        const adjuvantsInput = document.getElementById('adjuvantsInput').value;

        fetch('/save-level-pain', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                image: canvasData,
                pain_level: painLevel,
                medications: medications,
                painIndex:painIndex,
                age:age,
                weight:weight,
                height:height,
                typePain:typePain,
                adjuvantsSelect: adjuvantsSelect,
                adjuvantsInput: adjuvantsInput
            })
        }).then(response => response.json()).then(data => {
            alert('Data saved successfully!');
        }).catch(error => console.error('Error:', error));
    });


    //Treatment


    document.getElementById('calcButton').addEventListener('click', function() {
        // --- Get values for Adjuvants ---
        const adjuvantDrug = document.getElementById('adjuvants').value;
        const adjuvantDoseValue = document.getElementById('adjuvantsDose').value;
        const adjuvantDoseUnit = document.getElementById('adjuvantsDosa').value;
        const adjuvantMultiplicity = document.getElementById('adjuvantsInput').value;

        // --- Get values for NSAID ---
        const nsaidDrug = document.getElementById('nsaid').value;
        const nsaidDoseValue = document.getElementById('nsaidInput').value;
        const nsaidDoseUnit = document.getElementById('nsaidDosa').value;
        const nsaidMultiplicity = document.getElementById('nsaidInputMultiplicity').value;

        // --- Get values for Weak opioids ---
        const weakOpioidsDrug = document.getElementById('weak_opioids').value;
        const weakOpioidsDoseValue = document.getElementById('weak_opioidsDose').value;
        const weakOpioidsDoseUnit = document.getElementById('weak_opioidsDosa').value;
        const weakOpioidsMultiplicity = document.getElementById('weak_opioidsMultiplicity').value;

        // --- Get values for Strong opioids ---
        const strongOpioidsDrug = document.getElementById('strong_opioids').value;
        const strongOpioidsDoseValue = document.getElementById('strong_opioidsDose').value;
        const strongOpioidsDoseUnit = document.getElementById('strong_opioidsDosa').value;
        const strongOpioidsMultiplicity = document.getElementById('strong_opioidsInputMultiplicity').value;

        // --- Log all collected values ---
        // (Logging code omitted for brevity - keep the previous logging code here)
        console.log('--- Collected Data ---');
        // ... (previous console.log statements for Adjuvant, NSAID, Weak, Strong) ...
        console.log('----------------------');


        // --- CORRECTED Combination Logic A/B/C ---
        const isAdjuvantSelected = adjuvantDrug !== 'not_selected';
        const isNsaidSelected = nsaidDrug !== 'not_selected';
        const isWeakOpioidSelected = weakOpioidsDrug !== 'not_selected';
        const isStrongOpioidSelected = strongOpioidsDrug !== 'not_selected';

        console.log('--- Combination Logic ---');

        // First, check the base requirement: Adjuvant and NSAID must be selected for A, B, or C
        if (isAdjuvantSelected && isNsaidSelected) {

            // Condition for 'B': Weak selected, Strong NOT selected
            if (isWeakOpioidSelected && !isStrongOpioidSelected) {
                console.log('Combination Code: B'); // <<< CORRECTED TO B
            }
            // Condition for 'C': Strong selected, Weak NOT selected
            else if (isStrongOpioidSelected) {
                console.log('Combination Code: C');
            }
            // Condition for 'A': NEITHER Weak NOR Strong selected
            else if (!isWeakOpioidSelected && !isStrongOpioidSelected) {
                console.log('Combination Code: A');
            }
            // Handle other cases within Adjuvant+NSAID (e.g., BOTH Weak and Strong selected)
            else {
                console.log('Combination Code: Undefined (e.g., both Weak and Strong selected, or other state)');
            }

        } else {
            // Adjuvant or NSAID (or both) not selected
            console.log('Combination Code: Base conditions (Adjuvant + NSAID) not met.');
        }
        console.log('-----------------------');


        // --- Optional: Display data on page ---
        // ... (previous examples for alert or DOM manipulation) ...

    });
</script>
</body>
</html>
