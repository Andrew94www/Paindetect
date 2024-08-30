<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class DatabaseController extends Controller
{
    public function downloadDatabasePdf()
    {
        $fileName = 'database_dump.pdf';

        // Имя пользователя базы данных
        $dbUser = 'root';

        // Пароль пользователя базы данных
        $dbPass = '';

        // Имя базы данных
        $dbName = 'paindetect';

        // Команда для создания дампа базы данных
        $command = "mysqldump -u {$dbUser} -p{$dbPass} {$dbName} > {$fileName}";

        // Выполнение команды в командной строке
        exec($command);

        // Скачивание файла
        return response()->download($fileName);
    }
}
