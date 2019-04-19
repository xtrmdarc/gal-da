<?php

namespace App\Http\Controllers\Application\Comprobantes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\EFacturacion;
use Greenter\Model\Summary\Summary;
use Illuminate\Support\Facades\Storage;



class ResumenesController extends Controller
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
        
        // $tipos_doc = DB::table('tm_tipo_doc')
        //                 ->select(DB::raw('tm_tipo_doc.*'))
        //                 ->leftJoin('tipo_doc_empresa','tipo_doc_empresa.id_tipo_doc','tm_tipo_doc.id_tipo_doc')
        //                 ->where('tipo_doc_empresa.id_empresa',session('id_empresa'))
        //                 ->where('tm_tipo_doc.tipo_doc_codigo','03')
        //                 ->get();

        $data = [
            'breadcrumb'=> 'comprobantes.resumen',
            'titulo_vista' => 'Resumen diario',
            // 'tipos_doc' => $tipos_doc
        ];

        return view('contents.application.comprobantes.resumenes')->with($data);
    }

    //resumenes
    public function buscarResumenes(Request $request){

        $data = $request->all();
        
        $resumenes_query = DB::table('v_resumenes_comprobante')->where('id_empresa',session('id_empresa'));
        // Expected Cliente, Fecha Inicio, Fecha Fin , Documento, Tipo de factura

        // if(isset($data['cliente_id'])&& $data['cliente_id']!= '')
        // {
        //     $resumenes_query = $resumenes_query->where('id_cliente',$data['cliente_id']);
        // }
        
        if(isset($data['fecha_inicio'])&& $data['fecha_inicio']!= '')
        {
            $resumenes_query = $resumenes_query->where(DB::raw('date(fecha_resumen)'),'>=',date('Y-m-d',strtotime($data['fecha_inicio'])));
        }
        if(isset($data['fecha_final'])&& $data['fecha_final']!= '')
        {
            $resumenes_query = $resumenes_query->where(DB::raw('date(fecha_resumen)'),'<=',date('Y-m-d',strtotime($data['fecha_final'])));
        }
        
        // if(isset($data['tipo_doc'])&& $data['tipo_doc']!= '')
        // {
        //     $resumenes_query = $resumenes_query->where('id_tipo_doc',$data['tipo_doc']);
        // }
        // if(isset($data['documento'])&& $data['documento']!= '')
        // {
        //     $resumenes_query = $resumenes_query->where('folio',$data['documento']);
        // }
        
        $resumenes = $resumenes_query->get();
        return  json_encode($resumenes);

    }

    public function enviarResumenSunat(Request $request)
    {
        
        $data = $request->all();
        
        $id_boletas = array();
        $id_notas = array();
        
        if(!isset($data['id_boletas']) && !isset($data['id_notas']) )
        {
            //No hay boletas ni notas para procesar
            $response = new \stdClass();
            $response->cod = 0;
            $response->mensaje = 'El resumen no tiene documentos asociados. Incluye documentos al resumen para crearlo.';
            return json_encode($response);
        }
        else
        {
            $id_boletas = isset($data['id_boletas'])?$data['id_boletas']:$id_boletas;
            $id_notas = isset($data['id_notas'])?$data['id_notas']:$id_notas;
        }
        
        return EFacturacion::enviarResumenSunat($id_boletas,$id_notas);
        
        // $factura_response = DB::table('v_resumenes_comprobante')->where('id_venta',$data['id_venta'])
        // ->where('id_empresa',session('id_empresa'))->first();
 
        // return json_encode($factura_response);
    }
    
    public function existenComprobantesParaResumen(Request $request)
    {
        $data = $request->all();
        
        $comprobantes_enviar = DB::table('v_docs_resumen')->where('id_empresa',session('id_empresa'))
                                                        ->whereNotIn('id_estado_comprobante',array(1,3))
                                                        ->where('id_estado_doc_resumen','<>',0)
                                                        ->exists();
        return json_encode($comprobantes_enviar);
    }

    public function buscarDocsResumenPorFecha(Request $request)
    {
        $data = $request->all();
        $fecha = date('Y-m-d',strtotime($data['fecha']));
        
        $docs = DB::table('v_docs_resumen')->where('id_empresa',session('id_empresa'))
                                            ->whereNotIn('id_estado_comprobante',array(1,3))
                                            ->where('id_estado_doc_resumen','<>',0)
                                            ->where(DB::raw('date(fecha_emision)'),$fecha)
                                            ->get();
        
        return json_encode($docs);
    }

    public function consultarEstadoResumen(Request $request)
    {
        $data = $request->all();
        $resumen = DB::table('resumen_diario')->where('IdEmpresa',session('id_empresa'))
                                              ->where('IdResumenDiario',$data['id_resumen'])
                                              ->first();

        $fecha_generacion = \DateTime::createFromFormat('Y-m-d',$resumen->FecGeneracion);
        $fecha_resumen = \DateTime::createFromFormat('Y-m-d',$resumen->FecResumen);
        // echo ($resumen->IdResumenDiario.'-'.$fecha_generacion.'- ' .$fecha_resumen.'-'.$resumen->FecGeneracion);
        // return;
        $sum = new Summary();
        $sum->setFecGeneracion($fecha_generacion)
            ->setFecResumen($fecha_resumen)
            ->setCorrelativo($resumen->Correlativo)
            ->setCompany(EFacturacion::obtenerCompany());
            // ->setDetails($detalles_resumen);
        $respuesta = EFacturacion::consultarEstadoResumen($resumen->Ticket,$resumen->IdResumenDiario,$sum);

        
        return json_encode(DB::table('v_resumenes_comprobante')->where('id_resumen',$data['id_resumen'])->first() );
      
    }

    public function eliminarResumen(Request $request)
    {
        $data = $request->all();
        //Cambiar el estado del Resumen a 6 Eliminado
        DB::table('resumen_diario') ->where('IdResumenDiario',$data['id_resumen'])
                                    ->where('IdEmpresa',session('id_empresa'))
                                    ->update([
                                        'IdEstadoComprobante' => 6
                                    ]);
        
        return json_encode(DB::table('v_resumenes_comprobante')->where('id_resumen',$data['id_resumen'])->first() );
    }    

    public function reenviarResumen(Request $request)
    {
        $data = $request->all();
        $resumen = DB::table('resumen_diario')->where('IdEmpresa',session('id_empresa'))
                                            ->where('IdResumenDiario',$data['id_resumen'])
                                            ->first();
       
        $sum_xml = \Storage::disk('s3')->get($resumen->NameXmlFile.'.xml');
                                            
        EFacturacion::reenviarResumenSunat($resumen,$sum_xml);

        return json_encode(DB::table('v_resumenes_comprobante')->where('id_resumen',$data['id_resumen'])->first() );
    }

}
