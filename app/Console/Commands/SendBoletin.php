<?php

namespace App\Console\Commands;

use App\Models\TmUsuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\boletinMensual;

class SendBoletin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:boletin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se envia mensualmente un boletin informativo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $users = DB::select('SELECT u.id_usu,count(*) as nventas_mensual
         FROM tm_venta v
         LEFT JOIN empresa e ON e.id = v.id_empresa
         LEFT JOIN tm_usuario u ON u.id_empresa = e.id and u.parent_id is null
         WHERE MONTH(v.fecha_venta) = MONTH(DATE_SUB(curdate(), INTERVAL 1 MONTH))
         and YEAR(v.fecha_venta) = YEAR(DATE_SUB(curdate(), INTERVAL 1 MONTH))
         group by e.id
         having nventas_mensual > 10;');

        foreach ($users as $user) {
            $id_usu = $user->id_usu;
            $thisUser = (TmUsuario::where('id_usu',$id_usu)->first());
            Mail::to($thisUser->email)->send(new boletinMensual($thisUser));
        }
    }
}
