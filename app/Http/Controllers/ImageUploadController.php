<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        // Валидация загружаемого файла
//        $request->validate([
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Максимальный размер 2MB
//        ]);
        session()->forget('imagePath');
        // Получаем файл из запроса
        $image = $request->file('image');

        // Определяем путь для сохранения
        $imagePath = $image->store('vision', 'public');
        session()->put('imagePath', $imagePath);

        // Возвращаем ответ с путём сохраненного изображения
//        return redirect()->route('vision')->with('imagePath', $imagePath);
        return response()->json([
            'redirect' => true,
            'url' => route('vision')
        ]);
    }
}
