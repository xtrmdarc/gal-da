<?php

namespace App\Console\Commands\suscripcion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Mail\suscripcion\renovacionPlan;
use App\Models\TmUsuario;

class SendRenovacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:renovacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se envia un correo con 5 dias previos para su renovacion de plan';

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
        $users = DB::select('select u.id_usu,u.email,u.nombres,u.ape_paterno,u.ape_materno,DATE_FORMAT(s.ends_at,"%Y-%m-%d") as renovacion,p.nombre as n_plan
                    from tm_usuario u
                    left join subscription s on s.id_usu = u.id_usu
                    left join planes p on p.id = u.plan_id
                    where u.parent_id is null and u.plan_id <> 1 and u.id_usu = 243;');

        foreach ($users as $user) {
            $id_usu = $user->id_usu;
            $thisUser = (TmUsuario::where('id_usu',$id_usu)->first());

            Mail::to($thisUser->email)->send(new renovacionPlan($thisUser,$user->renovacion,$user->n_plan));
        }
    }
}
