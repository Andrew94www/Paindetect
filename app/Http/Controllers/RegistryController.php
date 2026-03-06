<?php


namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistryController extends Controller
{
   public function index(){
       return view('registry.index');
   }
    public function registrationForm()
    {
        return view('registry.reg_form');
    }
    /**
     * Показать форму ввода кода доступа (Промежуточная страница)
     */
    public function entrance(Request $request )
    {
        return view('registry.ent_form');

    }

    public function getFormData( )
    {
        return view('registry.cre_form');

    }

    public function getStatistics($id)
    {
        $hospital = Hospital::findOrFail($id); // Используйте findOrFail, чтобы не упасть на пустом госпитале
        $records = $hospital->records;

        if ($records->isEmpty()) {
            // Логика, если записей НЕТ
            return view('registry.not_stat');
        }

        return view('registry.stastic', compact('records', 'id'));

    }

    public function list($id)
    {
        $hospital = Hospital::find($id);
        $records = $hospital->records;
        return view('registry.list', compact('records'));

    }

    public function entranceUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Пытаемся авторизовать пользователя через guard 'hospital'
        if (Auth::guard('hospital')->attempt($credentials, $request->remember)) {
            // Регенерируем сессию для защиты от фиксации сессий
            $request->session()->regenerate();

            $hospital = Auth::guard('hospital')->user();

            // 2. Получаем все его записи (коллекция моделей PatientRecord)
            $records = $hospital->records;


//            return redirect()->route('registry.getFormData');

            return view('registry.list', compact('records'));

        }

        return back()->withErrors([
            'email' => 'Ошибка входа для медицинского учреждения.',
        ])->onlyInput('email');
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'hospital_name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals',
            'password' => 'required|min:3',
        ]);

        // 1. Создаем запись в базе данных
        $hospital = Hospital::create([
            'hospital_name' => $validated['hospital_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 2. ВАЖНО: Автоматически логиним пользователя сразу после создания,
        // чтобы ID сохранился в сессии и был доступен после редиректа.
        Auth::guard('hospital')->login($hospital);

        return view('registry.sacces');

//        return redirect()->route('registry.getFormData');
    }

    public function createData(Request $request )
    {
        // 1. Валидация входящих данных
        $validated = $request->validate([
            'patient_data' => 'required|array',
            'icd_codes' => 'required|array',
            'prosthetics_data'=> 'required|array',
            'predictors' => 'required|array',
            'scores' => 'required|array',
            // Мы не валидируем hospital_id из запроса,
            // так как возьмем его из сессии для безопасности.
        ]);

        // 2. Сохранение через связь текущего госпиталя
        // Это автоматически заполнит поле hospital_id
        $hospital = Auth::guard('hospital')->user();

        $record = $hospital->records()->create([
            'patient_data'=>$validated['patient_data'],
            'history_id'=>$validated['patient_data']['history_id'],
            'icd_codes'  => $validated['icd_codes'],
            'prosthetics_data'=> $validated['prosthetics_data'],
            'predictors' => $validated['predictors'],
            'scores'     => $validated['scores'],
        ]);

        // 3. Ответ для фронтенда
        return response()->json([
            'success' => true,
            'message' => 'Запис успішно збережено',
            'record_id' => $record->id
        ], 201);

    }

    }

