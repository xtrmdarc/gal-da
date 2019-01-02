<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmIngresosAdm
 * 
 * @property int $id_ing
 * @property int $id_usu
 * @property int $id_apc
 * @property float $importe
 * @property string $motivo
 * @property \Carbon\Carbon $fecha_reg
 * @property string $estado
 *
 * @package App\Models
 */
class TmIngresosAdm extends Eloquent
{
	protected $table = 'tm_ingresos_adm';
	protected $primaryKey = 'id_ing';
	public $timestamps = false;

	protected $casts = [
		'id_usu' => 'int',
		'id_apc' => 'int',
		'importe' => 'float'
	];

	protected $dates = [
		'fecha_reg'
	];

	protected $fillable = [
		'id_usu',
		'id_apc',
		'importe',
		'motivo',
		'fecha_reg',
		'estado'
	];
}
