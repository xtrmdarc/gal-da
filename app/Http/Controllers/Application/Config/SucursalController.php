<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SucursalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
    }
    public function index()
    {
        $numero_sucursales = DB::table('empresa')
        ->leftjoin('sucursal', 'empresa.id', '=', 'sucursal.id_empresa')
        ->where('empresa.id',session('id_empresa'))->count();
        $sesion_plan = session('plan_actual');

        $data = [
            'breadcrumb' => 'config.Sucursal',
            'titulo_vista' => 'Sucursales',
            'numero_sucursales' => $numero_sucursales
        ];
        if(is_null($sesion_plan)){
            return view('contents.application.config.cargar_sesiones');
        }
        else {
            return view('contents.application.config.sist.sucursal')->with($data);
        }
    }
    public function ListaSucursales()
    {
        /*Sucursales*/
        $sucursales = DB::table('v_sucursal')
            ->where('id_empresa',session('id_empresa'))
            ->get();

        echo json_encode($sucursales);
    }
    public function CrudSucursal(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $id_empresa = \Auth::user()->id_empresa;
        $planId_admin = \Auth::user()->plan_id;

        $post = $request->all();
        $response = new \stdClass();
        $cod = $post['cod_sucursal'];
        if($cod != ''){
            //Update
            $nombre_sucursal = $post['nomb_sucursal'];
            $direccion = $post['direccion_sucursal'];
            $telefono = $post['telefono_sucursal'];
            $estado = $post['estado_sucursal'];

            $sql = DB::update("UPDATE sucursal SET
                    nombre_sucursal  = ?,
                    direccion   = ?,
                    telefono   = ?,
                    estado = ?
                WHERE id = ? and id_empresa = ?",
                [$nombre_sucursal,$direccion,$telefono,$estado,$cod,$id_empresa]);
            if(empty($new_sucursal)) {
                $response->cod = 2;
                
            }else {
                $response->cod = 0;
            }
        }else {
           //Create

            if($planId_admin == 1) {
                $plan_estado = '1';
            }else {
                $plan_estado = '2';
            }

            $new_sucursal = Sucursal::create([
                'id_empresa' => $id_empresa,
                'id_usu' => $id_usu,
                'nombre_sucursal' => $post['nomb_sucursal'],
                'direccion' => $post['direccion_sucursal'],
                'telefono' => $post['telefono_sucursal'],
                'moneda' => $post['moneda_sucursal'],
                'estado' => $post['estado_sucursal'],
                'plan_estado' => $plan_estado,
            ]);

            if(!empty($new_sucursal)) {
                $response->cod = 1;
                
            }else {
                $response->cod = 0;
            }
        }

        $response->cant_sucursal = DB::table('empresa')
        ->leftjoin('sucursal', 'empresa.id', '=', 'sucursal.id_empresa')
        ->where('empresa.id',session('id_empresa'))->count();

        return json_encode($response);
    }
}
