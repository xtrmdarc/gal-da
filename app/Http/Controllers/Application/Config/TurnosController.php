<?php

namespace App\Http\Controllers\Application\Config;

use App\Models\TmTurno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Sucursal;

class TurnosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index(){

        $viewdata = [];
        $user_AdminSucursal = auth()->user()->id_empresa;
        $user_sucursal = Sucursal::where('id_empresa', $user_AdminSucursal)->get();
        $viewdata['user_sucursal'] = $user_sucursal;

        $data = [
            'breadcrumb'=> 'config.Turnos',
            'titulo_vista' => 'Turnos'
        ];
        return view('contents.application.config.sist.turnos_del_dia',$viewdata)->with($data);
    }

    public function ListarTurnos()
    {
        $listar_turnos = TmTurno::where('id_sucursal','=',session('id_sucursal'))->get();

        //Admin
        $listar_turnos = DB::table('v_turnos_g')
                ->where('id_sucursal','=',session('id_sucursal'))
                ->get();

        echo json_encode($listar_turnos);
    }

    public function GuardarTurnos(Request $request)
    {
        $post = $request->all();
        $cod = $post['cod_turno'];

        if($cod != ''){
            //Update
            $nombre = $post['nomb_turno'];
            $h_inicio = $post['h_inicio_t'];
            $h_fin = $post['h_fin_t'];
            $idTurno = $cod;
            $idSucursal = $post['id_sucursal'];

            $sql = DB::update("UPDATE tm_turno SET
						descripcion  = ?,
					    id_sucursal  = ?,
                        h_inicio = ?,
						h_fin   = ?
				    WHERE id_turno = ?", [$nombre, $idSucursal, $h_inicio, $h_fin, $idTurno]);
            return $array['cod'] = 1;
        }else {
            //Create
            $nombre = $post['nomb_turno'];
            $h_inicio = $post['h_inicio_t'];
            $h_fin = $post['h_fin_t'];
            $idSucursal = $post['id_sucursal'];

            $consulta_create = TmTurno::create([
                'descripcion' => $nombre,
                'id_sucursal' => $idSucursal,
                'h_inicio' => $h_inicio,
                'h_fin' => $h_fin
            ]);
            return $array['cod'] = 2;
        }
    }

    public function EliminarTurno(Request $request)
    {
        $post = $request->all();
        $cod_turno_e = $post['cod_turno_e'];

        $consulta_eliminar = DB::delete("DELETE FROM tm_turno WHERE id_turno = ?",[($cod_turno_e)]);
        return back();
    }
}
