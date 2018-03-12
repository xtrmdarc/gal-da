<?php

namespace App\Http\Controllers\AreaProd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaProdController extends Controller
{
    //
    public function index(){
        return view('contents.areaprod.areaprod');
    }

    
}