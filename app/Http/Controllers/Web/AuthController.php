<?php

namespace App\Http\Controllers\Web;

use App\Models\Empresa;
use App\Models\Sucursal;
use App\Models\TmAlmacen;
use App\Models\TmAreaProd;
use App\Models\TmTipoDoc;
use App\Models\TmUsuario;
use App\Models\TmTurno;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct()     {         
        $this->middleware('afterRegister');     
    }
    //
    public function store_f(Request $request)
    {
        $post = $request->all();

        $empresa = Empresa::create([
            'nombre_empresa' => $post['name_business'],
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
            'estado' => 'a',
            'name_business' => $post['name_business'],
            'nombres' => $post['name'],
            'ape_paterno' => $post['lastname'],
            'ape_materno' => $post['m_lastname'],
            'phone' => $post['phone'],
            'email' => $post['email'],
            'plan_id' => $post['plan_id'],
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
        $thisUser = TmUsuario::findOrFail($user->id_usu);

        $this->senEmail($thisUser);
        return redirect(route('verifyEmailFirst'));
    }

    public function show_account_v() {
        return view('auth.register.register-step-account');
    }

    public function store_account(Request $request)
    {
        $post = $request->all();

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
        $thisUser = TmUsuario::findOrFail($user->id_usu);

        $this->senEmail($thisUser);
        return redirect(route('verifyEmailFirst'));
    }

    public function senEmail($thisUser)
    {
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }

    public function verifyEmailFirst()
    {
        dd('REVISA TU CORREO PAPU');
    }

    public function sendEmailDone($email,$verifyToken)
    {
        $user = TmUsuario::where(['email' => $email, 'verifyToken' => $verifyToken])->first();

        if($user) {
            return TmUsuario::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['status' => '1','verifyToken' => NULL]);
        }else {
            dd('Usuario no existe');
        }
    }

    public function show_account_info_v() {
        return view('auth.register.register-step-account-info');
    }

    public function store_account_info(Request $request)
    {
        $post = $request->all();

        $idUsu = \Auth::user()->id_usu;
        $nombres = $post['name'];
        $ape_paterno = $post['lastname'];
        $ape_materno = $post['m_lastname'];
        $dni = $post['dni'];
        $phone = $post['phone'];

        $sql = DB::update("UPDATE tm_usuario SET
						nombres  = ?,
					    ape_paterno  = ?,
                        ape_materno = ?,
						dni   = ?,
                        phone = ?
				    WHERE id_usu = ?", [$nombres, $ape_paterno, $ape_materno, $dni, $phone, $idUsu]);
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

        if($planId == '1'){
            return redirect()->route('tableroF');
        }else {
            return redirect()->route('tablero');
        }

    }

    public function verificarTokenSubUsuario($email,$verifyToken)
    {   
        $user = TmUsuario::where(['email' => $email, 'verifyToken' => $verifyToken])->first();

        if($user) {
            return ('diseño aqui pero backend está');
            return view('auth.verificar_mail.verificar_sub_usuario')->with(['user' => $user]);

        }else {
            dd('Usuario no existe');
        }
    }

    public function activarSubUsuario(Request $request)
    {       
        $data = $request->all();
        
        $usuario_update =  TmUsuario::where(['email' => $email, 'verifyToken' => $verifyToken])
                                    ->update(['status' => '1','verifyToken' => NULL,'password' => Hash::make($data['password'])]);

        if($usuario_update == 1) 
        {
            return ('DISEÑO PAPU');
        }   
        else    {
            return null;
        }

    }
}
