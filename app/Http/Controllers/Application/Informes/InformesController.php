<?php

namespace App\Http\Controllers\Application\Informes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformesController extends Controller
{
    //
    public function index()
    {   
        $data = [
            'breadcrumb'=> 'informes'  
        ];

        return view('contents.application.informes.index')->with($data);
    }
}
