<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('patient_records', function (Blueprint $table) {
            $table->id();

            // Создает колонку hospital_id и вешает на нее внешний ключ
            // constrained() автоматически поймет, что таблица называется 'hospitals'
            // cascadeOnDelete() удалит записи пациента, если госпиталь будет удален
            $table->foreignId('hospital_id')->constrained('hospitals')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('age')->nullable();
            $table->string('history_id')->nullable();
            $table->json('icd_codes')->nullable();
            $table->json('predictors')->nullable();
            $table->json('scores')->nullable();
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
        Schema::dropIfExists('patient_records');
    }
}
