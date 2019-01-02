<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpCenterController extends Controller
{
    public function primeros_pasos()
    {
        return view('contents.home.helpcenter.primeros_pasos');
    }
    public function manual_galda()
    {
        return view('contents.home.helpcenter.manual_galda');
    }
}
