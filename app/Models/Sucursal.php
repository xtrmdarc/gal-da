<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_sucursal',
        'id_empresa',
        'id_usu',
        'estado',
        'direccion',
        'telefono',
        'moneda',
        'id_sucursal',
    ];
}
