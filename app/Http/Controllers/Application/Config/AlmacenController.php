<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;

class AlmacenController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        /*Almacen*/

        $id_usu = \Auth::user()->id_usu;

        $lista_almacenes = DB::table('tm_almacen')
            ->join('sucursal', 'tm_almacen.id_sucursal', '=', 'sucursal.id')
            ->where('sucursal.id_usu',$id_usu)
            ->select('tm_almacen.*', 'sucursal.id_usu', 'sucursal.nombre_sucursal')
            ->get();

        $viewdata = [];
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();
        $user_sucursal_free = Sucursal::where('id_empresa', $user_AdminSucursal)->first();

        foreach($user_sucursal as $a) {
            $viewdata['id_sucursal'] = $a->id;
            $viewdata['nombre_sucursal'] = $a->nombre_sucursal;
            $viewdata['id_usu'] = $a->id_usu;
        }

        $viewdata['user_sucursal'] = $user_sucursal;
        $viewdata['user_sucursal_free'] = $user_sucursal_free;
        $viewdata['lista_almacenes'] = $lista_almacenes;

        $data = [
            'breadcrumb'=> 'config.Almacen'  
        ];

        return view('contents.application.config.rest.almacen',$viewdata)->with($data);
    }
    public function ListaAlmacenes()
    {
        $id_usu = \Auth::user()->id_usu;

        $data = DB::table('tm_almacen')
            ->join('sucursal', 'tm_almacen.id_sucursal', '=', 'sucursal.id')
            ->where('sucursal.id_usu',$id_usu)
            ->select('tm_almacen.*', 'sucursal.id_usu', 'sucursal.nombre_sucursal')
            ->get();

        echo json_encode($data);
    }

    public function CrudAlmacen(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();
        $cod = $post['cod_alm'];
        if($cod != ''){
            //Update
            $flag = 2;
            $nombre = $post['nomb_alm'];
            $estado = $post['estado_alm'];
            $idAlmacen = $post['cod_alm'];
            $idSucursal = $post['id_sucursal'];

            $consulta_update = DB::select('call usp_configAlmacenes_g( :flag, :nombre, :estado, :idAlm, :idUsu, :_idSucursal)',
                array(':flag' => $flag,':nombre' => $nombre,':estado' => $estado,':idAlm' =>$idAlmacen,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            $array = [];
            foreach($consulta_update as $k)
            {
                return $array['cod'] = $k->cod;
            }
        }else {
            //Create
            $flag = 1;
            $nombre = $post['nomb_alm'];
            $estado = $post['estado_alm'];
            $idSucursal = $post['id_sucursal'];

            $consulta_create = DB::select('call usp_configAlmacenes_g( :flag, :nombre, :estado, @a, :idUsu, :_idSucursal)',
                array(':flag' => $flag,':nombre' => $nombre,':estado' => $estado,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            $array = [];
            foreach($consulta_create as $k)
            {
                return $array['cod'] = $k->cod;
            }
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
        $id_usu = \Auth::user()->id_usu;
        $idSucursal = \Auth::user()->id_sucursal; //CORREGIR ESTO

        $post = $request->all();
        $cod = $post['cod_area'];
        if($cod != ''){
            //Update
            $flag = 2;
            $idAlm = $post['cod_alma'];
            $nombre = $post['nomb_area'];
            $estado = $post['estado_area'];
            $idArea = $post['cod_area'];

            $consulta_update = DB::Select("call usp_configAreasProd_g( :flag, :idAlm, :nombre, :estado, :idArea, :idUsu, :_idSucursal);",
                array(':flag' => $flag,':idAlm' =>$idAlm,':nombre' =>$nombre,':estado' =>$estado,':idArea' =>$idArea,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            $array = [];
            foreach($consulta_update as $k)
            {
                return $array['cod'] = $k->cod;
            }
        }else {
            //Create
            $flag = 1;
            $id_Alm = $post['cod_alma'];
            $nombre = $post['nomb_area'];
            $estado = $post['estado_area'];

            $id_sucursal_alm = DB::select("SELECT id_sucursal FROM tm_almacen WHERE id_alm = ?",array($id_Alm));
            foreach($id_sucursal_alm as $k){
                $id_sucursal_alm_d = $k->id_sucursal;
            }

            $consulta_create = DB::select('call usp_configAreasProd_g( :flag, :idAlm, :nombre, :estado, @a, :idUsu, :_idSucursal)',
                array(':flag' => $flag,':idAlm' =>$id_Alm, ':nombre' => $nombre,':estado' => $estado,':idUsu' => $id_usu,':_idSucursal' => $id_sucursal_alm_d));

            $array = [];
            foreach($consulta_create as $k)
            {
                return $array['cod'] = $k->cod;
            }
        }
    }

    public function ComboAlm()
    {
        $id_usu = \Auth::user()->id_usu;
        $id_plan = \Auth::user()->plan_id;

        if($id_plan != 1){
            $query = DB::select("SELECT * FROM tm_almacen WHERE estado = 'a' and id_usu = ?",[$id_usu]);
            echo '<select name="cod_alma" id="cod_alma" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar" data-size="5">';
            foreach($query as $v) {
                echo '<option value="'.$v->id_alm.'">'.$v->nombre.'</option>';
            }
            echo " </select>";
        } else {
            echo '<input type="hidden" name="cod_alma" id="cod_alma" class="form-control" placeholder="Ingrese nombre" autocomplete="off" value ="{{$user_sucursal_free->id}}" required="required" disabled/>';
            echo '<input type="text" name="" id="" class="form-control" placeholder="Ingrese nombre" autocomplete="off" value ="{{$user_sucursal_free->nombre_sucursal}}" required="required" disabled/>';
        }

    }
}
