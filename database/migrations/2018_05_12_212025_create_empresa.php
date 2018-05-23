<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('empresa', function (Blueprint $table) {            
            $table->increments('id');
            $table->string('nombre_empresa')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('abrev_rs')->nullable();
            $table->string('ruc')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('logo')->nullable();
            $table->double('igv')->nullable();
            $table->string('moneda') ->nullable();
            $table->integer('id_pais') ->nullable();
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
        Schema::dropIfExists('empresa');
    }
}
