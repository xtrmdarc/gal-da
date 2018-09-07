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
    //
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
            'breadcrumb'=> 'clientes'
        ];

        return view('contents.application.cliente.cliente',$viewdata)->with($data);
    }

    public function index_e($id=null){

        $data= null;    
        $breadcrumb = 'ncliente';
        $data = [
            'breadcrumb' => $breadcrumb
        ];
        if(isset($id)){
            $cliente = TmCliente::Where('id_cliente',$id)
                                ->first();
            $breadcrumb = 'ecliente';
            $data['cliente'] = $cliente;
            $data['breadcrumb'] = $breadcrumb;
            /*$data= [
                'cliente' => $cliente,
                'breadcrumb'=> $breadcrumb
            ];*/
        }


        //dd($cliente);
        return view('contents.application.cliente.cliente_e')->with($data);
    }

    public function RUCliente(Request $request){

        try{
            
            $idUsu = \Auth::user()->id_usu;
            $idRol = \Auth::user()->id_rol;
            
            $idEmpresa = \Auth::user()->id_empresa;

            $data = $request->all();
            $fecha_nac = date('Y-m-d',strtotime($data['fecha_nac']));

            if($data['id_cliente'] != ''){
                
                //$this->model->Actualizar($alm);
                
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


                //DB::select("call usp_restRegCliente_g( :flag, :dni, :ruc, :apeP, :apeM, :nomb, :razS, :telf, :fecN, :correo, :direc, :idCliente)",$arrayParam);
                //$consulta = "call usp_restRegCliente( :flag, :dni, :ruc, :apeP, :apeM, :nomb, :razS, :telf, :fecN, :correo, :direc, :idCliente);";
                
                /*$st = $this->conexionn->prepare($consulta);
                $st->execute($arrayParam);*/
                
                //header('Location: lista_tm_clientes.php?m=u');
                $notification = [ 
                    'message' =>'Datos modificados, correctamente.',
                    'alert-type' => 'success'
                ];
               return redirect('/cliente')->with($notification);
            } else {

                //$row = $this->model->Registrar($alm);

                $post = $request->all();

                if($idRol == 1) {
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
                    
                }else if($idRol == 2){
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
                $notification = [ 
                    'message' =>'Cliente registrado, correctamente.',
                    'alert-type' => 'success'
                ];
                return redirect('/cliente')->with($notification);
/*
                $arrayParam =  array(
                    ':flag' => 1,
                    ':dni' => $data['dni'],
                    ':ruc' => $data['ruc'],
                    ':apeP' => $data['ape_paterno'],
                    ':apeM' => $data['ape_materno'],
                    ':nomb' => $data['nombres'],
                    ':razS' => $data['razon_social'],
                    ':telf' => $data['telefono'],
                    ':fecN' => $fecha_nac,
                    ':correo' => $data['correo'],
                    ':direc' => $data['direccion']
                );
                $row = DB::select("call usp_restRegCliente( :flag, :dni, :ruc, :apeP, :apeM, :nomb, :razS, :telf, :fecN, :correo, :direc, @a)",$arrayParam)[0];

                if ($row->dup == 1){
                    //header('Location: lista_tm_clientes.php?m=d');
                   return redirect('/cliente');
                } else {
                   return redirect('/cliente?m=n');
                }*/

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
            //$alm = new Cliente();
            if ($data['estado']=='a' || $data['estado']=='i'){
                
                /*$alm->__SET('cod_cliente',  $_REQUEST['cod_cliente']);
                $alm->__SET('estado',     $_REQUEST['estado']);
                $this->model->Estado($alm);*/
                //"UPDATE tm_cliente SET estado = ? WHERE id_cliente = ?";
                TmCliente::where('id_cliente',$data['cod_cliente'])
                        ->update(['estado'=>$data['estado']]);

                //echo('hizo el cambio  a '. $data['estado'] . ' codcli ' .$data['cod_cliente']);
                /*$this->conexionn->prepare($sql)
                     ->execute(array($data->__GET('estado'),$data->__GET('cod_cliente')));*/
                //$this->conexionn=null;
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
            //$result = $this->conexionn->prepare($consulta);
            //$result->bindParam(':id_cliente',$cod_cliente_e,PDO::PARAM_INT);
            //$result->execute();
            if($result->total==0){
                    
                /*$stm = $this->conexionn->prepare("DELETE FROM tm_cliente WHERE id_cliente = ?");          
                $stm->execute(array($cod_cliente_e));*/
                TmCliente::where('id_cliente',$cod_cliente_e)->delete();

                //header('Location: lista_tm_clientes.php');
                return json_encode(1);

            }else{
                return json_encode(2);
            }
            /*$result->closeCursor();
            $this->conexionn=null;*/
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
        //$this->model->Eliminar($_REQUEST['cod_cliente_e']);
    }

}
