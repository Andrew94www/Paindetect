<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Infusion Index Score (IIS) v2.0 — Clinical Tool</title>
    <style>
        :root {
            --bg: #0b1220;
            --card: #151e32;
            --ink: #e7ecf7;
            --muted: #94a3b8;
            --accent: #38bdf8; /* Sky blue */
            --good: #4ade80;   /* Green */
            --warn: #fbbf24;   /* Amber */
            --bad: #f87171;    /* Red */
            --brand: #0d9488;  /* Teal */
            --border: #1e293b;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            padding-bottom: 60px;
        }
        a { color: var(--accent); text-decoration: none; border-bottom: 1px dotted var(--accent); }
        .wrap { max-width: 1000px; margin: 0 auto; padding: 20px 16px; }

        /* Branding Header (Restored) */
        .brand-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #1f2a44; }
        .brand-logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 20px; color: #fff; }
        .brand-logo img { height: auto; max-width: 100%; }

        /* Typography */
        h1 { font-size: clamp(24px, 4vw, 32px); margin: 0 0 8px; color: #fff; }
        h2 { font-size: 20px; color: #e2e8f0; margin-top: 30px; border-left: 4px solid var(--brand); padding-left: 12px; }
        h3 { margin: 0 0 16px; font-size: 16px; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.05em; }
        p.lead { color: var(--muted); font-size: 15px; margin-bottom: 30px; line-height: 1.5; }

        /* Layout */
        .grid { display: grid; gap: 16px; }
        .cols-2 { grid-template-columns: repeat(2, 1fr); }
        .cols-3 { grid-template-columns: repeat(3, 1fr); }

        @media (max-width: 800px) { .cols-3 { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 600px) { .cols-2, .cols-3 { grid-template-columns: 1fr; } }

        /* Components */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        label { display: block; font-size: 13px; margin: 12px 0 6px; color: #cbd5e1; font-weight: 500; }

        select, input {
            width: 100%;
            padding: 10px;
            background: #0f172a;
            border: 1px solid #334155;
            color: #fff;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        select:focus, input:focus { border-color: var(--accent); box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2); }

        .row-input { display: flex; gap: 10px; align-items: flex-end; }
        .row-input input { width: 80px; text-align: center; }
        .row-input select { flex: 1; }

        /* Buttons */
        .actions { display: flex; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border); flex-wrap: wrap; }
        .btn {
            background: #1e293b; color: #fff;
            border: none; padding: 12px 24px;
            border-radius: 8px; cursor: pointer;
            font-weight: 600; font-size: 15px;
            display: inline-flex; align-items: center; gap: 8px;
            transition: 0.2s;
        }
        .btn:hover { background: #334155; }
        .btn-primary { background: var(--brand); }
        .btn-primary:hover { background: #14b8a6; }

        /* Results Area */
        .result-box {
            background: linear-gradient(to bottom right, #1e293b, #0f172a);
            border: 1px solid #334155;
            color: #fff;
        }

        .score-display {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px dashed #475569;
        }
        .main-score { font-size: 36px; font-weight: 800; line-height: 1; color: var(--accent); }
        .score-label { font-size: 13px; color: var(--muted); text-transform: uppercase; }

        .badge {
            display: inline-block; padding: 4px 12px; border-radius: 99px;
            font-size: 12px; font-weight: 700; text-transform: uppercase;
            background: #334155; color: #fff;
        }
        .badge.critical { background: rgba(248, 113, 113, 0.2); color: #f87171; border: 1px solid #f87171; }
        .badge.warning { background: rgba(251, 191, 36, 0.2); color: #fbbf24; border: 1px solid #fbbf24; }
        .badge.stable { background: rgba(74, 222, 128, 0.2); color: #4ade80; border: 1px solid #4ade80; }

        /* Therapy Lines */
        .therapy-line { margin-top: 16px; }
        .therapy-title { font-size: 14px; font-weight: 700; color: #94a3b8; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; }
        .therapy-content {
            background: rgba(0,0,0,0.2); border-radius: 8px; padding: 12px;
            border-left: 3px solid var(--muted); font-size: 14px;
        }
        .product-link {
            color: var(--accent); font-weight: 600; cursor: pointer;
            border-bottom: 1px dotted var(--accent);
        }

        .highlight-box {
            background: rgba(13, 148, 136, 0.1); border: 1px solid var(--brand);
            padding: 16px; border-radius: 8px; margin-top: 20px;
        }

        /* Responsive helper */
        .hidden-mobile { display: block; }
        @media(max-width: 600px) { .hidden-mobile { display: none; } }
    </style>
</head>
<body>

<div class="wrap">

    <div class="brand-header">
        <div class="brand-logo">
            <!-- Restored Logo Path -->
            <img class="" src="img/ufarm.png" width="400px" alt="UF Logo">
        </div>
        <div style="font-size: 14px; opacity: 0.7;">IIS Calculator</div>
    </div>

    <h1>IIS Calculator <span style="color:var(--brand)">v2.0</span></h1>

    <p class="lead">
        Алгоритм оцінює 21 показник для розрахунку <b>Infusion Index Score</b>.
        <br>Система автоматично визначає гемодинамічний профіль (Гіповолемія vs Гіперволемія) та пропонує лінії терапії.
    </p>

    <div class="grid cols-3">
        <!-- Section A: Clinical -->
        <div class="card">
            <h3>🩺 A. Клініка та Гемодинаміка</h3>

            <label>Артеріальний тиск (АТ)</label>
            <!-- value format: "score|type" where type: 1=hypo/need fluid, -1=hyper/restrict, 0=neutral -->
            <select id="clin_bp">
                <option value="0|0">Норма (110-130 сис)</option>
                <option value="1|1">Помірна гіпотензія (90-100)</option>
                <option value="2|1">🔴 ШОК / Тяжка гіпотензія (<90)</option>
                <option value="1|-1">Помірна гіпертензія (140-159)</option>
                <option value="2|-1">🔴 Гіпертензивний криз (≥160)</option>
            </select>

            <label>Частота серцевих скорочень (ЧСС)</label>
            <select id="clin_hr">
                <option value="0|0">Норма (60-90)</option>
                <option value="1|1">Тахікардія (91-110)</option>
                <option value="2|1">🔴 Виражена тахікардія (>110)</option>
                <option value="1|0">Брадикардія (50-59)</option>
                <option value="2|0">🔴 Виражена брадикардія (<50)</option>
            </select>

            <label>Перфузія / Шкірні покриви</label>
            <select id="clin_perf">
                <option value="0|0">Теплі, рожеві (CRT <2s)</option>
                <option value="1|1">Прохолодні / Бліді (CRT 2-3s)</option>
                <option value="2|1">🔴 Холодні / Мармурові (CRT >3s)</option>
            </select>

            <label>Темп діурезу</label>
            <select id="clin_urine">
                <option value="0|0">Норма (>0.5 мл/кг/год)</option>
                <option value="1|1">Олігурія (0.3-0.5)</option>
                <option value="2|1">🔴 Анурія (<0.3)</option>
            </select>

            <label>Гідратація тканин (Набряки)</label>
            <select id="clin_edema">
                <option value="0|0">Немає</option>
                <option value="1|-1">Пастозність / Локальні</option>
                <option value="2|-1">🔴 Генералізовані / Анасарка</option>
            </select>

            <label>Свідомість (GCS)</label>
            <select id="clin_gcs">
                <option value="0|0">Ясна (15)</option>
                <option value="1|0">Оглушення (13-14)</option>
                <option value="2|0">🔴 Сопор / Кома (≤12)</option>
            </select>

            <label>Клінічне враження</label>
            <select id="clin_imp">
                <option value="0|0">Еуволемія</option>
                <option value="2|1">Гіповолемія ("Dry")</option>
                <option value="2|-1">Гіперволемія ("Wet")</option>
            </select>
        </div>

        <!-- Section B: Labs -->
        <div class="card">
            <h3>🧪 B. Лабораторія</h3>

            <label>Лактат (ммоль/л)</label>
            <div class="row-input">
                <input type="number" id="inp_lac" placeholder="2.0">
                <select id="lab_lac">
                    <option value="0|0">≤ 2.2</option>
                    <option value="1|1">2.3 - 4.0</option>
                    <option value="2|1">🔴 > 4.0 (Тканинна гіпоксія)</option>
                </select>
            </div>

            <label>BE (Base Excess)</label>
            <div class="row-input">
                <input type="number" id="inp_be" placeholder="-2">
                <select id="lab_be">
                    <option value="0|0"> -2 ... +2</option>
                    <option value="1|1"> -2 ... -5 (Дефіцит)</option>
                    <option value="2|1">🔴 < -5 (Метаб. ацидоз)</option>
                    <option value="1|0"> > +2 (Алкалоз)</option>
                </select>
            </div>

            <label>Натрій (Na⁺)</label>
            <div class="row-input">
                <input type="number" id="inp_na" placeholder="140">
                <select id="lab_na">
                    <option value="0|0">135 - 145</option>
                    <option value="1|0">130-134 (Легка гіпо)</option>
                    <option value="2|0">🔴 <130 (Тяжка гіпо)</option>
                    <option value="2|0">🔴 >150 (Гіпер)</option>
                </select>
            </div>

            <label>Осмолярність (мОсм/л)</label>
            <div class="row-input">
                <input type="number" id="inp_osm" placeholder="290">
                <select id="lab_osm">
                    <option value="0|0">275 - 300</option>
                    <option value="1|1">301 - 315 (Гіпер)</option>
                    <option value="2|1">🔴 > 315 (Тяжка гіпер)</option>
                    <option value="1|-1">< 275 (Гіпо)</option>
                </select>
            </div>

            <label>Гематокрит (Hct)</label>
            <div class="row-input">
                <input type="number" id="inp_hct" placeholder="40">
                <select id="lab_hct">
                    <option value="0|0">30 - 50%</option>
                    <option value="1|1">> 50% (Згущення)</option>
                    <option value="2|1">🔴 < 25% (Анемія/Кровотеча)</option>
                </select>
            </div>

            <label>Креатинін</label>
            <select id="lab_cr">
                <option value="0|0">Норма</option>
                <option value="1|0">Підвищений помірно</option>
                <option value="2|0">Високий (ГНН)</option>
            </select>
        </div>

        <!-- Section C: Instrumental -->
        <div class="card">
            <h3>🖥️ C. Інструментальні</h3>

            <label>ЦВТ (CVP)</label>
            <select id="inst_cvp">
                <option value="0|0">6 - 12 мм рт.ст.</option>
                <option value="1|1">Низький (< 6)</option>
                <option value="2|-1">Високий (> 12)</option>
            </select>

            <label>V.Cava Inf (УЗД)</label>
            <select id="inst_ivc">
                <option value="0|0">Норма</option>
                <option value="2|1">Спадається (>50%) - Responder</option>
                <option value="2|-1">Розширена / Не спадається</option>
            </select>

            <label>УЗД Легень (BLUE)</label>
            <select id="inst_lung">
                <option value="0|0">А-профіль (Сухі)</option>
                <option value="1|-1">Кілька B-ліній</option>
                <option value="2|-1">🔴 B-профіль ("Мокрі" / Набряк)</option>
            </select>

            <label>Тест з підняттям ніг (PLR)</label>
            <select id="inst_plr">
                <option value="0|0">Не проводився / Негативний</option>
                <option value="2|1">Позитивний (>10% SV/CO)</option>
            </select>

            <label>Серцевий індекс (CI)</label>
            <select id="inst_ci">
                <option value="0|0">≥ 2.5</option>
                <option value="1|1">2.0 - 2.49</option>
                <option value="2|1">🔴 < 2.0 (Кардіоген. шок)</option>
            </select>

            <label>Кліренс лактату (2 год)</label>
            <select id="inst_lac_cl">
                <option value="0|0">> 20% (Норма)</option>
                <option value="1|0">10-20%</option>
                <option value="2|0">🔴 < 10% (Відсутній)</option>
            </select>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions">
        <button class="btn btn-primary" onclick="calculate()">
            <span>🚀</span> Розрахувати стратегію
        </button>
        <button class="btn" onclick="autoFill()">
            <span>⚡</span> Автозаповнення з полів
        </button>
        <button class="btn" onclick="resetForm()">
            <span>↺</span> Скинути
        </button>
    </div>

    <!-- RESULTS SECTION -->
    <div id="resultSection" class="grid cols-2" style="margin-top:24px; display:none;">

        <!-- Score Card -->
        <div class="card result-box">
            <div class="score-display">
                <div>
                    <div class="score-label">IIS Score (0-10)</div>
                    <div class="main-score" id="res_score">0.0</div>
                </div>
                <div style="text-align:right">
                    <div class="score-label">Статус</div>
                    <div id="res_badge" class="badge stable">Стабільність</div>
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <div class="score-label" style="margin-bottom:4px;">Домінуючий профіль:</div>
                <div id="res_profile" style="font-size:18px; font-weight:700; color:#fff;">Невизначено</div>
            </div>

            <div style="background:rgba(255,255,255,0.05); padding:10px; border-radius:6px; font-size:13px; line-height:1.4;">
                <span id="res_desc">Пацієнт у стабільному стані. Показань до агресивної інфузії немає.</span>
            </div>
        </div>

        <!-- Strategy Card -->
        <div class="card" style="border-top: 4px solid var(--accent);">
            <h3>💊 Рекомендована послідовність</h3>

            <div class="therapy-line">
                <div class="therapy-title"><span style="color:var(--good)">❶</span> 1-ша Лінія (Базис)</div>
                <div class="therapy-content" id="line1">
                    —
                </div>
            </div>

            <div class="therapy-line">
                <div class="therapy-title"><span style="color:var(--warn)">❷</span> 2-га Лінія (Корекція/Драйвери)</div>
                <div class="therapy-content" id="line2">
                    —
                </div>
            </div>

            <div id="monitoring_box" class="highlight-box">
                <strong>📢 Моніторинг безпеки:</strong>
                <ul id="monitor_list" style="margin:8px 0 0 20px; padding:0; font-size:13px;">
                    <li>Контроль АТ та ЧСС кожні 15 хв.</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<script>
    // Utility to parse value "score|type"
    function getVal(id) {
        const el = document.getElementById(id);
        if(!el) return { score: 0, type: 0, text: '' };
        const parts = el.value.split('|');
        return {
            score: parseInt(parts[0], 10),
            type: parseInt(parts[1], 10), // 1=Hypo/NeedFluid, -1=Hyper/Restrict, 0=Neutral
            text: el.options[el.selectedIndex].text
        };
    }

    // Auto-fill inputs to selects
    function autoFill() {
        const setSelect = (selId, val, thresholds) => {
            const sel = document.getElementById(selId);
            if (!val && val !== 0) return;
            // Simplified logic: finds first option that vaguely matches severity
            // Real implementation needs strict threshold mapping.
            // For demo, we trigger manually based on known IDs.

            // Lactate
            if (selId === 'lab_lac') {
                if (val <= 2.2) sel.selectedIndex = 0;
                else if (val <= 4.0) sel.selectedIndex = 1;
                else sel.selectedIndex = 2;
            }
            // Na
            if (selId === 'lab_na') {
                if (val >= 135 && val <= 145) sel.selectedIndex = 0;
                else if (val >= 130 && val < 135) sel.selectedIndex = 1;
                else if (val < 130) sel.selectedIndex = 2;
                else if (val > 150) sel.selectedIndex = 3;
            }
            // Hct
            if (selId === 'lab_hct') {
                if (val >= 30 && val <= 50) sel.selectedIndex = 0;
                else if (val > 50) sel.selectedIndex = 1;
                else if (val < 30) sel.selectedIndex = 2;
            }
        };

        const v = (id) => { const el = document.getElementById(id); return el.value ? parseFloat(el.value) : null; };

        setSelect('lab_lac', v('inp_lac'));
        setSelect('lab_na', v('inp_na'));
        setSelect('lab_hct', v('inp_hct'));

        // Visual feedback
        const btn = document.querySelector('button[onclick="autoFill()"]');
        const oldText = btn.innerHTML;
        btn.innerHTML = "<span>✅</span> Готово";
        setTimeout(() => btn.innerHTML = oldText, 1500);

        calculate();
    }

    function calculate() {
        // IDs of all selects
        const ids = [
            'clin_bp', 'clin_hr', 'clin_perf', 'clin_urine', 'clin_edema', 'clin_gcs', 'clin_imp',
            'lab_lac', 'lab_be', 'lab_na', 'lab_osm', 'lab_hct', 'lab_cr',
            'inst_cvp', 'inst_ivc', 'inst_lung', 'inst_plr', 'inst_ci', 'inst_lac_cl'
        ];

        let totalScore = 0;
        let hypoPoints = 0;
        let hyperPoints = 0;
        let criticalFlags = []; // Store names of critical items

        ids.forEach(id => {
            const data = getVal(id);
            totalScore += data.score;

            // Sum directional points
            if (data.type === 1) hypoPoints += data.score; // Needs Fluid
            if (data.type === -1) hyperPoints += data.score; // Restrict Fluid

            // Check for critical flags (Score 2)
            if (data.score === 2) {
                // If it's Shock BP, Anuria, High Lactate -> Critical
                if (['clin_bp', 'clin_urine', 'lab_lac', 'clin_perf'].includes(id) && data.type === 1) {
                    criticalFlags.push("HypoCritical");
                }
                // If it's Pulmonary Edema, HTN Crisis -> Critical
                if (['clin_bp', 'inst_lung', 'clin_edema'].includes(id) && data.type === -1) {
                    criticalFlags.push("HyperCritical");
                }
            }
        });

        // --- SCORING LOGIC V2.0 ---

        // 1. IIS Calculation (Normalized 0-10)
        // Max theoretical points is roughly 42.
        let iis = (totalScore / 42) * 10;

        // 2. Critical Override
        // If critical flags exist, minimal IIS should be high
        if (criticalFlags.length > 0) {
            if (iis < 5.0) iis = 6.5; // Force into warning zone at least
        }

        // 3. Determine Profile
        let profile = "Euvolemia";
        if (hypoPoints > hyperPoints) profile = "Hypovolemia (Needs Fluid)";
        else if (hyperPoints > hypoPoints) profile = "Hypervolemia (Restrict)";

        // Tie-breaker or low scores
        if (totalScore < 3) profile = "Stable / Euvolemia";

        // --- RENDER RESULTS ---
        document.getElementById('resultSection').style.display = 'grid';

        // Update Score UI
        const scoreEl = document.getElementById('res_score');
        const badgeEl = document.getElementById('res_badge');

        scoreEl.innerText = iis.toFixed(1);

        if (iis < 3) {
            badgeEl.className = 'badge stable'; badgeEl.innerText = 'Стабільність';
            scoreEl.style.color = 'var(--good)';
        } else if (iis < 7) {
            badgeEl.className = 'badge warning'; badgeEl.innerText = 'Увага (Warning)';
            scoreEl.style.color = 'var(--warn)';
        } else {
            badgeEl.className = 'badge critical'; badgeEl.innerText = 'КРИТИЧНИЙ СТАН';
            scoreEl.style.color = 'var(--bad)';
        }

        // Strategy Logic
        const line1 = document.getElementById('line1');
        const line2 = document.getElementById('line2');
        const desc = document.getElementById('res_desc');
        const profEl = document.getElementById('res_profile');
        const monList = document.getElementById('monitor_list');

        let l1_html = "";
        let l2_html = "";
        let mon_html = "<li>Контроль діурезу щогодини</li>";

        // Logic Branching
        if (profile.includes("Hypovolemia")) {
            profEl.innerText = "Гіповолемія / Дефіцит ОЦК";
            profEl.style.color = "var(--accent)"; // Blue for water needed

            desc.innerHTML = `Виявлено ознаки дефіциту рідини (Score: ${hypoPoints}). Пріоритет: <b>Відновлення перфузії</b>.`;

            // Line 1: Balanced
            l1_html = `<b>Збалансовані кристалоїди</b> (5-10 мл/кг болюс, далі підтримка).
                       <br><small>Препарати: <a href="#" class="product-link">Рінгера-Лактат</a>, <a href="#" class="product-link">Рінгера-Малат</a>.</small>`;

            // Line 2: Advanced
            // Check specific conditions for line 2
            const na = getVal('lab_na');
            const lac = getVal('lab_lac');
            const bp = getVal('clin_bp');

            if (bp.score === 2 && bp.type === 1) {
                // Shock logic
                l2_html = `<b>Малооб'ємна ресусцитація + Вазопресори</b>.
                           <br>1. <a href="#" class="product-link">Реосорбілакт</a> (200-400 мл в/в краплинно/струминно) — для мобілізації рідини.
                           <br>2. Норадреналін (якщо АТ сер. < 65 після болюсу).`;
                mon_html += "<li>Інвазивний моніторинг АТ</li><li>Контроль лактату кожні 2 год</li>";
            } else if (na.text.includes('<130')) {
                // Hyponatremia logic
                l2_html = `<b>Корекція Гіпонатріємії</b>.
                           <br>Розглянути гіпертонічні розчини або <a href="#" class="product-link">Реосорбілакт</a> (осмолярність 890).`;
            } else if (lac.score >= 1) {
                // Intoxication/Acidosis
                l2_html = `<b>Дезінтоксикація / Енергетики</b>.
                           <br><a href="#" class="product-link">Ксилат</a> (зменшення кетозу, джерело енергії) або <a href="#" class="product-link">Реосорбілакт</a>.`;
            } else {
                l2_html = `При відсутності ефекту від кристалоїдів: <a href="#" class="product-link">Реосорбілакт</a> 6-8 мл/кг.`;
            }

        } else if (profile.includes("Hypervolemia")) {
            profEl.innerText = "Гіперволемія / Перевантаження";
            profEl.style.color = "var(--bad)"; // Red for danger

            desc.innerHTML = `Виявлено ознаки застою/набряку (Score: ${hyperPoints}). Пріоритет: <b>Розвантаження (De-resuscitation)</b>.`;

            l1_html = `<b>Фуросемід / Торасемід</b>. Обмеження інфузії до "0" або KVO (Keep Vein Open).`;
            l2_html = `<b>Вазодилататори</b> (Нітрати) при АТ > 160.
                       <br>При низькому білку: Альбумін + Фуросемід.
                       <br>Інотропи (Добутамін) при низькому СІ.`;
            mon_html += "<li>УЗД легень (динаміка B-ліній)</li><li>Суворий контроль гідробалансу (мета: негативний)</li>";

        } else {
            // Stable
            profEl.innerText = "Еуволемія / Стабільність";
            profEl.style.color = "var(--good)";
            desc.innerHTML = "Показники в межах норми. Підтримуюча терапія.";
            l1_html = "Фізіологічна потреба: 1-1.5 мл/кг/год (Збалансовані кристалоїди).";
            l2_html = "Ентеральне харчування/гідратація за можливості.";
        }

        line1.innerHTML = l1_html;
        line2.innerHTML = l2_html;
        monList.innerHTML = mon_html;

        document.getElementById('resultSection').scrollIntoView({behavior: 'smooth'});
    }

    function resetForm() {
        document.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        document.querySelectorAll('input').forEach(i => i.value = '');
        document.getElementById('resultSection').style.display = 'none';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>

</body>
</html>
