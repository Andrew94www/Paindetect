<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Реєстр Бойової Травми та Прогнозування</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .transition-all { transition: all 0.3s ease; }
        .conditional-field { display: none; margin-top: 0.75rem; padding-left: 1rem; border-left: 2px solid #e2e8f0; }
        .conditional-field.active { display: block; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }

        #toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 50; display: flex; flex-direction: column; gap: 10px; }
        .toast { padding: 16px; border-radius: 8px; color: white; opacity: 0; transform: translateX(100%); transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 400px; word-break: break-word; }
        .toast.show { opacity: 1; transform: translateX(0); }
        .toast.success { background-color: #10b981; }
        .toast.error { background-color: #ef4444; }
        .toast.info { background-color: #3b82f6; }
    </style>
</head>
<body class="bg-slate-900 text-slate-200 font-sans min-h-screen">

<div id="toast-container"></div>

<div class="max-w-7xl mx-auto p-4 md:p-8">

    <header class="mb-8 text-center md:text-left flex items-center gap-4 border-b pb-4 border-slate-700">
        <div class="bg-blue-600 text-white p-3 rounded-lg shadow-md">
            <i class="fa-solid fa-truck-medical text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-100">Реєстр Бойової Травми</h1>
            <p class="text-slate-400">Збір даних (МКХ-10) та калькулятор прогнозування ризиків (CPRS)</p>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-user-injured text-blue-500"></i>
                    Загальні дані пацієнта
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1">ПІБ (ФІО)</label>
                        <input type="text" id="patientName" placeholder="Прізвище Ім'я По батькові" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Вік</label>
                        <input type="number" id="patientAge" min="0" max="120" placeholder="Років" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-slate-300 mb-1">ID історії хвороби</label>
                        <input type="text" id="historyId" placeholder="Номер медичної карти / історії хвороби" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </section>

            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-list-check text-blue-500"></i>
                    Клінічні дані (Коди МКХ-10)
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Основне ушкодження (S00-T98)</label>
                        <select id="mainTraumaIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Оберіть ушкодження --</option>
                            <optgroup label="Голова та шия">
                                <option value="S00-S09">S00–S09 Травми голови (ЧМТ, переломи)</option>
                                <option value="S02">S02 Переломи лиця</option>
                                <option value="S10-S19">S10–S19 Травми шиї</option>
                            </optgroup>
                            <optgroup label="Грудна клітка">
                                <option value="S20-S29">S20–S29 Травми грудної клітки</option>
                                <option value="S27">S27 Пошкодження легень</option>
                                <option value="S22">S22 Переломи ребер</option>
                            </optgroup>
                            <optgroup label="Живіт і таз">
                                <option value="S30-S39">S30–S39 Травми живота</option>
                                <option value="S36">S36 Пошкодження печінки/селезінки</option>
                                <option value="S37">S37 Пошкодження органів таза</option>
                            </optgroup>
                            <optgroup label="Верхня кінцівка">
                                <option value="S40-S49">S40–S49 Плече</option>
                                <option value="S50-S59">S50–S59 Передпліччя</option>
                                <option value="S60-S69">S60–S69 Кисть</option>
                                <option value="S48">S48 Травматична ампутація плеча</option>
                                <option value="S58">S58 Ампутація передпліччя</option>
                                <option value="S68">S68 Ампутація кисті</option>
                            </optgroup>
                            <optgroup label="Нижня кінцівка">
                                <option value="S70-S79">S70–S79 Стегно</option>
                                <option value="S80-S89">S80–S89 Гомілка</option>
                                <option value="S90-S99">S90–S99 Стопа</option>
                                <option value="S78">S78 Ампутація стегна</option>
                                <option value="S88">S88 Ампутація гомілки</option>
                                <option value="S98">S98 Ампутація стопи</option>
                            </optgroup>
                            <optgroup label="Множинна травма">
                                <option value="T00-T07">T00–T07 Множинні ушкодження</option>
                                <option value="T14">T14 Неуточнена травма</option>
                                <option value="T79">T79 Ранні ускладнення (шок, компартмент)</option>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Зовнішня причина</label>
                        <select id="externalCauseIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="Y36">Y36 Військові операції</option>
                            <option value="Y36.0-Y36.9">Y36.0–Y36.9 Уточнення (вибух, вогнепальна зброя тощо)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Ушкодження судин / нервів</label>
                        <select id="vascularNerveIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Відсутнє --</option>
                            <optgroup label="Судини">
                                <option value="S15">S15 Судини шиї</option>
                                <option value="S25">S25 Судини грудної клітки</option>
                                <option value="S35">S35 Судини живота</option>
                                <option value="S55">S55 Судини верхньої кінцівки</option>
                                <option value="S75">S75 Судини стегна</option>
                                <option value="S85">S85 Судини гомілки</option>
                            </optgroup>
                            <optgroup label="Нерви">
                                <option value="S14">S14 Ушкодження нервів шийного рівня</option>
                                <option value="S24">S24 Грудний рівень</option>
                                <option value="S34">S34 Поперековий</option>
                                <option value="G57">G57 Мононевропатії нижньої кінцівки</option>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Опіки / Вибухова травма</label>
                        <select id="burnBlastIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Відсутнє --</option>
                            <option value="T20-T25">T20–T25 Опіки обличчя/верхніх кінцівок</option>
                            <option value="T26-T28">T26–T28 Очі, дихальні шляхи</option>
                            <option value="T29-T32">T29–T32 Опіки множинні</option>
                            <option value="T70.8">T70.8 Наслідки вибухової хвилі</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1">Біль та ускладнення (хронічні / фантомні)</label>
                        <select id="painComplicationIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Відсутнє --</option>
                            <option value="G89.2">G89.2 Хронічний біль</option>
                            <option value="G54.6">G54.6 Фантомний біль</option>
                            <option value="T90-T98">T90–T98 Наслідки травм</option>
                            <option value="M79.2">M79.2 Невралгія</option>
                            <option value="F43.1">F43.1 Посттравматичний стресовий розлад</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-heart-pulse text-red-500"></i>
                    Предиктори Ризику (1-3 доба)
                </h2>
                <p class="text-sm text-slate-400 mb-6">Введіть клінічні показники для автоматичного розрахунку ризику тривалої реабілітації та хронічного болю (CPRS).</p>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Тип травми</label>
                        <select id="traumaType" class="w-full p-3 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="penetrating">Проникаюча (Penetrating)</option>
                            <option value="blast">Вибухова (Blast)</option>
                            <option value="crush">Роздавлювання / Краш (Crush)</option>
                            <option value="combo">Комбінована (Combo)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="amputation" class="w-5 h-5 bg-slate-800 border-slate-500 text-blue-500 rounded focus:ring-blue-500 focus:ring-offset-slate-800">
                                <span class="font-medium text-slate-200">Ампутація</span>
                            </label>
                            <div id="amputationLevelBox" class="conditional-field border-slate-500">
                                <label class="block text-xs text-slate-400 mb-1">Рівень ампутації</label>
                                <select id="amputationLevel" class="w-full p-2 bg-slate-800 border border-slate-600 rounded-md text-slate-200 text-sm outline-none">
                                    <option value="distal">Дистальна (кисть, стопа, гомілка)</option>
                                    <option value="proximal">Проксимальна (вище коліна/ліктя)</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="tourniquet" class="w-5 h-5 bg-slate-800 border-slate-500 text-blue-500 rounded focus:ring-blue-500 focus:ring-offset-slate-800">
                                <span class="font-medium text-slate-200">Турнікет</span>
                            </label>
                            <div id="tourniquetDurationBox" class="conditional-field border-slate-500">
                                <label class="block text-xs text-slate-400 mb-1">Тривалість накладання</label>
                                <select id="tourniquetDuration" class="w-full p-2 bg-slate-800 border border-slate-600 rounded-md text-slate-200 text-sm outline-none">
                                    <option value="under60">Менше 60 хв</option>
                                    <option value="60to120">Від 60 до 120 хв</option>
                                    <option value="over120">Більше 120 хв</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="nerveInjury" class="w-5 h-5 bg-slate-800 border-slate-500 text-blue-500 rounded focus:ring-blue-500 focus:ring-offset-slate-800">
                                <span class="font-medium text-slate-200">Ушкодження нерва</span>
                            </label>
                            <div id="nerveTypeBox" class="conditional-field border-slate-500">
                                <label class="block text-xs text-slate-400 mb-1">Тип ушкодження</label>
                                <select id="nerveType" class="w-full p-2 bg-slate-800 border border-slate-600 rounded-md text-slate-200 text-sm outline-none">
                                    <option value="demyelinating">Демієлінізуюче</option>
                                    <option value="axonal">Аксональне</option>
                                    <option value="mixed">Змішане</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600 flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer w-full">
                                <input type="checkbox" id="infection" class="w-5 h-5 bg-slate-800 border-slate-500 text-blue-500 rounded focus:ring-blue-500 focus:ring-offset-slate-800">
                                <span class="font-medium text-slate-200">Інфекція (рання/підозра)</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1">Кількість операцій</label>
                            <select id="surgeries" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 outline-none">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3plus">≥ 3</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1">Дні в реанімації (ICU)</label>
                            <select id="icuDays" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 outline-none">
                                <option value="0">0</option>
                                <option value="1-2">1–2 дні</option>
                                <option value="3plus">≥ 3 днів</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1">Гострий біль (NRS 0-10)</label>
                            <input type="number" id="acutePain" min="0" max="10" value="0" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-8 space-y-6">

                <div class="bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-700">
                    <h3 class="text-lg font-bold text-slate-100 mb-4 border-b border-slate-700 pb-2">Результати Прогнозу</h3>

                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Ризик тривалої реабілітації</h4>
                        <div id="rehabBox" class="p-4 rounded-xl border-2 transition-all">
                            <div class="flex justify-between items-center mb-1">
                                <span id="rehabText" class="font-bold text-lg">Низький</span>
                                <div class="flex items-center gap-1">
                                    <span id="rehabScore" class="font-black text-2xl">0</span>
                                    <span class="text-xs font-bold uppercase">балів</span>
                                </div>
                            </div>
                            <p class="text-xs opacity-90 mt-1 font-medium" id="rehabDesc">Базова траєкторія відновлення.</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Ризик хронічного болю (CPRS)</h4>
                        <div id="painBox" class="p-4 rounded-xl border-2 transition-all">
                            <div class="flex justify-between items-center mb-1">
                                <span id="painText" class="font-bold text-lg">Низький</span>
                                <div class="flex items-center gap-1">
                                    <span id="painScore" class="font-black text-2xl">0</span>
                                    <span class="text-xs font-bold uppercase">балів</span>
                                </div>
                            </div>
                            <p class="text-xs opacity-90 mt-1 font-medium" id="painDesc">Стандартний контроль болю.</p>
                        </div>
                    </div>

                    <button id="saveBtn" class="w-full mt-6 bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all flex justify-center items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Зберегти в реєстр
                    </button>
                </div>

                <div class="bg-blue-900/30 p-4 rounded-xl border border-blue-800/50 text-sm text-blue-300">
                    <p class="font-bold mb-1"><i class="fa-solid fa-circle-info mr-1"></i> Інтерпретація балів (0-13):</p>
                    <ul class="list-disc list-inside space-y-1 opacity-90 ml-1 mt-2">
                        <li><strong>0–3:</strong> Низький ризик</li>
                        <li><strong>4–7:</strong> Середній ризик</li>
                        <li><strong>≥ 8:</strong> Високий ризик</li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    let currentRehabScore = 0;
    let currentPainScore = 0;

    function updateVisibility() {
        document.getElementById('amputationLevelBox').classList.toggle('active', document.getElementById('amputation').checked);
        document.getElementById('tourniquetDurationBox').classList.toggle('active', document.getElementById('tourniquet').checked);
        document.getElementById('nerveTypeBox').classList.toggle('active', document.getElementById('nerveInjury').checked);
    }

    function calculateScores() {
        const traumaType = document.getElementById('traumaType').value;
        const amputation = document.getElementById('amputation').checked;
        const amputationLevel = document.getElementById('amputationLevel').value;
        const tourniquet = document.getElementById('tourniquet').checked;
        const tourniquetDuration = document.getElementById('tourniquetDuration').value;
        const nerveInjury = document.getElementById('nerveInjury').checked;
        const nerveType = document.getElementById('nerveType').value;
        const infection = document.getElementById('infection').checked;
        const surgeries = document.getElementById('surgeries').value;
        const icuDays = document.getElementById('icuDays').value;
        const acutePain = parseInt(document.getElementById('acutePain').value) || 0;

        let rehabScore = 0;
        if (traumaType === 'blast' || traumaType === 'crush') rehabScore += 2;
        if (traumaType === 'combo') rehabScore += 3;

        if (amputation) {
            rehabScore += 2;
            if (amputationLevel === 'distal') rehabScore += 1;
            if (amputationLevel === 'proximal') rehabScore += 2;
        }

        if (infection) rehabScore += 2;
        if (surgeries === '2') rehabScore += 1;
        if (surgeries === '3plus') rehabScore += 2;
        if (icuDays === '1-2') rehabScore += 1;
        if (icuDays === '3plus') rehabScore += 2;

        let painScore = 0;
        if (traumaType === 'blast') painScore += 2;
        if (tourniquet && tourniquetDuration === 'over120') painScore += 3;
        if (amputation && amputationLevel === 'proximal') painScore += 2;
        if (nerveInjury && nerveType === 'axonal') painScore += 3;
        if (infection) painScore += 1;
        if (acutePain >= 7) painScore += 2;

        currentRehabScore = rehabScore;
        currentPainScore = painScore;

        updateScoreUI('rehab', rehabScore, {
            low: "Базова траєкторія відновлення.",
            mod: "Стандарт + контроль ускладнень (Moderate).",
            high: "Мультидисциплінарна команда, психоскринінг (High)."
        });
        updateScoreUI('pain', painScore, {
            low: "Стандартний контроль болю.",
            mod: "Підвищена увага до знеболення.",
            high: "Спеціалізований pain-pathway маршрут."
        });
    }

    function updateScoreUI(type, score, descTexts) {
        const scoreEl = document.getElementById(`${type}Score`);
        const textEl = document.getElementById(`${type}Text`);
        const boxEl = document.getElementById(`${type}Box`);
        const descEl = document.getElementById(`${type}Desc`);

        scoreEl.innerText = score;

        let level = 'Низький';
        let bgClass = 'bg-emerald-900/30';
        let borderClass = 'border-emerald-700/50';
        let textClass = 'text-emerald-400';
        let numClass = 'text-emerald-300';
        let lblClass = 'text-emerald-500/80';
        let desc = descTexts.low;

        if (score >= 4 && score <= 7) {
            level = 'Середній';
            bgClass = 'bg-amber-900/30';
            borderClass = 'border-amber-700/50';
            textClass = 'text-amber-400';
            numClass = 'text-amber-300';
            lblClass = 'text-amber-500/80';
            desc = descTexts.mod;
        } else if (score >= 8) {
            level = 'Високий';
            bgClass = 'bg-rose-900/30';
            borderClass = 'border-rose-700/50';
            textClass = 'text-rose-400';
            numClass = 'text-rose-300';
            lblClass = 'text-rose-500/80';
            desc = descTexts.high;
        }

        textEl.innerText = level;
        textEl.className = `font-bold text-lg ${textClass}`;
        scoreEl.className = `font-black text-2xl ${numClass}`;
        scoreEl.nextElementSibling.className = `text-xs font-bold uppercase ${lblClass}`;
        boxEl.className = `p-4 rounded-xl border-2 transition-all ${bgClass} ${borderClass}`;
        descEl.innerText = desc;
        descEl.className = `text-xs opacity-90 mt-1 font-medium ${textClass}`;
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-circle-exclamation' : 'fa-info-circle')} mr-2"></i> ${message}`;
        container.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    async function submitData() {
        const btn = document.getElementById('saveBtn');
        const originalText = btn.innerHTML;

        // Збираємо дані, включаючи нові поля пацієнта
        const payload = {
            hospital_id: "{{ Auth::guard('hospital')->id() }}",

            // НОВИЙ БЛОК: Дані пацієнта
            patient_data: {
                full_name: document.getElementById('patientName').value,
                age: parseInt(document.getElementById('patientAge').value) || null,
                history_id: document.getElementById('historyId').value
            },

            icd_codes: {
                mainTrauma: document.getElementById('mainTraumaIcd').value,
                externalCause: document.getElementById('externalCauseIcd').value,
                vascularNerve: document.getElementById('vascularNerveIcd').value,
                burnBlast: document.getElementById('burnBlastIcd').value,
                painComplication: document.getElementById('painComplicationIcd').value,
            },
            predictors: {
                traumaType: document.getElementById('traumaType').value,
                amputation: document.getElementById('amputation').checked,
                amputationLevel: document.getElementById('amputation').checked ? document.getElementById('amputationLevel').value : null,
                tourniquet: document.getElementById('tourniquet').checked,
                tourniquetDuration: document.getElementById('tourniquet').checked ? document.getElementById('tourniquetDuration').value : null,
                nerveInjury: document.getElementById('nerveInjury').checked,
                nerveType: document.getElementById('nerveInjury').checked ? document.getElementById('nerveType').value : null,
                infection: document.getElementById('infection').checked,
                surgeries: document.getElementById('surgeries').value,
                icuDays: document.getElementById('icuDays').value,
                acutePain: parseInt(document.getElementById('acutePain').value) || 0
            },
            scores: {
                rehabScore: currentRehabScore,
                painScore: currentPainScore
            }
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Відправка...';

        try {
            const response = await fetch('/registry/createData', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                showToast('Дані успішно збережено в реєстр!', 'success');

                // Робимо редирект через 1.5 секунди
                setTimeout(() => {
                    // Варіант 1: Використовуємо id, який ми вже отримали в об'єкті payload
                    window.location.href = `/registry/list/${payload.hospital_id}`;

                    // Варіант 2 (Альтернативний): Використання іменованого маршруту Blade
                    // window.location.href = "{{ route('registry.list', ['id' => Auth::guard('hospital')->id()]) }}";
                }, 1500);

            } else {
                throw new Error(`Помилка сервера: ${response.status}`);
            }
        } catch (error) {
            showToast('Сталася помилка при збереженні.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('input, select');

        inputs.forEach(input => {
            // Для текстових полів нам не потрібно перераховувати бали
            if (input.type !== 'text' && input.id !== 'patientName' && input.id !== 'historyId') {
                input.addEventListener('change', () => {
                    updateVisibility();
                    calculateScores();
                });
            }

            if(input.type === 'number' && input.id !== 'patientAge') {
                input.addEventListener('input', calculateScores);
            }
        });

        document.getElementById('saveBtn').addEventListener('click', submitData);

        updateVisibility();
        calculateScores();
    });
</script>
</body>
</html>
