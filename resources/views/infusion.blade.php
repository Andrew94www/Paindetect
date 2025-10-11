<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Infusion Index Score (IIS) — Калькулятор</title>
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
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: linear-gradient(180deg, #0b1220, #0b1220 60%, #0e1628);
            color: var(--ink);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .wrap { max-width: 1080px; margin: 32px auto; padding: 0 16px; }
        h1 { font-size: clamp(24px, 3.3vw, 34px); letter-spacing: .2px; margin: 0 0 6px; }
        h2 { font-size: clamp(18px, 2.2vw, 22px); margin: 22px 0 10px; color: #dce6ff; }
        p.lead { color: var(--muted); margin: 0 0 24px; font-size: 16px; line-height: 1.6; }
        .grid { display: grid; gap: 16px; }
        .grid.cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        @media (max-width: 860px) {
            .grid.cols-2, .grid.cols-3 { grid-template-columns: 1fr; }
        }
        .card {
            background: linear-gradient(180deg, #111a2c, #0f182b);
            border: 1px solid #1f2a44;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .25);
        }
        .card h3 { margin: 0 0 14px; font-size: 18px; color: #d6e2ff; }
        label { display: block; font-size: 14px; margin: 12px 0 6px; color: #cbd6ef; }
        select, input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #253256;
            border-radius: 12px;
            background: #0d1424;
            color: #e8eeff;
            font-size: 15px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        select:focus, input[type="number"]:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(93, 208, 255, 0.2);
        }
        input[type=number] { -moz-appearance: textfield; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .row { display: grid; grid-template-columns: 1fr 140px; gap: 10px; align-items: center; }
        @media (max-width: 480px) { .row { grid-template-columns: 1fr; } }
        .footer { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px; align-items: center; }
        .btn {
            cursor: pointer;
            border-radius: 12px;
            border: none;
            background: #1a2c5a;
            color: #eaf2ff;
            padding: 10px 16px;
            font-weight: 600;
            font-size: 15px;
            transition: background-color 0.2s, transform 0.1s;
        }
        .btn:hover { background-color: #253e7a; }
        .btn:active { transform: translateY(1px); }
        .pill { padding: 6px 12px; border-radius: 999px; border: 1px solid #273251; background: #0c1324; color: #dfe7ff; font-size: 12px; }
        .score { font-size: 28px; font-weight: 800; }
        .tag { display: inline-block; padding: 3px 8px; border-radius: 999px; font-size: 12px; font-weight: 600; margin-left: 8px; border: 1px solid; }
        .tag.good { border-color: var(--good); color: var(--good); background-color: rgba(46, 204, 113, 0.1); }
        .tag.warn { border-color: var(--warn); color: var(--warn); background-color: rgba(241, 196, 15, 0.1); }
        .tag.bad { border-color: var(--bad); color: var(--bad); background-color: rgba(231, 76, 60, 0.1); }
        ul { padding-left: 20px; margin: 8px 0 0; line-height: 1.7; }
        li::marker { color: var(--accent); }
        .small { color: #9fb0cf; font-size: 13px; line-height: 1.5; }
        .muted { color: var(--muted); }
        .kpi { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }
        @media (max-width: 740px) { .kpi { grid-template-columns: 1fr; } }
        .kpi > div { background: #0d1526; border: 1px dashed #223057; border-radius: 14px; padding: 12px; }
        #osmoAdvice ul { list-style-type: none; padding-left: 0; }
        #osmoAdvice li { margin-bottom: 8px; padding-left: 20px; position: relative; }
        #osmoAdvice li::before { content: "💡"; position: absolute; left: 0; }
    </style>
</head>
<body>
<div class="wrap">
    <h1>💧 Infusion Index Score (IIS)</h1>
    <p class="lead">Алгоритм інфузійної терапії з розрахунком <b>IIS</b> (0–10), інтерпретацією та підказками по «осмо-драйверу». Оцінюємо <b>21 показник</b> (A/B/C), кожен: <b>0</b> — норма, <b>1</b> — відхилення, <b>2</b> — патологія.</p>
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
            <div class="row"><label>Натрій (ммоль/л)</label><input type="number" step="1" id="lab_na" placeholder="напр., 132" /></div>
            <select data-weight="1" id="lab_na_sel"><option value="0">135–145</option><option value="1">130–134 або 146–150</option><option value="2">&lt;130 або &gt;150</option></select>
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
            <h3>🖥️ C. Інструментальні/динамічні</h3>
            <label>ЦВТ / динаміка CVP</label>
            <select data-weight="1"><option value="0">6–12 мм рт.ст. / стабільно</option><option value="1">&lt;6 або &gt;12 без клініки перевантаження</option><option value="2">&gt;12 із застоєм або &lt;4 із шоком</option></select>
            <label>УЗД-IVC (інспіраторний колапс)</label>
            <select data-weight="1"><option value="0">Норма</option><option value="1">Помірно колабує/повнокровна</option><option value="2">Колабує (гіповолемія) або плетора</option></select>
            <label>ΔVTI / динаміка CO</label>
            <select data-weight="1"><option value="0">Стабільний</option><option value="1">Незначне зниження</option><option value="2">Виражене зниження / приріст ≥15% після PLR</option></select>
            <label>ΔPP / SVV</label>
            <select data-weight="1"><option value="0">≤12%</option><option value="1">13–15% або межові умови</option><option value="2">&gt;15% за валідних умов</option></select>
            <label>Біоімпеданс/NICOM — cardiac index</label>
            <select data-weight="1"><option value="0">≥2.5 л/хв/м²</option><option value="1">2.0–2.49 л/хв/м²</option><option value="2">&lt;2.0 л/хв/м²</option></select>
            <label>Кліренс лактату (2–4 год)</label>
            <select data-weight="1"><option value="0">≥20%</option><option value="1">10–19%</option><option value="2">&lt;10% або зростання</option></select>
            <label>Відповідь на інфузію (PLR/міні-болюс)</label>
            <select data-weight="1"><option value="0">Немає</option><option value="1">Сумнівна</option><option value="2">Підтверджена</option></select>
        </div>
    </div>
    <div class="footer">
        <button class="btn" id="calcBtn">Розрахувати IIS</button>
        <button class="btn" id="autoBtn">Автоскоринг лаб. даних</button>
        <button class="btn" id="resetBtn">Скинути</button>
        <span class="pill">IIS = (Σ балів / 42) × 10</span>
    </div>
    <div class="grid cols-2" style="margin-top:16px">
        <div class="card" id="resultCard">
            <h3>🚦 Результати</h3>
            <div class="kpi">
                <div>
                    <div class="muted">Σ балів (0–42)</div>
                    <div id="sumScore" class="score">0</div>
                </div>
                <div>
                    <div class="muted">IIS (0–10)</div>
                    <div id="iisScore" class="score">0.0</div>
                </div>
                <div>
                    <div class="muted">Інтерпретація</div>
                    <div id="interp" class="score">—</div>
                </div>
            </div>
            <div id="plan" style="margin-top:12px"></div>
        </div>
        <div class="card">
            <h3>💡 Осмо-драйвер: вибір розчину</h3>
            <div id="osmoAdvice"><p class="small muted">Заповніть лабораторні значення для отримання персоналізованої підказки.</p></div>
        </div>
    </div>
    <p class="small" style="text-align: center; margin-top: 24px;">Ревізія кожні <b>4–6 годин</b> або при клінічних змінах. Інструмент не замінює клінічне рішення.</p>
</div>
<script>
    const autoBtn = document.getElementById('autoBtn');
    const calcBtn = document.getElementById('calcBtn');
    const resetBtn = document.getElementById('resetBtn');

    // Auto-scoring from numeric inputs
    autoBtn.addEventListener('click', () => {
        const v = (id) => parseFloat(document.getElementById(id).value);
        const setSel = (id, val) => {
            const el = document.getElementById(id);
            if (!el) return;
            el.value = String(val);
        };

        const lac = v('lab_lac'); if (!isNaN(lac)) { setSel('lab_lac_sel', lac <= 2.2 ? 0 : (lac <= 4.0 ? 1 : 2)); }
        const cr = v('lab_cr'); if (!isNaN(cr)) { setSel('lab_cr_sel', cr <= 110 ? 0 : (cr <= 176 ? 1 : 2)); }
        const na = v('lab_na'); if (!isNaN(na)) { setSel('lab_na_sel', (na >= 135 && na <= 145) ? 0 : ((na >= 130 && na <= 134) || (na >= 146 && na <= 150) ? 1 : 2)); }
        const hct = v('lab_hct'); if (!isNaN(hct)) { setSel('lab_hct_sel', (hct >= 30 && hct <= 50) ? 0 : ((hct >= 26 && hct <= 29) || (hct >= 51 && hct <= 55) ? 1 : 2)); }
        const osm = v('lab_osm'); if (!isNaN(osm)) { setSel('lab_osm_sel', (osm >= 275 && osm <= 300) ? 0 : (osm <= 315 ? 1 : 2)); }
        const ph = v('lab_ph'); if (!isNaN(ph)) { setSel('lab_ph_sel', ph >= 7.35 ? 0 : (ph >= 7.30 ? 1 : 2)); }
        const glu = v('lab_glu'); if (!isNaN(glu)) { setSel('lab_glu_sel', (glu >= 4 && glu <= 10) ? 0 : ((glu >= 3.5 && glu < 4) || (glu > 10 && glu <= 13.9) ? 1 : 2)); }

        // Trigger calculation after auto-scoring
        calcBtn.click();
    });

    // Calculate IIS
    calcBtn.addEventListener('click', () => {
        const selects = document.querySelectorAll('select[data-weight]');
        let sum = 0;
        selects.forEach(s => sum += parseInt(s.value || '0', 10));

        const max = 42; // 21 * 2
        const iis = Math.round(((sum / max) * 10) * 10) / 10; // one decimal

        document.getElementById('sumScore').textContent = sum;
        document.getElementById('iisScore').textContent = iis.toFixed(1);

        // Interpretation & plan
        let interp = '', plan = '';
        if (iis <= 3) {
            interp = 'Перевантаження';
            plan = `<span class="tag bad">Стратегія</span>
          <ul>
            <li>Обмежити інфузії; розглянути діуретики/де-ресусцитацію (ROSE: Evacuation).</li>
            <li>Мінімізувати Cl⁻-навантаження; контроль УЗД легень (B-лінії), VExUS.</li>
          </ul>`;
        } else if (iis <= 6) {
            interp = 'Компенсація';
            plan = `<span class="tag warn">Стратегія</span>
          <ul>
            <li>Ізотонічна інфузія 1–2 мл/кг/год з постійним моніторингом відповіді (PLR/ΔVTI).</li>
            <li>Надавати перевагу збалансованим кристалоїдам.</li>
          </ul>`;
        } else {
            interp = 'Гіповолемія / Шок';
            plan = `<span class="tag bad">Стратегія</span>
          <ul>
            <li>Болюси по 250 мл (≈4 мл/кг) з оцінкою відповіді; ранні вазопресори при вазоплегії.</li>
            <li>Розглянути гіпо- або гіпертонічні/альбумінові розчини в залежності від Na⁺/осмолярності.</li>
          </ul>`;
        }
        document.getElementById('interp').textContent = interp;
        document.getElementById('plan').innerHTML = plan;

        // Osmotic driver advice
        const na = parseFloat(document.getElementById('lab_na').value);
        const ph = parseFloat(document.getElementById('lab_ph').value);
        const cr = parseFloat(document.getElementById('lab_cr').value);
        const osm = parseFloat(document.getElementById('lab_osm').value);

        const advice = [];
        if (!isNaN(na) && na < 135) { advice.push('Гіпонатріємія → <b>NaCl 3%</b> обережно (контроль ΔNa⁺ ≤8–10 ммоль/л/добу).'); }
        if (!isNaN(ph) && ph < 7.35) { advice.push('Ацидоз → <b>Розчини з лактатом (Hartmann)</b> або інші збалансовані.'); }
        if (!isNaN(cr) && cr > 110) { advice.push('Ризик ГНН → Розчини <b>без калію</b> (NaCl, глюкоза), індивідуальний підхід.'); }
        if (!isNaN(osm) && osm < 275) { advice.push('Низька осмолярність / клітинна дегідратація → <b>D5W</b> (уважно за Na⁺).'); }
        if (!isNaN(osm) && osm > 315) { advice.push('Висока осмолярність → <b>Рінгера лактат/комбіновані</b> (обмежити «вільну воду»).'); }

        const osmoAdviceEl = document.getElementById('osmoAdvice');
        if (advice.length > 0) {
            osmoAdviceEl.innerHTML = `<ul>${advice.map(a => `<li>${a}</li>`).join('')}</ul>`;
        } else {
            osmoAdviceEl.innerHTML = '<p class="small muted">Заповніть лабораторні значення для отримання персоналізованої підказки.</p>';
        }
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
    });
</script>
</body>
</html>

