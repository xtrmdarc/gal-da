<?php

namespace App\Http\Controllers\Login;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmCaja;
use App\Models\TmTurno;
use App\Models\TmUsuario;
use App\Models\TmDatosEmpresa;
class login extends Controller
{
    //

    public function index(){
     

      $cajas = TmCaja::where('estado','a')->get();
      $turno = TmTurno::all();
      $data = [
        'cajas' => $cajas,
        'turnos' => $turno
      ];
      
      return view('contents.Login.login')->with( $data );

    }

    public function login(Request $request){

    $_POST = $request->all();
    if(isset($_POST["txt_usuario"]) and isset($_POST["txt_password"])){

      $usuario_login =trim($_POST["txt_usuario"]);
      $usuario_clave=trim($_POST["txt_password"]);
      $rol=trim($_POST["txt_rol"]);
      $caja=trim($_POST["txt_caja"]);
      $turno=trim($_POST["txt_turno"]);
      
      //Declaramos el Objeto
      //$objeto_usuario = new Usuarios();
      //$login=$objeto_usuario->Login($usuario_login,$usuario_clave,$rol);
      $whereLogin = ['usuario'=>$usuario_login,'contrasena'=>$usuario_clave,'id_rol'=>$rol,'estado'=>'a'];
      $login = TmUsuario::where($whereLogin) ? 1 : 0;
      //$datos_usuario=$objeto_usuario->DatosUsuario($usuario_login);
      $datos_usuario = DB::table('v_usuarios')->where('usuario',$usuario_login)->get();
      //$datos_empresa=$objeto_usuario->DatosEmpresa();
      $datos_empresa = TmDatosEmpresa::all();
      //dd($datos_empresa);
      //$apc=$objeto_usuario->AperCaja($usuario_login,$caja,$turno);
      //$apc = DB::table("SELECT au.usuario FROM tm_usuario AS au INNER JOIN tm_aper_cierre AS ta ON au.id_usu = ta.id_usu WHERE au.usuario = ? AND ta.id_caja = ? AND ta.id_turno = ? AND ta.estado = 'a'",[$usuario_login,$caja,$turno])->length()>0 ? 1: 0;
      $apc = DB::table('tm_usuario')->join('tm_aper_cierre','tm_usuario.id_usu','=','tm_aper_cierre.id_usu')->where(['tm_usuario.usuario' => $usuario_login,'tm_aper_cierre.id_caja'=> $caja,'tm_aper_cierre.id_turno'=>$turno,'tm_aper_cierre.estado'=>'a'])->exists() ? 0: 1;

      session(['datosusuario'=>$datos_usuario]);
      
      if($login == 1){
        //INGRESA AL SISTEMA
        //dd(session('datosusuario'));
        $almm = session('datosusuario');

        //dd($almm);
        foreach ($almm as $reg) {

          if($reg->id_rol ==1){
            //ADMINISTRADOR
              //$datos_caja=$objeto_usuario->DatosCaja($usuario_login,$caja,$turno);
              $datos_caja = DB::select("SELECT vc.id_apc,vc.id_caja,vc.id_turno,vc.desc_caja,vc.desc_turno FROM v_caja_aper AS vc INNER JOIN tm_usuario AS au ON vc.id_usu = au.id_usu WHERE au.usuario = ? AND vc.id_caja = ? AND vc.id_turno = ? AND vc.estado = 'a'",[$usuario_login,$caja,$turno]);

              $objeto_usuario=NULL;
              session_start();
              
              session(['datosusuario'=>$datos_usuario]);
              session(['datosempresa'=>$datos_empresa]);
              session(['datoscaja'=>$datos_caja]);
              
              $du = session('datosusuario');
              
              foreach ($du as $d) {
                $id_usu = $d->id_usu;
              }
              
              $de = session('datosempresa');
              
              foreach ($de as $d) {
                $igv = ($d->igv / 100);
                $moneda = $d->moneda;
              }
    
              $dc = session('datoscaja');
              foreach ($dc as $d) {
                $id_apc = $d->id_apc;
              }
    
              session(['id_usu'=> $id_usu]);
              session(['igv'=>$igv]);
              session(['moneda'=> $moneda]);
              session(['id_apc'=> $id_apc]);
              session(['apertura'=> $apc]);
              session(['rol_usr'=> $reg->id_rol]);
    
            if($apc == 1){
              //CAJA APERTURADA
                header("Location: ../lista_tm_tablero.php");
                
              } else{
                //CAJA SIN APERTURAR
                header("Location: ../advertencia.php");
              }
            
          }else if($reg->id_rol==2){
            //CAJERO
            $datos_caja = $objeto_usuario->DatosCaja($usuario_login,$caja,$turno);
            if($apc == 1){
              //CAJA APERTURADA
              $objeto_usuario=NULL;
              session_start();
    
              session(['datosusuario'=>$datos_usuario]);
              session(['datosempresa'=>$datos_empresa]);
              session(['datoscaja'=>$datos_caja]);
    
              $du = session('datosusuario');
              foreach ($du as $d) {
                $id_usu = $d->id_usu;
              }
    
              $de = session('datosempresa');
              foreach ($de as $d) {
                $igv = ($d->igv / 100);
                $moneda = $d->moneda;
              }
    
              $dc = session('datoscaja');
              foreach ($dc as $d) {
                $id_apc = $d->id_apc;
              }
    
            
              session(['id_usu'=> $id_usu]);
              session(['igv'=>$igv]);
              session(['moneda'=> $moneda]);
              session(['id_apc'=> $id_apc]);
              session(['apertura'=> $apc]);
              session(['rol_usr'=> $reg->id_rol]);
                  
              header("Location: ../inicio.php");
                
            } else {
              //CAJA NO APERTURADA
              header("Location: ../index.php?me=a");
            }
    
          }else if($reg->id_rol==3){
    
            //AREA DE PRODUCCION
            $objeto_usuario=NULL;
            session_start();
            session(['datosusuario'=>$datos_usuario]);
            session(['datosempresa'=>$datos_empresa]);
    
            $du = session('datosusuario');
            foreach ($du as $d) {
              $id_areap = $d->id_areap;
            }
            session(['id_areap'=>$id_areap]);
              header("Location: ../lista_area_prod.php");
    
          }else if($reg->id_rol==4){
    
            //MOSO
            $objeto_usuario=NULL;
            session_start();
            session(['datosusuario'=>$datos_usuario]);
            
            $du = session('datosusuario');
            foreach ($du as $d) {
              $id_usu = $d->id_usu;
            }
    
            session(['datosempresa'=>$datos_empresa]);
            $de = session('datosempresa');
            foreach ($de as $d) {
              $moneda = $d->moneda;
            }

            session(['id_usu'=> $id_usu]);
            session(['moneda'=> $moneda]);
            session(['apertura'=> 1]);
            session(['rol_usr'=> $reg->id_rol]);
            
            header("Location: ../inicio.php");
    
          }else {
            header("Location: ../index.php");
          }
        }
      }else{
        //NO INGRESA AL SISTEMA
        header("Location: ../index.php?m=e");
      }						
    }
  }



}
