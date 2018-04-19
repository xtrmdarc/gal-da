<?php

namespace App\Http\Controllers\Application\Informes\Ventas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    //
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_productos'
        ];
        return view('contents.application.informes.ventas.inf_productos')->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d H:i:s',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d H:i:s',strtotime($post['ffecha']));
        $stm = DB::Select("SELECT dp.id_prod,SUM(dp.cantidad) AS cantidad,dp.precio,IFNULL((SUM(dp.cantidad)*precio),0) AS total FROM tm_detalle_venta AS dp INNER JOIN tm_venta AS v ON dp.id_venta = v.id_venta WHERE v.fecha_venta >= ? AND v.fecha_venta <= ? GROUP BY dp.id_prod",
            array($ifecha,$ffecha));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Producto = DB::Select("SELECT CONCAT(nombre_prod,' ',pres_prod) AS nombres,desc_c FROM v_productos WHERE id_pres = ".$d->id_prod)[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

}
