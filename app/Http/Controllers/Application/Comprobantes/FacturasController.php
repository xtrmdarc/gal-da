<?php

namespace App\Http\Controllers\Application\Comprobantes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FacturasController extends Controller
{
    //
    public function index(){
        
        $tipos_doc = DB::table('tm_tipo_doc')
                        ->select(DB::raw('tm_tipo_doc.*'))
                        ->leftJoin('tipo_doc_empresa','tipo_doc_empresa.id_tipo_doc','tm_tipo_doc.id_tipo_doc')
                        ->where('tipo_doc_empresa.id_empresa',session('id_empresa'))
                        ->where('tm_tipo_doc.tipo_doc_codigo','01')
                        ->get();

        $data = [
            'breadcrumb'=> 'comprobantes.factura',
            'titulo_vista' => 'Facturas',
            'tipos_doc' => $tipos_doc
        ];

        return view('contents.application.comprobantes.facturas')->with($data);
    }

    public function buscarFacturas(Request $request){

        $data = $request->all();
        
        $facturas_query = DB::table('v_facturas_comprobante')->where('id_empresa',session('id_empresa'));
        // Expected Cliente, Fecha Inicio, Fecha Fin , Documento, Tipo de factura

        if(isset($data['cliente_id'])&& $data['cliente_id']!= '')
        {
            $facturas_query = $facturas_query->where('id_cliente',$data['cliente_id']);
        }
        
        if(isset($data['fecha_inicio'])&& $data['fecha_inicio']!= '')
        {
            $facturas_query = $facturas_query->where(DB::raw('date(fecha_venta)'),'>=',date('Y-m-d',strtotime($data['fecha_inicio'])));
        }
        if(isset($data['fecha_final'])&& $data['fecha_final']!= '')
        {
            $facturas_query = $facturas_query->where(DB::raw('date(fecha_venta)'),'<=',date('Y-m-d',strtotime($data['fecha_final'])));
        }
        
        if(isset($data['tipo_doc'])&& $data['tipo_doc']!= '')
        {
            $facturas_query = $facturas_query->where('id_tipo_doc',$data['tipo_doc']);
        }
        if(isset($data['documento'])&& $data['documento']!= '')
        {
            $facturas_query = $facturas_query->where('folio',$data['documento']);
        }
        
        $facturas = $facturas_query->get();
        return  json_encode($facturas);

    }
}
