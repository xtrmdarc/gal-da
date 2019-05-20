<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TmUsuario;
use Illuminate\Contracts\Queue\ShouldQueue;

class invoiceBasic extends Mailable
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
    public $url;

    public $precio;
    public $fecha_c;
    public $plan_actual;

    public function __construct(TmUsuario $usuario,$url,$precio,$fecha_c,$plan_actual)
    {
        //
        $this->usuario = $usuario;
        $this->u_nombre = $usuario->nombres;
        $this->u_ap = $usuario->ape_paterno;
        $this->url = $url;

        $this->precio = $precio;
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
        return $this->subject('Gal-Da | Recibo Plan '.$this->plan_actual)
            ->view('email.application.invoiceBasic')
            // ->attach($this->url)
            ->attachFromStorageDisk('s3_billing_g',$this->url,'recibo.pdf');
            // ->attachData()
    }
}
