<?php

namespace App\Http\Controllers\Application\Comprobantes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\EFacturacion;

class BoletasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
        $this->middleware('vActualizacion');
    }
    public function index(){
        
        $tipos_doc = DB::table('tm_tipo_doc')
                        ->select(DB::raw('tm_tipo_doc.*'))
                        ->leftJoin('tipo_doc_empresa','tipo_doc_empresa.id_tipo_doc','tm_tipo_doc.id_tipo_doc')
                        ->where('tipo_doc_empresa.id_empresa',session('id_empresa'))
                        ->where('tm_tipo_doc.tipo_doc_codigo','03')
                        ->get();

        $data = [
            'breadcrumb'=> 'comprobantes.boleta',
            'titulo_vista' => 'Boletas',
            'tipos_doc' => $tipos_doc
        ];

        return view('contents.application.comprobantes.boletas')->with($data);
    }

    //boletas
    public function buscarBoletas(Request $request){

        $data = $request->all();
        
        $boletas_query = DB::table('v_boletas_comprobante')->where('id_empresa',session('id_empresa'));
        // Expected Cliente, Fecha Inicio, Fecha Fin , Documento, Tipo de factura

        if(isset($data['cliente_id'])&& $data['cliente_id']!= '')
        {
            $boletas_query = $boletas_query->where('id_cliente',$data['cliente_id']);
        }
        
        if(isset($data['fecha_inicio'])&& $data['fecha_inicio']!= '')
        {
            $boletas_query = $boletas_query->where(DB::raw('date(fecha_venta)'),'>=',date('Y-m-d',strtotime($data['fecha_inicio'])));
        }
        if(isset($data['fecha_final'])&& $data['fecha_final']!= '')
        {
            $boletas_query = $boletas_query->where(DB::raw('date(fecha_venta)'),'<=',date('Y-m-d',strtotime($data['fecha_final'])));
        }
        
        if(isset($data['tipo_doc'])&& $data['tipo_doc']!= '')
        {
            $boletas_query = $boletas_query->where('id_tipo_doc',$data['tipo_doc']);
        }
        if(isset($data['documento'])&& $data['documento']!= '')
        {
            $boletas_query = $boletas_query->where('folio',$data['documento']);
        }
        
        $boletas = $boletas_query->get();
        return  json_encode($boletas);

    }

    public function enviarBoletaSunat(Request $request){
        
        $data = $request->all();
        
        EFacturacion::enviarInvoiceSunat($data['id_venta']);
        
        $factura_response = DB::table('v_boletas_comprobante')->where('id_venta',$data['id_venta'])
        ->where('id_empresa',session('id_empresa'))->first();
 
        return json_encode($factura_response);
    }

    public function getFacturaInvoiceXID(Request $request)
    {
        $data = $request->all();

        $factura = DB::table('v_boletas_comprobante')->where('id_venta',$data['id_venta'])
                                                    ->where('id_empresa',session('id_empresa'))->first();

        return json_encode($factura);
    }

}
