<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentificacionTriburatia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('identificacion_tributaria', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 45)->nullable();
            $table->string('description',145)->nullable();
            $table->string('code_country', 45)->nullable();
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
        Schema::dropIfExists('identificacion_tributaria');
    }
}
