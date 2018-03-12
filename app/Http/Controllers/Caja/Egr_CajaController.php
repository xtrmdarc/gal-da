<?php

namespace App\Http\Controllers\Caja;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmTipoDoc;
use App\Models\TmUsuario;

class Egr_CajaController extends Controller
{
    //
    public function index(){
        
        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d");
        $gasto = DB::table('v_gastosadm')->whereDate('fecha_re',$fecha)
                                ->Where('id_usu',session('id_usu'))
                                ->get();
        $TDocumentos = TmTipoDoc::all();
        $personal = TmUsuario::all();
        $data = [

                'lista1'=> $gasto,
                'tdocumentos' => $TDocumentos,
                'personal' => $personal
                ];
        return view('contents.caja.egr_caja')->with($data);
    }

    

}
