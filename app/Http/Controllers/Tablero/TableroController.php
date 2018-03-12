<?php

namespace App\Http\Controllers\Tablero;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableroController extends Controller
{
    //
    public function index(){

        $data = [];
        return view('contents.tablero.tm_tablero');
    }
}
