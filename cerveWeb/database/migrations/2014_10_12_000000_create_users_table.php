<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('id_tipo_usuario');
            $table->dateTime('deleted_at')->nullable();
            $table->string('cuitcuil')->nullable();
            $table->string('razonSocial')->nullable();
            $table->string('condicionIVA')->nullable();
            $table->string('direcciónEntrega')->nullable();
            $table->string('telefono')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('id_tipo_usuario')->references('id')->on('tipos_usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos_usuarios',function(Blueprint $table){
            $table->dropForeign('id_tipo_usuario');
       });

        Schema::dropIfExists('users');
    }
}
