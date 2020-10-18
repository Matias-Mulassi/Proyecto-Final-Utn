<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoPreciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_precios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('fecha_vigencia');
            $table->float('precio', 8, 2);
            $table->integer('id_cerveza')->unsigned();
            $table->timestamps();
            $table->foreign('id_cerveza')->references('id')->on('cervezas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_precios');
    }
}
