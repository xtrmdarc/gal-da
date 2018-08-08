<?php

namespace App\Http\Controllers\Application\Informes\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ComprasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $data=[
            'breadcrumb'=> 'inf_compras'
        ];

        return view('contents.application.informes.compras.inf_compras')->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $tdoc = $post['tdoc'];
        $est = $post['est'];

        $stm = DB::Select("SELECT * FROM v_compras WHERE (DATE(fecha_c) >= ? AND DATE(fecha_c) <= ?) AND id_tipo_doc like ? AND estado like ? GROUP BY id_compra",
            array($ifecha,$ffecha,$tdoc,$est));

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function Detalle(Request $request)
    {
        $post = $request->all();

        $cod = $post['cod'];
        $stm = DB::Select("SELECT * FROM tm_compra_detalle WHERE id_compra = ?",
            array($cod));
        foreach($stm as $k => $d)
        {
            $stm[$k]->Pres = DB::Select("SELECT cod_ins,nomb_ins,descripcion FROM v_busqins WHERE tipo_p = ".$d->id_tp."  AND id_ins = ".$d->id_pres)[0];
        }
        return $stm;
    }

    public function DetalleC(Request $request)
    {
        $post = $request->all();

        $cod = $post['cod'];
        $stm = DB::Select("SELECT * FROM tm_compra_credito WHERE id_compra = ?",
            array($cod));
        return $stm;
    }

    public function DetalleSC(Request $request)
    {
        $post = $request->all();

        $cod = $post['cod'];
        $stm = DB::Select("SELECT * FROM tm_credito_detalle WHERE id_credito = ?",
            array($cod));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Usuario = DB::Select("SELECT CONCAT(ape_paterno,' ',ape_materno,' ',nombres) AS nombre FROM v_usuarios WHERE id_usu = ".$d->id_usu)[0];
        }
        return $stm;
    }
}
