<?php

namespace App\Http\Controllers;

use App\Models\PainRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $imagePath = $image->store('vision','public');
        session()->put('imagePath', $imagePath);

        // Возвращаем ответ с путём сохраненного изображения
//        return redirect()->route('vision')->with('imagePath', $imagePath);
        return response()->json([
            'redirect' => true,
            'url' => route('vision')
        ]);
    }
    public function createPainLevel(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|string', // Если передается base64
            'pain_level' => 'required|string',
            'medications' => 'nullable|string',
            'painIndex' => 'nullable|string',
            'age' => 'nullable|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
            'typePain' => 'nullable|string'
        ]);

        $fileName = null;

        // Проверяем, передано ли изображение в base64
        if (preg_match('/^data:image\/(\w+);base64,/', $request->image, $matches)) {
            $imageType = $matches[1];
            $image = substr($request->image, strpos($request->image, ',') + 1);

            // Заменяем пробелы на "+" (иногда base64 их заменяет)
            $image = str_replace(' ', '+', $image);

            // Декодируем изображение
            $decodedImage = base64_decode($image);

            if ($decodedImage === false) {
                Log::error('Ошибка декодирования base64');
                return response()->json(['error' => 'Invalid base64 image data'], 400);
            }

            // Проверяем, является ли декодированное содержимое изображением
            $finfo = finfo_open();
            $mimeType = finfo_buffer($finfo, $decodedImage, FILEINFO_MIME_TYPE);
            finfo_close($finfo);

            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
                Log::error("Некорректный MIME-тип: $mimeType");
                return response()->json(['error' => 'Unsupported image format'], 400);
            }

            // Генерируем уникальное имя файла
            $fileName = 'images/' . uniqid() . '.' . $imageType;

            // Пробуем сохранить файл (можно заменить Storage на file_put_contents)
            Storage::disk('public')->put($fileName, $decodedImage);
        }
        // Проверяем, передано ли изображение как файл через multipart/form-data
        elseif ($request->hasFile('image') && $request->file('image')->isValid()) {
            $fileName = $request->file('image')->store('images', 'public');
        }
        else {
            Log::error('Неверный формат изображения');
            return response()->json(['error' => 'Invalid image format'], 400);
        }

        // Проверяем, что файл успешно записался
        if (!Storage::disk('public')->exists($fileName)) {
            Log::error("Файл $fileName не был сохранён");
            return response()->json(['error' => 'Failed to save image'], 500);
        }

        // Создаем запись в БД, сохраняя только путь к файлу
        $painRecord = PainRecord::create([
            'image' => $fileName,
            'pain_level' => $validatedData['pain_level'],
            'medications' => $validatedData['medications'] ?? null,
            'painIndex' => $validatedData['painIndex'] ?? null,
            'age' => $validatedData['age'] ?? null,
            'weight' => $validatedData['weight'] ?? null,
            'height' => $validatedData['height'] ?? null,
            'typePain'=>$validatedData['typePain'] ?? null
        ]);

        return response()->json([
            'message' => 'Data saved successfully!',
            'data' => $painRecord
        ]);
    }
    public function getData(Request $request){
        $data = PainRecord::all();

        return response()->json($data);
    }

}
