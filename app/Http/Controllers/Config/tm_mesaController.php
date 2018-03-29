<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TmSalon;
use App\Models\TmMesa;

class tm_mesaController extends Controller
{
    public function index()
    {
        return view('contents.config.rest.tm_mesa');
    }
    public function ListaSalones()
    {
        $stm = DB::select("SELECT * FROM tm_salon");
        foreach($stm as $k => $v){
            $mesa = DB::select("SELECT COUNT(id_mesa) AS total FROM tm_mesa WHERE id_catg = ".$v->id_catg);
            //$stm[$k]->put('Mesas',$mesa);
        }
        //dd($mesa);
        echo json_encode($stm);
    }
    public function ListaMesas(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod'];
        $stm = DB::select("SELECT * FROM tm_mesa WHERE id_catg like ? ORDER BY nro_mesa ASC",[($cod)]);
        foreach($stm as $k => $v){
            $salon = DB::select("SELECT descripcion FROM tm_salon WHERE id_catg = ".$v->id_catg);
            //$stm[$k]->put('Salon',$salon);
        }
        //dd($mesa);
        echo json_encode($stm);
    }
    public function CrudSalones()
    {
        dd("TEST");
        //$post = $request->all();
        //dd($post);
        /*$cod = $post['cod_alm'];
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
        }*/
    }

    public function CrudMesas()
    {

    }

    public function EliminarS()
    {
        echo "TEST";
    }

    public function EliminarM()
    {
        echo ("TEst");
    }

    public function EstadoM()
    {

    }
}
