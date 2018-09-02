<?php

namespace App\Http\Controllers\Application\Subscripcion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    //
    public function upgradeShow(){
        return view('auth.subscription');
    }

    public function upgrade(Request $request){

        $post = $request->all();
        //dd($post);

        // Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_30MMhfgvhxA7ySEVyoQN6nf9");

// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];
        //dd($token);
        $charge = \Stripe\Charge::create([
            'amount' => 15,
            'currency' => 'usd',
            'description' => 'Example charge',
            'source' => $token,
            'statement_descriptor' => 'Custom descriptor',
        ]);
        //dd($post,$charge);
    }
}
