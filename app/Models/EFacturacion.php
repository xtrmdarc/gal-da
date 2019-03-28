<?php

namespace App\Models;

use App\Models;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Illuminate\Support\Facades\DB;
use Greenter\Ws\Services\SunatEndpoints;
use App\Http\Controllers\Application\AppController;

class EFacturacion
{
    
    public static function obtenerCompany(){
        
        // Direccion provisional
        $address = new Address();
        $address->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setUrbanizacion('NONE')
            ->setDireccion('AV LS');

        $datos_empresa = AppController::DatosEmpresa(session('id_empresa'));
        $company = new Company();
        $company->setRuc($datos_empresa->ruc);
        $company->setRazonSocial($datos_empresa->razon_social);
        $company->setNombreComercial($datos_empresa->nombre_empresa);//opcional
        $company->setAddress($address);
        // $company->email() //opcional

        return $company;
    }

    public static function obtenerCliente($id_cliente){

        $cliente_bd = DB::table('tm_cliente')->where('id_cliente',$id_cliente)->first();

        $cliente = new Client();
        
        if($cliente_bd->id_cliente  == 1 || (!isset($cliente_bd->ruc) && !isset($cliente_bd->dni) )  ) 
        {
            $cliente->setTipoDoc('1');
            $cliente->setNumDoc('-');
            $cliente->setRznSocial('PUBLICO EN GENERAL');
        }
        else
        {
            if(isset($cliente_bd->ruc))
            {
                $cliente->setTipoDoc('6');
                $cliente->setNumDoc($cliente_bd->ruc);
                $cliente->setRznSocial($cliente_bd->razon_social);
            }
            else {
                $cliente->setTipoDoc('1');
                $cliente->setNumDoc($cliente_bd->dni);
                $cliente->setRznSocial($cliente_bd->nombres.' '.$cliente_bd->ape_paterno.' '.$cliente_bd->ape_materno);
            }
        }
        
        return $cliente;
    }

