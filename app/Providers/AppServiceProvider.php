<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Application\AppController;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        \View::composer('layouts/application/head', function( $view )
        {
            $sucursales =  AppController::GetSucursales();
            $lista_sucursales = DB::table('v_sucursal')
                ->where('id_empresa',session('id_empresa'))
                ->where('estado','a')
                ->get();
            $data= [
                'sucursales' => $sucursales,
                'lista_sucursales' => $lista_sucursales
            ];
            if( session('id_sucursal') != null ||  session('id_sucursal')!='' )
            {
                $id_sucursal_actual = session('id_sucursal');
            }
            else
            {
                $id_sucursal_actual = $sucursales[0]->id;
            }
            session(['id_sucursal'=>$id_sucursal_actual]);
            session(['id_empresa'=>\Auth::user()->id_empresa]);
            
            //pass the data to the view
            $view->with( $data);
        } );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
