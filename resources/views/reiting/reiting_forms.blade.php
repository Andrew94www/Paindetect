<!DOCTYPE html>
<html lang="uk" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Повна Рейтингова Система Оцінки НПП</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#1a1b1e',
                            surface: '#25262b',
                            border: '#2c2e33',
                            text: '#c1c2c5',
                            textLight: '#e9ecef',
                            primary: '#339af0',
                            primaryHover: '#228be6',
                            danger: '#fa5252',
                            success: '#40c057'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1b1e; }
        ::-webkit-scrollbar-thumb { background: #2c2e33; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #373a40; }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        /* Sticky header for tables */
        .sticky-header { position: sticky; top: 0; z-index: 10; background-color: #25262b; }

        /* Tooltip styles */
        .tooltip-container:hover .tooltip-text { opacity: 1; visibility: visible; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-dark-bg text-dark-text min-h-screen font-sans antialiased flex flex-col relative">

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-24 right-5 z-[60] flex flex-col gap-3 pointer-events-none">
    <!-- Toasts will be injected here by JS -->
</div>

<!-- Navbar -->
<nav class="bg-dark-surface border-b border-dark-border sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <i class="fa-solid fa-chart-line text-dark-primary text-2xl mr-3"></i>
                <div>
                    <span class="font-bold text-xl text-dark-textLight block leading-none">ВНМУ Рейтинг</span>
                    <span class="text-xs text-gray-500">Система оцінки ефективності</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm text-dark-textLight font-medium">Адміністратор</div>
                    <div class="text-xs text-gray-500">admin@vnmu.edu.ua</div>
                </div>
                <div class="h-9 w-9 rounded-lg bg-dark-primary flex items-center justify-center text-white font-bold shadow-lg shadow-blue-900/20">A</div>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="flex-grow max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 w-full">

    <!-- Header & Controls -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-dark-textLight">Розрахунок рейтингу</h1>
            <p class="text-gray-400 mt-1">Заповніть форму згідно з Положенням про рейтингову систему.</p>
        </div>
        <!-- Action Buttons Group -->
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('departments.list', ['code' => $code]) }}" class="bg-dark-surface border border-dark-border hover:bg-gray-800 text-dark-textLight px-5 py-2.5 rounded-lg font-medium transition-all transform hover:scale-105 active:scale-95 flex items-center shadow-sm">
                <i class="fa-solid fa-list-ul mr-2 text-dark-primary"></i> Показати список
            </a>
            <button onclick="toggleForm()" class="bg-dark-primary hover:bg-dark-primaryHover text-white px-5 py-2.5 rounded-lg shadow-lg shadow-blue-900/20 font-medium transition-all transform hover:scale-105 active:scale-95 flex items-center">
                <i class="fa-solid fa-plus mr-2"></i> Новий розрахунок
            </button>
        </div>

    </div>

    <!-- Empty State (Visible by default) -->
    <div id="emptyState" class="text-center py-24 bg-dark-surface rounded-xl border border-dark-border border-dashed">
        <div class="bg-dark-bg w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border border-dark-border">
            <i class="fa-solid fa-file-invoice text-3xl text-gray-600"></i>
        </div>
        <h3 class="text-lg font-medium text-dark-textLight">Форма прихована</h3>
        <p class="text-gray-500 mt-1">Натисніть кнопку вище, щоб відкрити анкету.</p>
    </div>

    <!-- Dynamic Form Container (Hidden by default) -->
    <div id="ratingFormContainer" class="animate-fade-in hidden">
        <form id="ratingForm" class="space-y-6">

            <!-- 0. Personal Info -->
            <div class="bg-dark-surface rounded-xl shadow-sm border border-dark-border overflow-hidden">
                <div class="px-6 py-4 border-b border-dark-border bg-gray-800/30">
                    <h3 class="text-lg font-medium text-dark-textLight"><i class="fa-regular fa-id-card mr-2 text-dark-primary"></i>Особисті дані</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">ПІБ Викладача</label>
                        <input type="text" name="personal[name]" class="w-full bg-dark-bg border border-dark-border rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-dark-primary focus:border-transparent outline-none transition-all" required autocomplete="off">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Посада</label>
                        <select name="personal[position]" class="w-full bg-dark-bg border border-dark-border rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-dark-primary outline-none">
                            <option>Асистент</option>
                            <option>Викладач</option>
                            <option>Старший викладач</option>
                            <option>Доцент</option>
                            <option>Професор</option>
                            <option>Завідувач кафедри</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Навчальний рік</label>
                        <select name="personal[year]" class="w-full bg-dark-bg border border-dark-border rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-dark-primary outline-none">
                            <option>2024-2025</option>
                            <option>2025-2026</option>
                            <option>2026-2027</option>
                        </select>
                    </div>
                    <div class="hidden">
                        <input name="code" type="hidden" value="{{$code}}">
                    </div>
                </div>
            </div>

            <!-- Sections Container (Populated by JS) -->
            <div id="sections-wrapper" class="space-y-6"></div>

            <!-- Sticky Footer -->
            <div class="sticky bottom-4 z-40">
                <div class="bg-dark-surface/90 backdrop-blur-md border border-dark-border rounded-xl shadow-2xl p-4 flex flex-col sm:flex-row justify-between items-center gap-4 mx-auto max-w-7xl">
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <div class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Загальна сума</div>
                            <div class="text-3xl font-bold text-dark-primary leading-none" id="grandTotal">0.0</div>
                        </div>
                    </div>
                    <div class="flex gap-3 w-full sm:w-auto">
                        <button type="button" onclick="document.getElementById('ratingForm').reset(); calculateAll();" class="flex-1 sm:flex-none px-6 py-3 border border-dark-border hover:bg-gray-800 text-gray-300 rounded-lg transition-colors">
                            Очистити
                        </button>
                        <button type="submit" id="submitBtn" class="flex-1 sm:flex-none px-8 py-3 bg-dark-success hover:bg-green-600 text-white font-bold rounded-lg shadow-lg shadow-green-900/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center">
                            <span>Зберегти звіт</span> <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</main>

<!-- JavaScript Configuration & Logic -->
<script>
    // Data Configuration
    const ratingData = [
        {
            id: 'sec1',
            title: '1. Навчально-методична робота',
            icon: 'fa-book-open',
            items: [
                { id: '1_1', text: 'Підручник (англ. мова, рек. Вченої ради)', points: 150, type: 'shared' },
                { id: '1_2', text: 'Підручник (рек. Вченої ради)', points: 100, type: 'shared' },
                { id: '1_3', text: 'Навчальний посібник (рек. Вченої ради)', points: 70, type: 'shared' },
                { id: '1_4', text: 'Конспект лекцій', points: 50, type: 'shared' },
                { id: '1_5', text: 'Збірник методичних матеріалів (ЦМК)', points: 20, type: 'shared' },
                { id: '1_6', text: 'Розробка освітніх програм (за кожну)', points: 50, type: 'shared' },
                { id: '1_7', text: 'Акредитація ОП (на групу)', points: 100, type: 'manual_shared', note: 'Розподіляється колективом' },
                { id: '1_8', text: 'Комплекс олімпіадних завдань', points: 20, type: 'manual_shared' },
                { id: '1_9', text: 'Розміщення в репозитарії', points: 2, type: 'simple' },
                { id: '1_10', text: 'Міжнародне стажування (тижнів)', points: 5, type: 'simple' },
                { id: '1_11', text: 'Розробка університетського положення', points: 20, type: 'manual_shared' },
                { id: '1_12', text: 'Розробка робочої програми (ТУ, ПАЦ)', points: 10, type: 'manual_shared' },
                { id: '1_13_1', text: 'Лекції (зарубіжні ЗВО)', points: 5, type: 'simple' },
                { id: '1_13_2', text: 'Лекції (українські ЗВО)', points: 2, type: 'simple' },
                { id: '1_14', text: 'Тестові завдання (прийняті ЦТ)', points: 1, type: 'simple' },
                { id: '1_15', text: 'Кращий викладач (анкетування)', points: 10, type: 'fixed' },
                { id: '1_16', text: 'Заходи студ. самоврядування', points: 2, type: 'simple' },
            ]
        },
        {
            id: 'sec2',
            title: '2. Науково-інноваційна діяльність',
            icon: 'fa-atom',
            items: [
                { id: '2_1', text: 'Монографія закордонна (ОЕСР/ЄС)', points: 75, type: 'shared' },
                { id: '2_2', text: 'Монографія українська', points: 50, type: 'shared' },
                { id: '2_3_1', text: 'Стаття Scopus/WoS (Q1)', points: 50, type: 'shared' },
                { id: '2_3_2', text: 'Стаття Scopus/WoS (Q2)', points: 45, type: 'shared' },
                { id: '2_3_3', text: 'Стаття Scopus/WoS (Q3)', points: 35, type: 'shared' },
                { id: '2_3_4', text: 'Стаття Scopus/WoS (Q4)', points: 25, type: 'shared' },
                { id: '2_4', text: 'Стаття фахова (категорія Б, індекс)', points: 25, type: 'shared' },
                { id: '2_5', text: 'Науково-популярна / консультаційна', points: 15, type: 'shared' },
                { id: '2_6', text: 'Стаття фахова (ЄС, ОЕСР)', points: 30, type: 'shared' },
                { id: '2_7', text: 'Стаття у виданнях ВНМУ', points: 30, type: 'shared' },
                { id: '2_8', text: 'Тези закордонні', points: 25, type: 'shared' },
                { id: '2_9', text: 'Тези українські', points: 10, type: 'shared' },
                {
                    id: '2_10', text: 'Індекс Гірша (Scopus)', type: 'select',
                    options: [
                        {label: '0', val: 0}, {label: '1-3', val: 15}, {label: '4-6', val: 18},
                        {label: '7-8', val: 22}, {label: '9-10', val: 25}, {label: '11-15', val: 28},
                        {label: '16-19', val: 30}, {label: '>20', val: 35}
                    ]
                },
                {
                    id: '2_11', text: 'Індекс Гірша (Google Scholar)', type: 'select',
                    options: [
                        {label: '0-5', val: 0}, {label: '1-5 (помилка в док?)', val: 5}, {label: '6-8', val: 8},
                        {label: '9-11', val: 12}, {label: '12-15', val: 15}, {label: '16-20', val: 18},
                        {label: '21-30', val: 20}, {label: '>30', val: 25}
                    ]
                },
                { id: '2_12_1', text: 'Конференції (закордонні)', points: 5, type: 'simple' },
                { id: '2_12_2', text: 'Конференції (міжнародні)', points: 4, type: 'simple' },
                { id: '2_12_3', text: 'Конференції (всеукраїнські)', points: 3, type: 'simple' },
                { id: '2_12_4', text: 'Конференції (університетські)', points: 2, type: 'simple' },
                { id: '2_13_1', text: 'Доповідь усна (закордонна)', points: 20, type: 'shared' },
                { id: '2_13_2', text: 'Доповідь стендова (закордонна)', points: 10, type: 'shared' },
                { id: '2_14_1', text: 'Рецензування (Impact Factor)', points: 5, type: 'simple' },
                { id: '2_14_2', text: 'Рецензування (Фахові UA)', points: 3, type: 'simple' },
                { id: '2_15', text: 'Участь у міжнар. проєктах/дослідженнях', points: 10, type: 'simple' },
                { id: '2_16', text: 'Держбюджетна НДР (на групу)', points: 60, type: 'shared_pool', note: 'Ділиться на учасників' },
                { id: '2_17', text: 'Ініціативна НДР (на групу)', points: 20, type: 'shared_pool' },
                { id: '2_18', text: 'Поданий проєкт (МОН, НФДУ)', points: 5, type: 'simple' },
                { id: '2_19_1', text: 'Грант на науковий проект', points: 50, type: 'simple' },
                { id: '2_19_2', text: 'Грант на стажування', points: 50, type: 'simple' },
                { id: '2_19_3', text: 'Грант на поїздки', points: 10, type: 'simple' },
                { id: '2_19_4', text: 'Грант на публікацію', points: 5, type: 'simple' },
                { id: '2_20', text: 'Атестація лабораторії (макс 10)', points: 1, type: 'manual' },
                { id: '2_21', text: 'Студент-переможець наук. робіт (Міжн/Всеукр/Унів)', type: 'manual', note: 'Введіть суму балів (15/10/5)' },
                { id: '2_22', text: 'Екзаменатор студ. робіт (держ. рівень)', points: 5, type: 'simple' },
                { id: '2_24', text: 'Суддя спорт. змагань (макс 20)', points: 1, type: 'manual', note: 'Не більше 20 балів сумарно' },
                { id: '2_27', text: 'Міжнародний патент', points: 30, type: 'shared' },
                { id: '2_28', text: 'Впровадження у виробництво', points: 15, type: 'shared' },
                { id: '2_29_1', text: 'Патент UA (промисловий)', points: 20, type: 'shared' },
                { id: '2_29_2', text: 'Патент UA (винахід/свідоцтво)', points: 10, type: 'shared' },
                { id: '2_29_3', text: 'Патент UA (корисна модель)', points: 5, type: 'shared' },
                { id: '2_30', text: 'Захист PhD (собі)', points: 75, type: 'fixed' },
                { id: '2_31', text: 'Захист Dr.Sc (собі)', points: 100, type: 'fixed' },
                { id: '2_32', text: 'Отримання звання Професора', points: 40, type: 'fixed' },
                { id: '2_33', text: 'Отримання звання Доцента', points: 20, type: 'fixed' },
                { id: '2_34', text: 'Протермінування звання (-10/рік)', points: -10, type: 'simple', note: 'Штрафні бали' },
                { id: '2_35', text: 'Опонування докторської', points: 15, type: 'simple' },
                { id: '2_36', text: 'Опонування PhD', points: 10, type: 'simple' },
                { id: '2_38_1', text: 'Спецрада ВНМУ (Голова/Секретар)', points: 20, type: 'simple' },
                { id: '2_38_2', text: 'Спецрада ВНМУ (Член)', points: 10, type: 'simple' },
                { id: '2_40', text: 'Відгук на автореферат', points: 5, type: 'simple' },
            ]
        },
        {
            id: 'sec3',
            title: '3. Організаційно-виховна робота',
            icon: 'fa-users',
            items: [
                { id: '3_1', text: 'Керівна посада (Декан/Зав.каф/тощо)', points: 50, type: 'fixed' },
                { id: '3_2', text: 'Гарант освітньої програми', points: 100, type: 'fixed' },
                { id: '3_3', text: 'Голова/Секретар ДЕК', points: 10, type: 'simple' },
                { id: '3_4', text: 'Підтримка веб-сайту', points: 5, type: 'fixed' },
                { id: '3_5', text: 'Експертні ради (НАЗЯВО/МОН)', points: 20, type: 'simple' },
                { id: '3_6_1', text: 'Оргкомітет/Журі (Міжнародні)', points: 15, type: 'simple' },
                { id: '3_6_2', text: 'Оргкомітет/Журі (Всеукраїнські)', points: 10, type: 'simple' },
                { id: '3_6_3', text: 'Оргкомітет/Журі (Обласні)', points: 5, type: 'simple' },
                { id: '3_6_4', text: 'Оргкомітет/Журі (Факультетські)', points: 3, type: 'simple' },
                { id: '3_8_1', text: 'Редколегія журналу Університету (Голова/Заст)', points: 20, type: 'simple' },
                { id: '3_8_2', text: 'Редколегія журналу Університету (Член)', points: 5, type: 'simple' },
                { id: '3_10_1', text: 'Редколегія Scopus/WoS (Голова/Заст)', points: 25, type: 'simple' },
                { id: '3_10_2', text: 'Редколегія Scopus/WoS (Член)', points: 20, type: 'simple' },
                { id: '3_11_1', text: 'Сертифікат англійської (B2+)', points: 15, type: 'fixed' },
                { id: '3_11_2', text: 'Сертифікат іншої мови', points: 5, type: 'fixed' },
                { id: '3_12', text: 'Викладання іноземною (50+ год)', points: 5, type: 'fixed' },
                { id: '3_13_1', text: 'Приймальна комісія (Голова предм. комісії)', points: 15, type: 'simple' },
                { id: '3_13_2', text: 'Приймальна комісія (Екзаменатор)', points: 10, type: 'simple' },
                { id: '3_13_3', text: 'Приймальна комісія (Член)', points: 5, type: 'simple' },
                { id: '3_14', text: 'Комісії Вченої ради (Голова/Секретар)', points: 10, type: 'simple' },
                { id: '3_15', text: 'Група проектної діяльності/моніторингу', points: 5, type: 'simple' },
                { id: '3_16', text: 'Виховні/спорт заходи зі студентами', points: 5, type: 'simple' },
                { id: '3_17', text: 'Керівництво гуртком/Кураторство', points: 5, type: 'fixed' },
                { id: '3_18', text: 'Відп. за метод/наук роботу кафедри', points: 10, type: 'fixed' },
                { id: '3_19', text: 'Проф. об\'єднання (закордонні)', points: 10, type: 'simple' },
                { id: '3_19_2', text: 'Проф. об\'єднання (вітчизняні)', points: 5, type: 'simple' },
            ]
        },
        {
            id: 'sec4',
            title: '4. Відзнаки та визнання',
            icon: 'fa-medal',
            items: [
                { id: '4_1', text: 'Член нац. академій наук', points: 100, type: 'fixed' },
                { id: '4_2', text: 'Державна нагорода / Заслужений діяч', points: 50, type: 'fixed' },
                { id: '4_3', text: 'Почесне звання ЗВО', points: 30, type: 'fixed' },
                { id: '4_4', text: 'Державна премія', points: 25, type: 'fixed' },
                { id: '4_5', text: 'Відомча відзнака (МОН, МОЗ)', points: 10, type: 'simple' },
                { id: '4_6', text: 'Відзнака університету/місцева', points: 5, type: 'simple' },
            ]
        },
        {
            id: 'sec5',
            title: '5. Клінічна робота',
            icon: 'fa-user-doctor',
            items: [
                { id: '5_1', text: 'Позаштатний спеціаліст / Протоколи', points: 20, type: 'fixed' },
                { id: '5_2', text: 'Робота в ЛКК, КЕК', points: 10, type: 'fixed' },
            ]
        }
    ];

    // ------------------------------------------------------------------
    // RENDERER
    // ------------------------------------------------------------------
    function renderForm() {
        const container = document.getElementById('sections-wrapper');
        container.innerHTML = '';

        ratingData.forEach(section => {
            const secDiv = document.createElement('div');
            secDiv.className = "bg-dark-surface rounded-xl shadow-sm border border-dark-border overflow-hidden transition-all duration-300";

            // Header
            const header = document.createElement('div');
            header.className = "px-6 py-4 border-b border-dark-border cursor-pointer hover:bg-gray-800/50 flex justify-between items-center transition-colors";
            header.onclick = () => toggleSectionBody(section.id);
            header.innerHTML = `
                    <h3 class="text-lg font-medium text-dark-primary flex items-center">
                        <i class="fa-solid ${section.icon} w-8 text-center mr-2"></i> ${section.title}
                    </h3>
                    <div class="flex items-center gap-4">
                        <span class="text-dark-textLight font-bold bg-gray-800 px-3 py-1 rounded-full text-sm shadow-inner border border-gray-700 section-total" id="total-${section.id}">0.0</span>
                        <i id="icon-${section.id}" class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300"></i>
                    </div>
                `;

            // Body
            const body = document.createElement('div');
            body.id = `body-${section.id}`;
            body.className = "hidden"; // Start collapsed

            // ADDED: Column Headers Row for Clarity
            const colHeader = document.createElement('div');
            colHeader.className = "grid grid-cols-12 gap-2 sm:gap-4 px-4 py-3 bg-gray-900/50 border-b border-dark-border/50 text-xs uppercase font-bold text-gray-500 tracking-wider";
            colHeader.innerHTML = `
                    <div class="col-span-6">Показник</div>
                    <div class="col-span-3 sm:col-span-2 text-center">Кількість / Введення</div>
                    <div class="col-span-3 sm:col-span-2 text-center">Співавтори</div>
                    <div class="col-span-12 sm:col-span-2 text-right hidden sm:block">Всього балів</div>
                `;
            body.appendChild(colHeader);

            const grid = document.createElement('div');
            grid.className = "p-4 space-y-3 bg-gray-900/20";

            section.items.forEach(item => {
                const row = document.createElement('div');
                row.className = "grid grid-cols-12 gap-2 sm:gap-4 items-center bg-dark-surface p-3 rounded-lg border border-dark-border/50 hover:border-dark-border transition-colors group";
                row.dataset.id = item.id;
                row.dataset.type = item.type;
                row.dataset.points = item.points || 0;

                let inputsHtml = '';
                let noteHtml = item.note ? `<div class="text-[10px] text-gray-500 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>${item.note}</div>` : '';

                // Explicit Placeholders as requested
                if (item.type === 'shared') {
                    inputsHtml = `
                            <div class="col-span-3 sm:col-span-2 relative tooltip-container">
                                <span class="text-[10px] text-gray-500 absolute -top-2 left-2 bg-dark-surface px-1">Робіт</span>
                                <input type="number" min="0" value="0" class="inp-count w-full bg-dark-bg border border-dark-border rounded px-2 py-1.5 text-white text-center focus:border-dark-primary outline-none" oninput="calculateRow(this)">
                            </div>
                            <div class="col-span-3 sm:col-span-2 relative">
                                <span class="text-[10px] text-gray-500 absolute -top-2 left-2 bg-dark-surface px-1">Авторів</span>
                                <input type="number" min="1" value="1" class="inp-authors w-full bg-dark-bg border border-dark-border rounded px-2 py-1.5 text-white text-center focus:border-dark-primary outline-none" oninput="calculateRow(this)">
                            </div>
                        `;
                } else if (item.type === 'shared_pool') {
                    inputsHtml = `
                            <div class="col-span-3 sm:col-span-2 flex flex-col items-center justify-center text-xs text-gray-400 border border-dashed border-gray-700 rounded bg-gray-900/50 h-full">
                                <span class="block text-[9px] uppercase">Фонд балів</span>
                                <span class="text-dark-primary font-bold">${item.points}</span>
                            </div>
                            <div class="col-span-3 sm:col-span-2 relative">
                                <span class="text-[10px] text-gray-500 absolute -top-2 left-2 bg-dark-surface px-1">Учасників</span>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" class="pool-enable accent-dark-primary w-4 h-4" onchange="calculateRow(this)" title="Активувати">
                                    <input type="number" min="1" value="1" class="inp-authors w-full bg-dark-bg border border-dark-border rounded px-2 py-1.5 text-white text-center focus:border-dark-primary outline-none disabled:opacity-30 disabled:cursor-not-allowed" disabled oninput="calculateRow(this)">
                                </div>
                            </div>
                        `;
                } else if (item.type === 'simple') {
                    inputsHtml = `
                            <div class="col-span-6 sm:col-span-4 relative">
                                <span class="text-[10px] text-gray-500 absolute -top-2 left-2 bg-dark-surface px-1">Кількість</span>
                                <input type="number" min="0" value="0" class="inp-count w-full bg-dark-bg border border-dark-border rounded px-2 py-1.5 text-white text-center focus:border-dark-primary outline-none" oninput="calculateRow(this)">
                            </div>
                        `;
                } else if (item.type === 'fixed') {
                    inputsHtml = `
                            <div class="col-span-6 sm:col-span-4 flex justify-end items-center pr-4 h-full">
                                <span class="text-xs text-gray-500 mr-2">Ні / Так</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer inp-check" onchange="calculateRow(this)">
                                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-dark-success"></div>
                                </label>
                            </div>
                        `;
                } else if (item.type === 'manual' || item.type === 'manual_shared') {
                    inputsHtml = `
                            <div class="col-span-6 sm:col-span-4 relative">
                                <span class="text-[10px] text-gray-500 absolute -top-2 left-2 bg-dark-surface px-1">Введіть бали</span>
                                <input type="number" step="0.1" value="0" class="inp-manual w-full bg-dark-bg border border-dark-border rounded px-2 py-1.5 text-white text-right focus:border-dark-primary outline-none" oninput="calculateRow(this)">
                            </div>
                        `;
                } else if (item.type === 'select') {
                    let opts = item.options.map(o => `<option value="${o.val}">${o.label}</option>`).join('');
                    inputsHtml = `
                            <div class="col-span-6 sm:col-span-4 relative">
                                <span class="text-[10px] text-gray-500 absolute -top-2 left-2 bg-dark-surface px-1">Оберіть варіант</span>
                                <select class="inp-select w-full bg-dark-bg border border-dark-border rounded px-2 py-1.5 text-white focus:border-dark-primary outline-none" onchange="calculateRow(this)">
                                    ${opts}
                                </select>
                            </div>
                        `;
                }

                row.innerHTML = `
                        <div class="col-span-6 sm:col-span-6 text-sm text-gray-300 pr-2">
                            ${item.text}
                            ${noteHtml}
                            <input type="hidden" name="items[${item.id}][label]" value="${item.text}">
                            <input type="hidden" name="items[${item.id}][score]" class="final-score-input" value="0">
                        </div>
                        ${inputsHtml}
                        <div class="col-span-12 sm:col-span-2 text-right mt-2 sm:mt-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-700 sm:border-none flex justify-between sm:block">
                            <span class="sm:hidden text-xs text-gray-500 uppercase">Всього:</span>
                            <span class="font-mono text-dark-primary font-bold row-total">0.0</span>
                        </div>
                    `;
                grid.appendChild(row);
            });

            body.appendChild(grid);
            secDiv.appendChild(header);
            secDiv.appendChild(body);
            container.appendChild(secDiv);
        });
    }

    // ------------------------------------------------------------------
    // LOGIC
    // ------------------------------------------------------------------
    function toggleForm() {
        const empty = document.getElementById('emptyState');
        const form = document.getElementById('ratingFormContainer');
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            empty.classList.add('hidden');
        } else {
            form.classList.add('hidden');
            empty.classList.remove('hidden');
        }
    }

    function toggleSectionBody(id) {
        const body = document.getElementById(`body-${id}`);
        const icon = document.getElementById(`icon-${id}`);
        if (body.classList.contains('hidden')) {
            body.classList.remove('hidden');
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            body.classList.add('hidden');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }

    function calculateRow(element) {
        const row = element.closest('.grid');
        const type = row.dataset.type;
        const points = parseFloat(row.dataset.points);
        const display = row.querySelector('.row-total');
        const hiddenInput = row.querySelector('.final-score-input');

        let score = 0;

        if (type === 'shared') {
            const count = parseFloat(row.querySelector('.inp-count').value) || 0;
            const authors = parseFloat(row.querySelector('.inp-authors').value) || 1;
            score = (count * points) / authors;
        } else if (type === 'shared_pool') {
            const enable = row.querySelector('.pool-enable').checked;
            const authInput = row.querySelector('.inp-authors');
            authInput.disabled = !enable;

            if (!enable) {
                score = 0;
            } else {
                const authors = parseFloat(authInput.value) || 1;
                score = points / authors;
            }
        } else if (type === 'simple') {
            const count = parseFloat(row.querySelector('.inp-count').value) || 0;
            score = count * points;
        } else if (type === 'fixed') {
            const checked = row.querySelector('.inp-check').checked;
            score = checked ? points : 0;
        } else if (type === 'manual' || type === 'manual_shared') {
            score = parseFloat(row.querySelector('.inp-manual').value) || 0;
        } else if (type === 'select') {
            score = parseFloat(row.querySelector('.inp-select').value) || 0;
        }

        // Update row display
        display.textContent = score.toFixed(1);
        hiddenInput.value = score.toFixed(1);

        // Update section total
        calculateSectionTotal(row.closest('[id^="body-"]').id.replace('body-', ''));
    }

    function calculateSectionTotal(sectionId) {
        const container = document.getElementById(`body-${sectionId}`);
        let total = 0;
        container.querySelectorAll('.row-total').forEach(span => {
            total += parseFloat(span.textContent) || 0;
        });

        document.getElementById(`total-${sectionId}`).textContent = total.toFixed(1);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.section-total').forEach(span => {
            total += parseFloat(span.textContent) || 0;
        });
        document.getElementById('grandTotal').textContent = total.toFixed(1);
    }

    function calculateAll() {
        document.querySelectorAll('[id^="total-"]').forEach(el => el.textContent = '0.0');
        document.getElementById('grandTotal').textContent = '0.0';
        document.querySelectorAll('.row-total').forEach(el => el.textContent = '0.0');
    }

    // ------------------------------------------------------------------
    // TOAST NOTIFICATIONS
    // ------------------------------------------------------------------
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');

        // Icons and Colors
        const isSuccess = type === 'success';
        const bgColor = 'bg-dark-surface';
        const borderColor = isSuccess ? 'border-green-500' : 'border-red-500';
        const icon = isSuccess ? 'fa-circle-check text-green-500' : 'fa-circle-exclamation text-red-500';
        const title = isSuccess ? 'Успіх' : 'Помилка';

        toast.className = `${bgColor} border-l-4 ${borderColor} text-white px-6 py-4 rounded shadow-2xl flex items-center gap-4 transform transition-all duration-300 translate-x-full opacity-0 min-w-[300px] pointer-events-auto`;

        toast.innerHTML = `
                <i class="fa-solid ${icon} text-xl"></i>
                <div>
                    <h4 class="font-bold text-sm">${title}</h4>
                    <p class="text-xs text-gray-400">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-gray-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

        container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        });

        // Auto remove
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    }

    // ------------------------------------------------------------------
    // JSON SUBMISSION HANDLER
    // ------------------------------------------------------------------
    document.getElementById('ratingForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Stop standard form submission
        const btn = document.getElementById('submitBtn');
        const originalBtnContent = btn.innerHTML;

        // Show loading state
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Обробка...';

        // Gather Data
        const formData = new FormData(this);
        const data = {
            personal: {},
            items: [],
            totalScore: parseFloat(document.getElementById('grandTotal').textContent),
            code: formData.get('code')
        };

        // Personal Info
        for (let [key, value] of formData.entries()) {
            if (key.startsWith('personal[')) {
                const field = key.match(/\[(.*?)\]/)[1];
                data.personal[field] = value;
            }
        }

        // Items (Only those with non-zero score)
        document.querySelectorAll('.grid[data-id]').forEach(row => {
            const id = row.dataset.id;
            const score = parseFloat(row.querySelector('.final-score-input').value) || 0;

            if (score > 0) {
                const label = row.querySelector('input[name*="[label]"]').value;
                const type = row.dataset.type;
                let itemData = { id, label, score, type };

                // Add details based on type
                if (row.querySelector('.inp-count')) itemData.count = row.querySelector('.inp-count').value;
                if (row.querySelector('.inp-authors')) itemData.authors = row.querySelector('.inp-authors').value;
                if (row.querySelector('.inp-manual')) itemData.manualValue = row.querySelector('.inp-manual').value;
                if (row.querySelector('.inp-select')) itemData.selectValue = row.querySelector('.inp-select').value;

                data.items.push(itemData);
            }
        });

        console.log("JSON для відправки:", data);

        // Simulate Fetch Request
        fetch('/department/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                // Since this is a static demo, we simulate success even if 404
                console.log("Request sent");
                return new Promise(resolve => setTimeout(resolve, 800)); // Fake delay
            })
            .then(() => {
                // Success UI on Button
                btn.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Успішно!';
                btn.classList.remove('bg-dark-success', 'hover:bg-green-600');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');

                // Show Beautiful Toast
                showToast('Звіт успішно збережено та відправлено!', 'success');

                // Wait 2 seconds, then reset and hide
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalBtnContent;
                    btn.classList.add('bg-dark-success', 'hover:bg-green-600');
                    btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');

                    // Reset and hide form, show empty state
                    document.getElementById('ratingForm').reset();
                    calculateAll();
                    toggleForm(); // Will hide form and show empty state
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerHTML = originalBtnContent;
                showToast('Виникла помилка при збереженні даних.', 'error');
            });
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderForm();
    });

</script>
</body>
</html>
