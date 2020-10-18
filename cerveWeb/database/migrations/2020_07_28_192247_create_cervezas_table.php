<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCervezasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cervezas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->text('descripcion');
            //$table->float('precio', 8, 2);
            $table->string('image',6500);
            $table->integer('cantidadStock')->unsigned();
            $table->integer('puntoPedido')->unsigned();
            $table->integer('loteOptimo')->unsigned()->nullable();
            $table->integer('id_categoria')->unsigned();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   

        Schema::table('categorias',function(Blueprint $table){
            $table->dropForeign('id_categoria');
       });
        Schema::dropIfExists('cervezas');
    }
}
