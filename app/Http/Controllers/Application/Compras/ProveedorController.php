<?php

namespace App\Http\Controllers\Application\Compras;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TmProveedor;

class ProveedorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        
        $proveedores = TmProveedor::all();

        $data =[
            'proveedores' => $proveedores,
            'breadcrumb'=> 'proveedores'
        ];

        return view('contents.application.proveedor.index')->with($data);
    }

    public function crear(){
        
        $proveedor = new TmProveedor();

        $data =[
            'proveedor' => $proveedor,
            'breadcrumb'=> 'nproveedor'
        ];

        return view('contents.application.proveedor.editar')->with($data);
    }

    public function editar($id){
        
        $proveedor = TmProveedor::find($id);

        $data =[
            'proveedor' => $proveedor,
            'breadcrumb'=> 'eproveedor'
        ];

        return view('contents.application.proveedor.editar')->with($data);
    }

    public function RUProveedor(Request $request){
        
        /*$alm = new Proveedor();
        $alm->__SET('id_prov',    $_REQUEST['id_prov']);
        $alm->__SET('ruc',    $_REQUEST['ruc']);
        $alm->__SET('razon_social',    $_REQUEST['razon_social']);
        $alm->__SET('direccion',    $_REQUEST['direccion']);
        $alm->__SET('telefono',    $_REQUEST['telefono']);
        $alm->__SET('email',    $_REQUEST['email']);
        $alm->__SET('contacto',    $_REQUEST['contacto']);
        */
        try 
        { 
            $data = $request->all();
            if($data['id_prov'] != ''){
                $arrayParam =  array(
                    ':flag' => 2,
                    ':ruc' => $data['ruc'],
                    ':razS' => $data['razon_social'],
                    ':direc' => $data['direccion'],
                    ':telf' => $data['telefono'],
                    ':email' => $data['email'],
                    ':contc' => $data['contacto'],
                    ':idProv' => $data['id_prov']
                );
                
                DB::select("call usp_comprasRegProveedor( :flag, :ruc, :razS, :direc, :telf, :email, :contc, :idProv);",$arrayParam);
                
                /*$st = $this->conexionn->prepare($consulta);
                $st->execute($arrayParam);*/
                    
                //$this->model->Actualizar($data);
                //header('Location: lista_comp_prov.php?m=u');
                header('Location: /proveedores?m=u');

            } else {
            
                $arrayParam =  array(
                    ':flag' => 1,
                    ':ruc' => $data['ruc'],
                    ':razS' => $data['razon_social'],
                    ':direc' => $data['direccion'],
                    ':telf' => $data['telefono'],
                    ':email' => $data['email'],
                    ':contc' => $data['contacto']
                );

                $row = DB::select("call usp_comprasRegProveedor( :flag, :ruc, :razS, :direc, :telf, :email, :contc, @a);",$arrayParam)[0];
                
                /*$st = $this->conexionn->prepare($consulta);
                $st->execute($arrayParam);
                $row = $st->fetch(PDO::FETCH_ASSOC);
                return $row;*/
                
                //$row = $this->model->Registrar($data);


            if ($row->dup == 1){
                    //header('Location: lista_comp_prov.php?m=d');
                    header('Location: /proveedores?m=d');
                    
                } else {
                    //header('Location: lista_comp_prov.php?m=n');
                    header('Location: /proveedores?m=n');
                    
                }
            }
        } catch (Exception $e) 
        {
            die($e->getMessage());
        }

    }
    
    public function Estado(Request $request)
    { 
        try 
        {
            //$alm = new Proveedor();
            $data = $request->all();
            if ($data['estado']=='a' || $data['estado']=='i'){
                /*$alm->__SET('cod_prov',  $_REQUEST['cod_prov']);
                $alm->__SET('estado',     $_REQUEST['estado']);*/
                
                //$this->model->Estado($alm);

                TmProveedor::Where('id_prov',$data['cod_prov'])
                            ->update(['estado'=>$data['estado']]);
                /*$sql = "UPDATE tm_proveedor SET estado = ? WHERE id_prov = ?";
                $this->conexionn->prepare($sql)->execute(array($data->__GET('estado'),$data->__GET('cod_prov')));
                $this->conexionn=null;*/

                //header('Location: lista_comp_prov.php');
                header('Location: /proveedores');
                
            }else{
                //header('Location: lista_comp_prov.php');
                header('Location: /proveedores');
            }

        } catch (Exception $e) 
        {
            die($e->getMessage());
        }
    }
}
