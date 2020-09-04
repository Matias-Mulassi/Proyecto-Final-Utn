<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresCervezasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores_cervezas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_proveedor')->nullable('false');
            $table->unsignedBigInteger('id_producto_cerveza')->nullable('false');
            $table->primary(['id_proveedor','id_producto_cerveza']);
            $table->dateTime('deleted_at')->nullable();     
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
        Schema::dropIfExists('proveedores_cervezas');
    }
}
