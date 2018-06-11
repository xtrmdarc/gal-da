<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Application\AppController;

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
            $data= [
                'sucursales' => $sucursales
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
