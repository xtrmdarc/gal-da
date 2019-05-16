<?php

namespace App\Http\Controllers\Application\Comprobantes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\EFacturacion;
use function GuzzleHttp\json_encode;
use function GuzzleHttp\json_decode;

class NotasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
        $this->middleware('vActualizacion');
    }
    public function indexCredito()
    {
        
        $motivos_nota_cred = DB::table('motivo_nota_cred')->get();
        $data =[
            'titulo_vista'=>'Notas de crédito',
            'breadcrumb'=> 'comprobantes.nota_cred',
            'motivos_nota_cred' => $motivos_nota_cred
        ];
        return view('contents.application.comprobantes.notas_cred')->with($data);
    }
    public function indexDebito()
    {
        return view('contents.application.comprobantes.notas_cred')->with($data);
    }

    public function listarFolios(Request $request)
    {
        $data = $request->all();
        $folios = DB::table('v_comprobante')->whereRaw('folio LIKE ? ',['%'.$data['criterio'].'%'])->get();

        return json_encode($folios);
    }

    public function obtenerComprobanteYDetalles(Request $request)
    {
        $respuesta = new \stdClass();
        $data = $request->all();
        //Obtener el id de venta.

        $comprobante_query = DB::table('v_comprobante')
                            ->where('id_empresa',session('id_empresa'))
                            ->where('folio',$data['folio']);
                        
        $comprobante =  $comprobante_query->first();
        if(!isset($comprobante))
        {
            $respuesta->code = 0;
            $respuesta->mensaje_error = 'No se encontró el comprobante';
            $respuesta->label_error = 'Algo sucedió';
            return json_encode($respuesta);
        }
        
        // $comprobante->detalles = [];
        $detalles = DB::table('tm_detalle_venta')
                        ->where('id_venta',$comprobante->id_venta)
                        ->get();
        
        $comprobante->detalles = $detalles;

        $respuesta->code = 1;
        $respuesta->comprobante = $comprobante;
        
        return json_encode($respuesta);
    }

    public function registrarNotaCredito(Request $request)
    {
        $respuesta = new \stdClass();
        $data = $request->all();

        $nota = $request->nota;
        $nota_obj = json_decode(json_encode($nota)); 

        if(!isset($nota_obj->detalles) )
        {
            $respuesta->code = 0;
            $respuesta->mensaje = 'No existen items para la nota de crédito';
        }
        if(!isset($nota_obj->id_motivo) || $nota_obj->id_motivo == "")
        {
            $respuesta->code = 0;
            $respuesta->mensaje = 'No se escogió un motivo';
        }
        if(!isset($nota_obj->sustento))
        {
            $respuesta->code = 0;
            $respuesta->mensaje = 'No se detalló el sustento';
        }

        if(isset($respuesta->code ))
        {   
            return json_encode($respuesta);
        }

        $nota_obj->doc_afectado = DB::table('v_comprobante')->where('id_venta',$nota_obj->id_comprobante)
                                                        ->where('id_empresa',session('id_empresa'))
                                                        ->first();
        $nota_obj->codigo_motivo = DB::table('motivo_nota_cred')->where('id_motivo_nota_cred',$nota_obj->id_motivo)->first()->codigo_motivo_nota_cred;
        
        $query_correlativo = DB::select("SELECT LPAD(count(n.IdNota)+ifnull(tde.correlativo,0 ),8,'0') correlativo 
                                        from  v_notas n
                                        right join tipo_doc_empresa tde on tde.id_empresa = n.IdEmpresa
                                        where tde.id_tipo_doc = ? AND n.IdEmpresa = ? AND n.IdTipoDocRelacionado = ?
                                        ",
                                        [   7 //por ser nota de credito
                                            ,session('id_empresa')
                                            ,$nota_obj->doc_afectado->tipo_doc_codigo =='03'?5:6
                                        ]
                                        )[0];
        $nota_obj->correlativo = $query_correlativo->correlativo;
        $nota_obj->serie = ($nota_obj->doc_afectado->tipo_doc_codigo =='03'?'B':'F'). DB::table('tipo_doc_empresa')->where('id_tipo_doc',7)
                                                        ->where('id_empresa',session('id_empresa'))
                                                        ->first()->serie;

        //Falta sacar la serie y el correlativo
        $respuesta = json_encode(EFacturacion::generarNotaCredito($nota_obj));
        return  $respuesta;
    }

    public function buscarNotasCred(Request $request)
    {
        $data = $request->all();
        
        $notas_query = DB::table('v_notas')->where('IdEmpresa',session('id_empresa'))->where('IdTipoDoc',7);

        if(isset($data['cliente_id'])&& $data['cliente_id']!= '')
        {
            $notas_query = $notas_query->where('IdCliente',$data['cliente_id']);
        }
        // Si lo queremos por rango de fechas
        // if(isset($data['fecha_inicio'])&& $data['fecha_inicio']!= '')
        // {
        //     $notas_query = $facturas_query->where(DB::raw('date(FechaEmision)'),'>=',date('Y-m-d',strtotime($data['fecha_inicio'])));
        // }
        // if(isset($data['fecha_final'])&& $data['fecha_final']!= '')
        // {
        //     $notas_query = $facturas_query->where(DB::raw('date(FechaEmision)'),'<=',date('Y-m-d',strtotime($data['fecha_final'])));
        // }

        if(isset($data['documento_folio'])&& $data['documento_folio']!= '')
        {
            $notas_query = $notas_query->where('Folio',$data['documento_folio']);
        }
        
        if(isset($data['fecha'])&& $data['fecha']!= '')
        {
            $notas_query = $notas_query->where(DB::raw('date(FechaEmision)'),date('Y-m-d',strtotime($data['fecha'])));
        }

        return json_encode($notas_query->get());
       
    }

    public function listarFoliosNotaCredito(Request $request){
        $data = $request->all();
        $folios = DB::table('v_notas')->whereRaw('Folio LIKE ? ',['%'.$data['criterio'].'%'])
                                    ->where('IdTipoDoc',7)
                                    ->get();

        return json_encode($folios);
    }

}
