<?php

namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    //
    public function index()
    {
        $viewdata = [];
        $data = [
            'breadcrumb'=>'inf_ventas'
        ];
        //Tipo de Pedido
        $stm = DB::Select("SELECT * FROM tm_tipo_pedido");

        //Clientes
        $stm_clientes = DB::Select("SELECT id_cliente,nombre FROM v_clientes where id_sucursal = ?",[session('id_sucursal')]);

        //Cajas
        $stm_cajas = DB::Select("SELECT * FROM tm_caja where id_sucursal = ?",[session('id_sucursal')]);

        //Comprobantes
        $stm_comprobantes = DB::Select("SELECT * FROM tm_tipo_doc where id_sucursal = ?",[session('id_sucursal')]);

        $viewdata['TipoPedido'] = $stm;
        $viewdata['Clientes'] = $stm_clientes;
        $viewdata['Cajas'] = $stm_cajas;
        $viewdata['Comprobantes'] = $stm_comprobantes;

        return view('contents.application.informes.ventas.inf_ventas',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d H:i:s',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d H:i:s',strtotime($post['ffecha']));
        $stm = DB::Select("SELECT v.id_ven,v.id_ped,v.id_tpag,v.pago_efe,v.pago_tar,v.descu,v.total AS stotal,v.fec_ven,v.desc_td,CONCAT(v.ser_doc,'-',v.nro_doc) AS numero,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total,v.id_cli,v.igv,v.id_usu,c.desc_caja FROM v_ventas_con AS v INNER JOIN v_caja_aper AS c ON v.id_apc = c.id_apc WHERE (v.fec_ven >= ? AND v.fec_ven <= ?) AND v.id_tped like ? AND v.id_tdoc like ? AND c.id_caja like ? AND v.id_cli like ? and v.id_sucursal = ? GROUP BY v.id_ven",
            array($ifecha,$ffecha,$post['tped'],$post['tdoc'],$post['icaja'],$post['cliente'],session('id_sucursal')));
        foreach($stm as $k => $d)
        {
            $stm[$k]->Cliente = DB::select("SELECT nombre FROM v_clientes WHERE id_cliente = ?",[$d->id_cli])[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }
    public function ExportExcel(Request $request)
    {
        $start = date('Y-m-d',strtotime($request->input('start')));
        $end = date('Y-m-d',strtotime($request->input('end')));
        $cod_cajas = $request->input('cod_cajas');
        $tipo_doc = $request->input('tipo_doc');

        $_SESSION["min-1"] = $_REQUEST['start'];
        $_SESSION["max-1"] = $_REQUEST['end'];

        $stm = DB::Select("SELECT v.id_ped,v.id_tpag,v.pago_efe,v.pago_tar,v.descu,v.fec_ven,v.desc_td,v.ser_doc,v.nro_doc,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total,v.id_cli,v.igv,v.id_usu,c.desc_caja FROM v_ventas_con AS v INNER JOIN v_caja_aper AS c ON v.id_usu = c.id_usu WHERE (DATE(v.fec_ven) >= ? AND DATE(v.fec_ven) <= ?) AND v.id_tdoc like ? AND c.id_caja like ? GROUP BY v.id_ven",
            array($start,$end,$tipo_doc,$cod_cajas));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Cliente = DB::Select("SELECT nombre, CONCAT(dni,'',ruc) AS numero FROM v_clientes WHERE id_cliente = ".$d->id_cli)[0];
        }

        return redirect('/creditos');
        require_once 'view/informes/ventas/exportar/inf_ventas_xls.php';
    }
    public function Detalle(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod'];
        $stm = DB::Select("SELECT id_prod,SUM(cantidad) AS cantidad,precio FROM tm_detalle_venta WHERE id_venta = ? GROUP BY id_prod",
            array($cod));
        foreach($stm as $k => $d)
        {
            $stm[$k]->Producto = DB::Select("SELECT nombre_prod,pres_prod FROM v_productos WHERE id_pres = ".$d->id_prod)[0];
        }
        return $stm;
    }
    /*public function informeVentasF()
    {
        $viewdata = [];
        $data = [
            'breadcrumb'=>'inf_ventas'
        ];
        //Tipo de Pedido
        $stm = DB::Select("SELECT * FROM tm_tipo_pedido");

        //Clientes
        $stm_clientes = DB::Select("SELECT id_cliente,nombre FROM v_clientes");

        //Cajas
        $stm_cajas = DB::Select("SELECT * FROM tm_caja");

        $viewdata['TipoPedido'] = $stm;
        $viewdata['Clientes'] = $stm_clientes;
        $viewdata['Cajas'] = $stm_cajas;

        return view('contents.application.informes.ventas.inf_ventasF',$viewdata)->with($data);
    }
    public function DatosFree(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d H:i:s',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d H:i:s',strtotime($post['ffecha']));
        $tped = $post['tped'];
        $tcaj = $post['icaja'];
        $tdoc = $post['tdoc'];

        $informeCard = DB::select('call usp_informe_f_g( :ifecha, :ffecha,:tped,:tcaj,:tdoc)'
            ,array(':ifecha' => $ifecha,':ffecha' => $ffecha,':tped' => $tped,':tcaj' => $tcaj,':tdoc' => $tdoc));

        $data = array("data" => $informeCard);

        $json = json_encode($data);
        echo $json;
    }*/
}
