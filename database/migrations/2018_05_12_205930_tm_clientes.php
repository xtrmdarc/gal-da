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
            $table->string('id_Sucursal')->nullable();
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
        Schema::table('tm_cliente', function(Blueprint $table) {$table->dropColumn('paid');});
    }
}

//php artisan make:migrate empresa
//php artisan make:migrate tm_caja
//php artisan migrate:refresh