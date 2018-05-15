<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empresa',
        'nombre_empresa',
        'direccion',
        'telefono',
        'moneda',
    ];

    public function users()
    {
        return $this->hasMany(\App\Models\TmUsuario::class, 'id_usu');
    }
}
