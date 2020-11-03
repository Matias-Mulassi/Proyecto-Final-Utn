<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->integer('cantidad')->unsigned();
            $table->float('total', 8, 2);
            $table->boolean('efectiva');
            $table->integer('id_proveedor')->unsigned();
            $table->integer('id_cerveza')->unsigned();
            $table->foreign('id_proveedor')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('id_cerveza')->references('id')->on('cervezas')->onDelete('cascade');
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
        Schema::dropIfExists('compras');
    }
}
