<?php

namespace App\Http\Controllers\Caja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmIngresosAdm;
class Ing_CajaController extends Controller
{
    //
    public function index(){

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d");
        $lista1 = TmIngresosAdm::WhereDate('fecha_reg',$fecha)
                                ->Where('id_usu',session('id_usu'))
                                ->get();
        

        $data = [
            'lista1' => $lista1
        ];

        return view('contents.caja.ing_caja')->with($data);
    }

    
}
