<?php

namespace App\Http\Controllers\Application;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Application\AppController;
use App\Models\Sucursal;
use App\Models\Empresa;

class AppController extends Controller
{
    //

    public static $home= "/home";

    public static function LoginAuthenticated(Request $request, $user){

        switch($user->id_rol)
        {
            //Administracion
            case 1 : {
                if($user->plan_id != 1){
                    self::$home = "/tablero";
                    //dd($home);
                } else {
                    if($user->plan_id == 1) {
                        self::$home = "/tableroF";
                        //dd($home);
                    }
                }
                break;
            }
            //Cajero
            case 2 : {
                
                self::$home = "/inicio";
                break;
            }
            //Produccion
            case 3 :{
                
                self::$home = "/cocina";
                //$sucursales =  AppController::GetSucursales();
                session(['id_sucursal'=>AppController::GetSucursales()[0]->id]);
                session(['id_areap'=>\Auth::user()->id_areap]);
                break;
            }
            //Mozo
            case 4 :{
                
                self::$home = "/inicio";
                break;
            }
            //Multimozo
            case 5 :{
                
                self::$home = "/inicio";
                break;
            }

        }
        
        return redirect(self::$home);
        
    }
    public static function ValidarPermisos($roles){
        
        $rol = \Auth::user()->id_rol;

        if (is_array($roles)) {

            for($i = 0; i< $roles.count() ; $i++){
                if($roles[i] == $rol ) return true;
            }
            return false;
        }

        if( $rol == $roles )
            return true;
        return false;

    }
    public static function RedirectSegunRol($roles){
        
        if( self::ValidarPermisos($roles) == true){
            
            return redirect(self::$home);
        }
    }
    public static function GetSucursales(){
        
        $id_sucursal = \Auth::user()->id_sucursal;
        $rol = \Auth::user()->id_rol;
        $id_empresa = \Auth::user()->id_empresa;
        if($rol != 1)
        {
            return Sucursal::where('id',$id_sucursal)->get();
        }
        else
        {
            return Sucursal::where('id_empresa',$id_empresa)->get();
        }
        

    }
    public function CambioSucursal($id){
        session(['id_sucursal'=> $id]);
    }

}
