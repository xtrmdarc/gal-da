<?php

namespace App\Http\Controllers\Application\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AperCajaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_apercaja'
        ];
        return view('contents.application.informes.finanzas.inf_cajas')->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $stm = DB::Select("SELECT * FROM v_caja_aper WHERE DATE(fecha_a) >= ? AND DATE(fecha_a) <= ?",
            array($ifecha,$ffecha));

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    //MONTO DEL SISTEMA
    public function MontoSis(Request $request)
    {
        $post = $request->all();

        $fecha_ape = date('Y-m-d H:i:s',strtotime($post['fecha_ape']));
        $fecha_cie = date("Y-m-d H:i:s");
        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven <= ?) AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$post['cod_apc']])[0];

        $arr->Datos = DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",[$post['cod_apc']])[0];
        //$arr->put('Datos',$datos);

        $arr->Ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= ? AND fecha_reg <= ? ) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$post['cod_apc']])[0];
        //$arr->put('Ingresos',$ingresos);

        $arr->Gastos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >= ? AND fecha_re <= ?) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$post['cod_apc']])[0];
        //$arr->put('Gastos',$gastos);

        echo json_encode($arr);
    }
}
