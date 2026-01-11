<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-PAT Admin System</title>

    <!-- Tailwind CSS (для стилизации) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Анимации */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 0.2s ease-out forwards; }
        .animate-slide-down { animation: slideDown 0.3s ease-out forwards; }

        /* Скроллбар */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { bg: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: {
                            850: '#151e32',
                            950: '#020617',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col md:flex-row overflow-hidden">

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-5 right-5 z-50 pointer-events-none transition-all duration-300"></div>

<!-- Sidebar -->
<aside class="w-full md:w-64 bg-slate-900 border-r border-slate-800 flex flex-col shadow-xl z-20">
    <div class="p-6 flex items-center gap-3 border-b border-slate-800">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-900/20">
            <i data-lucide="shield-alert" width="24" height="24"></i>
        </div>
        <div>
            <h1 class="font-bold text-xl tracking-tight leading-tight">R-PAT</h1>
            <p class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold">Secure Admin</p>
        </div>
    </div>

    <nav class="p-4 space-y-2 flex-1">
        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-4 mb-2 mt-2">База даних</div>

        <button onclick="switchTab('doctors')" id="nav-doctors" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-slate-200">
            <i data-lucide="stethoscope" width="20"></i>
            <span class="font-medium">Лікарі</span>
            <i data-lucide="chevron-right" width="16" class="ml-auto opacity-50 nav-arrow hidden"></i>
        </button>

        <button onclick="switchTab('patients')" id="nav-patients" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800 hover:text-slate-200">
            <i data-lucide="users" width="20"></i>
            <span class="font-medium">Пацієнти</span>
            <i data-lucide="chevron-right" width="16" class="ml-auto opacity-50 nav-arrow hidden"></i>
        </button>
    </nav>

    <div class="p-4 mt-auto">
        <div class="bg-slate-950/50 border border-slate-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center font-bold text-xs text-slate-300">SYS</div>
                <div>
                    <p class="text-sm font-medium text-slate-200">System Admin</p>
                    <p class="text-xs text-slate-500">root@r-pat.ua</p>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content -->
<main class="flex-1 overflow-auto bg-slate-950 relative h-screen flex flex-col">
    <!-- Decoration -->
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-900/10 to-transparent pointer-events-none"></div>

    <!-- Header -->
    <header class="sticky top-0 z-10 backdrop-blur-xl bg-slate-950/80 border-b border-slate-800 px-8 py-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 id="page-title" class="text-2xl font-bold text-white tracking-tight">Управління лікарями</h2>
            <p id="page-subtitle" class="text-slate-500 text-sm mt-1">Активні записи: 0</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="relative group">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-blue-400 transition-colors" width="18"></i>
                <input
                    type="text"
                    id="search-input"
                    placeholder="Швидкий пошук..."
                    class="pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 focus:border-blue-500/50 focus:bg-slate-800 focus:ring-4 focus:ring-blue-500/10 rounded-xl outline-none transition-all w-64 text-sm text-white placeholder:text-slate-600"
                >
            </div>

            <button onclick="openModal()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-900/40 transition-all active:scale-95 border border-blue-500">
                <i data-lucide="plus" width="18"></i>
                <span>Створити</span>
            </button>
        </div>
    </header>

    <!-- Table -->
    <div class="p-8 relative z-0 flex-1 overflow-auto">
        <div class="bg-slate-900 rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-slate-950/50 border-b border-slate-800">
                        <th class="px-6 py-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">ID / Роль</th>
                        <th class="px-6 py-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">Користувач</th>
                        <th id="th-col3" class="px-6 py-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">Спеціалізація</th>
                        <th id="th-col4" class="px-6 py-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">Досвід</th>
                        <th class="px-6 py-4 font-semibold text-slate-400 text-xs uppercase tracking-wider">Статус</th>
                        <th class="px-6 py-4 font-semibold text-slate-400 text-xs uppercase tracking-wider text-right">Дії</th>
                    </tr>
                    </thead>
                    <tbody id="table-body" class="divide-y divide-slate-800/50">
                    <!-- Rows will be injected by JS -->
                    </tbody>
                </table>
            </div>
            <!-- Empty State -->
            <div id="empty-state" class="hidden px-6 py-12 text-center text-slate-500">
                <div class="flex flex-col items-center gap-2">
                    <i data-lucide="search" width="32" class="opacity-20"></i>
                    <p>Записів не знайдено</p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Backdrop -->
<div id="modal-backdrop" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
    <!-- Modal Content -->
    <div id="modal-content" class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-950/50">
            <h3 id="modal-title" class="font-bold text-lg text-white">Створити профіль</h3>
            <button onclick="closeModal()" class="text-slate-500 hover:text-white transition-colors">
                <i data-lucide="x" width="20"></i>
            </button>
        </div>

        <form id="data-form" class="p-6 space-y-5">
            <input type="hidden" id="edit-id" value="">

            <!-- Role Selection -->
            <div class="bg-slate-950/50 p-3 rounded-xl border border-slate-800">
                <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wider">Призначити роль</label>
                <div class="flex gap-2">
                    <button type="button" onclick="setFormRole('doctor')" id="btn-role-doctor" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium transition-all bg-blue-600 text-white shadow-lg shadow-blue-900/50">
                        <i data-lucide="stethoscope" width="16"></i>
                        Лікар
                    </button>
                    <button type="button" onclick="setFormRole('patient')" id="btn-role-patient" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium transition-all bg-slate-800 text-slate-400 hover:bg-slate-700">
                        <i data-lucide="users" width="16"></i>
                        Пацієнт
                    </button>
                </div>
            </div>

            <!-- Common Fields -->
            <div>
                <label class="block text-sm font-medium text-slate-400 mb-1.5">ПІБ Користувача</label>
                <input required type="text" id="field-name" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 outline-none transition-all placeholder:text-slate-600" placeholder="Введіть повне ім'я">
            </div>

            <!-- Doctor Fields -->
            <div id="fields-doctor" class="space-y-4 animate-fade-in">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1.5">Спеціалізація</label>
                    <select id="field-spec" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500/50 outline-none">
                        <option value="">Оберіть...</option>
                        <option value="Терапевт">Терапевт</option>
                        <option value="Кардіолог">Кардіолог</option>
                        <option value="Хірург">Хірург</option>
                        <option value="Педіатр">Педіатр</option>
                        <option value="Невролог">Невролог</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1.5">Досвід роботи</label>
                    <input type="text" id="field-exp" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500/50 outline-none placeholder:text-slate-600" placeholder="Напр. 5 років">
                </div>
            </div>

            <!-- Patient Fields -->
            <div id="fields-patient" class="space-y-4 animate-fade-in hidden">
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1.5">Діагноз</label>
                    <input type="text" id="field-diagnosis" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 outline-none placeholder:text-slate-600" placeholder="Попередній діагноз">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-400 mb-1.5">Лікуючий лікар</label>
                    <select id="field-doctor-link" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:ring-2 focus:ring-emerald-500/50 outline-none">
                        <!-- Populated by JS -->
                    </select>
                </div>
            </div>

            <!-- Status Field (Dynamic Options) -->
            <div>
                <label class="block text-sm font-medium text-slate-400 mb-1.5">Статус</label>
                <select id="field-status" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-lg text-white focus:ring-2 outline-none">
                    <!-- Options injected by JS based on role -->
                </select>
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-2.5 rounded-xl border border-slate-700 text-slate-300 font-medium hover:bg-slate-800 transition-colors">
                    Скасувати
                </button>
                <button id="btn-save" type="submit" class="flex-1 py-2.5 rounded-xl text-white font-medium shadow-lg transition-colors flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 shadow-blue-900/40">
                    <i data-lucide="check" width="18"></i>
                    Зберегти
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript Logic -->
<script>
    // --- State ---
    let activeTab = 'doctors'; // 'doctors' | 'patients'
    let modalRole = 'doctor';  // 'doctor' | 'patient'

    let doctors = [
        { id: 1, name: 'Олександр Петренко', role: 'doctor', specialization: 'Терапевт', status: 'Активний', experience: '15 років' },
        { id: 2, name: 'Марія Коваленко', role: 'doctor', specialization: 'Кардіолог', status: 'У відпустці', experience: '7 років' },
        { id: 3, name: 'Андрій Шевченко', role: 'doctor', specialization: 'Хірург', status: 'Активний', experience: '20 років' },
        { id: 4, name: 'Олена Бойко', role: 'doctor', specialization: 'Педіатр', status: 'Активний', experience: '4 роки' },
        { id: 5, name: 'Василь Мельник', role: 'doctor', specialization: 'Невролог', status: 'На зміні', experience: '11 років' },
    ];

    let patients = [
        { id: 101, name: 'Іван Бондаренко', role: 'patient', diagnosis: 'Гіпертонія', doctor: 'Марія Коваленко', status: 'Стабільний' },
        { id: 102, name: 'Тетяна Кравчук', role: 'patient', diagnosis: 'ГРВІ', doctor: 'Олександр Петренко', status: 'Лікування' },
        { id: 103, name: 'Сергій Ткаченко', role: 'patient', diagnosis: 'Перелом руки', doctor: 'Андрій Шевченко', status: 'Реабілітація' },
        { id: 104, name: 'Наталія Лисенко', role: 'patient', diagnosis: 'Мігрень', doctor: 'Василь Мельник', status: 'Обстеження' },
    ];

    // --- Init ---
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        renderTable();
        updateNavigation();

        // Search Listener
        document.getElementById('search-input').addEventListener('input', renderTable);

        // Form Submit Listener
        document.getElementById('data-form').addEventListener('submit', handleFormSubmit);
    });

    // --- Navigation ---
    function switchTab(tab) {
        activeTab = tab;
        updateNavigation();
        renderTable();
    }

    function updateNavigation() {
        const navDoctors = document.getElementById('nav-doctors');
        const navPatients = document.getElementById('nav-patients');
        const activeClass = 'bg-blue-600/10 text-blue-400 border border-blue-600/20';
        const inactiveClass = 'text-slate-400 hover:bg-slate-800 hover:text-slate-200';

        // Reset
        navDoctors.className = `w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 ${activeTab === 'doctors' ? activeClass : inactiveClass}`;
        navPatients.className = `w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 ${activeTab === 'patients' ? activeClass : inactiveClass}`;

        // Handle Arrows
        navDoctors.querySelector('.nav-arrow').classList.toggle('hidden', activeTab !== 'doctors');
        navPatients.querySelector('.nav-arrow').classList.toggle('hidden', activeTab !== 'patients');

        // Update Header
        document.getElementById('page-title').innerText = activeTab === 'doctors' ? 'Управління лікарями' : 'Реєстр пацієнтів';

        // Update Headers
        document.getElementById('th-col3').innerText = activeTab === 'doctors' ? 'Спеціалізація' : 'Діагноз';
        document.getElementById('th-col4').innerText = activeTab === 'doctors' ? 'Досвід' : 'Лікар';
    }

    // --- Rendering ---
    function renderTable() {
        const tbody = document.getElementById('table-body');
        const emptyState = document.getElementById('empty-state');
        const query = document.getElementById('search-input').value.toLowerCase();

        const data = activeTab === 'doctors' ? doctors : patients;
        const filtered = data.filter(item =>
            item.name.toLowerCase().includes(query) ||
            (item.specialization && item.specialization.toLowerCase().includes(query)) ||
            (item.diagnosis && item.diagnosis.toLowerCase().includes(query))
        );

        document.getElementById('page-subtitle').innerText = `Активні записи: ${data.length}`;

        tbody.innerHTML = '';

        if (filtered.length === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
            filtered.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-800/50 transition-colors group animate-fade-in';

                // Avatar Color
                const avatarClass = item.role === 'doctor'
                    ? 'bg-gradient-to-br from-blue-500 to-indigo-600'
                    : 'bg-gradient-to-br from-emerald-500 to-teal-600';

                // Role Text Color
                const roleColor = item.role === 'doctor' ? 'text-blue-400' : 'text-emerald-400';

                // Col 3 Content
                const col3 = item.role === 'doctor' ? item.specialization : item.diagnosis;

                // Col 4 Content
                const col4 = item.role === 'doctor'
                    ? `<div class="flex items-center gap-1"><i data-lucide="activity" width="14" class="text-slate-500"></i> ${item.experience}</div>`
                    : `<div class="flex items-center gap-1"><i data-lucide="stethoscope" width="14" class="text-slate-500"></i> ${item.doctor}</div>`;

                tr.innerHTML = `
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-slate-500 font-mono text-xs">#${item.id}</span>
                                <span class="text-[10px] uppercase font-bold mt-1 ${roleColor}">
                                    ${item.role === 'doctor' ? 'Лікар' : 'Пацієнт'}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shadow-lg text-white ${avatarClass}">
                                    ${item.name.charAt(0)}
                                </div>
                                <span class="font-medium text-slate-200">${item.name}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-400 text-sm">${col3}</td>
                        <td class="px-6 py-4 text-slate-400 text-sm">${col4}</td>
                        <td class="px-6 py-4">${getStatusBadge(item.status)}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                <button onclick="editItem(${item.id}, '${item.role}')" class="p-2 text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition-colors">
                                    <i data-lucide="edit-2" width="16"></i>
                                </button>
                                <button onclick="deleteItem(${item.id}, '${item.role}')" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" width="16"></i>
                                </button>
                            </div>
                        </td>
                    `;
                tbody.appendChild(tr);
            });
            lucide.createIcons();
        }
    }

    function getStatusBadge(status) {
        const styles = {
            'Активний': 'bg-green-500/10 text-green-400 border-green-500/20',
            'На зміні': 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            'У відпустці': 'bg-orange-500/10 text-orange-400 border-orange-500/20',
            'Стабільний': 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            'Лікування': 'bg-purple-500/10 text-purple-400 border-purple-500/20',
            'Реабілітація': 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
            'Обстеження': 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
        };
        const style = styles[status] || 'bg-slate-800 text-slate-400';
        return `<span class="px-3 py-1 rounded-full text-xs font-medium border ${style}">${status}</span>`;
    }

    // --- Modal & Form Logic ---
    function openModal(isEdit = false) {
        const backdrop = document.getElementById('modal-backdrop');
        const content = document.getElementById('modal-content');

        backdrop.classList.remove('hidden');
        // Trigger reflow
        void backdrop.offsetWidth;
        backdrop.classList.remove('opacity-0');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');

        if (!isEdit) {
            // Default create state: set role based on active tab
            setFormRole(activeTab === 'doctors' ? 'doctor' : 'patient');
            document.getElementById('data-form').reset();
            document.getElementById('edit-id').value = '';
            document.getElementById('modal-title').innerText = 'Створити профіль';
        }
        updateDoctorSelect();
    }

    function closeModal() {
        const backdrop = document.getElementById('modal-backdrop');
        const content = document.getElementById('modal-content');

        backdrop.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 300);
    }

    function setFormRole(role) {
        modalRole = role;
        const btnDoc = document.getElementById('btn-role-doctor');
        const btnPat = document.getElementById('btn-role-patient');
        const fieldsDoc = document.getElementById('fields-doctor');
        const fieldsPat = document.getElementById('fields-patient');
        const btnSave = document.getElementById('btn-save');

        // Reset Fields Visibility
        if (role === 'doctor') {
            // UI Toggles
            btnDoc.className = "flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium transition-all bg-blue-600 text-white shadow-lg shadow-blue-900/50";
            btnPat.className = "flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium transition-all bg-slate-800 text-slate-400 hover:bg-slate-700";

            fieldsDoc.classList.remove('hidden');
            fieldsPat.classList.add('hidden');

            btnSave.classList.remove('bg-emerald-600', 'hover:bg-emerald-500', 'shadow-emerald-900/40');
            btnSave.classList.add('bg-blue-600', 'hover:bg-blue-500', 'shadow-blue-900/40');

            populateStatusOptions(['Активний', 'На зміні', 'У відпустці']);
        } else {
            // UI Toggles
            btnDoc.className = "flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium transition-all bg-slate-800 text-slate-400 hover:bg-slate-700";
            btnPat.className = "flex-1 flex items-center justify-center gap-2 py-2 rounded-lg text-sm font-medium transition-all bg-emerald-600 text-white shadow-lg shadow-emerald-900/50";

            fieldsDoc.classList.add('hidden');
            fieldsPat.classList.remove('hidden');

            btnSave.classList.remove('bg-blue-600', 'hover:bg-blue-500', 'shadow-blue-900/40');
            btnSave.classList.add('bg-emerald-600', 'hover:bg-emerald-500', 'shadow-emerald-900/40');

            populateStatusOptions(['Обстеження', 'Лікування', 'Стабільний', 'Реабілітація']);
        }
    }

    function populateStatusOptions(options) {
        const select = document.getElementById('field-status');
        const currentVal = select.value;
        select.innerHTML = '';
        options.forEach(opt => {
            const el = document.createElement('option');
            el.value = opt;
            el.innerText = opt;
            select.appendChild(el);
        });
        // Try to keep value if valid
        if (options.includes(currentVal)) select.value = currentVal;
    }

    function updateDoctorSelect() {
        const select = document.getElementById('field-doctor-link');
        select.innerHTML = '<option value="">Оберіть лікаря...</option>';
        doctors.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.name;
            opt.innerText = `${d.name} (${d.specialization})`;
            select.appendChild(opt);
        });
    }

    // --- CRUD Logic ---

    function handleFormSubmit(e) {
        e.preventDefault();
        const editId = document.getElementById('edit-id').value;

        const formData = {
            name: document.getElementById('field-name').value,
            role: modalRole,
            status: document.getElementById('field-status').value,
            // Optional fields based on role
            specialization: modalRole === 'doctor' ? document.getElementById('field-spec').value : undefined,
            experience: modalRole === 'doctor' ? document.getElementById('field-exp').value : undefined,
            diagnosis: modalRole === 'patient' ? document.getElementById('field-diagnosis').value : undefined,
            doctor: modalRole === 'patient' ? document.getElementById('field-doctor-link').value : undefined,
        };

        if (editId) {
            // Update Existing
            const id = parseInt(editId);
            if (modalRole === 'doctor') {
                doctors = doctors.map(d => d.id === id ? { ...d, ...formData } : d);
            } else {
                patients = patients.map(p => p.id === id ? { ...p, ...formData } : p);
            }
            showToast('Дані оновлено успішно');
        } else {
            // Create New
            const newId = Math.floor(Math.random() * 10000);
            if (modalRole === 'doctor') {
                doctors.push({ id: newId, ...formData });
                switchTab('doctors');
            } else {
                patients.push({ id: newId, ...formData });
                switchTab('patients');
            }
            showToast(`Створено нового ${modalRole === 'doctor' ? 'лікаря' : 'пацієнта'}`);
        }

        closeModal();
        renderTable();
    }

    function editItem(id, role) {
        openModal(true);
        document.getElementById('modal-title').innerText = 'Редагувати профіль';
        document.getElementById('edit-id').value = id;
        setFormRole(role);

        // Find Item
        const item = role === 'doctor'
            ? doctors.find(d => d.id === id)
            : patients.find(p => p.id === id);

        if (item) {
            document.getElementById('field-name').value = item.name;
            document.getElementById('field-status').value = item.status;

            if (role === 'doctor') {
                document.getElementById('field-spec').value = item.specialization;
                document.getElementById('field-exp').value = item.experience;
            } else {
                document.getElementById('field-diagnosis').value = item.diagnosis;
                document.getElementById('field-doctor-link').value = item.doctor;
            }
        }
    }

    function deleteItem(id, role) {
        if (confirm('Ви впевнені, що хочете видалити цей запис?')) {
            if (role === 'doctor') {
                doctors = doctors.filter(d => d.id !== id);
            } else {
                patients = patients.filter(p => p.id !== id);
            }
            renderTable();
            showToast('Запис видалено', 'error');
        }
    }

    function showToast(msg, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');

        const colorClass = type === 'error' ? 'bg-red-500' : 'bg-green-500';

        toast.className = 'bg-slate-800 border border-slate-700 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 animate-slide-down pointer-events-auto mb-2';
        toast.innerHTML = `
                <div class="w-2 h-2 rounded-full ${colorClass}"></div>
                <span>${msg}</span>
            `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

</script>
</body>
</html>
