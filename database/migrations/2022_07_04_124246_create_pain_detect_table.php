<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePainDetectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pain_detect', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('questions1')->default('1');
            $table->string('questions2')->default('1');
            $table->string('questions3')->default('1');
            $table->string('imaga')->default('0');
            $table->string('questions11')->default('1');
            $table->string('questions4')->default('0');
            $table->string('questions5')->default('0');
            $table->string('questions6')->default('0');
            $table->string('questions7')->default('0');
            $table->string('questions8')->default('0');
            $table->string('questions9')->default('0');
            $table->string('questions10')->default('0');
            $table->string('result')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pain_detect');
    }
}
