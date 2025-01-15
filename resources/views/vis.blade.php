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
            border-radius: 15px;
            max-width: 100%;
            height: auto;
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        button, .button_link {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover, .button_link:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        button:active, .button_link:active {
            background-color: #3e8e41;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            canvas {
                max-width: 100%;
                width: 100%;
                height: auto;
            }

            .button-container {
                flex-direction: column;
                align-items: center;
            }

            button, .button_link {
                width: 100%;
                font-size: 14px;
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            canvas {
                max-width: 100%;
                height: auto;
            }

            button, .button_link {
                font-size: 12px;
                padding: 10px;
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
    });

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
                body: JSON.stringify({ radiusMM })
            })
                .then(response => response.json())
                .then(data => {
                    window.location.href = '{{ route("detect") }}';
                    console.log('Response:', data);
                })
                .catch(error => {
                    window.location.href = '{{ route("detect") }}';
                    console.error('Error:', error);
                });
        } else {
            alert('Спочатку виконайте вимір!');
        }
    });
</script>

</body>
</html>
