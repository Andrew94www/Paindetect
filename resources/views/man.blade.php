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
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
            padding: 20px;
            max-width: 90%;
        }
        canvas {
            border: 1px solid #444;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background: url('img/uvmanpanoramic.jpg') no-repeat center center;
            background-size: cover;
            touch-action: none; /* Отключаем жесты браузера на сенсорных экранах */
        }
        .controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: 20px;
        }
        .text-area {
            width: 80%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
            text-align: center;
            resize: none;
            margin-top: 10px;
        }
        .face-picker {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 7px;
        }
        .face-option {
            width: 60px;
            height: 60px;
            cursor: pointer;
            border-radius: 50%;
            border: 3px solid transparent;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .face-option:hover, .face-option.active {
            transform: scale(1.2);
            border-color: #444;
        }
        .clear-button, .send-button,.calc-button {
            margin-top: 15px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
            width: 80%;
            text-align: center;
        }
        .clear-button {
            background-color: #ff4d4d;
            color: white;
        }
        .clear-button:hover {
            background-color: #cc0000;
        }
        .calc-button {
            background-color: #978e52;
            color: white;
        }
        .calc-button:hover {
            background-color: #897b44;
        }
        .send-button {
            background-color: #4CAF50;
            color: white;
        }
        .send-button:hover {
            background-color: #388E3C;
        }
        #line-width {
            margin-top: 10px;
            width: 80%;
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
        console.log(level);
        console.log(usedColors)
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

    canvas.addEventListener('mousedown', (e) => startDrawing(e.offsetX, e.offsetY));
    canvas.addEventListener('mousemove', (e) => draw(e.offsetX, e.offsetY));
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseleave', stopDrawing);

    // Поддержка сенсорного ввода
    canvas.addEventListener('touchstart', (e) => {
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        startDrawing(touch.clientX - rect.left, touch.clientY - rect.top);
    });

    canvas.addEventListener('touchmove', (e) => {
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        draw(touch.clientX - rect.left, touch.clientY - rect.top);
        e.preventDefault(); // Предотвращаем скроллинг при рисовании
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
