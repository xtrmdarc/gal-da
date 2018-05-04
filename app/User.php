<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_business',
        'nombres',
        'ape_paterno',
        'ape_materno',
        'phone',
        'plan_id',
        'id_rol',
        'id_areap',
        'dni',
        'estado',
        'imagen',
        'email',
        'password',
        'verifyToken',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
