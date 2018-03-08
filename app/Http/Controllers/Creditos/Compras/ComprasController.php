<?php

namespace App\Http\Controllers\Creditos\Compras;

use App\Models\TmCreditoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TmProveedor;

class ComprasController extends Controller
{
    //
    public function index()
    {
        $viewData = [];
        $providers = TmProveedor::all();
        $viewData['providers'] = $providers;

        return view('contents.creditos.compras.index',$viewData);
    }

    public function getProviders()
    {   //Geto all the Providers
        $providers = TmProveedor::all();
        return $providers;
    }

    public function Datos(Request $request)
    {
        $cprov = $request->input('cprov');
        $results = DB::select("select cc.id_credito,cc.id_compra,cc.total,cc.interes,cc.fecha,vc.id_prov,CONCAT(vc.serie_doc,' - ',vc.num_doc) AS
        numero,vc.desc_td,desc_prov
        FROM tm_compra_credito as cc
        inner join v_compras as vc
        ON cc.id_compra = vc.id_compra
        WHERE vc.id_prov like '?' AND
        cc.estado = 'p' AND vc.estado = 'a' ORDER BY cc.fecha ASC");

        $array_results = response()->json($results);

        foreach($array_results as $k => $d)
        {
            $query = DB::select("SELECT IFNULL(SUM(importe),0) AS total FROM tm_credito_detalle WHERE id_credito = '1'");
            $query_result = response()->json($query);
            $array_results[$k]->{'Amortizado'} = $query_result;
        }
        $data = array("data" => $array_results);
        $json = json_encode($data);
        echo $json;
    }

    public function DatosP()
    {

    }

    public function Detalle()
    {   //Geto all the Details from Tm_Credito_detalle
        $creditDetail = TmCreditoDetalle::all();

        return $creditDetail;
    }

    public function PagarCuota()
    {
        dd('TEST');
    }
}
