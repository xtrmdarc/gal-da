<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\TmProducto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;
use App\Models\TmProductoCatg;
use App\Models\TmAreaProd;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
    }
    public function index()
    {
        $id_usu = \Auth::user()->id_usu;
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)
                                 ->where('id', session('id_sucursal'))->get();

        $viewdata = [];
        $stm = DB::select("SELECT * FROM tm_area_prod WHERE estado = 'a' and id_usu = ? ",[$id_usu]);

        $stmcatg = DB::Select("SELECT * FROM tm_producto_catg WHERE id_usu = ?",[$id_usu]);

        $viewdata['areasP'] = $stm;
        $viewdata['catgs'] = $stmcatg;
        $viewdata['id_usu'] = $id_usu;
        $viewdata['user_sucursal'] = $user_sucursal;
        $viewdata['breadcrumb'] = '';
        $data = [
            'breadcrumb' => 'config.Productos',
            'titulo_vista' => 'Productos'
        ];

        return view('contents.application.config.rest.producto',$viewdata)->with($data);
    }

    public function EliminarP(){

    }

    public function ListaProd(Request $request)
    {
        $id_sucursal = session('id_sucursal');
        $post = $request->all();
        $cod = $post['cod'];
        $cat = $post['cat'];

        $stm = DB::Select("SELECT * FROM tm_producto WHERE id_prod like ? AND id_catg like ? and id_sucursal = ? ORDER BY id_prod DESC",
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
            $stm[$k]->TipoProd = DB::Select("SELECT id_tipo FROM tm_producto WHERE id_prod = ".$d->id_prod);
        }

        $data = array("data" => $stm);
        //dd($stm,$data);
        $json = json_encode($stm);
        echo $json;
    }

    public function ListaSucursalesProd()
    {
        $id_usu = \Auth::user()->id_usu;

        $stm = DB::table('sucursal')
            ->leftJoin('tm_producto_catg', 'sucursal.id', '=', 'tm_producto_catg.id_sucursal')
            ->where('tm_producto_catg.id_sucursal',session('id_sucursal'))
            ->get();

        $data = array("data" => $stm);

        $json = json_encode($data);
        echo $json;
    }

    public function ListaCatgs()
    {
        $id_sucursal = \Auth::user()->id_sucursal;
        $stm = DB::Select("SELECT * FROM tm_producto_catg where id_sucursal = ?".$id_sucursal);

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

    public function ListaIngs(Request $request)
    {
        $post = $request->all();

        try
        {
            $stm = DB::Select("SELECT * FROM tm_producto_ingr WHERE id_pres = ?",[$post["cod"]]);

            foreach($stm as $k => $d)
            {
                $stm[$k]->Insumo = DB::Select("SELECT desc_m,nomb_ins FROM v_insumos WHERE id_ins = ? and id_sucursal = ?",[$d->id_ins,session('id_sucursal')]);
            }
            foreach($stm as $k => $d)
            {
                $stm[$k]->Medida = DB::Select("SELECT descripcion FROM tm_tipo_medida WHERE id_med = ? ",[$d->id_med]);
            }

            $data = array("data" => $stm);
            $json = json_encode($data);
            echo $json;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
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

    public function ComboUniMed(Request $request)
    {
        $post = $request->all();
        $va1 = $post["va1"];
        $va2 = $post["va2"];

        try
        {
            $stmm = DB::Select("SELECT * FROM tm_tipo_medida WHERE grupo = ? OR grupo = ?",[$va1,$va2]);

            foreach($stmm as $v){
                echo '<option value="'.$v->id_med.'">'.$v->descripcion.'</option>';
            }
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }

    }

    public function BuscarIns(Request $request)
    {
        $post = $request->all();
        $criterio = $post["criterio"];
        try
        {
            $stm = DB::Select("SELECT * FROM v_insumos WHERE (nomb_ins LIKE '%".$criterio."%' OR cod_ins LIKE '%".$criterio."%')
                               AND estado <> 'i' and id_sucursal = ?  ORDER BY nomb_ins LIMIT 5",
                               [session('id_sucursal')]);

            $json = json_encode($stm);
            echo $json;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    public function GuardarIng(Request $request)
    {
        $post = $request->all();
        $cod_pre = $post["cod_pre"];
        $ins_cod = $post["ins_cod"];
        $cod_med = $post["cod_med"];
        $ins_cant = $post["ins_cant"];

        try
        {
            $consulta = DB::statement("call usp_configProductoIngrs( :flag, :idPres, :idIns, :idMed, :cant, :idPi);"
                                    ,array(':flag' => 1,':idPres' => $cod_pre, ':idIns' => $ins_cod, ':idMed' => $cod_med, ':cant' => $ins_cant,':idPi' => 1));
            $array = [];
            return $array['datos'] = "1";
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function UIng()
    {

    }

    public function EIng(Request $request)
    {
        $post = $request->all();
        $cod = $post["cod"];

        try
        {
            $consulta = DB::statement("call usp_configProductoIngrs( :flag, :idPres, :idIns, :idMed, :cant, :idPi);"
                ,array(':flag' => 3,':idPres' => 1, ':idIns' => 1, ':idMed' => 1, ':cant' => 1,':idPi' => $cod));
            $array = [];
            return $array['datos'] = "1";
        }
        catch (Exception $e)
        {
            return false;
        }
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

            $sql = DB::update("UPDATE tm_producto SET
						id_tipo  = ?,
						id_catg   = ?,
						id_areap   = ?,
						nombre  = ?,
                        descripcion = ?,
                        estado = ?
                    WHERE id_prod = ?",[$idTipo,$idCatg,$idArea,$nombP,$descP,$estado,$idProd]);
            return $array['cod'] = 2;
        } else{
            //Registrar
            $flag = 1;
            $idTipo = $post['tipo_prod'];
            $idCatg = $post['cod_catg'];
            $idArea = $post['cod_area'];
            $nombP = $post['nombre_prod'];
            $descP = $post['descripcion'];
            //dd($id_sucursal_d);
            $consulta = DB::Select("call usp_configProducto_g( :flag, :idTipo, :idCatg, :idArea, :nombP, :descP, @a, @b,:idSucursal,:idUsu);",
            array(':flag' => $flag,':idTipo' => $idTipo,':idCatg' => $idCatg,':idArea' => $idArea,':nombP' => $nombP,':descP' => $descP,':idSucursal' => $id_sucursal_d,':idUsu' => $id_usu));

            $array = [];
            foreach($consulta as $k) {
                return $array['cod'] = $k->cod;
            }
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
            ,array(':flag' => $flag,':idProd' => $idProd,':codP' => $codP,':presP' => $presP,':precio' => $precio,':rec' => $rec,':stock' => $stock, ':estado' =>   $estado,':idPres' => $idPres));
            
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
