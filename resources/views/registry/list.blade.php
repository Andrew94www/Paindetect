<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пацієнтів</title>
    <!-- Підключаємо Tailwind CSS через CDN для стилізації -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen text-gray-200 antialiased font-sans">

<div class="container mx-auto px-4 sm:px-8 max-w-7xl">
    <div class="py-8">
        <!-- Верхня панель: Заголовок і Кнопки -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 bg-gray-800 p-4 rounded-lg shadow-md border border-gray-700">
            <h2 class="text-2xl font-bold leading-tight text-white">
                Список пацієнтів
            </h2>

            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full md:w-auto">
                <!-- Кнопка 2: Статистика по госпіталю -->
                <a href="{{ route('registry.statistics', ['id' => Auth::guard('hospital')->id()]) }}"
                   class="inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Статистика по госпіталю
                </a>

                <!-- Кнопка 1: Додати пацієнта -->
                <a href="{{ route('registry.getFormData') }}"
                   class="inline-flex justify-center items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Додати пацієнта
                </a>
            </div>
        </div>

        <!-- Таблиця пацієнтів -->
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow-md rounded-xl overflow-hidden border border-gray-700 bg-gray-800">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr class="bg-gray-900/50">
                        <th class="px-5 py-4 border-b-2 border-gray-700 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            ПІБ (ФИО)
                        </th>
                        <th class="px-5 py-4 border-b-2 border-gray-700 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            Ризик тривалої реабілітації
                        </th>
                        <th class="px-5 py-4 border-b-2 border-gray-700 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                            Ризик хронічного болю (CPRS)
                        </th>
                        <th class="px-5 py-4 border-b-2 border-gray-700 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">
                            Екшени (Дії)
                        </th>
                    </tr>
                    </thead>
                    <tbody id="patients-table-body">
                    @forelse($records as $record)
                        @php
                            // Обробка поля scores (захист на випадок, якщо Laravel не зробив cast автоматично)
                            $scoresStr = $record->scores;
                            $scores = is_string($scoresStr) ? json_decode($scoresStr, true) : (array)$scoresStr;

                            $rehabScore = $scores['rehabScore'] ?? 0;
                            $painScore = $scores['painScore'] ?? 0;

                            // Функції для визначення тексту та кольору бейджа
                            $getRiskLabel = function($score) {
                                if ($score >= 7) return "Високий ($score/10)";
                                if ($score >= 4) return "Середній ($score/10)";
                                return "Низький ($score/10)";
                            };

                            $getRiskBadgeClass = function($score) {
                                if ($score >= 7) return 'bg-red-900/30 text-red-300 border-red-800/50';
                                if ($score >= 4) return 'bg-yellow-900/30 text-yellow-300 border-yellow-800/50';
                                return 'bg-green-900/30 text-green-300 border-green-800/50';
                            };

                            // Обробка пустого імені (null fallback)
                            if (!empty($record->name)) {
                                $name = $record->name;
                            } elseif (!empty($record->history_id)) {
                                $name = "Історія #" . $record->history_id;
                            } else {
                                $name = "Пацієнт ID: " . $record->id;
                            }

                            $initial = mb_substr($name, 0, 1);
                        @endphp

                        <tr id="patient-row-{{ $record->id }}" class="hover:bg-gray-700/50 transition-colors duration-150 group">
                            <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-900/50 border border-indigo-700 flex items-center justify-center text-indigo-300 font-bold mr-3">
                                        {{ mb_strtoupper($initial) }}
                                    </div>
                                    <div class="font-medium text-gray-200">
                                        {{ $name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $getRiskBadgeClass($rehabScore) }}">
                                            {{ $getRiskLabel($rehabScore) }}
                                        </span>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $getRiskBadgeClass($painScore) }}">
                                            {{ $getRiskLabel($painScore) }}
                                        </span>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-700 bg-gray-800 text-sm">
                                <div class="flex items-center justify-center space-x-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <!-- Переглянути -->
                                    <button onclick="viewPatient({{ $record->id }}, '{{ addslashes($name) }}')" class="p-1.5 text-green-400 hover:text-green-300 hover:bg-green-900/50 rounded-md transition-colors" title="Переглянути">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <!-- Редагувати -->
                                    <button onclick="editPatient({{ $record->id }}, '{{ addslashes($name) }}')" class="p-1.5 text-blue-400 hover:text-blue-300 hover:bg-blue-900/50 rounded-md transition-colors" title="Редагувати">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <!-- Видалити -->
                                    <button onclick="openDeleteModal({{ $record->id }})" class="p-1.5 text-red-400 hover:text-red-300 hover:bg-red-900/50 rounded-md transition-colors" title="Видалити">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 border-b border-gray-700 bg-gray-800 text-sm text-center text-gray-500">
                                Немає даних про пацієнтів. Натисніть "Додати пацієнта", щоб почати.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Пагінація (за наявності) -->
        @if(method_exists($records, 'links'))
            <div class="mt-4">
                {{ $records->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Модальне вікно підтвердження видалення -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Фон -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-80 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Контент модального вікна -->
        <div class="inline-block align-bottom bg-gray-800 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-700">
            <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10 border border-red-800/50">
                        <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Видалити пацієнта
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-400">
                                Ви дійсно хочете видалити цього пацієнта? Цю дію неможливо скасувати. Дані будуть назавжди видалені з системи.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="confirmDelete()" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                    Видалити
                </button>
                <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                    Скасувати
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast сповіщення -->
<div id="toast" class="fixed bottom-5 right-5 transform translate-y-20 opacity-0 transition-all duration-300 bg-gray-700 border border-gray-600 text-white px-6 py-3 rounded-lg shadow-xl z-50 flex items-center">
    <span id="toast-message">Повідомлення</span>
</div>

<script>
    // Зберігаємо ID пацієнта для видалення
    let patientToDeleteId = null;

    function openDeleteModal(id) {
        patientToDeleteId = id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        patientToDeleteId = null;
        document.getElementById('delete-modal').classList.add('hidden');
    }

    function confirmDelete() {
        if (patientToDeleteId !== null) {
            // В реальному Laravel проєкті тут можна зробити форму або fetch-запит:
            // fetch(`/registry/${patientToDeleteId}`, { method: 'DELETE', headers: {'X-CSRF-TOKEN': '...'}} );

            // Для візуальної імітації видаляємо рядок з DOM:
            const row = document.getElementById(`patient-row-${patientToDeleteId}`);
            if (row) row.remove();

            closeDeleteModal();
            showNotification('Пацієнта успішно видалено');
        }
    }

    // Логіка кнопок-заглушок
    function viewPatient(id, name) {
        // Щоб перенаправити на роут: window.location.href = `/registry/${id}`;
        showNotification(`Перегляд інформації про пацієнта: ${name}`);
    }

    function editPatient(id, name) {
        // Щоб перенаправити на роут: window.location.href = `/registry/${id}/edit`;
        showNotification(`Редагування пацієнта: ${name}`);
    }

    // Функція для показу красивих сповіщень внизу екрану
    let toastTimeout;
    function showNotification(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        clearTimeout(toastTimeout);

        toastMessage.textContent = message;
        toast.classList.remove('translate-y-20', 'opacity-0');

        toastTimeout = setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }
</script>
</body>
</html>
