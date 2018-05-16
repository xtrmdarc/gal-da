<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScCaja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tm_caja', function (Blueprint $table) {
            $table->string('id_sucursal')->nullable();
            $table->string('id_usu')->nullable();
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
        Schema::table('tm_caja', function(Blueprint $table) {$table->dropColumn('id_sucursal');});
        Schema::table('tm_caja', function(Blueprint $table) {$table->dropColumn('id_usu');});
    }
}
