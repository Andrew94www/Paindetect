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

        @media (min-width: 992px) {
            /* Adjusted breakpoint for larger screens */
            .container {
                grid-template-columns: 1fr 1fr; /* 2 columns on desktop */
            }
        }

        /* Canvas Section */
        .canvas-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px; /* Add some padding */
            border-radius: 15px;
            background-color: #f8f9fa; /* Light background */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            /* Можливо, також потрібен скрол, якщо додаватиметься багато інпутів під канвасом */
            /* max-height: 80vh; */ /* Приклад обмеження висоти */
            /* overflow-y: auto; */ /* Додати скрол, якщо розкоментувати max-height */
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

        /* Wrapper for Controls and Buttons */
        .controls-wrapper {
            display: flex;
            flex-direction: column; /* Розташовуємо вміст вертикально */
            gap: 15px; /* Відступ між блоком прокрутки та кнопками */
            /* Додаємо ті ж стилі фону/тіні, що були у .controls */
            padding: 15px;
            border-radius: 15px;
            background-color: #f8f9fa;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
        }


        /* Controls Section (Scrollable) */
        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Space between control groups */
            /* Видаляємо background, padding, border-radius, box-shadow звідси, бо вони тепер у controls-wrapper */
            padding: 0; /* Важливо скинути внутрішній відступ */

            max-height: 70vh; /* Обмежуємо максимальну висоту для прокрутки */
            overflow-y: auto; /* Додаємо вертикальну прокрутку при необхідності */
            flex-grow: 1; /* Дозволяє цьому блоку займати доступний простір */
        }

        /* Додаткові стилі для смуги прокрутки (за бажанням) */
        .controls::-webkit-scrollbar {
            width: 8px;
        }

        .controls::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .controls::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .controls::-webkit-scrollbar-thumb:hover {
            background: #555;
        }


        .control-group {
            border: 1px solid #e0e0e0; /* Optional: Group border */
            border-radius: 10px;
            padding: 15px;
            background-color: #ffffff; /* White background for groups */
        }

        .controls label, .canvas-section label { /* Застосовуємо стиль до обох секцій */
            font-size: 1rem; /* Standard font size */
            font-weight: 500; /* Medium weight */
            color: #333;
            margin-bottom: 5px; /* Space below label */
            display: block; /* Make label a block element */
        }

        .text-area, .canvas-section input[type="text"],
        .canvas-section select, .canvas-section input[type="number"] { /* Додаємо стилі для нових інпутів/селектів */
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            resize: vertical;
            box-sizing: border-box; /* Include padding and border in width */
            background-color: #f9f9f9; /* Light background */
        }

        .canvas-section input[type="text"][readonly] {
            background-color: #e9ecef; /* Сірий фон для полів тільки для читання */
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
        .button-group {
            display: flex; /* Use Flexbox */
            gap: 10px; /* Space between buttons */
            margin-top: 15px; /* Space above the button group */
            padding-top: 15px; /* Додаємо відступ зверху */
            border-top: 1px solid #e0e0e0; /* Додаємо лінію розділення */
            flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
            justify-content: center; /* Центруємо кнопки */
            /* Видаляємо фон/тінь/відступи, бо вони тепер у controls-wrapper */
            padding: 0;
            background-color: transparent;
            box-shadow: none;
            border-radius: 0;
        }

        .button {
            padding: 12px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease, opacity 0.3s ease;
            /* Вирівнювання та розмір кнопок у рядку */
            flex-grow: 1; /* Дозволяє кнопкам розтягуватись */
            flex-shrink: 0; /* Запобігає сильному стисненню */
            min-width: 120px; /* Мінімальна ширина перед перенесенням */
            max-width: 200px; /* Максимальна ширина для кнопок на широких екранах */
            margin-top: 0; /* Видаляємо верхній відступ */
        }

        .medication-row,
        .medication-details,
        .calculation-section {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            display: flex; /* Use flexbox for better alignment */
            align-items: center;
            flex-wrap: wrap; /* Allow items to wrap on smaller screens */
        }

        .medication-row:last-child,
        .medication-details:last-child,
        .calculation-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }


        label {
            display: block; /* Make labels block elements */
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
            min-width: 120px; /* Give labels a minimum width */
            margin-right: 10px;
        }

        select,
        input[type="number"],
        input[type="text"] {
            flex-grow: 1; /* Allow inputs/selects to take up available space */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 10px; /* Add margin below inputs for wrapping */
            min-width: 150px; /* Ensure inputs are not too narrow */
        }

        /* Adjust label and input alignment within flex container */
        .medication-row label,
        .medication-details label {
            margin-bottom: 0; /* Remove bottom margin when using flex */
            align-self: center; /* Vertically center labels */
        }

        .medication-row select,
        .medication-details select,
        .medication-details input[type="number"] {
            margin-bottom: 0; /* Remove bottom margin when using flex */
        }


        #multiplicity_section {
            display: flex;
            align-items: center;
            margin-left: 10px; /* Add some space from previous element */
            flex-grow: 1; /* Allow this section to grow */
        }

        #multiplicity_section label {
            min-width: unset; /* Remove minimum width for this specific label */
            margin-right: 5px;
            margin-left: 10px;
        }

        #multiplicity_section input {
            flex-grow: 1; /* Allow the input to grow */
            max-width: 80px; /* Limit width of multiplicity input */
            margin-bottom: 0;
        }


        #fentanyl_unit_display {
            margin-left: 10px;
            font-weight: bold;
            color: #555;
            align-self: center; /* Vertically center */
        }


        button {
            display: block; /* Make the button a block element */
            width: 100%; /* Full width button */
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #ommed_result {
            background-color: #e9e9e9;
            font-weight: bold;
            color: #333;
        }

        #calculation_error {
            color: #dc3545; /* Bootstrap danger color */
            font-weight: bold;
            margin-left: 10px;
            align-self: center; /* Vertically center */
        }

        /* Adjust layout for result row */
        .result-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .result-row label {
            margin-bottom: 0;
            align-self: center;
        }

        .result-row input {
            margin-bottom: 0;
        }

        /* На десктопах вирівнюємо простір між кнопками */
        @media (min-width: 768px) {
            .button-group {
                justify-content: space-between;
                gap: 20px; /* Збільшуємо відстань на широких екранах */
            }

            .button {
                flex-grow: 0; /* Нехай не розтягуються на всю ширину, якщо їх три в ряд */
                width: auto; /* Ширина за вмістом або min-width */
            }
        }

        .button:hover {
            opacity: 0.9;
        }

        .clear-button {
            background-color: #dc3545;
            color: white;
        }

        /* Danger red */
        .clear-button:hover {
            background-color: #c82333;
        }

        .calc-button {
            background-color: #ffc107;
            color: #212529;
        }

        /* Warning yellow */
        .calc-button:hover {
            background-color: #e0a800;
        }

        .send-button {
            background-color: #28a745;
            color: white;
        }

        /* Success green */
        .send-button:hover {
            background-color: #218838;
        }

        /* Styles for new Pain Index inputs */
        .pain-index-inputs {
            margin-top: 15px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            gap: 15px; /* Space between groups of PI inputs */
        }

        .pi-input-group {
            display: flex;
            flex-direction: column; /* Stack label and input */
            gap: 5px;
        }

        .pi-input-group label {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
            display: block;
        }

        .pi-input-group input[type="number"],
        .pi-input-group select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: #f9f9f9;
            appearance: none; /* for select arrow */
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
        }

        .control-group-face {
            text-align: center; /* Центрує вміст по горизонталі */
            background-color: #fefefe; /* Світлий фон */
            width: 80%;
            border-radius: 10px; /* Заокруглені кути */
            padding: 20px; /* Внутрішні відступи */
            margin: 20px auto; /* Центрує блок по горизонталі та додає зовнішні відступи */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Легка тінь для об'єму */
            border: 1px solid #ddd; /* Тонка рамка */
        }

        /*
          Стилі для зображення всередині контейнера.
        */
        .control-group-face img {
            max-width: 99%; /* Зображення не буде ширшим за контейнер */
            height: auto; /* Зберігає пропорції */
            border-radius: 8px; /* Заокруглені кути для зображення */
            transition: transform 0.3s ease-in-out; /* Плавний ефект при наведенні */
        }

        /* Ефект при наведенні на зображення */
        .control-group-face a:hover img {
            transform: scale(1.08); /* Збільшення при наведенні */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="canvas-section">
        <canvas id="canvas"></canvas>
        <div class="face-picker">
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
                <label for="indexPain">Pain Index (Calculated):</label>
                <input type="text" id="indexPain" readonly placeholder="Calculated PI">
            </div>
            <div style="margin-top: 10px;>
                <label for=" analgeticIndexPain
            ">Analgetic Index:</label>
            <input type="text" id="analgeticIndexPain" readonly placeholder="Calculated AI">
        </div>
        <div style="margin-top: 10px;>
                <label for=" pain_control
        ">Pain Control Degree:</label>
        <input type="text" id="pain_control" readonly placeholder="Control status">
    </div>
    <div style="margin-top: 10px;">
        <label for="ommed_result">Calculated oMEDD:</label>
        <input type="text" id="ommed_result" readonly placeholder="Result (mg/day)">
        <span id="calculation_error" style="color: red; margin-left: 10px;"></span>
    </div>
</div>
</div>
<div class="controls-wrapper">
    <div class="controls">
        <div class="control-group-face">
            <a href="{{ route('getCamera')}}">
                <img src="img/face_man.jpg" alt="Чоловіче обличчя" style="width:200px; height:100px;">
            </a>
        </div>
        <div class="control-group">
            <div class="id_history">
                <input id="id_history" name="hystory_name" style="border-radius: 5px;  width:100%;height: 40px;"
                       placeholder="Enter medical history ID" ;>
            </div>
        </div>
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
        <div class="pain-index-inputs">
            <label>Pain Index Components:</label>
            <div class="pi-input-group">
                <label for="intensityInput">Pain Intensity (0-10):</label>
                <input type="number" id="intensityInput" min="0" max="10" value="0">
            </div>
            <div class="pi-input-group">
                <label for="frequencySelect">Frequency (Usual Pain Hours/day):</label>
                <select id="frequencySelect">
                    <option value="1">1-2 hours</option>
                    <option value="2">3-6 hours</option>
                    <option value="3">6-8 hours</option>
                    <option value="4">9-12 hours</option>
                    <option value="5">12-18 hours</option>
                    <option value="6">18-24 hours</option>
                </select>
            </div>
            <div class="pi-input-group">
                <label for="durationSelect">Duration (Worst Pain Hours/day):</label>
                <select id="durationSelect">
                    <option value="1">1-2 hours</option>
                    <option value="2">3-6 hours</option>
                    <option value="3">6-8 hours</option>
                    <option value="4">9-12 hours</option>
                    <option value="5">12-18 hours</option>
                    <option value="6">18-24 hours</option>
                </select>
            </div>
            <div class="pi-input-group">
                <label for="functionalImpactSelect">Functional Impact (Last 2 weeks):</label>
                <select id="functionalImpactSelect">
                    <option value="1">Зовсім ні (Not at all)</option>
                    <option value="2">Трішки (A little bit)</option>
                    <option value="3">Помірно (Moderately)</option>
                    <option value="4">Дуже сильно (Very much)</option>
                    <option value="5">Надзвичайно (Extremely)</option>
                </select>
            </div>
        </div>

        <div class="control-group">
            <input id="id_history" name="hystory_name" style="border-radius: 5px;  width:100%;height: 40px;"
                   placeholder="Enter PNbs type block:" ;>
            <div class="medication-group">
                <div class="medication-row">
                    <label for="adjuvants">Local anaesthetic:</label>
                    <select id="adjuvants" name="adjuvants">
                        <option value="not_selected">Not selected</option>
                        <option value="lidocaine">Lidocaine</option>
                        <option value="bupivacaine">Bupivacaine</option>
                        <option value="ropivacaine">Ropivacaine</option>
                        {{--                            <option value="amitriptyline">Amitriptyline</option>--}}
                        {{--                            <option value="dexamethasone">Dexamethasone</option>--}}
                    </select>
                    <input type="text" id="adjuvantsDose" class="adjuvantsInput" placeholder="Dose">
                    <div class="dosa">
                        <select id="adjuvantsDosa" name="adjuvantsDosa">
                            <option value="g">g</option>
                            <option value="ml" selected>ml</option>
                            <option value="mg">mg</option>
                            {/* Default to mg */}
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
                            <option value="mg" selected>mg</option>
                            {/* Default to mg */}
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
                            <option value="mg" selected>mg</option>
                            {/* Default to mg */}
                            <option value="mkg">mkg</option>
                        </select>
                    </div>
                    <input type="text" id="weak_opioidsMultiplicity" class="adjuvantsInput" placeholder="Times/day">
                </div>
                <div class="medication-row">
                    <label for="strong_opioid">Strong Opioid:</label>
                    <select id="strong_opioid" name="strong_opioid">
                        <option value="not_selected" selected>-- Select Medication --</option>
                        <option value="morphine_oral">Morphine (Oral)</option>
                        <option value="oxycodone_oral">Oxycodone (Oral)</option>
                        <option value="fentanyl_td">Fentanyl (TD, Patch)</option>
                    </select>
                </div>

                <div class="medication-details" id="medication_details" style="display: none; margin-top: 10px;">
                    <label for="opioid_dose">Dose:</label>
                    <input type="number" id="opioid_dose" class="adjuvantsInput" placeholder="Dose" min="0"
                           step="any">

                    <label for="opioid_unit" id="opioid_unit_label">Unit:</label>
                    <select id="opioid_unit" name="opioid_unit">
                        <option value="mg">mg</option>
                        <option value="mcg">mcg</option>
                    </select>

                    <span id="multiplicity_section">
        <label for="opioid_multiplicity">Frequency/Day:</label>
        <input type="number" id="opioid_multiplicity" class="adjuvantsInput" placeholder="Times/Day" min="1" step="1"
               value="1">
    </span>

                    <span id="fentanyl_unit_display" style="display: none; margin-left: 5px;">mcg/hour</span>
                </div>


            </div>
        </div>

    </div>

    <div class="button-group">
        <div style="margin-top: 15px;">
            <button type="button" class="calc-button button" onclick="calculateOmed()">Calculate oMEDD</button>
        </div>
        <div style="margin-top: 15px;">
            <button class="calc-button button" id="calcButton">Calculate Metrics</button>
        </div>
        <div style="margin-top: 15px;">
            <button class="send-button button" id="sendData">Send Data</button>
        </div>
        <div style="margin-top: 15px;">
            <button class="clear-button button" id="clearCanvas">Clear All</button>
        </div>
    </div>
    <div class="button-group">
        <div style="margin-top: 15px;">
            <a href="{{ route('interaction') }}" style="width: 90%; border-radius: 10px; display: inline-block; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);" class="button">
                <img src="img/interaction.jpg" alt="" style="width:200px; height:100px;">
            </a>
        </div>
        <div style="margin-top: 15px;">
            <a href="{{ route('protesys') }}" style="width: 100%; border-radius: 10px; display: inline-block; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);" class="button">
                <img src="img/prot.jpg" alt="" style="width:200px; height:100px;">
            </a>
        </div>

    </div>

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
        return {x, y};
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
        '#006400': {name: 'No Pain (Green)', coefficient: 1, level: 'No Pain'},
        '#ADFF2F': {name: 'Very Mild Pain (Lime Green)', coefficient: 2, level: 'Very Mild Pain'},
        '#FFFF00': {name: 'Mild Pain (Yellow)', coefficient: 3, level: 'Mild Pain'},
        '#FFA500': {name: 'Moderate Pain (Orange)', coefficient: 4, level: 'Moderate Pain'},
        '#8B4513': {name: 'Severe Pain (Brown)', coefficient: 5, level: 'Severe Pain'},
        '#FF0000': {name: 'Worst Pain (Red)', coefficient: 6, level: 'Worst Pain'},
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
                const pixelKey = `${i / 4}`;
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
        // Calculate Pain Index first, based on user inputs
        const painIndexValue = calculatePainIndex();
        const omdd = calculateOmed()
        console.log(omdd)
        document.getElementById('indexPain').value = isNaN(painIndexValue) ? 'Invalid Input' : painIndexValue.toFixed(2);


        // Update Pain Level based on canvas drawing (if needed, or rely solely on Intensity input?)
        // The original code used the drawn color with the highest coefficient for Pain Level.
        // Let's keep this logic for now, as it seems intentional.
        const colorPercentages = calculateDrawnArea(canvas);
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
        // Set the pain level based on the color with the highest coefficient drawn
        document.getElementById('pain-input').value = calculatedPainLevel;


        calculateAnalgeticIndex(); // Also calculate analgesic index
    }

    function calculatePainIndex() {
        const intensity = parseFloat(document.getElementById('intensityInput').value);
        const frequencyScore = parseFloat(document.getElementById('frequencySelect').value);
        const durationModifierScore = parseFloat(document.getElementById('durationSelect').value);
        const functionalImpactScore = parseFloat(document.getElementById('functionalImpactSelect').value);

        // Check if inputs are valid numbers
        if (isNaN(intensity) || isNaN(frequencyScore) || isNaN(durationModifierScore) || isNaN(functionalImpactScore)) {
            console.error("Invalid input for Pain Index calculation.");
            return NaN; // Return Not-a-Number if any input is invalid
        }

        // Formula: (Intensity × Frequency × Duration Modifier × Functional Impact Score) / 10
        const painIndex = (intensity * frequencyScore * durationModifierScore * functionalImpactScore) / 10;

        return painIndex;
    }

    function calculateOmed() {
        const strongOpioidsDrug = document.getElementById('strong_opioids').value;
        const strongOpioidsDoseValue = parseFloat(document.getElementById('strong_opioidsDose').value) || 0;
        const strongOpioidsMultiplicity = parseFloat(document.getElementById('strong_opioidsInputMultiplicity').value) || 0;

        let omedd = 0;
        // Используем факторы конверсии из документа для пероральных форм (кроме фентанила)
        const conversionFactors = {
            'morphine': 1, // Oral conversion factor
            'oxycodone': 1.5, // Oral conversion factor
            'fentanyl': 2.4 // Transdermal conversion factor for mcg/hr
        };

        if (conversionFactors[strongOpioidsDrug]) {
            if (strongOpioidsDrug === 'fentanyl') {

                omedd = strongOpioidsDoseValue * conversionFactors[strongOpioidsDrug] * strongOpioidsMultiplicity;
            } else {
                const dailyDose = strongOpioidsDoseValue * strongOpioidsMultiplicity;
                omedd = dailyDose * conversionFactors[strongOpioidsDrug];
            }
        } else {
            // Опционально: обработка случая, если выбранный препарат не входит в список
            // console.warn(`Неизвестный опиоид или отсутствует коэффициент конверсии для: ${strongOpioidsDrug}`);
        }

        document.getElementById('ommed').value = omedd;
    }


    // --- Analgetic Index and Pain Control Calculation (Simplified) ---
    function calculateAnalgeticIndex() {
        // Отримати дані про ад'юванти
        const adjuvantDrug = document.getElementById('adjuvants').value;
        const adjuvantDoseValue = parseFloat(document.getElementById('adjuvantsDose').value) || 0;
        const adjuvantMultiplicity = parseFloat(document.getElementById('adjuvantsInput').value) || 0;

        // Отримати дані про НПЗП (NSAID)
        const nsaidDrug = document.getElementById('nsaid').value;
        const nsaidDoseValue = parseFloat(document.getElementById('nsaidInput').value) || 0;
        const nsaidMultiplicity = parseFloat(document.getElementById('nsaidInputMultiplicity').value) || 0;

        // Отримати дані про слабкі опіоїди
        const weakOpioidsDrug = document.getElementById('weak_opioids').value;
        const weakOpioidsDoseValue = parseFloat(document.getElementById('weak_opioidsDose').value) || 0;
        const weakOpioidsMultiplicity = parseFloat(document.getElementById('weak_opioidsMultiplicity').value) || 0;

        // Отримати дані про сильні опіоїди - ВИКОРИСТОВУВАТИ ПРАВИЛЬНІ ID
        const strongOpioidsDrug = document.getElementById('strong_opioid').value; // Виправлено ID (було strong_opioids)
        // Доза та кратність беруться з елементів, що з'являються при виборі сильного опіоїду
        const strongOpioidsDoseValue = parseFloat(document.getElementById('opioid_dose').value) || 0; // Виправлено ID (було strong_opioidsDose)
        const strongOpioidsMultiplicity = parseFloat(document.getElementById('opioid_multiplicity').value) || 0; // Виправлено ID (було strong_opioidsInputMultiplicity)
        const strongOpioidsUnit = document.getElementById('opioid_unit').value; // Отримати одиницю для розрахунку OMEDD

        // --- Розрахунок Анальгетичного Індексу ---
        let analgeticIndex = '0'; // За замовчуванням 0%, якщо нічого не вибрано

        // Перевірити, чи вибрано кожну категорію з дійсними значеннями
        const isAdjuvantSelected = adjuvantDrug !== 'not_selected' && adjuvantDoseValue > 0 && adjuvantMultiplicity > 0;
        const isNsaidSelected = nsaidDrug !== 'not_selected' && nsaidDoseValue > 0 && nsaidMultiplicity > 0;
        const isWeakOpioidSelected = weakOpioidsDrug !== 'not_selected' && weakOpioidsDoseValue > 0 && weakOpioidsMultiplicity > 0;
        // Перевірка вибору сильного опіоїду: доза/кратність мають значення лише якщо препарат ВИБРАНО
        const isStrongOpioidSelected = strongOpioidsDrug !== 'not_selected' && strongOpioidsDoseValue > 0;
        // Примітка: для Фентанілу ТД "кратність" може бути не зовсім коректним поняттям, але поки дотримуємося поточної логіки

        console.log("Сильний опіоїд вибрано:", isStrongOpioidSelected, "НПЗП вибрано:", isNsaidSelected); // Для відладки

        // Проста логіка на основі щаблів знеболення ВООЗ
        if (isStrongOpioidSelected) {
            analgeticIndex = '80'; // Сходинка 3
        } else if (isWeakOpioidSelected) {
            if (isAdjuvantSelected || isNsaidSelected) {
                analgeticIndex = '50-70'; // Сходинка 2 + ад'ювант/НПЗП
            } else {
                analgeticIndex = '40-60'; // Тільки сходинка 2
            }
        } else if (isAdjuvantSelected && isNsaidSelected) {
            analgeticIndex = '30'; // Сходинка 1 (Ад'ювант + НПЗП)
        } else if (isAdjuvantSelected || isNsaidSelected) {
            analgeticIndex = '30'; // Сходинка 1 (Ад'ювант АБО НПЗП)
        }
        // інакше залишається '0%'

        // Відобразити Анальгетичний Індекс (перевірити наявність елемента)
        const analgeticIndexOutput = document.getElementById('analgeticIndexPain');
        if (analgeticIndexOutput) {
            analgeticIndexOutput.value = analgeticIndex;
        } else {
            console.error("Елемент з ID 'analgeticIndexPain' не знайдено!");
            // ПОТРІБНО ДОДАТИ ЦЕЙ ЕЛЕМЕНТ В HTML, наприклад:
            // <input type="text" id="analgeticIndexPain" readonly>
        }

        // --- Розрахунок Ступеня Контролю Болю ---
        let painControl = 'Н/Д'; // Стан за замовчуванням

        // Спрощений розрахунок OMEDD (Поки тільки для перорального морфіну)
        // ВАЖЛИВО: Цей розрахунок ДУЖЕ спрощений і потребує розширення!
        let totalOMEDD = 0;
        if (strongOpioidsDrug === 'morphine_oral' && strongOpioidsUnit === 'mg') { // Виправлено значення препарату та ID одиниці
            totalOMEDD = strongOpioidsDoseValue * strongOpioidsMultiplicity;
        }
        // !!! ПОТРІБНО ДОДАТИ КОНВЕРСІЮ ДЛЯ ІНШИХ СИЛЬНИХ ОПІОЇДІВ (Оксикодон, Фентаніл) !!!
        else if (strongOpioidsDrug === 'oxycodone_oral' && strongOpioidsUnit === 'mg') {
            // Приблизний коефіцієнт конверсії Оксикодон -> Морфін перорально = 1.5-2
            totalOMEDD = strongOpioidsDoseValue * strongOpioidsMultiplicity * 1.5; // Приклад! Використовуйте точні дані
        } else if (strongOpioidsDrug === 'fentanyl_td' && strongOpioidsUnit === 'mcg') {
            // Доза фентанілового пластиру - мкг/год. Конверсія відрізняється.
            // Приблизна конверсія: Фентаніл ТД мкг/год * 2.4 ≈ Морфін перорально мг/добу
            // Кратність (multiplicity) тут не використовується для добової дози пластиру.
            totalOMEDD = strongOpioidsDoseValue * 2.4; // Приклад! Використовуйте точні дані
        }

        // !!! ПОТРІБНО ДОДАТИ КОНВЕРСІЮ ДЛЯ СЛАБКИХ ОПІОЇДІВ (Трамадол, Кодеїн), якщо вони враховуються в OMEDD !!!
        if (isWeakOpioidSelected && weakOpioidsDrug === 'tramadol') {
            let tramadolDoseMg = 0;
            const tramadolUnit = document.getElementById('weak_opioidsDosa').value; // Потрібно перевіряти одиницю
            if (tramadolUnit === 'mg') tramadolDoseMg = weakOpioidsDoseValue;
            else if (tramadolUnit === 'g') tramadolDoseMg = weakOpioidsDoseValue * 1000;
            // Коефіцієнт конверсії Трамадол -> Морфін перорально = 0.1-0.2
            totalOMEDD += (tramadolDoseMg * weakOpioidsMultiplicity) * 0.1; // Приклад! Використовуйте точні дані
        }
        // Додати конверсію для кодеїну та дигідрокодеїну...


        // --- Логіка Контролю Болю ---
        const painIntensityInput = document.getElementById('intensityInput'); // Виправлено ID (було pain-input)
        let currentPainLevel = -1; // За замовчуванням недійсне значення

        if (painIntensityInput) {
            currentPainLevel = parseInt(painIntensityInput.value, 10); // Отримати числове значення інтенсивності (0-10)
        } else {
            console.error("Елемент з ID 'intensityInput' не знайдено!");
        }

        const highPainThreshold = 5; // Поріг високого болю (наприклад, 5 і вище за шкалою 0-10)
        const moderateOpioidThreshold = 60; // Приклад порогу OMEDD (мг/добу), потребує уточнення

        // Перевірка, чи є інтенсивність болю дійсним числом
        if (!isNaN(currentPainLevel) && currentPainLevel >= 0 && currentPainLevel <= 10) {
            const isAnyAnalgesicSelected = isAdjuvantSelected || isNsaidSelected || isWeakOpioidSelected || isStrongOpioidSelected;

            if (totalOMEDD > moderateOpioidThreshold && currentPainLevel >= highPainThreshold) {
                painControl = 'Потенційно неконтрольований біль';
            } else if (totalOMEDD > moderateOpioidThreshold) {
                // Висока доза OMEDD, але біль низький/помірний
                painControl = 'Високі дози опіоїдів (Біль контрольований)';
            } else if (currentPainLevel >= highPainThreshold && totalOMEDD <= moderateOpioidThreshold) {
                // Високий біль, але низька/помірна доза OMEDD
                if (isAnyAnalgesicSelected) {
                    painControl = 'Потенційно неконтрольований біль (Недостатнє знеболення)';
                } else {
                    painControl = 'Неконтрольований біль (Знеболення не застосовується)';
                }
            } else {
                // Низький/помірний біль ТА низька/помірна доза OMEDD
                if (isAnyAnalgesicSelected || currentPainLevel === 0) { // Якщо щось приймається або болю немає
                    painControl = 'Контрольований біль';
                } else { // Біль низький/помірний, але нічого не приймається
                    painControl = 'Біль присутній (Знеболення не застосовується)';
                }
            }
        } else {
            painControl = 'Інтенсивність болю не вказана або некоректна'; // Обробка випадку, коли поле інтенсивності порожнє або не число
        }


        // Відобразити Ступінь Контролю Болю (перевірити наявність елемента)
        const painControlOutput = document.getElementById('pain_control');
        if (painControlOutput) {
            painControlOutput.value = painControl;
        } else {
            console.error("Елемент з ID 'pain_control' не знайдено!");
            // ПОТРІБНО ДОДАТИ ЦЕЙ ЕЛЕМЕНТ В HTML, наприклад:
            // <input type="text" id="pain_control" readonly>
        }
    }

    function setupOpioidUI() {
        const drugSelect = document.getElementById('strong_opioid');
        const detailsDiv = document.getElementById('medication_details');
        const doseInput = document.getElementById('opioid_dose');
        const unitSelect = document.getElementById('opioid_unit');
        const unitLabel = document.getElementById('opioid_unit_label');
        const multiplicitySection = document.getElementById('multiplicity_section');
        const multiplicityInput = document.getElementById('opioid_multiplicity');
        const fentanylUnitDisplay = document.getElementById('fentanyl_unit_display');
        const resultInput = document.getElementById('ommed_result');
        const errorSpan = document.getElementById('calculation_error');

        drugSelect.addEventListener('change', function () {
            const selectedDrug = this.value;
            // Сброс при смене препарата
            doseInput.value = '';
            multiplicityInput.value = '1';
            resultInput.value = '';
            errorSpan.textContent = '';
            unitSelect.style.display = 'inline-block'; // Показать селектор единиц по умолчанию
            unitLabel.style.display = 'inline-block';
            fentanylUnitDisplay.style.display = 'none'; // Скрыть мкг/час
            multiplicitySection.style.display = 'inline-block'; // Показать кратность по умолчанию

            if (selectedDrug === 'not_selected') {
                detailsDiv.style.display = 'none';
            } else {
                detailsDiv.style.display = 'block';
                if (selectedDrug === 'fentanyl_td') {
                    // Настройка для Фентанила ТТС
                    unitSelect.style.display = 'none'; // Скрыть выбор мг/мкг
                    unitLabel.style.display = 'none';
                    fentanylUnitDisplay.style.display = 'inline-block'; // Показать "мкг/час"
                    multiplicitySection.style.display = 'none'; // Скрыть кратность
                    doseInput.placeholder = 'Доза (мкг/час)';
                } else if (selectedDrug === 'morphine_oral' || selectedDrug === 'oxycodone_oral') {
                    // Настройка для пероральных форм
                    doseInput.placeholder = 'Single dose';
                    // Установить мг по умолчанию для оральных, если нужно
                    unitSelect.value = 'mg';
                }
                // Добавить другие else if для других препаратов/форм
            }
        });

        // Инициализация UI при загрузке страницы (если нужно)
        // drugSelect.dispatchEvent(new Event('change'));
    }

    function calculateOmed() {
        const strongOpioidsDrug = document.getElementById('strong_opioid').value;
        const strongOpioidsDoseValue = parseFloat(document.getElementById('opioid_dose').value);
        const strongOpioidsUnit = document.getElementById('opioid_unit').value;
        const strongOpioidsMultiplicity = parseInt(document.getElementById('opioid_multiplicity').value) || 1; // По умолчанию 1, если поле скрыто или пусто
        const resultInput = document.getElementById('ommed_result');
        const errorSpan = document.getElementById('calculation_error');

        resultInput.value = ''; // Очистить результат перед расчетом
        errorSpan.textContent = ''; // Очистить ошибки

        if (strongOpioidsDrug === 'not_selected') {
            errorSpan.textContent = 'Please select a drug.';
            return;
        }

        if (isNaN(strongOpioidsDoseValue) || strongOpioidsDoseValue < 0) {
            errorSpan.textContent = 'Please enter a correct non-negative dose.';
            return;
        }
        if (isNaN(strongOpioidsMultiplicity) || strongOpioidsMultiplicity < 1) {
            // Эта проверка сработает только если поле кратности видимо и некорректно заполнено
            errorSpan.textContent = 'Please enter a valid multiple (minimum 1).';
            return;
        }


        let omedd = 0;
        // Коэффициенты конверсии в ОМЭДД (мг/сутки)
        // Ключ: значение из select, Значение: { factor: число, route: 'oral'/'td', expectedUnit: 'mg'/'mcg/hr' }
        const conversionFactors = {
            'morphine_oral': {factor: 1, route: 'oral', expectedUnit: 'mg'},
            'oxycodone_oral': {factor: 1.5, route: 'oral', expectedUnit: 'mg'},
            'fentanyl_td': {factor: 2.4, route: 'td', expectedUnit: 'mcg/hr'} // Конвертирует мкг/час в мг/сутки ОМЭДД
            // Добавьте сюда другие препараты и их коэффициенты/параметры
        };

        const drugInfo = conversionFactors[strongOpioidsDrug];

        if (drugInfo) {
            try {
                let dailyDoseInExpectedUnit = 0;

                if (drugInfo.route === 'oral') {
                    let doseInMg = strongOpioidsDoseValue;
                    // Конвертируем разовую дозу в MG, если она введена в MCG
                    if (strongOpioidsUnit === 'mcg') {
                        doseInMg = strongOpioidsDoseValue / 1000;
                    } else if (strongOpioidsUnit !== 'mg') {
                        throw new Error(`Неожиданная единица измерения ${strongOpioidsUnit} для ${strongOpioidsDrug}`);
                    }

                    if (drugInfo.expectedUnit !== 'mg') {
                        // Теоретически, можно добавить обработку, если ожидаемая единица не мг
                        console.warn(`Ожидаемая единица для ${strongOpioidsDrug} (${drugInfo.expectedUnit}) не совпадает с базовой 'mg'. Проверьте логику.`);
                    }

                    dailyDoseInExpectedUnit = doseInMg * strongOpioidsMultiplicity; // Суточная доза в мг
                    omedd = dailyDoseInExpectedUnit * drugInfo.factor;

                } else if (drugInfo.route === 'td') {
                    // Для трансдермальных форм (Фентанил ТТС)
                    if (drugInfo.expectedUnit === 'mcg/hr') {
                        // Доза уже введена в мкг/час, кратность не используется
                        dailyDoseInExpectedUnit = strongOpioidsDoseValue;
                        // Фактор 2.4 напрямую переводит mcg/hr в мг/сутки ОМЭДД
                        omedd = dailyDoseInExpectedUnit * drugInfo.factor;
                    } else {
                        throw new Error(`Неожиданная ожидаемая единица ${drugInfo.expectedUnit} для трансдермального препарата ${strongOpioidsDrug}`);
                    }
                } else {
                    throw new Error(`Неизвестный путь введения: ${drugInfo.route}`);
                }
                let omeddValue = parseFloat(omedd.toFixed(2))
                let risk = ''
                if (omeddValue >= 0 && omeddValue <= 50) {
                    risk = "Low dose – lower risk";
                } else if (omeddValue > 50 && omeddValue <= 90) {
                    risk = "Moderate dose – increasing risk";
                } else if (omeddValue > 90 && omeddValue <= 200) {
                    risk = "High dose – elevated risk, monitor closely";
                } else if (omeddValue > 200) {
                    risk = "Very high dose – consider opioid rotation or specialist consult";
                } else {
                    risk = "Invalid oMEDD value (less than 0)";
                }


                // Округляем результат для удобства
                resultInput.value = '(' + omedd.toFixed(2) + " mg/day" + ')' + risk;

            } catch (error) {
                console.error("Ошибка расчета:", error);
                errorSpan.textContent = `Ошибка расчета: ${error.message}`;
            }

        } else {
            errorSpan.textContent = `Коэффициент конверсии для "${document.getElementById('strong_opioid').options[document.getElementById('strong_opioid').selectedIndex].text}" не найден.`;
            console.warn(`Неизвестный опиоид или отсутствует коэффициент конверсии для: ${strongOpioidsDrug}`);
        }
    }

    // Инициализация UI после загрузки DOM
    document.addEventListener('DOMContentLoaded', setupOpioidUI);


    // --- Event Listeners ---
    document.getElementById('clearCanvas').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        usedColors.clear();
        document.getElementById('type-input').value = '';
        document.getElementById('pain-input').value = '';

        // Reset Pain Index inputs
        document.getElementById('intensityInput').value = 0;
        document.getElementById('frequencySelect').value = 1; // Set to default option value
        document.getElementById('durationSelect').value = 1; // Set to default option value
        document.getElementById('functionalImpactSelect').value = 1; // Set to default option value

        document.getElementById('indexPain').value = ''; // Clear calculated index
        document.getElementById('analgeticIndexPain').value = '';
        document.getElementById('pain_control').value = '';

        document.getElementById('ommed_result').value = ''

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

    // The "Calculate Metrics" button now triggers updatePainMetrics,
    // which in turn calls calculatePainIndex and calculateAnalgeticIndex.
    document.getElementById('calcButton').addEventListener('click', updatePainMetrics);

    // Also trigger calculations when Pain Index inputs change
    document.getElementById('intensityInput').addEventListener('input', updatePainMetrics);
    document.getElementById('frequencySelect').addEventListener('change', updatePainMetrics);
    document.getElementById('durationSelect').addEventListener('change', updatePainMetrics);
    document.getElementById('functionalImpactSelect').addEventListener('change', updatePainMetrics);


    document.getElementById('ageSlider').addEventListener('input', function () {
        document.getElementById('ageValue').textContent = this.value;
    });

    document.getElementById('weightSlider').addEventListener('input', function () {
        document.getElementById('weightValue').textContent = this.value;
    });

    document.getElementById('heightSlider').addEventListener('input', function () {
        document.getElementById('heightValue').textContent = this.value;
    });


    // Add event listeners to medication inputs/selects to trigger analgesic calculation
    document.querySelectorAll('.medication-group select, .medication-group input[type="text"]').forEach(element => {
        element.addEventListener('change', updatePainMetrics); // Use 'change' event - recalculates all metrics
        element.addEventListener('input', updatePainMetrics); // Also use 'input' for text fields - recalculates all metrics
    });


    document.getElementById('sendData').addEventListener('click', () => {
        // Ensure metrics are calculated before sending
        updatePainMetrics(); // This also calls calculateAnalgeticIndex

        const canvasData = canvas.toDataURL();
        const painLevel = document.getElementById('pain-input').value;
        const analgeticIndexPain = document.getElementById('analgeticIndexPain').value;
        const pain_control = document.getElementById('pain_control').value;
        const painIndex = document.getElementById('indexPain').value; // Get the calculated Pain Index
        const age = document.getElementById('ageSlider').value;
        const weight = document.getElementById('weightSlider').value;
        const height = document.getElementById('heightSlider').value;
        const typePain = document.getElementById('type-input').value;

        // Also collect the raw inputs for Pain Index components
        const intensityInput = document.getElementById('intensityInput').value;
        const frequencySelect = document.getElementById('frequencySelect').value;
        const durationSelect = document.getElementById('durationSelect').value;
        const functionalImpactSelect = document.getElementById('functionalImpactSelect').value;


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


        fetch('/save-level-pain', { // Ensure this is the correct endpoint on your server
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
                painIndex: painIndex, // Include the calculated index
                age: age,
                weight: weight,
                height: height,
                typePain: typePain,
                // Include raw Pain Index component inputs for record-keeping
                pi_intensity: intensityInput,
                pi_frequency: frequencySelect,
                pi_duration: durationSelect,
                pi_functional_impact: functionalImpactSelect,
                medications: medications // Include medication data
            })
        }).then(response => {
            if (!response.ok) {
                // Attempt to read response body for more details on error
                return response.text().then(text => {
                    throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                });
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


</script>
</body>
</html>
