<?php

namespace App\Http\Middleware\Register;

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
        $idEstado = \Auth::user()->estado;
        if($idEstado != "p")
            return $next($request);
        return redirect('/registerI');
    }
}
