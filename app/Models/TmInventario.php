<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmInventario
 * 
 * @property int $id_inv
 * @property int $id_ti
 * @property int $id_ins
 * @property int $id_tipo_ope
 * @property int $id_cv
 * @property float $cant
 * @property \Carbon\Carbon $fecha_r
 *
 * @package App\Models
 */
class TmInventario extends Eloquent
{
	protected $table = 'tm_inventario';
	protected $primaryKey = 'id_inv';
	public $timestamps = false;

	protected $casts = [
		'id_ti' => 'int',
		'id_ins' => 'int',
		'id_tipo_ope' => 'int',
		'id_cv' => 'int',
		'cant' => 'float'
	];

	protected $dates = [
		'fecha_r'
	];

	protected $fillable = [
		'id_ti',
		'id_ins',
		'id_tipo_ope',
		'id_cv',
		'cant',
		'fecha_r'
	];
}
