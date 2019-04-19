<?php

namespace App\Http\Controllers\Application\Informes\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('vActualizacion');
    }
    public function index()
    {
        $viewdata = [];
        //Proveedores
        $stm = DB::Select("SELECT id_prov,ruc,razon_social FROM tm_proveedor");

        $viewdata['Proveedores'] = $stm;

        $data = [
            'breadcrumb' =>'inf_proveedores',
            'titulo_vista' => 'Informe de proveedores'
        ];
        return view('contents.application.informes.compras.inf_proveedores',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $tdoc = $post['tdoc'];
        $cprov = $post['cprov'];
        $stm = DB::Select("SELECT * FROM v_compras WHERE (DATE(fecha_c) >= ? AND DATE(fecha_c) <= ?) AND id_tipo_doc like ? AND id_prov like ? GROUP BY id_compra",
            array($ifecha,$ffecha,$tdoc,$cprov));
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function Detalle(Request $request)
    {
        $post = $request->all();

        $cod = $post['cod'];
        $stm = DB::Select("SELECT * FROM tm_compra_credito WHERE id_compra = ?",
            array($cod));
        return $stm;
    }

    public function DetalleC(Request $request)
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

    public function Detalle_C(Request $request)
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
}
