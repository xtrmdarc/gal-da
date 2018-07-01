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
        $fechai = date("Y-m-d 12:00 A");
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

}
