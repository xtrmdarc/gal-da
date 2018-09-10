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
    //
      //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
      public function index(){
        
        if(\Auth::user()->id_rol == 1 )
        {
            $cajasAbiertas = DB::table('tm_aper_cierre')
                            ->select('tm_aper_cierre.id_apc','tm_caja.descripcion')
                            ->Join('tm_caja','tm_caja.id_caja','=','tm_aper_cierre.id_caja')
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

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d");
        $gasto = DB::table('v_gastosadm')->whereDate('fecha_re',$fecha)
                                ->Where('id_sucursal',session('id_sucursal'))
                                ->Where('id_usu',session('id_usu'))
                                ->get();
        $TDocumentos = TmTipoDoc::all();
        $personal = TmUsuario::where('id_sucursal',session('id_sucursal'));
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
        /*$alm = new Egreso();
        $alm->__SET('rating', $_REQUEST['rating']);
        $alm->__SET('id_tipo_doc', $_REQUEST['id_tipo_doc']);
        $alm->__SET('fecha_comp', date('Y-m-d',strtotime($_REQUEST['fecha_comp'])));
        $alm->__SET('serie_doc', $_REQUEST['serie_doc']);
        $alm->__SET('num_doc', $_REQUEST['num_doc']);
        $alm->__SET('id_per', $_REQUEST['id_per']);
        $alm->__SET('importe', $_REQUEST['importe']);
        $alm->__SET('motivo', $_REQUEST['motivo']);
        */
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
            //$this->conexionn->prepare($sql)->execute();
            //$this->conexionn=null; 

            //$this->model->Registrar($alm);
            //header('Location: lista_caja_egr.php?m=n');
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
        
        /*$alm = new Egreso();
        $alm->__SET('cod_ga',  $_REQUEST['cod_ga']);
        */
        //$this->model->Estado($alm);
        try 
        {   
            $data = $request->all();
            // "UPDATE tm_gastos_adm SET estado = 'i' WHERE id_ga = ?";
            TmGastosAdm::where('id_ga',$data['cod_ga'])
                        ->update(['estado'=>'i']);
            //$this->conexionn->prepare($sql)->execute(array($data->__GET('cod_ga')));
            //header('Location: lista_caja_egr.php?m=a');
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
