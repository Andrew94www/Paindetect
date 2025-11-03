<!DOCTYPE html>
<html lang="en"> <!-- Changed lang to "en" -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neural Network Training Dashboard</title> <!-- Translated -->
    <!-- Подключаем Tailwind CSS для стилей -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Подключаем Chart.js для графиков -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Используем приятный шрифт */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6; /* Немного другой фон */
        }
        /* Стили для плавного перехода прогресс-бара */
        #progress-bar-inner {
            transition: width 0.1s linear;
        }
        /* Класс для "мигания" при обновлении */
        .metric-updated {
            animation: flash 0.5s ease-out;
        }
        @keyframes flash {
            0% { background-color: rgba(59, 130, 246, 0.1); }
            100% { background-color: transparent; }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 md:p-6">

<div class="w-full max-w-7xl bg-white rounded-2xl shadow-xl p-6 md:p-8">

    <!-- Заголовок -->
    <div class="text-center mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 flex items-center justify-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M12 3c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm0 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" />
            </svg>
            <span>Training Dashboard: Wound Healing Diagnostics</span> <!-- Translated -->
        </h1>
    </div>

    <!-- Основная сетка: 1 колонка (управление) + 2 колонки (визуализация) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- === КОЛОНКА 1: УПРАВЛЕНИЕ И СТАТУС === -->
        <div class="lg:col-span-1 flex flex-col gap-6">

            <!-- Статус и Управление -->
            <div class="p-5 bg-gray-50 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Control Panel <!-- Translated -->
                </h2>
                <button id="start-button" class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Start Training</span> <!-- Translated -->
                </button>
                <div class="mt-5">
                    <div id="status-text" class="text-md font-medium text-gray-700 mb-2 truncate">
                        Ready to start training... <!-- Translated -->
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div id="progress-bar-inner" class="bg-blue-500 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Ключевые метрики -->
            <div class="p-5 bg-gray-50 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Key Metrics (Validation)</h2> <!-- Translated -->
                <div class="space-y-3">
                    <div class="flex justify-between items-baseline p-2 rounded-lg">
                        <span class="text-lg font-medium text-gray-600">Diagnosis Accuracy:</span> <!-- Translated -->
                        <span id="accuracy-readout" class="text-3xl font-bold text-blue-600">---</span>
                    </div>
                    <div class="flex justify-between items-baseline p-2 rounded-lg">
                        <span class="text-lg font-medium text-gray-600">Error Rate:</span> <!-- Translated -->
                        <span id="loss-readout" class="text-3xl font-bold text-blue-600">---</span>
                    </div>
                    <div class="flex justify-between items-baseline p-2 rounded-lg">
                        <span class="text-lg font-medium text-gray-600">Precision:</span>
                        <span id="precision-readout" class="text-3xl font-bold text-blue-600">---</span>
                    </div>
                    <div class="flex justify-between items-baseline p-2 rounded-lg">
                        <span class="text-lg font-medium text-gray-600">Recall:</span>
                        <span id="recall-readout" class="text-3xl font-bold text-blue-600">---</span>
                    </div>
                    <div class="flex justify-between items-baseline p-2 rounded-lg">
                        <span class="text-lg font-medium text-gray-600">F1-Score:</span>
                        <span id="f1-readout" class="text-3xl font-bold text-blue-600">---</span>
                    </div>
                </div>
            </div>

            <!-- Параметры Модели -->
            <div class="p-5 bg-gray-50 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Model Parameters</h2> <!-- Translated -->
                <div class="space-y-2 text-md text-gray-600">
                    <p><strong>Model:</strong> <span>WoundNet-v3 (ResNet50)</span></p> <!-- Translated -->
                    <p><strong>Dataset:</strong> <span>"WoundCare-15k" (15,000+ images)</span></p> <!-- Translated -->
                    <p><strong>Classes:</strong> <span>3 (Necrosis, Granulation, Epithelialization)</span></p> <!-- Translated -->
                    <p><strong>Optimizer:</strong> <span>Adam</span></p> <!-- Translated -->
                </div>
            </div>

        </div>

        <!-- === КОЛОНКА 2 и 3: ГРАФИКИ И ДЕМО === -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- График 1: Уровень Ошибки (Loss) -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-lg font-semibold text-center text-gray-700 mb-4">Error Rate (Loss)</h2> <!-- Translated -->
                <canvas id="lossChart"></canvas>
            </div>

            <!-- График 2: Точность Диагноза (Accuracy) -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-lg font-semibold text-center text-gray-700 mb-4">Diagnosis Accuracy (Accuracy)</h2> <!-- Translated -->
                <canvas id="accuracyChart"></canvas>
            </div>

            <!-- График 3: Точность (Precision) -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-lg font-semibold text-center text-gray-700 mb-4">Precision</h2> <!-- Translated -->
                <canvas id="precisionChart"></canvas>
            </div>

            <!-- График 4: Полнота (Recall) -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-lg font-semibold text-center text-gray-700 mb-4">Recall</h2> <!-- Translated -->
                <canvas id="recallChart"></canvas>
            </div>

            <!-- График 5: F1-Score (NEW) -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200">
                <h2 class="text-lg font-semibold text-center text-gray-700 mb-4">Aggregate Metric (F1-Score)</h2> <!-- Translated -->
                <canvas id="f1Chart"></canvas>
            </div>

            <!-- Панель "Живой Демонстрации" (NEW) -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-200 flex flex-col">
                <h2 class="text-lg font-semibold text-center text-gray-700 mb-4">Live Prediction Demo</h2> <!-- Translated -->
                <div class="flex-grow flex flex-col items-center justify-center bg-gray-100 rounded-lg p-4">
                    <!-- Изображение-заглушка -->
                    <img id="live-prediction-image"
                         src="https://placehold.co/300x200/e2e8f0/94a3b8?text=Wound+Image"
                         alt="Wound image sample"
                         class="rounded-lg shadow-md mb-4 w-full max-w-[300px] aspect-video object-cover"
                         onerror="this.src='https://placehold.co/300x200/e2e8f0/94a3b8?text=Image+Error'"> <!-- Translated -->

                    <div class="text-center">
                        <p class="text-md font-medium text-gray-600">True Diagnosis:
                            <span id="live-truth-text" class="font-bold text-green-700">Stage 2 (Granulation)</span> <!-- Translated -->
                        </p>
                        <p id="live-prediction-text-wrapper" class="text-lg font-semibold mt-2 text-gray-700">Network Prediction:
                            <span id="live-prediction-text" class="text-gray-500 font-bold">...waiting...</span> <!-- Translated -->
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // --- Получение элементов DOM ---
    const lossCanvas = document.getElementById('lossChart').getContext('2d');
    const accuracyCanvas = document.getElementById('accuracyChart').getContext('2d');
    const precisionCanvas = document.getElementById('precisionChart').getContext('2d');
    const recallCanvas = document.getElementById('recallChart').getContext('2d');
    const f1Canvas = document.getElementById('f1Chart').getContext('2d'); // Новый

    const startButton = document.getElementById('start-button');
    const statusText = document.getElementById('status-text');
    const progressBar = document.getElementById('progress-bar-inner');

    // Элементы "readout"
    const readouts = {
        accuracy: document.getElementById('accuracy-readout'),
        loss: document.getElementById('loss-readout'),
        precision: document.getElementById('precision-readout'),
        recall: document.getElementById('recall-readout'),
        f1: document.getElementById('f1-readout')
    };

    // Элементы "live demo"
    const liveImage = document.getElementById('live-prediction-image');
    const livePredictionText = document.getElementById('live-prediction-text');
    const liveTruthText = document.getElementById('live-truth-text');

    // URL-заглушки для изображений
    const imgPlaceholder1 = "https://placehold.co/300x200/e2e8f0/94a3b8?text=Test+Sample+1"; // Translated
    const imgPlaceholder2 = "https://placehold.co/300x200/dbeafe/3b82f6?text=Test+Sample+2"; // Translated


    let lossChart, accuracyChart, precisionChart, recallChart, f1Chart;
    const TOTAL_EPOCHS = 100; // Общее количество эпох для симуляции
    const SIMULATION_SPEED_MS = 100; // Скорость симуляции (мс на эпоху)

    // --- Функция для создания пустого графика ---
    function createChart(ctx, label, color1, color2) {
        return new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // Метки (Эпохи)
                datasets: [
                    {
                        label: 'Training', // Translated
                        data: [],
                        borderColor: color1 || 'rgba(59, 130, 246, 1)', // Синий
                        backgroundColor: (color1 || 'rgba(59, 130, 246, 1)').replace('1)', '0.1)'),
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3 // Сглаживание линии
                    },
                    {
                        label: 'Validation', // Translated
                        data: [],
                        borderColor: color2 || 'rgba(16, 185, 129, 1)', // Зеленый
                        backgroundColor: (color2 || 'rgba(16, 185, 129, 1)').replace('1)', '0.1)'),
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                animation: {
                    duration: 0 // Отключаем анимацию Chart.js
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Epoch' } // Translated
                    },
                    y: {
                        title: { display: true, text: label },
                        min: 0,
                        max: (label.includes('Accuracy') || label.includes('Recall') || label.includes('F1')) ? 1.0 : undefined // Adjusted check for English
                    }
                },
                plugins: {
                    legend: { position: 'top', }
                }
            }
        });
    }

    // --- Инициализация графиков ---
    window.onload = () => {
        lossChart = createChart(lossCanvas, 'Error Rate (Loss)', 'rgba(239, 68, 68, 1)', 'rgba(249, 115, 22, 1)'); // Red, Orange
        accuracyChart = createChart(accuracyCanvas, 'Diagnosis Accuracy (Accuracy)', 'rgba(59, 130, 246, 1)', 'rgba(16, 185, 129, 1)'); // Blue, Green
        precisionChart = createChart(precisionCanvas, 'Precision', 'rgba(59, 130, 246, 1)', 'rgba(16, 185, 129, 1)');
        recallChart = createChart(recallCanvas, 'Recall', 'rgba(59, 130, 246, 1)', 'rgba(16, 185, 129, 1)');
        f1Chart = createChart(f1Canvas, 'Aggregate (F1-Score)', 'rgba(139, 92, 246, 1)', 'rgba(217, 70, 239, 1)'); // Violet, Fuchsia
    };

    // --- Функция очистки графиков и индикаторов ---
    function resetCharts() {
        const charts = [lossChart, accuracyChart, precisionChart, recallChart, f1Chart];
        charts.forEach(chart => {
            if(chart) {
                chart.data.labels = [];
                chart.data.datasets[0].data = [];
                chart.data.datasets[1].data = [];
                chart.update('none'); // Обновляем без анимации
            }
        });

        progressBar.style.width = '0%';

        // Сброс индикаторов
        Object.values(readouts).forEach(el => el.textContent = "---");
        livePredictionText.textContent = "...waiting..."; // Translated
        livePredictionText.className = "text-gray-500 font-bold";
        liveImage.src = imgPlaceholder1;
        liveTruthText.textContent = "Stage 2 (Granulation)"; // Translated
    }

    // --- Функция для мигания индикатора ---
    function flashReadout(element) {
        element.parentElement.classList.add('metric-updated');
        setTimeout(() => element.parentElement.classList.remove('metric-updated'), 500);
    }

    // --- Функция симуляции обучения ---
    async function startTraining() {
        startButton.disabled = true;
        startButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Training in progress...</span>`; // Translated
        startButton.classList.add('opacity-75', 'cursor-not-allowed');

        resetCharts();

        let currentEpoch = 0;

        // --- Генераторы симуляционных данных ---
        function getSimulatedLoss(epoch) {
            let baseLoss = 0.8 * Math.exp(-epoch / (TOTAL_EPOCHS / 4)) + 0.05;
            let noise = (Math.random() - 0.5) * (0.5 / (epoch + 1));
            return Math.max(0.01, baseLoss + noise);
        }

        function getSimulatedAccuracy(epoch) {
            let baseAccuracy = 0.85 * (1 - Math.exp(-epoch / (TOTAL_EPOCHS / 5))) + 0.105;
            let noise = (Math.random() - 0.5) * (0.3 / (epoch + 1));
            return Math.min(0.99, Math.max(0.1, baseAccuracy + noise));
        }

        function getSimulatedPrecision(epoch) {
            let basePrecision = 0.92 * (1 - Math.exp(-epoch / (TOTAL_EPOCHS / 4.5))) + 0.12;
            let noise = (Math.random() - 0.5) * (0.2 / (epoch + 1));
            return Math.min(0.98, Math.max(0.12, basePrecision + noise));
        }

        function getSimulatedRecall(epoch) {
            let baseRecall = 0.97 * (1 - Math.exp(-epoch / (TOTAL_EPOCHS / 5.5))) + 0.08;
            let noise = (Math.random() - 0.5) * (0.25 / (epoch + 1));
            return Math.min(0.99, Math.max(0.08, baseRecall + noise));
        }

        function getSimulatedF1(precision, recall) {
            if (precision + recall === 0) return 0;
            return 2 * (precision * recall) / (precision + recall);
        }

        // --- Цикл по эпохам ---
        function runEpoch() {
            if (currentEpoch >= TOTAL_EPOCHS) {
                statusText.textContent = `Training complete! Final accuracy: ${(readouts.accuracy.textContent)}`; // Translated
                startButton.disabled = false;
                startButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Start Training</span>`; // Translated
                startButton.classList.remove('opacity-75', 'cursor-not-allowed');
                return;
            }

            currentEpoch++;

            // --- Генерируем данные ---
            const trainLoss = getSimulatedLoss(currentEpoch);
            const valLoss = trainLoss + Math.random() * 0.05 + (currentEpoch > TOTAL_EPOCHS * 0.7 ? Math.random() * 0.02 * (currentEpoch - TOTAL_EPOCHS * 0.7) : 0);

            const trainAcc = getSimulatedAccuracy(currentEpoch);
            const valAcc = trainAcc - Math.random() * 0.01 - (currentEpoch > TOTAL_EPOCHS * 0.7 ? Math.random() * 0.001 * (currentEpoch - TOTAL_EPOCHS * 0.7) : 0);

            const trainPrecision = getSimulatedPrecision(currentEpoch);
            const valPrecision = trainPrecision - Math.random() * 0.04;

            const trainRecall = getSimulatedRecall(currentEpoch);
            const valRecall = trainRecall - Math.random() * 0.02;

            const trainF1 = getSimulatedF1(trainPrecision, trainRecall);
            const valF1 = getSimulatedF1(valPrecision, valRecall);

            // --- Обновляем UI ---
            statusText.textContent = `Epoch: ${currentEpoch}/${TOTAL_EPOCHS} | Acc (val): ${(valAcc * 100).toFixed(2)}% | Loss (val): ${valLoss.toFixed(4)}`; // Translated
            progressBar.style.width = (currentEpoch / TOTAL_EPOCHS) * 100 + '%';

            // --- Обновляем цифровые индикаторы ---
            readouts.accuracy.textContent = `${(valAcc * 100).toFixed(1)}%`;
            readouts.loss.textContent = `${valLoss.toFixed(3)}`;
            readouts.precision.textContent = `${(valPrecision * 100).toFixed(1)}%`;
            readouts.recall.textContent = `${(valRecall * 100).toFixed(1)}%`;
            readouts.f1.textContent = `${(valF1 * 100).toFixed(1)}%`;

            // Мигаем индикаторами
            if (currentEpoch % 5 === 0) {
                Object.values(readouts).forEach(flashReadout);
            }

            // --- Обновляем "Живую Демонстрацию" ---
            if (currentEpoch === 1) {
                livePredictionText.textContent = "Analyzing..."; // Translated
                livePredictionText.className = "text-gray-500 font-bold animate-pulse";
            } else if (currentEpoch === 15) {
                livePredictionText.textContent = "Prediction: Stage 1 (Necrosis)"; // Translated
                livePredictionText.className = "text-red-600 font-bold";
                liveImage.src = imgPlaceholder2; // Меняем картинку
            } else if (currentEpoch === 40) {
                livePredictionText.textContent = "Prediction: Stage 2 (Granulation)"; // Translated
                livePredictionText.className = "text-green-600 font-bold";
                liveImage.src = imgPlaceholder1; // Меняем картинку
            } else if (currentEpoch === 70) {
                liveTruthText.textContent = "Stage 3 (Epithelialization)"; // Translated
                livePredictionText.textContent = "Prediction: Stage 3 (Epithelialization)"; // Translated
                liveImage.src = imgPlaceholder2;
            }

            // --- Обновляем графики ---
            const allCharts = [lossChart, accuracyChart, precisionChart, recallChart, f1Chart];
            allCharts.forEach(chart => chart.data.labels.push(currentEpoch));

            lossChart.data.datasets[0].data.push(trainLoss);
            lossChart.data.datasets[1].data.push(valLoss);

            accuracyChart.data.datasets[0].data.push(trainAcc);
            accuracyChart.data.datasets[1].data.push(valAcc);

            precisionChart.data.datasets[0].data.push(trainPrecision);
            precisionChart.data.datasets[1].data.push(valPrecision);

            recallChart.data.datasets[0].data.push(trainRecall);
            recallChart.data.datasets[1].data.push(valRecall);

            f1Chart.data.datasets[0].data.push(trainF1);
            f1Chart.data.datasets[1].data.push(valF1);

            allCharts.forEach(chart => chart.update('none'));

            // Запускаем следующую эпоху
            setTimeout(runEpoch, SIMULATION_SPEED_MS);
        }

        runEpoch();
    }

    startButton.addEventListener('click', startTraining);

</script>
</body>
</html>

