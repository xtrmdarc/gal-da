<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmDetalleVentum
 * 
 * @property int $id_venta
 * @property int $id_prod
 * @property int $cantidad
 * @property float $precio
 *
 * @package App\Models
 */
class TmDetalleVentum extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_venta' => 'int',
		'id_prod' => 'int',
		'cantidad' => 'int',
		'precio' => 'float'
	];

	protected $fillable = [
		'id_venta',
		'id_prod',
		'cantidad',
		'precio'
	];
}
