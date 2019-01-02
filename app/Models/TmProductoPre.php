<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmProductoPre
 * 
 * @property int $id_pres
 * @property int $id_prod
 * @property string $cod_prod
 * @property string $presentacion
 * @property float $precio
 * @property int $receta
 * @property int $stock_min
 * @property string $estado
 *
 * @package App\Models
 */
class TmProductoPre extends Eloquent
{
	protected $primaryKey = 'id_pres';
	public $timestamps = false;

	protected $casts = [
		'id_prod' => 'int',
		'precio' => 'float',
		'receta' => 'int',
		'stock_min' => 'int'
	];

	protected $fillable = [
		'id_prod',
		'cod_prod',
		'presentacion',
		'precio',
		'receta',
		'stock_min',
		'estado'
	];
}
