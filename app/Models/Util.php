<?php

namespace App\Models;

// use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\CdrResponse;
use Greenter\Report\HtmlReport;
use Greenter\Report\PdfReport;
use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\See;
use Illuminate\Support\Facades\Storage;
use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Illuminate\Support\Facades\URL;
use mikehaertl\wkhtmlto\Pdf;
use App\Http\Controllers\Application\AppController;



class Util
{
    const ROOT_PREFIX = 'xs';
    private $error;
    /**
     * @var PathResolverInterface
     */
    public $pathResolver;
    /**
     * @var SchemaValidatorInterface
     */
    public $schemaValidator;

    private $rootNs;
    private $xpath;

    public function numtoletras($xcifra,$codigo_moneda = null)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
    //
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }
    
        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }
    
                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                                
                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                                
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                                
                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO
    
            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";
    
            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";
    
            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO CON $xdecimales/100 ".$codigo_moneda?$codigo_moneda:'SOLES';
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN CON $xdecimales/100 ".$codigo_moneda?$codigo_moneda:'SOLES';
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " CON $xdecimales/100 ".$codigo_moneda?$codigo_moneda:'SOLES'; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }
    
    // END FUNCTION
    
    public function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }
    
    //end FUNCTION

    private static $current;
    /**
     * @var SharedStore
     */
    public $shared;
    private function __construct()
    {
        // $this->shared = new SharedStore();
    }
    public static function getInstance()
    {
        if (!self::$current instanceof self) {
            self::$current = new self();
        }
        return self::$current;
    }
    /**
     * @param string $endpoint
     * @return See
     */
    public function getSee($endpoint)
    {
        $see = new See();
        $see->setService($endpoint);
//        $see->setCodeProvider(new XmlErrorCodeProvider());
        $see->setCertificate(file_get_contents(__DIR__ . '/certificate.pem'));
        $see->setCredentials('20000000001MODDATOS', 'moddatos');
        // $see->setCachePath(__DIR__ . '/../cache');
        return $see;
    }
    public function showResponse(DocumentInterface $document, CdrResponse $cdr)
    {
        $filename = $document->getName();
        require __DIR__.'/../views/response.php';
    }
    public function getErrorResponse(\Greenter\Model\Response\Error $error)
    {
        $result = <<<HTML
        <h2 class="text-danger">Error:</h2><br>
        <b>Código:</b>{$error->getCode()}<br>
        <b>Descripción:</b>{$error->getMessage()}<br>
HTML;
        return $result;
    }
    public function writeXml(DocumentInterface $document, $xml, $repo)
    {   
        switch ($repo)
        {
            case  'DISK' : {$path = $this->writeFile($document->getName().'.xml', $xml);break; }
            case  'S3' : {
                $anio_actual = date("Y");
                $empresa = AppController::DatosEmpresa(session('id_empresa'));
                $path = $this->writeFileS3('/'.$anio_actual.'/'.$empresa->nombre_empresa.'/'.$document->getName().'.xml', $xml); break; 
            }
            default : {
                $path = $this->writeFile($document->getName().'.xml', $xml); 
            }
        }
        return $path;
    }

    public function writeCdr(DocumentInterface $document, $zip,$repo)
    {
        switch ($repo)
        {
            case  'DISK' :{ $this->writeFile('R-'.$document->getName().'.zip', $zip);break;}
            case  'S3' :{ 
                $anio_actual = date("Y");
                $empresa = AppController::DatosEmpresa(session('id_empresa'));
                $this->writeFileS3('/'.$anio_actual.'/'.$empresa->nombre_empresa.'/'.'R-'.$document->getName().'.zip', $zip);break;
            }
            default:{
                { $this->writeFile('R-'.$document->getName().'.zip', $zip);break;}
            }
        }
    }
    public function writeFile($filename, $content)
    {
        if (getenv('GREENTER_NO_FILES')) {
            return;
        }
        $path = __DIR__.'/'.$filename;
        // file_put_contents(__DIR__.'/../files/'.$filename, $content);
        file_put_contents($path, $content);
        return $path;
    }

    public function writeFileS3($filename, $content)
    {
        if (getenv('GREENTER_NO_FILES')) {
            return;
        }

        Storage::disk('s3_billing_c')->put($filename, $content);
               
        // $path = __DIR__.'/'.$filename;
        // file_put_contents(__DIR__.'/../files/'.$filename, $content);
        // file_put_contents($path, $content);
        return $filename;
    }

    public function writeXml_g(DocumentInterface $document, $xml, $repo)
    {   
        switch ($repo)
        {
            case  'DISK' : {$path = $this->writeFile($document->getName().'.xml', $xml);break; }
            case  'S3' : {
                $anio_actual = date("Y");
                $empresa = AppController::DatosEmpresa(session('id_empresa'));
                $path = $this->writeFileS3_g('/'.$anio_actual.'/'.$empresa->nombre_empresa.'/'.$document->getName().'.xml', $xml); break; 
            }
            default : {
                $path = $this->writeFile($document->getName().'.xml', $xml); 
            }
        }
        return $path;
    }

    public function writeCdr_g(DocumentInterface $document, $zip,$repo)
    {
        switch ($repo)
        {
            case  'DISK' :{ $this->writeFile('R-'.$document->getName().'.zip', $zip);break;}
            case  'S3' :{ 
                $anio_actual = date("Y");
                $empresa = AppController::DatosEmpresa(session('id_empresa'));
                $this->writeFileS3_g('/'.$anio_actual.'/'.$empresa->nombre_empresa.'/'.'R-'.$document->getName().'.zip', $zip);break;
            }
            default:{
                { $this->writeFile('R-'.$document->getName().'.zip', $zip);break;}
            }
        }
    }

    public function writeFileS3_g($filename, $content)
    {
        if (getenv('GREENTER_NO_FILES')) {
            return;
        }

        Storage::disk('s3_billing_g')->put($filename, $content);
               
        // $path = __DIR__.'/'.$filename;
        // file_put_contents(__DIR__.'/../files/'.$filename, $content);
        // file_put_contents($path, $content);
        return $filename;
    }

    public function generarReciboPdfGalda($billing_info,$plan_culqi,$parameters_recibo)
    {
        $pdf = new Pdf();
        $pdf->setOptions([
            'no-outline',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            // 'footer-html' => __DIR__.'/../resources/footer.html',
        ]);
        //Los datos
        $data =[ 'billing_info'=> $billing_info, 'plan_culqi'=>$plan_culqi,'param'=>$parameters_recibo];
        $pdf->addPage(view('contents.application.suscripcion.template_recibo')->with($data)->render());
        $binPath = self::getPathBin();
        if (file_exists($binPath)) {
            $render->setBinPath($binPath);
        }
        // $this->writeFile($document->getName().'.html', $render->getHtml());
        $pdf_content = $pdf->toString();
        if ($pdf_content === false) {
            $error = $pdf->getError();
            
            echo 'Error: '.$error;
            exit();
        }
        return $pdf_content;
    }

    public function getPdf(DocumentInterface $document)
    {
        $html = new HtmlReport('/', [
            // 'cache' => __DIR__ . '/../cache',
            'strict_variables' => true,
        ]);
        $resolver = new DefaultTemplateResolver();
        $template = $resolver->getTemplate($document);
        $html->setTemplate($template);
        $render = new PdfReport($html);
        $render->setOptions( [
            'no-outline',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            // 'footer-html' => __DIR__.'/../resources/footer.html',
        ]);
        $binPath = self::getPathBin();
        if (file_exists($binPath)) {
            $render->setBinPath($binPath);
        }
        $hash = $this->getHash($document);
        //Setear nuestros parametros
        $params = self::getParametersPdf();
        $params['system']['hash'] = $hash;
        // $params['user']['footer'] = '<div>consulte en <a href="https://github.com/giansalex/sufel">sufel.com</a></div>';
   
        $pdf = $render->render($document, $params);
        
        if ($pdf === false) {
            $error = $render->getExporter()->getError();
            
            echo 'Error: '.$error;
            exit();
        }
        // Write html
        // $this->writeFile($document->getName().'.html', $render->getHtml());
        return $pdf;
    }
    public function getGenerator($type)
    {
        $factory = new \Greenter\Data\GeneratorFactory();
        $factory->shared = $this->shared;
        return $factory->create($type);
    }
    public static function generator($item, $count)
    {
        $items = [];
        for ($i = 0; $i < $count; $i++) {
            $items[] = $item;
        }
        return $items;
    }
    public function showPdf($content, $filename)
    {
        $this->writeFile($filename, $content);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($content));
        echo $content;
    }
    public static function getPathBin()
    {
        $path = __DIR__.'wkhtmltopdf';
        if (self::isWindows()) {
            $path .= '.exe';
        }
        return $path;
    }
    public static function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
    public static function inPath($command) {
        $whereIsCommand = self::isWindows() ? 'where' : 'which';
        $process = proc_open(
            "$whereIsCommand $command",
            array(
                0 => array("pipe", "r"), //STDIN
                1 => array("pipe", "w"), //STDOUT
                2 => array("pipe", "w"), //STDERR
            ),
            $pipes
        );
        if ($process !== false) {
            $stdout = stream_get_contents($pipes[1]);
            stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
            return $stdout != '';
        }
        return false;
    }
    private function getHash(DocumentInterface $document)
    {
        $see = $this->getSee('');
        $xml = $see->getXmlSigned($document);
        $hash = (new \Greenter\Report\XmlUtils())->getHashSign($xml);
        return $hash;
    }

    public function getHashFromSignedXml($signedXml)
    {
        $see = $this->getSee('');
        $xml = $signedXml;
        $hash = (new \Greenter\Report\XmlUtils())->getHashSign($xml);
        return $hash;
    }

    private static function getParametersPdf()
    {
        //Recuerda probar con detalles de factura puestos y logo (o sin logo)
        $logo = file_get_contents(__DIR__.'/../../public/home/images/logo-1.png');
        return [
            'system' => [
                'logo' => $logo,
                'hash' => ''
            ],
            'user' => [
                'resolucion' => '212321',
                'header' => 'Telf: <b>(056) 123375</b>',
                'extras' => [
                    ['name' => 'CONDICION DE PAGO', 'value' => 'Efectivo'],
                    ['name' => 'VENDEDOR', 'value' => 'GAL-DA'],
                ],
            ]
        ];
    }

    public function toInvoice(\DOMDocument $doc)
    {
        if (!$doc->documentElement) {
            throw new \InvalidArgumentException('No se pudo cargar el xml');
        }
        $docName = $doc->documentElement->nodeName;
        $this->rootNs = '/'. self::ROOT_PREFIX . ':' . $docName;
        $this->xpath = new \DOMXPath($doc);
        $this->xpath->registerNamespace(self::ROOT_PREFIX, $doc->documentElement->namespaceURI);
        $inv = $this->getInvoice();
        $totalNodeName = 'cac:LegalMonetaryTotal';
        if ($docName == 'CreditNote') {
            $inv->setTipoDoc('07');
        } elseif ($docName == 'DebitNote') {
            $inv->setTipoDoc('08');
            $totalNodeName = 'cac:RequestedMonetaryTotal';
        }
        $inv->setTotal(floatval($this->getFirst($totalNodeName . '/cbc:PayableAmount')));
        return $inv;
    }
    /**
     * @return Invoice
     */
    private function getInvoice()
    {
        $ubl = $this->getFirst('cbc:UBLVersionID');
        $doc = $this->getFirst('cbc:ID');
        $arr = explode('-', $doc);
        $inv = new Invoice();
        $inv->setTipoDoc($this->getFirst('cbc:InvoiceTypeCode'))
            ->setSerie($arr[0])
            ->setCorrelativo($arr[1])
            ->setFechaEmision(\DateTime::createFromFormat('Y-m-d H:i:s',$this->getFirst('cbc:IssueDate')));
        switch ($ubl) {
            case '2.0':
                $inv->setEmisor($this->getFirst('cac:AccountingSupplierParty/cbc:CustomerAssignedAccountID'))
                    ->setClientTipo($this->getFirst('cac:AccountingCustomerParty/cbc:AdditionalAccountID'))
                    ->setClientDoc($this->getFirst('cac:AccountingCustomerParty/cbc:CustomerAssignedAccountID'))
                    ->setClientName($this->getFirst('cac:AccountingCustomerParty/cac:Party/cac:PartyLegalEntity/cbc:RegistrationName'));
                break;
            case '2.1':
                $inv->setEmisor($this->getFirst('cac:AccountingSupplierParty/cac:Party/cac:PartyIdentification/cbc:ID'))
                    ->setClientTipo($this->getFirst('cac:AccountingCustomerParty/cac:Party/cac:PartyIdentification/cbc:ID/@schemeID'))
                    ->setClientDoc($this->getFirst('cac:AccountingCustomerParty/cac:Party/cac:PartyIdentification/cbc:ID'))
                    ->setClientName($this->getFirst('cac:AccountingCustomerParty/cac:Party/cac:PartyLegalEntity/cbc:RegistrationName'));
                break;
            default:
                throw new \Exception("UBL version $ubl no soportada.");
        }
        return $inv;
    }
    /***
     * Obtiene el primer valor del nodo.
     *
     * @param string $query Relativo al root namespace
     * @return null|string
     */
    private function getFirst($query)
    {
        $nodes = $this->xpath->query($this->rootNs . '/' . $query);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }
        return null;
    }

}
