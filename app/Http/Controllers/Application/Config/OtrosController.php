<?php

namespace App\Http\Controllers\Application\Config;

use Illuminate\Http\Request;
use App\Models\Pais;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Application\AppController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OtrosController extends Controller
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
            'breadcrumb'=> 'ajustes',
            'titulo_vista' => 'Configuraciones'
        ];
        return view('contents.application.config.config')->with($data);
    }

    public function datosEmpresa(){

        $viewdata = [];

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
            $viewdata['paisEmpresa']= $r->id_pais;
        }

        $lista_paises = Pais::all();
        $viewdata['paises'] = $lista_paises;

        $identificacionTributaria = DB::table('identificacion_tributaria')
            ->leftjoin('empresa', 'identificacion_tributaria.code_country', '=', 'empresa.id_pais')
            ->select('identificacion_tributaria.code')
            ->where('identificacion_tributaria.code_country',$viewdata['paisEmpresa'])
            ->get();

        foreach($identificacionTributaria as $r) {
            $cod_tributario = $r->code;
        }

        if(isset($cod_tributario)){
            $viewdata['identificacionTributaria'] = $cod_tributario;
        }else {
            $viewdata['identificacionTributaria'] = 'Pais Externo';
        }


        if(is_null($viewdata['logo']) or $viewdata['logo'] == '') {
            $viewdata['logo'] = '';
            $viewdata['logo_g']= $viewdata['logo'];
        }else {
            $url = Storage::disk('s3')->url($viewdata['logo']);
            $viewdata['logo_g']= $url;
        }
        $data = [
            'breadcrumb'=>'config.DatosEmpresa',
            'titulo_vista' => 'Datos de empresa'
        ];
        return view('contents.application.config.sist.datos_emp',$viewdata)->with($data);
    }

    public function tiposdeDocumentos(){

        $data = [
            'breadcrumb'=> 'config.TiposdeDocumentos',
            'titulo_vista' => 'Tipos de documento'  
        ];
        return view('contents.application.config.sist.tipo_doc')->with($data);
    }

    public function ListarTD()
    {
        $stm = DB::Select("SELECT * FROM tm_tipo_doc where id_sucursal = ".session('id_sucursal'));
        echo json_encode($stm);
    }

    public function GuardarTD(Request $request)
    {
        $post = $request->all();
        $cod_td = $post['cod_td'];
        $serie = $post['serie'];
        $numero = $post['numero'];

        if($cod_td != '' and $serie != '' and $numero != ''){
            $sql = DB::update("UPDATE tm_tipo_doc SET serie = ?,numero = ? WHERE id_tipo_doc = ?",array($serie,$numero,$cod_td));
            return $array['cod'] = 1;
        }
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
        $id_pais = $post['country'];

        if($id != ''){
            $stm = DB::Select("SELECT * FROM empresa where id = ".$id);

            foreach($stm as $r) {
                $viewdata['logo']= $r->logo;
            }

            if(!(is_null($viewdata['logo']) or $viewdata['logo'] == '')) {
                $url = Storage::disk('s3')->delete($viewdata['logo']);
            }
            if($request->hasFile('logo')) {

                //get filename with extension
                $filenamewithextension = $request->file('logo')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('logo')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename.'_'.time().'.'.$extension;

                //Upload File to s3
                Storage::disk('s3')->put($filenametostore, fopen($request->file('logo'), 'r+'), 'public');

                //Store $filenametostore in the database
            } else {
                $filenametostore = $viewdata['logo'];
            }

            $sql = DB::update("UPDATE empresa SET
                    razon_social  = ?,
                    abrev_rs   = ?,
                    ruc   = ?,
                    telefono  = ?,
                    direccion = ?,
                    logo = ?,
                    igv = ?,
                    moneda = ?,
                    id_pais = ?
                WHERE id = ?",[$razon_social,$abrev_rs,$ruc,$telefono,$direccion,$filenametostore,$igv,$moneda,$id_pais,$id]);

            session(['datosempresa'=> json_decode(json_encode(AppController::DatosEmpresa(\Auth::user()->id_empresa),true))]);

            return redirect('/ajustesDatosEmpresa');
        }
    }

}
