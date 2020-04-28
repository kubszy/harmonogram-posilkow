<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DodatkoweKolumnyHarmonogram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('harmonogram', function($table) {
        $table->string('masa_ciała')->nullable();
        $table->string('bmi')->nullable();
        $table->string('talia')->nullable();
        $table->string('pass')->nullable();
        $table->string('biodra')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
