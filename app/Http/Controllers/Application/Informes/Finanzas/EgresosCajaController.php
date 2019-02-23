<?php

namespace App\Http\Controllers\Application\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class EgresosCajaController extends Controller
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
            'breadcrumb'=>'inf_egrcaja',
            'titulo_vista' => 'Informe egresos'
        ];
        return view('contents.application.informes.finanzas.inf_egresos')->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $stm = DB::Select("SELECT * FROM v_gastosadm WHERE DATE(fecha_re) >= ? AND DATE(fecha_re) <= ? and id_sucursal = ?",
            array($ifecha,$ffecha,session('id_sucursal')));

        foreach($stm as $k => $d)
        {
            $stm[$k]->Caja = DB::Select("SELECT desc_caja FROM v_caja_aper WHERE id_apc = ".$d->id_apc)[0];
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

            $stm = DB::Select("SELECT * FROM v_gastosadm WHERE DATE(fecha_re) >= ? AND DATE(fecha_re) <= ? and id_sucursal = ?",
                array($start,$end,session('id_sucursal')));

            ob_end_clean();
            ob_start();

            return Excel::download(new ExportFromArray($stm),'inf-egresos-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
