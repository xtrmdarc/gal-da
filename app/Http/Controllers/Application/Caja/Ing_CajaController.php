<?php

namespace App\Http\Controllers\Application\Caja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TmIngresosAdm;
use App\Models\TmCaja;

class Ing_CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index(){

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d");
        $lista1 = TmIngresosAdm::WhereDate('fecha_reg',$fecha)
                                ->Where('id_sucursal',session('id_sucursal'))
                                ->Where('id_usu',session('id_usu'))
                                ->get();
        
        if(\Auth::user()->id_rol == 1 )
        {
            $cajasAbiertas = DB::table('tm_aper_cierre')
                            ->select('tm_aper_cierre.id_apc','tm_caja.descripcion','tm_turno.descripcion as t_des')
                            ->Join('tm_caja','tm_caja.id_caja','=','tm_aper_cierre.id_caja')
                            ->Join('tm_turno','tm_turno.id_turno','=','tm_aper_cierre.id_turno')
                            ->where('tm_caja.id_sucursal',session('id_sucursal'))
                            ->WhereNull('tm_aper_cierre.fecha_cierre')->get();

        }
        else{
            $cajasAbiertas = DB::table('tm_aper_cierre')
                            ->select('tm_aper_cierre.id_apc','tm_caja.descripcion')
                            ->Join('tm_caja','tm_caja.id_caja','=','tm_aper_cierre.id_caja')
                            ->Join('tm_usuario','tm_usuario.id_usu','=','tm_aper_cierre.id_usu')
                            ->where('tm_usuario.id_usu',\Auth::user()->id_usu)
                            ->WhereNull('tm_aper_cierre.fecha_cierre')->get();
        }
        
        $data = [
            'lista1' => $lista1,
            'breadcrumb'=> 'ingcaja',
            'titulo_vista' => 'Ingresos de caja',
            'cajas' => $cajasAbiertas
        ];

        return view('contents.application.caja.ing_caja')->with($data);
    }

    public function Guardar(Request $request){

        try
        {
            $data = $request->all();
            date_default_timezone_set('America/Lima');
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = session('id_usu');
            $id_apc = $data['cb_caja'];

            $arrayParam= array(
                $id_usu,
                $id_apc,
                $data['importe'],         
                $data['motivo'],
                $fecha,
                session('id_sucursal')
                );
            DB::insert("INSERT INTO tm_ingresos_adm (id_usu,id_apc,importe,motivo,fecha_reg,id_sucursal) VALUES (?,?,?,?,?,?)",$arrayParam);

            $notification = [ 
                'message' =>'Datos registrados, correctamente.',
                'alert-type' => 'success'
            ];
           return redirect('/caja/ing')->with($notification);
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Estado(Request $request){

        try 
        {   
            $data = $request->all();
            TmIngresosAdm::where('id_ing',$data['cod_ing'])
                        ->update(['estado'=>'i']);

            $notification = [ 
                'message' =>'Datos anulados, correctamente',
                'alert-type' => 'success'
            ];
           return redirect('/caja/ing')->with($notification);
          
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
}
