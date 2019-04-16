<?php

namespace App\Http\Controllers\Application\Caja;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TmUsuario;
use App\Models\TmCaja;
use App\Models\TmTurno;

class Aper_CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index(){

        $id_usu = \Auth::user()->id_usu;
        $id_parentId = \Auth::user()->parent_id;
        $user_rol = \Auth::user()->id_rol;

        if($user_rol == '1'){

            $cajeros = TmUsuario::Where('estado','a')
                ->Where('parent_id',$id_usu)
                ->Where('id_sucursal',session('id_sucursal'))
                ->WhereIn('id_rol',array(1,2))->get();

            $cajas = TmCaja::Where('estado','a')
                ->Where('id_usu',$id_usu)
                ->Where('id_sucursal',session('id_sucursal'))
                ->get();

        }else if($user_rol == '2'){

            $cajeros = TmUsuario::Where('estado','a')
                ->Where('parent_id',$id_parentId)
                ->Where('id_sucursal',session('id_sucursal'))
                ->WhereIn('id_rol',array(2))->get();

            $cajas = TmCaja::Where('estado','a')
                ->Where('id_usu',$id_parentId)
                ->Where('id_sucursal',session('id_sucursal'))
                ->get();
        }

        $turnos = TmTurno::where('id_sucursal',session('id_sucursal'))
                            ->get();
        $data =
            [
                'cajeros' => $cajeros,
                'cajas'=> $cajas,
                'turnos' => $turnos,
                'breadcrumb'=> 'apercaja',
                'titulo_vista' => 'Apertura y Cierre de Caja'

            ];        

        return view('contents.application.caja.aper_caja')->with($data);
    }

    public function datos(Request $request){
    
        $arr = DB::table('v_caja_aper')
                ->where('estado','<>','c')
                ->Where('id_sucursal',session('id_sucursal'))
                ->get();
        
        echo json_encode($arr);
    }

    public function Guardar(Request $request){

        $user_parentId = \Auth::user()->parent_id;
        $user_rol = \Auth::user()->id_rol;

        try{

            $data = $request->all();
            
    
            if( isset($data['cod_apc'])  ){
                $data['fecha_cierre'] = date('Y-m-d H:i:s',strtotime($data['fecha_cierre']));
                $arrayParam =  array(
                    ':flag' => 1,
                    ':idApc' => $data['cod_apc'],
                    ':fechaC' => $data['fecha_cierre'],
                    ':montoC' => $data['monto'],
                    ':montoS' => $data['monto_sistema']
                );
                $row = DB::select("call usp_cajaCerrar( :flag, :idApc, :fechaC, :montoC, :montoS)",$arrayParam)[0];

               if ($row->dup == 1){
                    session(['apertura'=> 0]);
                    session(['id_apc'=> 0]);
                    
                    $notification = [ 
                        'message' =>'Caja cerrada, correctamente',
                        'alert-type' => 'success'
                    ];
                   
               } else {
                    
                    $notification = [ 
                        'message' =>'Advertencia, Datos duplicados.',
                        'alert-type' => 'warning'
                    ];
               }
                    return redirect('/caja/aper')->with($notification);
            }else{
                
                date_default_timezone_set('America/Lima');
                setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                $fecha = date("Y-m-d H:i:s");
                
                $arrayParam =  array(
                    ':flag' => 1,
                    ':idUsu' => $data['id_usu'],
                    ':idCaja' => $data['id_caja'],
                    ':idTurno' => $data['id_turno'],
                    ':fechaA' =>  $fecha,
                    ':montoA' => $data['monto'],
                    ':parentId' => $user_parentId
                );

                if($user_rol == '1'){
                    $arrayParam[':parentId'] =  $data['id_usu'];
                    $row = DB::select("call usp_cajaAperturar_g( :flag, :idUsu, :idCaja, :idTurno, :fechaA, :montoA, :parentId)",$arrayParam)[0];
                }else if($user_rol == '2'){
                    $row = DB::select("call usp_cajaAperturar_g( :flag, :idUsu, :idCaja, :idTurno, :fechaA, :montoA, :parentId)",$arrayParam)[0];
                }

               if ($row->dup == 0){

                    if(\Auth::user()->id_usu == $data['id_usu'] || \Auth::user()->id_rol == 1 ) session(['apertura'=> 1]);
                    session(['id_apc'=>$row->cod]);

                    $notification = [ 
                        'message' =>'La caja se aperturó correctamente',
                        'alert-type' => 'success'
                    ];
                    
               }else {
                    
                    $notification = [ 
                        'message' =>'Advertencia, Apertura duplicada',
                        'alert-type' => 'warning'
                    ];
               }
               return redirect('/caja/aper')->with($notification);
            }

        }
        catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function montoSis(Request $request){
    
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        $data = $request->all();
        $fecha_ape = date('Y-m-d H:i:s',strtotime($data['fecha_ape']));
        $fecha_cie = date('Y-m-d H:i:s',strtotime($data['fecha_cie']));


        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven <= ?) AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$data['cod_apc']])[0];
       
        $arr->Datos = DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",[$data['cod_apc']])[0];
       
        $arr->Ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= ? AND fecha_reg <= ? ) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']])[0];

        $arr->Gastos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >= ? AND fecha_re <= ?) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']])[0];

        echo json_encode($arr);
    }

    public function montoSisDet(Request $request){
    
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        $data = $request->all();

        $fecha_ape = date('Y-m-d H:i:s',strtotime($data['fecha_aper']));
        $fecha_cie = date("Y-m-d H:i:s");
        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven <= ?) AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$data['cod_apc']] )[0];

        $arr->Datos =  DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",[$data['cod_apc']])[0];
        
        $arr->Ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= ? AND fecha_reg <= ?) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']])[0];

        $arr->Gastos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >= ?  AND fecha_re <= ?) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']])[0];

        echo json_encode($arr);
    }

  
}
