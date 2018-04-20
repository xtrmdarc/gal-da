<?php

namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MozosController extends Controller
{
    //
    public function index()
    {
        $viewdata = [];
        //Mozos
        $stm = DB::Select("SELECT id_usu,CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS nombre FROM v_usuarios WHERE id_rol = 4");
        $viewdata['Mozos'] = $stm;
        $data = [
            'breadcrumb'=>'inf_mozos'
        ];
        return view('contents.application.informes.ventas.inf_mozos',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d H:i:s',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d H:i:s',strtotime($post['ffecha']));
        $cmozo = $post['cmozo'];
        $stm = DB::Select("SELECT v.fec_ven,v.desc_td,CONCAT(v.ser_doc,'-',v.nro_doc) AS numero,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total,v.id_cli,pm.id_mozo FROM v_ventas_con AS v INNER JOIN tm_pedido_mesa AS pm ON v.id_ped = pm.id_pedido WHERE (v.fec_ven >= ? AND v.fec_ven <= ?) AND pm.id_mozo like ? GROUP BY v.id_ven",
            array($ifecha,$ffecha,$cmozo));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Mozo = $this->conexionn->query("SELECT CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS nombre FROM v_usuarios WHERE id_usu = ".$d->id_mozo)[0];

            $stm[$k]->Cliente = $this->conexionn->query("SELECT nombre FROM v_clientes WHERE id_cliente = ".$d->id_cli)[0];
        }
        $stmm = DB::Select("SELECT COUNT(v.id_ven) AS cantidad, IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total FROM v_ventas_con AS v INNER JOIN tm_pedido_mesa AS pm ON v.id_ped = pm.id_pedido WHERE v.fec_ven >= ? AND v.fec_ven <= ? AND pm.id_mozo like ?",
            array($ifecha,$ffecha,$cmozo));

        $data = array("dato" => $stmm,"data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

}
