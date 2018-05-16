<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SucursalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = [
            'breadcrumb' => 'config.Sucursal'
        ];
        return view('contents.application.config.sist.sucursal')->with($data);
    }
    public function ListaSucursales()
    {
        $id_usu = \Auth::user()->id_usu;
        $data = Sucursal::where('id_usu',$id_usu)->get();

        echo json_encode($data);
    }
    public function CrudSucursal(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $id_empresa = \Auth::user()->id_usu;
        $post = $request->all();

        $cod = $post['cod_sucursal'];
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
           /* //Create
            $flag = 1;
            $nombre = $post['nomb_caja'];
            $estado = $post['estado_caja'];
            //$consulta_create = DB::select('call usp_configCajas( :flag, :nombre, :estado, @a)',array($flag, $nombre, $estado));
            $consulta_create = DB::select('call usp_configCajas_g( :flag, :nombre, :estado, @a, :idUsu)',array($flag, $nombre, $estado, $id_usu));

            return redirect('/ajustesCaja');*/
            $new_sucursal = Sucursal::create([
                'id_empresa' => $id_empresa,
                'id_usu' => $id_usu,
                'nombre_sucursal' => $post['nomb_sucursal'],
                'direccion' => $post['direccion_sucursal'],
                'telefono' => $post['telefono_sucursal'],
                'moneda' => $post['moneda_sucursal'],
                'estado' => $post['estado_sucursal'],
            ]);

            return redirect('/ajustesSucursal');
        }
    }
}
