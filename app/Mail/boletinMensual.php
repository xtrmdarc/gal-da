<?php

namespace App\Mail;

use App\Models\TmUsuario;
use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class boletinMensual extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $usuario;
    public $id_empresa;
    public $empresa;
    public $moneda;
    public $u_nombre;
    public $ingresos;

    public $ingresos_mensual;
    public $nventas_mensual;
    public $nclientes_mensual;
    public $nombre_mes;
    public $anio;

    public function __construct(TmUsuario $usuario)
    {
        //
        $this->usuario = $usuario;
        $this->empresa = (Empresa::where('id',$usuario->id_empresa)->first())->nombre_empresa;
        $this->moneda = (Empresa::where('id',$usuario->id_empresa)->first())->moneda;
        $this->u_nombre = $usuario->nombres;
        $this->id_empresa = $usuario->id_empresa;

        $fecha_anio = date("Y");
        $fecha_mes = date("m")-1;

        switch ($fecha_mes) {
            case "01":
                $monthName = 'ENERO';
                break;
            case "02":
                $monthName = 'FEBRERO';
                break;
            case "03":
                $monthName = 'MARZO';
                break;
            case "04":
                $monthName = 'ABRIL';
                break;
            case "05":
                $monthName = 'MAYO';
                break;
            case "06":
                $monthName = 'JUNIO';
                break;
            case "07":
                $monthName = 'JULIO';
                break;
            case "08":
                $monthName = 'AGOSTO';
                break;
            case "09":
                $monthName = 'SEPTIEMBRE';
                break;
            case "10":
                $monthName = 'OCTUBRE';
                break;
            case "11":
                $monthName = 'NOVIEMBRE';
                break;
            case "12":
                $monthName = 'DICIEMBRE';
                break;
        }

        $ingresos_mensual =  DB::select('SELECT SUM(total) as ingresos_mensual FROM v_ventas_con v LEFT JOIN empresa e ON e.id = v.id_empresa WHERE e.id = ?
        and MONTH(fec_ven) = ? and YEAR(fec_ven) = ?',[$this->id_empresa,$fecha_mes,$fecha_anio])[0]->ingresos_mensual;

        $nventas_mensual =  DB::select('SELECT count(*) as nventas_mensual FROM tm_venta v LEFT JOIN tm_usuario u ON u.id_usu = v.id_usu WHERE u.id_empresa = ?
        and MONTH(fecha_venta) = ? and YEAR(fecha_venta) = ?',[$this->id_empresa,$fecha_mes,$fecha_anio])[0]->nventas_mensual;

        $nclientes_mensual =  DB::select('SELECT count(id_cli) as nclientes_mensual FROM v_ventas_con v WHERE v.id_empresa = ?
        and MONTH(fec_ven) = ? and YEAR(fec_ven) = ? and id_cli <> 1',[$this->id_empresa,$fecha_mes,$fecha_anio])[0]->nclientes_mensual;

        if($ingresos_mensual == null) {
            $ingresos_mensual = "0";
        }

        $this->ingresos_mensual = $ingresos_mensual;
        $this->nventas_mensual = $nventas_mensual;
        $this->nclientes_mensual = $nclientes_mensual;
        $this->nombre_mes = $monthName;
        $this->anio = $fecha_anio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Gal-Da | Boletin Mensual')
            ->view('email.application.boletin_Mensual');
    }
}
