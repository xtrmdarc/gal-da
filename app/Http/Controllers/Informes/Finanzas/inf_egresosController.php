<?php

namespace App\Http\Controllers\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class inf_egresosController extends Controller
{
    //
    public function index()
    {
        return view('contents.informes.finanzas.inf_egresos');
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $stm = DB::Select("SELECT * FROM v_gastosadm WHERE DATE(fecha_re) >= ? AND DATE(fecha_re) <= ?",
            array($ifecha,$ffecha));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Caja = $this->conexionn->query("SELECT desc_caja FROM v_caja_aper WHERE id_apc = ".$d->id_apc)[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }
}
