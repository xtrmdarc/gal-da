<?php

namespace App\Http\Controllers\Application\TableroF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TmVentum;

class TableroFController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $viewdata = [];
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fechai = date("Y-m-d 00:00 ");
        $fecha = date("Y-m-d h:i A");

        //Total en $$ del dia.
        $total_dinero_venta_g = TmVentum::where('fecha_venta','>=',$fechai)
                          ->where('fecha_venta','<=',$fecha)
                          ->select(DB::raw('SUM(total) as totalVenta'))
                          ->first();

        $t_venta = $total_dinero_venta_g->totalVenta;

        if($t_venta == null){
            $t_venta = '0.00';
        }

        //Total de Ventas en el dia.

        $total_n_venta_g = TmVentum::where('fecha_venta','>=',$fechai)
            ->where('fecha_venta','<=',$fecha)
            ->select(DB::raw('COUNT(id_venta) as nVentas'))
            ->first();

        $t_n_venta = $total_n_venta_g->nVentas;

        if($t_n_venta == null){
            $t_n_venta = '0';
        }

        //Total de Clientes en el dia.

        $total_n_clientes = DB::table('tm_venta')
            ->where('fecha_venta','>=',$fechai)
            ->where('fecha_venta','<=',$fecha)
            ->leftjoin('tm_cliente', 'tm_venta.id_cliente', '=', 'tm_cliente.id_cliente')
            ->select(DB::raw('COUNT(distinct tm_cliente.id_cliente) as NClientes'))
            ->first();

        $t_n_clientes = $total_n_clientes->NClientes;

        if($t_n_clientes == null){
            $t_n_clientes = '0';
        }

        $viewdata['total_venta'] = $t_venta;
        $viewdata['total_n_venta'] = $t_n_venta;
        $viewdata['n_clientes'] = $t_n_clientes;

        return view('contents.application.tablero_f.tablero_f',$viewdata) ;
    }

    public function graficoVentasyMonto(){
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        /*Horas del dia */
        $fecha_s12a = date("Y-m-d 00:00 A");
        $fecha_s1 = date("Y-m-d 01:00 A");
        $fecha_s2 = date("Y-m-d 02:00 A");
        $fecha_s3 = date("Y-m-d 03:00 A");
        $fecha_s4 = date("Y-m-d 04:00 A");
        $fecha_s5 = date("Y-m-d 05:00 A");
        $fecha_s6 = date("Y-m-d 06:00 A");
        $fecha_s7 = date("Y-m-d 07:00 A");
        $fecha_s8 = date("Y-m-d 08:00 A");
        $fecha_s9 = date("Y-m-d 09:00 A");
        $fecha_s10 = date("Y-m-d 10:00 A");
        $fecha_s11 = date("Y-m-d 11:00 A");
        $fecha_s12p = date("Y-m-d 12:00 A");
        $fecha_s13 = date("Y-m-d 13:00 A");
        $fecha_s14 = date("Y-m-d 14:00 A");
        $fecha_s15 = date("Y-m-d 15:00 A");
        $fecha_s16 = date("Y-m-d 16:00 A");
        $fecha_s17 = date("Y-m-d 17:00 A");
        $fecha_s18 = date("Y-m-d 18:00 A");
        $fecha_s19 = date("Y-m-d 19:00 A");
        $fecha_s20 = date("Y-m-d 20:00 A");
        $fecha_s21 = date("Y-m-d 21:00 A");
        $fecha_s22 = date("Y-m-d 22:00 A");
        $fecha_s23 = date("Y-m-d 23:00 A");
        $fecha_s2359 = date("Y-m-d 24:00 A");

        $queryTotal = DB::Select("SELECT COUNT(distinct id_ven) as NVentas,SUM(total) as Total
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas2,SUM(total) as Total2
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas3,SUM(total) as Total3
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas4,SUM(total) as Total4
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas5,SUM(total) as Total5
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas6,SUM(total) as Total6
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas7,SUM(total) as Total7
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas8,SUM(total) as Total8
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas9,SUM(total) as Total9
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas10,SUM(total) as Total10
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas11,SUM(total) as Total11
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas12,SUM(total) as Total12
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas13,SUM(total) as Total13
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas14,SUM(total) as Total14
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas15,SUM(total) as Total15
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas16,SUM(total) as Total16
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas17,SUM(total) as Total17
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas18,SUM(total) as Total18
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas19,SUM(total) as Total19
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas20,SUM(total) as Total20
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas21,SUM(total) as Total21
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas22,SUM(total) as Total22
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas23,SUM(total) as Total23
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              union ALL
                              SELECT COUNT(distinct id_ven) as NVentas2359,SUM(total) as Total2359
                              FROM db_rest.v_ventas_con
                              where fec_ven >= ? and fec_ven <= ?
                              ",array(
            $fecha_s12a,
            $fecha_s1,
            $fecha_s1,
            $fecha_s2,
            $fecha_s2,
            $fecha_s3,
            $fecha_s3,
            $fecha_s4,
            $fecha_s4,
            $fecha_s5,
            $fecha_s5,
            $fecha_s6,
            $fecha_s6,
            $fecha_s7,
            $fecha_s7,
            $fecha_s8,
            $fecha_s8,
            $fecha_s9,
            $fecha_s9,
            $fecha_s10,
            $fecha_s10,
            $fecha_s11,
            $fecha_s11,
            $fecha_s12p,
            $fecha_s12p,
            $fecha_s13,
            $fecha_s13,
            $fecha_s14,
            $fecha_s14,
            $fecha_s15,
            $fecha_s15,
            $fecha_s16,
            $fecha_s16,
            $fecha_s17,
            $fecha_s17,
            $fecha_s18,
            $fecha_s18,
            $fecha_s19,
            $fecha_s19,
            $fecha_s20,
            $fecha_s20,
            $fecha_s21,
            $fecha_s21,
            $fecha_s22,
            $fecha_s22,
            $fecha_s23,
            $fecha_s23,
            $fecha_s2359));

        $data = array("data" => $queryTotal);
        //$data = array("data" => [$query1,$query2,$query3,$query4]);

        return $data;
    }
}
