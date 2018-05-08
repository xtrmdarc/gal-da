<?php

namespace App\Http\Controllers\Web;

use App\Models\TmUsuario;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;

class AuthController extends Controller
{
    //
    public function store(Request $request)
    {
        $post = $request->all();

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
            'phone' => $post['phone'],
            'plan_id' => $post['plan_id'],
            'password' => bcrypt($post['password']),
            'verifyToken' => Str::random(40),
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
