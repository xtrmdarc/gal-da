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

        $nota_obj->serie = 

        //Falta sacar la serie y el correlativo
        $respuesta = json_encode(EFacturacion::generarNotaCredito($nota_obj));
        return  $respuesta;
    }

}
