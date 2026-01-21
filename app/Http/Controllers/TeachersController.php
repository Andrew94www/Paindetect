<?php


namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeachersController extends Controller
{
    /**
     *
     * Отображает список всех пользователей.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $department = DB::table('departments')->where('code', $request->input('code'))->first();
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'position'   => 'required|string',
            'totalScore' => 'required|numeric',
        ]);
        // 3. Створення запису
        Rating::create([
            'name'       => $validated['name'],
            'position'   => $validated['position'],
            'totalScore' => $validated['totalScore'],
            'department' =>$department->name,
            'code'       => $department->code,
            'data'       => [],
        ]);

        // 4. Редирект назад із повідомленням
        return redirect()->back()->with('success', 'Викладача успішно додано до рейтингу!');
    }

    public function edit(Request $request, $id)
    {
        // 1. Валідація вхідних даних
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'position'   => 'required|string',
            'totalScore' => 'required|numeric',
        ]);

        // 2. Пошук запису (якщо не знайдено — поверне 404)
        $rating = Rating::findOrFail($id);

        // 3. Оновлення даних
        $rating->update([
            'name'       => $validated['name'],
            'position'   => $validated['position'],
            'totalScore' => $validated['totalScore'],
            // department та code зазвичай не змінюються при редагуванні,
            // але якщо потрібно — додайте їх сюди
        ]);

        // 4. Повернення назад із повідомленням про успіх
        return redirect()->back()->with('success', 'Дані викладача успішно оновлено!');
    }

    public function deletion($id)
    {
        // 1. Пошук запису (findOrFail автоматично видасть 404, якщо ID невірний)
        $rating = Rating::findOrFail($id);

        // 2. Видалення запису з бази даних
        $rating->delete();

        // 3. Редирект назад із флеш-повідомленням про успіх
        return redirect()->back()->with('success', 'Викладача успішно видалено з рейтингу!');
    }

}

