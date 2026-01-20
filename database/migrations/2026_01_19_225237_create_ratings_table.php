<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ФИО или название');
            $table->string('position')->comment('Должность');
            $table->string('code')->comment('Уникальный код/идентификатор');
            $table->string('totalScore')->comment('Общий балл');
            $table->string('department')->comment('Кафедра');
            $table->json('data')->comment('Дополнительные данные в формате JSON');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
