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


class InicioController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
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
        $data = [
            'ListarCM' => $ListarCM,
            'ListarMesa' => $ListarMesa,
            'ListarMozos'=> $ListarMozos,
            'breadcrumb' => 'produccion'
        ];
        

        return view('contents.application.inicio.index')->with($data);
    }

    /*Registrar mesa*/
    public function RMesa(Request $request){  

        $data = $request->all();

        date_default_timezone_set('America/Lima');
        setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
        $fecha = date("Y-m-d H:i:s");
        $id_usu = session('id_usu');
        $id_usu = 1;
        if(session('rol_usr') == 4){ $id_moso = $id_usu; } else { $id_moso = $data['cod_mozo']; };
        $row = DB::select('call  usp_restRegMesa_g( ?, ?, ?, ?, ?, ?,?, ?,?)',[1,$data['cod_mesa'],1,$id_usu,$id_moso,$fecha,$data['nomb_cliente'],$data['comentario'],session('id_sucursal') ])[0];
        //$row = "call usp_restRegMesa( :flag, :idMesa, :idTp, :idUsu, :idMoso, :fechaP, :nombC, :comen);";
        
        if ($row->dup == 1){
            //header('Location: pedido_mesa.php?Cod='.$row['cod']);
            
            session(['cod_tipe'=>1]);
            //ValidarEstadoPedido($row['cod']);
            header('Location: /inicio/PedidoMesa/'.$row->cod);
        } else {
            //header('Location: inicio.php?Cod=d');
            //self::Index();
            header('Location: /inicio');
        }
    
    }

    public function ValidarEstadoP($cod){
        try {
            //$consulta = "SELECT count(*) AS total FROM tm_pedido WHERE id_pedido = :id_pedido AND estado = 'a'";
            
            $result  = DB::select("SELECT count(*) AS total FROM tm_pedido WHERE id_pedido = ? AND estado = 'a'",[$cod]);

            /*while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $valor = $row['total'];
            }*/ 
            foreach($result as $r){
                $valor = $r->total;
            }
            return $valor;
        } catch (Exception $e) {
            return false;   
        }
    }

    /*Registrar mostrador*/
    public function RegistrarMostrador(Request $request){

       
        try
        {
            $data = $request->all();

            /*$alm = new Mostrador();
            $alm->__SET('nomb_cliente', $_REQUEST['nomb_cliente']);
            $alm->__SET('comentario', $_REQUEST['comentario']);
            */
            
            
            
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = session('id_usu');
            $arrayParam =  array(
                1,//id_flag
                2,//id_tp
                1,//id_usu
                $fecha,
                $data['nomb_cliente'],
                $data['comentario']?:'',
                session('id_sucursal')

            );

            $row = DB::select("call usp_restRegMostrador_g( ?,?,?,?,?,?,?)",$arrayParam)[0];
           
           /* $st = $this->conexionn->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row;*/

            session(['cod_tipe'=>2]);
            header('Location: /inicio/PedidoMostrador/'.$row->cod);
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
        

       /// $row = $this->model->RMostrador($alm);
        
        //header('Location: pedido_mostrador.php?Cod='.$row['cod']);
    }

    /*Registrar delivery*/
    public function RegistrarDelivery(Request $request){

        
        try
        {
            $data = $request->all();

            //$alm = new Delivery();
            /*$alm->__SET('nombCli', $_REQUEST['nombCli']);
            $alm->__SET('telefCli', $_REQUEST['telefCli']);
            $alm->__SET('direcCli', $_REQUEST['direcCli']);
            $alm->__SET('comentario', $_REQUEST['comentario']);
            */
            $cliente = TmCliente::firstOrNew(
                ['telefono'=>$data['telefCli']],
                [   'nombres'=>$data['nombCli'],
                    'ape_paterno'=>$data['appCli'],
                    'ape_materno'=>$data['apmCli'],
                    'direccion'=>$data['direcCli']
                ]
            );
            $cliente->save();
            
            //date_default_timezone_set('America/Lima');
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");
            $id_usu = session('id_usu');
            $arrayParam =  array(
                1,
                3,
                1,//id_usu
                $fecha,
                trim($data['nombCli']).trim($data['appCli']).trim($data['apmCli']),
                $data['direcCli'],
                $data['telefCli'],
                $data['comentario'],
                $cliente->id_cliente,
                session('id_sucursal')
            );
            //echo json_encode($arrayParam);
            $row = DB::select('call usp_restRegDelivery_g( ?, ?, ?,?,?,?,?, ?,?,?)',$arrayParam)[0];
            //dd($row);
            /*$st = $this->conexionn->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);*/
            //header('Location: pedido_delivery.php?Cod='.$row->cod);
            
            //self::ValidarEstadoPedido($row->cod);

            session(['cod_tipe'=>3]);
            header('Location: /inicio/PedidoDelivery/'.$row->cod);
            
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
        //$row = $this->model->RDelivery($alm);


       
    }

    public function ValidarEstadoPedido($cod){

        //$val = $this->model->ValidarEstadoPedido($_REQUEST['Cod']);
        $val = self::ValidarEstadoP($cod);
        $data = [
            'cod'=> $cod,
            'breadcrumb'=> ''  
        ];
        if ($val == 1){
           /* require_once 'view/header.php';
            require_once 'view/inicio/orden.php';
            require_once 'view/footer.php';
            */
            
            
            //echo('hola');
            return view('contents.application.inicio.orden')->with($data);
        } else {
            
            //header('Location: inicio.php?Cod=f');
            self::Index();
        }
    }

    public function RegistrarPedido(Request $request)
    {
        try{
            $data = $request->all();
            $val = self::ValidarEstadoP($data['cod_p']);
            //echo('entro aqui antes de if' );    
            //dd();
            if ($val == 1){
                //var_dump($_POST);
                //echo('entro aqui despues inm de if');  
                
                date_default_timezone_set('America/Lima');
                setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                
                $fecha = date("Y-m-d H:i:s");      

                //echo('fecha '.$fecha);      
                foreach($data['items'] as $d)
                {
                    //echo('entro aqui antes de db');
                    DB::insert("INSERT INTO tm_detalle_pedido (id_pedido,id_prod,cantidad,cant,precio,comentario,fecha_pedido) VALUES (?,?,?,?,?,?,?);",[$data['cod_p'],$d['producto_id'],$d['cantidad'],$d['cantidad'],$d['precio'],$d['comentario'],$fecha]);
                    //DB::table('tm_detalle_pedido')
                    //$this->conexionn->prepare($sql)->execute(array($data['cod_p'],$d['producto_id'],$d['cantidad'],$d['cantidad'],$d['precio'],$d['comentario'],$fecha));
                    //echo('entro aqui');
                }

                print_r(json_encode(1));
            } else  {
                print_r(json_encode(2));
                //header('Location: inicio.php?Cod=f');
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
            /* 
            $alm = new Pedido();
            $alm->__SET('cod_pede',  $_REQUEST['cod_pede']);
            $alm->__SET('cod_tipe',  $_REQUEST['cod_tipe']);
            */
            //$this->model->Desocupar($alm);

            
            if($data['cod_tipe'] == 1){
                
                $arrayParam =  array(
                    ':flag' => 1,
                    ':idPed' =>  $data['cod_pede']
                );

                DB::select("call usp_restDesocuparMesa( :flag, :idPed)",$arrayParam);
                
                /*$st = $this->conexionn->prepare($consulta);
                $st->execute($arrayParam);*/

            } elseif($data['cod_tipe'] == 2 OR $data['cod_tipe'] == 3){
                //$sql = "UPDATE tm_pedido SET estado = 'i' WHERE id_pedido = ?";
                //$this->conexionn->prepare($sql)->execute(array($data->__GET('cod_pede')));
                TmPedido::where('id_pedido',$data['cod_pede'])
                        ->update(['estado'=>'i']);

            }
            
           header('Location: /inicio');
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
        
    }

    public function CancelarPedido(Request $request){
        
        $data = $request->all();
        //$alm = new Pedido();
        $cod = $data['cod_ped'];
        //$sql = "UPDATE tm_detalle_pedido SET estado = 'i' WHERE estado <> 'i' AND id_pedido = ? AND id_prod = ? AND fecha_pedido = ? LIMIT 1";
        DB::table('tm_detalle_pedido')->where('estado','<>','i')
                                    ->where('id_pedido',$data['cod_ped'])
                                    ->where('id_prod',$data['cod_pro'])
                                    ->where('fecha_pedido',$data['fec_ped'])
                                    ->update(['estado'=>'i']);
       /* $this->conexionn->prepare($sql)
             ->execute(
            array(
                $data->__GET('cod_ped'),
                $data->__GET('cod_pro'),
                $data->__GET('fec_ped')
                )
            );*/
        //$this->model->CancelarPedido($alm);

        if($data['cod_tipe'] == 1){
            self::ValidarEstadoPedido($cod);
            //header('Location: pedido_mesa.php?Cod='.$cod.'');

        } elseif($data['cod_tipe'] == 2){
            header('Location: pedido_mostrador.php?Cod='.$cod.'');
        } elseif($data['cod_tipe'] == 3){
            header('Location: pedido_delivery.php?Cod='.$cod.'');
        }
    }

    public function CambiarMesa(Request $request){        
        

        try
        {
           /* $alm = new Mesa();
            $alm->__SET('c_mesa', $_REQUEST['c_mesa']);
            $alm->__SET('co_mesa', $_REQUEST['co_mesa']);
            $row = $this->model->CambiarMesa($alm);
            */
            $data = $request->all();
            $arrayParam =  array(
                ':flag' => 1,
                ':codMO' =>  $data['c_mesa'],
                ':codMD' => $data['co_mesa']
            );
            $row = DB::select("call usp_restCambiarMesa( :flag, :codMO, :codMD)",$arrayParam)[0];
            
            /*$st = $this->conexionn->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);*/
           // return $row;

            if ($row->dup == 1){
                header('Location: /inicio');
                //self::Index();
            } else {
                //header('Location: inicio.php?Cod=d');
                self::Index();
            }

            echo(' llego aqui');

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }

        
    }

    /*Realizar venta*/
    public function RegistrarVenta(Request $request){
        
        $data = $request->all();
        if($data['cod_pedido'] != ''){
           
            try
            {
                date_default_timezone_set('America/Lima');
                setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
                $fecha = date("Y-m-d H:i:s");
                $id_usu = session('id_usu');
                $id_apc = session('id_apc');
                $igv = session('igv');
                if($data['m_desc'] == null ) $data['m_desc'] = '0.00'; 
                $arrayParam = array(
                    1,
                    $data['tipo_pedido'],
                    $data['tipoEmision'],
                    $data['cod_pedido'],
                    $data['cliente_id'],
                    $data['tipo_pago'],
                    $data['tipo_doc'],
                    1,
                    1,
                    $data['pago_t'],
                    $data['m_desc'],
                    $igv,
                    $data['total_pedido'],
                    $fecha
                    );
                $st = DB::select('call usp_restEmitirVenta( ?,?,?,?,?,?,?,?,?,?,?,?,?,?)',$arrayParam);
                //dd($arrayParam);
                //$st = $this->conexionn->prepare($consulta);
                //$st->execute($arrayParam);

            /*  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                    $cod = $row['cod'];
                }
            */

                foreach($st as $s){
                    $cod = $s->cod;
                }


                $a = $data['idProd'];
                $b = $data['cantProd'];
                $c = $data['precProd'];

                for($x=0; $x < sizeof($a); ++$x){
                    if ($b[$x] > 0){
                        $params = array($cod,$a[$x],$b[$x],$c[$x]);
                        DB::insert("INSERT INTO tm_detalle_venta (id_venta,id_prod,cantidad,precio) VALUES (?,?,?,?)",$params);
                        //$this->conexionn->prepare($sql)->execute(array($cod,$a[$x],$b[$x],$c[$x]));
                    }
                }

                //$this->conexionn = Database::Conectar();
                
                $arrayParam2 = array(
                    1,
                    $cod,
                    $data['cod_pedido'],
                    $fecha
                );
                DB::select('call usp_restEmitirVentaDet( ?, ?, ?, ?)',$arrayParam2);
                
                //$stm = $this->conexionn->prepare($cons);
                //$stm->execute($arrayParam);

            } catch (Exception $e) 
            {
                die($e->getMessage());
            }

        //print_r(json_encode( $this->model->RegistrarVenta($_POST)));

        }

    }

    public function FinalizarPedido(Request $request){
        
        try 
        {
            $data = $request->all();

            /*$alm = new Pedido();
            $alm->__SET('codPed',  $_REQUEST['codPed']);
            */

            $pedido = TmPedido::find($data['codPed']);
            $pedido->estado = 'c';
            $pedido ->save();

            /*$sql = "UPDATE tm_pedido SET estado = 'c' WHERE id_pedido = ?";
            $this->conexionn->prepare($sql)->execute(array($data->__GET('codPed')));
            $this->conexionn=null;
            */
        
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
        //$this->model->FinalizarPedido($alm);


        header('Location: /inicio');
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
            //$stm = $this->conexionn->prepare("SELECT * FROM ".$tabla." WHERE id_pedido = ?");
            //$stm->execute(array($data['cod']));
            //$st = DB::select("SELECT * FROM ".$tabla." WHERE id_pedido = ?",[$data['cod']]);
            $c = DB::table($tabla)->where('id_pedido',$data['cod'])->first();
            //$c = $stm->fetch(PDO::FETCH_OBJ);
            
           
            $c->Detalle = DB::select("SELECT SUM(cantidad) AS cantidad, precio, comentario, estado FROM tm_detalle_pedido WHERE id_pedido = ".$c->id_pedido." AND estado <> 'i' GROUP BY id_prod ORDER BY fecha_pedido DESC");
            
            /* Traemos el detalle */
            
              
            return json_encode($c);

       // print_r(json_encode($this->model->DatosGrles($_POST)));

    }
    
    public function listarPedidos(Request $request){

        try
        {  
            
             $dato = $request->all();
            //$stm = $this->conexionn->prepare("SELECT id_prod,SUM(cantidad) AS cantidad, precio, comentario, estado FROM tm_detalle_pedido WHERE id_pedido = ? AND estado <> 'i' AND cantidad > 0 GROUP BY id_prod ORDER BY fecha_pedido DESC");
            $c = DB::select("SELECT id_prod,SUM(cantidad) AS cantidad, precio, comentario, estado FROM tm_detalle_pedido WHERE id_pedido = ? AND estado <> 'i' AND cantidad > 0 GROUP BY id_prod ORDER BY fecha_pedido DESC",[$dato['cod']]);
            //$stm->execute(array($_POST['cod']));
            //$c = $stm->fetchAll(PDO::FETCH_OBJ);  
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
            $stm = DB::select("SELECT * FROM v_clientes WHERE estado <> 'i' AND (dni LIKE '%$criterio%' OR ruc LIKE '%$criterio%') AND id_sucursal = ?  ORDER BY dni LIMIT 1",[session('id_sucursal')]);

            //$stm->execute();
            //return $stm->fetchAll(PDO::FETCH_OBJ);
            
            return json_encode($stm);

        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        //print_r(json_encode($this->model->BuscarCliente($_REQUEST['criterio'])));
    }

    //Replicar en todos los módulos que registran actulizan clientes
    public function NuevoCliente(Request $request)
    {
        
        try
        {
            $data = $request->all();
            $fecha_nac = date('Y-m-d',strtotime($data['fecha_nac']));

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
            $consulta = DB::select("call usp_restRegCliente( :flag, :dni, :ruc, :apeP, :apeM, :nomb, :razS, :telf, :fecN, :correo, :direc, @a,:idSucursal,:idEmpresa)",$arrayParam);
            
            /*$st = $this->conexionn->prepare($consulta);
            $st->execute($arrayParam);
            while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
                return $row['dup'];
            }
            */
            foreach($consulta as $row){
                return json_encode($row->dup);
            }
        } 
        catch (Exception $e) 
        {
            die($e->getMessage());
        }

        //print_r(json_encode($this->model->NuevoCliente($_POST)));
    }

    public function ListarDetallePed(Request $request){

        try
        {   $data = $request->all();
            if($data['tp'] == 1){ $tabla = 'v_pedido_mesa'; } elseif($data['tp'] == 2) { $tabla = 'v_pedido_llevar'; } elseif($data['tp'] == 3) { $tabla = 'v_pedido_delivery'; }
            $c = DB::table($tabla)->where('id_pedido',$data['cod'])->first();
            //("SELECT id_pedido FROM ".$tabla." WHERE id_pedido = ?");
            //$stm->execute(array($data['cod']));
            //$c = $stm->fetch(PDO::FETCH_OBJ);
            /* Traemos el detalle */
            $c->Detalle = DB::select("SELECT id_prod,SUM(cantidad) AS cantidad, precio, estado FROM tm_detalle_pedido WHERE id_pedido = " . $c->id_pedido." AND estado <> 'i' GROUP BY id_prod");
                //->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->Producto = DB::select("SELECT nombre_prod, pres_prod FROM v_productos WHERE id_pres = " . $d->id_prod)[0];
                //    ->fetch(PDO::FETCH_OBJ);
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
            //$stm = $this->conexionn->prepare("SELECT id_pedido FROM ".$tabla." WHERE id_pedido = ?");
            //$stm->execute(array($data['cod']));
            //$c = $stm->fetch(PDO::FETCH_OBJ);
            
            /* Traemos el detalle */
            $c->Detalle = DB::select("SELECT id_prod, cantidad, precio, estado, fecha_pedido FROM tm_detalle_pedido WHERE id_pedido = ".$c->id_pedido." AND id_prod = ".$data['prod']." ORDER BY fecha_pedido DESC");
                //->fetchAll(PDO::FETCH_OBJ);
            foreach($c->Detalle as $k => $d)
            {
                $c->Detalle[$k]->Producto = DB::select("SELECT nombre_prod, pres_prod FROM v_productos WHERE id_pres = " . $d->id_prod)[0];
                    //->fetch(PDO::FETCH_OBJ);
            }
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        //print_r(json_encode($this->model->ListarDetalleSubPed($_POST)));
    }

    public function ListarMostrador(){

        try
        {   
            /*$stm = $this->conexionn->prepare("SELECT tp.*,p.fecha_pedido,p.estado FROM tm_pedido AS p INNER JOIN tm_pedido_llevar AS tp ON p.id_pedido = tp.id_pedido WHERE p.estado <> 'i' AND p.estado <> 'c'");
            $stm->execute();
            $c = $stm->fetchAll(PDO::FETCH_OBJ);*/
            $c = DB::select("SELECT tp.*,p.fecha_pedido,p.estado FROM tm_pedido AS p INNER JOIN tm_pedido_llevar AS tp ON p.id_pedido = tp.id_pedido WHERE p.estado <> 'i' AND p.estado <> 'c' AND p.id_sucursal = ?",[session('id_sucursal')]);
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_llevar WHERE estado <> 'i' AND id_pedido = " . $d->id_pedido)[0];
                    //->fetch(PDO::FETCH_OBJ);
            }
            
            return json_encode($c);
          
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        //print_r(json_encode($this->model->ListarMostrador($_POST)));
    }

    public function DetalleMostrador(Request $request)
    {

        try
        {
            $data = $request->all();
            $cod = $data['cod'];

            $c =DB::select("SELECT id_pedido,id_prod,SUM(cantidad) AS cantidad,precio,estado FROM v_det_llevar WHERE id_pedido = ? GROUP BY id_prod",[$cod]);
            /*$stm->execute(array($cod));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);*/
            foreach($c as $k => $d)
            {
                $c[$k]->Producto = DB::select("SELECT nombre_prod,pres_prod FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
                //->fetch(PDO::FETCH_OBJ);
            }
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        //print_r(json_encode($this->model->DetalleMostrador($_POST)));
    }

    public function ListarDelivery(){
        try
        {   
            //$stm = $this->conexionn->prepare("SELECT tp.*,p.fecha_pedido,p.estado FROM tm_pedido AS p INNER JOIN tm_pedido_delivery AS tp ON p.id_pedido = tp.id_pedido WHERE p.estado <> 'i' AND p.estado <> 'c'");
            //$stm->execute();
            //$c = $stm->fetchAll(PDO::FETCH_OBJ);
            $c = DB::select("SELECT tp.*,p.fecha_pedido,p.estado FROM tm_pedido AS p INNER JOIN tm_pedido_delivery AS tp ON p.id_pedido = tp.id_pedido WHERE p.estado <> 'i' AND p.estado <> 'c'AND p.id_sucursal = ?",[session('id_sucursal')]);
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT IFNULL(SUM(precio*cantidad),0) AS total FROM v_det_delivery WHERE estado <> 'i' AND id_pedido = " . $d->id_pedido)[0];
                    //->fetch(PDO::FETCH_OBJ);
            }
            //$stm->closeCursor();
            return json_encode($c);
            //$this->conexionn=null;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        //print_r(json_encode($this->model->ListarDelivery($_POST)));
    }

    public function DetalleDelivery(Request $request)
    {
        try
        {
            $data = $request->all();
            $cod = $data['cod'];
            $c = DB::select("SELECT id_pedido,id_prod,SUM(cantidad) AS cantidad,precio,estado FROM v_det_delivery WHERE id_pedido = ? GROUP BY id_prod",[$cod]);
            /*$stm->execute(array($cod));
            $c = $stm->fetchAll(PDO::FETCH_OBJ);*/
            foreach($c as $k => $d)
            {
                $c[$k]->Producto = DB::select("SELECT nombre_prod,pres_prod FROM v_productos WHERE id_pres = ?",[$d->id_prod])[0];
               // ->fetch(PDO::FETCH_OBJ);
            }
            return json_encode($c);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        //print_r(json_encode($this->model->DetalleDelivery($_POST)));
    }
    
    public function ComboMesaOri(Request $request)
    {
        try
        {   
            $data = $request->all();
            /*$stmm = $this->conexionn->prepare("SELECT * FROM tm_mesa WHERE id_catg = ? AND estado = 'i' ORDER BY nro_mesa ASC");
            $stmm->execute(array($data['cod']));
            $var = $stmm->fetchAll(PDO::FETCH_ASSOC);4
            */
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
            /*$stmm = $this->conexionn->prepare("SELECT * FROM tm_mesa WHERE id_catg = ? AND estado = 'a' ORDER BY nro_mesa ASC");
            $stmm->execute(array($data['cod']));
            $var = $stmm->fetchAll(PDO::FETCH_ASSOC);
            */
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

    public function Imprimir(){

        $data = $this->model->ObtenerDatosImp($_REQUEST['Cod']);
        require_once 'view/inicio/imprimir/comp.php';

    }

    public function ImprimirPC(){
        $data = $this->model->ObtenerDatosImpPC($_REQUEST['Cod']);
        require_once 'view/inicio/imprimir/comp_pc.php';
    }

    public function preCuenta(Request $request){

        try 
        {
            $data = $request->all();
            if($data['est']=='i'){$est='p';}elseif($data['est']=='p'){$est='i';};
            //$sql = "UPDATE tm_mesa SET estado = ? WHERE id_mesa = ?";
            //$this->conexionn->prepare($sql)->execute(array($est,$data['cod']));
            DB::table('tm_mesa')->where('id_mesa',$data['cod'])
                                ->update(['estado'=>$est]);
        }
        catch (Exception $e) 
        {
            return false;
        }

        //print_r(json_encode( $this->model->preCuenta($_POST)));
    }
    
    
    public function BuscarClienteTelefono(Request $request){
        
        try
        {
            $data = $request->all();
            $telefono = $data['telefono'];
            
            $cliente = TmCliente::firstOrNew(['telefono'=>$telefono,'id_sucursal'=>session('id_sucursal')]);

            return response()->json($cliente);

        }catch(Exception $e){
            return false;   
        }
    }    

    

}
