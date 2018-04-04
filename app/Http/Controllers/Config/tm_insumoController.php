<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class tm_insumoController extends Controller
{
    //
    public function index()
    {
        //ComboCatg
        $viewdata = [];
        $stm = DB::Select("SELECT * FROM tm_insumo_catg");
        $stm_unidadM = DB::Select("SELECT * FROM tm_tipo_medida");

        $viewdata['comboCatg'] = $stm;
        $viewdata['unidadM'] = $stm_unidadM;

        return view('contents.config.rest.tm_insumo',$viewdata);
    }
    public function ListaCatgs()
    {
        $stm = DB::Select("SELECT * FROM tm_insumo_catg");

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function ListaIns(Request $request)
    {
        $post = $request->all();

        $cod = $post['cod'];
        $cat = $post['cat'];

        $stm = DB::Select("SELECT * FROM v_insumos WHERE id_ins like ? AND id_catg like ? ORDER BY id_ins DESC",
        array($cod,$cat));

        $data = array("data" => $stm);
        $json = json_encode($stm);
        echo $json;
    }

    public function CrudCatg(Request $request)
    {
        $post = $request->all();

        $descC = $post['nombre_catg'];
        $idCatg = $post['cod_catg'];

       if($post['cod_catg'] != ''){
            //Actualizar
           $flag = 2;

           $consulta = DB::Select("call usp_configInsumoCatgs( :flag, :descC, :idCatg);"
           ,array($flag,$descC,$idCatg));
           return $consulta;

        } else{
           //Crear
           $flag = 1;

           $consulta = DB::Select("call usp_configInsumoCatgs( :flag, :descC, @a);"
           ,array($flag,$descC));
          return $consulta;
        }
    }

    public function CrudIns(Request $request)
    {
        $post = $request->all();

       if($post['cod_ins'] != ''){
            //Actualizar
            dd('ACTUALIZAR');
           $flag = 2;
           $idCatg = $post['cod_catg'];
           $idMed = $post['cod_med'];
           $cod = $post['codigo_ins'];
           $nombre = $post['nombre_ins'];
           $stock = $post['stock_min'];
           $estado = $post['estado'];
           $idIns = $post['cod_ins'];

           $consulta = DB::Select("call usp_configInsumo( :flag, :idCatg, :idMed, :cod, :nombre, :stock, :estado, :idIns);"
           ,array($flag,$idCatg,$idMed,$cod,$nombre,$stock,$estado,$idIns));

           return $consulta;
        } else{
            //Crear

           $idCatg = $post['cod_catg'];
           $idMed = $post['cod_med'];
           $cod = $post['codigo_ins'];
           $nombre = $post['nombre_ins'];
           $stock = $post['stock_min'];
           $estado = $post['estado'];
           $idIns = $post['cod_ins'];
           $flag = 1;

           $consulta = DB::Select("call usp_configInsumo( :flag, :idCatg, :idMed, :cod, :nombre, :stock, @a, @b);",
               array($flag,$idCatg,$idMed,$cod,$nombre,$stock));
           return $consulta;
        }
    }
    public function ActualizarIns() {
        dd('Test');
    }
}
