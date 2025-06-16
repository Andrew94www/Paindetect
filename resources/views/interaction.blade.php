<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafetyAnalgeticUse - Клинический инструмент</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .transition-all { transition: all 0.2s ease-in-out; }
        .modal-enter { animation: fadeIn 0.3s ease-out forwards; }
        .modal-leave { animation: fadeOut 0.3s ease-in forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @keyframes fadeOut { from { opacity: 1; transform: scale(1); } to { opacity: 0; transform: scale(0.95); } }
        .modal-open { overflow: hidden; }
        #autocomplete-list { position: absolute; background: white; border: 1px solid #e2e8f0; border-radius: 0.5rem; z-index: 100; max-height: 200px; overflow-y: auto; width: 100%; }
        .autocomplete-item { padding: 0.75rem; cursor: pointer; }
        .autocomplete-item:hover { background-color: #f1f5f9; }
        .tag { display: inline-flex; align-items: center; background-color: #e2e8f0; color: #475569; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; }
        .tag-remove { margin-left: 0.5rem; cursor: pointer; color: #94a3b8; }
        .tag-remove:hover { color: #475569; }
        @media print {
            body * { visibility: hidden; }
            #modal-print-area, #modal-print-area * { visibility: visible; }
            #modal-print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="text-slate-800">

<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-5xl">

    <header class="text-center mb-8">
        <i class="ph-duotone ph-pill text-5xl text-blue-600 mb-2"></i>
        <h1 class="text-3xl md:text-4xl font-bold text-slate-900">SafetyAnalgeticUse</h1>
        <p class="text-md md:text-lg text-slate-500 mt-2">Клінічний інструмент перевірки лікарських взаємодій</p>
    </header>

    <!-- Основной инструмент проверки -->
    <div class="bg-white p-6 rounded-2xl shadow-lg mb-8">
        <h2 class="text-xl font-bold mb-4">Перевірка взаємодій</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Левая колонка: ввод препаратов -->
            <div class="relative">
                <label for="drug-input" class="block text-sm font-medium text-slate-700 mb-1">Додайте препарати пацієнта (МНН або торгова назва):</label>
                <div class="flex items-center gap-2">
                    <div class="relative w-full">
                        <input type="text" id="drug-input" placeholder="Напр., ібупрофен, ксарелто..." class="w-full p-3 pl-4 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <div id="autocomplete-list"></div>
                    </div>
                    <button id="add-drug-btn" class="p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-semibold">Додати</button>
                </div>
            </div>
            <!-- Правая колонка: список препаратов -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Список препаратів для перевірки:</label>
                <div id="selected-drugs-list" class="p-3 bg-slate-50 rounded-lg min-h-[52px] border flex flex-wrap gap-2 items-center">
                    <span id="placeholder-text" class="text-slate-400">Препарати не додано</span>
                </div>
            </div>
        </div>
        <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center">
                <input id="renal-checkbox" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="renal-checkbox" class="ml-2 block text-sm text-gray-900">Пацієнт з похилим віком / нирковою недостатністю</label>
            </div>
            <button id="clear-list-btn" class="w-full sm:w-auto px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-all">Очистити список</button>
        </div>
    </div>

    <!-- Результаты проверки -->
    <div id="results-container">
        <!-- Результаты будут вставлены сюда -->
    </div>

</div>

<div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4">
    <div id="modal-content" class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative">
        <div id="modal-print-area" class="p-6 sm:p-8">
            <!-- Содержимое для модального окна и печати -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Максимально расширенная база данных лекарств
        const drugDatabase = [
            // НПВС
            { id: 1, name: 'Ібупрофен', tradeNames: ['Нурофен', 'Імет'] },
            { id: 2, name: 'Кеторолак', tradeNames: ['Кетанов', 'Кетолонг'] },
            { id: 14, name: 'Диклофенак', tradeNames: ['Вольтарен', 'Наклофен', 'Олфен'] },
            { id: 15, name: 'Німесулід', tradeNames: ['Німесил', 'Аффида', 'Німід'] },
            { id: 16, name: 'Мелоксикам', tradeNames: ['Моваліс', 'Мелокс'] },
            { id: 17, name: 'Ацетилсаліцилова кислота', tradeNames: ['Аспірин', 'Кардіомагніл'] },
            // Анальгетики-антипиретики
            { id: 12, name: 'Парацетамол', tradeNames: ['Панадол', 'Ефералган'] },
            // Опиоидные анальгетики
            { id: 8, name: 'Трамадол', tradeNames: ['Трамал'] },
            { id: 10, name: 'Оксикодон', tradeNames: ['Оксиконтин'] },
            { id: 18, name: 'Фентаніл', tradeNames: ['Дюрогезик'] },
            { id: 19, name: 'Метадон', tradeNames: ['Метафін'] },
            { id: 20, name: 'Кодеїн', tradeNames: ['Кодтерпін (комб.)'] },
            // ГКС
            { id: 21, name: 'Преднізолон', tradeNames: ['Преднізолон'] },
            { id: 22, name: 'Дексаметазон', tradeNames: ['Дексаметазон'] },
            // Транквилизаторы (Бензодиазепины)
            { id: 11, name: 'Алпразолам', tradeNames: ['Ксанакс'] },
            { id: 23, name: 'Діазепам', tradeNames: ['Реланіум', 'Сибазон'] },
            { id: 24, name: 'Лоразепам', tradeNames: ['Ативан'] },
            // Антидепрессанты
            { id: 9, name: 'Флуоксетин', tradeNames: ['Прозак'] },
            { id: 25, name: 'Сертралін', tradeNames: ['Золофт', 'Стимулотон'] },
            { id: 26, name: 'Пароксетин', tradeNames: ['Паксил', 'Рексетин'] },
            { id: 27, name: 'Амітриптилін', tradeNames: ['Амітриптилін'] },
            // Антикоагулянты и антиагреганты
            { id: 3, name: 'Варфарин', tradeNames: ['Варфарин'] },
            { id: 4, name: 'Ривароксабан', tradeNames: ['Ксарелто'] },
            { id: 29, name: 'Клопідогрель', tradeNames: ['Плавікс', 'Тромбонет'] },
            // Гипотензивные
            { id: 5, name: 'Еналаприл', tradeNames: ['Енап', 'Берліприл'] },
            { id: 30, name: 'Метопролол', tradeNames: ['Беталок', 'Егілок'] },
            { id: 31, name: 'Амлодипін', tradeNames: ['Норваск', 'Амло'] },
            // Диуретики
            { id: 6, name: 'Фуросемід', tradeNames: ['Лазикс'] },
            // Антибиотики
            { id: 28, name: 'Кларитроміцин', tradeNames: ['Клацид', 'Фромілід'] },
            { id: 32, name: 'Еритроміцин', tradeNames: ['Еритроміцин'] },
            // Противогрибковые
            { id: 33, name: 'Флуконазол', tradeNames: ['Дифлюкан', 'Мікосист'] },
            // Противосудорожные
            { id: 34, name: 'Карбамазепін', tradeNames: ['Фінлепсин', 'Тегретол'] },
            // Статины
            { id: 35, name: 'Симвастатин', tradeNames: ['Зокор', 'Вазиліп'] },
            // Прочие
            { id: 7, name: 'Метотрексат', tradeNames: ['Метотрексат'] },
            { id: 13, name: 'Алкоголь', tradeNames: [] },
        ];

        // Максимально расширенная база данных взаимодействий
        const interactionsDB = [
            // НПВС + ...
            { pair: [1, 3], risk: 'Високий', color: 'orange', mechanism: 'НПЗЗ інгібують ЦОГ-1 в тромбоцитах, порушуючи їх агрегацію, що синергічно посилює антикоагулянтний ефект варфарину.', recommendation: 'Уникати комбінації. Використовувати ІПП. Моніторинг МНВ.', alternatives: ['Парацетамол'], dosage: 'Не застосовувати разом.', source: 'drugs.com' },
            { pair: [14, 3], risk: 'Високий', color: 'orange', mechanism: 'Диклофенак, як і інші НПЗЗ, пригнічує агрегацію тромбоцитів, значно підвищуючи ризик кровотеч у пацієнтів, що приймають варфарин.', recommendation: 'Комбінація не рекомендована. Ретельний моніторинг МНВ.', alternatives: ['Парацетамол'], dosage: 'Не застосовувати разом.', source: 'drugs.com' },
            { pair: [1, 4], risk: 'Високий', color: 'orange', mechanism: 'НПЗЗ порушують агрегацію тромбоцитів, що створює додатковий ризик кровотечі на фоні прямого інгібування фактора Xa ривароксабаном.', recommendation: 'Уникати комбінації. Моніторинг симптомів кровотечі.', alternatives: ['Парацетамол'], dosage: 'Не застосовувати разом.', source: 'drugs.com' },
            { pair: [1, 29], risk: 'Високий', color: 'orange', mechanism: 'Синергічний антитромбоцитарний ефект. НПЗЗ інгібують ЦОГ-1, а клопідогрель - P2Y12 рецептори. Комбінація значно підвищує ризик великих кровотеч.', recommendation: 'Комбінація тільки за життєвими показаннями (напр. після стентування). Обов\'язково з ІПП.', alternatives: ['Парацетамол + Клопідогрель'], dosage: 'Використовувати з максимальною обережністю.', source: 'medscape.com' },
            { pair: [1, 5], risk: 'Критичний', color: 'red', condition: 'renal', mechanism: 'НПЗЗ блокують синтез ниркових простагландинів (вазодилатація), ІАПФ знижують тиск у виносній артеріолі. Комбінація різко знижує ШКФ і може призвести до гострого пошкодження нирок.', recommendation: 'Комбінація небезпечна. Моніторинг креатиніну.', alternatives: ['Парацетамол'], dosage: 'Потребує корекції дози обох препаратів.', source: 'medscape.com' },
            { pair: [1, 6], risk: 'Критичний', color: 'red', condition: 'renal', mechanism: 'НПЗЗ знижують синтез простагландинів, які опосередковують діуретичний ефект фуросеміду, що призводить до його ослаблення та затримки рідини.', recommendation: 'Уникати. Контроль функції нирок.', alternatives: ['Парацетамол'], dosage: 'Зменшити дозу НПЗЗ.', source: 'medscape.com' },
            { pair: [1, 21], risk: 'Високий', color: 'orange', mechanism: 'Синергічний ульцерогенний ефект на слизову оболонку ШКТ. Обидва класи препаратів знижують її захисні властивості.', recommendation: 'Комбінація тільки за абсолютними показаннями. Обов\'язкове прикриття ІПП.', alternatives: ['Парацетамол'], dosage: 'Мінімально ефективні дози обох препаратів.', source: 'drugs.com' },
            { pair: [14, 25], risk: 'Високий', color: 'orange', mechanism: 'СІЗЗС (Сертралін) можуть порушувати функцію тромбоцитів. У поєднанні з НПЗЗ ризик шлунково-кишкових кровотеч значно зростає.', recommendation: 'За можливості уникати. Розглянути додавання ІПП.', alternatives: ['Парацетамол + ТЦА (Амітриптилін)'], dosage: 'Ретельний моніторинг.', source: 'pubmed.ncbi.nlm.nih.gov' },
            // Опиоиды + ...
            { pair: [8, 9], risk: 'Критичний', color: 'red', mechanism: 'Обидва препарати підвищують рівень серотоніну (трамадол - інгібітор зворотного захоплення, флуоксетин - СІЗЗС). Комбінація може призвести до летального серотонінового синдрому.', recommendation: 'Комбінація протипоказана.', alternatives: ['НПЗЗ', 'Парацетамол'], dosage: 'Не застосовувати разом.', source: 'pubmed.ncbi.nlm.nih.gov' },
            { pair: [10, 11], risk: 'Критичний', color: 'red', mechanism: 'Опіоїди та бензодіазепіни - депресанти ЦНС. Синергічно пригнічують дихальний центр (μ-опіоїдні та ГАМК-А рецептори), що може призвести до коми та смерті.', recommendation: 'FDA Black Box Warning. Уникати.', alternatives: ['Нефармакологічні методи'], dosage: 'Тільки в умовах стаціонару.', source: 'fda.gov' },
            { pair: [20, 9], risk: 'Високий', color: 'orange', mechanism: 'Флуоксетин є потужним інгібітором CYP2D6, який перетворює кодеїн в активний метаболіт - морфін. Блокування цього шляху призводить до відсутності анальгетичного ефекту.', recommendation: 'Комбінація неефективна. Уникати.', alternatives: ['Інші опіоїди (напр., морфін), НПЗЗ'], dosage: 'Заміна кодеїну.', source: 'drugs.com' },
            { pair: [19, 28], risk: 'Критичний', color: 'red', mechanism: 'Кларитроміцин - потужний інгібітор CYP3A4, що метаболізує метадон. Інгібування призводить до підвищення концентрації метадону, подовження QT та ризику аритмії Torsades de Pointes.', recommendation: 'Комбінація протипоказана.', alternatives: ['Азитроміцин'], dosage: 'Не застосовувати разом.', source: 'medscape.com' },
            { pair: [18, 33], risk: 'Критичний', color: 'red', mechanism: 'Флуконазол - потужний інгібітор CYP3A4, що є основним шляхом метаболізму фентанілу. Комбінація може призвести до непередбачуваного і значного підвищення концентрації фентанілу, пригнічення дихання та смерті.', recommendation: 'Комбінація протипоказана.', alternatives: ['Опіоїди з іншим метаболізмом (напр., морфін)'], dosage: 'Не застосовувати разом.', source: 'fda.gov' },
            { pair: [8, 27], risk: 'Високий', color: 'orange', mechanism: 'Синергічний седативний ефект. Обидва препарати знижують судомний поріг. Посилення антихолінергічних ефектів.', recommendation: 'Застосовувати з великою обережністю.', alternatives: ['НПЗЗ + СІЗЗС (з обережністю)'], dosage: 'Потребує зниження доз обох препаратів.', source: 'drugs.com' },
            // Другие важные взаимодействия
            { pair: [12, 13], risk: 'Високий', color: 'orange', mechanism: 'Хронічне вживання алкоголю індукує CYP2E1, що прискорює утворення токсичного метаболіту парацетамолу (NAPQI), викликаючи некроз печінки.', recommendation: 'Обмежити дозу парацетамолу до 2 г/добу.', alternatives: ['Ібупрофен'], dosage: 'Максимум 2г парацетамолу на добу.', source: 'drugs.com' },
            { pair: [35, 32], risk: 'Високий', color: 'orange', mechanism: 'Еритроміцин інгібує CYP3A4, що значно підвищує концентрацію симвастатину. Це створює високий ризик розвитку міопатії та рабдоміолізу.', recommendation: 'Тимчасово відмінити статин на час прийому антибіотика.', alternatives: ['Правастатин (не метаболізується CYP3A4)'], dosage: 'Не застосовувати разом.', source: 'drugs.com' },
            { pair: [3, 28], risk: 'Високий', color: 'orange', mechanism: 'Кларитроміцин інгібує CYP3A4, сповільнюючи метаболізм варфарину та підвищуючи його концентрацію, що призводить до значного ризику кровотеч.', recommendation: 'Потрібний ретельний моніторинг МНВ та корекція дози варфарину.', alternatives: ['Азитроміцин'], dosage: 'Зменшити дозу варфарину.', source: 'medscape.com' },
        ];

        // --- Остальной код ---
        const riskStyles = {
            'red':    { bg: 'bg-red-50', border: 'border-red-500', text: 'text-red-700', icon: 'ph-skull' },
            'orange': { bg: 'bg-orange-50', border: 'border-orange-500', text: 'text-orange-700', icon: 'ph-warning-octagon' },
        };
        const drugInput = document.getElementById('drug-input');
        const addDrugBtn = document.getElementById('add-drug-btn');
        const selectedDrugsList = document.getElementById('selected-drugs-list');
        const placeholderText = document.getElementById('placeholder-text');
        const resultsContainer = document.getElementById('results-container');
        const renalCheckbox = document.getElementById('renal-checkbox');
        const clearListBtn = document.getElementById('clear-list-btn');
        const autocompleteList = document.getElementById('autocomplete-list');
        const modal = document.getElementById('modal');
        const modalPrintArea = document.getElementById('modal-print-area');

        let selectedDrugs = [];

        function findDrugByName(name) {
            const searchTerm = name.toLowerCase();
            return drugDatabase.find(d => d.name.toLowerCase() === searchTerm || d.tradeNames.map(tn => tn.toLowerCase()).includes(searchTerm));
        }

        function renderSelectedDrugs() {
            selectedDrugsList.innerHTML = '';
            if (selectedDrugs.length === 0) {
                selectedDrugsList.appendChild(placeholderText);
            } else {
                selectedDrugs.forEach(drug => {
                    const tag = document.createElement('div');
                    tag.className = 'tag';
                    tag.innerHTML = `<span>${drug.name}</span><i class="ph ph-x tag-remove" data-id="${drug.id}"></i>`;
                    selectedDrugsList.appendChild(tag);
                });
            }
            checkInteractions();
        }

        function addDrug() {
            const drugName = drugInput.value.trim();
            if (drugName) {
                const drug = findDrugByName(drugName);
                if (drug && !selectedDrugs.some(d => d.id === drug.id)) {
                    selectedDrugs.push(drug);
                    renderSelectedDrugs();
                }
                drugInput.value = '';
                autocompleteList.innerHTML = '';
            }
        }

        function checkInteractions() {
            resultsContainer.innerHTML = '';
            let interactionsFound = [];

            for (let i = 0; i < selectedDrugs.length; i++) {
                for (let j = i + 1; j < selectedDrugs.length; j++) {
                    const drug1Id = selectedDrugs[i].id;
                    const drug2Id = selectedDrugs[j].id;

                    const interaction = interactionsDB.find(inter =>
                        (inter.pair.includes(drug1Id) && inter.pair.includes(drug2Id))
                    );

                    if (interaction) {
                        interactionsFound.push({
                            ...interaction,
                            drug1: selectedDrugs[i],
                            drug2: selectedDrugs[j]
                        });
                    }
                }
            }

            if (interactionsFound.length > 0) {
                const isRenal = renalCheckbox.checked;
                interactionsFound.sort((a,b) => {
                    const aScore = a.risk === 'Критичний' ? 3 : 2;
                    const bScore = b.risk === 'Критичний' ? 3 : 2;
                    return bScore - aScore;
                });

                let resultsHTML = '<h2 class="text-xl font-bold mb-4">Знайдені взаємодії:</h2>';
                interactionsFound.forEach(inter => {
                    const style = riskStyles[inter.color] || riskStyles['orange'];
                    let specialWarning = '';
                    if (isRenal && inter.condition === 'renal') {
                        specialWarning = `<div class="mt-2 p-2 bg-yellow-100 text-yellow-800 text-sm rounded-lg flex items-center gap-2">
                            <i class="ph-bold ph-warning"></i>
                            <span>Особлива увага! Підвищений ризик у пацієнтів з нирковою недостатністю.</span>
                         </div>`;
                    }
                    resultsHTML += `
                        <div class="mb-4 p-4 rounded-lg border-l-4 ${style.border} ${style.bg} cursor-pointer hover:shadow-md" data-interaction='${JSON.stringify(inter)}'>
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-lg ${style.text}">${inter.drug1.name} + ${inter.drug2.name}</p>
                                    <p class="text-slate-600 truncate">${inter.mechanism}</p>
                                    ${specialWarning}
                                </div>
                                <span class="text-sm font-semibold ${style.text} whitespace-nowrap px-3 py-1 ${style.bg} rounded-full border ${style.border}">${inter.risk} ризик</span>
                            </div>
                        </div>
                    `;
                });
                resultsContainer.innerHTML = resultsHTML;

                document.querySelectorAll('[data-interaction]').forEach(el => {
                    el.addEventListener('click', () => {
                        showModal(JSON.parse(el.dataset.interaction));
                    });
                });

            } else if (selectedDrugs.length > 1) {
                resultsContainer.innerHTML = `<div class="p-4 bg-green-50 text-green-800 rounded-lg border-l-4 border-green-500">Критичних взаємодій між обраними препаратами не знайдено.</div>`
            }
        }

        function showModal(inter) {
            const style = riskStyles[inter.color];
            const sourceUrl = `https://${inter.source}`;
            modalPrintArea.innerHTML = `
                <div class="no-print flex justify-between items-center">
                    <button id="print-button" class="px-3 py-1 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 flex items-center gap-2"><i class="ph ph-printer"></i>Друк</button>
                    <button id="closeModal" class="text-slate-400 hover:text-slate-700"><i class="ph-bold ph-x text-2xl"></i></button>
                </div>
                <div class="mt-4 flex items-start gap-4 pb-4 border-b ${style.border}">
                     <i class="ph-duotone ${style.icon} ${style.text} text-4xl"></i>
                     <div>
                        <span class="text-sm font-medium ${style.text}">${inter.risk} ризик</span>
                        <h3 class="text-2xl font-bold text-slate-900">${inter.drug1.name} + ${inter.drug2.name}</h3>
                     </div>
                </div>
                <div class="mt-4 space-y-5">
                    <div><h4 class="font-semibold">Механізм взаємодії:</h4><p class="text-slate-600">${inter.mechanism}</p></div>
                    <div><h4 class="font-semibold">Клінічні рекомендації:</h4><p class="text-slate-600">${inter.recommendation}</p></div>
                    <div><h4 class="font-semibold text-blue-800">Корекція дози:</h4><p class="p-2 bg-blue-50 rounded-md text-blue-900">${inter.dosage}</p></div>
                    <div><h4 class="font-semibold text-green-800">Безпечніші альтернативи:</h4><p class="text-slate-600">${inter.alternatives.join(', ')}</p></div>
                </div>
                <div class="mt-6 pt-4 border-t text-xs text-slate-500 no-print">
                    Джерело: <a href="${sourceUrl}" target="_blank" class="text-blue-600 hover:underline">${inter.source}</a>
                </div>
            `;
            modal.classList.remove('hidden');
            modal.querySelector('#modal-content').classList.add('modal-enter');
            document.body.classList.add('modal-open');
            document.getElementById('closeModal').addEventListener('click', hideModal);
            document.getElementById('print-button').addEventListener('click', () => window.print());
        }

        function hideModal() {
            const modalContentDiv = modal.querySelector('#modal-content');
            modalContentDiv.classList.remove('modal-enter');
            modalContentDiv.classList.add('modal-leave');
            setTimeout(() => { modal.classList.add('hidden'); document.body.classList.remove('modal-open'); modalContentDiv.classList.remove('modal-leave'); }, 300);
        }

        function handleAutocomplete(e) {
            const term = e.target.value.toLowerCase();
            autocompleteList.innerHTML = '';
            if (term.length < 2) return;

            const matches = drugDatabase.filter(d => d.name.toLowerCase().includes(term) || d.tradeNames.some(tn => tn.toLowerCase().includes(term)));
            matches.slice(0, 5).forEach(drug => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = drug.name;
                item.addEventListener('click', () => {
                    drugInput.value = drug.name;
                    autocompleteList.innerHTML = '';
                    addDrug();
                });
                autocompleteList.appendChild(item);
            });
        }

        addDrugBtn.addEventListener('click', addDrug);
        drugInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') addDrug() });
        drugInput.addEventListener('input', handleAutocomplete);
        renalCheckbox.addEventListener('change', checkInteractions);
        clearListBtn.addEventListener('click', () => { selectedDrugs = []; renderSelectedDrugs(); });
        selectedDrugsList.addEventListener('click', (e) => {
            if (e.target.classList.contains('tag-remove')) {
                const drugId = parseInt(e.target.dataset.id);
                selectedDrugs = selectedDrugs.filter(d => d.id !== drugId);
                renderSelectedDrugs();
            }
        });
        modal.addEventListener('click', (e) => { if (e.target === modal) hideModal(); });

    });
</script>
</body>
</html>
