<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmCreditoDetalle
 * 
 * @property int $id_credito
 * @property int $id_usu
 * @property float $importe
 * @property \Carbon\Carbon $fecha
 * 
 * @property \App\Models\TmUsuario $tm_usuario
 *
 * @package App\Models
 */
class TmCreditoDetalle extends Eloquent
{
	protected $table = 'tm_credito_detalle';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_credito' => 'int',
		'id_usu' => 'int',
		'importe' => 'float'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'id_credito',
		'id_usu',
		'importe',
		'fecha'
	];

	public function tm_usuario()
	{
		return $this->belongsTo(\App\Models\TmUsuario::class, 'id_usu');
	}
}
