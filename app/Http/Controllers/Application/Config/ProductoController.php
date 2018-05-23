<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $viewdata = [];
        $stm = DB::Select("SELECT * FROM tm_area_prod WHERE estado ='a'");
        $stmcatg = DB::Select("SELECT * FROM tm_producto_catg");

        $viewdata['areasP'] = $stm;
        $viewdata['catgs'] = $stmcatg;
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
        $post = $request->all();
        $cod = $post['cod'];
        $cat = $post['cat'];

        $stm = Db::Select("SELECT * FROM tm_producto WHERE id_prod like ? AND id_catg like ? ORDER BY id_prod DESC",
            array($cod,$cat));

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

    public function ListaCatgs()
    {
        $stm = DB::Select("SELECT * FROM tm_producto_catg");

        $data = array("data" => $stm);

        $json = json_encode($data);
        echo $json;
    }

    public function CrudCatg(Request $request)
    {
        $post = $request->all();
        $cod_catg = $post['cod_catg'];
        if($cod_catg != ''){
            //Actualizar
            $flag = 2;
            $descC = $post['nombre_catg'];
            $idCatg = $post['cod_catg'];

            $consulta =  DB::Select("call usp_configProductoCatgs( :flag, :descC, :idCatg);",
                array($flag,$descC,$idCatg));;
            dd($consulta);
            return $consulta;

        }else {
            //Crear
            $flag = 1;
            $descC = $post['nombre_catg'];

            $consulta = DB::Select("call usp_configProductoCatgs( :flag, :descC, @a);",
                array(':flag' => $flag,':descC' => $descC));
            return $consulta;
            }
    }

    public function ListaIngs()
    {

    }

    public function ComboCatg()
    {
       //POR LAS :v
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

    public function CrudProd(Request $request)
    {
        $post = $request->all();
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

            $consulta = DB::Select("call usp_configProducto( :flag, :idTipo, :idCatg, :idArea, :nombP, :descP, @a, @b);",
            array($flag,$idTipo,$idCatg,$idArea,$nombP,$descP));
            }
    }

    public function CrudPres(Request $request)
    {
        $post = $request->all();
        dd($post);
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
            dd($consulta);
            return $consulta;
        } else{
            //Registrar
            $flag = 1;
            $consulta = DB::Select("call usp_configProductoPres( :flag, :idProd, :codP, :presP, :precio, :rec, :stock, :estado, @a);"
            ,array($flag,$idProd,$codP,$presP,$precio,$rec,$stock,$estado));
            dd($consulta);
            return $consulta;
        }
    }


}
