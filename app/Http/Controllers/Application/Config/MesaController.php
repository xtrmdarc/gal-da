<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\TmMesa;
use App\Models\TmSalon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;

class MesaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
    }
    public function index()
    {
        $viewdata = [];
        $user_AdminSucursal = auth()->user()->id_empresa;

        //$user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();
        //$cant_mesas_actual = (DB::select('SELECT count(*) as cant_mesas FROM tm_mesa WHERE id_sucursal = ?',[session('id_sucursal')])[0])->cant_mesas;

        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)
                                 ->where('estado', 'a')->get();
        $cant_mesas_actual = (DB::select('SELECT count(*) as cant_mesas FROM tm_mesa WHERE id_empresa = ?',[session('id_empresa')])[0])->cant_mesas;

        $viewdata['user_sucursal'] = $user_sucursal;
        $sesion_plan = session('plan_actual');

        $data = [
            'breadcrumb'=> 'config.MesasSalones',
            'titulo_vista' => 'Salones y Mesas',
            'mesas_actual'=> $cant_mesas_actual
        ];
        if(is_null($sesion_plan)){
            return view('contents.application.config.cargar_sesiones');
        }
        else {
            return view('contents.application.config.rest.mesa',$viewdata)->with($data);
        }
    }
    public function ListaSalones()
    {
        $id_usu = \Auth::user()->id_usu;
        $id_sucursal = session('id_sucursal');

        $stm = DB::table('tm_salon')
            ->join('sucursal', 'tm_salon.id_sucursal', '=', 'sucursal.id')
            ->where('sucursal.id',$id_sucursal)
            ->select('tm_salon.*', 'sucursal.id_usu', 'sucursal.nombre_sucursal')
            ->get();

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
        $stm = DB::select("SELECT * FROM v_mesa_g WHERE id_catg like ? ORDER BY nro_mesa ASC",[($cod)]);

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
        $planId_admin = \Auth::user()->plan_id;
        if($planId_admin == 1) {
            $plan_estado = '1';
        }else {
            $plan_estado = '2';
        }

        if($post['cod_sala'] != ''){
            //Actualizar

            $flag = 2;
            $desc = $post['desc_sala'];
            $est = $post['est_salon'];
            $idCatg = $post['cod_sala'];
            $idSucursal = $post['sucursal_sala'];

            $consulta = DB::Select("call usp_configSalones_g( :flag, :desc, :est, :idCatg,:idUsu, :_idSucursal, :_planEstado, :_idEmpresa);"
                ,array(':flag' => $flag,':desc' => $desc,':est' => $est,':idCatg' =>$idCatg,':idUsu' => $id_usu,':_idSucursal' => $idSucursal,':_planEstado' => $plan_estado,':_idEmpresa' => session('id_empresa')));
            $array = [];
            foreach($consulta as $k)
            {
                return $array['cod'] = $k->cod;
            }
        } else{
            //Crear
            $flag = 1;
            $desc = $post['desc_sala'];
            $est = $post['est_salon'];
            $idSucursal = $post['sucursal_sala'];

            $consulta = DB::Select("call usp_configSalones_g( :flag, :desc, :est,@a, :idUsu, :_idSucursal, :_planEstado, :_idEmpresa);"
                ,array(':flag' => $flag,':desc' => $desc,':est' => $est,':idUsu' => $id_usu,':_idSucursal' => $idSucursal,':_planEstado' => $plan_estado,':_idEmpresa' => session('id_empresa')));
            foreach($consulta as $k)
            {
                return $array['cod'] = $k->cod;
            }
        }
    }

    public function CrudMesas(Request $request)
    {
        $post = $request->all();
        $id_sucursal_m = $post['id_sucursal_m'];
        $response = new \stdclass();

        $id_usu = \Auth::user()->id_usu;
        $planId_admin = \Auth::user()->plan_id;
        if($planId_admin == 1) {
            $plan_estado = '1';
        }else {
            $plan_estado = '2';
        }

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


           // $consulta = DB::Select("call usp_configMesas_g( :flag, :idCatg, :nroMesa, :idMesa, :_idSucursal);",
                //array(':flag' => $flag,':idCatg' => $idCatg,':nroMesa' => $nroMesa,':idMesa' => $idMesa,':_idSucursal' => $id_sucursal));

            $consulta = DB::Select("call usp_configMesas_g( :flag, :idCatg, :nroMesa, :idMesa, :_idSucursal, :_planEstado, :_idEmpresa, :_idUsu);",
                array(':flag' => $flag,':idCatg' => $idCatg,':nroMesa' => $nroMesa,':idMesa' => $idMesa,':_idSucursal' => $id_sucursal,':_planEstado' => $plan_estado,':_idEmpresa' => session('id_empresa'),':_idUsu' => $id_usu));

            foreach($consulta as $k)
            {
                $response->cod = $k->cod;

            }
        } else{
            //Crear

            $flag = 1;
            $idCatg = $post['id_catg'];
            $nroMesa = $post['nro_mesa'];

            //$consulta = DB::Select("call usp_configMesas_g( :flag, :idCatg, :nroMesa, @a, :_idSucursal);",
                //array(':flag' => $flag,':idCatg' => $id_sucursal_m,':nroMesa' => $nroMesa,':_idSucursal' => $id_sucursal));

            $consulta = DB::Select("call usp_configMesas_g( :flag, :idCatg, :nroMesa, @a, :_idSucursal, :_planEstado, :_idEmpresa, :_idUsu);",
                array(':flag' => $flag,':idCatg' => $id_sucursal_m,':nroMesa' => $nroMesa,':_idSucursal' => $id_sucursal,':_planEstado' => $plan_estado,':_idEmpresa' => session('id_empresa'),':_idUsu' => $id_usu));

            foreach($consulta as $k)
            {
                $response->cod = $k->cod;

            }
        }
        $response->cant_mesas = (DB::select('SELECT count(*) as cant_mesa FROM tm_mesa WHERE id_sucursal = ?',[session('id_sucursal')])[0])->cant_mesa;
        return json_encode($response);
    }

    public function EliminarS(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();

        if($post['cod_salae'] != ''){
            //Eliminar

            $flag = 3;
            $idCatg = $post['cod_salae'];
            $idSucursal = $post['id_sucursal'];

            $consulta = DB::Select("call usp_configSalones_g( :flag, @a, @b, :idCatg,:idUsu, :_idSucursal, :_planEstado, :_idEmpresa);",
                array(':flag' => $flag,':idCatg' => $idCatg,':idUsu' => $id_usu,':_idSucursal' => $idSucursal,':_planEstado' => '1',':_idEmpresa' => session('id_empresa')));

            foreach($consulta as $k)
            {
                return $array['cod'] = $k->cod;
            }
        }
    }

    public function EliminarM(Request $request)
    {
        $post = $request->all();
        $response = new \stdClass();
        $flag = 3;
        $idMesa = $post['cod_mesae'];

        $lista_mesas =  TmMesa::where('id_mesa',$idMesa)->get();

        foreach($lista_mesas as $v){
            $id_catg_s = $v->id_catg;
        }

        $id_sucursal_salon =  DB::select("SELECT id_sucursal FROM tm_salon WHERE id_catg =".$id_catg_s);

        foreach($id_sucursal_salon as $r){
            $id_catg_sucursal = $r->id_sucursal;
        }

        $consulta = DB::Select("call usp_configMesas_g( :flag, @a, @b, :idMesa,:_idSucursal, :_planEstado, :_idEmpresa, :_idUsu);",
            array(':flag' => $flag,':idMesa' => $idMesa,':_idSucursal' => $id_catg_sucursal,':_planEstado' => '1',':_idEmpresa' => session('id_empresa'),':_idUsu' => '1'));

        foreach($consulta as $k)
        {
            $response->cod  = $k->cod;
        }
        $response->cant_mesas = (DB::select('SELECT count(*) as cant_mesa FROM tm_mesa WHERE id_sucursal = ?',[session('id_sucursal')])[0])->cant_mesa;
        return json_encode($response);
    }

    public function EstadoM(Request $request)
    {
        $post = $request->all();
        $estado = $post['est_mesa'];
        $idMesa = $post['codi_mesa'];
        $idSucursal = session('id_sucursal');

        try
        {
            //$mesa_ocupada = DB::table('tm_mesa')->where('estado','!=','a')->where('id_mesa',$idMesa)->exists();
            //if($mesa_ocupada== true){
            //    return -1;
            //}
            $sql =  DB::update("UPDATE tm_mesa SET estado = ? WHERE id_mesa = ? and id_sucursal = ?",
                [$estado,$idMesa,$idSucursal]);
            return 1;

        } catch (Exception $e)
        {
            dd("Error");//Revisar
        }
    }
}