    public static function generarInvoice($id_venta){
        
        // dd($id_venta);
        //Iniciar el utilitario
        $util = Util::getInstance();
        //Obtener la venta y sus detalles
        $venta = DB::table('tm_venta')->where('id_venta',$id_venta)->where('id_empresa',session('id_empresa'))->first();
        $detalles_venta = DB::table('tm_detalle_venta')->where('id_venta',$venta->id_venta)->get();
        
        //Setear cliente
        $cliente = self::obtenerCliente($venta->id_cliente);

        //Setear compañia
        $empresa = self::obtenerCompany();
        
        //iniciar detaller invoice
        $detalles_invoice = array();
        //Iniciar invoice
        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            // ->setFecVencimiento(new \DateTime()) //falta guardar
            ->setTipoOperacion($venta->tipo_operacion) //falta guardar
            ->setTipoDoc($venta->tipo_doc) //falta guardar
            ->setSerie($venta->serie_doc) 
            ->setCorrelativo($venta->nro_doc) 
            ->setFechaEmision( \DateTime::createFromFormat('Y-m-d H:i:s',$venta->fecha_venta))
            ->setTipoMoneda($venta->tipo_moneda)//falta guardar
            ->setClient($cliente)
            ->setMtoOperGravadas($venta->mto_oper_gravadas) //total  / (1+igv) //falta guardar
            //->setMtoOperExoneradas(100) //falta guardar
            ->setMtoIGV($venta->mto_igv) // (total  / (1+igv)) * 0.18 //falta guardar
            ->setTotalImpuestos($venta->mto_igv) // (total  / (1+igv)) * 0.18 //falta guardar
            ->setValorVenta($venta->valor_venta) // total  / (1+igv) //falta guardar
            ->setMtoImpVenta($venta->mto_imp_venta) // total //falta guardar
            ->setCompany($empresa);
        
        foreach($detalles_venta as $detalle)
        {
            $item = new SaleDetail();
            $item->setCodProducto($detalle->cod_producto) //falta guardar
            ->setUnidad($detalle->unidad) //falta guardar
            ->setDescripcion($detalle->descripcion) //falta guardar
            ->setCantidad($detalle->cantidad)
            ->setMtoValorUnitario($detalle->mto_valor_unitario) //falta guardar
            ->setMtoValorVenta($detalle->mto_valor_venta) //falta guardar
            ->setMtoBaseIgv($detalle->mto_base_igv) //falta guardar
            ->setPorcentajeIgv($detalle->porcentaje_igv) //falta guardar
            ->setIgv($detalle->igv) //falta guardar
            ->setTipAfeIgv($detalle->tip_afe_igv) //falta guardar
            ->setTotalImpuestos($detalle->total_impuestos) //falta guardar
            ->setMtoPrecioUnitario($detalle->mto_precio_unitario) //falta guardar
            ;

            $detalles_invoice[] = $item;
        }
        
       
        $invoice->setDetails($detalles_invoice)
        ->setLegends([
            (new Legend())
                ->setCode('1000')
                ->setValue($util->numtoletras($venta->mto_imp_venta))
        ]);
        // Envio a SUNAT.
        $see = $util->getSee(SunatEndpoints::FE_BETA);
        
        /** Si solo desea enviar un XML ya generado utilice esta función**/
        //$res = $see->sendXml(get_class($invoice), $invoice->getName(), file_get_contents($ruta_XML));
        // $res = $see->send($invoice);

        // Aqui se obtiene el xml que se firmó antes de enviarse a la sunat
        // $util->writeXml($invoice, $see->getFactory()->getLastXml());

        // Aqui se firma el xml y se obtiene el xml firmado para guardarse
        $signedInvoiceXml = $see->getXmlSigned($invoice);
        // Se obtiene la ruta donde se alojará el archivo
        $path = $util->writeXml($invoice, $signedInvoiceXml,'S3'); // Configurar para que se guarde en el bucket y guardar esa ruta en la bd
        
        // Guardar Hash en tm_venta y v_ventas_con y la ruta del S3 donde se guardará el archivo xml
        $hash = $util->getHashFromSignedXml($signedInvoiceXml);
        DB::table('tm_venta')->where('id_venta',$id_venta)->update([
                                    'name_xml_file' => $invoice->getName(),
                                    'path_xml_file' => $path,
                                    'hash_xml_file' => $hash,
                                    'nombre_cliente' => $cliente->getRznSocial(),
                                    'id_estado_comprobante' => 2
                                    ])
                                ;

    }
   
    
    public static function enviarInvoiceSunat($id_venta)
    {
        $util = Util::getInstance();
        //Necesito el invoice 

        $doc = DB::table('v_factura_invoice')->where('id_venta',$id_venta)
                                    ->where('id_empresa',session('id_empresa'))->first();


        // Envio a SUNAT
        $see = $util->getSee(SunatEndpoints::FE_BETA);
        
        /** Si solo desea enviar un XML ya generado utilice esta función**/
        $invoice_content = \Storage::disk('s3')->get($doc->path_xml_file);
        // $invoice_dom = new \DOMDocument();
        // $invoice_dom->loadXML($invoice_content);
        // $util->toInvoice($invoice_dom);
        //  echo ($invoice_content);
        // echo $invoice_content;
        $company = new Company ();
        $datos_empresa = AppController::DatosEmpresa(session('id_empresa'));
        $company->setRuc($datos_empresa->ruc);
        $invoice = new Invoice();
        $invoice->setCompany($company);
        $invoice->setTipoDoc($doc->tipo_doc_codigo);
        $invoice->setSerie($doc->serie);
        $invoice->setCorrelativo($doc->correlativo);
       
        $res = $see->sendXml(get_class($invoice),$invoice->getName(), $invoice_content);
        // $res = $see->send($invoice);
        DB::table('tm_venta')->where('id_venta',$id_venta)->update(['id_estado_comprobante'=>3]);
        // $util->writeXml($invoice, $see->getFactory()->getLastXml(),'S3');
        if ($res->isSuccess()) {
            /**@var $res \Greenter\Model\Response\BillResult*/
            $cdr = $res->getCdrResponse();
            $util->writeCdr($invoice, $res->getCdrZip(),'S3');
            
            if($cdr->getCode() == '0')
            {
                DB::table('tm_venta')->where('id_venta',$id_venta)
                                    ->update(['mensaje_sunat'=>$cdr->getDescription(),
                                            'codigo_sunat'=>$cdr->getCode(),
                                            'id_estado_comprobante'=>4]);
                                
            }
            else
            {
                DB::table('tm_venta')->where('id_venta',$id_venta)
                ->update(['mensaje_sunat'=>$cdr->getDescription(),
                        'codigo_sunat'=>$cdr->getCode()]);
            }    
           
            // $util->showResponse($invoice, $cdr);
        } else {
            echo $util->getErrorResponse($res->getError());
        }
    }

