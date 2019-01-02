<?php

namespace App\Http\Controllers\Application\Compras;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TmProveedor;
use App\Models\TmCompraDetalle;

class ComprasController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index(){

        $idSucursal = session("id_sucursal");
        $proveedores = TmProveedor::where('id_sucursal',$idSucursal)->get();

        $data =[
            'proveedores' => $proveedores,
            'breadcrumb'=> 'compras',
            'titulo_vista' => 'Compras'
        ];

        return view('contents.application.compras.index')->with($data);
    }

    public function crear(){
        $data =[
           // 'proveedores' => $proveedores
           'breadcrumb'=> ''
        ];

        return view('contents.application.compras.crear')->with($data);
    }

    public function obtenerDatos(Request $request){

        $post = $request->all();
        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $tdoc = $post['tdoc'];
        $cprov = $post['cprov'];
        $c = DB::select("SELECT * FROM v_compras WHERE (DATE(fecha_c) >= ? AND DATE(fecha_c) <= ?) AND id_tipo_doc like ? AND id_prov like ? GROUP BY id_compra",[$ifecha,$ffecha,$tdoc,$cprov]);
       
        $data = array('data'=>$c);
        $json = json_encode($data);
        echo $json;
    }

    public function detalle(Request $request){
        
        $post = $request->all();
        $cod = $post['cod'];
        
        $stm = TmCompraDetalle::where('id_compra',$cod)->get();
        
        foreach($stm as $k => $v){ 
            $stm[$k]->Pres = DB::select("SELECT cod_ins,nomb_ins,descripcion FROM v_busqins WHERE tipo_p = ?  AND id_ins = ?", [ $v->id_tp, $v->id_pres ] )[0];
        }
        //dd($stm);
        echo json_encode($stm);
    }

    public function buscarIns(Request $request){

        $post = $request->all();
        $criterio = $post['criterio'];

        //$data = DB::select("SELECT tipo_p,id_ins,cod_ins,nomb_ins,descripcion FROM v_busqins WHERE cod_ins LIKE '%?%' OR nomb_ins LIKE '%?%' ORDER BY nomb_ins LIMIT 5",[$criterio,$criterio]);
        $data = DB::select("SELECT tipo_p,id_ins,cod_ins,nomb_ins,descripcion FROM v_busqins WHERE cod_ins LIKE '%".$criterio."%' OR nomb_ins LIKE '%".$criterio."%' ORDER BY nomb_ins LIMIT 5");
        
        echo json_encode($data);
    }

    public function buscarProv(Request $request){

        $post = $request->all();
        $criterio = $post['criterio'];
        
        //$data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%?%' OR razon_social LIKE '%?%') ORDER BY ruc LIMIT 5",[$criterio,$criterio] );
        $data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%".$criterio."%' OR razon_social LIKE '%".$criterio."%') ORDER BY ruc LIMIT 5");
        
        echo json_encode($data);
    }

    public function nuevoProv(Request $request){
        //$data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%?%' OR razon_social LIKE '%?%') ORDER BY ruc LIMIT 5",[$criterio,$criterio] );
        //$data = DB::select("SELECT id_prov,ruc,razon_social FROM tm_proveedor WHERE estado <> 'i' AND (ruc LIKE '%".$criterio."%' OR razon_social LIKE '%".$criterio."%') ORDER BY ruc LIMIT 5");
        try
        {   
            $data = $request->all();
            dd($data);
            $arrayParam =  array(
                ':flag' => 1,
                ':ruc' => $data['ruc'],
                ':razS' => $data['razon_social'],
                ':direc' => $data['direccion'],
                ':telf' => $data['telefono'],
                ':email' => $data['email'],
                ':contc' => $data['contacto']
            );
            $st = DB::select("call usp_comprasRegProveedor_g( :flag, :ruc, :razS, :direc, :telf, :email, :contc, @a,:idSucursal);",$arrayParam);

            foreach ($st as $row) {
                return json_encode($row->dup);
            }


        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
        
        //echo json_encode($data);
    }

    public function GuardarCompra(Request $request)
    {
        try
        {  
            $dato = $request->all();     
            date_default_timezone_set('America/Lima');
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha_r = date("Y-m-d H:i:s");
            $igv = session("igv");
            $id_usu = session("id_usu");
            $fecha = date('Y-m-d',strtotime($dato['compra_fecha']));
            
            
            /*$arrayParam = array(
                $dato['cod_prov'],
                $dato['tipo_compra'],
                $dato['tipo_doc'],
                $id_usu,
                $fecha,
                $dato['compra_hora'],
                $dato['serie_doc'],
                $dato['num_doc'],
                $igv,
                $dato['monto_total'],
                $dato['desc_comp'],
                $dato['observaciones'],
                $fecha_r
            );*/
            //DB::insert("INSERT INTO tm_compra (id_prov,id_tipo_compra,id_tipo_doc,id_usu,fecha_c,hora_c,serie_doc,num_doc,igv,total,descuento,observaciones,fecha_reg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);",$arrayParam);
            /*$this->conexionn->prepare($sql)
                ->execute();*/
            
            $compra_id= DB::table('tm_compra')->insertGetId(array(
                'id_prov' =>$dato['cod_prov'],
                'id_tipo_compra'=>$dato['tipo_compra'],
                'id_tipo_doc'=>$dato['tipo_doc'],
                'id_usu'=>$id_usu,
                'fecha_c'=>$fecha,
                'hora_c'=>$dato['compra_hora'],
                'serie_doc'=>$dato['serie_doc'],
                'num_doc'=>$dato['num_doc'],
                'igv'=>$igv,
                'total'=>$dato['monto_total'],
                'descuento'=>$dato['desc_comp'],
                'observaciones'=>$dato['observaciones'],
                'fecha_reg'=>$fecha_r
            ));

            /* El ultimo ID que se ha generado */
           // $compra_id = $this->conexionn->lastInsertId();

            if($dato['tipo_compra'] == 2){

                $a = $dato['mmcuota'];
                $b = $dato['imcuota'];
                $c = $dato['fmcuota'];

                for($x=0; $x < sizeof($a); ++$x)
                {
                    //$sql = "INSERT INTO tm_compra_credito (id_compra,total,interes,fecha) VALUES (?,?,?,?);";
                    //$this->conexionn->prepare($sql)->execute(array($compra_id,$a[$x],$b[$x],date('Y-m-d',strtotime($c[$x]))));

                    DB::insert("INSERT INTO tm_compra_credito (id_compra,total,interes,fecha) VALUES (?,?,?,?);",array($compra_id,$a[$x],$b[$x],date('Y-m-d',strtotime($c[$x]))));
                }
            }

            /* Recorremos el detalle para insertar */
            foreach($dato['items'] as $d)
            {
                /*$sqll = "INSERT INTO tm_compra_detalle (id_compra,id_tp,id_pres,cant,precio) VALUES (?,?,?,?,?)";
                $this->conexionn->prepare($sqll)->execute(array($compra_id,$d['tipo_p'],$d['cod_ins'],$d['cant_ins'],$d['precio_ins']));*/
                DB::insert("INSERT INTO tm_compra_detalle (id_compra,id_tp,id_pres,cant,precio) VALUES (?,?,?,?,?)",array($compra_id,$d['tipo_p'],$d['cod_ins'],$d['cant_ins'],$d['precio_ins']));

                /*$sql = "INSERT INTO tm_inventario (id_ti,id_ins,id_tipo_ope,id_cv,cant,fecha_r) VALUES (?,?,?,?,?,?)";
                $this->conexionn->prepare($sql)->execute(array($d['tipo_p'],$d['cod_ins'],1,$compra_id,$d['cant_ins'],$fecha_r));*/
                DB::insert("INSERT INTO tm_inventario (id_ti,id_ins,id_tipo_ope,id_cv,cant,fecha_r) VALUES (?,?,?,?,?,?)",array($d['tipo_p'],$d['cod_ins'],1,$compra_id,$d['cant_ins'],$fecha_r));
            }

            return json_encode(true);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        //print_r(json_encode($this->model->GuardarCompra($_POST)));
    }

    public function AnularCompra(Request $request){

        try 
        {
            $data = $request->all();
            $cod_compra = $data['cod_compra'];

            $arrayParam =  array(
                ':flag' => 1,
                ':idCom' => $cod_compra
            );
            $row = DB::select("call usp_comprasAnular( :flag, :idCom);",$arrayParam)[0];
            
            /*$st = $this->conexionn->prepare($consulta);
            $st->execute($arrayParam);
            $row = $st->fetch(PDO::FETCH_ASSOC);*/
            //return $row;
            //$row = $this->model->AnularCompra($_REQUEST['cod_compra']);

            if ($row->dup == 1){
                //header('Location: lista_comp.php?m=c');
                $notification = [ 
                    'message' =>'Datos anulados, correctamente',
                    'alert-type' => 'success'
                ];
               return redirect('/compras')->with($notification);
            } else {
                $notification = [ 
                    'message' =>'Advertencia, La compra ya ha sido anulada.',
                    'alert-type' => 'warning'
                ];
                return redirect('/compras')->with($notification);
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
        
    }
}
