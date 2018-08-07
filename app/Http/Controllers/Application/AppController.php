<?php

namespace App\Http\Controllers\Application;

use App\Models\TmDatosEmpresa;
use App\Models\TmRol;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Application\AppController;
use App\Models\Sucursal;
use App\Models\Empresa;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackSent;

class AppController extends Controller
{
    //

    public static $home= "/home";
    public static $galdaMail = "dreyesc@gal-da.com";

    public static function LoginAuthenticated(Request $request, $user){

        session(['datosempresa'=> json_decode(json_encode(self::DatosEmpresa(\Auth::user()->id_empresa),true))]);
        session(['id_usu'=>\Auth::user()->id_usu]);

        $moneda = DB::select('SELECT moneda FROM db_rest.empresa where id = ?'
            ,array(\Auth::user()->id_empresa));
        foreach($moneda as $r) {
            $mon = $r->moneda;
        }

        $igv = DB::select('SELECT igv FROM db_rest.empresa where id = ?'
            ,array(\Auth::user()->id_empresa));
        foreach($igv as $r) {
            $igv_empresa = $r->igv;
        }

        session(['moneda_session'=>$mon]);
        session(['igv_session'=>$igv_empresa]);

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
                session(['id_sucursal'=>AppController::GetSucursales()[0]->id]);
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

    public static function DatosEmpresa($id_empresa){
        return (DB::table('empresa')->where('id',$id_empresa)->get())[0];
    }

    public function EnviarFeedback(Request $request){

        Mail::to(self::$galdaMail)->send(new FeedbackSent(\Auth::user(),$request->comentario));
        
    }

}
