<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\Captcha;
use App\Models\Empresa;
use App\Http\Controllers\Application\AppController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class CaptchaController extends Controller
{
    public function datos(Request $request){

        $post = $request->all();

        $ruc = $post['ruc'];
        $tipo_doc = $post['tipo_doc'];
        $folio_doc = $post['folio_doc'];
        $ifecha = date('Y-m-d',strtotime($post['start']));
        $m_total = $post['m_total'];
        $captcha = $post['g-recaptcha-response'];

        $id_empresa = Empresa::where('ruc',$ruc)->get();

        foreach($id_empresa as $r){
            $viewdata['id_empre_ruc'] = $r->id;
            $viewdata['id_empre_logo'] = $r->logo;
        }

        //Obtener path de tmVenta

        $venta_cpe = DB::Select("SELECT * FROM db_rest.v_cpe_home
                    where id_empresa = ? and id_tipo_doc = ?
                    and serie_correlativo  = ?
                    and fecha_emision = ?
                    and monto_total = ?;",
            [$viewdata['id_empre_ruc'],$tipo_doc,$folio_doc,$ifecha,$m_total]);

        foreach($venta_cpe as $r){
            $viewdata['path_xml'] = $r->path_xml_file;
            $viewdata['v_index_x_cuenta'] = $r->index_por_cuenta;
        }

        if($ruc == '' || $ruc == " "){
            $errors = [];
            $errors[] = 'Completa el Ruc.';
            if(count($errors) > 0) {
                return view('contents.home.cpe.index')->withErrors($errors);
            }
        }
        if($tipo_doc == '' || $tipo_doc == " "){
            $errors = [];
            $errors[] = 'Completa el Tipo de Documento.';
            if(count($errors) > 0) {
                return view('contents.home.cpe.index')->withErrors($errors);
            }
        }
        if($folio_doc == '' || $folio_doc == " "){
            $errors = [];
            $errors[] = 'Completa el Folio del Documento.';
            if(count($errors) > 0) {
                return view('contents.home.cpe.index')->withErrors($errors);
            }
        }
        //Si existe todos los campos del CPE
        if (DB::table("v_cpe_home")
            ->where('id_empresa',$viewdata['id_empre_ruc'])
            ->where('id_tipo_doc',$tipo_doc)
            ->where('serie_correlativo',$folio_doc)
            ->where('fecha_emision',$ifecha)
            ->where('monto_total',$m_total)->exists() && ($captcha)) {

            return view('contents.home.cpe.verDocumento',$viewdata);
            //dd($captcha,'EXISTE');
        }else {
            dd($captcha,'');
            $errors = [];
            $errors[] = 'No esta registrado el Folio de Documentos en nuestra base de datos';
            if(count($errors) > 0) {
                return view('contents.home.cpe.index')->withErrors($errors);
            }
        }

        //dd($request,$tipo_doc,$tipo_doc_empresa);
    }

    public function downloadXml(Request $request)
    {
        $post = $request->all();
        $path = $post['x_p'];
        //$url = Storage::disk('s3')->url($path);
        $exist = Storage::disk('s3_billing_c')->exists($path);

        if(($exist)){
            return Storage::disk('s3_billing_c')->download($path);
        } else {
            dd('NO EXISTE');
        }
    }

    public function downloadPdf(Request $request){

        $post = $request->all();
        $index = $post['x_pdf'];
        $id_empresa = $post['id_emp'];
           
        try{

            $cod = (DB::table('tm_pedido')->where('index_por_cuenta',$index)->where('id_empresa',$id_empresa)->first())->id_pedido;
            $data = DB::table('v_ventas_con')->where('id_ped',$cod)->first();
              
            $data->Cliente = DB::table('v_clientes')->where('id_cliente',$data->id_cli)->first();
            
            $data->Detalle = DB::select("SELECT id_prod,SUM(cantidad) AS cantidad, precio FROM tm_detalle_venta WHERE id_venta = ? GROUP BY id_prod",[$data->id_ven]);

            foreach($data->Detalle as $k => $d)
            {
                $data->Detalle[$k]->Producto = DB::select("SELECT nombre_prod, pres_prod FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
            }

            $de = AppController::DatosEmpresa($id_empresa);
            
            require_once (public_path().'/rest/Imprimir/comp_cpe.php');
            return json_encode(1);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
