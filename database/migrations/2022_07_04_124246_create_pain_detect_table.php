<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('data_create')->default(time());
            $table->string('contact_id')->default('-');
            $table->string('neu_now')->default('0');
            $table->string('neu_after_15_day')->default('0');
            $table->string('neu_after_30_day')->default('0');
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
        Schema::dropIfExists('pain_detect');
    }
}
