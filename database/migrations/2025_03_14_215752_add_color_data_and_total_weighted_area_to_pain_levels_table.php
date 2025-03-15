<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorDataAndTotalWeightedAreaToPainLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pain_records', function (Blueprint $table) {
            $table->string('painIndex')->nullable();
            $table->string('age')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pain_records', function (Blueprint $table) {
            $table->dropColumn('painIndex');
            $table->dropColumn('age');
            $table->dropColumn('weight');
            $table->dropColumn('height');
        });
    }
}
