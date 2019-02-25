<?php

namespace App\Http\Controllers\Application\Tablero;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Application\AppController;

class TableroController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
    }
    public function index(){

        //Solo puede verlo el adminsitrador
        AppController::RedirectSegunRol(1);
        
        $data = [

            'breadcrumb'=> 'inicio',
            'titulo_vista' => 'Tablero'  
            
        ];
  
        return view('contents.application.tablero.tablero') ;
    }

    public function datosGrls(Request $request)
    {
        $_POST = $request->all();

        $ifecha = date('Y-m-d H:i:s',strtotime($_POST['ifecha']));
        $ffecha = date('Y-m-d H:i:s',strtotime($_POST['ffecha']));

        $fechas = array($ifecha,$ffecha);
        
        $vt = DB::select("SELECT IFNULL(SUM(pago_efe),0) AS efe, IFNULL(SUM(pago_tar),0) AS tar, IFNULL(SUM(descu),0) AS des, IFNULL(SUM(total),0) AS total_v FROM v_ventas_con WHERE (fec_ven >= ? AND fec_ven < ?)",$fechas);
       
        
        $g =  DB::select("SELECT IFNULL(SUM(importe),0) AS tgas FROM v_gastosadm WHERE (fecha_re >= ? AND fecha_re < ?) AND estado = 'a'",$fechas);
     //   $g = $g[0];

        $m =  DB::select("SELECT IFNULL(COUNT(dp.id_pedido),0) AS tped,u.nombres,u.ape_paterno,u.ape_materno FROM tm_detalle_pedido AS dp INNER JOIN tm_pedido_mesa AS pm ON dp.id_pedido = pm.id_pedido INNER JOIN tm_pedido AS p ON dp.id_pedido = p.id_pedido INNER JOIN tm_usuario AS u ON pm.id_mozo = u.id_usu WHERE dp.estado <> 'i' AND p.estado = 'c' AND (p.fecha_pedido >= ? AND p.fecha_pedido < ?) GROUP BY pm.id_mozo ORDER BY tped DESC LIMIT 1",$fechas);
       // $m = $m[0];
       
        $tp = DB::select("SELECT IFNULL(COUNT(dp.id_pedido),0) AS toped FROM tm_detalle_pedido AS dp INNER JOIN tm_pedido AS p ON dp.id_pedido = p.id_pedido WHERE dp.estado <> 'i' AND p.estado = 'c' AND (p.fecha_pedido >= ? AND p.fecha_pedido < ?)",$fechas);

        
        $me = DB::select("SELECT IFNULL(COUNT(pm.id_pedido),0) AS total FROM tm_pedido_mesa AS pm INNER JOIN tm_pedido as p ON pm.id_pedido = p.id_pedido WHERE p.estado = 'c' AND (p.fecha_pedido >= ? AND p.fecha_pedido < ?)",$fechas);


        $vm = DB::select("SELECT IFNULL(SUM(v.total - v.descu),0) AS total_v FROM v_ventas_con AS v INNER JOIN tm_pedido_mesa AS pm ON v.id_ped = pm.id_pedido WHERE (v.fec_ven >= ? AND v.fec_ven < ?)",$fechas);


        $vmo = DB::select("SELECT IFNULL(SUM(v.total - v.descu),0) AS total_v FROM v_ventas_con AS v INNER JOIN tm_pedido_llevar AS pm ON v.id_ped = pm.id_pedido WHERE (v.fec_ven >= ? AND v.fec_ven < ?)",$fechas);


        $mo = DB::select("SELECT IFNULL(COUNT(pm.id_pedido),0) AS total FROM tm_pedido_llevar AS pm INNER JOIN tm_pedido as p ON pm.id_pedido = p.id_pedido WHERE p.estado = 'c' AND (p.fecha_pedido >= ? AND p.fecha_pedido < ?)",$fechas);


        $pp = DB::select("SELECT vp.nombre_prod,vp.pres_prod,dv.precio,SUM(dv.cantidad) AS cantidad,COUNT(dv.id_venta) AS total FROM tm_detalle_venta AS dv INNER JOIN tm_venta AS v ON dv.id_venta = v.id_venta INNER JOIN v_productos AS vp ON dv.id_prod = vp.id_pres WHERE vp.id_tipo = 1 AND (v.fecha_venta >= ? AND v.fecha_venta <= ?) GROUP BY dv.id_prod ORDER BY total DESC LIMIT 10",$fechas);


        $ppp = DB::select("SELECT vp.nombre_prod,vp.pres_prod,dv.precio,SUM(dv.cantidad) AS cantidad,COUNT(dv.id_venta) AS total FROM tm_detalle_venta AS dv INNER JOIN tm_venta AS v ON dv.id_venta = v.id_venta INNER JOIN v_productos AS vp ON dv.id_prod = vp.id_pres WHERE (v.fecha_venta >= ? AND v.fecha_venta <= ?) GROUP BY dv.id_prod ORDER BY total DESC LIMIT 10",$fechas);


        $ma = DB::select("SELECT COUNT(id_pedido) as total FROM tm_pedido WHERE (fecha_pedido >= ? AND fecha_pedido < ?) AND id_tipo_pedido = 1 AND estado ='i'",$fechas);


        $moa = DB::select("SELECT COUNT(id_pedido) as total FROM tm_pedido WHERE (fecha_pedido >= ? AND fecha_pedido < ?) AND id_tipo_pedido = 2 AND estado ='i'",$fechas);


        $i = DB::select("SELECT IFNULL(SUM(importe),0) AS ting FROM tm_ingresos_adm WHERE (fecha_reg >= ? AND fecha_reg < ?) AND estado = 'a'",$fechas);



        $dat = array("data1" => $vt,"data2" => $g,"data3" => $m,"data4" => $tp,"data5" => $me,"data6" => $vm,"data7" => $vmo,"data8" => $mo,"data9" => $pp,"data10" => $ppp,"data11" => $ma,"data12" => $moa,"data13" => $i);
        
        $json = json_encode($dat);
        
        echo $json;
    }

    public function datosGraf(Request $request)
    {
        $this->model->DatosGraf($_POST);
    }
}
