<?php

namespace App\Http\Controllers\Application\Creditos\Compras;

use App\Models\TmCreditoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TmProveedor;
use Illuminate\Support\Facades\Session;

class ComprasController extends Controller
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
        $viewData = [];
        $providers = TmProveedor::where('id_empresa',session('id_empresa'))->get();
        $viewData['providers'] = $providers;

        $data= [
            
            'breadcrumb' => 'creditosCompra',
            'titulo_vista' => 'Compras'
        ];
        return view('contents.application.creditos.compras.index',$viewData)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $cprov = $post['cprov'];

        $stm = DB::Select("SELECT cc.id_credito,cc.id_compra,cc.total,cc.interes,cc.fecha,vc.id_prov,CONCAT(vc.serie_doc,' - ',vc.num_doc) AS numero,vc.desc_td,desc_prov FROM tm_compra_credito AS cc INNER JOIN v_compras AS vc ON cc.id_compra = vc.id_compra WHERE vc.id_prov like ? AND cc.estado = 'p' AND vc.estado = 'a' AND vc.id_sucursal = ? ORDER BY cc.fecha ASC",
            array($cprov,session('id_sucursal')));
        foreach($stm as $k => $d)
        {
            $stm[$k]->Amortizado = DB::Select("SELECT IFNULL(SUM(importe),0) AS total FROM tm_credito_detalle WHERE id_credito = ".$d->id_credito)[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function DatosP(Request $request)
    {
        $post = $request->all();

        $cod = $post['cod'];
        $stm = DB::Select("SELECT cc.fecha,vc.desc_prov FROM tm_compra_credito AS cc INNER JOIN v_compras AS vc ON cc.id_compra = vc.id_compra WHERE cc.id_credito like ? AND vc.id_sucursal = ? AND cc.estado = 'p'",
            array($cod,session('id_sucursal')))[0];
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function Detalle(Request $request)
    {
        $post = $request->all();

        $cod = $post['cod'];
        $stm = Db::Select("SELECT * FROM tm_credito_detalle WHERE id_credito = ?",
            array($cod));
        //dd($stm);
        foreach($stm as $k => $d)
        {
            $stm[$k]->Usuario = Db::Select("SELECT CONCAT(ape_paterno,' ',ape_materno,' ',nombres) AS nombre FROM v_usuarios WHERE id_usu = ".$d->id_usu)[0];
        }
        return $stm;
    }

    public function PagarCuota(Request $request)
    {
        $idCre = $request->input('cod_cuota');
        $imp = $request->input('pago_cuo');
        $egCaja = $request->input('egre_caja');
        $montC = $request->input('monto_ec');
        $totalC = $request->input('total_cuota');
        $amorC = $request->input('amort_cuota');

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $flag = 1;
        $fecha = date("Y-m-d H:i:s");
        $id_usu = session("id_usu");
        $id_apc = session("id_apc");

        $consulta = DB::statement ("call usp_comprasCreditoCuotas( :flag, :idCre, :idUsu, :idApc, :imp, :fecha, :egCaja, :montC, :amorC, :totalC);"
            ,array(':flag' => $flag,':idCre' => $idCre, ':idUsu' => $id_usu, ':idApc' => $id_apc, ':imp' => $imp,':fecha' => $fecha,':egCaja' => $egCaja,
                ':montC' => $montC,':amorC' => $amorC,':totalC' => $totalC));
        return redirect('/creditos');
    }
}
