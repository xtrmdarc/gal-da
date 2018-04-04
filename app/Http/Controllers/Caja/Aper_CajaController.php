<?php

namespace App\Http\Controllers\Caja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\TmUsuario;
use App\Models\TmCaja;
use App\Models\TmTurno;


class Aper_CajaController extends Controller
{
    //
    public function index(){
        
        //Query views
        //$cajas = DB::table('v_caja_aper')->where('estado','<>','c')->get();   
        $cajeros = TmUsuario::Where('estado','a')
                            ->WhereIn('id_rol',array(1,2))->get();
        
        $cajas = TmCaja::Where('estado','a')->get();
        
        $turnos = TmTurno::all();
        $data =
            [
                'cajeros' => $cajeros,
                'cajas'=> $cajas,
                'turnos' => $turnos
            ];        


        return view('contents.caja.aper_caja')->with($data);
                //->with($data);
    }

    public function datos(Request $request){
    
        $arr = DB::table('V_caja_aper')->where('estado','<>','c')
                                ->get();
        
        echo json_encode($arr);
        
    }

    public function Guardar(){
        
       /* $alm = new Caja();
        $alm->__SET('cod_apc', $_REQUEST['cod_apc']);
        $alm->__SET('id_usu', $_REQUEST['id_usu']);
        $alm->__SET('id_caja', $_REQUEST['id_caja']);
        $alm->__SET('id_turno', $_REQUEST['id_turno']);
        $alm->__SET('monto', $_REQUEST['monto']);
        $alm->__SET('monto_sistema', $_REQUEST['monto_sistema']);
        $alm->__SET('fecha_cierre', date('Y-m-d H:i:s',strtotime($_REQUEST['fecha_cierre'])));
        */
        try{

            $data = $request->all();
            $data['fecha_cierre'] = date('Y-m-d H:i:s',strtotime($data['fecha_cierre']));
    
            if($data['cod_apc'] != ''){
    
                $row = $this->model->Actualizar($alm);
                $arrayParam =  array(
                    ':flag' => 1,
                    ':idApc' => $data['cod_apc'],
                    ':fechaC' => $data['fecha_cierre'],
                    ':montoC' => $data['monto'],
                    ':montoS' => $data['monto_sistema']
                );
                $row = DB::select("call usp_cajaCerrar( :flag, :idApc, :fechaC, :montoC, :montoS)",$arrayParam)[0];
                
                /*$st = $this->conexionn->prepare($consulta);
                $st->execute($arrayParam);
                $row = $st->fetch(PDO::FETCH_ASSOC);
                */
    
               if ($row->dup == 1){
                    session(['apertura'=> 0]);
                    //header('Location: lista_caja_aper.php?m=c');
                    header('Location: /');
               } else {
                    //header('Location: lista_caja_aper.php?m=d');
               }
    
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
                    ':montoA' => $data['monto']
                );
                $row = DB::select("call usp_cajaAperturar( :flag, :idUsu, :idCaja, :idTurno, :fechaA, :montoA)",$arrayParam)[0];
                
                /*$st = $this->conexionn->prepare($consulta);
                $st->execute($arrayParam);
                $row = $st->fetch(PDO::FETCH_ASSOC);
                return $row;*/
                
               //$row = $this->model->Registrar($alm);
    
               if ($row->dup == 0){
                    $du = session("datosusuario");
                    foreach ($du as $reg) { 
                        if($reg['id_usu'] == $data['id_usu']) {
                            session(['apertura'=> 1]);
                        }
                    }
                    //$_SESSION["id_apc"] = $row['cod'];
                    session(['id_apc'=>$row->cod]);
                    //header('Location: lista_caja_aper.php?m=n');
                    header('Location: /');
               }else {
                    header('Location: lista_caja_aper.php?m=d');
               }
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


        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven <= ?) AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
       
        $datos = DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",[$data['cod_apc']]);
        $arr->put('Datos',$datos);
       
        $ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= ?' AND fecha_reg <= ? ) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Ingresos',$ingresos);
        
        $gastos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >= ? AND fecha_re <= ?) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Gastos',$gastos);
        
        echo json_encode($arr);
    }

    public function montoSisDet(Request $request){
    
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        $data = $request->all();

        $fecha_ape = date('Y-m-d H:i:s',strtotime($data['fecha_aper']));
        $fecha_cie = date("Y-m-d H:i:s");
        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven <= ?) AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$data['cod_apc']] );
        
        $datos = DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",$data['cod_apc']);
        $arr->put('Datos',$datos);
        
        $ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= ? AND fecha_reg <= ) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Ingresos',$ingresos);
        
        $gatos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >=  AND fecha_re <= ?) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$data['cod_apc']]);
        $arr->put('Gastos',$gastos);
        
        echo json_encode($arr);
    }

}
