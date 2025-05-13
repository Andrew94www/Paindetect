<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Application</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Additional styles if needed, but we try to use Tailwind classes */
        #camera-feed {
            width: 100%;
            max-width: 640px;
            height: auto;
            /* Remove default border, use Tailwind classes */
        }
        canvas {
            display: none; /* Hide canvas by default */
        }
        /* Add styles for a more modern font, if not loaded by default by Tailwind */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-200 flex flex-col items-center justify-center min-h-screen p-6">

<h1 class="text-4xl font-extrabold mb-8 text-gray-900 drop-shadow-sm">Camera Application</h1>

<div class="w-full max-w-xl bg-white rounded-2xl shadow-2xl p-8 transform transition duration-500 hover:scale-105">
    <video id="camera-feed" autoplay playsinline class="rounded-lg mb-6 border border-gray-300 shadow-inner"></video>
    <canvas id="snapshot-canvas" class="rounded-lg mb-6 border border-gray-300 shadow-inner"></canvas>
    <img id="snapshot-img" src="#" alt="Camera Snapshot" class="hidden rounded-lg mb-6 border border-gray-300 shadow-inner">

    <div class="flex flex-col space-y-5">
        <button id="open-camera" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
            Open Camera
        </button>

        <button id="take-snapshot" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Take Snapshot
        </button>

        <button id="go-back" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
            Back
        </button>
    </div>
</div>

<script>
    const openCameraButton = document.getElementById('open-camera');
    const takeSnapshotButton = document.getElementById('take-snapshot');
    const goBackButton = document.getElementById('go-back');
    const cameraFeed = document.getElementById('camera-feed');
    const snapshotCanvas = document.getElementById('snapshot-canvas');
    const snapshotImg = document.getElementById('snapshot-img');
    let currentStream = null; // Variable to store the current camera stream

    // Function to stop the camera stream
    function stopCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
            cameraFeed.srcObject = null;
            currentStream = null;
            takeSnapshotButton.disabled = true; // Disable snapshot button after stopping
            snapshotImg.classList.add('hidden'); // Hide snapshot image
            snapshotCanvas.style.display = 'none'; // Hide canvas
            cameraFeed.style.display = 'block'; // Show video again
            cameraFeed.play(); // Resume video playback if it was paused
        }
    }

    // Event listener for the open camera button
    openCameraButton.addEventListener('click', async () => {
        stopCamera(); // Stop the previous stream if any
        try {
            // Request access to the video (camera)
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            currentStream = stream; // Store the current stream
            cameraFeed.srcObject = stream;
            takeSnapshotButton.disabled = false; // Enable snapshot button after successful access
            snapshotImg.classList.add('hidden'); // Hide snapshot image when opening camera
            snapshotCanvas.style.display = 'none'; // Hide canvas when opening camera
            cameraFeed.style.display = 'block'; // Show video

            // Wait for the video to start playing to get its dimensions
            cameraFeed.onloadedmetadata = () => {
                snapshotCanvas.width = cameraFeed.videoWidth;
                snapshotCanvas.height = cameraFeed.videoHeight;
            };

        } catch (error) {
            console.error('Error accessing camera:', error);
            alert('Could not access the camera. Please check permissions.');
            takeSnapshotButton.disabled = true; // Disable snapshot button in case of error
        }
    });

    // Event listener for the take snapshot button
    takeSnapshotButton.addEventListener('click', () => {
        if (currentStream) {
            const context = snapshotCanvas.getContext('2d');
            // Ensure the canvas has the correct dimensions before drawing
            snapshotCanvas.width = cameraFeed.videoWidth;
            snapshotCanvas.height = cameraFeed.videoHeight;

            // Draw the current video frame onto the canvas
            context.drawImage(cameraFeed, 0, 0, snapshotCanvas.width, snapshotCanvas.height);

            // Get the image data in Data URL format
            const dataUrl = snapshotCanvas.toDataURL('image/png');

            // Display the snapshot
            snapshotImg.src = dataUrl;
            snapshotImg.classList.remove('hidden'); // Show the snapshot image
            snapshotCanvas.style.display = 'none'; // Hide canvas after creating snapshot
            cameraFeed.style.display = 'none'; // Hide video after snapshot
            // cameraFeed.pause(); // Pause video (optional, can hide instead of pausing)
        }
    });

    // Event listener for the go back button
    goBackButton.addEventListener('click', () => {
        stopCamera(); // Stop the camera before navigating away
        history.back(); // Go back to the previous page in browser history
    });

    // Stop the camera when the page is closed or reloaded
    window.addEventListener('beforeunload', stopCamera);

    // Add an event listener to resume video if the user clicks the snapshot image
    snapshotImg.addEventListener('click', () => {
        snapshotImg.classList.add('hidden'); // Hide the snapshot image
        cameraFeed.style.display = 'block'; // Show the video again
        cameraFeed.play(); // Resume video playback
    });


</script>

</body>
</html>
