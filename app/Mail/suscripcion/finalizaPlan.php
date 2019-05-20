<?php

namespace App\Mail\suscripcion;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TmUsuario;
use Illuminate\Contracts\Queue\ShouldQueue;

class finalizaPlan extends Mailable
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

    public $plan_actual;

    public function __construct(TmUsuario $usuario,$plan_actual)
    {
        //
        $this->usuario = $usuario;
        $this->u_nombre = $usuario->nombres;
        $this->u_ap = $usuario->ape_paterno;

        $this->plan_actual = $plan_actual;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Gal-Da | Ha finalizado tu Plan '.$this->plan_actual)
            ->view('email.application.suscripcion.finalizaPlan');
    }
}
