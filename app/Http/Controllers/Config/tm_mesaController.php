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
            $stm[$k]->Mesas = DB::select("SELECT COUNT(id_mesa) AS total FROM tm_mesa WHERE id_catg = ".$v->id_catg)[0];
        }
        $data = array("data" => $stm);
        echo json_encode($data);
    }
    public function ListaMesas(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod'];
        $stm = DB::select("SELECT * FROM tm_mesa WHERE id_catg like ? ORDER BY nro_mesa ASC",[($cod)]);
        foreach($stm as $k => $v){
            $stm[$k]->Salon = DB::select("SELECT descripcion FROM tm_salon WHERE id_catg = ".$v->id_catg);
        }
        $data = array("data" => $stm);
        echo json_encode($data);
    }
    public function CrudSalones(Request $request)
    {
        $post = $request->all();

        if($post['cod_sala'] != ''){
            //Actualizar

            $flag = 2;
            $desc = $post['desc_sala'];
            $est = $post['est_salon'];
            $idCatg = $post['cod_sala'];

            $consulta = DB::Select("call usp_configSalones( :flag, :desc, :est, :idCatg);"
                ,array($flag,$desc,$est,$idCatg));
            return $consulta;
        } else{
            //Crear
            $flag = 1;
            $desc = $post['desc_sala'];
            $est = $post['est_salon'];

            $consulta = Db::Select("call usp_configSalones( :flag, :desc, :est, @a);",
                array($flag,$desc,$est));
            return $consulta;
        }
    }

    public function CrudMesas(Request $request)
    {
        $post = $request->all();

        if($post['cod_mesa'] != '' and $post['id_catg'] != ''){
          //Actualizar
            //Solo actualiza numero en BD, CORREGIR ESTO.
            $flag = 2;
            $idCatg = $post['id_catg'];
            $nroMesa = $post['nro_mesa'];
            $idMesa = $post['cod_mesa'];

            $consulta = DB::Select("call usp_configMesas( :flag, :idCatg, :nroMesa, :idMesa);",
                array($flag,$idCatg,$nroMesa,$idMesa));
            return $consulta;
        } else{
            //Crear

            $flag = 1;
            $idCatg = $post['id_catg'];
            $nroMesa = $post['nro_mesa'];

            $consulta = DB::Select("call usp_configMesas( :flag, :idCatg, :nroMesa, @a);",
                array($flag,$idCatg,$nroMesa));
            return $consulta;
        }
    }

    public function EliminarS(Request $request)
    {
        $post = $request->all();

        if($post['cod_salae'] != ''){
           //Eliminar

            $flag = 3;
            $idCatg = $post['cod_salae'];

            $consulta = DB::Select("call usp_configSalones( :flag, @a, @b, :idCatg);",
                array($flag,$idCatg));
            return $consulta;
        }
    }

    public function EliminarM(Request $request)
    {
        $post = $request->all();

        $flag = 3;
        $idMesa = $post['cod_mesae'];

        $consulta = DB::Select("call usp_configMesas( :flag, @a, @b, :idMesa);",
            array($flag,$idMesa));
        return $consulta;
    }

    public function EstadoM()
    {
        //NO LO UTILIZAN :v
    }
}
