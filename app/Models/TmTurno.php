<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTurno
 * 
 * @property int $id_turno
 * @property string $descripcion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_aper_cierres
 *
 * @package App\Models
 */
class TmTurno extends Eloquent
{
	protected $table = 'tm_turno';
	protected $primaryKey = 'id_turno';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function tm_aper_cierres()
	{
		return $this->hasMany(\App\Models\TmAperCierre::class, 'id_turno');
	}
}
