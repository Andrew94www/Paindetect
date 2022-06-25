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
            $table->string('name');
            $table->string('date');  
            $table->string('id_patient');
            $table->string('questions1');
            $table->string('questions2');
            $table->string('questions3');
            $table->string('questions4');
            $table->string('questions5');
            $table->string('questions6');
            $table->string('questions7');
            $table->string('questions8');
            $table->string('questions9');
            $table->string('questions10');
            $table->string('questions11');
            $table->string('questions12');
            $table->string('questions13');
            $table->string('questions14');
            $table->string('questions15');
            $table->string('questions16');
            $table->string('questions17');
            $table->string('questions18');
            $table->string('questions19');
            $table->string('questions20');
            $table->string('questions21');
            $table->string('questions22');
            $table->string('questions23');
            $table->string('questions24');
            $table->string('questions25');
            $table->string('questions26');
            $table->string('questions27');
            $table->string('questions28');
            $table->string('questions29');
            $table->string('questions30');
            $table->string('questions31');
            $table->string('questions32');
            $table->string('questions33');
            $table->string('questions34');
            $table->string('questions35');
            $table->string('questions36');
            $table->string('questions37');
            $table->string('questions38');
            $table->string('questions39');
            $table->string('questions40');
            $table->string('questions41');
            $table->string('questions42');
            $table->string('questions43');
            $table->string('questions44');
            $table->string('questions45');
            $table->string('questions46');
            $table->string('questions47');
            $table->string('questions48');
            $table->string('questions49');
            $table->string('questions50');
            $table->string('questions51');
            $table->string('questions52');
            $table->string('questions53');
            $table->string('questions54');

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
