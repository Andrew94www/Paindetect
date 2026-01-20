<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Первичный ключ (ID)

            // 1) Название кафедры
            $table->string('name')->comment('Название кафедры');

            // 2) Ключ (например, аббревиатура или уникальный код)
            $table->string('code')->unique()->comment('Уникальный ключ/код кафедры');

            // 3) Ключ код доступа
            $table->string('access_code')->unique()->comment('Код доступа');

            $table->timestamps(); // Поля created_at и updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
}
