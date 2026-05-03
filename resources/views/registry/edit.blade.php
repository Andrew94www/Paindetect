<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Редагування: {{ $patient->patient_data['full_name'] ?? 'Пацієнт' }}</title>
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

        .custom-checkbox { width: 1.25rem; height: 1.25rem; border-radius: 0.25rem; background-color: #1e293b; border: 1px solid #64748b; color: #3b82f6; }
        .custom-checkbox:focus { outline: none; box-shadow: 0 0 0 2px #1e293b, 0 0 0 4px #3b82f6; }
    </style>
</head>
<body class="bg-slate-900 text-slate-200 font-sans min-h-screen">

<div id="toast-container"></div>

<div class="max-w-7xl mx-auto p-4 md:p-8">

    <header class="mb-8 flex items-center justify-between border-b pb-4 border-slate-700">
        <div class="flex items-center gap-4">
            <div class="bg-amber-600 text-white p-3 rounded-lg shadow-md">
                <i class="fa-solid fa-pen-to-square text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-100">Редагування запису #{{ $patient->id }}</h1>
                <p class="text-slate-400">Внесіть необхідні зміни та збережіть</p>
            </div>
        </div>
        <a href="javascript:history.back()" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition">
            <i class="fa-solid fa-xmark mr-2"></i> Скасувати
        </a>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">

            <!-- 1. Базові дані -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-user-injured text-blue-500"></i>
                    1. Загальні дані пацієнта
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1">ПІБ (ФІО)</label>
                        <input type="text" id="patientName" value="{{ $patient->patient_data['full_name'] ?? '' }}" placeholder="Прізвище Ім'я По батькові" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-slate-300 mb-1">ID пацієнта / Історії хвороби</label>
                        <input type="text" id="historyId" value="{{ $patient->patient_data['history_id'] ?? '' }}" placeholder="Номер карти" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Вік</label>
                        <input type="number" id="patientAge" value="{{ $patient->patient_data['age'] ?? '' }}" min="0" max="120" placeholder="Років" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Стать</label>
                        <select id="patientGender" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Оберіть --</option>
                            <option value="male" {{ ($patient->patient_data['gender'] ?? '') == 'male' ? 'selected' : '' }}>Чоловіча</option>
                            <option value="female" {{ ($patient->patient_data['gender'] ?? '') == 'female' ? 'selected' : '' }}>Жіноча</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Статус</label>
                        <select id="patientStatus" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="military" {{ ($patient->patient_data['status'] ?? '') == 'military' ? 'selected' : '' }}>Військовий</option>
                            <option value="civilian" {{ ($patient->patient_data['status'] ?? '') == 'civilian' ? 'selected' : '' }}>Цивільний</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Дата травми</label>
                        <input type="date" id="injuryDate" value="{{ $patient->patient_data['injury_date'] ?? '' }}" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1">Механізм травми</label>
                        <select id="injuryMechanism" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Оберіть механізм --</option>
                            <option value="blast" {{ ($patient->patient_data['injury_mechanism'] ?? '') == 'blast' ? 'selected' : '' }}>Вибух</option>
                            <option value="drone" {{ ($patient->patient_data['injury_mechanism'] ?? '') == 'drone' ? 'selected' : '' }}>Дрон (скид / FPV)</option>
                            <option value="gunshot" {{ ($patient->patient_data['injury_mechanism'] ?? '') == 'gunshot' ? 'selected' : '' }}>Вогнепальне поранення</option>
                            <option value="other" {{ ($patient->patient_data['injury_mechanism'] ?? '') == 'other' ? 'selected' : '' }}>Інше</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- Клінічні дані -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-list-check text-blue-500"></i>
                    Клінічні дані (Коди МКХ-10)
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Основне ушкодження</label>
                        <select id="mainTraumaIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Оберіть ушкодження --</option>
                            <option value="S00-S09" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S00-S09' ? 'selected' : '' }}>S00–S09 Травми голови</option>
                            <option value="S10-S19" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S10-S19' ? 'selected' : '' }}>S10–S19 Травми шиї</option>
                            <option value="S20-S29" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S20-S29' ? 'selected' : '' }}>S20–S29 Травми грудної клітки</option>
                            <option value="S30-S39" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S30-S39' ? 'selected' : '' }}>S30–S39 Травми живота</option>
                            <option value="S40-S49" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S40-S49' ? 'selected' : '' }}>S40–S49 Плече</option>
                            <option value="S50-S59" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S50-S59' ? 'selected' : '' }}>S50–S59 Передпліччя</option>
                            <option value="S60-S69" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S60-S69' ? 'selected' : '' }}>S60–S69 Кисть</option>
                            <option value="S48" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S48' ? 'selected' : '' }}>S48 Ампутація плеча</option>
                            <option value="S58" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S58' ? 'selected' : '' }}>S58 Ампутація передпліччя</option>
                            <option value="S68" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S68' ? 'selected' : '' }}>S68 Ампутація кисті</option>
                            <option value="S70-S79" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S70-S79' ? 'selected' : '' }}>S70–S79 Стегно</option>
                            <option value="S80-S89" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S80-S89' ? 'selected' : '' }}>S80–S89 Гомілка</option>
                            <option value="S90-S99" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S90-S99' ? 'selected' : '' }}>S90–S99 Стопа</option>
                            <option value="S78" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S78' ? 'selected' : '' }}>S78 Ампутація стегна</option>
                            <option value="S88" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S88' ? 'selected' : '' }}>S88 Ампутація гомілки</option>
                            <option value="S98" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'S98' ? 'selected' : '' }}>S98 Ампутація стопи</option>
                            <option value="T00-T07" {{ ($patient->icd_codes['mainTrauma'] ?? '') == 'T00-T07' ? 'selected' : '' }}>T00–T07 Множинні ушкодження</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Зовнішня причина</label>
                        <select id="externalCauseIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="Y36" {{ ($patient->icd_codes['externalCause'] ?? '') == 'Y36' ? 'selected' : '' }}>Y36 Військові операції</option>
                            <option value="Y36.0-Y36.9" {{ ($patient->icd_codes['externalCause'] ?? '') == 'Y36.0-Y36.9' ? 'selected' : '' }}>Y36.0–Y36.9 Уточнення (вибух тощо)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Ушкодження судин / нервів</label>
                        <select id="vascularNerveIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 outline-none">
                            <option value="">-- Відсутнє --</option>
                            <option value="S15" {{ ($patient->icd_codes['vascularNerve'] ?? '') == 'S15' ? 'selected' : '' }}>S15 Судини шиї</option>
                            <option value="S55" {{ ($patient->icd_codes['vascularNerve'] ?? '') == 'S55' ? 'selected' : '' }}>S55 Судини верхньої кінцівки</option>
                            <option value="S75" {{ ($patient->icd_codes['vascularNerve'] ?? '') == 'S75' ? 'selected' : '' }}>S75 Судини стегна</option>
                            <option value="S85" {{ ($patient->icd_codes['vascularNerve'] ?? '') == 'S85' ? 'selected' : '' }}>S85 Судини гомілки</option>
                            <option value="G57" {{ ($patient->icd_codes['vascularNerve'] ?? '') == 'G57' ? 'selected' : '' }}>G57 Мононевропатії нижньої кінцівки</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Опіки / Вибухова травма</label>
                        <select id="burnBlastIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 outline-none">
                            <option value="">-- Відсутнє --</option>
                            <option value="T20-T25" {{ ($patient->icd_codes['burnBlast'] ?? '') == 'T20-T25' ? 'selected' : '' }}>T20–T25 Опіки обличчя/рук</option>
                            <option value="T26-T28" {{ ($patient->icd_codes['burnBlast'] ?? '') == 'T26-T28' ? 'selected' : '' }}>T26–T28 Очі, дихальні шляхи</option>
                            <option value="T70.8" {{ ($patient->icd_codes['burnBlast'] ?? '') == 'T70.8' ? 'selected' : '' }}>T70.8 Наслідки вибухової хвилі</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1">Біль та ускладнення</label>
                        <select id="painComplicationIcd" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 outline-none">
                            <option value="">-- Відсутнє --</option>
                            <option value="G89.2" {{ ($patient->icd_codes['painComplication'] ?? '') == 'G89.2' ? 'selected' : '' }}>G89.2 Хронічний біль</option>
                            <option value="G54.6" {{ ($patient->icd_codes['painComplication'] ?? '') == 'G54.6' ? 'selected' : '' }}>G54.6 Фантомний біль</option>
                            <option value="F43.1" {{ ($patient->icd_codes['painComplication'] ?? '') == 'F43.1' ? 'selected' : '' }}>F43.1 ПТСР</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- Предиктори ризику -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-heart-pulse text-red-500"></i>
                    Гострі Предиктори Ризику
                </h2>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="amputation" class="custom-checkbox" {{ !empty($patient->predictors['amputation']) ? 'checked' : '' }}>
                                <span class="font-medium text-slate-200">Ампутація (Загальний факт)</span>
                            </label>
                            <div id="amputationLevelBox" class="conditional-field border-slate-500">
                                <label class="block text-xs text-slate-400 mb-1">Рівень ампутації</label>
                                <select id="amputationLevel" class="w-full p-2 bg-slate-800 border border-slate-600 rounded-md text-slate-200 text-sm outline-none">
                                    <option value="distal" {{ ($patient->predictors['amputationLevel'] ?? '') == 'distal' ? 'selected' : '' }}>Дистальна</option>
                                    <option value="proximal" {{ ($patient->predictors['amputationLevel'] ?? '') == 'proximal' ? 'selected' : '' }}>Проксимальна</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="tourniquet" class="custom-checkbox" {{ !empty($patient->predictors['tourniquet']) ? 'checked' : '' }}>
                                <span class="font-medium text-slate-200">Турнікет</span>
                            </label>
                            <div id="tourniquetDurationBox" class="conditional-field border-slate-500">
                                <label class="block text-xs text-slate-400 mb-1">Тривалість накладання</label>
                                <select id="tourniquetDuration" class="w-full p-2 bg-slate-800 border border-slate-600 rounded-md text-slate-200 text-sm outline-none">
                                    <option value="under60" {{ ($patient->predictors['tourniquetDuration'] ?? '') == 'under60' ? 'selected' : '' }}>Менше 60 хв</option>
                                    <option value="60to120" {{ ($patient->predictors['tourniquetDuration'] ?? '') == '60to120' ? 'selected' : '' }}>Від 60 до 120 хв</option>
                                    <option value="over120" {{ ($patient->predictors['tourniquetDuration'] ?? '') == 'over120' ? 'selected' : '' }}>Більше 120 хв</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="nerveInjury" class="custom-checkbox" {{ !empty($patient->predictors['nerveInjury']) ? 'checked' : '' }}>
                                <span class="font-medium text-slate-200">Ушкодження нерва</span>
                            </label>
                            <div id="nerveTypeBox" class="conditional-field border-slate-500">
                                <label class="block text-xs text-slate-400 mb-1">Тип ушкодження</label>
                                <select id="nerveType" class="w-full p-2 bg-slate-800 border border-slate-600 rounded-md text-slate-200 text-sm outline-none">
                                    <option value="demyelinating" {{ ($patient->predictors['nerveType'] ?? '') == 'demyelinating' ? 'selected' : '' }}>Демієлінізуюче</option>
                                    <option value="axonal" {{ ($patient->predictors['nerveType'] ?? '') == 'axonal' ? 'selected' : '' }}>Аксональне</option>
                                    <option value="mixed" {{ ($patient->predictors['nerveType'] ?? '') == 'mixed' ? 'selected' : '' }}>Змішане</option>
                                </select>
                            </div>
                        </div>

                        <div class="bg-slate-700/50 p-4 rounded-xl border border-slate-600 flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer w-full">
                                <input type="checkbox" id="infection" class="custom-checkbox" {{ !empty($patient->predictors['infection']) ? 'checked' : '' }}>
                                <span class="font-medium text-slate-200">Інфекція (рання/підозра)</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1">Тип травми</label>
                            <select id="traumaType" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 outline-none">
                                <option value="penetrating" {{ ($patient->predictors['traumaType'] ?? '') == 'penetrating' ? 'selected' : '' }}>Проникаюча</option>
                                <option value="blast" {{ ($patient->predictors['traumaType'] ?? '') == 'blast' ? 'selected' : '' }}>Вибухова</option>
                                <option value="crush" {{ ($patient->predictors['traumaType'] ?? '') == 'crush' ? 'selected' : '' }}>Роздавлювання / Краш</option>
                                <option value="combo" {{ ($patient->predictors['traumaType'] ?? '') == 'combo' ? 'selected' : '' }}>Комбінована</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1">Кількість операцій</label>
                            <select id="surgeries" class="w-full p-2.5 bg-slate-700 border border-slate-600 rounded-lg text-slate-100 outline-none">
                                <option value="1" {{ ($patient->predictors['surgeries'] ?? '') == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ ($patient->predictors['surgeries'] ?? '') == '2' ? 'selected' : '' }}>2</option>
                                <option value="3plus" {{ ($patient->predictors['surgeries'] ?? '') == '3plus' ? 'selected' : '' }}>≥ 3</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1">Біль (NRS 0-10)</label>
                            <input type="number" id="acutePain" value="{{ $patient->predictors['acutePain'] ?? 0 }}" min="0" max="10" class="w-full p-2.5 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg outline-none">
                        </div>
                    </div>
                </div>
            </section>

            <!-- ОЦІНКА ПРОТЕЗУВАННЯ -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-6 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-person-walking-with-cane text-purple-500"></i> Оцінка протезування
                </h2>
                <div class="space-y-6">
                    <!-- Характеристика ампутації -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Рівень ампутації</label>
                            <select id="prostheticAmpLevel" class="w-full p-2.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200">
                                <option value="">-- Оберіть рівень --</option>
                                <option value="transfemoral" {{ ($patient->prosthetics_data['amputation_level'] ?? '') == 'transfemoral' ? 'selected' : '' }}>Трансфеморальна (стегно)</option>
                                <option value="transtibial" {{ ($patient->prosthetics_data['amputation_level'] ?? '') == 'transtibial' ? 'selected' : '' }}>Транстибіальна (гомілка)</option>
                                <option value="upper" {{ ($patient->prosthetics_data['amputation_level'] ?? '') == 'upper' ? 'selected' : '' }}>Верхня кінцівка</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Сторона</label>
                            <select id="amputationSidedness" class="w-full p-2.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200">
                                <option value="unilateral" {{ ($patient->prosthetics_data['sidedness'] ?? '') == 'unilateral' ? 'selected' : '' }}>Однобічна</option>
                                <option value="bilateral" {{ ($patient->prosthetics_data['sidedness'] ?? '') == 'bilateral' ? 'selected' : '' }}>Двобічна</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Дата операції</label>
                            <input type="date" id="prostheticSurgeryDate" value="{{ $patient->prosthetics_data['surgery_date'] ?? '' }}" class="w-full p-2.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200">
                        </div>
                        <div class="flex items-center mt-6">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="prostheticRevisions" class="custom-checkbox" {{ !empty($patient->prosthetics_data['revisions']) ? 'checked' : '' }}>
                                <span class="text-slate-200">Повторні ревізії (наявні)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Стан кукси -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 border-t border-slate-700 pt-4">
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Біль у куксі (0–10)</label>
                            <input type="number" id="stumpPain" value="{{ $patient->prosthetics_data['stump_pain'] ?? 0 }}" min="0" max="10" class="w-full p-2.5 bg-slate-800 border border-slate-600 text-slate-200 rounded-lg">
                        </div>
                        <div class="flex items-center mt-1 sm:mt-6">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="phantomPain" class="custom-checkbox" {{ !empty($patient->prosthetics_data['phantom_pain']) ? 'checked' : '' }}>
                                <span class="text-slate-200 text-sm">Фантомний біль</span>
                            </label>
                        </div>
                        <div class="flex items-center mt-1 sm:mt-6">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="scarTenderness" class="custom-checkbox" {{ !empty($patient->prosthetics_data['scar_tenderness']) ? 'checked' : '' }}>
                                <span class="text-slate-200 text-sm">Рубцева болючість</span>
                            </label>
                        </div>
                        <div class="flex items-center mt-1">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="neuromaSigns" class="custom-checkbox" {{ !empty($patient->prosthetics_data['neuroma_signs']) ? 'checked' : '' }}>
                                <span class="text-slate-200 text-sm">Нейрома / ентрапмент</span>
                            </label>
                        </div>
                        <div class="flex items-center mt-1">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="healingIssues" class="custom-checkbox" {{ !empty($patient->prosthetics_data['healing_issues']) ? 'checked' : '' }}>
                                <span class="text-slate-200 text-sm">Проблеми загоєння</span>
                            </label>
                        </div>
                    </div>

                    <!-- Протезування -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-700 pt-4">
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Дата первинного протезування</label>
                            <input type="date" id="primaryProstheticsDate" value="{{ $patient->prosthetics_data['primary_date'] ?? '' }}" class="w-full p-2.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Тип протеза</label>
                            <select id="prosthesisType" class="w-full p-2.5 bg-slate-800 border border-slate-600 rounded-lg text-slate-200">
                                <option value="">-- Оберіть тип --</option>
                                <option value="mechanical" {{ ($patient->prosthetics_data['type'] ?? '') == 'mechanical' ? 'selected' : '' }}>Механічний</option>
                                <option value="microprocessor" {{ ($patient->prosthetics_data['type'] ?? '') == 'microprocessor' ? 'selected' : '' }}>Мікропроцесорний</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Годин використання/день</label>
                            <input type="number" id="prosthesisHours" value="{{ $patient->prosthetics_data['hours_per_day'] ?? '' }}" min="0" max="24" class="w-full p-2.5 bg-slate-800 border border-slate-600 text-slate-200 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Болісність при використанні (0–10)</label>
                            <input type="number" id="prosthesisPain" value="{{ $patient->prosthetics_data['pain_during_use'] ?? 0 }}" min="0" max="10" class="w-full p-2.5 bg-slate-800 border border-slate-600 text-slate-200 rounded-lg">
                        </div>
                    </div>

                    <!-- Функціональна оцінка -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-slate-700 pt-4">
                        <div class="flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="independentWalking" class="custom-checkbox" {{ !empty($patient->prosthetics_data['functional']['independent_walking']) ? 'checked' : '' }}>
                                <span class="text-slate-200">Самостійна ходьба</span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="distance100m" class="custom-checkbox" {{ !empty($patient->prosthetics_data['functional']['distance_100m']) ? 'checked' : '' }}>
                                <span class="text-slate-200">Дистанція > 100 м</span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" id="returnToWork" class="custom-checkbox" {{ !empty($patient->prosthetics_data['functional']['return_to_work']) ? 'checked' : '' }}>
                                <span class="text-slate-200">Повернення до служби/роботи</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm text-slate-400 mb-1">Задоволеність (0–10)</label>
                            <input type="number" id="prosthesisSatisfaction" value="{{ $patient->prosthetics_data['functional']['satisfaction'] ?? 0 }}" min="0" max="10" class="w-full p-2.5 bg-slate-800 border border-slate-600 text-slate-200 rounded-lg">
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="lg:col-span-1">
            <div class="sticky top-8 space-y-6">
                <!-- Блоки для результатів (перераховуються динамічно в JS) -->
                <div class="bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-700">
                    <h3 class="text-lg font-bold text-slate-100 mb-4 border-b border-slate-700 pb-2">Поточний Прогноз</h3>

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ризик тривалої реабілітації</h4>
                        <div id="rehabBox" class="p-4 rounded-xl border-2 transition-all"><div class="flex justify-between items-center mb-1"><span id="rehabText" class="font-bold text-lg">Низький</span><div class="flex items-center gap-1"><span id="rehabScore" class="font-black text-2xl">0</span><span class="text-[10px] font-bold uppercase">балів</span></div></div><p class="text-[11px] opacity-90 mt-1 font-medium leading-tight" id="rehabDesc"></p></div>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ризик хронічного болю (CPRS)</h4>
                        <div id="painBox" class="p-4 rounded-xl border-2 transition-all"><div class="flex justify-between items-center mb-1"><span id="painText" class="font-bold text-lg">Низький</span><div class="flex items-center gap-1"><span id="painScore" class="font-black text-2xl">0</span><span class="text-[10px] font-bold uppercase">балів</span></div></div><p class="text-[11px] opacity-90 mt-1 font-medium leading-tight" id="painDesc"></p></div>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-purple-400 uppercase tracking-wider mb-2">Ризик ускладнень протезування</h4>
                        <div id="prostheticBox" class="p-4 rounded-xl border-2 transition-all"><div class="flex justify-between items-center mb-1"><span id="prostheticText" class="font-bold text-lg">Низький</span><div class="flex items-center gap-1"><span id="prostheticScore" class="font-black text-2xl">0</span><span class="text-[10px] font-bold uppercase">балів</span></div></div><p class="text-[11px] opacity-90 mt-1 font-medium leading-tight" id="prostheticDesc"></p></div>
                    </div>

                    <button id="saveBtn" class="w-full mt-6 bg-amber-600 hover:bg-amber-500 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition-all flex justify-center items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Зберегти зміни
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Вся логіка обрахунків з вашого оригінального файлу
    let currentRehabScore = 0, currentPainScore = 0, currentProstheticScore = 0;

    const getVal = (id) => { const el = document.getElementById(id); return el ? el.value : ''; };
    const getChk = (id) => { const el = document.getElementById(id); return el ? el.checked : false; };
    const getInt = (id) => { const val = parseInt(getVal(id)); return isNaN(val) ? 0 : val; };

    function updateVisibility() {
        document.getElementById('amputationLevelBox')?.classList.toggle('active', getChk('amputation'));
        document.getElementById('tourniquetDurationBox')?.classList.toggle('active', getChk('tourniquet'));
        document.getElementById('nerveTypeBox')?.classList.toggle('active', getChk('nerveInjury'));
    }

    function calculateScores() {
        const traumaType = getVal('traumaType');
        const amputation = getChk('amputation');
        const amputationLevel = getVal('amputationLevel');
        const tourniquet = getChk('tourniquet');
        const tourniquetDuration = getVal('tourniquetDuration');
        const nerveInjury = getChk('nerveInjury');
        const nerveType = getVal('nerveType');
        const infection = getChk('infection');
        const surgeries = getVal('surgeries');
        const acutePain = getInt('acutePain');

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

        let painScore = 0;
        if (traumaType === 'blast') painScore += 2;
        if (tourniquet && tourniquetDuration === 'over120') painScore += 3;
        if (amputation && amputationLevel === 'proximal') painScore += 2;
        if (nerveInjury && nerveType === 'axonal') painScore += 3;
        if (infection) painScore += 1;
        if (acutePain >= 7) painScore += 2;

        let prostheticScore = 0;
        if (getInt('stumpPain') >= 6) prostheticScore += 1;
        if (getChk('phantomPain')) prostheticScore += 1;
        if (getChk('healingIssues')) prostheticScore += 1;
        if (getVal('amputationSidedness') === 'bilateral') prostheticScore += 1;
        const mainIcd = getVal('mainTraumaIcd');
        if (mainIcd === 'S00-S09' || mainIcd.startsWith('S0')) prostheticScore += 1;

        currentRehabScore = rehabScore;
        currentPainScore = painScore;
        currentProstheticScore = prostheticScore;

        updateScoreUI('rehab', rehabScore, { low: "Базова", mod: "Стандарт", high: "Мультидисциплінарна" }, { mod: 4, high: 8 });
        updateScoreUI('pain', painScore, { low: "Стандарт", mod: "Увага", high: "Pain-pathway" }, { mod: 4, high: 8 });
        updateScoreUI('prosthetic', prostheticScore, { low: "Оптимальний", mod: "Контроль", high: "Корекція" }, { mod: 2, high: 4 }, true);
    }

    function updateScoreUI(type, score, descTexts, thresholds, isProsthetic = false) {
        const scoreEl = document.getElementById(`${type}Score`);
        const textEl = document.getElementById(`${type}Text`);
        const boxEl = document.getElementById(`${type}Box`);
        const descEl = document.getElementById(`${type}Desc`);
        if (!scoreEl || !textEl || !boxEl || !descEl) return;

        scoreEl.innerText = score;
        let level = 'Низький', bgClass = 'bg-emerald-900/30', borderClass = 'border-emerald-700/50', textClass = 'text-emerald-400', numClass = 'text-emerald-300', lblClass = 'text-emerald-500/80', desc = descTexts.low;

        if (score >= thresholds.mod && score < thresholds.high) {
            level = 'Середній'; bgClass = 'bg-amber-900/30'; borderClass = 'border-amber-700/50'; textClass = 'text-amber-400'; numClass = 'text-amber-300'; lblClass = 'text-amber-500/80'; desc = descTexts.mod;
        } else if (score >= thresholds.high) {
            level = 'Високий'; desc = descTexts.high;
            if (isProsthetic) { bgClass = 'bg-purple-900/30'; borderClass = 'border-purple-700/50'; textClass = 'text-purple-400'; numClass = 'text-purple-300'; lblClass = 'text-purple-500/80'; }
            else { bgClass = 'bg-rose-900/30'; borderClass = 'border-rose-700/50'; textClass = 'text-rose-400'; numClass = 'text-rose-300'; lblClass = 'text-rose-500/80'; }
        }

        textEl.innerText = level; textEl.className = `font-bold text-lg ${textClass}`; scoreEl.className = `font-black text-2xl ${numClass}`; scoreEl.nextElementSibling.className = `text-[10px] font-bold uppercase ${lblClass}`; boxEl.className = `p-4 rounded-xl border-2 transition-all ${bgClass} ${borderClass}`; descEl.innerText = desc; descEl.className = `text-[11px] opacity-90 mt-1 font-medium leading-tight ${textClass}`;
    }

    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        if (!container) return;
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-circle-exclamation'} mr-2"></i> ${message}`;
        container.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 300); }, 5000);
    }

    async function submitData() {
        const btn = document.getElementById('saveBtn');
        const originalText = btn.innerHTML;

        const payload = {
            patient_data: {
                full_name: getVal('patientName'), history_id: getVal('historyId'), age: getInt('patientAge') || null, gender: getVal('patientGender'), status: getVal('patientStatus'), injury_date: getVal('injuryDate'), injury_mechanism: getVal('injuryMechanism')
            },
            icd_codes: { mainTrauma: getVal('mainTraumaIcd'), externalCause: getVal('externalCauseIcd'), vascularNerve: getVal('vascularNerveIcd'), burnBlast: getVal('burnBlastIcd'), painComplication: getVal('painComplicationIcd') },
            predictors: { traumaType: getVal('traumaType'), amputation: getChk('amputation'), amputationLevel: getChk('amputation') ? getVal('amputationLevel') : null, tourniquet: getChk('tourniquet'), tourniquetDuration: getChk('tourniquet') ? getVal('tourniquetDuration') : null, nerveInjury: getChk('nerveInjury'), nerveType: getChk('nerveInjury') ? getVal('nerveType') : null, infection: getChk('infection'), surgeries: getVal('surgeries'), acutePain: getInt('acutePain') },
            prosthetics_data: { amputation_level: getVal('prostheticAmpLevel'), sidedness: getVal('amputationSidedness'), surgery_date: getVal('prostheticSurgeryDate'), revisions: getChk('prostheticRevisions'), stump_pain: getInt('stumpPain'), phantom_pain: getChk('phantomPain'), scar_tenderness: getChk('scarTenderness'), neuroma_signs: getChk('neuromaSigns'), healing_issues: getChk('healingIssues'), primary_date: getVal('primaryProstheticsDate'), type: getVal('prosthesisType'), hours_per_day: getInt('prosthesisHours') || null, pain_during_use: getInt('prosthesisPain'), functional: { independent_walking: getChk('independentWalking'), distance_100m: getChk('distance100m'), return_to_work: getChk('returnToWork'), satisfaction: getInt('prosthesisSatisfaction') } },
            scores: { rehabScore: currentRehabScore, painScore: currentPainScore, prostheticScore: currentProstheticScore }
        };

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Відправка...';

        try {
            // Зверніть увагу: тут ми стукаємо на роут оновлення і метод зазвичай 'PUT'
            const response = await fetch(`/registry/update/{{ $patient->id }}`, {
                method: 'PUT', // або 'POST', залежно від того, як налаштовано у web.php
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                showToast('Дані успішно оновлено!', 'success');
                setTimeout(() => window.location.href = `/registry/show/{{ $patient->id }}`, 1500);
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
            if (input.type !== 'text') input.addEventListener('change', () => { updateVisibility(); calculateScores(); });
            if (input.type === 'number') input.addEventListener('input', calculateScores);
        });

        document.getElementById('saveBtn').addEventListener('click', submitData);

        // Ініціалізація при завантаженні (щоб показались правильні блоки і бали)
        updateVisibility();
        calculateScores();
    });
</script>
</body>
</html>
