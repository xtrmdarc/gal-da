<?php

namespace App\Models;

use App\Models;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Illuminate\Support\Facades\DB;
use Greenter\Ws\Services\SunatEndpoints;
use App\Http\Controllers\Application\AppController;

class EFacturacion
{
    
    public static function obtenerCompany(){

        $datos_empresa = AppController::DatosEmpresa(session('id_empresa'));
        $company = new Company();
        $company->setRuc($datos_empresa->ruc);
        $company->setRazonSocial($datos_empresa->razon_social);
        // $company->setNombreComercial($datos_empresa->nombre_empresa);//opcional
        // $company->setAddress() Falta implementar
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
            ->setIgv($detlale->igv) //falta guardar
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
        $path = $util->writeXml($invoice, $signedInvoiceXml); // Configurar para que se guarde en el bucket y guardar esa ruta en la bd
        
        // Guardar Hash en tm_venta y v_ventas_con y la ruta del S3 donde se guardará el archivo xml
        $hash = $util->getHashFromSignedXml($signedInvoiceXml);
        DB::table('tm_venta')->where('id_venta',$id_venta)->update([
                                    'name_xml_file' => $invoice->getName(),
                                    'path_xml_file' => $path,
                                    'hash_xml_file' => $hash
                                    ])
                                ;
        
        /*
        if ($res->isSuccess()) {

            /**@var $res \Greenter\Model\Response\BillResult
            $cdr = $res->getCdrResponse();
            $util->writeCdr($invoice, $res->getCdrZip());
            $util->showResponse($invoice, $cdr);
        } else {
            echo $util->getErrorResponse($res->getError());
        }
        */

    }
   


}
