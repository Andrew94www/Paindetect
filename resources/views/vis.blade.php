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
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3a8dff, #a7c7e7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        .container {
            background: #ffffff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 90%;
            width: 420px;
        }

        h1 {
            font-size: 24px;
            color: #222;
            margin-bottom: 15px;
        }

        canvas {
            border-radius: 12px;
            background-color: #f0f0f0;
            width: 100%;
            height: auto;
            max-height: 180px;
            margin-bottom: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        button, .button_link {
            flex: 1;
            padding: 12px;
            font-size: 14px;
            color: white;
            background: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15);
        }

        button:hover, .button_link:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 600px) {
            .container {
                width: 95%;
            }
            .button-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Vision Measurement</h1>
    <canvas id="canvas"></canvas>
    <div class="button-container">
        <button id="resetButton">Скинути</button>
        <a href="{{route('get-vision')}}" class="button_link">Завантажити</a>
        <a id="submitResult" class="button_link">Відправити</a>
    </div>
</div>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const DPI = 96;

    function mmToPx(mm) {
        return (mm / 25.4) * DPI;
    }

    const canvasWidthMM = 60;
    const canvasHeightMM = 50;
    canvas.width = mmToPx(canvasWidthMM);
    canvas.height = mmToPx(canvasHeightMM);

    let image = new Image();
    image.src = '{{ asset('storage/' . $imagePath) }}';

    image.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        let scale = Math.min(canvas.width / image.width, canvas.height / image.height);
        let newWidth = image.width * scale;
        let newHeight = image.height * scale;
        let x = (canvas.width - newWidth) / 2;
        let y = (canvas.height - newHeight) / 2;
        ctx.drawImage(image, x, y, newWidth, newHeight);
    };

    let drawing = false, ix, iy, rx, ry, radiusMM;

    function startDrawing(e) {
        drawing = true;
        const rect = canvas.getBoundingClientRect();
        ix = e.clientX - rect.left;
        iy = e.clientY - rect.top;
    }

    function draw(e) {
        if (drawing) {
            rx = e.clientX - canvas.getBoundingClientRect().left;
            ry = e.clientY - canvas.getBoundingClientRect().top;
        }
    }

    function stopDrawing(e) {
        drawing = false;
        rx = e.clientX - canvas.getBoundingClientRect().left;
        ry = e.clientY - canvas.getBoundingClientRect().top;
        const radiusPx = Math.sqrt((ix - rx) ** 2 + (iy - ry) ** 2);
        radiusMM = (radiusPx * 25.4) / DPI;

        ctx.beginPath();
        ctx.arc(ix, iy, radiusPx, 0, 2 * Math.PI);
        ctx.strokeStyle = 'green';
        ctx.lineWidth = 2;
        ctx.stroke();
        ctx.closePath();
    }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);

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
                .then(() => {
                    window.location.href = '{{ route("detect") }}';
                })
                .catch(() => {
                    alert('Помилка відправки даних.');
                });
        } else {
            alert('Спочатку виконайте вимір!');
        }
    });
</script>

</body>
</html>
