<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('contact_id')->default('-');
            $table->string('neu_now')->default('0');
            $table->string('neu_after_15_day')->default('0');
            $table->string('neu_after_30_day')->default('0');
            $table->string('date_create')->default(time());

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient');
    }
}
