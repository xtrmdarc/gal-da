<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmAlmacen;
use Illuminate\Support\Facades\DB;

class tm_almacenController extends Controller
{
    public function index()
    {
        return view('contents.config.rest.tm_almacen');
    }
    public function ListaAlmacenes()
    {
        $data = TmAlmacen::all();

        echo json_encode($data);
    }

    public function CrudAlmacen(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod_alm'];
        if($cod != ''){
            //Update
            $flag = 2;
            $nombre = $post['nomb_alm'];
            $estado = $post['estado_alm'];
            $idAlmacen = $post['cod_alm'];
            $consulta_update = DB::select('call usp_configAlmacenes( :flag, :nombre, :estado, :idAlm)',array($flag, $nombre, $estado,$idAlmacen));
            return $consulta_update;
        }else {
            //Create
            $flag = 1;
            $nombre = $post['nomb_alm'];
            $estado = $post['estado_alm'];
            $consulta_create = DB::select('call usp_configAlmacenes( :flag, :nombre, :estado, @a)',array($flag, $nombre, $estado));
            return $consulta_create;
        }
    }

    public function ListaAreasP(Request $request)
    {
        $post = $request->all();
        $cod = $post['codigo'];
        $stm = DB::select("SELECT * FROM tm_area_prod WHERE id_areap like ?",[($cod)]);
        foreach($stm as $k => $v){
            $almacen = DB::select("SELECT nombre FROM tm_almacen WHERE id_alm = ".$v->id_alm);
            //$stm[$k]->put("Almacen",$almacen);
        }
        //echo $almacen;
        echo json_encode($almacen);
    }

    public function CrudAreaP(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod_area'];
        if($cod != ''){
            //Update
            $flag = 2;
            $nombre = $post['nomb_alm'];
            $estado = $post['estado_alm'];
            $idAlmacen = $post['cod_alm'];
            $consulta_update = DB::select('call usp_configAlmacenes( :flag, :nombre, :estado, :idAlm)',array($flag, $nombre, $estado,$idAlmacen));
            return $consulta_update;
        }else {
            //Create
            $flag = 1;
            $id_Alm = $post['cod_alma'];
            $nombre = $post['nomb_area'];
            $estado = $post['estado_area'];
            $consulta_create = DB::select('call usp_configAreasProd( :flag, :idAlm, :nombre, :estado, @a)',array($flag,$id_Alm, $nombre, $estado));
            return $consulta_create;
        }
    }

    public function ComboAlm()
    {
        $query = DB::select("SELECT * FROM tm_almacen WHERE estado = 'a'");
        echo '<select name="cod_alma" id="cod_alma" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar" data-size="5">';
        foreach($query as $v) {
            echo '<option value="'.$v->id_alm.'">'.$v->nombre.'</option>';
        }
        echo " </select>";
    }
}
