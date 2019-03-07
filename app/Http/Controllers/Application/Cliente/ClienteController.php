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
            
            $idUsu = \Auth::user()->id_usu;
            $idRol = \Auth::user()->id_rol;
            
            $idEmpresa = \Auth::user()->id_empresa;

            $data = $request->all();
            //$fecha_nac = date('Y-m-d',strtotime($data['fecha_nac']));
            $fecha_nac = '';

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
                    'direccion' => $data['direccion']
                );
                TmCliente::where('id_cliente',$data['id_cliente'])
                        ->update($arrayParam);

                $notification = [ 
                    'message' =>'Datos modificados, correctamente.',
                    'alert-type' => 'success'
                ];
               return redirect('/cliente')->with($notification);
            } else {

                $post = $request->all();

                if($idRol == 1) {

                    if (TmCliente::where('id_empresa', session('id_empresa'))
                        ->where('dni',$post['dni'])->exists()) {
                        $notification = [
                            'message' =>'Ya existe el Cliente con el mismo Dni',
                            'alert-type' => 'error'
                        ];
                        return redirect('/cliente')->with($notification);
                    }
                    else {
                        $nuevo_cliente = TmCliente::create([
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
                        ]);
                    }
                }else if($idRol == 2){
                    if (TmCliente::where('id_empresa', session('id_empresa'))
                        ->where('dni',$post['dni'])->exists()) {
                        $notification = [
                            'message' =>'Ya existe el Cliente con el mismo Dni',
                            'alert-type' => 'error'
                        ];
                        return redirect('/cliente')->with($notification);
                    }
                    else {
                        $nuevo_cliente = TmCliente::create([
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
                        ]);
                    }
                }
                $notification = [ 
                    'message' =>'Cliente registrado, correctamente.',
                    'alert-type' => 'success'
                ];
                return redirect('/cliente')->with($notification);
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
