<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_index', function (Blueprint $table) {
            $table->id();
            $table->string('createPatient')->default(time());
            $table->string('date')->default('-');
            $table->string('name')->default('-');
            $table->string('id_patient')->default('-');
            $table->string('contact_id')->default('-');
            $table->string('noc_now')->default('0');
            $table->string('noc_after_15_day')->default('0');
            $table->string('noc_after_30_day')->default('0');
            $table->string('ish_now')->default('0');
            $table->string('ish_after_15_day')->default('0');
            $table->string('ish_after_30_day')->default('0');
            $table->string('neu_now')->default('0');
            $table->string('neu_after_15_day')->default('0');
            $table->string('neu_after_30_day')->default('0');
            $table->string('cen_now')->default('0');
            $table->string('cen_after_15_day')->default('0');
            $table->string('cen_after_30_day')->default('0');
            $table->string('dez_now')->default('0');
            $table->string('dez_after_15_day')->default('0');
            $table->string('dez_after_30_day')->default('0');
            $table->string('dis_now')->default('0');
            $table->string('dis_after_15_day')->default('0');
            $table->string('dis_after_30_day')->default('0');
            $table->longText('treatment');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_index');
    }
}
