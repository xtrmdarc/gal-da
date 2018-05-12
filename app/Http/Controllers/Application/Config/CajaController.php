<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TmCaja;

class CajaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=> 'config.Cajas'  
        ];
        return view('contents.application.config.rest.caja')->with($data);
    }

    public function ListaCajas()
    {
        $id_usu = \Auth::user()->id_usu;
        $data = TmCaja::where('id_usu',$id_usu)->get();
        echo json_encode($data);
    }

    public function CrudCaja(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();

        $cod = $post['cod_caja'];
        if($cod != ''){
            //Update
            $flag = 2;
            $nombre = $post['nomb_caja'];
            $estado = $post['estado_caja'];
            $idCaja = $post['cod_caja'];
            //$consulta_update = DB::select('call usp_configCajas( :flag, :nombre, :estado, :idCaja)',array($flag, $nombre, $estado,$idCaja));
            $consulta_update = DB::select('call usp_configCajas_g( :flag, :nombre, :estado, :idCaja, :idUsu)',array($flag, $nombre, $estado,$idCaja,$id_usu));
            return redirect('/ajustesCaja');
        }else {
            //Create
            $flag = 1;
            $nombre = $post['nomb_caja'];
            $estado = $post['estado_caja'];
            //$consulta_create = DB::select('call usp_configCajas( :flag, :nombre, :estado, @a)',array($flag, $nombre, $estado));
            $consulta_create = DB::select('call usp_configCajas_g( :flag, :nombre, :estado, @a, :idUsu)',array($flag, $nombre, $estado, $id_usu));

            return redirect('/ajustesCaja');
        }
    }
}
