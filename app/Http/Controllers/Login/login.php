<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmCaja;

class login extends Controller
{
    //

    public function index(){
      
      return view('Login.login')->with('cajas', TmCaja::all());

    }
}
