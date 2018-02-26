<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmMargenVentum
 * 
 * @property int $id
 * @property int $cod_dia
 * @property string $dia
 * @property float $margen
 *
 * @package App\Models
 */
class TmMargenVentum extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'cod_dia' => 'int',
		'margen' => 'float'
	];

	protected $fillable = [
		'cod_dia',
		'dia',
		'margen'
	];
}
