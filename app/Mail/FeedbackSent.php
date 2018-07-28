<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\TmRol;
use App\Models\Empresa;

class FeedbackSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $usuario;
    public $comentario;
    public $rol;
    public $empresa;

    public function __construct($user,$comentario)
    {
        //
        $this->usuario = $user;
        $this->comentario = $comentario;
        $this->rol = (TmRol::where('id_rol',$user->id_rol)->first())->descripcion;
        $this->empresa = (Empresa::where('id',$user->id_empresa)->first())->nombre_empresa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.application.newFeedback');
    }
}
