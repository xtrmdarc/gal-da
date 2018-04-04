<?php

namespace App\Http\Controllers\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class inf_ingresosController extends Controller
{
    //
    public function index()
    {
        return view('contents.informes.finanzas.inf_ingresos');
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($_POST['ffecha']));
        $stm = DB::Select("SELECT * FROM tm_ingresos_adm WHERE DATE(fecha_reg) >= ? AND DATE(fecha_reg) <= ?",
            array($ifecha,$ffecha));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Caja = $this->conexionn->query("SELECT desc_caja FROM v_caja_aper WHERE id_apc = ".$d->id_apc)[0];
        }
        foreach($stm as $k => $d)
        {
            $stm[$k]->Cajero = $this->conexionn->query("SELECT CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS desc_usu FROM tm_usuario WHERE id_usu = ".$d->id_usu)[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

}
