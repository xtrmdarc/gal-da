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
            $lista_sucursales = DB::table('empresa')
                ->leftjoin('sucursal', 'empresa.id', '=', 'sucursal.id_empresa')
                ->select('sucursal.id','sucursal.id_empresa','sucursal.nombre_sucursal','sucursal.id_usu','sucursal.direccion','sucursal.estado','sucursal.moneda','sucursal.telefono')
                ->where('empresa.id',session('id_empresa'))
                ->get();
            $data= [
                'sucursales' => $sucursales,
                'lista_sucursales' => $lista_sucursales
            ];
            session(['id_sucursal'=>$sucursales[0]->id]);
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
