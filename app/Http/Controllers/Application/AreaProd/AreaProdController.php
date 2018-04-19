<?php

namespace App\Http\Controllers\Application\AreaProd;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaProdController extends Controller
{
    //
    public function index(){
        $data = [
            'breadcrumb' => ''
        ];

        return view('contents.application.areaprod.areaprod')->with($data);
    }

    public function ListarM(){
        
        try
        {   
            $id_areap = session('id_areap');
            $c = DB::select("SELECT * FROM v_cocina_me WHERE id_areap = ? AND cantidad > 0 ORDER BY fecha_pedido ASC",[$id_areap]);
            
            foreach($c as $k => $d)
            {   

                $c[$k]->Total = DB::select("SELECT COUNT(id_pedido) AS nro_p FROM v_cocina_me WHERE cantidad > 0 AND id_areap = ?",[$id_areap])[0];
                
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
            $c = DB::select("SELECT * FROM v_cocina_mo WHERE id_areap = ? ORDER BY fecha_pedido ASC",[$id_areap]);
            
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT COUNT(id_pedido) AS nro_p FROM v_cocina_mo WHERE estado <> 'c' AND estado <> 'i' AND id_areap = ?",[$id_areap])[0];
                    

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
            //$id_areap= 1;
            $c = DB::select("SELECT * FROM v_cocina_de WHERE id_areap = ? ORDER BY fecha_pedido ASC",[$id_areap]);
           
            foreach($c as $k => $d)
            {
                $c[$k]->Total = DB::select("SELECT COUNT(id_pedido) AS nro_p FROM v_cocina_de WHERE estado <> 'c' AND estado <> 'i' AND id_areap = ?",[$id_areap])[0];
                    

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
            date_default_timezone_set('America/Lima');
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            //$sql = "UPDATE tm_detalle_pedido SET estado = 'p', fecha_envio = ? WHERE id_pedido = ? AND id_prod = ? AND fecha_pedido = ?";
            DB::table('tm_detalle_pedido')  -> where(['id_pedido'=>$data['cod_ped'],'id_prod'=> $data['cod_prod'],'fecha_pedido'=>$data['fecha_p']])
                                            ->update(['estado'=>'p','fecha_envio'=>$fecha]);
            /* $this->conexionn->prepare($sql)
              ->execute(array(
                $fecha,
                $data['cod_ped'],
                $data['cod_prod'],
                $data['fecha_p']
                 ));*/
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

        print_r(json_encode($this->model->Preparacion($_POST)));

    }

    public function Atendido(Request $request){
        
        try
        {   
            date_default_timezone_set('America/Lima');
            setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
            $fecha = date("Y-m-d H:i:s");

            //$sql = "UPDATE tm_detalle_pedido SET estado = 'p', fecha_envio = ? WHERE id_pedido = ? AND id_prod = ? AND fecha_pedido = ?";
            DB::table('tm_detalle_pedido')  -> where(['id_pedido'=>$data['cod_ped'],'id_prod'=> $data['cod_prod'],'fecha_pedido'=>$data['fecha_p']])
                                            ->update(['estado'=>'c','fecha_envio'=>$fecha]);
/*            $this->conexionn->prepare($sql)
              ->execute(array(
                $fecha,
                $data['cod_ped'],
                $data['cod_prod'],
                $data['fecha_p']
                 ));*/
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

}
