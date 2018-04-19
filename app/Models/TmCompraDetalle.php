<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmCompraDetalle
 * 
 * @property int $id_compra
 * @property int $id_tp
 * @property int $id_pres
 * @property float $cant
 * @property float $precio
 *
 * @package App\Models
 */
class TmCompraDetalle extends Eloquent
{
	protected $table = 'tm_compra_detalle';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_compra' => 'int',
		'id_tp' => 'int',
		'id_pres' => 'int',
		'cant' => 'float',
		'precio' => 'float'
	];

	protected $fillable = [
		'id_compra',
		'id_tp',
		'id_pres',
		'cant',
		'precio'
	];
}
