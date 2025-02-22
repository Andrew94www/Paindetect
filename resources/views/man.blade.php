<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Drawing Tool</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #eef2ff, #c3dafe);
            overflow: hidden; /* Убираем скроллинг на мобильных */
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 15px;
            width: 90%;
            max-width: 600px; /* Ограничиваем ширину */
            box-sizing: border-box;
        }
        canvas {
            border: 1px solid #444;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: url('img/uvmanpanoramic.jpg') no-repeat center center;
            background-size: cover;
            touch-action: none;
            width: 100%; /* Адаптивная ширина */
            max-width: 500px;
            height: auto;
            aspect-ratio: 3 / 2; /* Сохраняем пропорции */
        }
        .controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: 10px;
        }
        .text-area {
            width: 100%;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            text-align: center;
            resize: none;
            margin-top: 8px;
        }
        .face-picker {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
        }
        .face-option {
            width: 45px;
            height: 45px;
            cursor: pointer;
            border-radius: 50%;
            border: 2px solid transparent;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .face-option:hover, .face-option.active {
            transform: scale(1.1);
            border-color: #444;
        }
        .clear-button, .send-button, .calc-button {
            margin-top: 10px;
            padding: 8px 16px;
            font-size: 14px;
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

        /* Адаптация для мобильных */
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            .face-option {
                width: 40px;
                height: 40px;
            }
            .clear-button, .send-button, .calc-button {
                font-size: 12px;
                padding: 6px 12px;
            }
            canvas {
                max-width: 350px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <canvas id="canvas" width="600" height="400"></canvas>
    <div class="controls">
        <div class="face-picker">
            <img class="face-option" src="img/face_0.jpg" alt="No Pain" data-color="#006400">
            <img class="face-option" src="img/face_1.jpg" alt="Mild Pain" data-color="#ADFF2F">
            <img class="face-option" src="img/face_2.jpg" alt="Moderate Pain" data-color="#FFFF00">
            <img class="face-option" src="img/face_3.jpg" alt="Severe Pain" data-color="#FFA500">
            <img class="face-option" src="img/face_4.jpg" alt="Very Severe Pain" data-color="#8B4513">
            <img class="face-option" src="img/face_5.jpg" alt="Worst Pain" data-color="#FF0000">
        </div>
        <textarea id="pain-input" class="text-area">No Pain</textarea>
        <textarea id="medications" class="text-area" placeholder="Enter medications for treatment..."></textarea>
        <button class="clear-button" id="clearCanvas">Clear</button>
        <button class="calc-button" id="calcButton">Calc Pain</button>
        <button class="send-button" id="sendData">Send Data</button>
    </div>
</div>
<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let usedColors = new Set();
    let lineWidth = 8; // Толщина линии по умолчанию
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
        } else if (levelPain==="#8b4513") { // Коричневый - самый высокий приоритет
            level = 'Severe pain';
        } else if (levelPain==="#ffa500") { // Желтый - четвертый приоритет
            level = 'Moderate pain';
        } else if (levelPain==="#ffff00") { // Желтый - четвертый приоритет
            level = 'Mild pain';
        } else if (levelPain==="#adff2f") { // Оранжевый - пятый приоритет
            level = 'Very mild pain';
        } else { // Красный - шестой приоритет
            level = 'No pain';
        }
        console.log(level)


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
    });
    document.getElementById('calcButton').addEventListener('click', () => {
       updatePainInput()
    });


    document.getElementById('sendData').addEventListener('click', () => {
        const canvasData = canvas.toDataURL();
        const painLevel = document.getElementById('pain-input').value;
        const medications = document.getElementById('medications').value;

        fetch('/save-drawing', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                image: canvasData,
                pain_level: painLevel,
                medications: medications
            })
        }).then(response => response.json()).then(data => {
            alert('Data saved successfully!');
        }).catch(error => console.error('Error:', error));
    });
</script>
</body>
</html>
