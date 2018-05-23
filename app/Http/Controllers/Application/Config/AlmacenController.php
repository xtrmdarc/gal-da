<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmAlmacen;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=> 'config.Almacen'  
        ];

        return view('contents.application.config.rest.almacen')->with($data);
    }
    public function ListaAlmacenes()
    {
        $id_usu = \Auth::user()->id_usu;

        $data = TmAlmacen::where('id_usu',$id_usu)->get();

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
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();

        $cod = $post['codigo'];
        $stm = DB::select("SELECT * FROM tm_area_prod WHERE id_areap like ? and id_usu = ?",[($cod),$id_usu]);
        foreach($stm as $k => $v){
            $stm[$k]->Almacen = DB::select("SELECT id_alm,nombre FROM tm_almacen WHERE id_alm = ".$v->id_alm)[0];
        }
        $data = array("data" => $stm);
        echo json_encode($data);
    }

    public function CrudAreaP(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod_area'];
        if($cod != ''){
            //Update
            $flag = 2;
            $idAlm = $post['cod_alma'];
            $nombre = $post['nomb_area'];
            $estado = $post['estado_area'];
            $idArea = $post['cod_area'];

            $consulta = DB::Select("call usp_configAreasProd( :flag, :idAlm, :nombre, :estado, :idArea);",
                array($flag,$idAlm,$nombre,$estado,$idArea));
            return $consulta;
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
