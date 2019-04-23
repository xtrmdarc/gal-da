<?php

namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class ProductosController extends Controller
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
            'breadcrumb'=>'inf_productos',
            'titulo_vista' => 'Informe Productos'
        ];

        //Sucursales Filtro
        $sucursales_filtro = Sucursal::where('id_empresa',session('id_empresa'))->get();

        $viewdata['sucursales_filtro'] = $sucursales_filtro;
        return view('contents.application.informes.ventas.inf_productos',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $sucu_filter = $request->input('sucu_filter');

        $stm = DB::Select("SELECT dp.id_prod,SUM(dp.cantidad) AS cantidad,dp.precio,IFNULL((SUM(dp.cantidad)*precio),0) AS total,s.id as id_sucursal,s.nombre_sucursal as nombre_sucursal
                           FROM tm_detalle_venta AS dp INNER JOIN tm_venta AS v ON dp.id_venta = v.id_venta left join sucursal as s on v.id_sucursal = s.id WHERE date(v.fecha_venta) >= ? AND date(v.fecha_venta) <= ? AND s.id like ? and v.id_empresa = ? GROUP BY dp.id_prod",
            array($ifecha,$ffecha,$sucu_filter,session('id_empresa')));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Producto = DB::Select("SELECT CONCAT(nombre_prod,' ',pres_prod) AS nombres,desc_c FROM v_productos WHERE id_pres = ".$d->id_prod)[0];
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

            $_SESSION["min-1"] = $_REQUEST['start'];
            $_SESSION["max-1"] = $_REQUEST['end'];

            $stm = DB::Select("SELECT dp.id_prod,SUM(dp.cantidad) AS cantidad,dp.precio,IFNULL((SUM(dp.cantidad)*precio),0) AS total FROM tm_detalle_venta AS dp INNER JOIN tm_venta AS v ON dp.id_venta = v.id_venta WHERE date(v.fecha_venta) >= ? AND date(v.fecha_venta) <= ? GROUP BY dp.id_prod",
                array($start,$end));

            ob_end_clean();
            ob_start();

            return Excel::download(new ExportFromArray($stm),'inf-ventas-por-producto-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
