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
use App\Mail\SubUsuarioCreado;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $user_plan = \Auth::user()->plan_id;
        $user = \Auth::user()->parent_id;
        $id_usu = \Auth::user()->id_usu;

        $viewData = [];

        if(is_null($user)) {
            $owner = $user;
            $viewData['owner'] = $owner;
            $subUsers = DB::select("call usp_Subsuarios_wp( :idParent);",
                array(':idParent' => $id_usu));
            $viewData['users'] = $subUsers;
            $viewData['breadcrumb'] = '';
            $data = [
                'breadcrumb' => 'config.Usuarios'
            ];

            return view('contents.application.config.sist.usuario',$viewData)->with($data);
        } else {

            
            $owner = TmUsuario::where('id_usu', $user)->first();
            //$subUsers = DB::select("call usp_Subsuarios_wp( :idParent);",
            //array(':idParent' => $user));
            $subUsers =     DB::table('tm_usuario as tm_usuario')
                                    ->where('tm_usuario.id_sucursal',\Auth::user()->id_sucursal)
                                    ->where('tm_usuario.id_usu','<>',\Auth::user()->id_usu)
                                    ->whereNotNull('tm_usuario.parent_id')
                                    ->leftJoin('tm_rol','tm_rol.id_rol','tm_usuario.id_rol')
                                    ->select('tm_usuario.*','tm_rol.descripcion as desc_r')
                                    ->get();

            $viewData['owner'] = $owner;
            $viewData['users'] = $subUsers;
            
            $viewdata['breadcrumb'] = '';
            $data = [
                'breadcrumb' => 'config.Usuarios'
            ];

            return view('contents.application.config.sist.usuario',$viewData)->with($data);
        }
    }

    public function RegistrarUsuario()
    {
        $id_usu = \Auth::user()->id_usu;

        $viewdata = [];
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();

        $area_produccion = TmAreaProd::where('id_usu',$id_usu)->get();
        $empresa = Empresa::find($user_AdminSucursal);

        $user_rol = TmRol::all();
        $viewdata['user_rol']= $user_rol;
        $viewdata['user_sucursal']= $user_sucursal;
        $viewdata['user_areaProd']= $area_produccion;
        $viewdata['id_usu']= $id_usu;
        $viewdata['breadcrumb'] = '';
        $viewdata['nombre_empresa']=$empresa->nombre_empresa;
        
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
        
        $planId_admin = \Auth::user()->plan_id;
        $status_admin = \Auth::user()->status;
        
        //Empresa
        $empresa = Empresa::find(\Auth::user()->id_empresa);
        $nombre_empresa =  $empresa->nombre_empresa;
        //dd($post);
        $flag = 1;
        $id_usu = $post['id_usu'];
        $imagen = $post['imagen'];
        $dni = isset($post['dni'])?$post['dni']:0;
        $nombres = isset($post['nombres'])?$post['nombres']:"";
        $ape_paterno = isset($post['ape_paterno'])?$post['ape_paterno']:"";
        $ape_materno = isset($post['ape_materno'])?$post['ape_materno']:"";
        $email = isset($post['email'])?$post['email']:"";
        $id_rol = $post['id_rol'];
        $pin = isset($post['pin'])?isset($post['pin']):0;
        $plan_id = '1';
        $nombre_empresa = $nombre_empresa;
        $cod_area = isset($post['cod_area'])?$post['cod_area']:"";
        if($cod_area == null ){
            $cod_area = 0;
        }
      
        $usuario = $post['usuario'];
        $contrasena = $post['contrasena'];
        $contrasena_g = bcrypt($post['contrasena']);
        
        if(TmUsuario::where('id_empresa',$userEmpresa)->where('pin',$pin)->where('id_rol',3)->exists()){return 0;}
        
        if($id_usu != ''){
            if($id_rol != '3'){
                $cod_area = 0;
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
                        password = ?,
                        imagen = ?,
                        pin = ?
                    WHERE id_usu = ?",[$id_rol,$cod_area,$dni,$ape_paterno,$ape_materno,$nombres,$email,$usuario,bcrypt($contrasena),$imagen,$pin,$id_usu]);
                    
            return redirect()->route('config.Usuarios');
        } else {

            $user = TmUsuario::create([
                'id_areap' => $cod_area,
                'id_rol' => $id_rol,
                'dni' => $dni,
                'parent_id' => $parentId,
                'estado' => 'a',
                'nombres' => $nombres,
                'ape_paterno' => $ape_paterno,
                'ape_materno' => $ape_materno,
                'email' => $email,
                'plan_id' => $planId_admin,
                'password' => bcrypt($contrasena),
                'usuario' => $usuario,
                'verifyToken' => ($id_rol==5)?null: Str::random(40),
                'id_sucursal' => $post['id_sucursal'],
                'id_empresa' => $userEmpresa,
                'pin' => $pin
            ]);

            if($user) {
                
                
                
                if($user->id_rol==5) {
                    TmUsuario::find($user->id_usu)->update(['status'=>1]);
                }
                else{
                    Mail::to($user->email)->send(new SubUsuarioCreado($user));
                }
                return redirect()->route('config.Usuarios');
            }
        }
    }

    public function CrudUsuario(Request $request,$id_usu){

        $viewdata = [];
        $user = $id_usu;

        $id_user = \Auth::user()->id_usu;
        $nombre_empresa = Empresa::find(\Auth::user()->id_empresa)->nombre_empresa;
        if(isset($user)){
            $user_rol = TmRol::all();
            $area_produccion = TmAreaProd::where('id_usu',$id_user)->get();

            $viewdata['user_areaProd'] = $area_produccion;
            $viewdata['user_rol']= $user_rol;

            $user_sucursal = Sucursal::where('id_empresa', \Auth::user()->id_empresa)->get();
            $viewdata['user_sucursal']= $user_sucursal;

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
                $viewdata['pin']= $r->pin;
                $viewdata['nombre_empresa']= $nombre_empresa;
                $viewdata['id_sucursal']= $r->id_sucursal;
                //dd($viewdata);
                //$viewdata['id_empresa']= $r->nombre_empresa;
              
            }
        }
   
        return view('contents.application.config.sist.usuario_e',$viewdata);
    }

    public function Eliminar(Request $request){

            $post = $request->all();
            $cod_usu_e = $post['cod_usu_e'];
            
            $usuarioEnUso = DB::select('call usp_verificarUsuarioActivo(?)', [$cod_usu_e])[0];
         

            if($usuarioEnUso->COD == 1) {return json_encode(0);}

            $consulta = DB::select("SELECT count(*) AS total FROM tm_venta WHERE id_usu = ?",[($cod_usu_e)]);
            foreach($consulta as $a){
                $con = $a->total;
            }
            if($con == '0') {
                $consulta_eliminar = DB::delete("DELETE FROM tm_usuario WHERE id_usu = ?",[($cod_usu_e)]);
                return json_encode(1);
            }else {
                dd("error");
                //return redirect()->route('config.Usuarios');
            }
    }

    public function Estado(Request $request){

        $post = $request->all();
        $cod_usu = $post['cod_usu'];
        $nuevo_estado = $post['estado'];
        TmUsuario::find($cod_usu)
                    ->update(['estado'=>$nuevo_estado]);

        header('Location: /ajustesUsuarios');
    }

    public function GetAreasProdXSucursal(Request $request){
        
        $areas_prod = TmAreaProd::where('id_sucursal',$request->id_sucursal)->get();
        return $areas_prod;

    }

}
