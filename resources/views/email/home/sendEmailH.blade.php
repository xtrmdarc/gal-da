<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .x_email-wrapper{
            background: #1FBDB7;
        }
    
        .content-mail{
            padding: 14px;
            text-align: center;
            background-color: white;
            border-radius: 3px;
        }
    
        .title-mail{
            margin-bottom: 15px;
        }
    
        .btn-mail{
            padding: 12px 4px 12px 4px;
            border: none;
            background-color: #FBA017 !important;
            color: white;
            text-decoration: none;
            margin-top:20px; 
        }
    
        
    
    </style>
</head>

   
    <body>
        <div class="email-wrapper">
            <div class="content-mail">
                <h2>Bienvenido a Gal-Da!</h2>
        
                <p style="margin-bottom:15px;">Hola! Solo necesitamos verificar que tienes acceso a este correo. Terminar de configurar tu cuenta haciendo clic en el boton de abajo</p>
                <a class="btn-mail"  href="{{route('sendEmailDone',["email" => $user->email, "verifyToken" => $user->verifyToken])}} ">Verifcar</a>
            </div>
        </div>                
    </body>
</html>


