<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TmClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tm_cliente', function (Blueprint $table) {
            $table->string('id_empresa')->nullable();
            $table->string('id_usu')->nullable();
            $table->string('estado')->default('a');
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
        Schema::table('tm_cliente', function(Blueprint $table) {$table->dropColumn('estado');});
        Schema::table('tm_cliente', function(Blueprint $table) {$table->dropColumn('id_empresa');});
        Schema::table('tm_cliente', function(Blueprint $table) {$table->dropColumn('id_usu');});
    }
}
