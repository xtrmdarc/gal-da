<?php

namespace App\Http\Controllers\Application\Informes\Finanzas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sucursal;
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
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
    }
    public function index()
    {
        $data = [
            'breadcrumb'=>'inf_egrcaja',
            'titulo_vista' => 'Informe egresos'
        ];

        //Sucursales Filtro
        $sucursales_filtro = Sucursal::where('id_empresa',session('id_empresa'))->get();

        $viewdata['sucursales_filtro'] = $sucursales_filtro;
        return view('contents.application.informes.finanzas.inf_egresos',$viewdata)->with($data);
    }

    public function Datos(Request $request)
    {
        $post = $request->all();

        $ifecha = date('Y-m-d',strtotime($post['ifecha']));
        $ffecha = date('Y-m-d',strtotime($post['ffecha']));
        $sucu_filter = $post['sucu_filter'];

        $stm = DB::Select("SELECT * FROM v_gastosadm WHERE DATE(fecha_re) >= ? AND DATE(fecha_re) <= ? and id_sucursal like ? and id_empresa = ?",
            array($ifecha,$ffecha,$sucu_filter,session('id_empresa')));

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
            $sucu_filter = $request->input('sucu_filter');

            $_SESSION["min-1"] = $_REQUEST['start'];
            $_SESSION["max-1"] = $_REQUEST['end'];

            $stm = DB::Select("SELECT fecha_re as Fecha_de_Registro,desc_usu as Nombre_usuario,importe as Importe,motivo as Motivo,desc_per as Personal,
                des_td as Tipo_Documento,des_tg as Tipo_de_Gasto,
                serie_doc as Serie_Doc,
                num_doc as Numero_Doc,
                v_gastosadm.estado as Estado,
                nombre_sucursal as Nombre_de_Sucursal
                FROM v_gastosadm
                WHERE DATE(fecha_re) >= ? AND DATE(fecha_re) <= ?
                and v_gastosadm.id_sucursal like ? and id_empresa = ?;",
                array($start,$end,$sucu_filter,session('id_empresa')));

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
