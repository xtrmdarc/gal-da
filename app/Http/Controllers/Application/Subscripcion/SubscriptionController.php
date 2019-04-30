<?php

namespace App\Http\Controllers\Application\Subscripcion;

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


class SubscriptionController extends Controller
{
    private $SECRET_KEY = "sk_test_asQalOKDq7la1gKr";
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
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

            $subscription_id = DB::table('subscription')->where('id_usu',\Auth::user()->id_usu)->first()->id;

            DB::table('subscription')->where('id',$subscription_id)
                                    ->update([
                                        'culqi_id' => $subscription_culqi->id,
                                        'culqi_plan'  => $data['plan_id'],
                                        'plan_id'=> $plan_culqi->id_plan,
                                        'id_periodicidad' =>$plan_culqi->id_periodicidad,
                                        'ends_at' => date("Y-m-d H:i:s", $subscription_culqi->next_billing_date/1000)
                                    ]);
            
            DB::table('tm_usuario')->where('id_empresa',\Auth::user()->id_empresa)
                                   ->update([
                                        'plan_id'=>$plan_culqi->id_plan
                                   ]);
            // dd($subscription_culqi,$subscription_culqi->next_billing_date,date("Y-m-d H:i:s ", $subscription_culqi->next_billing_date/1000));
            $response->cod = 1;
            $response->plan_id = $plan_culqi->id_plan;
            return json_encode($response);
        }
        catch(\Exception $e)
        {
            $response->cod = 0;
            return json_encode($response);
        }
    }

    public function paymentCompleted($id_plan)
    {   
        $plan = DB::table('planes')->where('id',$id_plan);
        auth()->logout();
        $data = [
            'plan' =>$plan
        ];
        return view('components.payment.completed_basic')->with($data);
    }

    public function cancelar_subs(Request $request){

        $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));
        $post = $request->all();
        $usuario = \Auth::user();
        $sub_id = $post['cod_subs'];

        $culqi->Subscriptions->delete("$sub_id");

        DB::table('subscription')->where('id_usu',$usuario->id_usu)
            ->update([
                'culqi_id'=> 'Cancelado',
                'ends_at'=> 'Cancelado',
            ]);

        $this->Basic_a_Free();
        return redirect('/');
    }

    public function Basic_a_Free(){
        $usuario = \Auth::user();

        if($usuario->plan_id == 2){
            DB::table('tm_usuario')->where('id_usu',\Auth::user()->id_usu)->update(['plan_id'=>'1']);

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
        }
    }
}
