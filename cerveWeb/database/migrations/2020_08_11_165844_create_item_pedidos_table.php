<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cantidad')->unsigned();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('id_pedido')->unsigned();
            $table->foreign('id_pedido')->references('id')->on('pedidos')->onDelete('cascade');
            $table->integer('id_cerveza')->unsigned();
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
        Schema::dropIfExists('items_pedidos');
    }
}
