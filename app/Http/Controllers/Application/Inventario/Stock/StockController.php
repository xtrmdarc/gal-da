<?php

namespace App\Http\Controllers\Application\Inventario\Stock;

use App\Models\TmAlmacen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('vActualizacion');
    }

    public function index(){
        $viewData = [];

        $almacenes = TmAlmacen::where('id_sucursal',session('id_sucursal'))
                                ->where('estado','a')->get();

        $viewData['almacenes'] = $almacenes;

        $data= [

            'breadcrumb' => 'inventario.stock',
            'titulo_vista' => 'Stock'
        ];
        return view('contents.application.inventario.stock.stock',$viewData)->with($data);
    }

    public function datos(Request $request){
        $post = $request->all();

        $tipo_ip = $post['tipo_p_i'];

        $stm = DB::Select("select i.id_inv,i.id_ti,i.id_ins,i.id_tipo_ope,i.id_cv,
                        SUM(case when i.id_tipo_ope = 1 then i.cant end) as entradas,
                        SUM(case when i.id_tipo_ope = 2 then i.cant end) as salidas,
                        SUM(case when i.id_tipo_ope = 2 then i.cant*- 1 else i.cant end) as stock_total,
                        v_bus.id_sucursal,v_bus.nomb_ins,v_bus.categoria,v_bus.descripcion,v_bus.stock_min
                        from tm_inventario as i
                        left join v_busqins as v_bus on i.id_ins = v_bus.id_ins
                        left join v_insumos as v_i on v_i.id_ins = i.id_ins
                        where i.id_ti like ? and v_bus.id_sucursal = ?
                        GROUP BY id_ins;
                        ",
            array($tipo_ip,session('id_sucursal')));

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }
}
