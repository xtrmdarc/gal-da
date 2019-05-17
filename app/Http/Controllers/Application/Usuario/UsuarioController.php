<?php

namespace App\Http\Controllers\Application\Usuario;

use App\Models\Pais;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Culqi;
use App\Http\Controllers\Application\AppController;

class UsuarioController extends Controller
{
    private $SECRET_KEY = "sk_test_asQalOKDq7la1gKr";

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('afterRegister');
        $this->middleware('BasicFree');
        $this->middleware('vActualizacion');
    }
    public function i_perfil(){

        $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));

        $usuario = \Auth::user();
        $idUsu = \Auth::user()->id_usu;
        $plan_id_user = \Auth::user()->plan_id;
        $viewdata = [];

        $listar_telefonos_paises = Pais::all();

        $subscription = DB::table('subscription')
                        ->select('planes.nombre',DB::raw('CASE WHEN subscription.id_periodicidad = 0 THEN planes.precio_anual ELSE planes.precio_mensual END AS precio'),'subscription.id_periodicidad','subscription.ends_at','subscription.culqi_id','subscription.estado','subscription.plan_id')
                        ->leftJoin('planes','subscription.plan_id','planes.id')
                        ->where('id_usu',$usuario->id_usu)
                        ->where('plan_id',$usuario->plan_id)
                        ->first();
        //dd($subscription);
        $viewdata['subscription'] = $subscription;

        $viewdata['id_usu'] = $idUsu;
        $viewdata['cod_telefonos'] = $listar_telefonos_paises;

        $fecha_anio = date("Y");
        $fecha_mes = date("m");

        $nventas_mensual =  DB::select('SELECT count(*) as nventas_mensual FROM tm_venta v LEFT JOIN tm_usuario u ON u.id_usu = v.id_usu WHERE u.id_empresa = ?
        and MONTH(fecha_venta) = ? and YEAR(fecha_venta) = ?',[\Auth::user()->id_empresa,$fecha_mes,$fecha_anio])[0]->nventas_mensual;

        $testnVentas = $nventas_mensual;
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

        if($plan_id_user == 2 || $plan_id_user == 3) {

            $response = new \stdClass();
            try
            {
                $f_renovacion = date('d/m/Y',strtotime($subscription->ends_at));
                $viewdata['f_renovacio'] = $f_renovacion;

                //Traer Tarjeta
                $infoFact = DB::table('info_fact')->where('IdInfoFact', $usuario->info_fact_id)->first();
                $u_card = DB::table('u_card')->where('id_card', $usuario->id_card)->first();

                $respuesta = $response->cod = 1;

                $viewdata['card_brand']= $u_card->card_brand;
                $viewdata['card_number']= $u_card->card_last_four;
                $viewdata['r_cod']= $respuesta;
                $viewdata['info_fact']= $infoFact;
            }
            catch(\Exception $e)
            {
                $respuesta = $response->cod = 0;

                $viewdata['r_cod']= $respuesta;
                $viewdata['card_brand']= 'Ingresa';
                $viewdata['card_number']= 'una tarjeta';
                $viewdata['info_fact']= $infoFact;

                return view('contents.application.usuario.u_perfil',$viewdata);
            }
        }
        return view('contents.application.usuario.u_perfil',$viewdata);
    }

    public function i_perfilEditar(Request $request){

        $post = $request->all();

        $empresa = AppController::DatosEmpresa(session('id_empresa'));
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

            if ($request->hasFile('imagen_p')) {

                if (!(is_null($viewdata['imagen']) or $viewdata['imagen'] == '')) {
                    $url = Storage::disk('s3')->delete($viewdata['imagen']);
                }
                //get filename with extension
                $filenamewithextension = $request->file('imagen_p')->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $extension = $request->file('imagen_p')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $empresa->nombre_empresa.'/logo_u/'.$filename.'_'.time().'.'.$extension;
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

        $current_password = $post['current_pass'];
        $new_pass = $post['new_pass'];
        $confirm_pass = $post['confirm_pass'];

        $response = new \stdClass();

        $idPassword = \Auth::user()->password;
        /*
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
        */
        if (!password_verify($current_password, $idPassword)) {
            $response->cod = 0;
        } else {
            if($new_pass == $confirm_pass) {
                \Auth::user()->password = bcrypt($new_pass);
                \Auth::user()->save();
                $response->cod = 2;
            }else {
                $response->cod = 3;
            }
        }
        return json_encode($response);
    }

    public function actualizarTarjeta(Request $request){

        $data = $request->all();

        $response = new \stdClass();
        try
        {
            $usuario = \Auth::user();
            $culqi = new Culqi\Culqi(array('api_key' => $this->SECRET_KEY));

            if($usuario->id_card != ''){
                $card = $culqi->Cards->create(
                    array(
                        "customer_id" => $usuario->culqi_id,
                        "token_id" => $data['token']
                    )
                );

                DB::table('info_fact')->where('IdInfoFact',$usuario->info_fact_id)
                    ->update([
                        'CardId'=> $card->id
                    ]);

                //Traer Tarjeta
                $infoFact = DB::table('info_fact')->where('IdInfoFact', $usuario->info_fact_id)->first();
                $cardID = $infoFact->CardId;

                $culqui_card = $culqi->Cards->get("$cardID");

                $card_obj = json_encode($culqui_card);

                $source = $culqui_card->source;
                $iin = $source->iin;

                $last_four = $source->last_four;
                $card_brand = $iin->card_brand;

                DB::table('u_card')->where('id_card',$usuario->id_card)
                    ->update([
                        'CardId'=> $cardID,
                        'card_brand'=> $card_brand,
                        'card_last_four'=> $last_four
                    ]);
                $response->cod = 1;
                return json_encode($response);
            }
        }
        catch(\Exception $e)
        {
            $response->cod = 0;
            return json_encode($response);
        }
    }
}
