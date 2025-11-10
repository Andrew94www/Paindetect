<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Pain & Risk Analysis Dashboard</title>

    <!-- Load Chart.js for graphs --><script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Load Google Font --><link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        /* --- Hyper-AI Theme --- */
        :root {
            --bg-primary: #0d1117;
            --bg-secondary: rgba(22, 27, 34, 0.85);
            --bg-tertiary: #21262d;
            --text-primary: #f0f6fc;
            --text-secondary: #bdbdbd;
            --border-color: #30363d;
            --accent-blue: #00aaff;
            --accent-blue-dark: #007bff;
            --accent-red: #ff5566;
            --accent-yellow: #ffc107;
            --accent-green: #28a745;
            --accent-purple: #9b59b6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Added fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            font-family: 'Inter', sans-serif;
            font-weight: 300; /* Lighter font */
            background-color: var(--bg-primary);
            background: radial-gradient(ellipse at top center, rgba(0, 170, 255, 0.1), var(--bg-primary) 70%), var(--bg-primary);
            color: var(--text-primary);
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align to top */
            min-height: 100vh;
        }

        /* --- Dashboard Layout (Unchanged) --- */
        .dashboard-container {
            width: 100%;
            max-width: 1920px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .column-wrapper {
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-width: 0;
        }

        @media (min-width: 1200px) {
            .dashboard-container {
                grid-template-columns: 380px 1.2fr 1fr;
            }
        }
        /* --- END --- */


        /* --- Card Styles --- */
        .card {
            /* Frosted Glass Effect */
            background-color: var(--bg-secondary);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);

            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: fadeIn 0.5s ease-out;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            padding-bottom: 5px;
            border-left: 3px solid var(--accent-blue);
            padding-left: 10px;
        }

        /* --- Form Elements --- */
        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 400;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(0, 170, 255, 0.3);
        }

        input[type="text"][readonly] {
            background-color: #21262d;
            cursor: not-allowed;
            color: var(--text-secondary);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* --- Range Slider Styles --- */
        .range-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .range-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .range-label span {
            font-weight: 700;
            color: var(--text-primary);
        }

        input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 8px;
            background: var(--bg-tertiary);
            border-radius: 5px;
            outline: none;
            border: 1px solid var(--border-color);
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            background: var(--accent-blue);
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid var(--bg-secondary);
            transition: background-color 0.2s, box-shadow 0.3s;
        }

        input[type="range"]::-webkit-slider-thumb:hover {
            background: var(--accent-blue-dark);
            box-shadow: 0 0 10px var(--accent-blue);
        }

        /* --- Button Styles (Solid) --- */
        .button-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }

        .btn {
            padding: 12px 15px;
            font-size: 0.95rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
        }

        .btn-primary {
            background-color: var(--accent-blue-dark);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--accent-blue);
            opacity: 1;
            box-shadow: 0 0 15px rgba(0, 170, 255, 0.5);
        }

        .btn-danger {
            background-color: var(--accent-red);
            color: white;
        }
        .btn-danger:hover {
            background-color: #ff3344;
            opacity: 1;
            box-shadow: 0 0 15px rgba(255, 85, 102, 0.5);
        }

        .btn-warning {
            background-color: var(--accent-yellow);
            color: var(--bg-primary);
            font-weight: 700;
        }
        .btn-warning:hover {
            background-color: #ffd65a;
            opacity: 1;
            box-shadow: 0 0 15px rgba(255, 193, 7, 0.5);
        }
        /* --- END --- */


        /* --- Canvas & Face Picker --- */
        #pain-canvas {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background-color: #000;
            background: url('img/R_PAT_.png'); /* Placeholder */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            touch-action: none;
            width: 100%;
            height: auto;
            aspect-ratio: 4 / 3;
            cursor: crosshair;
        }

        .face-picker {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 10px;
        }

        .face-option-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 60px;
        }

        .face-option {
            width: 50px;
            height: 50px;
            cursor: pointer;
            border-radius: 50%;
            border: 3px solid transparent;
            transition: all 0.3s ease;
            object-fit: cover;
            background-color: var(--bg-tertiary);
        }

        .face-option:hover {
            transform: scale(1.1);
        }

        .face-option.active {
            transform: scale(1.1);
            border-color: var(--accent-blue);
            box-shadow: 0 0 15px var(--accent-blue);
        }

        .face-option-wrapper span {
            font-size: 11px;
            margin-top: 5px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .pain-localization-grid {
            display: grid;
            grid-template-columns: 1fr; /* Stack by default */
            gap: 20px;
        }

        @media (min-width: 768px) {
            .pain-localization-grid {
                grid-template-columns: 1fr 300px; /* Side-by-side on tablets+ */
            }
        }

        /* --- Medication Inputs --- */
        .medication-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .medication-row {
            display: grid;
            grid-template-columns: 80px 1fr 80px 80px;
            gap: 10px;
            align-items: center;
        }
        .medication-row label {
            margin-bottom: 0;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        /* Strong Opioid Details */
        #strong-opioid-details {
            display: none; /* Hidden by default */
            grid-template-columns: 1fr 100px 1fr 100px;
            gap: 10px;
            align-items: center;
            background: var(--bg-tertiary);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        /* --- Metrics & AI Dashboard (Gauge Styles) --- */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .metric-gauge {
            position: relative;
            text-align: center;
            background-color: var(--bg-tertiary);
            padding: 15px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .metric-gauge canvas {
            max-width: 100%;
            height: auto;
        }

        .metric-gauge-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -60%); /* Adjust vertical */
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .metric-gauge-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            margin-top: -15px; /* Pull label up */
        }

        /* AI Analysis Module */
        .ai-analysis-grid {
            display: grid;
            grid-template-columns: 1fr; /* Stack summary and radar */
            gap: 20px;
            align-items: center;
        }

        #ai-summary {
            background-color: var(--bg-tertiary);
            padding: 20px;
            border-radius: 12px;
            font-size: 0.95rem;
            line-height: 1.6;
            border-left: 4px solid var(--accent-blue);
            font-style: italic;
            color: var(--text-primary);
        }

        /* NEW: Light theme for charts */
        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
            /* NEW: Light theme */
            background-color: #ffffff;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        /* --- END NEW --- */


        /* Links */
        .link-group {
            display: grid;
            /* NEW: Change to 2 columns for more prominence */
            grid-template-columns: 1fr 1fr;
            gap: 15px; /* Increased gap */
        }
        .btn-link {
            /* NEW: Updated style */
            background: var(--bg-primary); /* Darker background */
            color: var(--accent-blue); /* Blue text */
            border: 1px solid var(--accent-blue); /* Blue border */
            text-align: center;
            font-size: 0.9rem; /* Slightly larger */
            font-weight: 500;
            padding: 12px 5px; /* Taller */
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-link:hover {
            color: var(--text-primary); /* White text on hover */
            background: var(--accent-blue); /* Blue background on hover */
            border-color: var(--accent-blue);
            box-shadow: 0 0 15px rgba(0, 170, 255, 0.5); /* Glow on hover */
        }


        /* Responsive Adjustments for medication rows */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .dashboard-container {
                gap: 15px;
            }
            .card {
                padding: 15px;
            }
            .medication-row, #strong-opioid-details {
                grid-template-columns: 1fr 1fr; /* Stack inputs */
            }
            .medication-row label {
                grid-column: 1 / -1; /* Label spans full width */
                margin-bottom: 5px;
            }
        }

    </style>
