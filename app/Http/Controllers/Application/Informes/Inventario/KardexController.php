<?php

namespace App\Http\Controllers\Application\Informes\Inventario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KardexController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $data = [
            'breadcrumb' => 'inf_kardex'
        ];
        return view('contents.application.informes.inventario.inf_kardex')->with($data);
    }
    public function Datos(Request $request)
    {
        $post = $request->all();

        $tipo_ip = $post['tipo_ip'];
        $id_ip = $post['id_ip'];
        $stm = DB::Select("SELECT * FROM tm_inventario WHERE id_ti = ? AND id_ins = ?",
            array($tipo_ip,$id_ip));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Dato = DB::Select("SELECT descripcion FROM v_busqins WHERE tipo_p = ".$d->id_ti." AND id_ins = ".$d->id_ins)[0];

            if($d->id_tipo_ope == 1){
                $stm[$k]->Comp = DB::Select("SELECT serie_doc,num_doc,desc_td FROM v_compras WHERE id_compra = ".$d->id_cv)[0];
            } else if($d->id_tipo_ope == 2){
                $stm[$k]->Comp= DB::Select("SELECT ser_doc,nro_doc,desc_td FROM v_ventas_con WHERE id_ven = ".$d->id_cv)[0];
            }

            if($d->id_ti == 1){
                $stm[$k]->Almacen = DB::Select("SELECT a.nombre as dato FROM tm_producto  AS p INNER JOIN tm_area_prod AS ap ON p.id_areap = ap.id_areap INNER JOIN tm_almacen AS a ON ap.id_alm = a.id_alm INNER JOIN tm_producto_pres AS pp ON p.id_prod = pp.id_prod INNER JOIN tm_producto_ingr i ON pp.id_pres = i.id_pres WHERE i.id_ins = ".$d->id_ins)[0];
            } else if($d->id_ti == 2){
                $stm[$k]->Almacen = DB::Select("SELECT a.nombre as dato FROM tm_producto  AS p INNER JOIN tm_area_prod AS ap ON p.id_areap = ap.id_areap INNER JOIN tm_almacen AS a ON ap.id_alm = a.id_alm INNER JOIN tm_producto_pres AS pp ON p.id_prod = pp.id_prod WHERE pp.id_pres = ".$d->id_ins)[0];
            }
        }

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function ComboIP(Request $request)
    {//FALTA QUE SALGA PARA LOS PRODUCTOS :,v
       $post = $request->all();

        $cod = $post['cod'];

        $stmm = DB::Select("SELECT id_ins,cod_ins,nomb_ins FROM v_busqins WHERE tipo_p = ?",
            array($cod));
        foreach($stmm as $v){
            echo '<option value="'.$v->id_ins.'">'.$v->cod_ins.' - '.$v->nomb_ins.'</option>';
        }
    }
}
