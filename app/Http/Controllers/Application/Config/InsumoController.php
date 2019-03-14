<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\TmInsumoCatg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;

class InsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('userRol');
    }
    public function index()
    {
        //ComboCatg
        $id_usu = \Auth::user()->id_usu;
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)
                                 ->where('id', session('id_sucursal'))->get();
        $id_sucursal = session('id_sucursal');

        $viewdata = [];

        $stm = TmInsumoCatg::where('id_sucursal',$id_sucursal)->get();
        $stm_unidadM = DB::Select("SELECT * FROM tm_tipo_medida");

        $viewdata['id_usu'] = $id_usu;
        $viewdata['user_sucursal'] = $user_sucursal;
        $viewdata['comboCatg'] = $stm;
        $viewdata['unidadM'] = $stm_unidadM;
        $viewdata['breadcrumb'] = 'config.Insumos';
        
        $data=[
            'breadcrumb' => 'config.Insumos',
            'titulo_vista' => 'Insumos'
        ];

        return view('contents.application.config.rest.insumo',$viewdata)->with($data);
    }

    public function ListaSucursalesInsum()
    {
        $id_sucursal = session('id_sucursal');

        $stm = DB::table('sucursal')
            ->leftJoin('tm_insumo_catg', 'sucursal.id', '=', 'tm_insumo_catg.id_sucursal')
            ->where('tm_insumo_catg.id_sucursal',$id_sucursal)
            ->get();

        $data = array("data" => $stm);

        $json = json_encode($data);
        echo $json;
    }

    public function ListaCatgs()
    {
        $id_sucursal = session('id_sucursal');
        $stm = DB::Select("SELECT * FROM tm_insumo_catg where id_sucursal = ?".$id_sucursal);

        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }
    public function CategoriasXSucursal(Request $request){
        
        $categorias = TmInsumoCatg::where('id_sucursal',$request->id_sucursal)->get();
        return $categorias;
    }
    
    public function ListaIns(Request $request)
    {
        $id_sucursal = session('id_sucursal');
        $post = $request->all();

        $cod = $post['cod'];
        $cat = $post['cat'];

        $stm = DB::Select("SELECT * FROM v_insumos WHERE id_ins like ? AND id_catg like ? and id_sucursal = ? ORDER BY id_ins DESC",
        array($cod,$cat,$id_sucursal));

        $data = array("data" => $stm);
        $json = json_encode($stm);
        echo $json;
    }

    public function CrudCatg(Request $request)
    {
        $id_sucursal = session('id_sucursal');

        $post = $request->all();

        $descC = $post['nombre_catg'];
        
        $idSucursal = $post['id_sucursal'];
        if($post['cod_catg'] != ""){
            //Actualizar
            $idCatg = $post['cod_catg'];
            $flag = 2;

            $consulta = DB::Select("call usp_configInsumoCatgs( :flag, :descC, :idCatg,:idSucursal,:idUsu);"
            ,array(':flag' => $flag,':descC'=> $descC,':idCatg'=>$idCatg,':idSucursal' => $idSucursal,':idUsu' => $id_usu));
            
            return json_encode($consulta[0]->cod);

            } else{
                //Crear
                $flag = 1;

                $consulta = DB::Select("call usp_configInsumoCatgs_g( :flag, :descC, @a,:idSucursal);"
                ,array(':flag' => $flag,':descC' => $descC, ':idSucursal' => $id_sucursal));
                $array = [];
                foreach($consulta as $k)
                {
                    return $array['cod'] = $k->cod;
                }
            }
    }

    public function CrudIns(Request $request)
    {
        $id_sucursal = session('id_sucursal');
        $post = $request->all();

       if($post['cod_ins'] != ''){
            //Actualizar
           $flag = 2;
           $idCatg = $post['cod_catg'];
           $idMed = $post['cod_med'];
           $cod = $post['codigo_ins'];
           $nombre = $post['nombre_ins'];
           $stock = $post['stock_min'];
           $estado = $post['estado'];
           $idIns = $post['cod_ins'];

           $sql = DB::update("UPDATE tm_insumo SET
						id_catg   = ?,
						id_med   = ?,
						cod_ins  = ?,
                        nomb_ins = ?,
                        stock_min = ?,
                        estado = ?
                    WHERE id_ins = ?",[$idCatg,$idMed,$cod,$nombre,$stock,$estado,$idIns]);
           return $array['cod'] = 2;
        } else{
            //Crear

           $idCatg = $post['cod_catg'];
           $idMed = $post['cod_med'];
           $cod = $post['codigo_ins'];
           $nombre = $post['nombre_ins'];
           $stock = $post['stock_min'];
           $estado = $post['estado'];
           $idIns = $post['cod_ins'];
           $flag = 1;

           $consulta = DB::Select("call usp_configInsumo_g( :flag, :idCatg, :idMed, :cod, :nombre, :stock, @a, @b,:idSucursal);",
               array(':flag' => $flag,':idCatg' => $idCatg,':idMed' => $idMed,':cod' => $cod,':nombre' => $nombre,':stock' =>$stock,':idSucursal' => $id_sucursal ));
           $array = [];
           foreach($consulta as $k)
           {
               return $array['cod'] = $k->cod;
           }
        }
    }
}
