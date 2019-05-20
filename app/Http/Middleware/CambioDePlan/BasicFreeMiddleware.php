<?php

namespace App\Http\Middleware\CambioDePlan;

use App\Models\Sucursal;
use App\Models\TmAlmacen;
use App\Models\TmAreaProd;
use App\Models\TmMesa;
use Closure;
use App\Models\TmCaja;
use App\Models\TmUsuario;
use Illuminate\Support\Facades\DB;
use Culqi;
use App\Http\Controllers\Application\Subscripcion\SubscriptionController;

class BasicFreeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $SECRET_KEY = "sk_test_asQalOKDq7la1gKr";

    public function handle($request, Closure $next)
    {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $today = date("Y-m-d");

        $parentUsu = \Auth::user()->parent_id;

        if(\Auth::user()->plan_id == '2' || \Auth::user()->plan_id == '3' ) {

            $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));

            if(empty($parentUsu)){
                //Admin
                $ends_at = DB::select('SELECT ends_at,estado,culqi_id FROM db_rest.subscription where id_usu = ? and plan_id = ?'
                    ,array(\Auth::user()->id_usu,\Auth::user()->plan_id));
            }else {
                //Others
                $ends_at = DB::select('SELECT ends_at,estado,culqi_id FROM db_rest.subscription where id_usu = ? and plan_id = ?'
                    ,array(\Auth::user()->parent_id,\Auth::user()->plan_id));
            }

            foreach($ends_at as $r) {
                $f_v = $r->ends_at;
                $estado_suscription = $r->estado;
                $sub_id = $r->culqi_id;
            }

            $fecha_vencimiento = date('Y-m-d',strtotime($f_v));

            if($fecha_vencimiento < $today) {

                if($estado_suscription == 2){
                    $culqi->Subscriptions->delete("$sub_id");

                    DB::table('subscription')->where('id_usu',\Auth::user()->id_usu)
                        ->update([
                            'culqi_id'=> 'Cancelado',
                            'ends_at'=> 'Cancelado',
                        ]);
                }

                DB::table('tm_usuario')->where('id_usu',\Auth::user()->id_usu)->update(['plan_id'=>'1']);

                DB::table('subscription')->where('id_usu',\Auth::user()->id_usu)->update(['plan_id'=>'1']);

                if(\Auth::user()->plan_id == '2'){
                    //MODULO DE CAJAS
                    //Actualizar a Inactivo las Cajas - Basic a Free
                    $apc = DB::table('tm_caja')
                        ->where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','2')
                        ->get();

                    foreach($apc as $r){
                        $id_caja = $r->id_caja;
                        $caja_ocupada = DB::table('tm_aper_cierre')->where('id_caja',$id_caja)->whereNull('fecha_cierre')->exists();

                        if(!($caja_ocupada)) {
                            TmCaja::where('id_empresa',session('id_empresa'))
                                ->where('id_caja',$id_caja)
                                ->where('plan_estado','2')
                                ->update(['estado'=>'i']);
                        }
                    }

                    //MODULO DE USUARIOS
                    TmUsuario::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','2')
                        ->update(['estado'=>'i']);

                    //MODULO DE SUCURSALES
                    Sucursal::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','2')
                        ->update(['estado'=>'i']);

                    //MODULO DE ALMACEN Y AREAS DE PRODUCCION
                    TmAlmacen::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','2')
                        ->update(['estado'=>'i']);

                    TmAreaProd::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','2')
                        ->update(['estado'=>'i']);

                    //MODULO DE MESAS
                    TmMesa::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','2')
                        ->update(['estado'=>'i']);
                }
                if(\Auth::user()->plan_id == '3'){
                    //MODULO DE CAJAS
                    //Actualizar a Inactivo las Cajas - Basic a Free
                    $apc = DB::table('tm_caja')
                        ->where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','3')
                        ->get();

                    foreach($apc as $r){
                        $id_caja = $r->id_caja;
                        $caja_ocupada = DB::table('tm_aper_cierre')->where('id_caja',$id_caja)->whereNull('fecha_cierre')->exists();

                        if(!($caja_ocupada)) {
                            TmCaja::where('id_empresa',session('id_empresa'))
                                ->where('id_caja',$id_caja)
                                ->where('plan_estado','3')
                                ->update(['estado'=>'i']);
                        }
                    }

                    //MODULO DE USUARIOS
                    TmUsuario::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','3')
                        ->update(['estado'=>'i']);

                    //MODULO DE SUCURSALES
                    Sucursal::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','3')
                        ->update(['estado'=>'i']);

                    //MODULO DE ALMACEN Y AREAS DE PRODUCCION
                    TmAlmacen::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','3')
                        ->update(['estado'=>'i']);

                    TmAreaProd::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','3')
                        ->update(['estado'=>'i']);

                    //MODULO DE MESAS
                    TmMesa::where('id_empresa','=',session('id_empresa'))
                        ->where('plan_estado','3')
                        ->update(['estado'=>'i']);
                }

                SubscriptionController::finalizaPlan();

                auth()->logout();
                return redirect('/');
            }
            return $next($request);
        } else {

            return $next($request);
        }
    }
}
