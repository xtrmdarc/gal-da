<?php

namespace App\Http\Controllers\Application\Caja;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmTipoDoc;
use App\Models\TmUsuario;
use App\Models\TmGastosAdm;

class Egr_CajaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
      public function index(){
        
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
                            ->select('tm_aper_cierre.id_apc','tm_caja.descripcion','tm_turno.descripcion as t_des')
                            ->Join('tm_caja','tm_caja.id_caja','=','tm_aper_cierre.id_caja')
                            ->Join('tm_usuario','tm_usuario.id_usu','=','tm_aper_cierre.id_usu')
                            ->Join('tm_turno','tm_turno.id_turno','=','tm_aper_cierre.id_turno')
                            ->where('tm_usuario.id_usu',\Auth::user()->id_usu)
                            ->WhereNull('tm_aper_cierre.fecha_cierre')->get();
        }

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d");
        $gasto = DB::table('v_gastosadm')->whereDate('fecha_re',$fecha)
                                ->Where('id_sucursal',session('id_sucursal'))
                                ->Where('id_usu',session('id_usu'))
                                ->get();
        //$TDocumentos = TmTipoDoc::where('id_sucursal',session('id_sucursal'))->get();
        //$TDocumentos = DB::Select("SELECT * FROM tm_tipo_doc td  LEFT JOIN tipo_doc_empresa te ON te.id_tipo_doc =  td.id_tipo_doc where te.id_empresa = ?",[session('id_empresa')]);
        $TDocumentos = DB::Select("SELECT * FROM tm_tipo_doc td  LEFT JOIN tipo_doc_empresa te ON te.id_tipo_doc =  td.id_tipo_doc where te.id_empresa = ? and td.electronico in (0,?) ",[session('id_empresa'),session('datosempresa')->factura_e]);

        $personal = DB::table('v_usuarios')->where('id_sucursal',session('id_sucursal'))->get();
        $data = [

                'lista1'=> $gasto,
                'tdocumentos' => $TDocumentos,
                'personal' => $personal,
                'breadcrumb'=> 'egrcaja',
                'titulo_vista' => 'Egresos de caja',
                'cajas' => $cajasAbiertas
                ];
        return view('contents.application.caja.egr_caja')->with($data);
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
                $data['rating'],
                $data['id_tipo_doc'],
                $data['id_per'],
                $id_usu,
                $id_apc,
                $data['serie_doc'],
                $data['num_doc'],
                $data['fecha_comp'],
                $data['importe'],         
                $data['motivo'],
                $fecha,
                session('id_sucursal')
                );
            DB::insert("INSERT INTO tm_gastos_adm (id_tipo_gasto,id_tipo_doc,id_per,id_usu,id_apc,serie_doc,num_doc,fecha_comp,importe,motivo,fecha_registro,id_sucursal) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",$arrayParam);

            $notification = [ 
                'message' =>'Datos registrados, correctamente.',
                'alert-type' => 'success'
            ];
           return redirect('/caja/egr')->with($notification);
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Estado(Request $request){

        try 
        {   
            $data = $request->all();
            TmGastosAdm::where('id_ga',$data['cod_ga'])
                        ->update(['estado'=>'i']);

            $notification = [ 
                'message' =>'Datos anulados, correctamente.',
                'alert-type' => 'success'
            ];
           return redirect('/caja/egr')->with($notification);
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
}
