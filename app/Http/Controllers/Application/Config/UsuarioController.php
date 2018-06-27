<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\Empresa;
use App\Models\Sucursal;
use App\Models\TmRol;
use App\Models\TmAreaProd;
use App\Models\TmUsuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_plan = \Auth::user()->plan_id;
        $user = \Auth::user()->parent_id;
        $id_usu = \Auth::user()->id_usu;

        $viewdata = [];

        if(is_null($user)) {
            $owner = $user;
            $viewData['owner'] = $owner;
            $subUsers = DB::select("call usp_Subsuarios_wp( :idParent);",
                array(':idParent' => $id_usu));
            $viewdata['users'] = $subUsers;
            $viewdata['breadcrumb'] = '';
            $data = [
                'breadcrumb' => 'config.Usuarios'
            ];

            return view('contents.application.config.sist.usuario',$viewdata)->with($data);
        } else {
            $owner = TmUsuario::where('id_usu', $user)->first();
            $subUsers = DB::select("call usp_Subsuarios_wp( :idParent);",
                array($user));
            $viewData['owner'] = $owner;
            $viewData['users'] = $subUsers;
            $viewdata['breadcrumb'] = '';
            $data = [
                'breadcrumb' => 'config.Usuarios'
            ];

            return view('contents.application.config.sist.usuario',$viewdata)->with($data);
        }
    }

    public function RegistrarUsuario()
    {
        $id_usu = \Auth::user()->id_usu;

        $viewdata = [];
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();

        $area_produccion = TmAreaProd::where('id_usu',$id_usu)->get();

        $user_rol = TmRol::all();
        $viewdata['user_rol']= $user_rol;
        $viewdata['user_sucursal']= $user_sucursal;
        $viewdata['user_areaProd']= $area_produccion;
        $viewdata['id_usu']= $id_usu;
        $viewdata['breadcrumb'] = '';
        
        return view('contents.application.config.sist.usuario_r',$viewdata);
    }

    public function RUUsuario(Request $request){
        /*
        $post = $request->all();

        //SuperAdmin User
        $parentId = \Auth::user()->id_usu;

        $flag = 1;
        $id_usu = $post['id_usu'];
        $imagen = $post['imagen'];
        $dni = $post['dni'];
        $nombres = $post['nombres'];
        $ape_paterno = $post['ape_paterno'];
        $ape_materno = $post['ape_materno'];
        $email = $post['email'];
        $id_rol = $post['id_rol'];
        $plan_id = '1';

        $cod_area = $post['cod_area'];
        if($id_rol == '3'){
            $cod_area = 1;
        }
        if($cod_area == null ){
            $cod_area = 0;
        }else {
            $cod_area = 1;
        }
        $usuario = $post['usuario'];
        $contrasena = $post['contrasena'];
        $contrasena_g = bcrypt($post['contrasena']);

        if($id_usu != ''){
            $consulta = DB::select("call usp_configUsuario_g( :flag, :idRol, :idArea, :dni, :apeP, :apeM, :nomb, :email, :usu, :cont, :img, :idUsu, :idParent, :plan_id, :password);",
            array('2',$id_rol,$cod_area,$dni,$ape_paterno,$ape_materno,$nombres,$email,$usuario,$contrasena,$imagen,$id_usu,$parentId,$plan_id,$contrasena_g));
            return redirect()->route('config.Usuarios');
        } else {
            $consulta = DB::select("call usp_configUsuario_g( :flag, :idRol, :idArea, :dni, :apeP, :apeM, :nomb, :email, :usu, :cont, :img, @a, :idParent, :plan_id, :password)"
                ,array($flag, $id_rol, $cod_area,$dni,$ape_paterno,$ape_materno,$nombres,$email,$usuario,$contrasena,$imagen,$parentId,$plan_id,$contrasena_g));
            return redirect()->route('config.Usuarios');
        }
        */

        $post = $request->all();

        //SuperAdmin User
        $parentId = \Auth::user()->id_usu;
        $userEmpresa = \Auth::user()->id_empresa;
        $name_business = \Auth::user()->name_business;
        $planId_admin = \Auth::user()->plan_id;
        $status_admin = \Auth::user()->status;
        //dd($post);
        $flag = 1;
        $id_usu = $post['id_usu'];
        $imagen = $post['imagen'];
        $dni = $post['dni'];
        $nombres = $post['nombres'];
        $ape_paterno = $post['ape_paterno'];
        $ape_materno = $post['ape_materno'];
        $email = $post['email'];
        $id_rol = $post['id_rol'];
        $plan_id = '1';

        $cod_area = $post['cod_area'];
        if($id_rol == '3'){
            $cod_area = 1;
        }
        if($cod_area == null ){
            $cod_area = 0;
        }else {
            $cod_area = 1;
        }
        $usuario = $post['usuario'];
        $contrasena = $post['contrasena'];
        $contrasena_g = bcrypt($post['contrasena']);

        if($id_usu != ''){
            if($id_rol != '3'){
                $cod_area = 0;
            }else {
                $cod_area = 1;
            }
            $sql = DB::update("UPDATE tm_usuario SET
						id_rol  = ?,
						id_areap   = ?,
						dni   = ?,
						ape_paterno  = ?,
                        ape_materno = ?,
                        nombres = ?,
                        email = ?,
                        usuario = ?,
                        contrasena = ?,
                        imagen = ?
				    WHERE id_usu = ?",[$id_rol,$cod_area,$dni,$ape_paterno,$ape_materno,$nombres,$email,$usuario,$contrasena,$imagen,$id_usu]);
            return redirect()->route('config.Usuarios');
        } else {

            $user = TmUsuario::create([
                'id_areap' => $cod_area,
                'id_rol' => $post['id_rol'],
                'dni' => $post['dni'],
                'parent_id' => $parentId,
                'estado' => 'a',
                'name_business' => $name_business,
                'nombres' => $post['nombres'],
                'ape_paterno' => $post['ape_paterno'],
                'ape_materno' => $post['ape_materno'],
                'email' => $post['email'],
                'plan_id' => $planId_admin,
                'password' => bcrypt($post['contrasena']),
                'verifyToken' => null,
                'id_sucursal' => $post['id_sucursal'],
                'id_empresa' => $userEmpresa,
            ]);

            if($user) {
                $update_user =  TmUsuario::where(['email' => $email])->update(['status' => '1']);
                return redirect()->route('config.Usuarios');
            }
        }
    }

    public function CrudUsuario(Request $request,$id_usu){

        $viewdata = [];
        $user = $id_usu;

        $id_user = \Auth::user()->id_usu;

        if(isset($user)){
            $user_rol = TmRol::all();
            $area_produccion = TmAreaProd::where('id_usu',$id_user)->get();

            $viewdata['user_areaProd'] = $area_produccion;
            $viewdata['user_rol']= $user_rol;

            foreach($area_produccion as $a) {
                $viewdata['nombre'] = $a->nombre;
            }
            $stm = DB::select("SELECT * FROM v_usuarios WHERE id_usu = ?",[($user)]);
            foreach($stm as $r) {
                $viewdata['id_usu'] = $r->id_usu;
                $viewdata['id_rol'] = $r->id_rol;
                $viewdata['id_areap']= $r->id_areap;
                $viewdata['dni'] = $r->dni;
                $viewdata['ape_paterno']= $r->ape_paterno;
                $viewdata['ape_materno']= $r->ape_materno;
                $viewdata['nombres']= $r->nombres;
                $viewdata['email']= $r->email;
                $viewdata['usuario']= $r->usuario;
                $viewdata['contrasena']= $r->contrasena;
                $viewdata['estado']= $r->estado;
                $viewdata['imagen']= $r->imagen;
                $viewdata['desc_r']= $r->desc_r;
                $viewdata['desc_ap']= $r->desc_ap;
            }
        }

        return view('contents.application.config.sist.usuario_e',$viewdata);
    }

    public function Eliminar(Request $request){

            $post = $request->all();
            $cod_usu_e = $post['cod_usu_e'];

            $consulta = DB::select("SELECT count(*) AS total FROM tm_venta WHERE id_usu = ?",[($cod_usu_e)]);
            foreach($consulta as $a){
                $con = $a->total;
            }
            if($con == '0') {
                $consulta_eliminar = DB::delete("DELETE FROM tm_usuario WHERE id_usu = ?",[($cod_usu_e)]);
                return redirect()->route('config.Usuarios');
            }else {
                dd("error");
                //return redirect()->route('config.Usuarios');
            }
    }
}
