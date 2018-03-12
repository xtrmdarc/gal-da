<?php

namespace App\Http\Controllers\Compras;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TmProveedor;
use App\Models\TmCompraDetalle;

class ComprasController extends Controller
{
    //
    public function index(){

        $proveedores = TmProveedor::all();

        $data =[
            'proveedores' => $proveedores
        ];

        return view('contents.compras.index')->with($data);
    }

    public function crear(){



        $data =[
           // 'proveedores' => $proveedores
        ];

        return view('contents.compras.crear')->with($data);
    }

    public function obtenerDatos(Request $request){

        $post = $request->all();
        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $tdoc = $post['tdoc'];
        $cprov = $post['cprov'];
        $c = DB::select("SELECT * FROM v_compras WHERE (DATE(fecha_c) >= ? AND DATE(fecha_c) <= ?) AND id_tipo_doc like ? AND id_prov like ? GROUP BY id_compra",[$ifecha,$ffecha,$tdoc,$cprov]);
                           
        $data = array('data'=>$c);
        $json = json_encode($data);
        echo $json;
    }

    public function detalle(Request $request){

        $post = $request->all();
        $cod = $post['cod'];
        $stm = TmCompraDetalle::where('id_compra',$cod);

        foreach($stm as $k => $v){
            $pres = DB::select("SELECT cod_ins,nomb_ins,descripcion FROM v_busqins WHERE tipo_p = ?  AND id_ins = ?", [ $d->id_tp, $d->id_pres ] );
            $stm[$k]->put('Pres',$pres);
        }
        
        echo json_encode($stm);
    }

    public function buscarIns(Request $request){

        $post = $request->all();
        $criterio = $post['criterio'];

        //$data = DB::select("SELECT tipo_p,id_ins,cod_ins,nomb_ins,descripcion FROM v_busqins WHERE cod_ins LIKE '%?%' OR nomb_ins LIKE '%?%' ORDER BY nomb_ins LIMIT 5",[$criterio,$criterio]);
        $data = DB::select("SELECT tipo_p,id_ins,cod_ins,nomb_ins,descripcion FROM v_busqins WHERE cod_ins LIKE '%".$criterio."%' OR nomb_ins LIKE '%".$criterio."%' ORDER BY nomb_ins LIMIT 5");
        
        echo json_encode($data);
    }

    public function buscarProv(Request $request){

        $post = $request->all();
        $criterio = $post['criterio'];
        
        //$data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%?%' OR razon_social LIKE '%?%') ORDER BY ruc LIMIT 5",[$criterio,$criterio] );
        $data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%".$criterio."%' OR razon_social LIKE '%".$criterio."%') ORDER BY ruc LIMIT 5");
        
        echo json_encode($data);
    }

    public function nuevoProv(Request $request){

        $post = $request->all();
        $criterio = $post['criterio'];
        
        //$data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%?%' OR razon_social LIKE '%?%') ORDER BY ruc LIMIT 5",[$criterio,$criterio] );
        //$data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%".$criterio."%' OR razon_social LIKE '%".$criterio."%') ORDER BY ruc LIMIT 5");
        
        echo json_encode($data);
    }
}
