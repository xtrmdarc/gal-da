<?php

namespace App\Http\Controllers\Config;

use App\Models\TmRol;
use App\Models\TmAreaProd;
use App\Models\TmUsuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class tm_usuarioController extends Controller
{
    public function index()
    {
        $viewdata = [];
        $stm = DB::select("SELECT id_usu,id_rol,ape_paterno,ape_materno,nombres,desc_r,estado FROM v_usuarios");
        $viewdata['users'] = $stm;

        return view('contents.config.sist.tm_usuario',$viewdata);
    }

    public function RegistrarUsuario()
    {
        $viewdata = [];
        $user_rol = TmRol::all();
        $viewdata['user_rol']= $user_rol;
        $viewdata['id_usu']= 1;

        return view('contents.config.sist.tm_usuario_r',$viewdata);
    }

    public function RUUsuario(Request $request){

        $post = $request->all();

        $flag = 1;
        $id_usu = $post['id_usu'];
        $imagen = $post['imagen'];
        $dni = $post['dni'];
        $nombres = $post['nombres'];
        $ape_paterno = $post['ape_paterno'];
        $ape_materno = $post['ape_materno'];
        $email = $post['email'];
        $id_rol = $post['id_rol'];

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

        if($id_usu != ''){
            $consulta = DB::select("call usp_configUsuario( :flag, :idRol, :idArea, :dni, :apeP, :apeM, :nomb, :email, :usu, :cont, :img, :idUsu);",
            array('2',$id_rol,$cod_area,$dni,$ape_paterno,$ape_materno,$nombres,$email,$usuario,$contrasena,$imagen,$id_usu));
            return redirect()->route('config.Usuarios');
        } else {
            $consulta = DB::select("call usp_configUsuario( :flag, :idRol, :idArea, :dni, :apeP, :apeM, :nomb, :email, :usu, :cont, :img, @a)"
                ,array($flag, $id_rol, $cod_area,$dni,$ape_paterno,$ape_materno,$nombres,$email,$usuario,$contrasena,$imagen));
            return redirect()->route('config.Usuarios');
        }
    }

    public function CrudUsuario(Request $request,$id_usu){

        $viewdata = [];
        $user = $id_usu;
        if(isset($user)){
            $user_rol = TmRol::all();
            $area_prod = TmAreaProd::all();
            $viewdata['user_rol']= $user_rol;
            $viewdata['area_prod']= $area_prod;
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

        return view('contents.config.sist.tm_usuario_e',$viewdata);
    }

    public function Eliminar(Request $request){

            $post = $request->all();
            $cod_usu_e = $post['cod_usu_e'];

            $consulta = DB::select("SELECT count(*) AS total FROM tm_venta WHERE id_usu = ?",[($cod_usu_e)]);
            foreach($consulta as $a){
                $con = $a->total;
            }
            if($con == '0') {
                $consulta_eliminar = DB::select("DELETE FROM tm_usuario WHERE id_usu = ?",[($cod_usu_e)]);
                return redirect()->route('config.Usuarios');
            }else {
                dd("error");
                //return redirect()->route('config.Usuarios');
            }
    }
}
