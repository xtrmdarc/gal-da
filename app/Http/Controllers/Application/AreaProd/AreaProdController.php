<?php

namespace App\Http\Controllers\Application\AreaProd;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\PedidoRegistrado;
use App\Models\TmPedido;
use App\Models\TmDetallePedido;
use App\Models\TmTipoPedido;

class AreaProdController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        
        //falta area produccion
        $ordenes = DB::table('tm_pedido')
                            ->select(DB::raw('distinct tm_pedido.id_pedido'))
                            ->join('tm_detalle_pedido','tm_detalle_pedido.id_pedido','tm_pedido.id_pedido')
                            ->join('tm_producto','tm_producto.id_prod','tm_detalle_pedido.id_prod')
                            ->where('tm_pedido.id_sucursal',session('id_sucursal'))
                            ->where('tm_pedido.estado','a')
                            ->where('tm_producto.id_areap',session('id_areap'))  
                            ->get();

        
        $ordenes->transform(function($i) {
            return (array)$i;
        });

        $ordenes = $ordenes->toArray();
        /*for($i = 0 ; $i< count($ordenes);$i++)
        {
            $ordenesArr[i] = 
        }*/

        $productosRegistrados = [];
        $areasProd = [];
        foreach($ordenes as $k => $v)
        {   
            
            $ordenes[$k]['pedido'] = TmPedido::where('id_pedido',$v['id_pedido'])->first();
            //Nombre pedido (delivery,Mostrador o Mesa)
            $nombrePedidoDB = DB::select('call usp_nombrePedido (?)',[$v['id_pedido']])[0];
            $nombrePedido = '';
            if(isset($nombrePedidoDB)) $nombrePedido = $nombrePedidoDB->nombre;
            $ordenes[$k]['pedido']['nombre']  = $nombrePedido;
            $tipoPedido = TmTipoPedido::where('id_tipo_pedido',$ordenes[$k]['pedido']['id_tipo_pedido'])->first()->descripcion; 

            $ordenes[$k]['items'] = TmDetallePedido::where('id_pedido',$v['id_pedido'])
                                    ->where('estado','<>','i')
                                    ->get()->toArray();
            
            for($i = 0 ; $i< count($ordenes[$k]['items']) ;$i++ )
            {
                $producto = DB::select("SELECT * FROM v_productos WHERE id_pres = ? AND id_areap",[$ordenes[$k]['items'][$i]['id_prod']])[0];  
                $ordenes[$k]['items'][$i]['nombre_prod'] = $producto->nombre_prod;
                $ordenes[$k]['items'][$i]['id_areap'] = $producto->id_areap;
                $ordenes[$k]['items'][$i]['fecha']  = $ordenes[$k]['items'][$i]['fecha_pedido'];
                $ordenes[$k]['items'][$i]['nombre_usuario'] = $nombrePedido;
                $ordenes[$k]['items'][$i]['tipo_usuario'] = $tipoPedido;
                $productosRegistrados[] = $producto;
            }
        }
               
        //
        $id_sucursal = session('id_sucursal');
        $id_areap = session('id_areap');
        
        $data = [
            'breadcrumb' => '',
            'ordenes'=> $ordenes,
            'id_sucursal' => $id_sucursal,
            'id_areap' => $id_areap,
            'vl_pedidos'=>$this->PedidosLista(new Request())
        ];

        return view('contents.application.areaprod.areaprod')->with($data);
    }


    public function PedidosLista(Request $request){

        $data = $request->all();
        //dd($data);
        //mozo
        //estados
        $estados;
        //$estado = $data['estados'];

        //Tipo de pedido
        //H-inicio
        //H-fin
        //
        if(isset($data['estados']))$estados = $data['estados'];else $estados = array('a','i','p','c');
        
        $pedidos =  DB::table('tm_pedido')
                    ->select(DB::raw('tm_detalle_pedido.id_det_ped, tm_detalle_pedido.cantidad,tm_producto.nombre as nombre_prod,tm_detalle_pedido.estado,tm_detalle_pedido.fecha_pedido as fecha,tm_pedido.id_tipo_pedido,tm_pedido.id_pedido'))
                    ->join('tm_detalle_pedido','tm_detalle_pedido.id_pedido','tm_pedido.id_pedido')
                    ->join('tm_producto','tm_producto.id_prod','tm_detalle_pedido.id_prod')
                    ->where('tm_pedido.id_sucursal',session('id_sucursal'))
                    ->where('tm_producto.id_areap',session('id_areap'))  
                    ->WhereIn('tm_detalle_pedido.estado',$estados)
                    ->get();
    
        foreach($pedidos as $k){

            $nombrePedidoDB = DB::select('call usp_nombrePedido (?)',[$k->id_pedido])[0];
            $nombrePedido = '';
            if(isset($nombrePedidoDB)) $nombrePedido = $nombrePedidoDB->nombre;
            
            $tipoPedido = TmTipoPedido::where('id_tipo_pedido',$k->id_tipo_pedido)->first()->descripcion; 

            $k->nombre_usuario = $nombrePedido;
            $k->tipo_usuario = $tipoPedido;
        }

        return $pedidos;

    }

    public function ListarM(){
        
        try
        {   
            $id_areap = session('id_areap');
            $id_sucursal = session('id_sucursal');
            $c = DB::select("SELECT * FROM v_cocina_me WHERE id_areap = ? AND id_sucursal = ? AND cantidad > 0 ORDER BY fecha_pedido ASC",[$id_areap,$id_sucursal]);
            
            foreach($c as $k => $d)
            {   

                $c[$k]->Total = DB::select("SELECT COUNT(id_pedido) AS nro_p FROM v_cocina_me WHERE cantidad > 0 AND id_areap = ? AND id_sucursal = ?",[$id_areap,$id_sucursal])[0];
                
                $c[$k]->CProducto = DB::select("SELECT desc_c FROM v_productos WHERE id_pres =  ? ",[$d->id_prod])[0];
            }
            //dd($c);
            return json_encode($c);
            
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ListarMO(){
        try
        {
            $id_areap = session('id_areap');
            $id_sucursal = session('id_sucursal');
            $c = DB::select("SELECT * FROM v_cocina_mo WHERE id_areap = ? AND id_sucursal = ? ORDER BY fecha_pedido ASC",[$id_areap,$id_sucursal]);
            
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT COUNT(id_pedido) AS nro_p FROM v_cocina_mo WHERE estado <> 'c' AND estado <> 'i' AND id_areap = ? AND id_sucursal= ? ",[$id_areap,$id_sucursal])[0];
                    

                $c[$k]->CProducto = DB::select("SELECT desc_c FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
                    
            }
            
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ListarDE(){
        try
        {        
            $id_areap = session('id_areap');
            $id_sucursal = session('id_sucursal');
            //$id_areap= 1;
            $c = DB::select("SELECT * FROM v_cocina_de WHERE id_areap = ? AND id_sucursal = ? ORDER BY fecha_pedido ASC",[$id_areap,$id_sucursal]);
           
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT COUNT(id_pedido) AS nro_p FROM v_cocina_de WHERE estado <> 'c' AND estado <> 'i' AND id_areap = ? AND id_sucursal = ? ",[$id_areap,$id_sucursal])[0];
                    

                $c[$k]->CProducto = DB::select("SELECT desc_c FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
                    
            }
            
            return json_encode($c);
            
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

    }

    public function Preparacion(Request $request){

        try
        {   
            $data = $request->all();
            date_default_timezone_set('America/Lima');
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            
            //$sql = "UPDATE tm_detalle_pedido SET estado = 'p', fecha_envio = ? WHERE id_pedido = ? AND id_prod = ? AND fecha_pedido = ?";
            $val = DB::table('tm_detalle_pedido')   -> where(['id_pedido'=>$data['cod_ped'],'id_det_ped'=> $data['cod_det_ped']])
                                                    -> where('estado','a')
                                                    ->update(['estado'=>'p','fecha_envio'=>$fecha]);


            if($val == 0){
            DB::table('tm_detalle_pedido')  -> where(['id_pedido'=>$data['cod_ped'],'id_det_ped'=> $data['cod_det_ped']])
                                            -> where('estado','p')
                                            ->update(['estado'=>'a','fecha_envio'=>$fecha]);
            }

            /* $this->conexionn->prepare($sql)
              ->execute(array(
                $fecha,
                $data['cod_ped'],
                $data['cod_prod'],
                $data['fecha_p']
                 ));*/
            return json_encode($val);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        //print_r(json_encode($this->model->Preparacion($_POST)));

    }

    public function Atendido(Request $request){

        $data = $request->all();
        try 
        {   
            
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            

            //$sql = "UPDATE tm_detalle_pedido SET estado = 'p', fecha_envio = ? WHERE id_pedido = ? AND id_prod = ? AND fecha_pedido = ?";
            DB::table('tm_detalle_pedido')  -> where(['id_pedido'=>$data['cod_ped'],'id_det_ped'=> $data['cod_det_ped']])
                                            ->update(['estado'=>'c','fecha_envio'=>$fecha]);
/*            $this->conexionn->prepare($sql)
              ->execute(array(
                $fecha,
                $data['cod_ped'],
                $data['cod_prod'],
                $data['fecha_p']
                 ));*/

            return json_encode(1);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

}
