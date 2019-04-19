<?php

namespace App\Http\Middleware\Versiones;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Closure;

class ActualizacionMiddleware
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
        $id_empresa = \Auth::user()->id_empresa;

        $version_empresa = session('datosempresa')->id_version_app;
        $version_app = DB::table('app_version')->orderBy('id_app_version', 'desc')->first();

        $v_actual = $version_app->id_app_version;

        if(!($version_empresa == $v_actual)) {
            Empresa::where('id',$id_empresa)
                ->update(['id_version_app'=>$v_actual]);
            auth()->logout();
            return redirect('/');
        }
        return $next($request);
    }
}
