<?php

namespace App\Http\Controllers\Informes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class tm_informesController extends Controller
{
    //
    public function index()
    {
        return view('contents.informes.index');
    }

}
