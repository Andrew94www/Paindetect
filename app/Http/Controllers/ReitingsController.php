<?php


namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReitingsController extends Controller
{
    /**
     *
     * Отображает список всех пользователей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('reiting.index');
    }
    /**
     * Показать форму ввода кода доступа (Промежуточная страница)
     */
    public function showUnlockForm($code)
    {
        // Ищем кафедру, чтобы вывести её название на странице
        $department = DB::table('departments')->where('code', $code)->first();
        return view('reiting.unlock', compact('department'));
    }
    /**
     * Проверить введенный код
     */
    public function verifyCode(Request $request, $code)
    {
        // 1. Валидация входящих данных
        $request->validate([
            'access_code' => 'required',
        ]);

        // 2. Получаем кафедру из БД
        $department = DB::table('departments')->where('code', $code)->first();

        // 3. Сверяем введенный код с кодом из БД
        if ($request->access_code === $department->access_code) {

            // Записываем в сессию флаг доступа именно для ЭТОЙ кафедры
            session([
                "access_granted_{$code}" => true,
                "access_expires_{$code}" => now()->addMinutes(120)->timestamp
            ]);

            // Перенаправляем на саму страницу кафедры
            return redirect()->route('departments.show', $code);
        }

        // 4. Если код неверный, возвращаем обратно с ошибкой
        return back()->withErrors(['access_code' => 'Невірний код доступу для цієї кафедри.']);
    }
    public function show($code){
        return view('reiting.reiting_forms',['code'=>$code]);
    }

    public function create(Request $request){
        // 1. Валидация (рекомендуется)
        $validated = $request->validate([
            'personal.name' => 'required|string',
            'personal.position' => 'required|string',
            'code' => 'required|string',
            'totalScore' => 'required',
        ]);

        // 2. Создание записи в базе данных
        try {
            $department = DB::table('departments')->where('code', $request->input('code'))->first();
            $rating = Rating::create([
                'name'        => $request->input('personal.name'),      // Из вложенного массива personal
                'position'    => $request->input('personal.position'),  // Из вложенного массива personal
                'code'        => $request->input('code'),              // Прямой ключ из корня
                'totalScore'  => (string) $request->input('totalScore'),// Приводим к строке, как в миграции
                'department'  => $department->name, // Если department нет в массиве
                'data'        => $request->all(),              // Весь массив items уйдет в JSON
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Рейтинг успішно збережено!',
                'id' => $rating->id
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Помилка при збереженні: ' . $e->getMessage()
            ], 500);
        }
    }

    public function list($code){
        $reitingsList = DB::table('ratings')->where('code', $code)->get();
        $department =DB::table('departments')->where('code', $code)->first();
        return view('reiting.list',['reitingsList'=>$reitingsList,'department'=>$department->name]);
    }

    public function indexAdmin(){
        return view('reiting.index_admin');
    }

    public function listForAdmin($code){
        $reitingsList = DB::table('ratings')->where('code', $code)->get();
        return view('reiting.list_admin',['reitingsList'=>$reitingsList,'code'=>$code]);
    }

}

