<?php

namespace App\Http\Controllers\Application\Subscripcion;

use App\Mail\cancelPlan;
use App\Models\TmUsuario;
use App\Models\Sucursal;
use App\Models\TmAlmacen;
use App\Models\TmAreaProd;
use App\Models\TmCaja;
use App\Models\TmMesa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Stripe;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\DB;
use Culqi;
use App\Http\Controllers\Application\AppController;
use App\Models\Util;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Mail;
use App\Mail\invoiceBasic;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    private $SECRET_KEY = "sk_test_asQalOKDq7la1gKr";
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
    }
    public function upgradeShow(){
        return view('auth.subscription');
    }

    public function upgrade_plan($id){
        
        $datos_empresa = AppController::DatosEmpresa(\Auth::user()->id_empresa);
        $billing_info = new \stdClass();
        $card = new \stdClass();
        $card->last_four = 0000;
        $card->creation_date = 0;
        if(isset(\Auth::user()->info_fact_id))
        {
            $billing_info_aux = DB::table('info_fact')->where('IdInfoFact',\Auth::user()->info_fact_id)->first();
            
            $billing_info->EsEmpresarial = $billing_info_aux->EsEmpresarial;
            $billing_info->Nombre= $billing_info_aux->Nombre;
            $billing_info->Apellido= $billing_info_aux->Apellido;
            $billing_info->Email =$billing_info_aux->Email;
            $billing_info->Telefono =$billing_info_aux->Telefono;
            $billing_info->CodigoPais =$billing_info_aux->CodigoPais;
            $billing_info->Ciudad = $billing_info_aux->Ciudad;
            $billing_info->Direccion = $billing_info_aux->Direccion;
            $billing_info->RazonSocial= $billing_info_aux->RazonSocial?$billing_info_aux->RazonSocial:$datos_empresa->nombre_empresa;
            $billing_info->Ruc = $billing_info_aux->Ruc?$billing_info_aux->Ruc:$datos_empresa->ruc;
            $billing_info->CardId = $billing_info_aux->CardId;

            if(isset($billing_info_aux->CardId))
            {
                $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));
                $card_aux = $culqi->Cards->get($billing_info_aux->CardId);
                $card->last_four = $card_aux->source->last_four;
                $card->creation_date = $card_aux->source->creation_date;
                //dd($card);
            }
            
        }
        else 
        {
            $billing_info->EsEmpresarial = 0;
            $billing_info->Nombre= \Auth::user()->nombres;
            $billing_info->Apellido= \Auth::user()->ape_paterno;
            $billing_info->Email =\Auth::user()->email;
            $billing_info->Telefono = \Auth::user()->phone;
            $billing_info->CodigoPais = \Auth::user()->codigo_pais;
            $billing_info->Ciudad = '';
            $billing_info->Direccion = $datos_empresa->direccion;
            $billing_info->RazonSocial= $datos_empresa->nombre_empresa;
            $billing_info->Ruc = $datos_empresa->ruc;

        }
       
        

        $paises = DB::table('pais')->get();

        $planes = DB::table('culqi_plan')->where('id_plan',$id)->get();
        $plan = DB::table('planes')->where('id',$id)->first();
        $data = [
            'culqi_planes'=> $planes,
            'info_fact' => $billing_info,
            'paises' => $paises,
            'tarjeta' => $card,
            'plan'=> $plan
        ];

        //dd($data,isset($info_fact->CardId));
        return view('auth.payment_plan')->with($data);
    }

    public function upgrade(Request $request){

        $post = $request->all();
        dd($post['stripeToken']);
        /*
            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            \Stripe\Stripe::setApiKey("sk_test_30MMhfgvhxA7ySEVyoQN6nf9");

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $token = $_POST['stripeToken'];
            $charge = \Stripe\Charge::create([
                'amount' => 999,
                'currency' => 'usd',
                'description' => 'Example charge',
                'source' => $token,
            ]);
    
            $parentId = \Auth::user()->id_usu;
            $newU = TmUsuario::find($parentId);
            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            \Stripe\Stripe::setApiKey("sk_test_30MMhfgvhxA7ySEVyoQN6nf9");

            $charge = \Stripe\Charge::create([
                'amount' => 79000,
                'currency' => 'usd',
                'description' => 'Test Book',
                'source' => $post['stripeToken'],
            ]);
            //$newU->newSubscription('main', 'premium')->create($post['stripeToken']);
            //$newU->charge(100);
            //dd($newU);
            dd($charge);
        */
        /*
            Stripe::setApiKey(config('services.stripe.secret'));

            $token = request('stripeToken');

            $charge = Charge::create([
                'amount' => 1000,
                'currency' => 'usd',
                'description' => 'Test Book',
                'source' => $token,
            ]);

            return 'Payment Success!';
        */

    }

    public function confirmar_informacion_facturacion(Request $request)
    {   
        
        $data = $request->all();
 

        $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));

        //dd($culqi->Customers->all());
        $usuario = \Auth::user();
        //Crear cliente en culqi
        $arr_culqi_cust = array(
                "address" =>        $data['direccion'],
                "address_city" =>   $data['ciudad'],
                "country_code" =>   $data['pais'], //sacarlo de su usuario
                "email" =>          $data['email'], //sacarlo de su usuario
                "first_name" =>     $data['nombre'], ////sacarlo de su usuario
                "last_name" =>      $data['apellido'],////sacarlo de su usuario
                "metadata" =>       array("test"=>"test"),
                "phone_number" =>   $data['telefono']
        );
        
        $arr_info_fact = array(
            'EsEmpresarial' =>$data['es_empresarial'],
            'Nombre'        =>$data['nombre'],
            'Apellido'      =>$data['apellido'],
            'Email'         =>$data['email'],
            'Telefono'      =>$data['telefono'],
            'CodigoPais'    =>$data['pais'],
            'Ciudad'        =>$data['ciudad'],
            'Direccion'     =>$data['direccion'],
            'RazonSocial'   =>$data['razon_social'],
            'Ruc'           =>$data['ruc']
        );

        if(!isset($usuario->culqi_id))
        {
            $customer = $culqi->Customers->create($arr_culqi_cust);
            
            $info_fact_id = DB::table('info_fact')->insertGetId(
                $arr_info_fact
            );

            DB::table('tm_usuario')->where('id_usu',$usuario->id_usu)
                                ->update([
                                    'culqi_id'=>$customer->id,
                                    'info_fact_id' => $info_fact_id
                                ]);

        }
        else{
            $customer = $culqi->Customers->update($usuario->culqi_id,$arr_culqi_cust);
            DB::table('info_fact')->where('IdInfoFact',$usuario->info_fact_id)->update($arr_info_fact);
            //dd($customer);   
        }
        
        $data['status'] = 1;
        return json_encode($data);
        
    }

    public function agregar_tarjeta(Request $request)
    {
        $data = $request->all();
        $usuario = \Auth::user();

        if(!isset($usuario->culqi_id)) return;

        $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));
       // dd('pasa la instanciacion de cuqli');
        $card = $culqi->Cards->create(
            array(
              "customer_id" => $usuario->culqi_id,
              "token_id" => $data['token']
            )
        );

        DB::table('info_fact')->where('IdInfoFact',$usuario->info_fact_id)
                            ->update([
                                'CardId'=> $card->id
                            ]);

        //Traer Tarjeta
        $infoFact = DB::table('info_fact')->where('IdInfoFact', $usuario->info_fact_id)->first();
        $cardID = $infoFact->CardId;

        $culqui_card = $culqi->Cards->get("$cardID");

        $card_obj = json_encode($culqui_card);

        $source = $culqui_card->source;
        $iin = $source->iin;

        $last_four = $source->last_four;
        $card_brand = $iin->card_brand;

        $params = array(
            $cardID,
            $card_brand,
            $last_four
        );

        if($usuario->id_card == '') {

            DB::insert("INSERT INTO u_card (CardId,card_brand,card_last_four) VALUES (?,?,?)",$params);

            $statement = DB::select("SHOW TABLE STATUS LIKE 'u_card'");
            $u_card_id = $statement[0]->Auto_increment - 1;

            DB::table('tm_usuario')->where('id_usu',$usuario->id_usu)
                ->update([
                    'id_card'=> $u_card_id
                ]);
        } else {
            DB::table('u_card')->where('id_card',$usuario->id_card)
                ->update([
                    'CardId'=> $cardID,
                    'card_brand'=> $card_brand,
                    'card_last_four'=> $last_four
                ]);
        }
        return json_encode($card);
    }

    public function pagar_subscripcion(Request $request)
    {
        /*
                \Stripe\Stripe::setApiKey("sk_test_30MMhfgvhxA7ySEVyoQN6nf9");

                $charge = \Stripe\Charge::create([
                    'amount' => 53,
                    'currency' => 'usd',
                    'description' => 'Test Book',
                    'source' => $request->stripeToken
                ]);
        
            try {
                $stripe = Stripe::make('sk_test_30MMhfgvhxA7ySEVyoQN6nf9');
                $charge = $stripe->charges()->create([
                    'amount' => 20,
                    'currency' => 'CAD',
                    'source' => $request->stripeToken,
                    'description' => 'Description goes here',
                ]);
                dd($charge);
            } catch (Exception $e) {
                dd("ERROR");
            }
        */  

        $response = new \stdClass();
        try 
        {
            $data = $request->all();
        
            
            //customer id  = cus_test_dqaMxKOaPF75WgOr
            //card id = crd_test_MKpgmnUlcktnhQro
            //plan id = 
            
            $billing_info = DB::table('info_fact')->where('IdInfoFact',\Auth::user()->info_fact_id)->first();
            $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));

            // Creando Suscriptor a un plan
            $subscription_culqi = $culqi->Subscriptions->create(
                array(
                "card_id" => $billing_info->CardId,
                "plan_id" => $data['plan_id']//"pln_test_I1uj8UpurYGhzpeN"
                )
            );
            //Periodicidad 
            //1 - mensual
            //2 - anual
            $plan_culqi = DB::table('culqi_plan')->where('culqi_key',$data['plan_id'])->first();

            $subscription_galda = DB::table('subscription')->where('id_usu',\Auth::user()->id_usu)->first();

            DB::table('subscription')->where('id',$subscription_galda->id)
                                    ->update([
                                        'culqi_id' => $subscription_culqi->id,
                                        'culqi_plan'  => $data['plan_id'],
                                        'plan_id'=> $plan_culqi->id_plan,
                                        'id_periodicidad' =>$plan_culqi->id_periodicidad,
                                        'ends_at' => date("Y-m-d H:i:s", $subscription_culqi->next_billing_date/1000),
                                        'estado' => 1
                                    ]);
            
            DB::table('tm_usuario')->where('id_empresa',\Auth::user()->id_empresa)
                                   ->update([
                                        'plan_id'=>$plan_culqi->id_plan
                                   ]);

            self::registrarVentaGalda($billing_info,$plan_culqi);

            // dd($subscription_culqi,$subscription_culqi->next_billing_date,date("Y-m-d H:i:s ", $subscription_culqi->next_billing_date/1000));
            $response->cod = 1;
            $response->plan_id = $plan_culqi->id_plan;
            return json_encode($response);
        }
        catch(\Exception $e)
        {
            $response->cod = 0;
            $response->mensaje = $e->getMessage();
            return json_encode($response);
        }
    }

    public function paymentCompleted($id_plan)
    {
        $usuario = \Auth::user();

        $plan = DB::table('planes')->where('id',$id_plan)->first();
        $suscription = DB::table('subscription')->where('id_usu',$usuario->id_usu)->first();
        $precio = $plan->precio_mensual;
        $fecha_c = $suscription->ends_at;

        $this->sendEmailPayment($usuario,$precio,date('Y-m-d',strtotime($fecha_c)));

        auth()->logout();
        $data = [
            'plan' =>$plan
        ];
        return view('components.payment.completed_basic')->with($data);
    }

    public function sendEmailPayment($thisUser,$precio,$fecha_c)
    {
        //Obtener nombre del Recibo
        $galda_venta = DB::table('galda_venta')->orderBy('id_galda_venta', 'desc')
            ->where('id_usu',$thisUser->id_usu)->first();
        $path = $galda_venta->name_xml_file.'.pdf';
        $exist = Storage::disk('s3')->exists($path);

        $billing_info = DB::table('info_fact')->where('IdInfoFact',$thisUser->info_fact_id)->first();

        // $url = Storage::disk('s3')->url($path);
        // $pdf = Storage::disk('s3')->get($path);

        if(($exist)){
            Mail::to($billing_info->Email)->send(new invoiceBasic($thisUser,$path,$precio,$fecha_c));

        } else {
            dd('NO EXISTE');
        }
    }

    public function cancelar_subs(){

        //$culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));
        //$post = $request->all();
        $usuario = \Auth::user();
        //$sub_id = $post['cod_subs'];

        //$culqi->Subscriptions->delete("$sub_id");

        /*DB::table('subscription')->where('id_usu',$usuario->id_usu)
            ->update([
                'culqi_id'=> 'Cancelado',
                'ends_at'=> 'Cancelado',
            ]);
        */

        $suscription = DB::table('subscription')->where('id_usu',$usuario->id_usu)->first();
        $fecha_c = date('Y-m-d',strtotime($suscription->ends_at));

        $this->Basic_a_Free();
        Mail::to($usuario->email)->send(new cancelPlan($usuario,$fecha_c));

        return redirect('/perfil');
    }

    public function Basic_a_Free(){
        $usuario = \Auth::user();

        if($usuario->plan_id == 2){
            //Estado = 2, Plan cancelado
            DB::table('subscription')->where('id_usu',\Auth::user()->id_usu)->update(['estado'=>'2']);
            /*DB::table('tm_usuario')->where('id_usu',\Auth::user()->id_usu)->update(['plan_id'=>'1']);

            DB::table('subscription')->where('id_usu',\Auth::user()->id_usu)->update(['plan_id'=>'1']);

            //MODULO DE CAJAS
            //Actualizar a Inactivo las Cajas - Basic a Free
            $apc = DB::table('tm_caja')
                ->where('id_empresa','=',session('id_empresa'))
                ->where('plan_estado','2')
                ->get();

            foreach($apc as $r){
                $id_caja = $r->id_caja;
                $caja_ocupada = DB::table('tm_aper_cierre')->where('id_caja',$id_caja)->whereNull('fecha_cierre')->exists();

                if(!($caja_ocupada)) {
                    TmCaja::where('id_empresa',session('id_empresa'))
                        ->where('id_caja',$id_caja)
                        ->where('plan_estado','2')
                        ->update(['estado'=>'i']);
                }
            }

            //MODULO DE USUARIOS
            TmUsuario::where('id_empresa','=',session('id_empresa'))
                ->where('plan_estado','2')
                ->update(['estado'=>'i']);

            //MODULO DE SUCURSALES
            Sucursal::where('id_empresa','=',session('id_empresa'))
                ->where('plan_estado','2')
                ->update(['estado'=>'i']);

            //MODULO DE ALMACEN Y AREAS DE PRODUCCION
            TmAlmacen::where('id_empresa','=',session('id_empresa'))
                ->where('plan_estado','2')
                ->update(['estado'=>'i']);

            TmAreaProd::where('id_empresa','=',session('id_empresa'))
                ->where('plan_estado','2')
                ->update(['estado'=>'i']);

            //MODULO DE MESAS
            TmMesa::where('id_empresa','=',session('id_empresa'))
                ->where('plan_estado','2')
                ->update(['estado'=>'i']);

            auth()->logout();
            */
        }
    }

    public function registrarVentaGalda($billing_info,$plan_culqi)
    {
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

        $datos_galda = DB::table('galda_info')->where('id_galda_info',1)->first();
        $igv = $datos_galda->igv;

        // $arrayParam = array(
        //     1,//flag
        //     $data['tipo_pedido'], //tipo pedido
        //     $data['tipoEmision'], //tipo emision
        //     $data['cod_pedido'], //id pedido
        //     $data['cliente_id'], //id cliente
        //     $data['tipo_pago'], //tipo pago
        //     $data['tipo_doc'], //tipo doc
        //     $id_usu, //id _usu
        //     $id_apc,//Apc
        //     $data['pago_t'], // monto pago
        //     $data['m_desc'],//monto descuento
        //     $igv, //igv
        //     $data['total_pedido'], //total monto
        //     $fecha, //fecha emision
        //     //---
        //     '0101', //tipo operacion (tipo factura = venta interna)
        //     $fecha, //fecha vencimiento
        //     $comprobante->tipo_doc_codigo, //tipo doc = Factura
        //     'PEN', //moneda
        //     number_format($data['total_pedido']/(1+$igv), 2,".", ""), //MtoOperGravadas
        //     0, // MtoOperExoneradas
        //     number_format($data['total_pedido']/(1+$igv) *$igv, 2, ".", ""),//  MtoIGV
        //     number_format($data['total_pedido']/(1+$igv) *$igv, 2, ".", ""), //  TotalImpuestos
        //     number_format($data['total_pedido']/(1+$igv), 2, ".", ""), // MtoVenta
        //     number_format($data['total_pedido'],2, ".", ""), // total //falta guardar MtoImpVenta
        //     session('id_empresa'), //
        //     $comprobante->electronico, //factura electronicamente
        //     session('id_sucursal')
        // );

        $ahora = new \DateTime();
        $narray_comprobante = [
            'id_cliente_empresa' => \Auth::user()->id_empresa,
            // 'id_tipo_doc' , // Depende de si es factura o boleta, depende si es inter o naci
            'id_usu' => \Auth::user()->id_usu,
            // 'serie_doc' , // hacer el query para sacar el correlativo
            // 'nro_doc', // hacer el query para sacar el correlativo
            //'descuento', // No hay
            'igv' => $igv, // de $datos_galda
            'total' => $plan_culqi->precio, // del plan culqi
            'fecha_venta'=> $ahora , // fecha
            'estado' => 'prueba', // 'p' pagado
            // 'observacion',
            // 'tipo_operacion',// Depende de si internacional o nacional. SI es nacional 0101, si es inter 0200
            'fecha_vencimiento'=> $ahora , // fecha date(Y-m-d H:i:s) \DateTime::createFromFormat('Y-m-d H:i:s','2019-04-27 22:10:10')
            // 'tipo_doc' ,// Depende de si internacional entonces 01.  SI es nacional factura 01, boleta 03
            'tipo_moneda' => $plan_culqi->codigo_moneda, // USD deber�a sacarse de culqi plan
            // 'mto_oper_gravadas' , // Depende si es inter o nacional
            // 'mto_oper_exportacion', // 0.00
            // 'mto_oper_exoneradas', // 0.00
            // 'mto_igv', // number_format($data['total_pedido']/(1+$igv) *$igv, 2, ".", "")
            // 'total_impuestos', // number_format($data['total_pedido']/(1+$igv) *$igv, 2, ".", "")
            // 'valor_venta',// number_format($data['total_pedido']/(1+$igv), 2, ".", "")
            // 'mto_imp_venta', // total
            // 'id_empresa',
            'electronico'=>1, // 1
            // 'name_xml_file', // cuando se cree el xml
            // 'path_xml_file', // cuando se cree el xml
            // 'hash_xml_file', // cuando se cree el xml
            'id_estado_comprobante' => 1, // 1
            // 'mensaje_sunat',   // Cuando se cree el xml
            // 'nombre_cliente', // billing info depende si es para empresa o boleta
            // 'codigo_sunat', // Cuando se cree el xml y se obtenga la respuesta
            'id_estado_doc_resumen' => 1, // 1
            // 'id_ultimo_resumen', //
            // 'id_sucursal',
            'id_tipo_cliente' => $billing_info->EsEmpresarial,// Billing info
            // 'es_nacional' , // Billing info 1  si es PE,sino 0
            'id_galda_info' => $billing_info->IdInfoFact // del billing info
        ];



        $tip_afe_igv = '10';
        if($billing_info->CodigoPais == 'PE')
        {

            // ES NACIONAL
            $narray_comprobante['tipo_operacion']  = '0101';
            $tip_afe_igv = '10';
            $narray_comprobante['mto_oper_gravadas'] =number_format( $plan_culqi->precio/(1+$igv), 2, ".", "");
            $narray_comprobante['mto_oper_exportacion'] = 0.00;
            $narray_comprobante['mto_oper_exoneradas'] = 0.00;
            $narray_comprobante['mto_igv'] = number_format( ($plan_culqi->precio/(1+$igv))*$igv, 2, ".", "");
            $narray_comprobante['total_impuestos'] = number_format( ($plan_culqi->precio/(1+$igv))*$igv, 2, ".", "");
            $narray_comprobante['valor_venta'] = number_format( $plan_culqi->precio/(1+$igv), 2, ".", "");
            $narray_comprobante['mto_imp_venta'] = number_format( $plan_culqi->precio, 2, ".", "");

            $narray_comprobante['es_nacional'] = 1;
            if($billing_info->EsEmpresarial == 1)
            {
                // ES EMPRESA
                $narray_comprobante['id_tipo_doc' ] = 6; // 6 factura e
                $narray_comprobante['tipo_doc'] = '01';
            }
            else
            {
                // NO ES EMPRESA
                $narray_comprobante['id_tipo_doc' ] = 5; // 5 boleta e
                $narray_comprobante['tipo_doc'] = '03';
            }
        }
        else
        {
            $igv = 0.00;
            //ES INTERNACIONAL
            $narray_comprobante['tipo_doc'] = '01';
            $narray_comprobante['tipo_operacion']  = '0200';
            $narray_comprobante['id_tipo_doc'] = 6;
            $tip_afe_igv = '40';

            $narray_comprobante['mto_oper_gravadas'] = 0.00;
            $narray_comprobante['mto_oper_exportacion'] = number_format( $plan_culqi->precio, 2, ".", "");
            $narray_comprobante['mto_oper_exoneradas'] = 0.00;
            $narray_comprobante['mto_igv'] = number_format( ($plan_culqi->precio/(1+$igv))*$igv, 2, ".", "");
            $narray_comprobante['total_impuestos'] = number_format( ($plan_culqi->precio/(1+$igv))*$igv, 2, ".", "");
            $narray_comprobante['valor_venta'] = number_format( $plan_culqi->precio, 2, ".", "");
            $narray_comprobante['mto_imp_venta'] = number_format( $plan_culqi->precio, 2, ".", "");

            $narray_comprobante['es_nacional'] = 0;

            if($billing_info->EsEmpresarial == 1)
            {
                // ES EMPRESA
            }
            else
            {
                // NO ES EMPRESA

            }
        }
        // Hacer la serie y correlativo  solo los del estado prueba
        // $query = DB::table('galda_venta')->select(DB::raw("LPAD(count(galda_venta.id_galda_venta)+ifnull(galda_tipo_doc.correlativo,0),8,'0') correlativo,galda_tipo_doc.serie serie "))
        //     ->rightJoin('galda_tipo_doc','galda_tipo_doc.id_tipo_doc',DB::raw('?'))
        //     ->where('galda_venta.estado','?')
        //     ->where('galda_venta.id_tipo_doc','?')
        //     ->setBindings([$narray_comprobante['id_tipo_doc'],'prueba',$narray_comprobante['id_tipo_doc']])
        //     ->get()[0];

        $query_correlativo = DB::select("SELECT LPAD(count(gv.id_galda_venta)+ifnull(tp.correlativo,0 ),8,'0') correlativo 
        from galda_venta gv
        right join galda_tipo_doc tp on tp.id_tipo_doc = ?
        where gv.estado = ? and tp.id_tipo_doc = ? 
        ",[$narray_comprobante['id_tipo_doc'],'prueba',$narray_comprobante['id_tipo_doc']])[0];

        $query_serie = DB::table('galda_tipo_doc')->where('id_tipo_doc',$narray_comprobante['id_tipo_doc'])->first();
        
        $narray_comprobante['nro_doc'] = $query_correlativo->correlativo;
        $narray_comprobante['serie_doc'] =$query_serie->serie;

        // insertar en la bd
        $id_venta = DB::table('galda_venta')->insertGetId($narray_comprobante);

        // Crear table en la bd para la empresa LIMATON CORP (Ya esta )

        // GALDA INFOMRACION------------------------------------------------------------
        $address_galda = new Address();
        $address_galda->setUbigueo($datos_galda->ubigeo)
            ->setDepartamento($datos_galda->departamento)
            // ->setProvincia($datos_galda->provincia)
            ->setDistrito($datos_galda->distrito)
            ->setUrbanizacion($datos_galda->urbanizacion)
            ->setDireccion($datos_galda->direccion);
        // Obtener los datos de la empresa LIMATON de la table creada en la BD ( Ya esta )
        $company = new Company();
        $company->setRuc($datos_galda->ruc);
        $company->setRazonSocial($datos_galda->razon_social);
        $company->setNombreComercial($datos_galda->nombre_galda);//opcional
        $company->setAddress($address_galda);

        // ---------------------------------------------------------------------------

        // Cliente informacion ------------------------------------------------------------
        // Set empresa
        $address_cliente = new Address();
        $address_cliente
            // ->setUbigueo($datos_galda->ubigeo)
            // ->setDepartamento($datos_galda->departamento)
            // ->setProvincia($datos_gal_da->provincia)
            // ->setDistrito($datos_galda->distrito)
            // ->setUrbanizacion($datos_galda->urbanizacion)
            ->setDireccion($billing_info->Direccion);
        
        $cliente = new Client();
        if($narray_comprobante['es_nacional'] == 1)
        {
            if($billing_info->EsEmpresarial == 1)
            {
                $cliente->setTipoDoc('6');
                $cliente->setNumDoc($billing_info->Ruc);
                $cliente->setRznSocial($billing_info->RazonSocial);
            }
            else
            {
                $cliente->setTipoDoc('1');
                $cliente->setNumDoc('-');
                $cliente->setRznSocial($billing_info->Nombre.' '.$billing_info->Apellido);
            }
        }
        else 
        {   
            $cliente->setTipoDoc('0');
            $cliente->setNumDoc('-');
            $cliente->setRznSocial($billing_info->Nombre.' '.$billing_info->Apellido);
        }

        $cliente->setAddress($address_cliente);

        // ----------------------------------------------------------------------------------

        // Crear una tabla venta para las ventas de limaton
        // $venta = DB::table('galda_venta')->where('')
        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setFecVencimiento($ahora)
            ->setFechaEmision( $ahora )
            ->setTipoMoneda($plan_culqi->codigo_moneda)
            ->setClient($cliente)
            ->setMtoOperGravadas( $narray_comprobante['mto_oper_gravadas']) //total  / (1+igv)
            ->setMtoOperExportacion($narray_comprobante['mto_oper_exportacion'])
            ->setMtoIGV($narray_comprobante['mto_igv']) // (total  / (1+igv)) * 0.18
            ->setTotalImpuestos($narray_comprobante['total_impuestos']) // (total  / (1+igv)) * 0.18
            ->setValorVenta($narray_comprobante['valor_venta'] ) // total  / (1+igv)
            ->setMtoImpVenta($narray_comprobante['mto_imp_venta'] ) // total
            ->setCompany($company)
            ->setTipoOperacion( $narray_comprobante['tipo_operacion'] )
            ->setTipoDoc($narray_comprobante['tipo_doc'])
            ->setSerie($narray_comprobante['serie_doc'] )
            ->setCorrelativo($narray_comprobante['nro_doc'])
            ;
        // Crear una tabla detalle venta para los detalles de las ventas de limaton
        // $venta = DB::table('galda_detalle_venta')->where('')
        $detail = new SaleDetail();
        $detail->setCodProducto('LMCPBM')
            // ->setUnidad('ZZ')
            ->setDescripcion($plan_culqi->nombre_plan)
            ->setCantidad(1)
            ->setMtoValorUnitario($narray_comprobante['valor_venta']) // Si es exportacion
            ->setMtoValorVenta($narray_comprobante['valor_venta']) // Si es exportacion
            ->setMtoBaseIgv($narray_comprobante['valor_venta']) // Si es exportacion
            ->setPorcentajeIgv($igv*100) // Si es exportacion
            ->setIgv($narray_comprobante['mto_igv']) // Si es exportacion
            ->setTipAfeIgv($tip_afe_igv)
            ->setTotalImpuestos($narray_comprobante['total_impuestos']) // Si es exportacion
            ->setMtoPrecioUnitario($narray_comprobante['mto_imp_venta']); // Si es exportacion

        $util = Util::getInstance();
        $invoice->setDetails([$detail])
            ->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue( $util->numtoletras($narray_comprobante['mto_imp_venta'],$plan_culqi->codigo_moneda) )
            ]);
        if($narray_comprobante['es_nacional'] == 1 )
        {
            
            if($billing_info->EsEmpresarial == 1)
            {
                //Generar factura
            }
            else
            {

            }   
        }
        else
        {


        }
        self::generarComprobanteNacionalPdf($invoice,$id_venta,$cliente);
        $parameters_recibo =[
            'ahora' => $ahora,
            'nro_pedido' => $narray_comprobante['serie_doc'].'-'.$narray_comprobante['nro_doc']
        ];
        self::generarReciboPdf($billing_info,$plan_culqi,$parameters_recibo,$invoice);
        // $util->showPdf($pdf,'recibo.pdf');

        return;
    }

    public function generarReciboPdf($billing_info,$plan_culqi,$ahora,$invoice)
    {
        $util = Util::getInstance();
        $pdf = $util->generarReciboPdfGalda($billing_info,$plan_culqi,$ahora);
        //Guardar el Recibo
        $util->writeFileS3($invoice->getName().'.pdf',$pdf );
        // $util->showPdf($pdf,'filename.pdf');
    }

    public function generarComprobanteNacionalPdf($invoice,$id_venta,$cliente)
    {
        //Get pdf S3 or DISK
        $util = Util::getInstance();
        $pdf = $util->getPdf($invoice);
        $util->writeFileS3($invoice->getName().'.pdf',$pdf );

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
        DB::table('galda_venta')->where('id_galda_venta',$id_venta)->update([
                                    'name_xml_file' => $invoice->getName(),
                                    'path_xml_file' => $path,
                                    'hash_xml_file' => $hash,
                                    'nombre_cliente' => $cliente->getRznSocial(),
                                    'id_estado_comprobante' => 2
                                    ])
                                ;
    }
}
