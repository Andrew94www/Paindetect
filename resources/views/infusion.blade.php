<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Infusion Index Score (IIS) — Calculator</title>
    <style>
        :root {
            --bg: #0b1220;
            --card: #121a2b;
            --ink: #e7ecf7;
            --muted: #a6b1c7;
            --accent: #5dd0ff;
            --good: #2ecc71;
            --warn: #f1c40f;
            --bad: #e74c3c;
            --brand: #009688; /* Medical teal/greenish */
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: linear-gradient(180deg, #0b1220, #0b1220 60%, #0e1628);
            color: var(--ink);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            padding-bottom: 40px;
        }
        a { color: var(--accent); text-decoration: none; border-bottom: 1px dotted var(--accent); transition: all 0.2s; }
        a:hover { color: #fff; border-bottom-style: solid; }
        .wrap { max-width: 1080px; margin: 24px auto; padding: 0 16px; }

        /* Branding Header */
        .brand-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #1f2a44; }
        .brand-logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 20px; color: #fff; }
        .brand-logo svg { fill: #fff; height: 32px; width: auto; }

        h1 { font-size: clamp(22px, 3vw, 30px); letter-spacing: .2px; margin: 0 0 6px; }
        h2 { font-size: clamp(18px, 2.2vw, 22px); margin: 22px 0 10px; color: #dce6ff; border-left: 4px solid var(--accent); padding-left: 12px; }
        .lead { color: var(--muted); margin: 0 0 24px; font-size: 15px; line-height: 1.6; }

        .grid { display: grid; gap: 16px; }
        .grid.cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid.cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        @media (max-width: 900px) { .grid.cols-3, .grid.cols-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .grid.cols-2, .grid.cols-3, .grid.cols-4 { grid-template-columns: 1fr; } }

        .card {
            background: linear-gradient(180deg, #111a2c, #0f182b);
            border: 1px solid #1f2a44;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .25);
            position: relative;
        }
        .card h3 { margin: 0 0 14px; font-size: 17px; color: #d6e2ff; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9; }

        label { display: block; font-size: 13px; margin: 12px 0 6px; color: #cbd6ef; font-weight: 500; }
        select, input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #253256;
            border-radius: 8px;
            background: #0d1424;
            color: #e8eeff;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        select:focus, input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(93, 208, 255, 0.2);
        }

        .section-patient { background: #162036; border-color: #2a3b5e; }
        .section-patient input, .section-patient select { background: #0f172a; border-color: #2a3b5e; }

        .row { display: grid; grid-template-columns: 1fr 140px; gap: 10px; align-items: center; }
        @media (max-width: 480px) { .row { grid-template-columns: 1fr; } }

        .footer { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 24px; align-items: center; padding-top: 20px; border-top: 1px solid #1f2a44; }

        .btn {
            cursor: pointer;
            border-radius: 8px;
            border: none;
            background: #1a2c5a;
            color: #eaf2ff;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn:hover { background-color: #253e7a; transform: translateY(-1px); }
        .btn:active { transform: translateY(1px); }
        .btn-primary { background: var(--brand); color: white; }
        .btn-primary:hover { background: #00897b; }

        .pill { padding: 6px 12px; border-radius: 999px; border: 1px solid #273251; background: #0c1324; color: #dfe7ff; font-size: 12px; margin-left: auto; }

        .score { font-size: 32px; font-weight: 800; line-height: 1; }
        .tag { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; margin-bottom: 8px; border: 1px solid; }
        .tag.good { border-color: var(--good); color: var(--good); background-color: rgba(46, 204, 113, 0.1); }
        .tag.warn { border-color: var(--warn); color: var(--warn); background-color: rgba(241, 196, 15, 0.1); }
        .tag.bad { border-color: var(--bad); color: var(--bad); background-color: rgba(231, 76, 60, 0.1); }

        ul { padding-left: 20px; margin: 8px 0 0; line-height: 1.6; font-size: 14px; }
        li { margin-bottom: 6px; }
        li::marker { color: var(--accent); }

        .small { color: #9fb0cf; font-size: 13px; line-height: 1.5; }
        .muted { color: var(--muted); }

        .kpi { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 16px; }
        .kpi > div { background: #0d1526; border: 1px dashed #223057; border-radius: 10px; padding: 12px; text-align: center; }

        #osmoAdvice ul { list-style-type: none; padding-left: 0; }
        #osmoAdvice li { margin-bottom: 12px; padding-left: 24px; position: relative; }
        #osmoAdvice li::before { content: "💡"; position: absolute; left: 0; top: 0; }

        /* New Alert Box */
        .alert-box {
            grid-column: 1 / -1;
            background: rgba(93, 208, 255, 0.1);
            border: 1px solid var(--accent);
            color: #d1ecf1;
            padding: 16px;
            border-radius: 12px;
            margin-top: 16px;
            display: none; /* Hidden by default */
            animation: slideDown 0.3s ease-out;
        }
        .alert-box.visible { display: block; }
        .alert-title { font-weight: bold; color: var(--accent); display: block; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;}

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hidden-input { display: none; margin-top: 8px; }
        .product-link {
            display: inline-block;
            background: #1f2a44;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            margin-top: 2px;
            border: 1px solid #36486b;
            color: #76c7ff;
        }
        .product-link:hover { border-color: var(--accent); text-decoration: none; }
    </style>
</head>
<body>
<div class="wrap">

    <div class="brand-header">
        <div class="brand-logo">
            <!-- Simple SVG Logo Placeholder -->
            <img class="" src="img/ufarm.png" width="400px" >
        </div>
        <div style="font-size: 14px; opacity: 0.7;">IIS Calculator</div>
    </div>

    <h1>💧 Infusion Index Score (IIS)</h1>
    <p class="lead">Алгоритм інфузійної терапії з розрахунком <b>IIS</b> (0–10). Оцінюємо <b>21 показник</b> (A/B/C), кожен: <b>0</b> — норма, <b>1</b> — відхилення, <b>2</b> — патологія.</p>

    <!-- 1. Patient Data (New) -->
    <div class="card section-patient" style="margin-bottom: 24px;">
        <h3>📄 Дані пацієнта</h3>
        <div class="grid cols-4">
            <div style="grid-column: span 2;">
                <label>Заклад охорони здоров`я</label>
                <input type="text" id="pt_hospital" placeholder="Назва лікарні" />
            </div>
            <div style="grid-column: span 2;">
                <label>Номер історії хвороби (ID)</label>
                <input type="text" id="pt_id" placeholder="№ Історії" />
            </div>
            <div>
                <label>Вік (років)</label>
                <input type="number" id="pt_age" placeholder="-" />
            </div>
            <div>
                <label>Вага (кг)</label>
                <input type="number" id="pt_weight" placeholder="-" />
            </div>
            <div>
                <label>Стать</label>
                <select id="pt_gender">
                    <option value="">-</option>
                    <option value="M">Чол</option>
                    <option value="F">Жін</option>
                </select>
            </div>
            <div>
                <label>Код МКХ 10</label>
                <select id="pt_mkb" onchange="toggleOtherMkb()">
                    <option value="">Оберіть...</option>
                    <option value="J09-J18">(J09-J18) Грип та пневмонія</option>
                    <option value="A40-A41">(А40-А41) Сепсис</option>
                    <option value="T20-T31">(Т20-Т31) Опіки</option>
                    <option value="K65-K67">(К65-К67) Перитоніт</option>
                    <option value="T00-T07">(Т00-Т07) Травми численних ділянок</option>
                    <option value="K56">(К56) Гостра кишкова непрохідність</option>
                    <option value="K92">(К92) Шлунково-кишкова кровотеча</option>
                    <option value="K25-K26">(К25-К26) Виразка шлунку/ДПК</option>
                    <option value="K85-K87">(К85-87) Панкреатит</option>
                    <option value="other">ІНШЕ (Ввести вручну)</option>
                </select>
                <input type="text" id="pt_mkb_other" class="hidden-input" placeholder="Код та назва діагнозу" />
            </div>
        </div>
    </div>

    <div class="grid cols-3">
        <!-- A. Клінічні -->
        <div class="card" id="blockA">
            <h3>🩺 A. Клінічні показники</h3>
            <label>Артеріальний тиск (АТ)</label>
            <select data-weight="1"><option value="0">Норма</option><option value="1">Відхилення (гіпо/гіпер)</option><option value="2">Патологія (шок/гіпертенз. криз)</option></select>

            <label>Частота серцевих скорочень (ЧСС)</label>
            <select data-weight="1"><option value="0">60–100</option><option value="1">50–59 або 101–120</option><option value="2">&lt;50 або &gt;120</option></select>

            <label>Сечовиділення (мл/кг/год)</label>
            <select data-weight="1"><option value="0">≥0.5</option><option value="1">0.3–0.49</option><option value="2">&lt;0.3 або анурія</option></select>

            <label>Периферичний кровообіг</label>
            <select data-weight="1"><option value="0">Теплі, рефіл &lt;2 c</option><option value="1">Прохолодні або рефіл 2–3 c</option><option value="2">Холодні/мармурові, рефіл &gt;3 c</option></select>

            <label>Ступінь набряку</label>
            <select data-weight="1"><option value="0">Немає</option><option value="1">Локальний</option><option value="2">Генералізований</option></select>

            <label>Рівень свідомості (GCS/AVPU)</label>
            <select data-weight="1"><option value="0">Норма</option><option value="1">Оглушення</option><option value="2">Сопор/кома</option></select>

            <label>Клінічне враження лікаря</label>
            <select data-weight="1"><option value="0">"euvolemic"</option><option value="1">"wet" або "leaky"</option><option value="2">"dry" або змішаний шок</option></select>
        </div>

        <!-- B. Лабораторні -->
        <div class="card" id="blockB">
            <h3>🧪 B. Лабораторні показники</h3>

            <div class="row"><label>Лактат (ммоль/л)</label><input type="number" step="0.1" id="lab_lac" placeholder="напр., 2.4" /></div>
            <select data-weight="1" id="lab_lac_sel"><option value="0">≤2.2</option><option value="1">2.3–4.0</option><option value="2">&gt;4.0</option></select>

            <div class="row"><label>Креатинін (мкмоль/л)</label><input type="number" step="1" id="lab_cr" placeholder="напр., 130" /></div>
            <select data-weight="1" id="lab_cr_sel"><option value="0">≤110</option><option value="1">111–176</option><option value="2">&gt;176</option></select>

            <!-- Modified Sodium Logic -->
            <div class="row"><label>Натрій (ммоль/л)</label><input type="number" step="1" id="lab_na" placeholder="напр., 132" /></div>
            <select data-weight="1" id="lab_na_sel">
                <option value="0">135–145 (Норма)</option>
                <option value="1">130–134 або 146–150 (Помірне)</option>
                <option value="2">&lt;130 (Гіпонатріємія)</option>
                <option value="2">&gt;150 (Гіпернатріємія)</option>
            </select>

            <div class="row"><label>Гематокрит (%)</label><input type="number" step="1" id="lab_hct" placeholder="напр., 28" /></div>
            <select data-weight="1" id="lab_hct_sel"><option value="0">30–50</option><option value="1">26–29 або 51–55</option><option value="2">&lt;26 або &gt;55</option></select>

            <div class="row"><label>Осмолярність (мОсм/кг)</label><input type="number" step="1" id="lab_osm" placeholder="напр., 305" /></div>
            <select data-weight="1" id="lab_osm_sel"><option value="0">275–300</option><option value="1">301–315</option><option value="2">&gt;315</option></select>

            <div class="row"><label>pH / BE (оцінка)</label><input type="number" step="0.01" id="lab_ph" placeholder="напр., 7.31" /></div>
            <select data-weight="1" id="lab_ph_sel"><option value="0">pH ≥7.35</option><option value="1">pH 7.30–7.34</option><option value="2">pH &lt;7.30</option></select>

            <div class="row"><label>Глюкоза (ммоль/л)</label><input type="number" step="0.1" id="lab_glu" placeholder="напр., 11.2" /></div>
            <select data-weight="1" id="lab_glu_sel"><option value="0">4–10</option><option value="1">3.5–3.9 або 10.1–13.9</option><option value="2">&lt;3.5 або &gt;13.9</option></select>
        </div>

        <!-- C. Інструментальні -->
        <div class="card" id="blockC">
            <h3>🖥️ C. Інструментальні</h3>
            <label>ЦВТ / динаміка CVP</label>
            <select data-weight="1"><option value="0">6–12 мм рт.ст. / стабільно</option><option value="1">&lt;6 або &gt;12 без клініки перевантаження</option><option value="2">&gt;12 із застоєм або &lt;4 із шоком</option></select>

            <label>УЗД-IVC (інспіраторний колапс)</label>
            <select data-weight="1"><option value="0">Норма</option><option value="1">Помірно колабує/повнокровна</option><option value="2">Колабує (гіповолемія) або плетора</option></select>

            <label>ΔVTI / динаміка CO</label>
            <select data-weight="1"><option value="0">Стабільний</option><option value="1">Незначне зниження</option><option value="2">Виражене зниження / приріст ≥15% після PLR</option></select>

            <label>ΔPP / SVV</label>
            <select data-weight="1"><option value="0">≤12%</option><option value="1">13–15% або межові умови</option><option value="2">&gt;15% за валідних умов</option></select>

            <label>Біоімпеданс/NICOM — CI</label>
            <select data-weight="1"><option value="0">≥2.5 л/хв/м²</option><option value="1">2.0–2.49 л/хв/м²</option><option value="2">&lt;2.0 л/хв/м²</option></select>

            <label>Кліренс лактату (2–4 год)</label>
            <select data-weight="1"><option value="0">≥20%</option><option value="1">10–19%</option><option value="2">&lt;10% або зростання</option></select>

            <label>Відповідь на інфузію (PLR)</label>
            <select data-weight="1"><option value="0">Немає</option><option value="1">Сумнівна</option><option value="2">Підтверджена</option></select>
        </div>
    </div>

    <div class="footer">
        <button class="btn btn-primary" id="calcBtn">
            <span>🧮</span> Розрахувати IIS
        </button>
        <button class="btn" id="autoBtn">
            <span>⚙️</span> Автоскоринг лаб. даних
        </button>
        <button class="btn" id="resetBtn">
            <span>↺</span> Скинути
        </button>
        <span class="pill" style="display:none">IIS = (Σ балів / 42) × 10</span>
    </div>

    <!-- 4. Mandatory Post-Decision Message -->
    <div id="controlParamsMsg" class="alert-box">
        <div class="alert-title">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            УВАГА! Контроль безпеки
        </div>
        <p style="margin:0">З метою фіксації ефективності та безпечності проведеної інфузійної терапії – <b>зафіксуйте контрольні параметри</b> та проведіть повторну оцінку в динаміці.</p>
    </div>

    <div class="grid cols-2" style="margin-top:24px">
        <div class="card" id="resultCard">
            <h3>🚦 Результати</h3>
            <div class="kpi">
                <div>
                    <div class="muted">Σ балів (0–42)</div>
                    <div id="sumScore" class="score">0</div>
                </div>
                <div>
                    <div class="muted">IIS (0–10)</div>
                    <div id="iisScore" class="score" style="color:var(--accent)">0.0</div>
                </div>
                <div>
                    <div class="muted">Інтерпретація</div>
                    <div id="interp" class="score" style="font-size: 18px; margin-top:8px;">—</div>
                </div>
            </div>
            <div id="plan" style="margin-top:16px"></div>
        </div>

        <div class="card">
            <h3>💡 Осмо-драйвер: вибір розчину</h3>
            <div id="osmoAdvice"><p class="small muted">Заповніть лабораторні значення (Натрій, Осмолярність, pH) для отримання рекомендацій ЮРіЯ-ФАРМ.</p></div>
        </div>
    </div>

    <p class="small" style="text-align: center; margin-top: 40px; opacity: 0.6;">
        Ревізія кожні 4–6 годин. Інструмент не замінює клінічне рішення. <br>
        &copy; 2025 ЮРіЯ-ФАРМ. Всі права захищені.
    </p>
</div>

<script>
    const autoBtn = document.getElementById('autoBtn');
    const calcBtn = document.getElementById('calcBtn');
    const resetBtn = document.getElementById('resetBtn');
    const msgBox = document.getElementById('controlParamsMsg');

    function toggleOtherMkb() {
        const sel = document.getElementById('pt_mkb');
        const inp = document.getElementById('pt_mkb_other');
        if (sel.value === 'other') {
            inp.style.display = 'block';
            inp.focus();
        } else {
            inp.style.display = 'none';
        }
    }

    // Product Links Map
    const products = {
        ringer: '<a href="https://www.uf.ua/product/ringera-r-n/" target="_blank" class="product-link">Розчин Рінгера 🔗</a>',
        ringerMalate: '<a href="https://www.uf.ua/product/ringer-malat/" target="_blank" class="product-link">Рінгера-Малат 🔗</a>',
        ringerLactate: '<a href="https://www.uf.ua/product/ringer-laktatnyj-r-n/" target="_blank" class="product-link">Рінгера-Лактат 🔗</a>',
        reosorbilact: '<a href="https://www.uf.ua/product/reosorbilakt-sup-sup/" target="_blank" class="product-link">Реосорбілакт® 🔗</a>',
        xylat: '<a href="https://www.uf.ua/product/ksylat-sup-sup/" target="_blank" class="product-link">Ксилат® 🔗</a>'
    };

    // Auto-scoring from numeric inputs
    autoBtn.addEventListener('click', () => {
        const v = (id) => parseFloat(document.getElementById(id).value);
        const setSel = (id, val) => {
            const el = document.getElementById(id);
            if (!el) return;
            // For Na select, we have 4 options but values are 0,1,2,2.
            // We need to pick the correct index if values are duplicate, or just set value.
            // Since value matches score, setting .value picks the first one.
            // For Na specifically, we might need to be careful visually, but for logic, value is fine.
            // However, to show the correct text in dropdown for Na, we should select by index.
            if(id === 'lab_na_sel') {
                const naVal = v('lab_na');
                if(isNaN(naVal)) return;
                if(naVal >= 135 && naVal <= 145) el.selectedIndex = 0; // Norm
                else if((naVal >= 130 && naVal < 135) || (naVal > 145 && naVal <= 150)) el.selectedIndex = 1; // Mild
                else if(naVal < 130) el.selectedIndex = 2; // Low
                else if(naVal > 150) el.selectedIndex = 3; // High
            } else {
                el.value = String(val);
            }
        };

        const lac = v('lab_lac'); if (!isNaN(lac)) { setSel('lab_lac_sel', lac <= 2.2 ? 0 : (lac <= 4.0 ? 1 : 2)); }
        const cr = v('lab_cr'); if (!isNaN(cr)) { setSel('lab_cr_sel', cr <= 110 ? 0 : (cr <= 176 ? 1 : 2)); }
        // Na handled in special block above
        const na = v('lab_na');
        if (!isNaN(na)) {
            const el = document.getElementById('lab_na_sel');
            if(na >= 135 && na <= 145) el.selectedIndex = 0;
            else if((na >= 130 && na < 135) || (na > 145 && na <= 150)) el.selectedIndex = 1;
            else if(na < 130) el.selectedIndex = 2; // <130
            else if(na > 150) el.selectedIndex = 3; // >150
        }

        const hct = v('lab_hct'); if (!isNaN(hct)) { setSel('lab_hct_sel', (hct >= 30 && hct <= 50) ? 0 : ((hct >= 26 && hct <= 29) || (hct >= 51 && hct <= 55) ? 1 : 2)); }
        const osm = v('lab_osm'); if (!isNaN(osm)) { setSel('lab_osm_sel', (osm >= 275 && osm <= 300) ? 0 : (osm <= 315 ? 1 : 2)); }
        const ph = v('lab_ph'); if (!isNaN(ph)) { setSel('lab_ph_sel', ph >= 7.35 ? 0 : (ph >= 7.30 ? 1 : 2)); }
        const glu = v('lab_glu'); if (!isNaN(glu)) { setSel('lab_glu_sel', (glu >= 4 && glu <= 10) ? 0 : ((glu >= 3.5 && glu < 4) || (glu > 10 && glu <= 13.9) ? 1 : 2)); }

        // Trigger calculation
        calcBtn.click();
    });

    // Calculate IIS
    calcBtn.addEventListener('click', () => {
        const selects = document.querySelectorAll('select[data-weight]');
        let sum = 0;
        selects.forEach(s => sum += parseInt(s.value || '0', 10));

        const max = 42;
        const iis = Math.round(((sum / max) * 10) * 10) / 10;

        document.getElementById('sumScore').textContent = sum;
        document.getElementById('iisScore').textContent = iis.toFixed(1);

        // Interpretation & plan
        let interp = '', plan = '';
        if (iis <= 3) {
            interp = 'Перевантаження / Стабільність';
            plan = `<span class="tag bad">Стратегія: Evacuation</span>
          <ul>
            <li>Обмежити інфузії; розглянути діуретики/де-ресусцитацію.</li>
            <li>Контроль УЗД легень (B-лінії), протокол VExUS.</li>
          </ul>`;
        } else if (iis <= 6) {
            interp = 'Компенсація';
            plan = `<span class="tag warn">Стратегія: Maintenance</span>
          <ul>
            <li>Ізотонічна інфузія 1–2 мл/кг/год під контролем.</li>
            <li>Надавати перевагу збалансованим кристалоїдам (${products.ringerMalate}, ${products.ringerLactate}).</li>
          </ul>`;
        } else {
            interp = 'Гіповолемія / Шок';
            plan = `<span class="tag bad">Стратегія: Resuscitation</span>
          <ul>
            <li>Болюси по 250-500 мл. Розглянути ${products.reosorbilact} (малооб’ємна ресусцитація).</li>
            <li>При вазоплегії — ранні вазопресори.</li>
          </ul>`;
        }
        document.getElementById('interp').textContent = interp;
        document.getElementById('plan').innerHTML = plan;

        // Osmotic driver advice
        const na = parseFloat(document.getElementById('lab_na').value);
        const ph = parseFloat(document.getElementById('lab_ph').value);
        const cr = parseFloat(document.getElementById('lab_cr').value);
        const osm = parseFloat(document.getElementById('lab_osm').value);
        const glu = parseFloat(document.getElementById('lab_glu').value);

        const advice = [];

        // Na Logic
        if (!isNaN(na)) {
            if (na < 130) advice.push(`Тяжка гіпонатріємія (<130) → Обережно з корекцією. Можливе використання NaCl 3% або ${products.reosorbilact} (гіперосмолярний).`);
            else if (na < 135) advice.push(`Гіпонатріємія → Слідкувати за Na⁺. Уникати гіпотонічних розчинів.`);
        }

        // pH Logic (Acidosis)
        if (!isNaN(ph) && ph < 7.35) {
            advice.push(`Ацидоз (pH < 7.35) → Показані збалансовані розчини з буфером (лактат/малат): ${products.ringerLactate}, ${products.ringerMalate}, або ${products.reosorbilact} (корекція ацидозу).`);
        }

        // Kidney (Creatinine)
        if (!isNaN(cr) && cr > 110) {
            advice.push('Ризик ГНН (Креатинін ↑) → Обережно з калієм. Розчини: NaCl 0.9%, Глюкоза, або збалансовані під суворим діурез-контролем. ' + products.xylat + ' (енергетик, обережно при анурії).');
        }

        // Osmolarity
        if (!isNaN(osm)) {
            if(osm < 275) advice.push(`Низька осмолярність (<275) → Ризик набряку клітин. Уникати "вільної води".`);
            if(osm > 315) advice.push(`Висока осмолярність (>315) → Дегідратація. Показані гіпо/ізотонічні кристалоїди: ${products.ringerLactate}, ${products.ringerMalate}.`);
        }

        // Ketosis/Intoxication (Generic based on high glucose or shock context)
        if (iis > 5 && (!isNaN(glu) && glu > 10)) {
            advice.push(`Гіперглікемія/Стрес → Розглянути ${products.xylat} як джерело енергії без значного впливу на глюкозу (інсулін-незалежний).`);
        }

        const osmoAdviceEl = document.getElementById('osmoAdvice');
        if (advice.length > 0) {
            osmoAdviceEl.innerHTML = `<ul>${advice.map(a => `<li>${a}</li>`).join('')}</ul>`;
        } else {
            osmoAdviceEl.innerHTML = `<p class="small muted">Для отримання точних рекомендацій введіть лабораторні показники (Натрій, pH, Осмолярність, Креатинін).</p>
            <div style="margin-top:10px; border-top:1px dashed #333; padding-top:10px;">
                <small>Препарати вибору:</small><br>
                ${products.reosorbilact} ${products.ringerMalate} ${products.ringerLactate}
            </div>`;
        }

        // Show Alert Box
        msgBox.classList.add('visible');
        // Scroll to result
        document.getElementById('resultCard').scrollIntoView({behavior: 'smooth', block: 'start'});
    });

    // Reset
    resetBtn.addEventListener('click', () => {
        document.querySelectorAll('select[data-weight]').forEach(s => s.value = '0');
        document.querySelectorAll('#blockB input').forEach(i => i.value = '');
        document.getElementById('sumScore').textContent = '0';
        document.getElementById('iisScore').textContent = '0.0';
        document.getElementById('interp').textContent = '—';
        document.getElementById('plan').innerHTML = '';
        document.getElementById('osmoAdvice').innerHTML = '<p class="small muted">Заповніть лабораторні значення для отримання персоналізованої підказки.</p>';
        msgBox.classList.remove('visible');

        // Reset patient data
        document.getElementById('pt_hospital').value = '';
        document.getElementById('pt_id').value = '';
        document.getElementById('pt_age').value = '';
        document.getElementById('pt_weight').value = '';
        document.getElementById('pt_gender').value = '';
        document.getElementById('pt_mkb').value = '';
        document.getElementById('pt_mkb_other').value = '';
        document.getElementById('pt_mkb_other').style.display = 'none';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
</body>
</html>
