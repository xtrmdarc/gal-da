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
    }
      public function index(){
        
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d");
        $gasto = DB::table('v_gastosadm')->whereDate('fecha_re',$fecha)
                                ->Where('id_usu',session('id_usu'))
                                ->get();
        $TDocumentos = TmTipoDoc::all();
        $personal = TmUsuario::all();
        $data = [

                'lista1'=> $gasto,
                'tdocumentos' => $TDocumentos,
                'personal' => $personal,
                'breadcrumb'=> 'egrcaja'
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
            $id_apc = session('id_apc');
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
                );
            DB::insert("INSERT INTO tm_gastos_adm (id_tipo_gasto,id_tipo_doc,id_per,id_usu,id_apc,serie_doc,num_doc,fecha_comp,importe,motivo,fecha_registro) VALUES (?,?,?,?,?,?,?,?,?,?,?)",$arrayParam);
            //$this->conexionn->prepare($sql)->execute();
            //$this->conexionn=null; 

            //$this->model->Registrar($alm);
            //header('Location: lista_caja_egr.php?m=n');
            header('Location: /');
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
                        ->update('estado','i');
            //$this->conexionn->prepare($sql)->execute(array($data->__GET('cod_ga')));
            //header('Location: lista_caja_egr.php?m=a');

            header('Location: /');
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }

        
    }

}
