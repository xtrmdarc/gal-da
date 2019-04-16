<?php
namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;
use App\Models\TmCaja;
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
        $stm_clientes = DB::Select("SELECT id_cliente,nombre FROM v_clientes where id_empresa = ?",[session('id_empresa')]);

        //Cajas
        $stm_cajas = DB::Select("SELECT * FROM tm_caja where id_sucursal = ?",[session('id_sucursal')]);

        //Comprobantes
        //$stm_comprobantes = DB::Select("SELECT * FROM tm_tipo_doc td  LEFT JOIN tipo_doc_empresa te ON te.id_tipo_doc =  td.id_tipo_doc where te.id_empresa = ?",[session('id_empresa')]);
        $stm_comprobantes = DB::Select("SELECT * FROM tm_tipo_doc td  LEFT JOIN tipo_doc_empresa te ON te.id_tipo_doc =  td.id_tipo_doc where te.id_empresa = ? and td.es_comprobante_pago = 1 and td.electronico in (0,?) ",[session('id_empresa'),session('datosempresa')->factura_e]);
        //Sucursales Filtro
        $sucursales_filtro = Sucursal::where('id_empresa',session('id_empresa'))->get();

        $viewdata['TipoPedido'] = $stm;
        $viewdata['Clientes'] = $stm_clientes;
        $viewdata['Cajas'] = $stm_cajas;
        $viewdata['Comprobantes'] = $stm_comprobantes;
        $viewdata['sucursales_filtro'] = $sucursales_filtro;

        return view('contents.application.informes.ventas.inf_ventas',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $sucu_filter = $request->input('sucu_filter');

        $stm = DB::Select("SELECT v.id_ven,v.id_ped,v.id_tpag,tp.descripcion,v.pago_efe,v.pago_tar,v.descu,v.total AS stotal,v.fec_ven,v.desc_td,CONCAT(v.ser_doc,'-',v.nro_doc) AS numero,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS total,v.id_cli,v.igv,v.id_usu,c.desc_caja FROM v_ventas_con AS v INNER JOIN v_caja_aper AS c ON v.id_apc = c.id_apc left join tm_tipo_pedido as tp on v.id_tped = tp.id_tipo_pedido WHERE (v.fec_ven >= ? AND v.fec_ven <= ?) AND v.id_tped like ? AND v.id_tdoc like ? AND c.id_caja like ? AND v.id_cli like ? and v.id_sucursal = ? GROUP BY v.id_ven",
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
        try{

            $start = date('Y-m-d',strtotime($request->input('start')));
            $end = date('Y-m-d',strtotime($request->input('end')));
            $cod_cajas = $request->input('cod_cajas');
            $tipo_doc = $request->input('tipo_doc');
            $sucu_filter = $request->input('sucu_filter');

            $_SESSION["min-1"] = $_REQUEST['start'];
            $_SESSION["max-1"] = $_REQUEST['end'];

            $stm = DB::Select("SELECT v.id_ped as N_Pedido,v.pago_efe as Pago_Efectivo,v.pago_tar as Pago_Tarjeta,v.descu as Descuento,
            v.fec_ven as Fecha,v.desc_td as Comprobante,v.ser_doc as Serial_Documento,
            v.nro_doc as Numero_Documento,IFNULL(SUM(v.pago_efe+v.pago_tar),0) AS Total,v.igv as IGV,c.desc_caja as Nombre_caja, CONCAT(cli.nombres,' ',cli.ape_paterno,' ',cli.ape_materno) as Nombre_cliente
            FROM v_ventas_con AS v INNER JOIN v_caja_aper AS c ON  v.id_apc = c.id_apc
            inner join tm_cliente as cli on v.id_cli = cli.id_cliente WHERE (DATE(v.fec_ven) >= ? AND DATE(v.fec_ven) <= ?) AND v.id_tdoc like ? AND c.id_caja like ? AND v.id_sucursal = ? GROUP BY v.id_ven",
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
    public function lista_caja_x_sucursal(Request $request)
    {
        $post = $request->all();
        $id_sucu = $post['id_sucursal_d'];
        $lista_cajas = TmCaja::where('id_sucursal','like',$id_sucu)
                             ->where('id_empresa',session('id_empresa'))
                             ->get();

        return $lista_cajas;
        /*try
        {
            $post = $request->all();
            $id_sucu = $post['id_sucursal_d'];
            //$lista_cajas = DB::Select("SELECT * FROM tm_caja where id_sucursal = ?",[$id_sucu]);
            $lista_cajas = TmCaja::where('id_sucursal',$id_sucu)->get();

            echo '<select name="cod_cajas" id="cod_cajas" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" data-size="5">';
            echo '<option value="%">Todas</option>';
            foreach($lista_cajas as $v){
                echo '<option value="'.$v['id_caja'].'">'.$v['descripcion'].'</option>';
            }
            echo " </select>";
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }*/
    }
}
