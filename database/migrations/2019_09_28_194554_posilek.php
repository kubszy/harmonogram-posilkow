<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posilek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posilek', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('harmonogram_id');
            $table->integer('dzien');
            $table->integer('posilek_id');
            $table->string('typ_posilku');
            // $table->string('sniadanie');
            // $table->string('II_sniadanie');
            // $table->string('obiad');
            // $table->string('podwieczorek');
            // $table->string('kolacja');
            // $table->string('woda');
            // $table->string('przekaska');
            $table->text('opis');
            $table->dateTime('data_godzina');
            $table->integer('uzytkownik_id');
            $table->text('uwagi')->nullable();
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
