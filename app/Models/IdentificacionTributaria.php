<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentificacionTributaria extends Model
{
    //
    protected $table = 'identificacion_tributaria';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'code',
        'description',
        'code_country',
    ];

}
