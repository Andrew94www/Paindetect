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
            $table->timestamps();
            $table->string('date')->default('-');
            $table->string('name')->default('-');
            $table->string('id_patient')->default('-');
            $table->string('contact_id')->default('-');
            $table->string('questions1')->default('false');
            $table->string('questions2')->default('false');
            $table->string('questions3')->default('false');
            $table->string('questions4')->default('false');
            $table->string('questions5')->default('false');
            $table->string('questions6')->default('false');
            $table->string('questions7')->default('false');
            $table->string('questions8')->default('false');
            $table->string('questions9')->default('false');
            $table->string('questions10')->default('false');
            $table->string('questions11')->default('false');
            $table->string('questions12')->default('false');
            $table->string('questions13')->default('false');
            $table->string('questions14')->default('false');
            $table->string('questions15')->default('false');
            $table->string('questions16')->default('false');
            $table->string('questions17')->default('false');
            $table->string('questions18')->default('false');
            $table->string('questions19')->default('false');
            $table->string('questions20')->default('false');
            $table->string('questions21')->default('false');
            $table->string('questions22')->default('false');
            $table->string('questions23')->default('false');
            $table->string('questions24')->default('false');
            $table->string('questions25')->default('false');
            $table->string('questions26')->default('false');
            $table->string('questions27')->default('false');
            $table->string('questions28')->default('false');
            $table->string('questions29')->default('false');
            $table->string('questions30')->default('false');
            $table->string('questions31')->default('false');
            $table->string('questions32')->default('false');
            $table->string('questions33')->default('false');
            $table->string('questions34')->default('false');
            $table->string('questions35')->default('false');
            $table->string('questions36')->default('false');
            $table->string('questions37')->default('false');
            $table->string('questions38')->default('false');
            $table->string('questions39')->default('false');
            $table->string('questions40')->default('false');
            $table->string('questions41')->default('false');
            $table->string('questions42')->default('false');
            $table->string('questions43')->default('false');
            $table->string('questions44')->default('false');
            $table->string('questions45')->default('false');
            $table->string('questions46')->default('false');
            $table->string('questions47')->default('false');
            $table->string('questions48')->default('false');
            $table->string('questions49')->default('false');
            $table->string('questions50')->default('false');
            $table->string('questions51')->default('false');
            $table->string('questions52')->default('false');
            $table->string('questions53')->default('false');
            $table->string('questions54')->default('false');
            $table->string('questions55')->default('false');
            $table->string('questions56')->default('false');
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
