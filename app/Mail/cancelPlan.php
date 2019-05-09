<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TmUsuario;
use Illuminate\Contracts\Queue\ShouldQueue;

class cancelPlan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $usuario;
    public $u_nombre;
    public $u_ap;

    public $fecha_c;

    public function __construct(TmUsuario $usuario,$fecha_c)
    {
        //
        $this->usuario = $usuario;
        $this->u_nombre = $usuario->nombres;
        $this->u_ap = $usuario->ape_paterno;

        $this->fecha_c = $fecha_c;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Gal-Da | Recibo Plan Basic')
            ->view('email.application.cancel_Plan');
    }
}
