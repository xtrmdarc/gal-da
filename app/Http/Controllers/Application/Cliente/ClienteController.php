<?php

namespace App\Http\Controllers\Application\Cliente;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmCliente;
use App\Models\TmUsuario;
use App\Models\TmUsuarioDelivery;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
    }
    public function index(){

        $idEmpresa = \Auth::user()->id_empresa;

        $viewdata = [];

        $clientes = DB::select("call usp_clientes_g( :empresaID);",
            array(':empresaID' => $idEmpresa));

        $viewdata['breadcrumb'] = '';
        $data = [
            'clientes' => $clientes,
            'breadcrumb'=> 'clientes',
            'titulo_vista' => 'Clientes'
        ];

        return view('contents.application.cliente.cliente',$viewdata)->with($data);
    }

    public function index_e($id=null){

        

        $data= null;    
        $breadcrumb = 'ncliente';
        $data = [
            'breadcrumb' => $breadcrumb,
            'titulo_vista' => 'Nuevo cliente'
        ];
        if(isset($id)){
            
            $id_cliente = (DB::table('tm_cliente')->where('index_por_cuenta',$id)->where('id_empresa',\Auth::user()->id_empresa)->first())->id_cliente;

            $cliente = TmCliente::Where('id_cliente',$id_cliente)
                                ->first();
            $breadcrumb = 'ecliente';
            $data['cliente'] = $cliente;
            $data['breadcrumb'] = $breadcrumb;
            $data['titulo_vista'] = 'Editar Cliente';
            
        }

        return view('contents.application.cliente.cliente_e')->with($data);
    }

    public function RUCliente(Request $request){

        try{
            
            $response = new \stdClass();
            $idUsu = \Auth::user()->id_usu;
            $idRol = \Auth::user()->id_rol;
            
            $idEmpresa = \Auth::user()->id_empresa;

            $data = $request->all();
            if(isset($data['fecha_nac']))
                $fecha_nac = date('Y-m-d',strtotime($data['fecha_nac']));
            else $fecha_nac = '';

            if($data['id_cliente'] != ''){

                $arrayParam =  array(
                    'dni' => $data['dni'],
                    'ruc' => $data['ruc'],
                    'ape_paterno' => $data['ape_paterno'],
                    'ape_materno' => $data['ape_materno'],
                    'nombres' => $data['nombres'],
                    'razon_social' => $data['razon_social'],
                    'telefono' => $data['telefono'],
                    'fecha_nac' => $fecha_nac,
                    'correo' => $data['correo'],
                    'direccion' => $data['direccion'],
                    'es_empresa' => $data['tipo_cliente']==1?0:1
                );
                DB::table('tm_cliente')->where('id_cliente',$data['id_cliente'])
                        ->update($arrayParam);

                // $notification = [ 
                //     'message' =>'Cliente registrado, correctamente.',
                //     'alert-type' => 'success'
                // ];
                $response->code = 1;
                $response->message = 'Cliente modificado, correctamente';
                $response->alert_type = 'success';
                return json_encode($response);
            } else {

                $post = $request->all();

                $result = DB::select('SELECT count(*) as duplicado FROM tm_cliente WHERE id_empresa = ? AND ((dni = ? AND dni is not null AND dni != "" ) OR  (ruc = ? AND ruc is not null and ruc != ""))',[session('id_empresa'),$data['dni'],$data['ruc']])[0];
                if ($result->duplicado >0) {
                    $notification = [
                        'message' =>'Ya existe el Cliente con el mismo DNI o RUC',
                        'alert-type' => 'error'
                    ];
                    $response->code = 0;
                    $response->message = 'Ya existe el Cliente con el mismo DNI o RUC';
                    $response->alert_type = 'error';
                    return  json_encode($response);
                    // return redirect('/cliente')->with($notification);

                }
                // if($idRol == 1) {
                    
                $nuevo_cliente = DB::table('tm_cliente')->insertGetId([
                    'dni' => $post['dni'],
                    'ruc' => $post['ruc'],
                    'ape_paterno' => $post['ape_paterno'],
                    'ape_materno' => $post['ape_materno'],
                    'nombres' => $post['nombres'],
                    'razon_social' => $post['razon_social'],
                    'telefono' => $post['telefono'],
                    'fecha_nac' => $fecha_nac,
                    'correo' => $post['correo'],
                    'direccion' => $post['direccion'],
                    'id_usu' => $idUsu,
                    'id_empresa' => $idEmpresa,
                    'es_empresa' => $data['tipo_cliente']==1?0:1
                ]);
                // }else if($idRol == 2){
                   
                //         $nuevo_cliente = TmCliente::create([
                //             'dni' => $post['dni'],
                //             'ruc' => $post['ruc'],
                //             'ape_paterno' => $post['ape_paterno'],
                //             'ape_materno' => $post['ape_materno'],
                //             'nombres' => $post['nombres'],
                //             'razon_social' => $post['razon_social'],
                //             'telefono' => $post['telefono'],
                //             'fecha_nac' => $fecha_nac,
                //             'correo' => $post['correo'],
                //             'direccion' => $post['direccion'],
                //             'id_usu' => $idUsu,
                //             'id_empresa' => $idEmpresa,
                //         ]);
                  
                // }
                $notification = [ 
                    'message' =>'Cliente registrado, correctamente.',
                    'alert-type' => 'success'
                ];
                $response->code = 1;
                $response->message = 'Cliente registrado, correctamente';
                $response->alert_type = 'success';
                return json_encode($response);
                // return redirect('/cliente')->with($notification);
            }
        }
        catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function Estado(Request $request){
        echo('entra');
        try 
		{
            $data = $request->all();

            if ($data['estado']=='a' || $data['estado']=='i'){

                TmCliente::where('id_cliente',$data['cod_cliente'])
                        ->update(['estado'=>$data['estado']]);

                $notification = [ 
                    'message' =>'Datos modificados, correctamente.',
                    'alert-type' => 'success'
                ];
                return redirect('/cliente')->with($notification);

            }else{
                $notification = [ 
                    'message' =>'Se produjo un error.',
                    'alert-type' => 'warning'
                ];
                return redirect('/cliente')->with($notification);
            }

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
    }

    public function Eliminar(Request $request){

        try 
		{
            $data = $request->all();
            
            if(DB::table('tm_pedido_delivery')
                ->join('tm_pedido','tm_pedido.id_pedido','tm_pedido_delivery.id_pedido')
                ->where('tm_pedido_delivery.id_cliente',$data['cod_cliente_e'])->exists()) return json_encode(0);
            
            $cod_cliente_e = $data['cod_cliente_e'];
            $result = DB::select("SELECT count(*) AS total FROM tm_venta WHERE id_cliente = ?",[$cod_cliente_e])[0];

            if($result->total==0){

                TmCliente::where('id_cliente',$cod_cliente_e)->delete();

                return json_encode(1);

            }else{
                return json_encode(2);
            }
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
    }
}
