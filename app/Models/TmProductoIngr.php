<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmProductoIngr
 * 
 * @property int $id_pi
 * @property int $id_pres
 * @property int $id_ins
 * @property int $id_med
 * @property float $cant
 *
 * @package App\Models
 */
class TmProductoIngr extends Eloquent
{
	protected $table = 'tm_producto_ingr';
	protected $primaryKey = 'id_pi';
	public $timestamps = false;

	protected $casts = [
		'id_pres' => 'int',
		'id_ins' => 'int',
		'id_med' => 'int',
		'cant' => 'float'
	];

	protected $fillable = [
		'id_pres',
		'id_ins',
		'id_med',
		'cant'
	];
}
