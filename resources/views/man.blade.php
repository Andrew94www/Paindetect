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
            background: linear-gradient(135deg, #f0f4ff, #dfe7fd);
        }
        .container {
            display: flex;
            flex-direction: row;
            background: white;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
            padding: 20px;
        }
        canvas {
            border: 5px solid #333;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        canvas:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        .controls {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            margin-left: 20px;
            align-items: center;
        }
        .face-picker {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
        .face-option {
            width: 80px;
            height: 80px;
            margin: 10px;
            cursor: pointer;
            border-radius: 50%;
            border: 3px solid transparent;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .face-option:hover, .face-option.active {
            transform: scale(1.2);
            border-color: #333;
        }
        button {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            margin-top: 20px;
        }
        button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        #results {
            margin-top: 20px;
            font-size: 22px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                align-items: center;
                padding: 15px;
            }
            canvas {
                margin-bottom: 20px;
                width: 90%;
                height: auto;
            }
            .controls {
                margin-left: 0;
                width: 100%;
                align-items: center;
            }
            .face-picker {
                flex-wrap: wrap;
                justify-content: center;
            }
            .face-option {
                width: 70px;
                height: 70px;
                margin: 5px;
            }
            button {
                width: 90%;
            }
        }
        @media (max-width: 600px) {
            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <canvas id="canvas" width="600" height="400"></canvas>
    <div class="controls">
        <div class="face-picker">
            <img class="face-option" id="dark_green" src="img/face_0.jpg" alt="No Pain">
            <img class="face-option" id="green" src="img/face_1.jpg" alt="Mild Pain">
            <img class="face-option" id="yellow" src="img/face_2.jpg" alt="Moderate Pain">
            <img class="face-option" id="brown" src="img/face_3.jpg" alt="Severe Pain">
            <img class="face-option" id="orange" src="img/face_4.jpg" alt="Very Severe Pain">
            <img class="face-option" id="red" src="img/face_5.jpg" alt="Worst Pain">
        </div>
        <button id="calculateArea">Calculate Pain</button>
        <div id="results"></div>
    </div>
</div>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const originalImageData = [];
    let selectedColor = 'blue'; // Default color

    // Handle color selection
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            selectedColor = option.style.backgroundColor;
        });
    });

    // Load image
    const img = new Image();
    img.src = 'img/uvmanpanoramic.jpg'; // Path to your image
    img.onload = () => {
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        drawRedSquares();
        drawAreas.forEach(area => {
            originalImageData.push(ctx.getImageData(area.x, area.y, area.width, area.height));
        });
    };

    // const drawAreas = [
    //     { x: 40, y: 50, width: 155, height: 530 },
    //     { x: 230, y: 50, width: 155, height: 530 },
    //     { x: 430, y: 50, width: 70, height: 530 }
    // ];

    function drawRedSquares() {
        ctx.strokeStyle = 'red';
        drawAreas.forEach(area => {
            ctx.strokeRect(area.x, area.y, area.width, area.height);
        });
    }

    let isDrawing = false;

    canvas.addEventListener('mousedown', (e) => {
        const { offsetX, offsetY } = e;
        if (isInsideAnyDrawArea(offsetX, offsetY)) {
            isDrawing = true;
            ctx.lineWidth = 5;
            ctx.strokeStyle = selectedColor;
            ctx.beginPath();
            ctx.moveTo(offsetX, offsetY);
        }
    });

    canvas.addEventListener('mousemove', (e) => {
        if (isDrawing) {
            const { offsetX, offsetY } = e;
            if (isInsideAnyDrawArea(offsetX, offsetY)) {
                ctx.lineTo(offsetX, offsetY);
                ctx.stroke();
            }
        }
    });

    canvas.addEventListener('mouseup', () => {
        isDrawing = false;
        ctx.closePath();
    });

    function isInsideAnyDrawArea(x, y) {
        return drawAreas.some(area =>
            x >= area.x && x <= area.x + area.width &&
            y >= area.y && y <= area.y + area.height
        );
    }

    function calculateFilledArea(index) {
        const area = drawAreas[index];
        const imageData = ctx.getImageData(area.x, area.y, area.width, area.height);
        const originalData = originalImageData[index].data;
        const data = imageData.data;
        let filledPixels = 0;

        for (let i = 0; i < data.length; i += 4) {
            if (data[i] !== originalData[i] ||
                data[i + 1] !== originalData[i + 1] ||
                data[i + 2] !== originalData[i + 2] ||
                data[i + 3] !== originalData[i + 3]) {
                filledPixels++;
            }
        }

        const totalPixels = area.width * area.height;
        return (filledPixels / totalPixels) * 100;
    }

    document.getElementById('calculateArea').addEventListener('click', () => {
        const results = drawAreas.map((_, i) => calculateFilledArea(i).toFixed(2));

        // document.getElementById('results').innerText = `Filled areas: ${results[0]}%, ${results[1]}%, ${results[2]}%`;
        document.getElementById('results').innerText = `Заключення:Помірний больовий синдром !`;

        const imageDataURL = canvas.toDataURL('image/png'); // Получение изображения в base64 формате

        // Отправка данных на сервер через AJAX-запрос
        fetch('/save-image', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                image: imageDataURL,
                filledAreas: results // Результаты, которые вы получили
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log('Image and data saved:', data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
</body>
</html>
