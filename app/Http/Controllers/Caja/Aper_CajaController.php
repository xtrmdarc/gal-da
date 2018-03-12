<?php

namespace App\Http\Controllers\Caja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\TmUsuario;
use App\Models\TmCaja;
use App\Models\TmTurno;


class Aper_CajaController extends Controller
{
    //
    public function index(){
        
        //Query views
        //$cajas = DB::table('v_caja_aper')->where('estado','<>','c')->get();   
        $cajeros = TmUsuario::Where('estado','a')
                            ->WhereIn('id_rol',array(1,2))->get();
        
        $cajas = TmCaja::Where('estado','a')->get();
        
        $turnos = TmTurno::all();
        $data =
            [
                'cajeros' => $cajeros,
                'cajas'=> $cajas,
            'turnos' => $turnos
            ];        


        return view('contents.caja.aper_caja')->with($data);
                //->with($data);
    }

    public function datos(Request $request){
    
        $arr = DB::table('V_caja_aper')->where('estado','<>','c')
                                ->get();
        
        echo json_encode($arr);
        
    }

    public function montoSis(Request $request){
    
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        $data = $request->all();
        $fecha_ape = date('Y-m-d H:i:s',strtotime($data['fecha_ape']));
        $fecha_cie = date('Y-m-d H:i:s',strtotime($data['fecha_cie']));


        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= '?' AND fec_ven <= '?') AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
       
        $datos = DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",[$data['cod_apc']]);
        $arr->put('Datos',$datos);
       
        $ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= '?'' AND fecha_reg <= '?' ) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Ingresos',$ingresos);
        
        $gastos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >= '?' AND fecha_re <= '?') AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Gastos',$gastos);
        
        echo json_encode($arr);
        }

    public function montoSisDet(Request $request){
    
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        $data = $request->all();

        $fecha_ape = date('Y-m-d H:i:s',strtotime($data['fecha_aper']));
        $fecha_cie = date("Y-m-d H:i:s");
        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= '?' AND fec_ven <= '?') AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$data['cod_apc']] );
        
        $datos = DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",$data['cod_apc']);
        $arr->put('Datos',$datos);
        
        $ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= '?' AND fecha_reg <= '?') AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Ingresos',$ingresos);
        
        $gatos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >= '?' AND fecha_re <= '?') AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Gastos',$gastos);
        
        echo json_encode($arr);
    }

}
