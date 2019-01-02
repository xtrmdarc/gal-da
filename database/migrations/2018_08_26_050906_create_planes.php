<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('planes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45)->nullable();
            $table->integer('venta_max');
            $table->integer('mesa_max');
            $table->integer('a_prod_max');
            $table->integer('caja_max');
            $table->integer('sucursal_max');
            $table->integer('usuario_max');
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
        Schema::dropIfExists('planes');
    }
}
