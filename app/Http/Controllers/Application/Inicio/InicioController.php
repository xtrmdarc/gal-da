<?php

namespace App\Http\Controllers\Application\Inicio;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmSalon;
use App\Models\TmProductoCatg;
use App\Models\TmPedido;
use App\Models\TmMesa;
use App\Models\TmCliente;
use App\Models\TmUsuario;
use App\Models\TmTipoPedido;
use App\Models\Empresa;
use App\Events\PedidoRegistrado;
use App\Events\PedidoCancelado;
use App\Events\VentaEfectuada;
use App\Models\EFacturacion;


class InicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol',['only' => ['Index']]);
    }
    public function Index(){
        

        $ListarCM = TmSalon::where('estado','<>','i')
                            ->where('id_sucursal',session('id_sucursal'))->get();   
        //crear sp y filtro parametro id_sucursal
        $ListarMesa = DB::table('v_listar_mesas')
                            ->where('id_sucursal',session('id_sucursal'))->get();

        $ListarMozos = DB::table('v_usuarios')
                                ->select('id_usu','nombres','ape_paterno','ape_materno')
                                ->where('id_rol', 4)
                                ->where('id_sucursal',session('id_sucursal'))
                                ->get();

        $aperturas = DB::table('v_caja_aper')
                                ->select('id_apc','id_usu','id_caja','estado','desc_caja')
                                ->where('id_sucursal',session('id_sucursal'))
                                ->where('estado','a')
                                ->get();

        $data = [
            'ListarCM' => $ListarCM,
            'ListarMesa' => $ListarMesa,
            'ListarMozos'=> $ListarMozos,
            'breadcrumb' => 'pedidos',
            'titulo_vista' => 'Pedidos',
            'vista_amplia'=> true,
            'aperturas'=> $aperturas,
            'valida_empresa'=> $this->verificarEmpresaConfiguracion()
        ];

        return view('contents.application.inicio.index')->with($data);
    }

    public function verificarEmpresaConfiguracion(){

        $empresa = Empresa::where('id',\Auth::user()->id_empresa)->first();

        $razon_social = $empresa->razon_social;
        $abreviatura = $empresa->abrev_rs;
        $igv = $empresa->igv;
        $ruc = $empresa->ruc;
        $moneda = $empresa->moneda;
        $telefono = $empresa->telefono;
        $direccion = $empresa->direccion;
        $pais = $empresa->id_pais;
        $campos_empresa = array($razon_social,$abreviatura,$igv,$ruc,$moneda,$telefono,$direccion,$pais);

        foreach($campos_empresa as $ce)
        {
            if(!isset($ce) || $ce == '')
            {
                return 0;
            }
        }

        return 1;
    }

    public function VerificarMozoPIN(Request $request){

        $usrMozo = TmUsuario::where('PIN',$request->pin)->first();

        $response = new \stdClass();
        if(isset($usrMozo))
        {
            
            if($request->estadoM == 'a' )
            {   
                //Este es el array que se utiliza para suplir los campos que tiene el modal de apertura de mesa convencial
                //donde se tienen los campos de nomb_cliente, Cod_mozo ,Comentario
                //Pa que no te pierdas
                $sup_array = array ('cod_mozo'=>$usrMozo->id_usu,'nomb_cliente'=>"",'comentario'=>"");
                $request->request->add($sup_array);
                
                $response->nro_pedido = $this->RegistrarMesa($request)->cod;
                $response->status = 'ok';
                $response->index_por_cuenta = (DB::table('tm_pedido')->where('id_pedido',$row->cod)->first())->index_por_cuenta;
            }
            else 
            {
                $response->status = 'ok';
                $response->nro_pedido = $request->nro_pedido;
                $response->index_por_cuenta = (DB::table('tm_pedido')->where('id_pedido',$response->nro_pedido)->first())->index_por_cuenta;
            }
        }
        else $response->status = 'bad';

        return json_encode($response);
    }   

    /*Registrar mesa*/
    public function RMesa(Request $request){  
        $response = new \stdClass();
        $respuesta_validado = $this->ValidarLimiteVenta();
        if($respuesta_validado != null){
            return $respuesta_validado;
        }

        $row = $this->RegistrarMesa($request);
        if ($row->dup == 1){

            session(['cod_tipe'=>1]);
            //ValidarEstadoPedido($row['cod']);
            $response->tipo = 1;
            $response->num_pedido = $row->cod;
            $response->index_por_cuenta = $row->index_por_cuenta;
            return json_encode($response);

        } else {    
           return redirect('/inicio');
        }
    }

    public function RegistrarMesa(Request $request)
    {   
        $data = $request->all();

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d H:i:s");
        $id_usu = \Auth::user()->id_usu;
        
        if(session('rol_usr') == 4){ $id_moso = $id_usu; } else { $id_moso = $data['cod_mozo']; };
        $row = DB::select('call  usp_restRegMesa_g( ?, ?, ?, ?, ?, ?,?, ?,?)',[1,$data['cod_mesa'],1,$id_usu,$id_moso,$fecha,$data['nomb_cliente'],$data['comentario'],session('id_sucursal') ])[0];
        
        $row->index_por_cuenta = (DB::table('tm_pedido')->where('id_pedido',$row->cod)->first())->index_por_cuenta;
        
        return $row;
    }


    public function ValidarEstadoP($cod){
        try {

            $result  = DB::select("SELECT count(*) AS total FROM tm_pedido WHERE id_pedido = ? AND estado = 'a'",[$cod]);

            foreach($result as $r){
                $valor = $r->total;
            }
            return $valor;
        } catch (Exception $e) {
            return false;   
        }   
    }

    function ValidarLimiteVenta(){
        if(\Auth::user()->plan_id == 1)
        {
            $response = new \stdClass();

            $fecha_anio = date("Y");
            $fecha_mes = date("m");

            $subscription = DB::table('subscription')
                ->select('planes.venta_max')
                ->leftJoin('planes','subscription.plan_id','planes.id')
                ->where('id_usu',\Auth::user()->id_usu)
                ->get();

            foreach($subscription as $r) {
                $venta_max = $r->venta_max;
            }

            $nventas_mensual =  DB::select('SELECT count(*) as nventas_mensual FROM tm_venta v LEFT JOIN tm_usuario u ON u.id_usu = v.id_usu WHERE u.id_empresa = ?
                                            and MONTH(fecha_venta) = ? and YEAR(fecha_venta) = ?',[\Auth::user()->id_empresa,$fecha_mes,$fecha_anio])[0]->nventas_mensual;
            //$nventas =  DB::select('SELECT count(*) as nventas FROM tm_venta v LEFT JOIN tm_usuario u ON u.id_usu = v.id_usu WHERE u.id_empresa = ?',[\Auth::user()->id_empresa])[0]->nventas;
            if($nventas_mensual >= $venta_max) {

            //$nventas =  DB::select('SELECT count(*) as nventas FROM tm_venta v LEFT JOIN tm_usuario u ON u.id_usu = v.id_usu WHERE u.id_empresa = ?',[\Auth::user()->id_empresa])[0]->nventas;
            //if($nventas >= 1000) {
                $response->tipo =0;
                return json_encode($response);
            }
        }
        return null;
    }

    /*Registrar mostrador*/
    public function RegistrarMostrador(Request $request){
        $response = new \stdClass();
        $respuesta_validado = $this->ValidarLimiteVenta();
        if($respuesta_validado != null){
            return $respuesta_validado;
        }
        date_default_timezone_set('America/Lima');
        try
        {
            $data = $request->all();
            
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = \Auth::user()->id_usu;

            $arrayParam =  array(
                1,//id_flag
                2,//id_tp
                $id_usu,//id_usu
                $fecha,
                $data['nomb_cliente'],
                $data['comentario']?:'',
                session('id_sucursal')

            );

            $row = DB::select("call usp_restRegMostrador_g( ?,?,?,?,?,?,?)",$arrayParam)[0];

            session(['cod_tipe'=>2]);
            $response->tipo = 2;
            $response->num_pedido = $row->cod;
            $response->index_por_cuenta = (DB::table('tm_pedido')->where('id_pedido',$row->cod)->first())->index_por_cuenta;
            return json_encode($response);

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /*Registrar delivery*/
    public function RegistrarDelivery(Request $request){
        $response = new \stdClass();
        $respuesta_validado = $this->ValidarLimiteVenta();
        if($respuesta_validado != null){
            return $respuesta_validado;
        }
        
        try
        {
            $data = $request->all();

            $id_usu = \Auth::user()->id_usu;
            $cliente = TmCliente::firstOrNew(
                ['telefono'=>$data['telefCli'],'id_sucursal'=>\Auth::user()->id_empresa],
                [   'nombres'=>$data['nombCli'],
                    'ape_paterno'=>$data['appCli'],
                    'ape_materno'=>$data['apmCli'],
                    'direccion'=>$data['direcCli'],
                    'id_empresa'=> session('id_empresa'),
                    'id_usu' =>$id_usu
                ]
            );

            if (TmCliente::where('id_empresa', session('id_empresa'))
                ->where('telefono',$data['telefCli'])->exists()) {

                $user_tel = DB::table('tm_cliente')
                    ->where('id_empresa', session('id_empresa'))
                    ->where('telefono',$data['telefCli'])
                    ->select('id_cliente')
                    ->get();

                foreach($user_tel as $r){
                    $id_cliente_u = $r->id_cliente;
                }

                date_default_timezone_set('America/Lima');
                setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                $fecha = date("Y-m-d H:i:s");

                $arrayParam =  array(
                    1,
                    3,
                    $id_usu,//id_usu
                    $fecha,
                    trim($data['nombCli']).' '.trim($data['appCli']).' '.trim($data['apmCli']),
                    $data['direcCli'],
                    $data['telefCli'],
                    $data['comentario'],
                    $id_cliente_u,
                    session('id_sucursal')
                );

                $row = DB::select('call usp_restRegDelivery_g( ?, ?, ?,?,?,?,?, ?,?,?)',$arrayParam)[0];

                session(['cod_tipe'=>3]);
                $response->tipo = 3;
                $response->num_pedido = $row->cod;
                $response->index_por_cuenta = (DB::table('tm_pedido')->where('id_pedido',$row->cod)->first())->index_por_cuenta;
            return json_encode($response);

            }
            else {
                $cliente->save();
                date_default_timezone_set('America/Lima');
                setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                $fecha = date("Y-m-d H:i:s");

                $arrayParam =  array(
                    1,
                    3,
                    $id_usu,//id_usu
                    $fecha,
                    trim($data['nombCli']).' '.trim($data['appCli']).' '.trim($data['apmCli']),
                    $data['direcCli'],
                    $data['telefCli'],
                    $data['comentario'],
                    $cliente->id_cliente,
                    session('id_sucursal')
                );

                $row = DB::select('call usp_restRegDelivery_g( ?, ?, ?,?,?,?,?, ?,?,?)',$arrayParam)[0];

                session(['cod_tipe'=>3]);
                $response->tipo = 3;
                $response->num_pedido = $row->cod;
                $response->index_por_cuenta = (DB::table('tm_pedido')->where('id_pedido',$row->cod)->first())->index_por_cuenta;
            return json_encode($response);
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function ValidarEstadoPedido($index){

        $cod = (DB::table('tm_pedido')->where('index_por_cuenta',$index)->where('id_empresa',\Auth::user()->id_empresa)->first())->id_pedido;
        
        $val = self::ValidarEstadoP($cod);
        //Comprobantes
        $stm_comprobantes = DB::Select("SELECT * FROM tm_tipo_doc td  LEFT JOIN tipo_doc_empresa te ON te.id_tipo_doc =  td.id_tipo_doc where te.id_empresa = ?",[session('id_empresa')]);
        $data = [
            'cod'=> $cod,
            'breadcrumb'=> '' ,
            'vista_amplia' => true,
            'Comprobantes' => $stm_comprobantes,
            'index' =>$index
        ];
        if ($val == 1){
            
            return view('contents.application.inicio.orden')->with($data);
        } else {
            
            self::Index();
        }           
    }

    public function RegistrarPedido(Request $request)
    {
        try{
            $data = $request->all();
            $val = self::ValidarEstadoP($data['cod_p']);

            if ($val == 1){

                date_default_timezone_set('America/Lima');
                setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                
                $fecha = date("Y-m-d H:i:s");

                $productosRegistrados = [];
                $areasProd = [];

                $var  = DB::select('call usp_nombrePedido (?)',[$data['cod_p']])[0]->nombre;

                $nombrePedidoDB = DB::select('call usp_nombrePedido (?)',[$data['cod_p']])[0];
                $nombrePedido = '';
                if(isset($nombrePedidoDB->nombre)) $nombrePedido = $nombrePedidoDB->nombre;

                $data['pedido'] = TmPedido::where('id_pedido',$data['cod_p'])->first();
                $data['pedido']['nombre']  = $nombrePedido;

                $tipoPedido = TmTipoPedido::where('id_tipo_pedido',$data['pedido']['id_tipo_pedido'])->first()->descripcion; 
                
                foreach($data['items'] as $d => $v)
                {
                    $id = DB::table('tm_detalle_pedido')->insertGetId([
                        'id_pedido' => $data['cod_p'],
                        'id_prod'=> $data['items'][$d]['producto_id'],
                        'cantidad'=> $data['items'][$d]['cantidad'],
                        'cant'=>$data['items'][$d]['cantidad'],
                        'precio'=>$data['items'][$d]['precio'],
                        'comentario'=>$data['items'][$d]['comentario'],
                        'fecha_pedido'=>$fecha
                    ]);

                    $data['items'][$d]['id_det_ped'] = $id;
                    $producto = DB::select("SELECT * FROM v_productos WHERE id_pres = ?",[$data['items'][$d]['producto_id']])[0];
                    $data['items'][$d]['nombre_prod'] = $producto->nombre_prod;
                    $data['items'][$d]['pres_prod'] = $producto->pres_prod;
                    $data['items'][$d]['id_areap'] = $producto->id_areap;
                    $productosRegistrados[] = $producto;
                    $data['items'][$d]['fecha']  = $fecha;
                    $data['items'][$d]['nombre_usuario']  = $nombrePedido;
                    $data['items'][$d]['tipo_usuario']= $tipoPedido;
                    $data['items'][$d]['estado'] = 'a';
                }

                //Seleccionar todas las areas de produccion

                foreach($productosRegistrados as $k => $v){

                    $areasProd[$v->id_areap] = true;
                }

                $areasProd = array_keys($areasProd);
                
                //Evento registrado Ordenes por areas de proudccion
                foreach($areasProd as $a)
                {
                    $orden = $data;
                    $orden['items']= [];
                    $orden['id_areap'] = $a;
                    foreach($data['items'] as $itemPedido)
                    {
                        if($itemPedido['id_areap'] ==  $a )
                        {
                            $orden['items'][] = $itemPedido;
                        }
                    }
                    
                    event(new PedidoRegistrado($orden,$a));
                }

                print_r(json_encode(1));
            } else  {
                print_r(json_encode(2));
            }
        }
        catch (Exception $e) 
        {
            echo($e->getMessage());
            die($e->getMessage());
        }
    }

    public function Desocupar(Request $request){
       
        try
        {
            $data = $request->all(); 

            if($data['cod_tipe'] == 1){
                
                $arrayParam =  array(
                    ':flag' => 1,
                    ':idPed' =>  $data['cod_pede']
                );

                DB::select("call usp_restDesocuparMesa( :flag, :idPed)",$arrayParam);

            } elseif($data['cod_tipe'] == 2 OR $data['cod_tipe'] == 3){

                TmPedido::where('id_pedido',$data['cod_pede'])
                        ->update(['estado'=>'i']);
            }
            
          return redirect('/inicio');
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function CancelarPedido(Request $request){
        
        $data = $request->all();
        //Este codigo es el codigo de presentacion
        $cod = $data['cod_ped'];
        $index = $data['index_pedido'];
        //dd($index);
        DB::table('tm_detalle_pedido')->where('id_det_ped',$data['cod_det_ped'])
                                    ->where('id_pedido',$data['cod_ped'])
                                    ->where('estado','<>','i')
                                    ->update(['estado'=>'i']);
        //dd('SELECT p.id_sucursal as id_sucursal, p.id_areap as id_areap FROM tm_detalle_pedido dp join tm_producto p on dp.id_prod = p.id_prod where dp.id_det_ped = '.$data['cod_det_ped']);
        $aux = DB::select('SELECT p.id_sucursal as id_sucursal, p.id_areap as id_areap FROM tm_detalle_pedido dp join tm_producto_pres pp on pp.id_pres = dp.id_prod join tm_producto p on pp.id_prod = p.id_prod where dp.id_det_ped = ?',[$data['cod_det_ped']])[0];
  
        event(new PedidoCancelado($data['cod_det_ped'],$aux->id_sucursal,$aux->id_areap ));   

        if($data['cod_tipe'] == 1){
            //self::ValidarEstadoPedido($cod);
           return redirect('/inicio/PedidoMesa/'.$index.'');

        } elseif($data['cod_tipe'] == 2){
           return redirect('/inicio/PedidoMostrador/'.$index.'');
        } elseif($data['cod_tipe'] == 3){
           return redirect('/inicio/PedidoDelivery/'.$index.'');
        }
    }

    public function CambiarMesa(Request $request){        

        try
        {
            $data = $request->all();
            $arrayParam =  array(
                ':flag' => 1,
                ':codMO' =>  $data['c_mesa'],
                ':codMD' => $data['co_mesa']
            );
            $row = DB::select("call usp_restCambiarMesa( :flag, :codMO, :codMD)",$arrayParam)[0];

            if ($row->dup == 1){
               return redirect('/inicio');
            } else {
                self::Index();
            }

            echo(' llego aqui');//Verificar

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    /*Realizar venta*/
    public function RegistrarVenta(Request $request){

        $response = new \stdClass();
        $respuesta_validado = $this->ValidarLimiteVenta();
        if($respuesta_validado != null){
            return $respuesta_validado;
        }
        $data = $request->all();
        // SETEAR SI ESTA ACTIVADO LA FACTURACION ELECTRONICA. LE QUEDAN CPE's ? 

        if($data['cod_pedido'] != ''){
           
            try
            {
                date_default_timezone_set('America/Lima');  
                setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                $fecha = date("Y-m-d H:i:s");

                $id_usu = \Auth::user()->id_usu;
                if(\Auth::user()->id_rol == 5)
                {
                    //Verificar
                }
                $id_apc = session('id_apc');
                //dd(session('id_apc'));
                $igv = session('igv_session');
                if($data['m_desc'] == null ) $data['m_desc'] = '0.00'; 
                
                
                $comprobante = DB::table('tm_tipo_doc')->where('id_tipo_doc',$data['tipo_doc'])->first(); 
                
                $arrayParam = array(
                        1,//flag
                        $data['tipo_pedido'], //tipo pedido
                        $data['tipoEmision'], //tipo emision
                        $data['cod_pedido'], //id pedido
                        $data['cliente_id'], //id cliente
                        $data['tipo_pago'], //tipo pago
                        $data['tipo_doc'], //tipo doc
                        $id_usu, //id _usu
                        $id_apc,//Apc
                        $data['pago_t'], // monto pago
                        $data['m_desc'],//monto descuento
                        $igv, //igv 
                        $data['total_pedido'], //total monto
                        $fecha, //fecha emision
                        //---
                        '0101', //tipo operacion (tipo factura = venta interna)
                        $fecha, //fecha vencimiento
                        $comprobante->tipo_doc_codigo, //tipo doc = Factura
                        'PEN', //moneda
                        number_format($data['total_pedido']/(1+$igv), 2,".", ""), //MtoOperGravadas
                        0, // MtoOperExoneradas
                        number_format($data['total_pedido']/(1+$igv) *$igv, 2, ".", ""),//  MtoIGV
                        number_format($data['total_pedido']/(1+$igv) *$igv, 2, ".", ""), //  TotalImpuestos
                        number_format($data['total_pedido']/(1+$igv), 2, ".", ""), // MtoVenta
                        number_format($data['total_pedido'],2, ".", ""), // total //falta guardar MtoImpVenta
                        session('id_empresa'), //
                        $comprobante->electronico //factura electronicamente
                    );
                
            
                
                
                $st = DB::select('call usp_restEmitirVenta( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',$arrayParam);

                //Cod es el id de la venta realizada.
                foreach($st as $s){
                    $cod = $s->cod;
                }


                
                

                $a = $data['idProd'];
                $b = $data['cantProd'];
                $c = $data['precProd'];
    

                for($x=0; $x < sizeof($a); ++$x){
                    if ($b[$x] > 0){
                        $params = array($cod,
                                        $a[$x], //id producto
                                        $b[$x], //cantidad
                                        $c[$x], //precio
                                        'NIU', //unidad 
                                        $igv , //porcentaje igv 0.18
                                        '10' //tipo afe igv
                                    );
                        DB::insert("INSERT INTO tm_detalle_venta (id_venta,id_prod,cantidad,precio,unidad,porcentaje_igv,tip_afe_igv) VALUES (?,?,?,?,?,?,?)",$params);
                    }
                }

                $arrayParam2 = array(
                    1,
                    $cod,
                    $data['cod_pedido'],
                    $fecha.''
                );
                DB::statement('call usp_restEmitirVentaDet( ?, ?, ?, ?)',$arrayParam2);

                if($comprobante->electronico==1)
                {
                    EFacturacion::generarInvoice($cod);
                }

                //el usuario superadminsitrador ha hecho mas de 1 venta
                $id_user_super = \Auth::user()->parent_id?\Auth::user()->parent_id : \Auth::user()->id_usu;
                DB::table('tm_usuario')->where('id_usu',$id_user_super)->update([
                    'primer_pedido' => true
                ]);

                //Broadcastear venta de pedido
                $ordenVendida = TmPedido::find($data['cod_pedido']);
                event(new VentaEfectuada($ordenVendida));

            } catch (Exception $e) 
            {
                die($e->getMessage());
            }
        }

    }

    public function FinalizarPedido(Request $request){
        
        try 
        {
            $data = $request->all();
            $pedido = TmPedido::find($data['codPed']);
            $pedido->estado = 'c';
            $pedido ->save();

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }

       return redirect('/inicio');
    }

    public function DatosGrles(Request $request)
    {
        $data = $request->all();

        if($data['tp'] == 1){ 
            $tabla = 'v_pedido_mesa'; 
            }
        elseif($data['tp'] == 2) { 
            $tabla = 'v_pedido_llevar';
            } 
        elseif($data['tp'] == 3) {
             $tabla = 'v_pedido_delivery'; 
            }
            $c = DB::table($tabla)->where('id_pedido',$data['cod'])->first();

            $c->Detalle = DB::select("SELECT SUM(cantidad) AS cantidad, precio, comentario, estado FROM tm_detalle_pedido WHERE id_pedido = ".$c->id_pedido." AND estado <> 'i' GROUP BY id_prod ORDER BY fecha_pedido DESC");
            
            /* Traemos el detalle */

            return json_encode($c);
    }
    
    public function listarPedidos(Request $request){

        try
        {  
            
            $dato = $request->all();
            $c = DB::select("SELECT id_prod,SUM(cantidad) AS cantidad, precio, comentario, estado FROM tm_detalle_pedido WHERE id_pedido = ? AND estado <> 'i' AND cantidad > 0 GROUP BY id_prod ORDER BY fecha_pedido DESC",[$dato['cod']]);

            foreach($c as $k => $d)
            {
                $c[$k]->Producto = DB::select("SELECT nombre_prod,pres_prod FROM v_productos WHERE id_pres = ?", [$d->id_prod])[0];    
            }
            $data = array("data" => $c);
            $json = json_encode($data);
            echo $json;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    //convertirlo a SP y asignar un (parametro) filtro de id_sucursal
    public function BuscarProducto(Request $request)
    {
        try
        {       
            $data = $request->all(); 
            $criterio = $data['criterio'];
            $c = DB::select("SELECT * FROM v_productos WHERE (nombre_prod LIKE '%$criterio%' OR cod_prod LIKE '%$criterio%') AND estado <> 'i' AND id_sucursal = ?  ORDER BY nombre_prod LIMIT 5",[session('id_sucursal')]);
            
            echo json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    //convertirlo a SP y asignar un (parametro) filtro de id_sucursal
    public function BuscarCliente(Request $request)
    {
        try
        {   
            $criterio = ($request->all())['criterio'];
            $stm = DB::select("SELECT * FROM v_clientes WHERE estado <> 'i' AND (dni LIKE '%$criterio%' OR ruc LIKE '%$criterio%' OR nombre LIKE '%$criterio%') AND (id_empresa = ? OR id_empresa is null)  ORDER BY dni LIMIT 5",[session('id_empresa')]);
            // dd($stm);
            return json_encode($stm);

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    //Re diseñar está funcion para registro lite de cliente en delivery
    public function NuevoCliente(Request $request)
    {
        try
        {
            $response = new \stdClass();
            
            $data = $request->all();
            $fecha_nac = date('Y-m-d',strtotime($data['fecha_nac']));
            //$fecha_nac = '';

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
                ':direc' => $data['direccion'],
                ':idSucursal' =>session('id_sucursal'),
                ':idEmpresa' =>session('id_empresa')
            );
            $result = DB::select('SELECT count(*) as duplicado FROM tm_cliente WHERE id_empresa = ? AND ((dni = ? AND dni is not null AND dni != "" ) OR  (ruc = ? AND ruc is not null and ruc != ""))',[session('id_empresa'),$data['dni'],$data['ruc']])[0];
            $response->dup = $result->duplicado;
            if($response->dup >0 )
            {
                return json_encode($response);
            }
            $id_cliente = DB::table('tm_cliente')->insertGetId([
                                                    'dni'=> $data['dni'],
                                                    'ruc' => $data['ruc'],
                                                    'ape_paterno'=> $data['ape_paterno'],
                                                    'ape_materno'=> $data['ape_materno'],
                                                    'nombres'=> $data['nombres'],
                                                    'razon_social'=> $data['razon_social'],
                                                    'telefono'=> $data['telefono'],
                                                    'fecha_nac'=> $fecha_nac,
                                                    'correo'=> $data['correo'],
                                                    'direccion'=> $data['direccion'],
                                                    'id_sucursal'=> session('id_sucursal'),
                                                    'id_empresa'=> session('id_empresa'),
                                                    'es_empresa' => $data['tipoCliente']==1?0:1
                                                ]);
                        
            $response->id_cliente = $id_cliente;
            $response->nombres = $data['nombres'];
            $response->ape_materno = $data['ape_paterno'];
            $response->ape_paterno = $data['ape_materno'];
            $response->razon_social = $data['razon_social'];

            //$consulta = DB::select("call usp_restRegCliente_g( :flag, :dni, :ruc, :apeP, :apeM, :nomb, :razS, :telf, :fecN, :correo, :direc, @a,:idSucursal,:idEmpresa)",$arrayParam);
            return json_encode($response);
            // foreach($consulta as $row){
            //     return json_encode($row->dup);
            // }
        } 
        catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }

    public function ListarDetallePed(Request $request){

        try
        {   $data = $request->all();
            if($data['tp'] == 1){ $tabla = 'v_pedido_mesa'; } elseif($data['tp'] == 2) { $tabla = 'v_pedido_llevar'; } elseif($data['tp'] == 3) { $tabla = 'v_pedido_delivery'; }
            $c = DB::table($tabla)->where('id_pedido',$data['cod'])->first();

            /* Traemos el detalle */
            $c->Detalle = DB::select("SELECT id_prod,SUM(cantidad) AS cantidad, precio, estado FROM tm_detalle_pedido WHERE id_pedido = " . $c->id_pedido." AND estado <> 'i' GROUP BY id_prod");

            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->Producto = DB::select("SELECT nombre_prod, pres_prod FROM v_productos WHERE id_pres = " . $d->id_prod)[0];
            }
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ListarDetalleSubPed(Request $request){

        try
        {   
            $data = $request->all();
            if($data['tp'] == 1){ $tabla = 'v_pedido_mesa'; } elseif($data['tp'] == 2) { $tabla = 'v_pedido_llevar'; } elseif($data['tp'] == 3) { $tabla = 'v_pedido_delivery'; }
            $c = DB::table($tabla)->where('id_pedido',$data['cod'])->first();

            /* Traemos el detalle */
            $c->Detalle = DB::select("SELECT id_det_ped, id_prod, cantidad, precio, estado, fecha_pedido FROM tm_detalle_pedido WHERE id_pedido = ".$c->id_pedido." AND id_prod = ".$data['prod']." ORDER BY fecha_pedido DESC");

            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->Producto = DB::select("SELECT nombre_prod, pres_prod FROM v_productos WHERE id_pres = " . $d->id_prod)[0];
            }
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ListarMostrador(){

        try
        {
            $c = DB::select("SELECT tp.*,p.fecha_pedido,p.estado, count(dp.id_pedido) as pedidos_listos,p.index_por_cuenta FROM tm_pedido AS p INNER JOIN tm_pedido_llevar AS tp ON p.id_pedido = tp.id_pedido LEFT JOIN tm_detalle_pedido dp ON (p.id_pedido = dp.id_pedido and dp.estado = 'c') WHERE p.estado <> 'i' AND p.estado <> 'c' AND p.id_sucursal = ? GROUP BY 1,p.fecha_pedido,p.estado",[session('id_sucursal')]);
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_llevar WHERE estado <> 'i' AND id_pedido = " . $d->id_pedido)[0];
            }
            
            return json_encode($c);
          
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function DetalleMostrador(Request $request)
    {

        try
        {
            $data = $request->all();
            $cod = $data['cod'];

            $c =DB::select("SELECT id_pedido,id_prod,SUM(cantidad) AS cantidad,precio,estado FROM v_det_llevar WHERE id_pedido = ? GROUP BY id_prod",[$cod]);

            foreach($c as $k => $d)
            {
                $c[$k]->Producto = DB::select("SELECT nombre_prod,pres_prod FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
            }
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ListarDelivery(){
        try
        {
            $c = DB::select("SELECT tp.*,p.fecha_pedido,p.estado, count(dp.id_pedido) as pedidos_listos,p.index_por_cuenta FROM tm_pedido AS p INNER JOIN tm_pedido_delivery AS tp ON p.id_pedido = tp.id_pedido LEFT JOIN tm_detalle_pedido dp ON (p.id_pedido = dp.id_pedido and dp.estado = 'c') WHERE p.estado <> 'i' AND p.estado <> 'c'AND p.id_sucursal = ? GROUP BY 1,p.fecha_pedido,p.estado",[session('id_sucursal')]);
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_delivery WHERE estado <> 'i' AND id_pedido = " . $d->id_pedido)[0];
            }

            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function DetalleDelivery(Request $request)
    {
        try
        {
            $data = $request->all();
            $cod = $data['cod'];
            $c = DB::select("SELECT id_pedido,id_prod,SUM(cantidad) AS cantidad,precio,estado FROM v_det_delivery WHERE id_pedido = ? GROUP BY id_prod",[$cod]);

            foreach($c as $k => $d)
            {
                $c[$k]->Producto = DB::select("SELECT nombre_prod,pres_prod FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
            }
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    
    public function ComboMesaOri(Request $request)
    {
        try
        {   
            $data = $request->all();
            $var = TmMesa::where(['id_catg'=>$data['cod'],'estado'=>'i','id_sucursal'=>session('id_sucursal')])
                            ->orderBy('nro_mesa','ASC')->get();
            foreach($var as $v){
                echo '<option value="'.$v->id_mesa.'">'.$v->nro_mesa.'</option>';
            }
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ComboMesaDes(Request $request)
    {
        try
        {   
            $data = $request->all();

            $var = TmMesa::where(['id_catg'=>$data['cod'],'estado'=>'a','id_sucursal'=>session('id_sucursal')])
                            ->orderBy('nro_mesa','ASC')->get();

            foreach($var as $v){
                echo '<option value="'.$v->id_mesa.'">'.$v->nro_mesa.'</option>';
            }
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function listarCategorias(){
        try
        {   
            $c = TmProductoCatg::where('id_sucursal',session('id_sucursal'))->get();
            echo json_encode($c);
            
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function listarProductos(Request $request){

        try
        {   
            $data = $request->all();
            $c = DB::table("v_productos")->where("id_catg",$data['cod'])
                                        ->where('id_sucursal',session('id_sucursal'))->get();
            echo json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function Imprimir($index){

        try{
            $cod = (DB::table('tm_pedido')->where('index_por_cuenta',$index)->where('id_empresa',\Auth::user()->id_empresa)->first())->id_pedido;
            $data = DB::table('v_ventas_con')->where('id_ped',$cod)->first();
            $data->Cliente = DB::table('v_clientes')->where('id_cliente',$data->id_cli)->first();
            /* Traemos el detalle */
            $data->Detalle = DB::select("SELECT id_prod,SUM(cantidad) AS cantidad, precio FROM tm_detalle_venta WHERE id_venta = ? GROUP BY id_prod",[$data->id_ven]);

            foreach($data->Detalle as $k => $d)
            {
                $data->Detalle[$k]->Producto = DB::select("SELECT nombre_prod, pres_prod FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
            }
            
            require_once (public_path().'/rest/Imprimir/comp.php');
            return json_encode(1);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ImprimirPC($index){

        try
        {        
            $cod = (DB::table('tm_pedido')->where('index_por_cuenta',$index)->where('id_empresa',\Auth::user()->id_empresa)->first())->id_pedido;
            $data = DB::table('v_pedido_mesa')->where('id_pedido',$cod)->first();
            /* Traemos el detalle */
            $data->Detalle = DB::select("SELECT id_prod,SUM(cantidad) AS cantidad, precio FROM tm_detalle_pedido WHERE id_pedido = ? AND estado <> 'i' GROUP BY id_prod",[$data->id_pedido]);

            foreach($data->Detalle as $k => $d)
            {
                $data->Detalle[$k]->Producto = DB::table('v_productos')->where('id_pres',$d->id_prod)->first();
            }
            require_once (public_path().'/rest/Imprimir/comp_pc.php');
            return json_encode(1);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        
    }

    public function preCuenta(Request $request){

        try 
        {
            $data = $request->all();
            if($data['est']=='i'){$est='p';}elseif($data['est']=='p'){$est='i';};

            DB::table('tm_mesa')->where('id_mesa',$data['cod'])
                                ->update(['estado'=>$est]);
            
            return 1;
        }
        catch (Exception $e) 
        {
            return false;
        }
    }
    
    
    public function BuscarClienteTelefono(Request $request){
        
        try
        {
            $data = $request->all();
            $telefono = $data['telefono'];
            
            $cliente = TmCliente::firstOrNew(['telefono'=>$telefono,'id_empresa'=>session('id_empresa')]);

            return response()->json($cliente);

        }catch(Exception $e){
            return false;   
        }
    }    

    public function EscogerApc(Request $request)
    {
        $data = $request->all();
        session(['id_apc'=>$data['id_apc']]);
        return 1 ;
    }
}
