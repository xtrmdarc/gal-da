<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        \App::setLocale('es');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome_main()
    {
        //$user = WebAuth::getLoggedInUser();

        return view('contents.home.welcome_main');
    }

    public function prices()
    {
        return view('contents.home.prices');
    }


}
