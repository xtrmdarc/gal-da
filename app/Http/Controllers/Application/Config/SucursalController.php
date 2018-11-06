<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SucursalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $data = [
            'breadcrumb' => 'config.Sucursal',
            'titulo_vista' => 'Sucursales'
        ];
        return view('contents.application.config.sist.sucursal')->with($data);
    }
    public function ListaSucursales()
    {
        $id_usu = \Auth::user()->id_usu;
        /*Sucursales*/
        $sucursales = DB::table('empresa')
            ->leftjoin('sucursal', 'empresa.id', '=', 'sucursal.id_empresa')
            ->select('sucursal.id','sucursal.id_empresa','sucursal.nombre_sucursal','sucursal.id_usu','sucursal.direccion','sucursal.estado','sucursal.moneda','sucursal.telefono')
            ->where('empresa.id',session('id_empresa'))
            ->get();
        echo json_encode($sucursales);
    }
    public function CrudSucursal(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $id_empresa = \Auth::user()->id_empresa;
        $post = $request->all();

        $cod = $post['cod_sucursal'];
        if($cod != ''){
            //Update
            $nombre_sucursal = $post['nomb_sucursal'];
            $direccion = $post['direccion_sucursal'];
            $telefono = $post['telefono_sucursal'];
            $moneda = $post['moneda_sucursal'];
            $estado = $post['estado_sucursal'];

            $sql = DB::update("UPDATE sucursal SET
                    nombre_sucursal  = ?,
                    direccion   = ?,
                    telefono   = ?,
                    moneda  = ?,
                    estado = ?
                WHERE id = ? and id_empresa = ?",
                [$nombre_sucursal,$direccion,$telefono,$moneda,$estado,$cod,$id_empresa]);
            if(empty($new_sucursal)) {
                return $array['cod'] = 2;
            }else {
                return $array['cod'] = 0;
            }
        }else {
           //Create

            $new_sucursal = Sucursal::create([
                'id_empresa' => $id_empresa,
                'id_usu' => $id_usu,
                'nombre_sucursal' => $post['nomb_sucursal'],
                'direccion' => $post['direccion_sucursal'],
                'telefono' => $post['telefono_sucursal'],
                'moneda' => $post['moneda_sucursal'],
                'estado' => $post['estado_sucursal'],
            ]);

            if(!empty($new_sucursal)) {
                return $array['cod'] = 1;
            }else {
                return $array['cod'] = 0;
            }
        }
    }
}
