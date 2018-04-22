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
        $stm = DB::Select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE estado <> 'i' AND (fec_ven >= ? AND fec_ven <= ?) AND id_apc = ?",
            array($fecha_ape,$fecha_cie,$post['cod_apc']));
        //Corregir aqui :,v
        $stm->Datos = DB::Select("SELECT * FROM v_caja_aper WHERE id_apc =".$post['cod_apc'])[0];
        $stm->Ingresos = DB::Select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= '{$fecha_ape}' AND fecha_reg <= '{$fecha_cie}') AND id_apc = {$post['cod_apc']} AND estado='a'")[0];
        $stm->Gastos = DB::Select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE estado='a' AND (fecha_re >= '{$fecha_ape}' AND fecha_re <= '{$fecha_cie}') AND id_apc = {$post['cod_apc']}")[0];
        return $stm;
    }
}
