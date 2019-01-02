<?php

namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FPagoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_fpago',
            //'titulo_vista' => 'Informe '
        ];
        return view('contents.application.informes.ventas.inf_fpagos')->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d H:i:s',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d H:i:s',strtotime($post['ffecha']));
        $tpag = $post['tpag'];
        $stm = DB::Select("SELECT id_ped,id_tpag,pago_efe,pago_tar,fec_ven,desc_td,CONCAT(ser_doc,'-',nro_doc) AS numero,IFNULL(SUM(pago_efe+pago_tar),0) AS total,id_cli FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven <= ?) AND id_tpag like ? GROUP BY id_ven",
            array($ifecha,$ffecha,$tpag));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Cliente = DB::Select("SELECT nombre FROM v_clientes WHERE id_cliente = ".$d->id_cli)[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

}
