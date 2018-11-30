<?php

namespace App\Http\Controllers\Application\Subscripcion;

use App\Models\TmUsuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Stripe;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\DB;
use Culqi;

class SubscriptionController extends Controller
{
    //
    public function upgradeShow(){
        return view('auth.subscription');
    }

    public function upgrade_plan($id){
        $plan = DB::table('planes')->where('id',$id);
        $data = [
            'plan'=> $plan
        ];
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
    */
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

    /*
        Stripe::setApiKey(config('services.stripe.secret'));

        $token = request('stripeToken');

        $charge = Charge::create([
            'amount' => 1000,
            'currency' => 'usd',
            'description' => 'Test Book',
            'source' => $token,
        ]);

        return 'Payment Success!';*/

    }

    public function checkout(Request $request){
    /*
            \Stripe\Stripe::setApiKey("sk_test_30MMhfgvhxA7ySEVyoQN6nf9");

            $charge = \Stripe\Charge::create([
                'amount' => 53,
                'currency' => 'usd',
                'description' => 'Test Book',
                'source' => $request->stripeToken
            ]);
    */
    /*
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
        $data = $request->all();
        $SECRET_KEY = "sk_test_asQalOKDq7la1gKr";
        $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));
        //customer id  = cus_test_dqaMxKOaPF75WgOr
        //card id = crd_test_MKpgmnUlcktnhQro
        //plan id = 
     
        $card = $culqi->Cards->create(
            array(
              "customer_id" => "cus_test_dqaMxKOaPF75WgOr",
              "token_id" => $data['token']
            )
        );

        // Creando Suscriptor a un plan
        $subscription = $culqi->Subscriptions->create(
            array(
            "card_id" => "crd_test_MKpgmnUlcktnhQro",
            "plan_id" => "pln_test_I1uj8UpurYGhzpeN"
            )
        );
        
        //Respuesta
        dd($subscription);
    }
}
