<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vision</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #72edf2 10%, #d2d2e6 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        canvas {
            border: none;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }

        .button-container {
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #c2d2e3;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #bacee3;
        }

        button:active {
            background-color: #ced7e1;
        }

        @media (max-width: 768px) {
            button {
                width: 100%;
                padding: 15px;
                font-size: 18px;
            }

            canvas {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

<canvas id="canvas"></canvas>

<div class="button-container">
    <button id="resetButton">Reset</button>
</div>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    const DPI = 96;

    function mmToPx(mm) {
        return (mm / 25.4) * DPI;
    }

    const canvasWidthMM = 210;
    const canvasHeightMM = 297;

    canvas.width = mmToPx(canvasWidthMM);
    canvas.height = mmToPx(canvasHeightMM);

    let image = new Image();
    image.src = 'img/visi.jpg';

    let drawing = false;
    let ix = -1, iy = -1;
    let rx = -1, ry = -1;

    image.onload = function() {
        const imgAspectRatio = image.width / image.height;
        const canvasAspectRatio = canvas.width / canvas.height;

        let renderWidth, renderHeight;

        if (imgAspectRatio > canvasAspectRatio) {
            renderHeight = canvas.height;
            renderWidth = canvas.height * imgAspectRatio;
        } else {
            renderWidth = canvas.width;
            renderHeight = canvas.width / imgAspectRatio;
        }

        const offsetX = (canvas.width - renderWidth) / 2;
        const offsetY = (canvas.height - renderHeight) / 2;

        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(image, offsetX, offsetY, renderWidth, renderHeight);
    };

    canvas.addEventListener('mousedown', function(e) {
        drawing = true;
        const rect = canvas.getBoundingClientRect();
        ix = e.clientX - rect.left;
        iy = e.clientY - rect.top;

        ctx.beginPath();
        ctx.arc(ix, iy, mmToPx(1), 0, 2 * Math.PI);
        ctx.fillStyle = 'red';
        ctx.fill();
        ctx.closePath();
    });

    canvas.addEventListener('mousemove', function(e) {
        if (drawing) {
            const rect = canvas.getBoundingClientRect();
            rx = e.clientX - rect.left;
            ry = e.clientY - rect.top;
        }
    });

    canvas.addEventListener('mouseup', function(e) {
        drawing = false;
        const rect = canvas.getBoundingClientRect();
        rx = e.clientX - rect.left;
        ry = e.clientY - rect.top;

        const radiusPx = Math.sqrt((ix - rx) ** 2 + (iy - ry) ** 2);
        const radiusMM = (radiusPx * 25.4) / DPI;

        ctx.beginPath();
        ctx.arc(ix, iy, radiusPx, 0, 2 * Math.PI);
        ctx.strokeStyle = 'green';
        ctx.lineWidth = mmToPx(0.5);
        ctx.stroke();
        ctx.closePath();

        // Добавляем текст с радиусом зрачка на холст
        ctx.font = `${mmToPx(5)}px Arial`;
        ctx.fillStyle = 'white';
        ctx.fillText(`Radius: ${radiusMM.toFixed(2)} mm`, ix + radiusPx + mmToPx(3), iy);

        console.log(`Center of pupil: (${ix}, ${iy}), Pupil radius: ${radiusMM} mm`);
    });

    document.getElementById('resetButton').addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        image.onload();
    });

</script>

</body>
</html>
