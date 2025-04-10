<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPainIndexOfPain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pain_records', function (Blueprint $table) {
            $table->string('analgeticIndexPain')->nullable();
            $table->string('pain_control')->nullable();
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
            $table->dropColumn('analgeticIndexPain');
            $table->dropColumn('pain_control');
        });
    }
}
