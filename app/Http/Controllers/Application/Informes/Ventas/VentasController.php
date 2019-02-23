<?php
namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class VentasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $viewdata = [];
        $data = [
            'breadcrumb'=>'inf_ventas',
            'titulo_vista' => 'Informe ventas'
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
        //dd($stm);
        foreach($stm as $k => $d)
        {
            $stm[$k]->Cliente = DB::select("SELECT nombre FROM v_clientes WHERE id_cliente = ?",[$d->id_cli])[0];
        }
        dd($stm);
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }
    public function ExportExcel(Request $request)
    {
        try{

            $start = date('Y-m-d',strtotime($request->input('start')));
            $end = date('Y-m-d',strtotime($request->input('end')));
            $cod_cajas = $request->input('cod_cajas');
            $tipo_doc = $request->input('tipo_doc');

            $_SESSION["min-1"] = $_REQUEST['start'];
            $_SESSION["max-1"] = $_REQUEST['end'];

            $stm = DB::Select("SELECT v.id_ped as N_Pedido,v.id_tpag,v.pago_efe as Pago_Efectivo,v.pago_tar as Pago_Tarjeta,v.descu as Descuento,v.fec_ven as Fecha_vencimiento,v.desc_td as Comprobante,v.ser_doc as Serial_Documento,v.nro_doc as Numero_Documento,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS Total,v.igv as IGV,c.desc_caja as Nombre_caja FROM v_ventas_con AS v INNER JOIN v_caja_aper AS c ON  v.id_apc = c.id_apc WHERE (DATE(v.fec_ven) >= ? AND DATE(v.fec_ven) <= ?) AND v.id_tdoc like ? AND c.id_caja like ? AND v.id_sucursal = ? GROUP BY v.id_ven",
                array($start,$end,$tipo_doc,$cod_cajas,session('id_sucursal')));

            ob_end_clean();
            ob_start();
            
            return Excel::download(new ExportFromArray($stm),'inf-ventas-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
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
}
