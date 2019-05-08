<?php

namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class MozosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
    }
    public function index()
    {
        $viewdata = [];
        //Mozos
        $stm = DB::Select("SELECT id_usu,CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS nombre FROM v_usuarios WHERE id_rol = 4 and id_empresa = ?",[session('id_empresa')]);
        $viewdata['Mozos'] = $stm;
        $data = [
            'breadcrumb'=>'inf_mozos',
            'titulo_vista' => 'Informe mozos'
        ];

        //Sucursales Filtro
        $sucursales_filtro = Sucursal::where('id_empresa',session('id_empresa'))->get();

        $viewdata['sucursales_filtro'] = $sucursales_filtro;
        return view('contents.application.informes.ventas.inf_mozos',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $sucu_filter = $request->input('sucu_filter');
        $cmozo = $post['cmozo'];

        $stm = DB::Select("SELECT v.fec_ven,v.desc_td,CONCAT(v.ser_doc,'-',v.nro_doc) AS numero,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total,v.id_cli,pm.id_mozo
                           FROM v_ventas_con AS v INNER JOIN tm_pedido_mesa AS pm ON v.id_ped = pm.id_pedido WHERE (date(v.fec_ven) >= ? AND date(v.fec_ven) <= ?) AND pm.id_mozo like ? AND id_sucursal like ? AND id_empresa = ? GROUP BY v.id_ven",
            array($ifecha,$ffecha,$cmozo,$sucu_filter,session('id_empresa')));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Mozo = DB::Select("SELECT CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS nombre FROM v_usuarios WHERE id_usu = ".$d->id_mozo)[0];

            $stm[$k]->Cliente = DB::Select("SELECT nombre FROM v_clientes WHERE id_cliente = ".$d->id_cli)[0];
        }
        $stmm = DB::Select("SELECT COUNT(v.id_ven) AS cantidad, IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total
                            FROM v_ventas_con AS v INNER JOIN tm_pedido_mesa AS pm ON v.id_ped = pm.id_pedido WHERE date(v.fec_ven) >= ? AND date(v.fec_ven) <= ? AND pm.id_mozo like ? AND id_sucursal like ? AND id_empresa = ?",
            array($ifecha,$ffecha,$cmozo,$sucu_filter,session('id_empresa')));

        $data = array("dato" => $stmm,"data" => $stm);
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

            $cmozo = $request->input('mozo');

            $stm = DB::Select("SELECT v.fec_ven as Fecha_Venta,v.desc_td as Documento,CONCAT(v.ser_doc,'-',v.nro_doc) AS Numero_Documento,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS Monto_total
                               FROM v_ventas_con AS v INNER JOIN tm_pedido_mesa AS pm ON v.id_ped = pm.id_pedido WHERE (date(v.fec_ven) >= ? AND date(v.fec_ven) <= ?) AND pm.id_mozo like ? AND id_sucursal like ? AND id_empresa = ? GROUP BY v.id_ven",
                array($start,$end,$cmozo,$sucu_filter,session('id_empresa')));
            /*
                foreach($stm as $k => $d)
                {
                    $stm[$k]->Mozo = DB::Select("SELECT CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS nombre FROM v_usuarios WHERE id_usu = ".$d->id_mozo)[0];

                    $stm[$k]->Cliente = DB::Select("SELECT nombre FROM v_clientes WHERE id_cliente = ".$d->id_cli)[0];
                }
                $stmm = DB::Select("SELECT COUNT(v.id_ven) AS cantidad, IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total
                                FROM v_ventas_con AS v INNER JOIN tm_pedido_mesa AS pm ON v.id_ped = pm.id_pedido WHERE v.fec_ven >= ? AND v.fec_ven <= ? AND pm.id_mozo like ? AND id_sucursal like ? AND id_empresa = ?",
                    array($ifecha,$ffecha,$cmozo,$sucu_filter,session('id_empresa')));
            */

            ob_end_clean();
            ob_start();

            return Excel::download(new ExportFromArray($stm),'inf-mozos-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
