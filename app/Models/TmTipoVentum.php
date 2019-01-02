<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTipoVentum
 * 
 * @property int $id_tipo_venta
 * @property string $descripcion
 *
 * @package App\Models
 */
class TmTipoVentum extends Eloquent
{
	protected $primaryKey = 'id_tipo_venta';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];
}
