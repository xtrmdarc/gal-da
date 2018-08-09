<?php

namespace App\Http\Middleware\Register;

use App\Http\Controllers\Application\AppController;
use Closure;

class RegisterMiddleware
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
        
        if(empty(\Auth::user()) ==true )
        {
            return  $next($request);
        }
        $idEstado = \Auth::user()->estado;
        if($idEstado != "p")
        {
            if($request->getPathInfo() == '/register' ||
                $request->getPathInfo() == '/registerI' ||
                $request->getPathInfo() == '/registerB' ){
                return redirect(AppController::$home);
            }
            return $next($request);
        }
        else {
            if($request->getPathInfo() == '/register' ||
                $request->getPathInfo() == '/registerI' ||
                $request->getPathInfo() == '/registerB' )
            return $next($request);

            return redirect('/registerI');
        }
    }
}
