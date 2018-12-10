<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class TmUsuario extends Authenticatable
{
    //
    use Notifiable;
    //use Billable;

    protected $table = 'tm_usuario';
    protected $primaryKey = 'id_usu';
    //public $timestamps = false;

    protected $casts = [
        'id_rol' => 'int',
        'id_areap' => 'int',
        'plan_id' => 'int',
        'parent_id' => 'int',
        'dni' => 'int',
        'status' => 'int'
    ];

    protected $fillable = [
        'id_rol',
        'id_areap',
        'plan_id',
        'parent_id',
        'dni',
        'name_business',
        'ape_paterno',
        'ape_materno',
        'phone',
        'nombres',
        'email',
        'usuario',
        'contrasena',
        'estado',
        'imagen',
        'password',
        'verifyToken',
        'id_sucursal',
        'id_empresa',
        'status',
        'codigo_pais',
        'codigo_phone',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
        'pin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tm_rol()
    {
        return $this->belongsTo(\App\Models\TmRol::class, 'id_rol');
    }

    public function tm_aper_cierres()
    {
        return $this->hasMany(\App\Models\TmAperCierre::class, 'id_usu');
    }

    public function tm_compras()
    {
        return $this->hasMany(\App\Models\TmCompra::class, 'id_usu');
    }

    public function tm_credito_detalle()
    {
        return $this->hasOne(\App\Models\TmCreditoDetalle::class, 'id_usu');
    }

    public function tm_pedidos()
    {
        return $this->hasMany(\App\Models\TmPedido::class, 'id_usu');
    }

    public function tm_pedido_mesa()
    {
        return $this->hasOne(\App\Models\TmPedidoMesa::class, 'id_mozo');
    }

    public function tm_venta()
    {
        return $this->hasMany(\App\Models\TmVentum::class, 'id_usu');
    }
    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class, 'id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
