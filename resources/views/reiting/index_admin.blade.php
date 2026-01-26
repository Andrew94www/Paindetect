 <!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кафедри ВНМУ ім. М.І. Пирогова</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #1e293b; /* Slate 800 - Much lighter/softer dark */
            color: #f1f5f9; /* Slate 100 */
            overflow-x: hidden;
        }

        /* Adjusted background glow for lighter theme */
        .glow-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background:
                radial-gradient(circle at 10% 20%, rgba(56, 189, 248, 0.08) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(99, 102, 241, 0.08) 0%, transparent 20%);
            pointer-events: none;
        }

        .glass-header {
            background: rgba(30, 41, 59, 0.85); /* Slate 800 with opacity */
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Lighter Cards */
        .dept-card {
            background: #334155; /* Slate 700 - Distinctly lighter than background */
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease-out;
            position: relative;
            overflow: hidden;
        }

        .dept-card:hover {
            transform: translateY(-2px);
            background: #475569; /* Slate 600 on hover */
            border-color: rgba(99, 102, 241, 0.4);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Accent strip on hover */
        .dept-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: #818cf8; /* Indigo 400 */
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .dept-card:hover::before {
            opacity: 1;
        }

        /* Input styling */
        .search-input {
            background: #0f172a; /* Darker input for contrast */
            border: 1px solid #475569;
            transition: all 0.2s ease;
        }
        .search-input:focus {
            background: #1e293b;
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
        }

        /* Filter Buttons */
        .filter-btn {
            background: #334155;
            border: 1px solid transparent;
            color: #cbd5e1;
            transition: all 0.2s ease;
        }
        .filter-btn:hover {
            background: #475569;
            color: white;
        }
        .filter-btn.active {
            background: #6366f1; /* Indigo 500 */
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>
<body class="antialiased selection:bg-indigo-400 selection:text-white">

<!-- Ambient Background -->
<div class="glow-bg"></div>

<!-- Header / Navbar -->
<header class="glass-header fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center gap-4">
                <!-- Logo -->
                <div class="bg-indigo-500 text-white w-10 h-10 rounded-lg flex items-center justify-center font-bold text-lg shadow-md">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white leading-none tracking-tight">ВНМУ</h1>
                    <p class="text-[10px] uppercase text-slate-400 font-bold tracking-widest mt-1">ім. М.І. Пирогова</p>
                </div>
            </div>

            <a href="https://www.vnmu.edu.ua/" target="_blank" class="hidden sm:flex items-center gap-2 text-sm font-medium text-slate-300 hover:text-white transition-colors bg-slate-700/50 hover:bg-slate-700 px-4 py-2 rounded-lg border border-slate-600/50">
                <span>Офіційний сайт</span>
                <i class="fa-solid fa-arrow-up-right-from-square text-xs opacity-70"></i>
            </a>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">

    <!-- Hero Section -->
    <div class="text-center mb-16 relative">
        <h2 class="text-4xl sm:text-6xl font-extrabold text-white mb-6 tracking-tight drop-shadow-sm">
            Навігатор <br class="hidden sm:block">
            <span class="text-indigo-400">Кафедрами</span>
        </h2>
        <p class="text-lg text-slate-300 max-w-xl mx-auto mb-10 leading-relaxed font-light">
            Швидкий доступ до структурних підрозділів університету.
        </p>

        <!-- Search Bar -->
        <div class="relative max-w-2xl mx-auto group z-10">
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                <i class="fa-solid fa-search text-slate-400 group-focus-within:text-indigo-400 transition-colors"></i>
            </div>
            <input type="text" id="searchInput"
                   class="search-input block w-full pl-12 pr-4 py-4 rounded-xl text-white placeholder-slate-400 focus:outline-none text-lg shadow-lg shadow-black/10"
                   placeholder="Пошук (наприклад: Хірургії, Фізіології)...">
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                <kbd class="hidden sm:inline-block px-2 py-1 text-xs font-semibold text-slate-400 bg-slate-800 border border-slate-600 rounded-md">⌘ K</kbd>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap justify-center gap-3 mb-12" id="filterContainer">
        <button class="filter-btn active px-5 py-2.5 rounded-full text-sm font-medium shadow-md" data-filter="all">Всі</button>
        <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium shadow-sm" data-filter="theoretical">Теоретичні</button>
        <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium shadow-sm" data-filter="clinical">Клінічні</button>
        <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium shadow-sm" data-filter="dental">Стоматологічні</button>
        <button class="filter-btn px-5 py-2.5 rounded-full text-sm font-medium shadow-sm" data-filter="pharma">Фармацевтичні</button>
    </div>

    <!-- Departments Grid -->
    <div id="departmentsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Cards will be injected here by JS -->
    </div>

    <!-- No Results State -->
    <div id="noResults" class="hidden text-center py-24">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-700/50 mb-4 text-slate-400 border border-slate-600/50">
            <i class="fa-solid fa-magnifying-glass text-2xl"></i>
        </div>
        <h3 class="text-xl font-medium text-white mb-2">Нічого не знайдено</h3>
        <p class="text-slate-400">Спробуйте змінити критерії пошуку</p>
    </div>

</main>

<footer class="border-t border-slate-700/50 py-12 mt-12 bg-slate-800/50">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-slate-400 text-sm flex items-center justify-center gap-2">
            <span>© 2024 ВНМУ ім. М.І. Пирогова</span>
            <span class="w-1 h-1 rounded-full bg-slate-600"></span>
            <span class="text-slate-500">Неофіційний навігатор</span>
        </p>
    </div>
</footer>

<script>
    // Data Source
    const departments = [
        // --- Theoretical / General ---
        { name: "Кафедра анатомії людини", category: "theoretical", link: "/admin/department/anatomy" },
        { name: "Кафедра біологічної фізики, медичної апаратури та інформатики", category: "theoretical", link: "/admin/department/biophysics" },
        { name: "Кафедра біохімії та загальної хімії", category: "theoretical", link: "/admin/department/biochemistry" },
        { name: "Кафедра гістології", category: "theoretical", link: "/admin/department/histology" },
        { name: "Кафедра медичної біології", category: "theoretical", link: "/admin/department/med-biology" },
        { name: "Кафедра мікробіології", category: "theoretical", link: "/admin/department/microbiology" },
        { name: "Кафедра нормальної фізіології", category: "theoretical", link: "/admin/department/physiology" },
        { name: "Кафедра патологічної анатомії", category: "theoretical", link: "/admin/department/path-anatomy" },
        { name: "Кафедра патологічної фізіології", category: "theoretical", link: "/admin/department/path-physiology" },
        { name: "Кафедра оперативної хірургії та клінічної анатомії", category: "theoretical", link: "/admin/department/op-surgery" },
        { name: "Кафедра загальної гігієни та екології", category: "theoretical", link: "/admin/department/general-hygiene" },
        { name: "Кафедра епідеміології", category: "theoretical", link: "/admin/department/epidemiology" },
        { name: "Кафедра іноземних мов", category: "theoretical", link: "/admin/department/languages" },
        { name: "Кафедра латинської мови", category: "theoretical", link: "/admin/department/latin" },
        { name: "Кафедра суспільних наук", category: "theoretical", link: "/admin/department/social-sciences" },
        { name: "Кафедра філософії та суспільних наук", category: "theoretical", link: "/admin/department/philosophy" },
        { name: "Кафедра українознавства", category: "theoretical", link: "/admin/department/ukrainian-studies" },
        { name: "Кафедра педагогіки та психології", category: "theoretical", link: "/admin/department/pedagogy-psych" },
        { name: "Кафедра фізвиховання", category: "theoretical", link: "/admin/department/phys-ed" },
        { name: "Кафедра судової медицини та права", category: "theoretical", link: "/admin/department/forensic-med" },
        { name: "Кафедра менеджменту", category: "theoretical", link: "/admin/department/management" },
        { name: "Медичне право", category: "theoretical", link: "/admin/department/med-law" },

        // --- Clinical ---
        { name: "Кафедра акушерства і гінекології №1", category: "clinical", link: "/admin/department/obstetrics-1" },
        { name: "Кафедра акушерства і гінекології №2", category: "clinical", link: "/admin/department/obstetrics-2" },
        { name: "Кафедра внутрішньої медицини №1", category: "clinical", link: "/admin/department/int-medicine-1" },
        { name: "Кафедра внутрішньої медицини №2", category: "clinical", link: "/admin/department/int-medicine-2" },
        { name: "Кафедра внутрішньої медицини №3", category: "clinical", link: "/admin/department/int-medicine-3" },
        { name: "Кафедра внутрішньої медицини МФ №2", category: "clinical", link: "/admin/department/int-medicine-mf2" },
        { name: "Кафедра внутрішньої та сімейної медицини", category: "clinical", link: "/admin/department/family-medicine" },
        { name: "Кафедра пропедевтики внутрішньої медицини", category: "clinical", link: "/admin/department/propaedeutics" },
        { name: "Кафедра ендокринології", category: "clinical", link: "/admin/department/endocrinology" },
        { name: "Кафедра інфекційних хвороб", category: "clinical", link: "/admin/department/infectious-diseases" },
        { name: "Кафедра медицини катастроф та військової медицини", category: "clinical", link: "/admin/department/military-med" },
        { name: "Кафедра нервових хвороб з курсом нейрохірургії", category: "clinical", link: "/admin/department/neurology-neurosurg" },
        { name: "Кафедра невролгії та нейрохірургії факультету післяделомної освіти", category: "clinical", link: "/admin/department/neurology-after" },
        { name: "Кафедра променевої діагностики, променевої терапії та онкології", category: "clinical", link: "/admin/department/oncology-radiology" },
        { name: "Кафедра педіатрії №1", category: "clinical", link: "/admin/department/pediatrics-1" },
        { name: "Кафедра педіатрії №2", category: "clinical", link: "/admin/department/pediatrics-2" },
        { name: "Кафедра пропедевтики дитячих захворювань", category: "clinical", link: "/admin/department/prop-pediatrics" },
        { name: "Кафедра дитячих інфекційних хвороб", category: "clinical", link: "/admin/department/ped-infectious" },
        { name: "Кафедра дитячої хірургії", category: "clinical", link: "/admin/department/ped-surgery" },
        { name: "Кафедра психіатрії, наркології та психотерапії", category: "clinical", link: "/admin/department/psychiatry" },
        { name: "Кафедра медичної психології та психіатрії", category: "clinical", link: "/admin/department/med-psychology" },
        { name: "Кафедра травматології та ортопедії", category: "clinical", link: "/admin/department/traumatology" },
        { name: "Кафедра фізичної та реабілітаційної медицини", category: "clinical", link: "/admin/department/rehab-medicine" },
        { name: "Кафедра загальної хірургії", category: "clinical", link: "/admin/department/general-surgery" },
        { name: "Кафедра хірургії №1", category: "clinical", link: "/admin/department/surgery-1" },
        { name: "Кафедра хірургії №2", category: "clinical", link: "/admin/department/surgery-2" },
        { name: "Кафедра хірургії МФ №2", category: "clinical", link: "/admin/department/surgery-mf2" },
        { name: "Кафедра ендоскопічної та серцево-судинної хірургії", category: "clinical", link: "/admin/department/cv-surgery" },
        { name: "Кафедра анестезіології, інтенсивної терапії та МНС", category: "clinical", link: "/admin/department/anesthesiology" },
        { name: "Курс урології", category: "clinical", link: "/admin/department/urology" },
        { name: "Кафедра оториноларингології", category: "clinical", link: "/admin/department/ent" },
        { name: "Кафедра очних хвороб", category: "clinical", link: "/admin/department/ophthalmology" },
        { name: "Кафедра фтизіатрії", category: "clinical", link: "/admin/department/phthisiology" },
        { name: "Кафедра шкірно-венеричних хвороб", category: "clinical", link: "/admin/department/dermatology" },
        { name: "Кафедра соціальної медицини", category: "clinical", link: "/admin/department/social-medicine" },

        // --- Dental ---
        { name: "Кафедра ортопедичної стоматології", category: "dental", link: "/admin/department/ortho-dentistry" },
        { name: "Кафедра стоматології дитячого віку", category: "dental", link: "/admin/department/ped-dentistry" },
        { name: "Кафедра терапевтичної стоматології", category: "dental", link: "/admin/department/ther-dentistry" },
        { name: "Кафедра хірургічної стоматології", category: "dental", link: "/admin/department/surg-dentistry" },

        // --- Pharma ---
        { name: "Кафедра фармації", category: "pharma", link: "/admin/department/pharmacy" },
        { name: "Кафедра фармацевтичної хімії", category: "pharma", link: "/admin/department/pharm-chemistry" },
        { name: "Кафедра клінічної фармації", category: "pharma", link: "/admin/department/clin-pharmacy" },
        { name: "Кафедра фармакології", category: "pharma", link: "/admin/department/pharmacology" }
    ];

    const grid = document.getElementById('departmentsGrid');
    const searchInput = document.getElementById('searchInput');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const noResults = document.getElementById('noResults');

    let currentFilter = 'all';

    function renderDepartments(filterText = '') {
        grid.innerHTML = '';

        const filtered = departments.filter(dept => {
            const matchesText = dept.name.toLowerCase().includes(filterText.toLowerCase());
            const matchesCategory = currentFilter === 'all' || dept.category === currentFilter;
            return matchesText && matchesCategory;
        });

        if (filtered.length === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
            filtered.forEach(dept => {
                const card = document.createElement('a');
                card.href = dept.link;
                card.className = 'dept-card p-6 rounded-xl flex items-center justify-between group cursor-pointer';

                card.innerHTML = `
                        <div class="pr-4">
                            <h3 class="font-medium text-slate-100 group-hover:text-white transition-colors leading-snug">
                                ${dept.name}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                Перейти до кафедри
                            </p>
                        </div>
                        <div class="arrow-icon text-slate-500 transition-transform duration-300">
                             <i class="fa-solid fa-chevron-right text-sm"></i>
                        </div>
                    `;
                grid.appendChild(card);
            });
        }
    }

    // Search Listener
    searchInput.addEventListener('input', (e) => {
        renderDepartments(e.target.value);
    });

    // Filter Buttons Listener
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active state
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            currentFilter = btn.dataset.filter;
            renderDepartments(searchInput.value);
        });
    });

    // Keyboard Shortcut
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
    });

    // Initial Render
    renderDepartments();

</script>
</body>
</html>
