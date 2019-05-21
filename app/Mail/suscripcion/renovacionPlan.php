<?php

namespace App\Mail\suscripcion;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TmUsuario;
use Illuminate\Contracts\Queue\ShouldQueue;

class renovacionPlan extends Mailable
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
    public $plan_actual;

    public function __construct(TmUsuario $usuario,$fecha_c,$plan_actual)
    {
        //
        $this->usuario = $usuario;
        $this->u_nombre = $usuario->nombres;
        $this->u_ap = $usuario->ape_paterno;

        $this->fecha_c = $fecha_c;
        $this->plan_actual = $plan_actual;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Gal-Da | Renovacion de tu Plan '.$this->plan_actual)
            ->view('email.application.suscripcion.renovacionPlan');
    }
}