</head>

<body>

<div class="dashboard-container">

    <!-- Column 1: Inputs & Actions --><div class="column-wrapper">

        <div class="card">
            <h2 class="card-title">Pain Index Components</h2>
            <div class="pi-input-group">
                <label for="input-intensity">Pain Intensity (0-10):</label>
                <input type="number" id="input-intensity" min="0" max="10" value="0">
            </div>
            <div class="pi-input-group">
                <label for="select-frequency">Frequency (Usual Pain Hours/day):</label>
                <select id="select-frequency">
                    <option value="1">1-2 hours</option>
                    <option value="2">3-6 hours</option>
                    <option value="3">6-8 hours</option>
                    <option value="4">9-12 hours</option>
                    <option value="5">12-18 hours</option>
                    <option value="6">18-24 hours</option>
                </select>
            </div>
            <div class="pi-input-group">
                <label for="select-duration">Duration (Worst Pain Hours/day):</label>
                <select id="select-duration">
                    <option value="1">1-2 hours</option>
                    <option value="2">3-6 hours</option>
                    <option value="3">6-8 hours</option>
                    <option value="4">9-12 hours</option>
                    <option value="5">12-18 hours</option>
                    <option value="6">18-24 hours</option>
                </select>
            </div>
            <div class="pi-input-group">
                <label for="select-impact">Functional Impact (Last 2 weeks):</label>
                <select id="select-impact">
                    <option value="1">Not at all</option>
                    <option value="2">A little bit</option>
                    <option value="3">Moderately</option>
                    <option value="4">Very much</option>
                    <option value="5">Extremely</option>
                </select>
            </div>
        </div>

        <div class="card">
            <h2 class="card-title">Medication & Analgesia</h2>
            <div class="medication-group">
                <!-- Adjuvants --><div class="medication-row">
                    <label for="med-adjuvant-drug">Adjuvant:</label>
                    <select id="med-adjuvant-drug">
                        <option value="not_selected">Not selected</option>
                        <option value="lidocaine">Lidocaine</option>
                        <option value="bupivacaine">Bupivacaine</option>
                        <option value="ropivacaine">Ropivacaine</option>
                        <option value="amitriptyline">Amitriptyline</option>
                        <option value="dexamethasone">Dexamethasone</option>
                    </select>
                    <input type="number" id="med-adjuvant-dose" placeholder="Dose">
                    <select id="med-adjuvant-unit">
                        <option value="g">g</option>
                        <option value="ml">ml</option>
                        <option value="mg" selected>mg</option>
                        <option value="mkg">mkg</option>
                    </select>
                </div>
                <!-- NSAID --><div class="medication-row">
                    <label for="med-nsaid-drug">NSAID:</label>
                    <select id="med-nsaid-drug">
                        <option value="not_selected">Not selected</option>
                        <option value="paracetamolum">Paracetamolum</option>
                        <option value="ibuprofen">Ibuprofen</option>
                        <option value="aspirin">Aspirin</option>
                        <option value="analgin">Analgin</option>
                        <option value="diclofenac">Diclofenac</option>
                        <option value="nimesulide">Nimesulide</option>
                        <option value="ketorolac">Ketorolac</option>
                    </select>
                    <input type="number" id="med-nsaid-dose" placeholder="Dose">
                    <select id="med-nsaid-unit">
                        <option value="g">g</option>
                        <option value="mg" selected>mg</option>
                        <option value="mkg">mkg</option>
                    </select>
                    <input type="number" id="med-nsaid-multi" placeholder="Times/day">
                </div>
                <!-- Weak Opioid --><div class="medication-row">
                    <label for="med-weak-drug">Weak Opioid:</label>
                    <select id="med-weak-drug">
                        <option value="not_selected">Not selected</option>
                        <option value="codeine">Codeine</option>
                        <option value="dihydrocodeine">Dihydrocodeine</option>
                        <option value="tramadol">Tramadol</option>
                    </select>
                    <input type="number" id="med-weak-dose" placeholder="Dose">
                    <select id="med-weak-unit">
                        <option value="g">g</option>
                        <option value="mg" selected>mg</option>
                        <option value="mkg">mkg</option>
                    </select>
                    <input type="number" id="med-weak-multi" placeholder="Times/day">
                </div>
                <!-- Strong Opioid --><div class="medication-row">
                    <label for="med-strong-drug">Strong Opioid:</label>
                    <select id="med-strong-drug" style="grid-column: 2 / -1;">
                        <option value="not_selected" selected>-- Select Medication --</option>
                        <option value="morphine_oral">Morphine (Oral)</option>
                        <option value="oxycodone_oral">Oxycodone (Oral)</option>
                        <option value="fentanyl_td">Fentanyl (TD, Patch)</option>
                    </select>
                </div>
                <!-- Strong Opioid Details --><div id="strong-opioid-details">
                    <label for="strong-dose">Dose:</label>
                    <input type="number" id="strong-dose" placeholder="Dose" min="0">

                    <label for="strong-unit" id="strong-unit-label">Unit:</label>
                    <select id="strong-unit">
                        <option value="mg">mg</option>
                        <option value="mcg">mcg</option>
                    </select>

                    <div id="strong-multi-section">
                        <label for="strong-multi">Frequency/Day:</label>
                        <input type="number" id="strong-multi" placeholder="Times/Day" min="1" value="1">
                    </div>

                    <span id="fentanyl-unit-display" style="display: none; color: var(--text-secondary); grid-column: 3 / -1; align-self: center;">mcg/hour</span>
                </div>
                <div id="omedd-error" style="color: var(--accent-red); font-weight: 500; height: 20px; text-align: right;"></div>

            </div>
        </div>

        <div class="card">
            <h2 class="card-title">Actions & External Tools</h2>

            <label for="input-block-type">PNBs Type Block:</label>
            <input id="input-block-type" placeholder="Enter PNBs type block">

            <div class="button-group">
                <button class="btn btn-warning" id="btn-calculate">Calculate Metrics</button>
                <button class="btn btn-primary" id="btn-send">Send Data</button>
                <button class="btn btn-danger" id="btn-clear">Clear All</button>
            </div>

            <div class="link-group" style="margin-top: 15px;">
                <!-- These are now styled as disabled links, as requested --><a href="{{ route('getCamera') }}" class="btn btn-link">Camera</a>
                <a href="{{ route('vision') }}" class="btn btn-link">Vision</a>
                <a href="#" class="btn btn-link">EKG</a>
                <a href="{{ route('interaction') }}" class="btn btn-link">Interaction</a>
                <a href="{{ route('tcare') }}" class="btn btn-link">TCare</a>
                <a href="{{ route('repain') }}" class="btn btn-link">Repain</a>
                <a href="{{ route('protesys') }}" class="btn btn-link">Protesys</a>
                <a href="{{ route('wound') }}" class="btn btn-link">Wound</a>
            </div>
        </div>
    </div>

    <!-- Column 2: Pain Localization & Demographics --><div class="column-wrapper">
        <div class="card">
            <h2 class="card-title">Pain Localization & Demographics</h2>

            <div class="pain-localization-grid">
                <!-- Left side: Canvas --><div>
                    <canvas id="pain-canvas"></canvas>

                    <label for="input-type" style="margin-top: 20px;">Type of Pain:</label>
                    <textarea id="input-type" placeholder="e.g., Sharp, dull, throbbing, neuropathic..."></textarea>
                </div>

                <!-- Right side: Faces & Demographics --><div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label>Pain Level:</label>
                        <div class="face-picker">
                            <!-- Images are placeholders. Replace 'src' with your actual image paths --><div class="face-option-wrapper">
                                <img class="face-option" src="https://placehold.co/50x50/006400/FFF?text=0" alt="No Pain" data-color="#006400" data-level="0">
                                <span>No Pain</span>
                            </div>
                            <div class="face-option-wrapper">
                                <img class="face-option" src="https://placehold.co/50x50/ADFF2F/000?text=2" alt="Very Mild Pain" data-color="#ADFF2F" data-level="2">
                                <span>Very Mild</span>
                            </div>
                            <div class="face-option-wrapper">
                                <img class="face-option" src="https://placehold.co/50x50/FFFF00/000?text=4" alt="Mild Pain" data-color="#FFFF00" data-level="4">
                                <span>Mild</span>
                            </div>
                            <div class="face-option-wrapper">
                                <img class="face-option" src="https://placehold.co/50x50/FFA500/000?text=6" alt="Moderate Pain" data-color="#FFA500" data-level="6">
                                <span>Moderate</span>
                            </div>
                            <div class="face-option-wrapper">
                                <img class="face-option" src="https://placehold.co/50x50/8B4513/FFF?text=8" alt="Severe Pain" data-color="#8B4513" data-level="8">
                                <span>Severe</span>
                            </div>
                            <div class="face-option-wrapper">
                                <img class="face-option" src="https://placehold.co/50x50/FF0000/FFF?text=10" alt="Worst Pain" data-color="#FF0000" data-level="10">
                                <span>Worst</span>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="background-color: var(--bg-tertiary); padding: 20px;">
                        <h3 class="card-title" style="padding-bottom: 15px; margin-bottom: 15px;">Patient Demographics</h3>
                        <div class="range-group">
                            <label class="range-label" for="slider-age">Age: <span id="value-age">25</span> years</label>
                            <input type="range" id="slider-age" min="10" max="100" value="25">
                        </div>
                        <div class="range-group">
                            <label class="range-label" for="slider-weight">Weight: <span id="value-weight">70</span> kg</label>
                            <input type="range" id="slider-weight" min="30" max="150" value="70">
                        </div>
                        <div class="range-group">
                            <label class="range-label" for="slider-height">Height: <span id="value-height">170</span> cm</label>
                            <input type="range" id="slider-height" min="100" max="220" value="170">
                        </div>
                    </div>

                    <div class="card" style="background-color: var(--bg-tertiary); padding: 20px;">
                        <label for="input-history-id">Medical History ID:</label>
                        <input id="input-history-id" name="hystory_name" placeholder="Enter medical history ID">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Column 3: AI & Metrics --><div class="column-wrapper">
        <div class="card">
            <h2 class="card-title">AI Analysis & Metrics Dashboard</h2>

            <!-- Key Metrics as Gauges --><div class="metrics-grid">
                <div class="metric-gauge">
                    <canvas id="gauge-pi"></canvas>
                    <div class="metric-gauge-value" id="value-pi">0.0</div>
                    <div class="metric-gauge-label">Pain Index</div>
                </div>
                <div class="metric-gauge">
                    <canvas id="gauge-omedd"></canvas>
                    <div class="metric-gauge-value" id="value-omedd">0.0</div>
                    <div class="metric-gauge-label">oMEDD</div>
                </div>
                <div class="metric-gauge">
                    <canvas id="gauge-ai"></canvas>
                    <div class="metric-gauge-value" id="value-ai">0</div>
                    <div class="metric-gauge-label">Analgesic Index</div>
                </div>
                <div class="metric-gauge">
                    <canvas id="gauge-risk"></canvas>
                    <div class="metric-gauge-value" id="value-risk">0</div>
                    <div class="metric-gauge-label">AI Risk Score</div>
                </div>
            </div>


            <!-- AI Analysis --><div class="ai-analysis-grid">
                <div id="ai-summary">AI analysis will appear here after calculation...</div>
                <!-- NEW: Light-themed container for Radar chart --><div class="chart-container" style="height: 350px;">
                    <canvas id="riskRadarChart"></canvas>
                </div>
            </div>

            <!-- Bar Chart --><!-- NEW: Light-themed container for Bar chart --><div class="chart-container">
                <canvas id="metricsBarChart"></canvas>
            </div>

            <!-- Pain Control Readout --><div class="metric-gadget" id="metric-pc" style="background-color: var(--bg-primary); text-align: left; padding: 15px 20px;">
                <span class="metric-label" style="font-size: 1rem;">Pain Control Status:</span>
                <span id="value-pc" class="metric-value" style="font-size: 1.5rem; color: var(--accent-purple); float: right;">N/A</span>
            </div>
        </div>
    </div>

