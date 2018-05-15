<?php

namespace App\Http\Controllers\Application\Caja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmIngresosAdm;

class Ing_CajaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        //date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d");
        $lista1 = TmIngresosAdm::WhereDate('fecha_reg',$fecha)
                                ->Where('id_sucursal',sesion('id_sucursal'))        
                                ->Where('id_usu',session('id_usu'))
                                ->get();
        

        $data = [
            'lista1' => $lista1,
            'breadcrumb'=> 'ingcaja'
        ];

        return view('contents.application.caja.ing_caja')->with($data);
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
                $id_usu,
                $id_apc,
                $data['importe'],         
                $data['motivo'],
                $fecha,
                session('id_sucursal')
                );
            DB::insert("INSERT INTO tm_ingresos_adm (id_usu,id_apc,importe,motivo,fecha_reg,id_sucursal) VALUES (?,?,?,?,?,?)",$arrayParam);
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
            TmIngresosAdm::where('id_ing',$data['cod_ing'])
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
