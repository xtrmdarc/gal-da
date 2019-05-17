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
use App\Models\Planes;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackSent;

class AppController extends Controller
{
    public static $home= "/";
    public static $galdaMail = "dreyesc@gal-da.com";

    public static function LoginAuthenticated(Request $request, $user){
        
        //dd($user,\Auth::user());
        switch($user->id_rol)
        {
            //Administracion
            case 1 : {
                    
                switch($user->plan_id)
                {
                    //Plan Free o lite
                    case 1 || 2: 
                    {
                        self::$home = "/tableroF";
                        session(['home'=>'/tableroF']);
                        break;
                    }
                    // //Plan Lite
                    // case 2:
                    // {
                    //     self::$home = "/tableroF";
                    //     session(['home'=>'/tableroF']);
                    //     break;
                    // }
                    // Plan basic o pro por ahora
                    default :
                    {
                        self::$home = "/tablero";
                        session(['home'=>'/tablero']);
                        break;
                    }
                }
                
                session(['id_sucursal'=>AppController::GetSucursales()[0]->id]);
                break;
            }
            //Cajero
            case 2 : {
                
                self::$home = "/inicio";
                session(['id_sucursal'=>AppController::GetSucursales()[0]->id]);
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
                session(['id_sucursal'=>AppController::GetSucursales()[0]->id]);
                break;
            }
            //Multimozo
            case 5 :{
                
                self::$home = "/inicio";
                session(['id_sucursal'=>AppController::GetSucursales()[0]->id]);
                break;
            }

        }
        //dd(self::$home);
        self::IniciarApp();
        //dd($user, self::$home,$user);
        return redirect(self::$home);
        
    }

    private static function IniciarApp(){
        
        session(['datosempresa'=> json_decode(json_encode(self::DatosEmpresa(\Auth::user()->id_empresa),true))]);
        session(['id_usu'=>\Auth::user()->id_usu]);
        session(['rol_usr'=>\Auth::user()->id_rol]);

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

        session(['id_empresa'=>\Auth::user()->id_empresa]);
        session(['moneda_session'=>$mon]);
        session(['moneda'=>$mon]);
        session(['igv_session'=>$igv_empresa]);
       
        if(\Auth::user()->id_rol == 1)  {
            
            $queryCajasAdmin = DB::table('tm_aper_cierre')
                ->Join('tm_caja','tm_caja.id_caja','=','tm_aper_cierre.id_caja')
                ->where('tm_caja.id_sucursal',session('id_sucursal'))
                ->WhereNull('tm_aper_cierre.fecha_cierre');
            
            if($queryCajasAdmin->exists())
            {
                $apertura = 1;
                session(['apertura'=>1]);
            }
        }
        else{
            $queryCajasCajero = DB::table('tm_aper_cierre')
                ->Join('tm_caja','tm_caja.id_caja','=','tm_aper_cierre.id_caja')
                ->Join('tm_usuario','tm_usuario.id_usu','=','tm_aper_cierre.id_usu')
                ->where('tm_usuario.id_usu',\Auth::user()->id_usu)
                ->WhereNull('tm_aper_cierre.fecha_cierre');
            if($queryCajasCajero->exists())
            {
                $apertura = 1;
                session(['apertura'=>1]);
            }
        }

        //Almacenar el plan en la session
        //$plan_actual = Planes::find(\Auth::user()->plan_id)->first();
        $plan_actual = Planes::where('id',\Auth::user()->plan_id)->first();
        //dd($plan_actual,\Auth::user()->plan_id);
        session(['plan_actual'=>$plan_actual]);
        //dd('llega a login event ',$plan_actual);
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
        session(['id_apc'=>0]);
    }

    public static function DatosEmpresa($id_empresa){
        return (DB::table('empresa')->where('id',$id_empresa)->get())[0];
    }

    public function EnviarFeedback(Request $request){
        DB::table('tm_usuario')->update([
            'free_feedback_sent' => 1
        ]);
        Mail::to(self::$galdaMail)->send(new FeedbackSent(\Auth::user(),$request->comentario));
    }

    public function UserOnboarded(Request $request){
        
        DB::table('tm_usuario')->where('id_usu',\Auth::user()->id_usu)
                            ->update([
                                'user_onboarded'=>1
                            ]);
        return json_encode(1);
    }

    public static function SetSucursalPrincipalActiva()
    {
        $sucursal_principal =DB::table('sucursal')->where('plan_estado',1)
                            ->where('id_empresa',session('id_empresa'))->first();
        session(['id_sucursal'=>$sucursal_principal->id]);
        return $sucursal_principal->id;
    }


}