    public static function darBajaFacturaSunat($id_venta)
    {
        //necesito el invoice Falta implementar
        $doc = DB::table('tm_venta')->where('id_venta',$id_venta)
                                    ->where('id_empresa',session('id_empresa'))->first();
    }

    public static function getResumenItemBoleta($boleta)
    {   
        $cliente = self::obtenerCliente($boleta->id_cliente);
        $resumen_item = new SummaryDetail();
        $resumen_item->setTipoDoc($boleta->tipo_doc)
                // ->setSerieNro($boleta->serie_doc.'-0'.$cont)
                ->setSerieNro($boleta->serie_doc.'-'.$boleta->nro_doc)
                ->setEstado('3') // 1 adicionar | 2 modificar | 3 anulado
                ->setClienteTipo($cliente->getTipoDoc())
                ->setClienteNro($cliente->getNumDoc())
                ->setTotal($boleta->mto_imp_venta)
                ->setMtoOperGravadas($boleta->mto_oper_gravadas)
                // ->setMtoOperInafectas(24.4)
                // ->setMtoOperExoneradas(50)
                // ->setMtoOperExportacion(10)
                // ->setMtoOtrosCargos(21)
                ->setMtoIGV($boleta->mto_igv);
        return $resumen_item;
    }

    public static function getResumenItemNota($nota)
    {
        //Falta implementar
        $cliente = self::obtenerCliente($boleta->id_cliente);
        $resumen_item = new SummaryDetail();
        $resumen_item->setTipoDoc('07')
                ->setSerieNro('B001-4')
                ->setDocReferencia((new Document())
                    ->setTipoDoc('03')
                    ->setNroDoc('0001-122'))
                ->setEstado('1')
                ->setClienteTipo('1')
                ->setClienteNro('00000000')
                ->setTotal(200)
                ->setMtoOperGravadas(40)
                ->setMtoOperExoneradas(30)
                ->setMtoOperInafectas(120)
                ->setMtoIGV(7.2)
                ->setMtoISC(2.8);

        return $resumen_item;

    }

