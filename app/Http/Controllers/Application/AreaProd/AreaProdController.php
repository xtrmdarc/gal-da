<?php

namespace App\Http\Controllers\Application\AreaProd;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\PedidoRegistrado;
use App\Events\PedidoListo;
use App\Models\TmPedido;
use App\Models\TmDetallePedido;
use App\Models\TmTipoPedido;
use App\Models\TmAreaProd;

class AreaProdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index(){

        $id_sucursal = session('id_sucursal');
        $id_areap = \Auth::user()->id_areap;

        if(\Auth::user()->id_rol == 1)
        {
            $areas_prod = TmAreaProd::where('id_sucursal',$id_sucursal)->get();
            
            $id_areap =  $areas_prod[0]->id_areap;
        }

        $ordenes = $this->GetOrdenes($id_sucursal,$id_areap);

        $data = [
            'breadcrumb' => '',
            'vista_amplia' => true,
            'ordenes'=> $ordenes,
            'id_sucursal' => $id_sucursal,
            'id_areap' => $id_areap,
            'vl_pedidos'=> $this->GetPedidosLista($id_sucursal,$id_areap,null)
        ];
      
        if(\Auth::user()->id_rol == 1)
        {
            $data['areas_prod'] = $areas_prod;
        }

        return view('contents.application.areaprod.areaprod')->with($data);
    }
    
    public function CocinaData(Request $request)
    {
        $data = $request->all();
        
        $ordenes = $this->GetOrdenes($data['id_sucursal'],$data['id_areap']);
        $lista = $this->GetPedidosLista($data['id_sucursal'],$data['id_areap'],null);

        $data=  [
            'ordenes' => $ordenes,
            'lista' => $lista
        ];

        return json_encode($data);
    }

    public function GetOrdenes($id_sucursal,$id_areap){ 

        $ordenes = DB::table('tm_pedido')
                            ->select(DB::raw('distinct tm_pedido.id_pedido'))
                            ->join('tm_detalle_pedido','tm_detalle_pedido.id_pedido','tm_pedido.id_pedido')
                            ->join('tm_producto_pres','tm_producto_pres.id_pres','tm_detalle_pedido.id_prod')
                            ->join('tm_producto','tm_producto.id_prod','tm_producto_pres.id_prod')
                            ->where('tm_pedido.id_sucursal',$id_sucursal)
                            ->where('tm_pedido.estado','a')
                            ->where('tm_producto.id_areap',$id_areap)  
                            ->get();

                           // dd($id_sucursal,$id_areap);
        $ordenes->transform(function($i) {
            return (array)$i;
        });

        $ordenes = $ordenes->toArray();

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
                //$productosRegistrados[] = $producto;
            }
        }

        return $ordenes;

    }

    public function GetPedidosLista($id_sucursal,$id_areap,$estados)
    {
        if(!isset($estados)) $estados = array('a','i','p','c');
        
        $pedidos =  DB::table('tm_pedido')
                    ->select(DB::raw('tm_detalle_pedido.id_det_ped, tm_detalle_pedido.cantidad,v_productos.nombre_prod as nombre_prod,tm_detalle_pedido.estado,tm_detalle_pedido.fecha_pedido as fecha,tm_pedido.id_tipo_pedido,tm_pedido.id_pedido'))
                    ->join('tm_detalle_pedido','tm_detalle_pedido.id_pedido','tm_pedido.id_pedido')
                    ->join('v_productos','v_productos.id_pres','tm_detalle_pedido.id_prod')
                    ->where('tm_pedido.id_sucursal',$id_sucursal)
                    ->where('v_productos.id_areap',$id_areap)  
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

    public function PedidosLista(Request $request){

        $data = $request->all();

        $pedidos = $this->GetPedidosLista($data['id_sucursal'],$data['id_areap'],isset($data['estados'])?$data['estados']:null );

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

            $val = DB::table('tm_detalle_pedido')   -> where(['id_pedido'=>$data['cod_ped'],'id_det_ped'=> $data['cod_det_ped']])
                                                    -> where('estado','a')
                                                    ->update(['estado'=>'p','fecha_envio'=>$fecha]);

            if($val == 0){
            DB::table('tm_detalle_pedido')  -> where(['id_pedido'=>$data['cod_ped'],'id_det_ped'=> $data['cod_det_ped']])
                                            -> where('estado','p')
                                            ->update(['estado'=>'a','fecha_envio'=>$fecha]);
            }

            return json_encode($val);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Atendido(Request $request){

        $data = $request->all();
        try 
        {   
            
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            DB::table('tm_detalle_pedido')  ->where(['id_pedido'=>$data['cod_ped'],'id_det_ped'=> $data['cod_det_ped']])
                                            ->update(['estado'=>'c','fecha_envio'=>$fecha]);
            event(new PedidoListo($data['cod_ped'],$data['cod_det_ped'],session('id_sucursal')));

            return json_encode(1);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
