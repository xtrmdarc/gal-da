<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OtrosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {   
        $data = [
            'breadcrumb'=> 'ajustes'  
        ];
        return view('contents.application.config.config')->with($data);
    }

    public function datosEmpresa(){

        $viewdata = [];
        /*$stm = DB::Select("SELECT * FROM tm_datos_empresa");

        foreach($stm as $r) {
            $viewdata['id'] = $r->id;
            $viewdata['razon_social'] = $r->razon_social;
            $viewdata['abrev_rs']= $r->abrev_rs;
            $viewdata['ruc'] = $r->ruc;
            $viewdata['direccion']= $r->direccion;
            $viewdata['telefono']= $r->telefono;
            $viewdata['logo']= $r->logo;
            $viewdata['igv']= $r->igv;
            $viewdata['moneda']= $r->moneda;
        }

        $data = [
            'breadcrumb'=>'config.DatosEmpresa'
        ];
        return view('contents.application.config.sist.datos_emp',$viewdata)->with($data);
        */
        $id_empresa = \Auth::user()->id_empresa;

        $stm = DB::Select("SELECT * FROM empresa where id = ".$id_empresa);

        foreach($stm as $r) {
            $viewdata['id'] = $r->id;
            $viewdata['razon_social'] = $r->razon_social;
            $viewdata['abrev_rs']= $r->abrev_rs;
            $viewdata['ruc'] = $r->ruc;
            $viewdata['direccion']= $r->direccion;
            $viewdata['telefono']= $r->telefono;
            $viewdata['logo']= $r->logo;
            $viewdata['igv']= $r->igv;
            $viewdata['moneda']= $r->moneda;
        }

        $data = [
            'breadcrumb'=>'config.DatosEmpresa'
        ];
        return view('contents.application.config.sist.datos_emp',$viewdata)->with($data);
    }

    public function tiposdeDocumentos(){

        $data = [
            'breadcrumb'=> 'config.TiposdeDocumentos'  
        ];
        return view('contents.application.config.sist.tipo_doc')->with($data);
    }

    public function ListarTD()
    {
        $stm = DB::Select("SELECT * FROM tm_tipo_doc");
        echo json_encode($stm);
    }

    public function GuardarTD(Request $request)
    {
        $post = $request->all();
        $cod_td = $post['cod_td'];
        $serie = $post['serie'];
        $numero = $post['numero'];

        if($cod_td != '' and $serie != '' and $numero != ''){
            $sql = DB::Select("UPDATE tm_tipo_doc SET serie = ?,numero = ? WHERE id_tipo_doc = ?",array($serie,$numero,$cod_td));
            //return view('contents.config.sist.tipo_doc');
        }
        return back();
    }

    public function GuardarDE(Request $request){
        $post = $request->all();

        $id = $post['id'];
        $razon_social = $post['razon_social'];
        $abrev_rs = $post['abrev_rs'];
        $ruc = $post['ruc'];
        $moneda = $post['moneda'];
        $telefono = $post['telefono'];
        $direccion = $post['direccion'];
        $logo = $post['logo'];
        $igv = $post['igv'];

        /*if( !empty( $_FILES['logo']['name'] ) ){
            $logo = date('ymdhis') . '-' . strtolower($_FILES['logo']['name']);
            move_uploaded_file ($_FILES['logo']['tmp_name'], 'assets/img/' . $logo);
            $alm->__SET('logo', $logo);
        }*/

        if($id != ''){

           /* $sql = DB::Select("UPDATE tm_datos_empresa SET
						razon_social  = ?,
						abrev_rs   = ?,
						ruc   = ?,
						telefono  = ?,
                        direccion = ?,
                        logo = ?,
                        igv = ?,
                        moneda = ?
				    WHERE id = ?",[$razon_social,$abrev_rs,$ruc,$telefono,$direccion,$logo,$igv,$moneda,$id]);
*/

            $sql = DB::update("UPDATE empresa SET
						razon_social  = ?,
						abrev_rs   = ?,
						ruc   = ?,
						telefono  = ?,
                        direccion = ?,
                        logo = ?,
                        igv = ?,
                        moneda = ?
				    WHERE id = ?",[$razon_social,$abrev_rs,$ruc,$telefono,$direccion,$logo,$igv,$moneda,$id]);
            //return redirect()->route('config.DatosEmpresa');
            return redirect('/ajustesDatosEmpresa');
        }
    }

}
