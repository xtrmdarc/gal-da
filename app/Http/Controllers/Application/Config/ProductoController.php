<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;
use App\Models\TmProductoCatg;
use App\Models\TmAreaProd;

class ProductoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $id_usu = \Auth::user()->id_usu;
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();

        $viewdata = [];
        $stm = DB::select("SELECT * FROM tm_area_prod WHERE estado = 'a' and id_usu = ? ",[$id_usu]);

        $stmcatg = DB::Select("SELECT * FROM tm_producto_catg WHERE id_usu = ?",[$id_usu]);

        $viewdata['areasP'] = $stm;
        $viewdata['catgs'] = $stmcatg;
        $viewdata['id_usu'] = $id_usu;
        $viewdata['user_sucursal'] = $user_sucursal;
        $viewdata['breadcrumb'] = '';
        $data = [
            'breadcrumb' => 'config.Productos'
        ];

        return view('contents.application.config.rest.producto',$viewdata)->with($data);
    }

    public function EliminarP(){

    }

    public function ListaProd(Request $request)
    {
        $id_sucursal = \Auth::user()->id_sucursal;
        $post = $request->all();
        $cod = $post['cod'];
        $cat = $post['cat'];

        $stm = Db::Select("SELECT * FROM tm_producto WHERE id_prod like ? AND id_catg like ? and id_sucursal = ? ORDER BY id_prod DESC",
            array($cod,$cat,$id_sucursal));
        $data = array("data" => $stm);

        $json = json_encode($stm);
        echo $json;
    }

    public function ListaPres(Request $request)
    {
        $post = $request->all();

        $cod_prod = $post['cod_prod'];
        $cod_pres = $post['cod_pres'];

        $stm = DB::Select("SELECT * FROM tm_producto_pres WHERE id_prod LIKE ? AND id_pres LIKE ?",
            array($cod_prod,$cod_pres));

        foreach($stm as $k => $d)
        {
            $stm[$k]->{'TipoProd'} = DB::Select("SELECT id_tipo FROM tm_producto WHERE id_prod = ".$d->id_prod);
        }

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }

    public function ListaSucursalesProd()
    {
        $id_usu = \Auth::user()->id_usu;

        $stm = DB::table('sucursal')
            ->leftJoin('tm_producto_catg', 'sucursal.id', '=', 'tm_producto_catg.id_sucursal')
            ->where('tm_producto_catg.id_usu',$id_usu)
            ->get();

        $data = array("data" => $stm);

        $json = json_encode($data);
        echo $json;
    }

    public function ListaCatgs()
    {
        $stm = DB::Select("SELECT * FROM tm_producto_catg");

        $data = array("data" => $stm);

        $json = json_encode($data);
        echo $json;
    }

    public function CrudCatg(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;

        $post = $request->all();
        $idSucursal = $post['id_sucursal'];
        if($post['cod_catg'] != ""){
            $cod_catg = $post['cod_catg'];
            //Actualizar
            $flag = 2;
            $descC = $post['nombre_catg'];
            $idCatg = $post['cod_catg'];
           
            $consulta =  DB::Select("call usp_configProductoCatgs_g( :flag, :descC, :idCatg,:idSucursal,:idUsu);",
                array(':flag' => $flag,':descC'=> $descC,':idCatg'=>$idCatg,':idSucursal' => $idSucursal,':idUsu' => $id_usu));
        
            return json_encode($consulta[0]->cod);

        }else {
            //Crear
            $flag = 1;
            $descC = $post['nombre_catg'];
          

            $consulta = DB::Select("call usp_configProductoCatgs_g( :flag, :descC, @a,:idSucursal,:idUsu);",
                array(':flag' => $flag,':descC' => $descC,':idSucursal' => $idSucursal,':idUsu' => $id_usu));

            $array = [];
            foreach($consulta as $k)
            {
                return $array['cod'] = $k->cod;
            }
            }
    }

    public function ListaIngs()
    {

    }

    public function ComboCatg()
    {
        try
        {      
            $var = TmProductoCatg::where('id_sucursal',session('id_sucursal'))->get();
            
            echo '<select name="cod_catg" id="cod_catg" class="selectpicker show-tick form-control" data-live-search="true" autocomplete="off" title="Seleccionar" data-size="5">';
            foreach($var as $v){
                echo '<option value="'.$v['id_catg'].'">'.$v['descripcion'].'</option>';
            }
            echo " </select>";
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function ComboUniMed()
    {

    }

    public function BuscarIns()
    {

    }

    public function GuardarIng()
    {

    }

    public function UIng()
    {

    }

    public function EIng()
    {

    }

    public function AreasProdXSucursal(Request $request){
        
        $areas_prod = TmAreaProd::where('id_sucursal',$request->id_sucursal)->get();
        return $areas_prod;
    }

    public function CategoriasXSucursal(Request $request){
        
        $categorias = TmProductoCatg::where('id_sucursal',$request->id_sucursal)->get();
        return $categorias;
    }

    public function CrudProd(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();
        $id_sucursal_d = $post['id_sucursal_d'];
        /*
        $areasProduccion_d = DB::Select("SELECT * FROM tm_area_prod WHERE estado = 'a' and id_usu = ? and id_sucursal = ?;",
            array($id_usu,$id_sucursal_d));

        $data = array("data" => $areasProduccion_d);

        $json = json_encode($data);
        echo $json;*/
        
        $codProd = $post['cod_prod'];
        if($codProd != ''){
            //Actualizar
            $flag = 2;
            $idTipo = $post['tipo_prod'];
            $idCatg = $post['cod_catg'];
            $idArea = $post['cod_area'];
            $nombP = $post['nombre_prod'];
            $descP = $post['descripcion'];
            $estado = $post['estado_catg'];
            $idProd = $post['cod_prod'];

            $consulta = DB::Select("call usp_configProducto( :flag, :idTipo, :idCatg, :idArea, :nombP, :descP, :estado, :idProd);",
                array($flag,$idTipo,$idCatg,$idArea,$nombP,$descP,$estado,$idProd));
        } else{
            //Registrar
            $flag = 1;
            $idTipo = $post['tipo_prod'];
            $idCatg = $post['cod_catg'];
            $idArea = $post['cod_area'];
            $nombP = $post['nombre_prod'];
            $descP = $post['descripcion'];

            $consulta = DB::Select("call usp_configProducto_g( :flag, :idTipo, :idCatg, :idArea, :nombP, :descP, @a, @b,:idSucursal,:idUsu);",
            array(':flag' => $flag,':idTipo' => $idTipo,':idCatg' => $idCatg,':idArea' => $idArea,':nombP' => $nombP,':descP' => $descP,':idSucursal' => $id_sucursal_d,':idUsu' => $id_usu));
            }
            $array = [];
            foreach($consulta as $k)
            {
                return $array['cod'] = $k->cod;
            }
    }

    public function CrudPres(Request $request)
    {
        $post = $request->all();

        $idProd = $post['cod_producto'];
        $codP = $post['cod_produ'];
        $presP = $post['nombre_pres'];
        $precio = $post['precio_prod'];
        $rec = $post['id_rec'];
        $stock = $post['stock_min'];
        $estado = $post['estado_pres'];
        $idPres = $post['cod_pres'];

        if($post['cod_pres'] != ''){
            //Actualizar El error esta aqui de qu eno deja al transformado concha son
            $flag = 2;
            $consulta = DB::Select("call usp_configProductoPres( :flag, :idProd, :codP, :presP, :precio, :rec, :stock, :estado, :idPres);"
            ,array($flag,$idProd,$codP,$presP,$precio,$rec,$stock,$estado,$idPres));
            
            return json_encode($consulta[0]->cod);
        } else{
            //Registrar
            $flag = 1;
            $consulta = DB::Select("call usp_configProductoPres( :flag, :idProd, :codP, :presP, :precio, :rec, :stock, :estado, @a);"
            ,array(':flag' => $flag,':idProd' => $idProd,':codP' => $codP,':presP' => $presP,':precio' => $precio,':rec' => $rec,':stock' => $stock,':estado' => $estado));
            
            return json_encode($consulta[0]->cod);
        }
    }


}
