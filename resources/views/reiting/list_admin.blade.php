<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рейтинг викладачів | Звіт</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- ОСНОВНІ СТИЛІ (ЕКРАН) --- */
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; }
        .glass-card { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .modal-show { opacity: 1 !important; transform: scale(1) !important; }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-fade-in { animation: slideIn 0.4s ease-out forwards; }

        .print-only { display: none; }

        /* --- СТИЛІ ДЛЯ ДРУКУ (PDF) --- */
        @media print {
            @page {
                margin: 10mm;
                size: A4;
            }

            body {
                background-color: white !important;
                color: black !important;
                padding: 0 !important;
                zoom: 95%; /* Трохи зменшуємо масштаб, щоб все влізло */
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Ховаємо все зайве */
            .no-print, button, #alerts-container, .modal, form.delete-form {
                display: none !important;
            }

            /* Скидаємо стилі карток */
            .glass-card {
                background: none !important;
                border: none !important;
                backdrop-filter: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                display: block !important;
            }

            .overflow-x-auto { overflow: visible !important; display: block !important; }

            /* --- ТАБЛИЦЯ ДЛЯ ДРУКУ --- */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
                border: 1px solid #000 !important;
                font-size: 11pt !important;
                table-layout: fixed; /* Фіксуємо ширину колонок */
            }

            th, td {
                border: 1px solid #000 !important;
                color: #000 !important;
                padding: 4px 8px !important;
                text-align: left !important;
                vertical-align: middle;
            }

            /* Налаштування ширини колонок */
            th:nth-child(1) { width: 5%; text-align: center; } /* № */
            th:nth-child(2) { width: 55%; } /* ПІБ - найширша */
            th:nth-child(3) { width: 25%; } /* Посада */
            th:nth-child(4) { width: 15%; text-align: right; } /* Бал */

            th {
                background-color: #f0f0f0 !important;
                font-weight: bold !important;
                text-transform: uppercase;
                text-align: center !important;
            }

            /* ВИПРАВЛЕННЯ ЧОРНИХ ПЛЯМ (БЕЙДЖІВ) */
            /* Цей стиль примусово робить фон прозорим */
            .position-badge {
                background-color: transparent !important;
                background: transparent !important;
                color: black !important;
                border: none !important;
                padding: 0 !important;
                font-weight: normal !important;
            }

            th:last-child, td:last-child { display: none !important; }

            tr { page-break-inside: avoid; break-inside: avoid; }
            thead { display: table-header-group; }

            /* Шапка та підвал */
            .print-only { display: block !important; }

            h1 { color: black !important; font-size: 16pt !important; text-align: center; margin: 0 0 5px 0; }
            h2 { color: #333 !important; font-size: 10pt !important; text-align: center; margin: 0; text-transform: uppercase; }
            p.report-meta { color: #444 !important; text-align: center; margin-bottom: 25px; font-size: 10pt !important; border-bottom: 2px solid black; padding-bottom: 15px; }

            .signatures {
                display: flex !important;
                justify-content: space-between;
                margin-top: 50px;
                page-break-inside: avoid;
            }
            .signature-box { width: 40%; }
            .signature-line { border-bottom: 1px solid #000; margin-top: 40px; margin-bottom: 5px; }
            .signature-label { font-size: 8pt; text-align: center; color: #555; display: block; }
        }
    </style>
</head>
<body class="text-slate-200 min-h-screen py-8 px-4 sm:px-6">

<div class="max-w-6xl mx-auto">

    <div id="alerts-container" class="fixed top-5 right-5 z-[100] w-full max-w-sm space-y-3 no-print">
        @if(session('success'))
            <div id="alert-success" class="glass-card animate-fade-in flex items-center justify-between p-4 rounded-xl border-emerald-500/50 text-emerald-400 shadow-2xl">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <button onclick="closeAlert('alert-success')" class="text-slate-400 hover:text-white transition-colors ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div id="alert-error" class="glass-card animate-fade-in p-4 rounded-xl border-red-500/50 text-red-400 shadow-2xl">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <ul class="text-xs list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 no-print">
        <button onclick="window.history.back()" class="group inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 border border-slate-600 rounded-xl transition-all shadow-lg active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Назад
        </button>

        <div class="flex gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold transition-all shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Зберегти PDF
            </button>

            <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold transition-all shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Додати
            </button>
        </div>
    </div>

    <div class="mb-8">
        <div class="print-only mb-4">
            <h2>Вінницький національний медичний університет ім. М.І Пирогова</h2>
            <h1>ЗВІТ: РЕЙТИНГ ВИКЛАДАЧІВ</h1>
            <p class="report-meta">Кафедра анатомії людини | Станом на {{ date('d.m.Y') }}</p>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 no-print">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Рейтинг викладачів</h1>
                <p class="text-slate-400 mt-1">Кафедра анатомії людини</p>
            </div>
            <div class="flex items-center gap-3 bg-slate-800/50 p-1 rounded-lg border border-slate-700">
                <span class="px-4 py-2 text-sm font-medium text-blue-400">Всього записів: <span id="total-count">{{ isset($reitingsList) ? count($reitingsList) : 0 }}</span></span>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="border-b border-slate-700/50 bg-slate-800/30">
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">№</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">ПІБ</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Посада</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400 text-right">Бал</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400 text-center no-print">Дії</th>
                </tr>
                </thead>
                <tbody id="data-table-body" class="divide-y divide-slate-700/50">
                @isset($reitingsList)
                    @foreach ($reitingsList as $index => $item)
                        <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-slate-500 font-medium text-center">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-white font-semibold text-black">{{ $item->name ?? 'Невідомо' }}</td>
                            <td class="px-6 py-4">
                                <span class="position-badge px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-slate-300 border border-slate-600">{{ $item->position ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right text-emerald-400 font-bold text-black">{{ number_format($item->totalScore ?? 0, 0, ',', ' ') }}</td>
                            <td class="px-6 py-4 text-center no-print">
                                <div class="flex items-center justify-center gap-2">

                                    <a href="/view/teachers/{{ $item->id }}" class="p-2 text-slate-400 hover:text-indigo-400 transition-all" title="Переглянути деталі">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <button onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->name) }}', '{{ $item->position }}', '{{ $item->totalScore }}')" class="p-2 text-slate-400 hover:text-blue-400 transition-all" title="Редагувати">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </button>

                                    <form action="/deletion/teachers/{{ $item->id }}" method="POST" class="delete-form inline">
                                        @csrf
                                        <button type="button" onclick="confirmDeletion(this.closest('form'))" class="p-2 text-slate-400 hover:text-red-400 transition-all" title="Видалити">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endisset
                </tbody>
            </table>
        </div>
    </div>

    <div class="print-only signatures">
        <div class="signature-box text-left">
            <p class="font-bold text-black">Завідувач кафедри</p>
            <div class="signature-line"></div>
            <span class="signature-label">(підпис, ПІБ)</span>
        </div>
        <div class="signature-box text-right">
            <p class="font-bold text-black">Ректор</p>
            <div class="signature-line"></div>
            <span class="signature-label">(підпис, ПІБ)</span>
        </div>
    </div>

    <div class="mt-6 text-center text-slate-500 text-sm no-print">Дані оновлено: <span id="current-date"></span></div>
</div>

<div id="teacher-modal" class="no-print fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden opacity-0 items-center justify-center p-4 transition-all duration-300">
    <div class="glass-card w-full max-w-lg rounded-2xl shadow-2xl transform scale-95 transition-all duration-300">
        <div class="px-6 py-4 border-b border-white/10 flex justify-between items-center bg-white/5 rounded-t-2xl">
            <h3 id="modal-title" class="text-xl font-bold text-white">Додати викладача</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <form id="teacher-form" method="POST" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <div>
                <label class="block text-sm font-medium text-slate-400 mb-1.5">ПІБ Викладача</label>
                <input type="text" name="name" id="field-name" required class="w-full bg-slate-800/50 border border-slate-600 rounded-xl px-4 py-2.5 text-white outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-400 mb-1.5">Посада</label>
                <select name="position" id="field-position" class="w-full bg-slate-800/50 border border-slate-600 rounded-xl px-4 py-2.5 text-white outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                    <option value="Професор">Професор</option>
                    <option value="Доцент">Доцент</option>
                    <option value="Старший викладач">Старший викладач</option>
                    <option value="Асистент">Асистент</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-400 mb-1.5">Загальний бал</label>
                <input type="number" name="totalScore" id="field-score" value="0" class="w-full bg-slate-800/50 border border-slate-600 rounded-xl px-4 py-2.5 text-white outline-none focus:ring-2 focus:ring-blue-500/50 transition-all">
                <input type="hidden" name="code" value="{{$code ?? ''}}">
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-600 text-slate-300 hover:bg-slate-800 transition-colors">Скасувати</button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition-all shadow-lg shadow-blue-900/20">Зберегти</button>
            </div>
        </form>
    </div>
</div>

<div id="confirm-modal" class="no-print fixed inset-0 bg-slate-950/90 backdrop-blur-md z-[60] hidden opacity-0 items-center justify-center p-4 transition-all duration-300">
    <div class="glass-card max-w-sm w-full rounded-2xl p-6 text-center transform scale-95 transition-all duration-300">
        <div class="w-16 h-16 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Ви впевнені?</h3>
        <p class="text-slate-400 mb-6">Видалення неможливо скасувати.</p>
        <div class="flex gap-3">
            <button onclick="closeConfirm()" class="flex-1 px-4 py-2.5 rounded-xl bg-slate-800 text-slate-300 hover:bg-slate-700 transition-colors">Ні</button>
            <button id="confirm-yes-btn" class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold shadow-lg shadow-red-900/40 transition-all">Видалити</button>
        </div>
    </div>
</div>

<script>
    const teacherModal = document.getElementById('teacher-modal');
    const confirmModal = document.getElementById('confirm-modal');
    let deleteTargetForm = null;

    function openCreateModal() {
        const form = document.getElementById('teacher-form');
        form.action = '/create/teacher';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('modal-title').innerText = 'Додати викладача';
        form.reset();
        toggleModalVisibility(teacherModal, true);
    }

    function openEditModal(id, name, position, score) {
        const form = document.getElementById('teacher-form');
        form.action = `/edit/teachers/${id}`;
        document.getElementById('form-method').value = 'POST';
        document.getElementById('modal-title').innerText = 'Редагувати дані';
        document.getElementById('field-name').value = name;
        document.getElementById('field-position').value = position;
        document.getElementById('field-score').value = score;
        toggleModalVisibility(teacherModal, true);
    }

    function confirmDeletion(form) {
        deleteTargetForm = form;
        toggleModalVisibility(confirmModal, true);
    }

    document.getElementById('confirm-yes-btn').onclick = () => {
        if(deleteTargetForm) deleteTargetForm.submit();
    };

    function closeAlert(id) {
        const alert = document.getElementById(id);
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(20px)';
            setTimeout(() => alert.remove(), 500);
        }
    }

    function closeModal() { toggleModalVisibility(teacherModal, false); }
    function closeConfirm() { toggleModalVisibility(confirmModal, false); }

    function toggleModalVisibility(m, show) {
        if(!m) return;
        const card = m.querySelector('.glass-card');
        if (show) {
            m.classList.remove('hidden');
            m.classList.add('flex');
            setTimeout(() => {
                m.classList.add('opacity-100');
                card.classList.add('modal-show');
            }, 10);
        } else {
            m.classList.remove('opacity-100');
            card.classList.remove('modal-show');
            setTimeout(() => {
                m.classList.add('hidden');
                m.classList.remove('flex');
            }, 300);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dateEl = document.getElementById('current-date');
        if(dateEl) dateEl.textContent = new Date().toLocaleDateString('uk-UA');

        const successAlert = document.getElementById('alert-success');
        if (successAlert) {
            setTimeout(() => closeAlert('alert-success'), 5000);
        }
    });

    window.onclick = (e) => {
        if (e.target == teacherModal) closeModal();
        if (e.target == confirmModal) closeConfirm();
    };
</script>

</body>
</html>