    public static function enviarResumenSunat($id_boletas,$id_notas)
    {   
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        $response = new \stdClass();
        $util = Util::getInstance();
        $detalles_resumen = array();
        
        //obtener los datos de boleta
        $boletas = DB::table('tm_venta')->whereIn('id_venta',$id_boletas)->where('id_empresa',session('id_empresa'))->get();
        //obtener los datos de las notas
        $notas = DB::table('nota')->whereIn('IdNota',$id_notas)->where('IdEmpresa',session('id_empresa'))->get();
        

        //Generar todas las boletas como detalles de resumen
        // $cont = 1;
        foreach($boletas as $boleta)
        {
            $fecha_comprobantes = $boleta->fecha_venta;
            // for($i = 0; $i < 100; $i++)
            // $detalles_resumen[] = self::getResumenItemBoleta($boleta,$i+1+$cont*100);
            $detalles_resumen[] = self::getResumenItemBoleta($boleta);
            // $cont++
        }
        //Generar todas las notas como detalles de resumen
        foreach($notas as $nota)
        {
            $fecha_comprobantes = $nota->FechaEmision;
            $detalles_resumen[] = self::getResumenItemNota($nota);
        }
        $fecha_generacion = \DateTime::createFromFormat('Y-m-d H:i:s',$fecha_comprobantes);
        $fecha_resumen = new \DateTime();
        //Crear resumen y añadir detalles
        $query = DB::table('resumen_diario')->select(DB::raw("LPAD(count(*)+1,3,'0') correlativo"))
                                                ->where('IdEmpresa',session('id_empresa'))
                                                ->where('FecResumen',$fecha_resumen->format('Y-m-d'))
                                                ->get()[0];

        $sum = new Summary();
        $sum->setFecGeneracion($fecha_generacion)
            ->setFecResumen($fecha_resumen)
            ->setCorrelativo($query->correlativo)
            ->setCompany(self::obtenerCompany())
            ->setDetails($detalles_resumen);
       
                                    
        $see = $util->getSee(SunatEndpoints::FE_BETA);

        //Guardar el xml
        $signedXml = $see->getXmlSigned($sum);
        $path = $util->writeXml($sum, $signedXml,'S3');
        
        // Envio a SUNAT.
        $res = $see->sendXml(get_class($sum),$sum->getName(),$signedXml);

        if (!$res->isSuccess()) {
            // Si hay error en el envio del resumen
             $response->cod = 0;
             $response->mensaje = $res->getError()->getMessage();
            //  DB::table('resumen_diario')->where('IdResumenDiario',$resumen_id_db)
            //                             ->update(['IdestadoComprobante' => 5,
            //                                     'MensajeSunat'=> $res->getError()->getMessage(),
            //                                     'CodigoSunat'=> $res->getError()->getCode() 
            //                             ]);
            return json_encode($response);
        }
        
        //Si no hay error regresa con un ticket
        /**@var $res \Greenter\Model\Response\SummaryResult*/
        $ticket = $res->getTicket();
        
        //Crear un SP que guarde el resumen. El correlativo debe ser calculado en base a los envios del dia por empresa
        $resumen_id_db = DB::table('resumen_diario')->insertGetId([
                                    'FecGeneracion' => $fecha_generacion,
                                    'FecResumen' => $fecha_resumen,
                                    'Correlativo' => $query->correlativo,
                                    'IdEmpresa' => session('id_empresa'),
                                    'NameXmlFile' => $sum->getName(),
                                    'MensajeSunat'=> 'Evaluando. Se asigna ticket '.$ticket ,
                                    'IdEstadoComprobante'=> 3,
                                    'Ticket' => $ticket,
                                    'PathXmlFile' => $path
                                ]);
        DB::table('tm_venta')->whereIn('id_venta',$id_boletas)
                            ->update([
                                'id_estado_comprobante' =>3,
                                'id_ultimo_resumen' => $resumen_id_db
                            ]);

        DB::table('nota')->whereIn('IdNota',$id_notas)
                        ->update([
                            'IdEstadoComprobante'=>3,
                            'IdUltimoResumen' => $resumen_id_db
                        ]);
        // DB::table('resumen_diario')->where('IdResumenDiario',$resumen_id_db)
        //                             ->update(['IdestadoComprobante' => 3,
        //                                   ,
        //                                     'CodigoSunat'=> '' ,      
        //                             ]);
        
        //Hasta aca llegamos
        return json_encode(self::consultarEstadoResumen($ticket,$resumen_id_db,$sum));

        
        //Consultar el estado 
        
    }

