<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmAperCierre
 * 
 * @property int $id_apc
 * @property int $id_usu
 * @property int $id_caja
 * @property int $id_turno
 * @property \Carbon\Carbon $fecha_aper
 * @property float $monto_aper
 * @property \Carbon\Carbon $fecha_cierre
 * @property float $monto_cierre
 * @property float $monto_sistema
 * @property string $estado
 * 
 * @property \App\Models\TmCaja $tm_caja
 * @property \App\Models\TmTurno $tm_turno
 * @property \App\Models\TmUsuario $tm_usuario
 * @property \Illuminate\Database\Eloquent\Collection $tm_venta
 *
 * @package App\Models
 */
class TmAperCierre extends Eloquent
{
	protected $table = 'tm_aper_cierre';
	protected $primaryKey = 'id_apc';
	public $timestamps = false;

	protected $casts = [
		'id_usu' => 'int',
		'id_caja' => 'int',
		'id_turno' => 'int',
		'monto_aper' => 'float',
		'monto_cierre' => 'float',
		'monto_sistema' => 'float'
	];

	protected $dates = [
		'fecha_aper',
		'fecha_cierre'
	];

	protected $fillable = [
		'id_usu',
		'id_caja',
		'id_turno',
		'fecha_aper',
		'monto_aper',
		'fecha_cierre',
		'monto_cierre',
		'monto_sistema',
		'estado'
	];

	public function tm_caja()
	{
		return $this->belongsTo(\App\Models\TmCaja::class, 'id_caja');
	}

	public function tm_turno()
	{
		return $this->belongsTo(\App\Models\TmTurno::class, 'id_turno');
	}

	public function tm_usuario()
	{
		return $this->belongsTo(\App\Models\TmUsuario::class, 'id_usu');
	}

	public function tm_venta()
	{
		return $this->hasMany(\App\Models\TmVentum::class, 'id_apc');
	}
}