</div>

<script>
    // --- Global Variables ---
    const canvas = document.getElementById('pain-canvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;
    let lineWidth = 5;
    ctx.lineWidth = lineWidth;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.globalAlpha = 0.8; // Semi-transparent drawing
    ctx.strokeStyle = 'var(--accent-red)'; // NEW: Default to red for drawing

    let riskRadarChart, metricsBarChart, piGaugeChart, omeddGaugeChart, aiGaugeChart, riskGaugeChart;

    // --- Gauge Chart Colors ---
    const gaugeColors = {
        pi: {
            color: 'var(--accent-yellow)',
            bg: 'rgba(255, 193, 7, 0.2)'
        },
        omedd: {
            color: 'var(--accent-red)',
            bg: 'rgba(255, 85, 102, 0.2)'
        },
        ai: {
            color: 'var(--accent-green)',
            bg: 'rgba(40, 167, 69, 0.2)'
        },
        risk: {
            color: 'var(--accent-blue)',
            bg: 'rgba(0, 170, 255, 0.2)'
        }
    };

    // --- DOM Elements ---
    const elements = {
        // Inputs
        intensity: document.getElementById('input-intensity'),
        frequency: document.getElementById('select-frequency'),
        duration: document.getElementById('select-duration'),
        impact: document.getElementById('select-impact'),
        age: document.getElementById('slider-age'),
        weight: document.getElementById('slider-weight'),
        height: document.getElementById('slider-height'),
        painType: document.getElementById('input-type'),
        historyId: document.getElementById('input-history-id'),
        blockType: document.getElementById('input-block-type'),

        // Sliders Values
        ageValue: document.getElementById('value-age'),
        weightValue: document.getElementById('value-weight'),
        heightValue: document.getElementById('value-height'),

        // Medication
        adjuvant: {
            drug: document.getElementById('med-adjuvant-drug'),
            dose: document.getElementById('med-adjuvant-dose'),
            unit: document.getElementById('med-adjuvant-unit')
        },
        nsaid: {
            drug: document.getElementById('med-nsaid-drug'),
            dose: document.getElementById('med-nsaid-dose'),
            unit: document.getElementById('med-nsaid-unit'),
            multi: document.getElementById('med-nsaid-multi')
        },
        weak: {
            drug: document.getElementById('med-weak-drug'),
            dose: document.getElementById('med-weak-dose'),
            unit: document.getElementById('med-weak-unit'),
            multi: document.getElementById('med-weak-multi')
        },
        strong: {
            drug: document.getElementById('med-strong-drug'),
            details: document.getElementById('strong-opioid-details'),
            dose: document.getElementById('strong-dose'),
            unit: document.getElementById('strong-unit'),
            unitLabel: document.getElementById('strong-unit-label'),
            multiSection: document.getElementById('strong-multi-section'),
            multi: document.getElementById('strong-multi'),
            fentanylDisplay: document.getElementById('fentanyl-unit-display'),
            error: document.getElementById('omedd-error')
        },

        // Metric Displays (Gauges + Text)
        piValue: document.getElementById('value-pi'),
        omeddValue: document.getElementById('value-omedd'),
        aiValue: document.getElementById('value-ai'),
        riskValue: document.getElementById('value-risk'),
        pcValue: document.getElementById('value-pc'),
        aiSummary: document.getElementById('ai-summary'),

        // Buttons
        calcButton: document.getElementById('btn-calculate'),
        sendButton: document.getElementById('btn-send'),
        clearButton: document.getElementById('btn-clear')
    };

    // --- Canvas Logic ---
    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = rect.height;
        ctx.lineWidth = lineWidth;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.globalAlpha = 0.8;
        // NEW: Keep red as default stroke style, only override if face-option is active
        ctx.strokeStyle = document.querySelector('.face-option.active')?.getAttribute('data-color') || 'var(--accent-red)';
    }

    function getRelativePos(canvasEl, event) {
        const rect = canvasEl.getBoundingClientRect();
        let x, y;
        if (event.touches) {
            x = (event.touches[0].clientX - rect.left) * (canvasEl.width / rect.width);
            y = (event.touches[0].clientY - rect.top) * (canvasEl.height / rect.height);
        } else {
            x = (event.clientX - rect.left) * (canvasEl.width / rect.width);
            y = (event.clientY - rect.top) * (canvasEl.height / rect.height);
        }
        return { x, y };
    }

    function startDrawing(e) {
        e.preventDefault();
        const pos = getRelativePos(canvas, e);
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }

    function draw(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const pos = getRelativePos(canvas, e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }

    function stopDrawing() {
        isDrawing = false;
        ctx.closePath();
    }

    // --- NEW: Animation Helper ---
    function animateValue(obj, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);

            // Check if it needs 1 decimal (oMEDD or Pain Index)
            if (obj.id === 'value-omedd' || obj.id === 'value-pi') {
                obj.innerHTML = (progress * (end - start) + start).toFixed(1);
            } else {
                obj.innerHTML = Math.floor(progress * (end - start) + start).toFixed(0);
            }

            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // --- Chart Logic (Gauges) ---

    // Helper to create a gauge
    function createGauge(canvasId, color, bgColor) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [0, 100], // [value, remaining]
                    backgroundColor: [color, bgColor],
                    borderColor: [color, bgColor],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                rotation: -135,
                circumference: 270,
                cutout: '80%',
                plugins: {
                    tooltip: { enabled: false },
                    legend: { display: false }
                },
                animation: {
                    animateRotate: true,
                    animateScale: false
                }
            }
        });
    }

    function initializeCharts() {
        /* NEW: Light theme for charts */
        const chartFontColor = '#333333';
        const chartGridColor = '#e0e0e0';

        // --- Create Gauges (These stay dark) ---
        piGaugeChart = createGauge('gauge-pi', gaugeColors.pi.color, gaugeColors.pi.bg);
        omeddGaugeChart = createGauge('gauge-omedd', gaugeColors.omedd.color, gaugeColors.omedd.bg);
        aiGaugeChart = createGauge('gauge-ai', gaugeColors.ai.color, gaugeColors.ai.bg);
        riskGaugeChart = createGauge('gauge-risk', gaugeColors.risk.color, gaugeColors.risk.bg);

        // --- Create Radar Chart (Light theme) ---
        const ctxRadar = document.getElementById('riskRadarChart').getContext('2d');
        riskRadarChart = new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: ['Pain Index', 'Opioid Risk', 'Functional Impact', 'Age Factor', 'Analgesic Gap'],
                datasets: [{
                    label: 'Risk Profile',
                    data: [0, 0, 0, 0, 0],
                    fill: true,
                    backgroundColor: 'rgba(0, 170, 255, 0.2)',
                    borderColor: 'rgb(0, 170, 255)',
                    pointBackgroundColor: 'rgb(0, 170, 255)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(0, 170, 255)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { color: chartGridColor },
                        grid: { color: chartGridColor },
                        pointLabels: { color: chartFontColor, font: { size: 12 } },
                        ticks: {
                            backdropColor: '#ffffff', // Light bg
                            color: chartFontColor, // Dark text
                            stepSize: 25,
                            max: 100,
                            min: 0
                        }
                    }
                },
                plugins: {
                    legend: { labels: { color: chartFontColor } } // Dark text
                }
            }
        });

        // --- Create Bar Chart (Light theme) ---
        const ctxBar = document.getElementById('metricsBarChart').getContext('2d');
        metricsBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Pain Index', 'Analgesic Index'],
                datasets: [{
                    label: 'Pain vs. Analgesia',
                    data: [0, 0],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.5)', // Yellow for Pain
                        'rgba(40, 167, 69, 0.5)'  // Green for Analgesia
                    ],
                    borderColor: [
                        'rgb(255, 193, 7)',
                        'rgb(40, 167, 69)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100, // Scale 0-100
                        grid: { color: chartGridColor },
                        ticks: { color: chartFontColor } // Dark text
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: chartFontColor } // Dark text
                    }
                },
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Pain vs. Analgesic Index Comparison',
                        color: chartFontColor, // Dark text
                        font: { size: 16 }
                    }
                }
            }
        });
    }

    // --- Update Chart Function ---
    function updateCharts(pi, omedd, ai, risk, riskComponents) {
        // Define max values for gauges
        const piMax = 100;
        const omeddMax = 120; // Max for gauge (risk rises fast > 90)
        const aiMax = 100;
        const riskMax = 100;

        // Clamp values
        let piVal = Math.min(pi, piMax);
        let omeddVal = Math.min(omedd, omeddMax);
        let aiVal = Math.min(ai, aiMax);
        let riskVal = Math.min(risk, riskMax);

        // Update Gauges
        piGaugeChart.data.datasets[0].data = [piVal, Math.max(0, piMax - piVal)];
        omeddGaugeChart.data.datasets[0].data = [omeddVal, Math.max(0, omeddMax - omeddVal)];
        aiGaugeChart.data.datasets[0].data = [aiVal, Math.max(0, aiMax - aiVal)];
        riskGaugeChart.data.datasets[0].data = [riskVal, Math.max(0, riskMax - riskVal)];

        piGaugeChart.update();
        omeddGaugeChart.update();
        aiGaugeChart.update();
        riskGaugeChart.update();

        // Update Radar Chart
        riskRadarChart.data.datasets[0].data = [
            riskComponents.pain,
            riskComponents.opioid,
            riskComponents.impact,
            riskComponents.age,
            riskComponents.gap
        ];
        riskRadarChart.update();

        // Update Bar Chart
        metricsBarChart.data.datasets[0].data = [pi, ai];
        metricsBarChart.update();
    }

    // --- Calculation Logic ---
    function calculatePainIndex() {
        const intensity = parseFloat(elements.intensity.value) || 0;
        const frequency = parseFloat(elements.frequency.value) || 0;
        const duration = parseFloat(elements.duration.value) || 0;
        const impact = parseFloat(elements.impact.value) || 0;

        if (intensity > 10) elements.intensity.value = 10;
        if (intensity < 0) elements.intensity.value = 0;

        const rawPainIndex = (intensity * frequency * duration * impact) / 10;
        const scaledPainIndex = (rawPainIndex / 180) * 100; // Scale 0-180 to 0-100

        return Math.min(100, Math.max(0, scaledPainIndex)); // Clamp between 0 and 100
    }

    function calculateOmedd() {
        const drug = elements.strong.drug.value;
        const dose = parseFloat(elements.strong.dose.value);
        const unit = elements.strong.unit.value;
        const multi = parseInt(elements.strong.multi.value) || 1;

        elements.strong.error.textContent = '';

        if (drug === 'not_selected' || isNaN(dose) || dose <= 0) {
            return 0; // No drug or no dose
        }

        const conversionFactors = {
            'morphine_oral': { factor: 1, route: 'oral', expectedUnit: 'mg' },
            'oxycodone_oral': { factor: 1.5, route: 'oral', expectedUnit: 'mg' },
            'fentanyl_td': { factor: 2.4, route: 'td', expectedUnit: 'mcg/hr' }
        };

        const drugInfo = conversionFactors[drug];
        if (!drugInfo) {
            elements.strong.error.textContent = 'Conversion factor not found.';
            return 0;
        }

        let omedd = 0;
        try {
            if (drugInfo.route === 'oral') {
                let doseInMg = dose;
                if (unit === 'mcg') {
                    doseInMg = dose / 1000;
                } else if (unit !== 'mg') {
                    throw new Error(`Unexpected unit ${unit} for ${drug}`);
                }
                omedd = doseInMg * multi * drugInfo.factor;
            } else if (drugInfo.route === 'td') {
                omedd = dose * drugInfo.factor;
            }
        } catch (error) {
            elements.strong.error.textContent = error.message;
        }

        return omedd;
    }

    function calculateAnalgesicIndex() {
        const adjuvant = elements.adjuvant.drug.value !== 'not_selected' && parseFloat(elements.adjuvant.dose.value) > 0;
        const nsaid = elements.nsaid.drug.value !== 'not_selected' && parseFloat(elements.nsaid.dose.value) > 0;
        const weak = elements.weak.drug.value !== 'not_selected' && parseFloat(elements.weak.dose.value) > 0;
        const strong = elements.strong.drug.value !== 'not_selected' && parseFloat(elements.strong.dose.value) > 0;

        if (strong) return { value: 80, text: 'Step 3' };
        if (weak) return { value: 50, text: 'Step 2' };
        if (nsaid || adjuvant) return { value: 30, text: 'Step 1' };
        return { value: 0, text: 'Step 0' };
    }

    function calculatePainControl(painIntensity, omedd) {
        const highPain = 5; // Intensity >= 5
        const highOmedd = 90; // oMEDD >= 90 mg/day

        if (painIntensity < highPain) return "Controlled";
        if (painIntensity >= highPain && omedd < highOmedd) return "Uncontrolled (Under-medicated)";
        if (painIntensity >= highPain && omedd >= highOmedd) return "Uncontrolled (Refractory)";
        return "N/A";
    }

    function generateAIAnalysis(painIndex, omedd, functionalImpact, age, analgesicIndexValue) {
        functionalImpact = parseFloat(functionalImpact) || 0; // 1-5 scale
        age = parseFloat(age) || 0;

        // Risk Factors (scaled 0-100)
        const painRisk = painIndex;
        const opioidRisk = Math.min(100, (omedd / 120) * 100); // 100% risk at 120 oMEDD
        const impactRisk = (functionalImpact / 5) * 100;
        const ageRisk = Math.min(100, (age / 100) * 100);
        const analgesicGap = Math.max(0, painIndex - analgesicIndexValue); // Gap

        const totalRisk = (painRisk * 0.3) + (opioidRisk * 0.3) + (impactRisk * 0.2) + (ageRisk * 0.1) + (analgesicGap * 0.1);

        let summary = `AI ANALYSIS (Risk Score: ${totalRisk.toFixed(0)}):\n`;

        if (totalRisk > 75) {
            summary += "High-risk profile detected. Significant pain, high opioid load, or major functional impact. Recommend immediate specialist review and consideration of multimodal strategies.";
        } else if (totalRisk > 40) {
            summary += "Moderate-risk profile. Pain is impacting function or requires significant analgesia. Monitor closely and optimize non-opioid adjurants. Risk of chronic pain is elevated.";
        } else {
            summary += "Low-risk profile. Pain appears managed or is low-impact. Continue current monitoring. Focus on functional restoration.";
        }

        if (analgesicGap > 30) {
            summary += `\n\nFLAG: High analgesic gap (${analgesicGap.toFixed(0)} pts) suggests pain level may be undertreated.`;
        }
        if (opioidRisk > 75) { // omedd > 90
            summary += `\n\nFLAG: High oMEDD value. Monitor for Opioid Use Disorder (OUD) and adverse effects.`;
        }

        return {
            riskScore: totalRisk,
            summary: summary,
            riskComponents: {
                pain: painRisk,
                opioid: opioidRisk,
                impact: impactRisk,
                age: ageRisk,
                gap: analgesicGap
            }
        };
    }

    // --- Main Update Function ---
    function runAllCalculations() {
        // 1. Calculate all metrics
        const painIndex = calculatePainIndex();
        const omedd = calculateOmedd();
        const analgesicInfo = calculateAnalgesicIndex();
        const painControl = calculatePainControl(parseFloat(elements.intensity.value), omedd);

        const aiAnalysis = generateAIAnalysis(
            painIndex,
            omedd,
            elements.impact.value,
            elements.age.value,
            analgesicInfo.value
        );

        // 2. Update Metric Displays (Text Values)
        // NEW: Animate the values
        const duration = 750; // ms
        animateValue(elements.piValue, parseFloat(elements.piValue.textContent) || 0, painIndex, duration);
        animateValue(elements.omeddValue, parseFloat(elements.omeddValue.textContent) || 0, omedd, duration);
        animateValue(elements.aiValue, parseInt(elements.aiValue.textContent) || 0, analgesicInfo.value, duration);
        animateValue(elements.riskValue, parseInt(elements.riskValue.textContent) || 0, aiAnalysis.riskScore, duration);

        elements.pcValue.textContent = painControl;

        // 3. Update AI Module
        elements.aiSummary.textContent = aiAnalysis.summary;

        // 4. Update ALL Charts (Gauges, Radar, Bar)
        updateCharts(
            painIndex,
            omedd,
            analgesicInfo.value,
            aiAnalysis.riskScore,
            aiAnalysis.riskComponents
        );
    }

    // --- Event Handlers ---

    // Face Picker
    document.querySelectorAll('.face-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.face-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            ctx.strokeStyle = option.getAttribute('data-color');

            // Sync face click with intensity input
            const painLevel = option.getAttribute('data-level');
            elements.intensity.value = painLevel;

            // Run calculations on click
            runAllCalculations();
        });
    });

    // Sliders
    elements.age.addEventListener('input', () => { elements.ageValue.textContent = elements.age.value; });
    elements.weight.addEventListener('input', () => { elements.weightValue.textContent = elements.weight.value; });
    elements.height.addEventListener('input', () => { elements.heightValue.textContent = elements.height.value; });

    // Strong Opioid UI
    elements.strong.drug.addEventListener('change', () => {
        const drug = elements.strong.drug.value;
        if (drug === 'not_selected') {
            elements.strong.details.style.display = 'none';
        } else if (drug === 'fentanyl_td') {
            elements.strong.details.style.display = 'grid';
            elements.strong.unit.style.display = 'none';
            elements.strong.unitLabel.style.display = 'none';
            elements.strong.multiSection.style.display = 'none';
            elements.strong.fentanylDisplay.style.display = 'inline-block';
        } else {
            elements.strong.details.style.display = 'grid';
            elements.strong.unit.style.display = 'inline-block';
            elements.strong.unitLabel.style.display = 'inline-block';
            elements.strong.multiSection.style.display = 'block'; // or 'grid' if it's a grid item
            elements.strong.fentanylDisplay.style.display = 'none';
        }
        runAllCalculations(); // Recalculate oMEDD
    });

    // Button Clicks
    elements.calcButton.addEventListener('click', runAllCalculations);

    elements.clearButton.addEventListener('click', () => {
        // Clear inputs
        document.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(el => el.value = '');
        document.querySelectorAll('select').forEach(el => el.value = el.options[0].value);

        // Reset special inputs
        elements.intensity.value = 0;
        elements.strong.drug.value = 'not_selected';
        elements.strong.details.style.display = 'none';

        // Reset sliders
        elements.age.value = 25; elements.ageValue.textContent = 25;
        elements.weight.value = 70; elements.weightValue.textContent = 70;
        elements.height.value = 170; elements.heightValue.textContent = 170;

        // Clear canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.querySelectorAll('.face-option').forEach(opt => opt.classList.remove('active'));
        ctx.strokeStyle = 'var(--accent-red)'; // Reset to default red

        // Reset metrics
        const zeroRisk = { pain: 0, opioid: 0, impact: 0, age: 0, gap: 0 };
        const duration = 300; // ms
        animateValue(elements.piValue, parseFloat(elements.piValue.textContent) || 0, 0, duration);
        animateValue(elements.omeddValue, parseFloat(elements.omeddValue.textContent) || 0, 0, duration);
        animateValue(elements.aiValue, parseInt(elements.aiValue.textContent) || 0, 0, duration);
        animateValue(elements.riskValue, parseInt(elements.riskValue.textContent) || 0, 0, duration);

        elements.pcValue.textContent = 'N/A';
        elements.aiSummary.textContent = 'AI analysis will appear here after calculation...';
        updateCharts(0, 0, 0, 0, zeroRisk);
    });

    elements.sendButton.addEventListener('click', () => {
        // Run final calculation
        runAllCalculations();

        // Collect all data
        const data = {
            // Demographics
            age: elements.age.value,
            weight: elements.weight.value,
            height: elements.height.value,
            historyId: elements.historyId.value,
            // Pain
            pain: {
                canvasData: canvas.toDataURL(),
                type: elements.painType.value,
                intensity: elements.intensity.value,
                frequency: elements.frequency.value,
                duration: elements.duration.value,
                impact: elements.impact.value
            },
            // Medications
            medications: {
                adjuvant: {
                    drug: elements.adjuvant.drug.value,
                    dose: elements.adjuvant.dose.value,
                    unit: elements.adjuvant.unit.value
                },
                nsaid: {
                    drug: elements.nsaid.drug.value,
                    dose: elements.nsaid.dose.value,
                    unit: elements.nsaid.unit.value,
                    multi: elements.nsaid.multi.value
                },
                weak: {
                    drug: elements.weak.drug.value,
                    dose: elements.weak.dose.value,
                    unit: elements.weak.unit.value,
                    multi: elements.weak.multi.value
                },
                strong: {
                    drug: elements.strong.drug.value,
                    dose: elements.strong.dose.value,
                    unit: elements.strong.unit.value,
                    multi: elements.strong.multi.value
                }
            },
            // Calculated Metrics
            metrics: {
                painIndex: elements.piValue.textContent,
                omedd: elements.omeddValue.textContent,
                analgesicIndex: elements.aiValue.textContent,
                painControl: elements.pcValue.textContent,
                riskScore: elements.riskValue.textContent
            }
        };

        console.log('--- Sending Data ---', data);

        // Placeholder for fetch POST request
        // fetch('/save-level-pain', { ... })

        // Show a temporary success message
        const originalText = elements.sendButton.textContent;
        elements.sendButton.textContent = 'Data Sent!';
        elements.sendButton.style.backgroundColor = 'var(--accent-green)';
        setTimeout(() => {
            elements.sendButton.textContent = originalText;
            elements.sendButton.style.backgroundColor = ''; // Revert to class style
        }, 2000);
    });

    // --- Initialization ---
    document.addEventListener('DOMContentLoaded', () => {
        resizeCanvas();
        initializeCharts();
        runAllCalculations(); // Run once on load to init charts

        // Attach canvas listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);
        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchmove', draw);
        canvas.addEventListener('touchend', stopDrawing);

        window.addEventListener('resize', () => {
            resizeCanvas();
            // Charts will resize automatically
        });

        // Add change/input listeners to all calculation inputs
        const inputsToTrack = [
            elements.intensity, elements.frequency, elements.duration, elements.impact,
            elements.age,
            elements.adjuvant.drug, elements.adjuvant.dose,
            elements.nsaid.drug, elements.nsaid.dose, elements.nsaid.multi,
            elements.weak.drug, elements.weak.dose, elements.weak.multi,
            elements.strong.drug, elements.strong.dose, elements.strong.unit, elements.strong.multi
        ];

        inputsToTrack.forEach(input => {
            if (input) { // Check if element exists
                input.addEventListener('input', runAllCalculations);
                input.addEventListener('change', runAllCalculations); // For selects
            }
        });

        // Set default slider height
        elements.height.value = 170;
        elements.heightValue.textContent = 170;
    });

</script>
</body>
</html>
