<?php

namespace App\Http\Controllers;



use App\Models\Drawing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class ManController extends Controller
{



    public function getMan(){
        return view('man');
    }

    public function getManVision(){
        $imagePath = session('imagePath');
        return view('vis',['imagePath'=>$imagePath]);
    }
    public function getForm(){
        return view('form');
    }


    public function saveImage(Request $request)
    {
        // Получение данных из запроса
        $imageData = $request->input('image');
        $filledAreas = $request->input('filledAreas');

        // Декодирование изображения из base64
        $image = str_replace('data:image/png;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = uniqid() . '.png';

        // Сохранение изображения в storage/app/public/images
        Storage::put('public/images/' . $imageName, base64_decode($image));

        // Сохранение данных в базе данных
        $drawing = new Drawing();
        $drawing->image_path = 'images/' . $imageName;
        $drawing->filled_areas = json_encode($filledAreas);
        $drawing->save();

        return response()->json(['success' => true, 'image' => $imageName]);
    }


}
