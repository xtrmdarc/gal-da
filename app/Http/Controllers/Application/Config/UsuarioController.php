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
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
    }
    public function index()
    {
        $user_plan = \Auth::user()->plan_id;
        $user = \Auth::user()->parent_id;
        $id_usu = \Auth::user()->id_usu;
        $usuarios_cant = TmUsuario::where('id_empresa',session('id_empresa'))->count();
        $sesion_plan = session('plan_actual');
        $viewData = [];

        if(is_null($user)) {
            $owner = $user;
            $viewData['owner'] = $owner;
            $subUsers = DB::select("call usp_Subsuarios_wp( :idParent);",
                array(':idParent' => $id_usu));
            $viewData['users'] = $subUsers;
            $viewData['breadcrumb'] = '';
            
            $data = [
                'breadcrumb' => 'config.Usuarios',
                'titulo_vista' => 'Usuarios',
                'usuarios_cant' => $usuarios_cant
            ];
            if(is_null($sesion_plan)){
                return view('contents.application.config.cargar_sesiones');
            }
            else {
                return view('contents.application.config.sist.usuario',$viewData)->with($data);
            }
        } else {

            
            $owner = TmUsuario::where('id_usu', $user)->first();
            $subUsers =     DB::table('tm_usuario as tm_usuario')
                                    ->where('tm_usuario.id_sucursal',\Auth::user()->id_sucursal)
                                    ->where('tm_usuario.id_usu','<>',\Auth::user()->id_usu)
                                    ->whereNotNull('tm_usuario.parent_id')
                                    ->leftJoin('tm_rol','tm_rol.id_rol','tm_usuario.id_rol')
                                    ->select('tm_usuario.*','tm_rol.descripcion as desc_r')
                                    ->get();
            dd($subUsers);
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
        $viewdata['breadcrumb'] = 'config.nuevo_usuario';
        $viewdata['nombre_empresa']=$empresa->empresa_usuario;
        $viewdata['titulo_vista']= 'Nuevo usuario';

        return view('contents.application.config.sist.usuario_r',$viewdata);
    }

    public function RUUsuario(Request $request){

        $post = $request->all();

        //SuperAdmin User
        $parentId = \Auth::user()->id_usu;
        $userEmpresa = \Auth::user()->id_empresa;
        
        $planId_admin = \Auth::user()->plan_id;
        $status_admin = \Auth::user()->status;
        
        //Empresa
        $empresa = Empresa::find(\Auth::user()->id_empresa);
        $nombre_empresa =  $empresa->empresa_usuario;

        $flag = 1;
        $id_usu = $post['id_usu'];
        $imagen = $post['imagen'];
        $dni = isset($post['dni'])?$post['dni']:0;
        $nombres = isset($post['nombres'])?$post['nombres']:"";
        $ape_paterno = isset($post['ape_paterno'])?$post['ape_paterno']:"";
        $ape_materno = isset($post['ape_materno'])?$post['ape_materno']:"";
        $email = isset($post['email'])?$post['email']:"";
        $id_rol = $post['id_rol'];
        $pin = isset($post['pin'])?$post['pin']:0;
        $plan_id = '1';
        $nombre_empresa = $nombre_empresa;
        $cod_area = isset($post['cod_area'])?$post['cod_area']:"";
        if($cod_area == null ){
            $cod_area = 0;
        }
        //$contrasena = '';
        $contrasena = $post['contrasena'];
        /*
        if($id_rol==5){
            $contrasena = $post['contrasena'];
            $contrasena_g = bcrypt($post['contrasena']);        
        }
        */
        
        $verificaPinMozo = TmUsuario::where('id_empresa',$userEmpresa)->where('pin',$pin)->where('id_rol',4);
        if($id_usu != '')
            $verificaPinMozo = $verificaPinMozo->where('id_usu','<>',$id_usu);
        
        if($verificaPinMozo->exists()){

            $notification = [
                'message' =>'El usuario tiene el mismo PIN que otro usuario.',
                'alert-type' => 'error'
            ];
            return redirect()->route('config.Usuarios')->with($notification);
        }
        
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
                        ".
                        (($contrasena != '' || !isset($contrasena))?'':'password = ?,' )
                        ."
                        imagen = ?,
                        pin = ?
                    WHERE id_usu = ?",[$id_rol,$cod_area,$dni,$ape_paterno,$ape_materno,$nombres,$email,bcrypt($contrasena),$imagen,$pin,$id_usu]);

            $notification = [ 
                'message' =>'Datos modificados, Correctamente',
                'alert-type' => 'success'
            ];

            return redirect()->route('config.Usuarios')->with($notification);
        } else {

            $usuario = $post['usuario'].'@'.$nombre_empresa;
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
                'verifyToken' => null,
                'id_sucursal' => $post['id_sucursal'],
                'id_empresa' => $userEmpresa,
                'status'=> 1,
                'pin' => $pin
            ]);

            if($user) {

                //if($user->id_rol==5) {
                
                

                // }
                // else{
                //     Mail::to($user->email)->send(new SubUsuarioCreado($user));
                // }
                
                $notification = [ 
                    'message' =>'Usuario registrado correctamente',
                    'alert-type' => 'success'
                ];

                return redirect()->route('config.Usuarios')->with($notification);
            }
        }
    }

    public function CrudUsuario(Request $request,$id_usu){

        $viewdata = [];
        $user = $id_usu;
        
        $viewdata['titulo_vista']='Editar usuario';
        $viewdata['breadcrumb']='config.editar_usuario';
        $id_user = \Auth::user()->id_usu;

        $id_empresa = \Auth::user()->id_empresa;
        $nombre_empresa = Empresa::find(\Auth::user()->id_empresa)->empresa_usuario;
        
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

            $stm = DB::select("SELECT * FROM v_usuarios WHERE id_empresa = ? AND index_por_cuenta = ? ",[$id_empresa,$user]);

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
            }
        }
   
        return view('contents.application.config.sist.usuario_e',$viewdata);
    }

    public function Eliminar(Request $request){

            $post = $request->all();
            $cod_usu_e = $post['cod_usu_e'];
            $response = new \stdClass();
            $usuarioEnUso = DB::select('call usp_verificarUsuarioActivo(?)', [$cod_usu_e])[0];

            if($usuarioEnUso->COD == 1) {$response->cod = 0; return json_encode($response);}

            $consulta = DB::select("SELECT count(*) AS total FROM tm_venta WHERE id_usu = ?",[($cod_usu_e)]);
            foreach($consulta as $a){
                $con = $a->total;
            }
            if($con == '0') {
                $consulta_eliminar = DB::delete("DELETE FROM tm_usuario WHERE id_usu = ?",[($cod_usu_e)]);
                $response->cod = 1;
                
            }else {
                dd("error");//Revisar
            }
            $response->usuarios_cant = TmUsuario::where('id_empresa',session('id_empresa'))->count();
            return json_encode($response);
    }

    public function Estado(Request $request){

        $post = $request->all();
        $cod_usu = $post['cod_usu'];
        $nuevo_estado = $post['estado'];
        TmUsuario::find($cod_usu)
                    ->update(['estado'=>$nuevo_estado]);

        $notification = [ 
            'message' =>'Registros modificados, Correctamente',
            'alert-type' => 'success'
        ];
       return redirect('/ajustesUsuarios')->with($notification);
    }

    public function GetAreasProdXSucursal(Request $request){
        
        $areas_prod = TmAreaProd::where('id_sucursal',$request->id_sucursal)->get();
        return $areas_prod;

    }
}
