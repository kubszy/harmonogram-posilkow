<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Harmonogram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('harmonogram', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('nr_tygodnia');
          $table->integer('ilosc_dni');
          $table->string('nazwa_harmonogramu')->nullable();
          $table->dateTime('start_dzien');
          $table->dateTime('koniec_dzien');
          $table->integer('uzytkownik_id');
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
        //
    }
}
