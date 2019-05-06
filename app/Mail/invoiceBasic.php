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
    public $url;

    public function __construct(TmUsuario $usuario,$url)
    {
        //
        $this->usuario = $usuario;
        $this->u_nombre = $usuario->nombres;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Gal-Da | Recibo Plan Basic')
            ->view('email.application.invoiceBasic')
            // ->attach($this->url)
            ->attachFromStorageDisk('s3',$this->url,'recibo.pdf');
            // ->attachData()
    }
}
