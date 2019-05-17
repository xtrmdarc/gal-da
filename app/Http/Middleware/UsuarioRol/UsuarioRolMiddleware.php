<?php

namespace App\Http\Middleware\UsuarioRol;

use App\Models\Empresa;
use Closure;

class UsuarioRolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $idRol = \Auth::user()->id_rol;
        $idPlan = \Auth::user()->plan_id;

        if($idRol == 3 || $idRol == 4 || $idRol == 5) {
            if($request->getPathInfo() != '/inicio'){
                return redirect('/inicio');
            }
        }
        if($idRol == 2)
        {
            if(($request->getPathInfo() == '/ajustes') || ($request->getPathInfo() == '/ajustesCaja') ||
                ($request->getPathInfo() == '/ajustesAlmacen') || ($request->getPathInfo() == '/ajustesSalonyMesas') ||
                ($request->getPathInfo() == '/ajustesProductos') || ($request->getPathInfo() == '/ajustesDatosEmpresa') ||
                ($request->getPathInfo() == '/ajustesTipoDocumento') || ($request->getPathInfo() == '/ajustesUsuarios') ||
                ($request->getPathInfo() == '/ajustesSucursal') || ($request->getPathInfo() == '/ajustesTurnos')){
                return redirect('/inicio');
            }
        }
        if($idPlan == 1 || $idPlan == 2)
        {
            if($request->getPathInfo() == '/tablero'){
                return redirect('/tableroF');
            }
        } else {
            if($request->getPathInfo() == '/tableroF'){
                return redirect('/tablero');
            }
        }

        return $next($request);
    }
}
