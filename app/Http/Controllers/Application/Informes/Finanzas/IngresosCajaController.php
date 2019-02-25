<?php

namespace App\Http\Controllers\Application\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class IngresosCajaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_ingcaja',
            'titulo_vista' => 'Informe ingresos'
        ];
        return view('contents.application.informes.finanzas.inf_ingresos')->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($_POST['ffecha']));
        $stm = DB::Select("SELECT * FROM tm_ingresos_adm WHERE DATE(fecha_reg) >= ? AND DATE(fecha_reg) <= ? and id_sucursal = ?",
            array($ifecha,$ffecha,session('id_sucursal')));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Caja = DB::select("SELECT desc_caja FROM v_caja_aper WHERE id_apc = ".$d->id_apc)[0];
        }
        foreach($stm as $k => $d)
        {
            $stm[$k]->Cajero = DB::select("SELECT CONCAT(nombres,' ',ape_paterno,' ',ape_materno) AS desc_usu FROM tm_usuario WHERE id_usu = ".$d->id_usu)[0];
        }
        $data = array("data" => $stm);
        $json = json_encode($data);
        echo $json;
    }
    public function ExportExcel(Request $request)
    {
        try{

            $start = date('Y-m-d',strtotime($request->input('start')));
            $end = date('Y-m-d',strtotime($request->input('end')));

            $_SESSION["min-1"] = $_REQUEST['start'];
            $_SESSION["max-1"] = $_REQUEST['end'];

            $stm = DB::Select("SELECT fecha_reg as Fecha_de_Registro,tm_caja.descripcion as Caja,importe as Importe,motivo as Motivo,tm_ingresos_adm.estado as Estado,sucursal.nombre_sucursal as Nombre_de_Sucursal
                FROM tm_ingresos_adm
                left join sucursal on tm_ingresos_adm.id_sucursal = sucursal.id
                left JOIN tm_caja on tm_ingresos_adm.id_usu = tm_caja.id_usu
                WHERE DATE(fecha_reg) >= ? AND DATE(fecha_reg) <= ? and tm_ingresos_adm.id_sucursal = ?",
                array($start,$end,session('id_sucursal')));

            ob_end_clean();
            ob_start();

            return Excel::download(new ExportFromArray($stm),'inf-ingresos-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
