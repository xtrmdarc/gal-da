<?php

namespace App\Http\Controllers\Application\Informes\Ventas;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class FPagoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
        $this->middleware('userRol');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_fpago',
            //'titulo_vista' => 'Informe '
        ];

        //Sucursales Filtro
        $sucursales_filtro = Sucursal::where('id_empresa',session('id_empresa'))->get();

        $viewdata['sucursales_filtro'] = $sucursales_filtro;
        return view('contents.application.informes.ventas.inf_fpagos',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $sucu_filter = $request->input('sucu_filter');

        $tpag = $post['tpag'];
        $stm = DB::Select("SELECT id_ped,id_tpag,pago_efe,pago_tar,fec_ven,desc_td,CONCAT(ser_doc,'-',nro_doc) AS numero,IFNULL(SUM(pago_efe+pago_tar),0) AS total,id_cli
                           FROM v_ventas_con WHERE (date(fec_ven) >= ? AND date(fec_ven) <= ?) AND id_tpag like ? AND id_sucursal like ? AND id_empresa = ? GROUP BY id_ven",
            array($ifecha,$ffecha,$tpag,$sucu_filter,session('id_empresa')));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Cliente = DB::Select("SELECT nombre FROM v_clientes WHERE id_cliente = ".$d->id_cli)[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function ExportExcel(Request $request)
    {
        try{

            $start = date('Y-m-d',strtotime($request->input('start')));
            $end = date('Y-m-d',strtotime($request->input('end')));
            $sucu_filter = $request->input('sucu_filter');

            $_SESSION["min-1"] = $_REQUEST['start'];
            $_SESSION["max-1"] = $_REQUEST['end'];

            $tpag = $request->input('tipo_p');

            $stm = DB::Select("SELECT fec_ven as Fecha_de_Venta,desc_td as Documento,CONCAT(ser_doc,'-',nro_doc) AS Num_doc,id_tpag as Tipo_de_pago,pago_efe as Pago_efectivo,pago_tar as Pago_tarjeta,IFNULL(SUM(pago_efe+pago_tar),0) AS Total_Venta
                               FROM v_ventas_con WHERE (date(fec_ven) >= ? AND date(fec_ven) <= ?) AND id_tpag like ? AND id_sucursal like ? AND id_empresa = ? GROUP BY id_ven",
                array($start,$end,$tpag,$sucu_filter,session('id_empresa')));

            ob_end_clean();
            ob_start();

            return Excel::download(new ExportFromArray($stm),'inf-fpago-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

}
