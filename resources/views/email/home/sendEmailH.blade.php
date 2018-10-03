<h2>Bienvenido a Gal-Da!</h2>

<p style="margin-bottom:15px;">Hola! Solo necesitamos verificar que tienes acceso a este correo. Terminar de configurar tu cuenta haciendo clic en el boton de abajo</p>
<a href="{{route('sendEmailDone',["email" => $user->email, "verifyToken" => $user->verifyToken])}}">Verificar</a>
