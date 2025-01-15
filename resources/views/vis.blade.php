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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        canvas {
            border: none;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            max-width: 100%;
            width: 90%; /* Адаптация для мобильных */
            height: auto;
            border-radius: 15px;
            touch-action: none; /* Отключение стандартных жестов браузера */
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        button, .button_link {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            margin: 5px;
            display: inline-block;
            text-align: center;
        }

        button:hover, .button_link:hover {
            background-color: #45a049;
        }

        button:active, .button_link:active {
            background-color: #3e8e41;
        }

        @media (max-width: 768px) {
            button, .button_link {
                width: 90%;
                font-size: 18px;
                margin-bottom: 10px;
            }

            canvas {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<canvas id="canvas"></canvas>

<div class="button-container">
    <button id="resetButton">Скинути замір</button>
    <a href="{{route('get-vision')}}" class="button_link">Завантажити зображення</a>
    <a id="submitResult" class="button_link">Відправити результат</a>
</div>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    const DPI = 96;

    function mmToPx(mm) {
        return (mm / 25.4) * DPI;
    }

    const canvasWidthMM = 100;
    const canvasHeightMM = 100;

    canvas.width = mmToPx(canvasWidthMM);
    canvas.height = mmToPx(canvasHeightMM);

    let image = new Image();
    image.src = '{{ asset('storage/' . $imagePath) }}';

    let drawing = false;
    let ix = -1, iy = -1;
    let rx = -1, ry = -1;
    let radiusMM = 0;

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

    function getTouchPosition(touchEvent) {
        const rect = canvas.getBoundingClientRect();
        const touch = touchEvent.touches[0] || touchEvent.changedTouches[0];
        return {
            x: touch.clientX - rect.left,
            y: touch.clientY - rect.top
        };
    }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);

    canvas.addEventListener('touchstart', function(e) {
        const pos = getTouchPosition(e);
        startDrawing({ clientX: pos.x, clientY: pos.y });
        e.preventDefault();
    });

    canvas.addEventListener('touchmove', function(e) {
        const pos = getTouchPosition(e);
        draw({ clientX: pos.x, clientY: pos.y });
        e.preventDefault();
    });

    canvas.addEventListener('touchend', function(e) {
        stopDrawing(e);
        e.preventDefault();
    });

    function startDrawing(e) {
        drawing = true;
        const rect = canvas.getBoundingClientRect();
        ix = e.clientX - rect.left;
        iy = e.clientY - rect.top;

        ctx.beginPath();
        ctx.arc(ix, iy, mmToPx(1), 0, 2 * Math.PI);
        ctx.fillStyle = 'red';
        ctx.fill();
        ctx.closePath();
    }

    function draw(e) {
        if (drawing) {
            const rect = canvas.getBoundingClientRect();
            rx = e.clientX - rect.left;
            ry = e.clientY - rect.top;
        }
    }

    function stopDrawing(e) {
        drawing = false;
        const rect = canvas.getBoundingClientRect();
        rx = e.clientX - rect.left;
        ry = e.clientY - rect.top;

        const radiusPx = Math.sqrt((ix - rx) ** 2 + (iy - ry) ** 2);
        radiusMM = (radiusPx * 25.4) / DPI;

        ctx.beginPath();
        ctx.arc(ix, iy, radiusPx, 0, 2 * Math.PI);
        ctx.strokeStyle = 'green';
        ctx.lineWidth = mmToPx(0.5);
        ctx.stroke();
        ctx.closePath();

        ctx.font = `${mmToPx(5)}px Arial`;
        ctx.fillStyle = 'white';
        ctx.fillText(`Radius: ${radiusMM.toFixed(2)} mm`, ix + radiusPx + mmToPx(3), iy);

        console.log(`Center: (${ix}, ${iy}), Radius: ${radiusMM} mm`);
    }

    document.getElementById('resetButton').addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        image.onload();
    });

    document.getElementById('submitResult').addEventListener('click', function() {
        if (radiusMM > 0) {
            fetch('{{ route('submit-measurement') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ radiusMM: radiusMM })
            })
                .then(response => response.json())
                .then(data => {
                    window.location.href = '{{ route("detect") }}';
                    console.log('Response:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Помилка відправки даних.');
                });
        } else {
            alert('Спочатку виконайте вимір!');
        }
    });
</script>

</body>
</html>
