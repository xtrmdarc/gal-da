<?php

namespace App\Http\Controllers\Application\Usuario;

use App\Models\Pais;
use App\Models\TmUsuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
    }
    public function i_perfil(){

        $idUsu = \Auth::user()->id_usu;
        $viewdata = [];

        $listar_telefonos_paises = Pais::all();

        $viewdata['id_usu'] = $idUsu;
        $viewdata['cod_telefonos'] = $listar_telefonos_paises;

        $nventas =  DB::select('SELECT count(*) as nventas FROM tm_venta v LEFT JOIN tm_usuario u ON u.id_usu = v.id_usu WHERE u.id_empresa = ?',[\Auth::user()->id_empresa])[0]->nventas;
        $testnVentas = $nventas;
        $viewdata['nventas'] = $testnVentas;

        $usuario_perfil = DB::select("SELECT * FROM tm_usuario WHERE id_usu = ?",[($idUsu)]);
        $viewdata['usuario_perfil'] = $usuario_perfil;

        foreach($usuario_perfil as $r) {
            $viewdata['nombres'] = $r->nombres;
            $viewdata['ape_paterno'] = $r->ape_paterno;
            $viewdata['ape_materno']= $r->ape_materno;
            $viewdata['email'] = $r->email;
            $viewdata['phone']= $r->phone;
            $viewdata['codigo_phone']= $r->codigo_phone;
            $viewdata['dni']= $r->dni;
            $viewdata['imagen']= $r->imagen;
        }

        if(is_null($viewdata['imagen']) or $viewdata['imagen'] == '') {
            $viewdata['imagen'] = '';
            $viewdata['imagen_g']= $viewdata['imagen'];
        }else {
            $url = Storage::disk('s3')->url($viewdata['imagen']);
            $viewdata['imagen_g']= $url;
        }

        return view('contents.application.usuario.u_perfil',$viewdata);
    }

    public function i_perfilEditar(Request $request){

        $post = $request->all();

        $idUsu = \Auth::user()->id_usu;
        $nombres = $post['nombres_p'];
        $ape_paterno = $post['a_paterno_p'];
        $ape_materno = $post['a_materno_p'];
        $dni = $post['dni_p'];
        $email = $post['email_p'];
        $imagen_p = $post['imagen_p'];
        $code_phone = $post['cod_phone'];
        $phone = $post['telefono_p'];

        if($idUsu != '') {
            $stm = DB::Select("SELECT * FROM tm_usuario where id_usu = " . $idUsu);

            foreach ($stm as $r) {
                $viewdata['imagen'] = $r->imagen;
            }

            if (!(is_null($viewdata['imagen']) or $viewdata['imagen'] == '')) {
                $url = Storage::disk('s3')->delete($viewdata['imagen']);
            }
            if ($request->hasFile('imagen_p')) {

                //get filename with extension
                $filenamewithextension = $request->file('imagen_p')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('imagen_p')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename . '_' . time() . '.' . $extension;

                //Upload File to s3
                Storage::disk('s3')->put($filenametostore, fopen($request->file('imagen_p'), 'r+'), 'public');

                //Store $filenametostore in the database
            } else {
                $filenametostore = $viewdata['imagen'];
            }

            $sql = DB::update("UPDATE tm_usuario SET
						nombres  = ?,
					    ape_paterno  = ?,
                        ape_materno = ?,
						dni   = ?,
                        email = ?,
                        imagen = ?,
                        phone = ?,
                        codigo_phone = ?
				    WHERE id_usu = ?", [$nombres, $ape_paterno, $ape_materno, $dni, $email, $filenametostore, $phone,$code_phone, $idUsu]);
            return redirect()->route('ajustes.i_perfil');
        }
    }

    public function i_pago(){
        return view('contents.application.usuario.u_pago');
    }

    public function i_suscripcion(){
        return view('contents.application.usuario.u_suscripcion');
    }

    public function changePassword(Request $request){
        $post = $request->all();

        $idPassword = \Auth::user()->password;
        if (!password_verify($request->input('data.user.current_password'), $idPassword)) {
            dd('Invalid password.');//Verificar
        } else {
            //dd('Password is valid!');
            foreach ($request->toArray()['data']['user'] as $field => $value) {
                //dd($value);
                switch ($field) {
                    case 'current_password':
                        break;
                    case 'password_confirmation':
                        break;
                    case 'password':
                        if (!empty($value)) {
                            \Auth::user()->password = bcrypt($value);
                        }
                        break;
                    default:
                        \Auth::user()->password = bcrypt($value);
                        break;
                }
            }

            \Auth::user()->save();
            return redirect()->route('ajustes.i_perfil');
        }
    }
}
