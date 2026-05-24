<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перегляд пацієнта: {{ $patient->patient_data['full_name'] ?? 'Невідомо' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-200 font-sans min-h-screen">

@php
    // Хелпери для перекладу значень з БД у людський текст
    $genders = ['male' => 'Чоловіча', 'female' => 'Жіноча'];
    $statuses = ['military' => 'Військовий', 'civilian' => 'Цивільний'];
    $mechanisms = ['blast' => 'Вибух', 'drone' => 'Дрон (скид / FPV)', 'gunshot' => 'Вогнепальне поранення', 'other' => 'Інше'];

    $ampLevels = ['distal' => 'Дистальна', 'proximal' => 'Проксимальна'];
    $tourniquetDurations = ['under60' => 'Менше 60 хв', '60to120' => 'Від 60 до 120 хв', 'over120' => 'Більше 120 хв'];
    $nerveTypes = ['demyelinating' => 'Демієлінізуюче', 'axonal' => 'Аксональне', 'mixed' => 'Змішане'];
    $traumaTypes = ['penetrating' => 'Проникаюча', 'blast' => 'Вибухова', 'crush' => 'Роздавлювання / Краш', 'combo' => 'Комбінована'];
    $surgeriesCount = ['1' => '1', '2' => '2', '3plus' => '≥ 3'];

    $prostheticLevels = ['transfemoral' => 'Трансфеморальна (стегно)', 'transtibial' => 'Транстибіальна (гомілка)', 'upper' => 'Верхня кінцівка'];
    $sidedness = ['unilateral' => 'Однобічна', 'bilateral' => 'Двобічна'];
    $prosthesisTypes = ['mechanical' => 'Механічний', 'microprocessor' => 'Мікропроцесорний'];

    // Макрос для відображення галочок
    $checkIcon = function($condition) {
        return $condition
            ? '<i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i> <span class="text-emerald-400 font-medium">Так</span>'
            : '<i class="fa-solid fa-circle-xmark text-slate-600 text-lg"></i> <span class="text-slate-500">Ні</span>';
    };
@endphp

<div class="max-w-7xl mx-auto p-4 md:p-8">

    <header class="mb-8 text-center md:text-left flex items-center justify-between border-b pb-4 border-slate-700">
        <div class="flex items-center gap-4">
            <div class="bg-blue-600 text-white p-3 rounded-lg shadow-md">
                <i class="fa-solid fa-file-medical text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-100">Картка пацієнта</h1>
                <p class="text-slate-400">ID Запису: #{{ $patient->id }} | Створено: {{ $patient->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>
        <div>
            <!-- Кнопка повернення (змініть URL на ваш роут списку) -->
            <a href="javascript:history.back()" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Назад
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-8">

            <!-- 1. Базові дані -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-user-injured text-blue-500"></i>
                    1. Загальні дані пацієнта
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-4 gap-x-6">
                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium text-slate-400 mb-1">ПІБ (ФІО)</span>
                        <div class="text-lg font-medium text-slate-100">{{ $patient->patient_data['full_name'] ?? '—' }}</div>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-slate-400 mb-1">Історія хвороби</span>
                        <div class="text-lg text-slate-100">{{ $patient->patient_data['history_id'] ?? '—' }}</div>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-slate-400 mb-1">Вік</span>
                        <div class="text-slate-200">{{ $patient->patient_data['age'] ?? '—' }} років</div>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-slate-400 mb-1">Стать</span>
                        <div class="text-slate-200">{{ $genders[$patient->patient_data['gender'] ?? ''] ?? '—' }}</div>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-slate-400 mb-1">Статус</span>
                        <div class="text-slate-200">{{ $statuses[$patient->patient_data['status'] ?? ''] ?? '—' }}</div>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-slate-400 mb-1">Дата травми</span>
                        <div class="text-slate-200">{{ !empty($patient->patient_data['injury_date']) ? \Carbon\Carbon::parse($patient->patient_data['injury_date'])->format('d.m.Y') : '—' }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium text-slate-400 mb-1">Механізм травми</span>
                        <div class="text-slate-200">{{ $mechanisms[$patient->patient_data['injury_mechanism'] ?? ''] ?? '—' }}</div>
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
                    <div class="bg-slate-700/30 p-3 rounded-lg">
                        <span class="block text-xs text-slate-400 mb-1">Основне ушкодження</span>
                        <div class="font-medium text-slate-200">{{ $patient->icd_codes['mainTrauma'] ?? 'Відсутнє' }}</div>
                    </div>
                    <div class="bg-slate-700/30 p-3 rounded-lg">
                        <span class="block text-xs text-slate-400 mb-1">Зовнішня причина</span>
                        <div class="font-medium text-slate-200">{{ $patient->icd_codes['externalCause'] ?? 'Відсутнє' }}</div>
                    </div>
                    <div class="bg-slate-700/30 p-3 rounded-lg">
                        <span class="block text-xs text-slate-400 mb-1">Ушкодження судин / нервів</span>
                        <div class="font-medium text-slate-200">{{ $patient->icd_codes['vascularNerve'] ?? 'Відсутнє' }}</div>
                    </div>
                    <div class="bg-slate-700/30 p-3 rounded-lg">
                        <span class="block text-xs text-slate-400 mb-1">Опіки / Вибухова травма</span>
                        <div class="font-medium text-slate-200">{{ $patient->icd_codes['burnBlast'] ?? 'Відсутнє' }}</div>
                    </div>
                    <div class="md:col-span-2 bg-slate-700/30 p-3 rounded-lg">
                        <span class="block text-xs text-slate-400 mb-1">Біль та ускладнення</span>
                        <div class="font-medium text-slate-200">{{ $patient->icd_codes['painComplication'] ?? 'Відсутнє' }}</div>
                    </div>
                </div>
            </section>

            <!-- Предиктори ризику -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-heart-pulse text-red-500"></i>
                    Гострі Предиктори Ризику
                </h2>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                            <span class="text-slate-300">Ампутація</span>
                            <div class="flex flex-col items-end">
                                <div>{!! $checkIcon($patient->predictors['amputation'] ?? false) !!}</div>
                                @if($patient->predictors['amputation'] ?? false)
                                    <span class="text-xs text-blue-400 mt-1">{{ $ampLevels[$patient->predictors['amputationLevel'] ?? ''] ?? '' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                            <span class="text-slate-300">Турнікет</span>
                            <div class="flex flex-col items-end">
                                <div>{!! $checkIcon($patient->predictors['tourniquet'] ?? false) !!}</div>
                                @if($patient->predictors['tourniquet'] ?? false)
                                    <span class="text-xs text-rose-400 mt-1">{{ $tourniquetDurations[$patient->predictors['tourniquetDuration'] ?? ''] ?? '' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                            <span class="text-slate-300">Ушкодження нерва</span>
                            <div class="flex flex-col items-end">
                                <div>{!! $checkIcon($patient->predictors['nerveInjury'] ?? false) !!}</div>
                                @if($patient->predictors['nerveInjury'] ?? false)
                                    <span class="text-xs text-amber-400 mt-1">{{ $nerveTypes[$patient->predictors['nerveType'] ?? ''] ?? '' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                            <span class="text-slate-300">Інфекція (рання)</span>
                            <div>{!! $checkIcon($patient->predictors['infection'] ?? false) !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-slate-700">
                        <div>
                            <span class="block text-xs text-slate-400 mb-1">Тип травми</span>
                            <div class="text-slate-200">{{ $traumaTypes[$patient->predictors['traumaType'] ?? ''] ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 mb-1">Кількість операцій</span>
                            <div class="text-slate-200">{{ $surgeriesCount[$patient->predictors['surgeries'] ?? ''] ?? '—' }}</div>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 mb-1">Гострий біль (NRS)</span>
                            <div class="text-xl font-bold {{ ($patient->predictors['acutePain'] ?? 0) >= 7 ? 'text-rose-500' : 'text-slate-200' }}">
                                {{ $patient->predictors['acutePain'] ?? '0' }} / 10
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ОЦІНКА ПРОТЕЗУВАННЯ -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-6 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-person-walking-with-cane text-purple-500"></i>
                    Дані протезування
                </h2>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-slate-700/30 p-4 rounded-xl border border-slate-600">
                            <span class="block text-xs text-slate-400 mb-1">Рівень ампутації</span>
                            <div class="font-medium text-slate-200">{{ $prostheticLevels[$patient->prosthetics_data['amputation_level'] ?? ''] ?? '—' }}</div>
                        </div>
                        <div class="bg-slate-700/30 p-4 rounded-xl border border-slate-600">
                            <span class="block text-xs text-slate-400 mb-1">Сторона</span>
                            <div class="font-medium text-slate-200">{{ $sidedness[$patient->prosthetics_data['sidedness'] ?? ''] ?? '—' }}</div>
                        </div>
                        <div class="bg-slate-700/30 p-4 rounded-xl border border-slate-600">
                            <span class="block text-xs text-slate-400 mb-1">Дата операції</span>
                            <div class="font-medium text-slate-200">{{ !empty($patient->prosthetics_data['surgery_date']) ? \Carbon\Carbon::parse($patient->prosthetics_data['surgery_date'])->format('d.m.Y') : '—' }}</div>
                        </div>
                    </div>

                    <div class="bg-slate-700/30 p-4 rounded-xl border border-slate-600">
                        <h3 class="text-sm font-medium text-slate-400 mb-3">Стан кукси та ускладнення</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <span class="block text-xs text-slate-500">Біль у куксі</span>
                                <div class="text-lg font-bold text-slate-200">{{ $patient->prosthetics_data['stump_pain'] ?? 0 }}/10</div>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500">Фантомний біль</span>
                                <div>{!! $checkIcon($patient->prosthetics_data['phantom_pain'] ?? false) !!}</div>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500">Рубцева болючість</span>
                                <div>{!! $checkIcon($patient->prosthetics_data['scar_tenderness'] ?? false) !!}</div>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500">Проблеми загоєння</span>
                                <div>{!! $checkIcon($patient->prosthetics_data['healing_issues'] ?? false) !!}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-700/30 p-4 rounded-xl border border-slate-600">
                        <h3 class="text-sm font-medium text-slate-400 mb-3">Функціональна оцінка протеза</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 border-b border-slate-600 pb-4">
                            <div>
                                <span class="block text-xs text-slate-500">Тип протеза</span>
                                <div class="font-medium text-slate-200">{{ $prosthesisTypes[$patient->prosthetics_data['type'] ?? ''] ?? '—' }}</div>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500">Використання</span>
                                <div class="font-medium text-slate-200">{{ $patient->prosthetics_data['hours_per_day'] ?? 0 }} год/день</div>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500">Біль при ходьбі</span>
                                <div class="font-medium text-slate-200">{{ $patient->prosthetics_data['pain_during_use'] ?? 0 }}/10</div>
                            </div>
                            <div>
                                <span class="block text-xs text-slate-500">Задоволеність</span>
                                <div class="font-medium text-purple-400">{{ $patient->prosthetics_data['functional']['satisfaction'] ?? 0 }}/10</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="flex items-center justify-between bg-slate-800 p-2 rounded">
                                <span class="text-sm text-slate-300">Самостійна ходьба</span>
                                <div>{!! $checkIcon($patient->prosthetics_data['functional']['independent_walking'] ?? false) !!}</div>
                            </div>
                            <div class="flex items-center justify-between bg-slate-800 p-2 rounded">
                                <span class="text-sm text-slate-300">Дистанція > 100 м</span>
                                <div>{!! $checkIcon($patient->prosthetics_data['functional']['distance_100m'] ?? false) !!}</div>
                            </div>
                            <div class="flex items-center justify-between bg-slate-800 p-2 rounded">
                                <span class="text-sm text-slate-300">Повернення до роботи</span>
                                <div>{!! $checkIcon($patient->prosthetics_data['functional']['return_to_work'] ?? false) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 6. Фактори інфекції -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-virus text-emerald-500"></i>
                    6. Фактори інфекції
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Відкрита рана</span>
                        <div>{!! $checkIcon($patient->infection_factors['openWound'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Забруднення рани</span>
                        <div>{!! $checkIcon($patient->infection_factors['woundContamination'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Відкритий перелом</span>
                        <div>{!! $checkIcon($patient->infection_factors['openFracture'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">NPWT</span>
                        <div>{!! $checkIcon($patient->infection_factors['npwt'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Позитивний посів</span>
                        <div>{!! $checkIcon($patient->infection_factors['positiveCulture'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">MDRO (Резистентність)</span>
                        <div>{!! $checkIcon($patient->infection_factors['mdro'] ?? false) !!}</div>
                    </div>
                </div>
            </section>

            <!-- 7. Хірургічна складність -->
            <section class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2 text-slate-100">
                    <i class="fa-solid fa-scalpel text-amber-500"></i>
                    7. Хірургічна складність
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Повторний дебридмент</span>
                        <div>{!! $checkIcon($patient->surgical_factors['repeatedDebridement'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Некроз тканин</span>
                        <div>{!! $checkIcon($patient->surgical_factors['tissueNecrosis'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Розходження рани</span>
                        <div>{!! $checkIcon($patient->surgical_factors['woundDehiscence'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Остеомієліт</span>
                        <div>{!! $checkIcon($patient->surgical_factors['osteomyelitis'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Судинне ушкодження</span>
                        <div>{!! $checkIcon($patient->surgical_factors['vascularInjury'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Flap/Реконструкція</span>
                        <div>{!! $checkIcon($patient->surgical_factors['flapReconstruction'] ?? false) !!}</div>
                    </div>
                    <div class="flex items-center justify-between bg-slate-700/40 p-3 rounded-xl">
                        <span class="text-slate-300">Повторна госпіталізація</span>
                        <div>{!! $checkIcon($patient->surgical_factors['readmission'] ?? false) !!}</div>
                    </div>
                </div>
            </section>

        </div>

        <!-- САЙДБАР З БАЛАМИ -->
        <div class="lg:col-span-1">
            <div class="sticky top-8 space-y-6">

                <div class="bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-700">
                    <h3 class="text-lg font-bold text-slate-100 mb-4 border-b border-slate-700 pb-2">Результати Прогнозу</h3>

                    @php
                        // Логіка підрахунку кольорів для Реабілітації
                        $rehabScore = $patient->scores['rehabScore'] ?? 0;
                        if($rehabScore >= 8) { $rLvl = 'Високий'; $rBg = 'bg-rose-900/30'; $rBorder = 'border-rose-700/50'; $rText = 'text-rose-400'; $rDesc = 'Мультидисциплінарна команда, психоскринінг.';}
                        elseif($rehabScore >= 4) { $rLvl = 'Середній'; $rBg = 'bg-amber-900/30'; $rBorder = 'border-amber-700/50'; $rText = 'text-amber-400'; $rDesc = 'Стандарт + контроль ускладнень.';}
                        else { $rLvl = 'Низький'; $rBg = 'bg-emerald-900/30'; $rBorder = 'border-emerald-700/50'; $rText = 'text-emerald-400'; $rDesc = 'Базова траєкторія відновлення.';}

                        // Логіка підрахунку кольорів для Болю
                        $painScore = $patient->scores['painScore'] ?? 0;
                        if($painScore >= 8) { $pLvl = 'Високий'; $pBg = 'bg-rose-900/30'; $pBorder = 'border-rose-700/50'; $pText = 'text-rose-400'; $pDesc = 'Спеціалізований pain-pathway маршрут.';}
                        elseif($painScore >= 4) { $pLvl = 'Середній'; $pBg = 'bg-amber-900/30'; $pBorder = 'border-amber-700/50'; $pText = 'text-amber-400'; $pDesc = 'Підвищена увага до знеболення.';}
                        else { $pLvl = 'Низький'; $pBg = 'bg-emerald-900/30'; $pBorder = 'border-emerald-700/50'; $pText = 'text-emerald-400'; $pDesc = 'Стандартний контроль болю.';}

                        // Логіка підрахунку кольорів для Протезування
                        $prostScore = $patient->scores['prostheticScore'] ?? 0;
                        if($prostScore >= 4) { $prLvl = 'Високий'; $prBg = 'bg-purple-900/30'; $prBorder = 'border-purple-700/50'; $prText = 'text-purple-400'; $prDesc = 'Потрібна мультидисциплінарна корекція.';}
                        elseif($prostScore >= 2) { $prLvl = 'Середній'; $prBg = 'bg-amber-900/30'; $prBorder = 'border-amber-700/50'; $prText = 'text-amber-400'; $prDesc = 'Потребує додаткового контролю.';}
                        else { $prLvl = 'Низький'; $prBg = 'bg-emerald-900/30'; $prBorder = 'border-emerald-700/50'; $prText = 'text-emerald-400'; $prDesc = 'Оптимальний прогноз протезування.';}

                        // Логіка підрахунку кольорів для Інфекції
                        $infScore = $patient->scores['infectionScore'] ?? 0;
                        if($infScore >= 6) { $iLvl = 'Високий'; $iBg = 'bg-rose-900/30'; $iBorder = 'border-rose-700/50'; $iText = 'text-rose-400'; $iDesc = 'Високий ризик інфекції.';}
                        elseif($infScore >= 3) { $iLvl = 'Середній'; $iBg = 'bg-amber-900/30'; $iBorder = 'border-amber-700/50'; $iText = 'text-amber-400'; $iDesc = 'Середній ризик.';}
                        else { $iLvl = 'Низький'; $iBg = 'bg-emerald-900/30'; $iBorder = 'border-emerald-700/50'; $iText = 'text-emerald-400'; $iDesc = 'Мінімальний ризик.';}

                        // Логіка підрахунку кольорів для Хірургічної складності
                        $surgScore = $patient->scores['surgicalScore'] ?? 0;
                        if($surgScore >= 6) { $sLvl = 'Висока'; $sBg = 'bg-rose-900/30'; $sBorder = 'border-rose-700/50'; $sText = 'text-rose-400'; $sDesc = 'Висока хірургічна складність.';}
                        elseif($surgScore >= 3) { $sLvl = 'Середня'; $sBg = 'bg-amber-900/30'; $sBorder = 'border-amber-700/50'; $sText = 'text-amber-400'; $sDesc = 'Підвищена складність.';}
                        else { $sLvl = 'Низька'; $sBg = 'bg-emerald-900/30'; $sBorder = 'border-emerald-700/50'; $sText = 'text-emerald-400'; $sDesc = 'Базова складність.';}
                    @endphp

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ризик тривалої реабілітації</h4>
                        <div class="p-4 rounded-xl border-2 {{ $rBg }} {{ $rBorder }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-lg {{ $rText }}">{{ $rLvl }}</span>
                                <div class="flex items-center gap-1 {{ $rText }}">
                                    <span class="font-black text-2xl">{{ $rehabScore }}</span>
                                    <span class="text-[10px] font-bold uppercase opacity-80">балів</span>
                                </div>
                            </div>
                            <p class="text-[11px] opacity-90 mt-1 font-medium leading-tight {{ $rText }}">{{ $rDesc }}</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Ризик хронічного болю (CPRS)</h4>
                        <div class="p-4 rounded-xl border-2 {{ $pBg }} {{ $pBorder }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-lg {{ $pText }}">{{ $pLvl }}</span>
                                <div class="flex items-center gap-1 {{ $pText }}">
                                    <span class="font-black text-2xl">{{ $painScore }}</span>
                                    <span class="text-[10px] font-bold uppercase opacity-80">балів</span>
                                </div>
                            </div>
                            <p class="text-[11px] opacity-90 mt-1 font-medium leading-tight {{ $pText }}">{{ $pDesc }}</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-purple-400 uppercase tracking-wider mb-2">Ризик ускладнень протезування</h4>
                        <div class="p-4 rounded-xl border-2 {{ $prBg }} {{ $prBorder }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-lg {{ $prText }}">{{ $prLvl }}</span>
                                <div class="flex items-center gap-1 {{ $prText }}">
                                    <span class="font-black text-2xl">{{ $prostScore }}</span>
                                    <span class="text-[10px] font-bold uppercase opacity-80">балів</span>
                                </div>
                            </div>
                            <p class="text-[11px] opacity-90 mt-1 font-medium leading-tight {{ $prText }}">{{ $prDesc }}</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-2">Ризик інфекції</h4>
                        <div class="p-4 rounded-xl border-2 {{ $iBg }} {{ $iBorder }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-lg {{ $iText }}">{{ $iLvl }}</span>
                                <div class="flex items-center gap-1 {{ $iText }}">
                                    <span class="font-black text-2xl">{{ $infScore }}</span>
                                    <span class="text-[10px] font-bold uppercase opacity-80">балів</span>
                                </div>
                            </div>
                            <p class="text-[11px] opacity-90 mt-1 font-medium leading-tight {{ $iText }}">{{ $iDesc }}</p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h4 class="text-xs font-semibold text-amber-400 uppercase tracking-wider mb-2">Хірургічна складність</h4>
                        <div class="p-4 rounded-xl border-2 {{ $sBg }} {{ $sBorder }}">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-lg {{ $sText }}">{{ $sLvl }}</span>
                                <div class="flex items-center gap-1 {{ $sText }}">
                                    <span class="font-black text-2xl">{{ $surgScore }}</span>
                                    <span class="text-[10px] font-bold uppercase opacity-80">балів</span>
                                </div>
                            </div>
                            <p class="text-[11px] opacity-90 mt-1 font-medium leading-tight {{ $sText }}">{{ $sDesc }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
