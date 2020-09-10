<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCervezaProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cerveza_proveedor', function (Blueprint $table) {
            $table->unsignedBigInteger('id_producto_cerveza')->nullable('false');
            $table->unsignedBigInteger('id_proveedor')->nullable('false');
            $table->float('costo', 8, 2);
            $table->primary(['id_producto_cerveza','id_proveedor']);
            $table->foreign('id_producto_cerveza')->references('id')->on('productos_cervezas')->onDelete('cascade')->onUpdate('cascade');  
            $table->foreign('id_proveedor')->references('id')->on('proveedores')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('cerveza_proveedor');
    }
}
