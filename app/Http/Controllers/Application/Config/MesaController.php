<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;

class MesaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $viewdata = [];
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();
        $viewdata['user_sucursal'] = $user_sucursal;
        $data = [
            'breadcrumb'=> 'config.MesasSalones'  
        ];
        return view('contents.application.config.rest.mesa',$viewdata)->with($data);
    }
    public function ListaSalones()
    {
        $id_usu = \Auth::user()->id_usu;

        $stm = DB::select("SELECT * FROM tm_salon WHERE id_usu =".$id_usu);

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
            $stm[$k]->Salon = DB::select("SELECT id_catg,descripcion FROM tm_salon WHERE id_catg = ".$v->id_catg)[0];
        }
        $data = array("data" => $stm);
        echo json_encode($data);
    }
    public function CrudSalones(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();

        if($post['cod_sala'] != ''){
            //Actualizar

            $flag = 2;
            $desc = $post['desc_sala'];
            $est = $post['est_salon'];
            $idCatg = $post['cod_sala'];
            $idSucursal = $post['sucursal_sala'];

            //$consulta = DB::Select("call usp_configSalones( :flag, :desc, :est, :idCatg);"
            //    ,array($flag,$desc,$est,$idCatg));
            $consulta = DB::Select("call usp_configSalones_g( :flag, :desc, :est, :idCatg,:idUsu, :_idSucursal);"
                ,array(':flag' => $flag,':desc' => $desc,':est' => $est,':idCatg' =>$idCatg,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            return $consulta;
        } else{
            //Crear
            $flag = 1;
            $desc = $post['desc_sala'];
            $est = $post['est_salon'];
            $idSucursal = $post['sucursal_sala'];

            //$consulta = Db::Select("call usp_configSalones( :flag, :desc, :est, @a);",
//                array($flag,$desc,$est));
            $consulta = DB::Select("call usp_configSalones_g( :flag, :desc, :est,@a, :idUsu, :_idSucursal);"
                ,array(':flag' => $flag,':desc' => $desc,':est' => $est,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            return $consulta;
        }
    }

    public function CrudMesas(Request $request)
    {
        $post = $request->all();
        $id_sucursal_m = $post['id_sucursal_m'];

        $id_sucursal_catg =  DB::select("SELECT id_sucursal FROM tm_salon WHERE id_catg =".$id_sucursal_m);

        foreach($id_sucursal_catg as $v){
            $id_sucursal = $v->id_sucursal;
        }

        if($post['cod_mesa'] != '' and $post['id_catg'] != ''){
          //Actualizar
            //Solo actualiza numero en BD, CORREGIR ESTO.
            $flag = 2;
            $idCatg = $post['id_catg'];
            $nroMesa = $post['nro_mesa'];
            $idMesa = $post['cod_mesa'];

//            $consulta = DB::Select("call usp_configMesas( :flag, :idCatg, :nroMesa, :idMesa);",
  //              array($flag,$idCatg,$nroMesa,$idMesa));
            $consulta = DB::Select("call usp_configMesas_g( :flag, :idCatg, :nroMesa, :idMesa, :_idSucursal);",
                array(':flag' => $flag,':idCatg' => $idCatg,':nroMesa' => $nroMesa,':idMesa' => $idMesa,':_idSucursal' => $id_sucursal));
            return $consulta;
        } else{
            //Crear

            $flag = 1;
            $idCatg = $post['id_catg'];
            $nroMesa = $post['nro_mesa'];

            //$consulta = DB::Select("call usp_configMesas( :flag, :idCatg, :nroMesa, @a);",
              //  array($flag,$idCatg,$nroMesa));
            $consulta = DB::Select("call usp_configMesas_g( :flag, :idCatg, :nroMesa, @a, :_idSucursal);",
                array(':flag' => $flag,':idCatg' => $id_sucursal_m,':nroMesa' => $nroMesa,':_idSucursal' => $id_sucursal));
            return $consulta;
        }
    }

    public function EliminarS(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();

        if($post['cod_salae'] != ''){
           //Eliminar

            $flag = 3;
            $idCatg = $post['cod_salae'];
            //$idSucursal = $post['sucursal_sala'];

           /* $consulta = DB::Select("call usp_configSalones( :flag, @a, @b, :idCatg,:idUsu, :_idSucursal);",
                array(':flag' => $flag,':idCatg' => $idCatg,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            return $consulta;*/

            $consulta = DB::select("SELECT count(*) AS total FROM tm_salon WHERE id_catg = ?",[($idCatg)]);
            foreach($consulta as $a){
                $con = $a->total;
            }
            if($con == '0') {
                $consulta_eliminar = DB::select("DELETE FROM tm_salon WHERE id_catg = ?",[($idCatg)]);
                return redirect()->route('config.SalonesMesas');
            }else {
                //Ummm Revisar
                $consulta_eliminar = DB::select("DELETE FROM tm_salon WHERE id_catg = ?",[($idCatg)]);
                return redirect()->route('config.SalonesMesas');
            }
        }
    }

    public function EliminarM(Request $request)
    {
        $post = $request->all();

        $flag = 3;
        $idMesa = $post['cod_mesae'];

        /*$consulta = DB::Select("call usp_configMesas( :flag, @a, @b, :idMesa);",
            array($flag,$idMesa));
        return $consulta;*/

        $consulta = DB::select("SELECT count(*) AS total FROM tm_pedido_mesa WHERE id_mesa = ?",[($idMesa)]);
        foreach($consulta as $a){
            $con = $a->total;
        }
        if($con == '0') {
            $consulta_eliminar = DB::select("DELETE FROM tm_mesa WHERE id_mesa = ?",[($idMesa)]);
            return redirect()->route('config.SalonesMesas');
        }else {
            //Ummm Revisar
            $consulta_eliminar = DB::select("DELETE FROM tm_mesa WHERE id_mesa = ?",[($idMesa)]);
            return redirect()->route('config.SalonesMesas');
        }
    }

    public function EstadoM()
    {
        //NO LO UTILIZAN :v
    }
}
