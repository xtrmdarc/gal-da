<?php

namespace App\Http\Controllers\Web;

use App\Models\Empresa;
use App\Models\Pais;
use App\Models\Sucursal;
use App\Models\TmAlmacen;
use App\Models\TmAreaProd;
use App\Models\TmTipoDoc;
use App\Models\TmUsuario;
use App\Models\TmCaja;
use App\Models\TmTurno;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Application\AppController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()     {         
        $this->middleware('afterRegister');
        $this->middleware('auth', ['only' => ['show_account_info_v', 'store_account_info','show_account_business_v','store_account_business','verifyEmailFirst']]);
    }

    public function show_account_v($email=null) {
        $data = [];
        if(isset($email))
        $data = ['email'=> $email ];
        return view('auth.register.register-step-account')->with($data);
    }

    public function store_account(Request $request)
    {
        $post = $request->all();

        if(TmUsuario::Where('email',$post['email'])->exists()){
            $errors = [];
            $errors[] = 'Ya existe el correo en nuestros registros.';
            if(count($errors) > 0) {
                return view('auth.register.register-step-account')->withErrors($errors);
            }
            else {
                return view('auth.register.register-step-account');
            }
        }else {
            $empresa = Empresa::create([
                'nombre_empresa' => $post['name_business']
            ]);

            $statement = DB::select("SHOW TABLE STATUS LIKE 'empresa'");
            $empresaid = $statement[0]->Auto_increment;
            $empresa_id = $empresaid - 1;

            $statement = DB::select("SHOW TABLE STATUS LIKE 'sucursal'");
            $sucursalid = $statement[0]->Auto_increment;
            $sucursal_id = $sucursalid ;

            $user = TmUsuario::create([
                'id_areap' => '0',
                'id_rol' => '1',
                'estado' => 'p',
                'name_business' => $post['name_business'],
                'email' => $post['email'],
                'plan_id' => '1',
                'password' => bcrypt($post['password']),
                'status' => '0',
                'verifyToken' => Str::random(40),
                'id_sucursal' => $sucursal_id,
                'id_empresa' => $empresa_id,
            ]);

            $statement = DB::select("SHOW TABLE STATUS LIKE 'tm_usuario'");
            $userid = $statement[0]->Auto_increment;
            $user_id = $userid - 1;

            $sucursal = Sucursal::create([
                'id_empresa' => $empresa_id,
                'id_usu' => $user_id,
                'nombre_sucursal' => $post['name_business'],
            ]);

            $almacen = TmAlmacen::create([
                'nombre' => 'ALMACEN 1',
                'estado' => 'a',
                'id_sucursal' => $sucursal_id,
                'id_usu' => $user_id,
            ]);

            $statement = DB::select("SHOW TABLE STATUS LIKE 'tm_almacen'");
            $almacenId = $statement[0]->Auto_increment;
            $almacen_Id = $almacenId - 1;

            $are_prod = TmAreaProd::create([
                'id_alm' => $almacen_Id,
                'nombre' => 'COCINA 1',
                'estado' => 'a',
                'id_sucursal' => $sucursal_id,
                'id_usu' => $user_id,
            ]);
                
            $caja = TmCaja::create([
                'descripcion' => 'CAJA 1',
                'estado' => 'a',
                'id_sucursal' => $sucursal_id,
                'id_usu' => $user_id,
            ]);

            //4 Tipos de Documentos
            $tipo_doc_boleta = TmTipoDoc::create([
                'descripcion' => 'BOLETA',
                'serie' => '001',
                'numero' => '0000001',
                'id_sucursal' => $sucursal_id,
            ]);
            $tipo_doc_factura = TmTipoDoc::create([
                'descripcion' => 'FACTURA',
                'serie' => '001',
                'numero' => '0000001',
                'id_sucursal' => $sucursal_id,
            ]);
            $tipo_doc_ticket = TmTipoDoc::create([
                'descripcion' => 'TICKET',
                'serie' => '001',
                'numero' => '0000001',
                'id_sucursal' => $sucursal_id,
            ]);
            $tipo_doc_otros = TmTipoDoc::create([
                'descripcion' => 'OTROS',
                'serie' => '001',
                'numero' => '0000001',
                'id_sucursal' => $sucursal_id,
            ]);
            //Turnos
            $primer_turno = TmTurno::create([
                'descripcion' => 'PRIMER T.',
                'id_sucursal' => $sucursal_id,
                'h_inicio' => '06:00',
                'h_fin' => '12:00'
            ]);
            $segundo_turno = TmTurno::create([
                'descripcion' => 'SEGUNDO T.',
                'id_sucursal' => $sucursal_id,
                'h_inicio' => '13:00',
                'h_fin' => '18:00'
            ]);
            $tercer_turno = TmTurno::create([
                'descripcion' => 'TERCER T.',
                'id_sucursal' => $sucursal_id,
                'h_inicio' => '19:00',
                'h_fin' => '24:00'
            ]);
            //crear Mozo
            TmUsuario::create([
                'id_areap' => '0',
                'id_rol' => 4,
                'dni' => '',
                'parent_id' => $user->id_usu,
                'estado' => 'a',
                'nombres' => 'Jose',
                'ape_paterno' => 'Mozo',
                'ape_materno' => 'Mozo',
                //'email' => $email,
                'plan_id' => '1',
                //'password' => bcrypt($contrasena),
                'usuario' => 'mozo@'.$post['name_business'],
                'verifyToken' => null,
                'id_sucursal' => $sucursal_id,
                'id_empresa' => $empresa_id,
                'status'=> 1,
                'pin' => '1234'
            ]);
            //Crear Cajero
            TmUsuario::create([
                'id_areap' => '0',
                'id_rol' => 2,
                'dni' => '',
                'parent_id' => $user->id_usu,
                'estado' => 'a',
                'nombres' => 'Luis',
                'ape_paterno' => 'Cajero',
                'ape_materno' => 'Cajero',
                //'email' => $email,
                'plan_id' => '1',
                //'password' => bcrypt($contrasena),
                'usuario' => 'cajero@'.$post['name_business'],
                'verifyToken' => null,
                'id_sucursal' => $sucursal_id,
                'id_empresa' => $empresa_id,
                'status'=> 1,
                //'pin' => '1234'
            ]);
            //Crear Produccion
            TmUsuario::create([
                'id_areap' => $are_prod->id_areap,
                'id_rol' => 3,
                'dni' => '',
                'parent_id' => $user->id_usu,
                'estado' => 'a',
                'nombres' => 'Emilio',
                'ape_paterno' => 'Cocina',
                'ape_materno' => 'Cocina',
                //'email' => $email,
                'plan_id' => '1',
                //'password' => bcrypt($contrasena),
                'usuario' => 'cocina@'.$post['name_business'],
                'verifyToken' => null,
                'id_sucursal' => $sucursal_id,
                'id_empresa' => $empresa_id,
                'status'=> 1,
                //'pin' => '1234'
            ]);


            $thisUser = TmUsuario::findOrFail($user->id_usu);


            $this->senEmail($thisUser);

            return $this->verifyEmailFirst($thisUser);
        }
    }

    public function reSendVerifyEmail(Request $request){
        $data = $request->all();
        $usuario = TmUsuario::findOrFail($data['id_user']);
        $this->senEmail($usuario);
        return json_encode(1);
    }

    public function senEmail($thisUser)
    {
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }

    public function verifyEmailFirst($thisUser)
    {   

        return view('contents.home.thanks_register')->with(['user' => $thisUser]);
    }
    
    public function sendEmailDone($email,$verifyToken)
    {
        $user = TmUsuario::where(['email' => $email, 'verifyToken' => $verifyToken])->first();

        if($user) {
            $validacion =  TmUsuario::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['status' => '1','verifyToken' => NULL]);
            if($validacion == 1){
                return view('contents.home.cuenta_verificada');
            }
        }else {
            //dd('Usuario no existe o ya verificaste.');
            return view('contents.home.cuenta_verificada_2');
        }
    }

    public function show_account_info_v() {

        $idUsu = \Auth::user()->id_usu;
        $viewdata = [];

        $usuario_perfil = DB::select("SELECT * FROM tm_usuario WHERE id_usu = ?",[($idUsu)]);
        $viewData['usuario_perfil'] = $usuario_perfil;

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

        $lista_paises = Pais::all();
        $viewdata['cod_telefonos'] = $lista_paises;

        $viewdata['paises'] = $lista_paises;

        return view('auth.register.register-step-account-info',$viewdata);
    }

    public function store_account_info(Request $request)
    {
        $post = $request->all();

        $id_empresa = \Auth::user()->id_empresa;
        $stm = DB::Select("SELECT * FROM empresa where id = ?",[$id_empresa]);

        $idUsu = \Auth::user()->id_usu;
        $nombres = $post['name'];
        $ape_paterno = $post['lastname'];
        $ape_materno = $post['m_lastname'];
        $dni = $post['dni'];
        $phone = $post['phone'];
        $codePhone = $post['cod_phone'];
        $country = $post['country'];

        $sql = DB::update("UPDATE tm_usuario SET
						nombres  = ?,
					    ape_paterno  = ?,
                        ape_materno = ?,
						dni   = ?,
                        phone = ?,
                        codigo_phone = ?,
                        codigo_pais = ?
				    WHERE id_usu = ?", [$nombres, $ape_paterno, $ape_materno, $dni, $phone,$codePhone, $country, $idUsu]);

        foreach($stm as $r) {
            $id = $r->id;
        }

        $sql2 = DB::update("UPDATE empresa SET
                    id_pais = ?
                WHERE id = ?",[$country,$id]);

        return redirect()->route('registerBusiness');
    }

    public function show_account_business_v() {
        return view('auth.register.register-step-account-registerBusiness');
    }
    public function store_account_business(Request $request)
    {
        $post = $request->all();

        $idUsu = \Auth::user()->id_usu;
        $planId = \Auth::user()->plan_id;
        $empresaId = \Auth::user()->id_empresa;
        $sucursalId = \Auth::user()->id_sucursal;

        $nombre_negocio = $post['name_business'];

        if($nombre_negocio == ''){
            $errors = [];
            $errors[] = 'Completa el nombre de tu negocio.';
            if(count($errors) > 0) {
                return view('auth.register.register-step-account-registerBusiness')->withErrors($errors);
            }
        }else {
            $sql = DB::update("UPDATE tm_usuario SET
						name_business  = ?,
						estado = ?
				    WHERE id_usu = ?", [$nombre_negocio,'a',$idUsu]);

            $sql = DB::update("UPDATE empresa SET
						nombre_empresa  = ?
				    WHERE id = ?", [$nombre_negocio,$empresaId]);

            $sql = DB::update("UPDATE sucursal SET
						nombre_sucursal  = ?
                    WHERE id = ?", [$nombre_negocio,$sucursalId]);

            //return redirect()->route('tableroF');
            //dd(\Auth::user());
            return AppController::LoginAuthenticated($request,\Auth::user());

            /*if($planId == '1'){
                return redirect()->route('tableroF');
            }else {
                return redirect()->route('tablero');
            }
            */
        }
    }

    public function verificarTokenSubUsuario($email,$verifyToken)
    {   
        $user = TmUsuario::where(['email' => $email, 'verifyToken' => $verifyToken])->first();

        if($user) {
            //return ('diseño aqui pero backend está');
            return view('auth.verificar_mail.verificar_sub_usuario')->with(['user' => $user]);

        }else {
            return view('contents.home.usuario_no_existe');
        }
    }

    public function activarSubUsuario(Request $request)
    {       
        $data = $request->all();
        
        $usuario_update =  TmUsuario::where(['email' => $data['email'], 'verifyToken' => $data['verifyToken']])
                                    ->update(['status' => '1','verifyToken' => NULL,'password' => Hash::make($data['password'])]);

        if($usuario_update == 1) 
        {
            return view('contents.home.subUsuario_verificada');
        }   
        else    {
            return null;
        }

    }
}
