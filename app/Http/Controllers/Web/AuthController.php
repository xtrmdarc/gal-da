<?php

namespace App\Http\Controllers\Web;

use App\Models\Empresa;
use App\Models\Sucursal;
use App\Models\TmUsuario;
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
    //
    public function store(Request $request)
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

}
