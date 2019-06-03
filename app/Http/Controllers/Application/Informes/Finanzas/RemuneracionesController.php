<?php

namespace App\Http\Controllers\Application\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Application\ExcelExports\ExportFromArray;
class RemuneracionesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
        $this->middleware('userRol');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_remu',
            'titulo_vista' => 'Informe remuneraciones'
        ];

        //Sucursales Filtro
        $sucursales_filtro = Sucursal::where('id_empresa',session('id_empresa'))->get();

        $viewdata['sucursales_filtro'] = $sucursales_filtro;
        return view('contents.application.informes.finanzas.inf_remuneraciones',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $stm = DB::Select("SELECT id_usu,id_sucursal,DATE(fecha_re) AS fecha_re,des_tg,desc_usu,desc_per,motivo,importe,estado FROM v_gastosadm WHERE id_tg = 3 AND DATE(fecha_re) >= ? AND DATE(fecha_re) <= ? and id_sucursal = ?",
            array($ifecha,$ffecha,session('id_sucursal')));
        //dd($stm);
        foreach($stm as $k => $d)
        {
            $stm[$k]->Caja =  DB::Select("SELECT desc_caja FROM v_caja_aper WHERE id_sucursal = ? AND DATE(fecha_a) = ?",[$d->id_sucursal,$d->fecha_re])[0];
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

            $stm = DB::Select("SELECT id_usu,id_sucursal,DATE(fecha_re) AS fecha_re,des_tg,desc_usu,desc_per,motivo,importe,estado FROM v_gastosadm WHERE id_tg = 3 AND DATE(fecha_re) >= ? AND DATE(fecha_re) <= ? and id_sucursal = ?",
                array($start,$end,session('id_sucursal')));

            ob_end_clean();
            ob_start();

            return Excel::download(new ExportFromArray($stm),'inf-remuneraciones-'.$start.'.xlsx');
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
}
