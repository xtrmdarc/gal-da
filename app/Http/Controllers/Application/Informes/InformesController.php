<?php

namespace App\Http\Controllers\Application\Informes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
        $this->middleware('userRol');
    }
    public function index()
    {   
        $data = [
            'breadcrumb'=> 'informes'  ,
            'titulo_vista' => 'Informes'
        ];

        return view('contents.application.informes.index')->with($data);
    }
}
