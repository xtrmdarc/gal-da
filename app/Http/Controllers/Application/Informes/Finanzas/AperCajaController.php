<?php

namespace App\Http\Controllers\Application\Informes\Finanzas;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class AperCajaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('vActualizacion');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_apercaja',
            'titulo_vista' => 'Informe de cajas'
        ];

        //Sucursales Filtro
        $sucursales_filtro = Sucursal::where('id_empresa',session('id_empresa'))->get();

        $viewdata['sucursales_filtro'] = $sucursales_filtro;
        return view('contents.application.informes.finanzas.inf_cajas',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $sucu_filter = $post['sucu_filter'];

        $stm = DB::Select("SELECT * FROM v_caja_aper WHERE DATE(fecha_a) >= ? AND DATE(fecha_a) <= ? and id_sucursal like ? and id_empresa = ?",
            array($ifecha,$ffecha,$sucu_filter,session('id_empresa')));

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    //MONTO DEL SISTEMA
    public function MontoSis(Request $request)
    {
        $post = $request->all();

        $fecha_ape = date('Y-m-d H:i:s',strtotime($post['fecha_ape']));
        $fecha_cie = date("Y-m-d H:i:s");
        $arr = DB::select("SELECT IFNULL(SUM(IF(id_tpag = 1,pago_efe,pago_efe)),0) AS total_i FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven <= ?) AND id_apc = ? AND estado <> 'i'",[$fecha_ape,$fecha_cie,$post['cod_apc']])[0];

        $arr->Datos = DB::select("SELECT * FROM v_caja_aper WHERE id_apc = ?",[$post['cod_apc']])[0];
        //$arr->put('Datos',$datos);

        $arr->Ingresos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_i FROM tm_ingresos_adm WHERE (fecha_reg >= ? AND fecha_reg <= ? ) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$post['cod_apc']])[0];
        //$arr->put('Ingresos',$ingresos);

        $arr->Gastos = DB::select("SELECT IFNULL(SUM(importe),0) AS total_g FROM v_gastosadm WHERE (fecha_re >= ? AND fecha_re <= ?) AND id_apc = ? AND estado='a'",[$fecha_ape,$fecha_cie,$post['cod_apc']])[0];
        //$arr->put('Gastos',$gastos);

        echo json_encode($arr);
    }

    public function ExportExcel(Request $request)
    {
        try{

            $start = date('Y-m-d',strtotime($request->input('start')));
            $end = date('Y-m-d',strtotime($request->input('end')));
            $sucu_filter = $request->input('sucu_filter');

            $_SESSION["min-1"] = $_REQUEST['start'];
            $_SESSION["max-1"] = $_REQUEST['end'];

            $stm = DB::Select("SELECT fecha_a as Fecha_Apertura,fecha_c as Fecha_cierre,monto_a as Monto_aperturado,monto_c as Monto_estimado,monto_s as Monto_real,estado as Estado,desc_per as Nombre_Cajero,desc_caja as Nombre_Caja,desc_turno as Turno FROM v_caja_aper WHERE DATE(fecha_a) >= ? AND DATE(fecha_a) <= ? and id_sucursal like ? and id_empresa = ?",
                array($start,$end,$sucu_filter,session('id_empresa')));

            ob_end_clean();
            ob_start();

            return Excel::download(new ExportFromArray($stm),'inf-apertura-y-cierre-caja-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
