<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_usuario', function (Blueprint $table) {
            $table->increments('id_usu');
            $table->string('id_rol');
            $table->string('id_areap');
            $table->string('plan_id');
            $table->string('parent_id')->nullable();
            $table->string('dni');
            $table->string('name_business');
            $table->string('nombres');
            $table->string('ape_paterno');
            $table->string('ape_materno');
            $table->string('phone');
            $table->string('estado')->default('a');
            $table->string('email')->unique();
            $table->string('usuario');
            $table->string('contrasena');
            $table->string('password');
            $table->string('verifyToken')->nullable();
            $table->boolean('status')->default(0);
            $table->string('imagen')->nullable();
            $table->integer('pin')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('tm_usuario');
    }
}