    //El $sum es el documento solo necesitamos le nombre
    public static function consultarEstadoResumen($ticket,$resumen_id_db,$sum)
    {
        $response = new \stdClass();
        $util = Util::getInstance();
        $see = $util->getSee(SunatEndpoints::FE_BETA);
        $res = $see->getStatus($ticket);
        if (!$res->isSuccess()) {
            //Si hay error en la consulta del estado del ticket
            $response->cod = 0;
            $response->mensaje = $res->getError()->getMessage();
            // echo $util->getErrorResponse($res->getError());
            DB::table('resumen_diario')->where('IdResumenDiario',$resumen_id_db)
                                        ->update(['IdestadoComprobante' => 5,
                                                'MensajeSunat'=> $res->getError()->getMessage(),
                                                'CodigoSunat'=> $res->getError()->getCode()
                                        ]);
        DB::table('tm_venta')->where('id_ultimo_resumen',$resumen_id_db)
                            ->update([
                                'id_estado_comprobante' =>5
                            ]);

        DB::table('nota')->where('IdUltimoResumen',$resumen_id_db)
                        ->update([
                            'IdEstadoComprobante'=>5
                        ]);
            return $response;
        }
        // Si no hay error en la consulta del estado del ticket
        $cdr = $res->getCdrResponse();
        $util->writeCdr($sum, $res->getCdrZip(),'S3');
        DB::table('resumen_diario')->where('IdResumenDiario',$resumen_id_db)
                                    ->update(['IdEstadoComprobante'=> 4,
                                            'MensajeSunat'=> $cdr->getDescription(),
                                            'CodigoSunat'=> $cdr->getCode() 
                                    ]);

        DB::table('tm_venta')->where('id_ultimo_resumen',$resumen_id_db)
                            ->update([
                                'id_estado_comprobante' =>4,
                                'id_estado_doc_resumen'=> 1
                            ]);
        
        DB::table('nota')->where('IdUltimoResumen',$resumen_id_db)
                        ->update([
                            'IdEstadoComprobante'=>4,
                            'IdEstadoDocResumen' => 1
                        ]);
        $response->cod = 1;
        $response->mensaje = $cdr->getDescription();
        return $response;
      
    }


    public static function reenviarResumenSunat($resumen_db,$sum_xml)
    {
        $response = new \stdClass();
        $fecha_generacion = \DateTime::createFromFormat('Y-m-d',$resumen_db->FecGeneracion);
        $fecha_resumen = \DateTime::createFromFormat('Y-m-d',$resumen_db->FecResumen) ;
        
        $sum = new Summary();
        $sum->setFecGeneracion($fecha_generacion)
            ->setFecResumen($fecha_resumen)
            ->setCorrelativo($resumen_db->Correlativo)
            ->setCompany(self::obtenerCompany());
            // ->setDetails($detalles_resumen);
       
        // Envio a SUNAT.
        $util = Util::getInstance();
        $see = $util->getSee(SunatEndpoints::FE_BETA);
        $res = $see->sendXml(get_class($sum),$sum->getName(),$sum_xml);
        

        if (!$res->isSuccess()) {
            // Si hay error en el envio del resumen
            $response->cod = 0;
            $response->mensaje = $res->getError()->getMessage();
            DB::table('resumen_diario')->where('IdResumenDiario',$resumen_db->IdResumenId)
                                    ->update(['IdEstadoComprobante' => 5,
                                                'MensajeSunat'=> $res->getError()->getMessage(),
                                                'CodigoSunat'=> $res->getError()->getCode() 
                                        ]);
            return json_encode($response);
        }
        
        //Si no hay error regresa con un ticket
        /**@var $res \Greenter\Model\Response\SummaryResult*/
        $ticket = $res->getTicket();
        
        DB::table('resumen_diario')->where('IdEmpresa',session('id_empresa'))
                                    ->where('IdResumenDiario',$resumen_db->IdResumenDiario)
                                    ->update([
                                        'Ticket' => $ticket
                                    ]);
                            
        $response = self::consultarEstadoResumen($ticket,$resumen_db->IdResumenDiario,$sum);
        return $response;
   
    }


}
