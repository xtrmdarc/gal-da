<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;

class CajaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $viewdata = [];
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();
        $viewdata['user_sucursal'] = $user_sucursal;
        $data = [
            'breadcrumb'=> 'config.Cajas'  
        ];
        return view('contents.application.config.rest.caja',$viewdata)->with($data);
    }

    public function ListaCajas()
    {
        $id_parent = \Auth::user()->parent_id;
        $id_rol = \Auth::user()->id_rol;
        $id_usu = \Auth::user()->id_usu;

        //Admin
        if(is_null($id_parent)){
            $data = DB::table('v_cajas_g')
                ->where('id_rol','=','1')
                ->where('id_usu',$id_usu)
                ->orWhere('id_rol','=','2')
                ->get();

            foreach($data as $k => $v){
                $data[$k]->id_rol_v = $id_rol;
            }
        } else {
            //Cajero
            $data = DB::table('v_cajas_g')
                ->where('id_rol','=','1')
                ->where('id_usu',$id_usu)
                ->orWhere('id_rol','=','2')
                ->get();
            foreach($data as $k => $v){
                $data[$k]->id_rol_v = $id_rol;
            }
        }

        echo json_encode($data);
    }

    public function CrudCaja(Request $request)
    {
        $id_usu = \Auth::user()->id_usu;
        $post = $request->all();

        $cod = $post['cod_caja'];
        if($cod != ''){
            //Update
            $flag = 2;
            $nombre = $post['nomb_caja'];
            $estado = $post['estado_caja'];
            $idCaja = $post['cod_caja'];
            $idSucursal = $post['id_sucursal'];

            //$consulta_update = DB::select('call usp_configCajas( :flag, :nombre, :estado, :idCaja)',array($flag, $nombre, $estado,$idCaja));
            $consulta_update = DB::select('call usp_configCajas_g( :flag, :nombre, :estado, :idCaja, :idUsu, :_idSucursal)'
                ,array(':flag' => $flag,':nombre' => $nombre,':estado' => $estado,':idCaja' => $idCaja,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            $array = [];
            foreach($consulta_update as $k)
            {
                return $array['cod'] = $k->cod;
            }
        }else {
            //Create
            $flag = 1;
            $nombre = $post['nomb_caja'];
            $estado = $post['estado_caja'];
            $idSucursal = $post['id_sucursal'];

            //$consulta_create = DB::select('call usp_configCajas( :flag, :nombre, :estado, @a)',array($flag, $nombre, $estado));
            $consulta_create = DB::select('call usp_configCajas_g( :flag, :nombre, :estado, @a, :idUsu, :_idSucursal)'
                ,array(':flag' => $flag,':nombre' => $nombre,':estado' => $estado,':idUsu' => $id_usu,':_idSucursal' => $idSucursal));
            $array = [];
            foreach($consulta_create as $k)
            {
                return $array['cod'] = $k->cod;
            }
        }
    }

    public function Eliminar(Request $request){

        $post = $request->all();

        $cod_caja = $post['cod_caja_e'];

        /*
        $consulta = DB::select("SELECT count(*) AS total FROM tm_caja WHERE id_caja = ?",[($cod_caja)]);
        foreach($consulta as $a){
            $con = $a->total;
        }
        if($con == '0') {
            $consulta_eliminar = DB::select("DELETE FROM tm_caja WHERE id_caja = ?",[($cod_caja)]);
            return redirect()->route('config.Caja.Eliminar');
        }else {
            //Ummm Revisar
            $consulta_eliminar = DB::select("DELETE FROM tm_caja WHERE id_caja = ?",[($cod_caja)]);
            return redirect()->route('config.Cajas');
        }
*/
    }
}
