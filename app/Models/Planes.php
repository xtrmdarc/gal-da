<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planes extends Model
{
    protected $table = 'planes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_empresa',
        'nombre',
        'venta_max',
        'mesa_max',
        'a_prod_max',
        'caja_max',
        'sucursal_max',
        'usuario_max'
    ];
}
