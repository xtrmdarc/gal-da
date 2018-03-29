<?php

namespace App\Http\Controllers\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TmCaja;

class tm_cajaController extends Controller
{
    public function index()
    {
        return view('contents.config.rest.tm_caja');
    }

    public function ListaCajas()
    {
        $data = TmCaja::all();
        echo json_encode($data);
    }

    public function CrudCaja(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod_caja'];
        if($cod != ''){
            //Update
            $flag = 2;
            $nombre = $post['nomb_caja'];
            $estado = $post['estado_caja'];
            $idCaja = $post['cod_caja'];
            $consulta_update = DB::select('call usp_configCajas( :flag, :nombre, :estado, :idCaja)',array($flag, $nombre, $estado,$idCaja));
            return $consulta_update;
        }else {
            //Create
            $flag = 1;
            $nombre = $post['nomb_caja'];
            $estado = $post['estado_caja'];
            $consulta_create = DB::select('call usp_configCajas( :flag, :nombre, :estado, @a)',array($flag, $nombre, $estado));
            return $consulta_create;
        }
    }
}
