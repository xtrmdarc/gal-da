<?php

namespace App\Http\Controllers\Application\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RemuneracionesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_remu'
        ];
        return view('contents.application.informes.finanzas.inf_remuneraciones')->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $stm = DB::Select("SELECT id_usu,DATE(fecha_re) AS fecha_re,des_tg,desc_usu,desc_per,motivo,importe,estado FROM v_gastosadm WHERE id_tg = 3 AND DATE(fecha_re) >= ? AND DATE(fecha_re) <= ?",
            array($ifecha,$ffecha));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Caja =  DB::Select("SELECT desc_caja FROM v_caja_aper WHERE id_usu = ".$d->id_usu." AND DATE(fecha_a) = '".$d->fecha_re."'")[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

}
