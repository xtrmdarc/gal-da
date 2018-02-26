<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmCaja
 * 
 * @property int $id_caja
 * @property string $descripcion
 * @property string $estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_aper_cierres
 *
 * @package App\Models
 */
class TmCaja extends Eloquent
{
	protected $table = 'tm_caja';
	protected $primaryKey = 'id_caja';
	public $timestamps = false;

	protected $fillable = [
		'descripcion',
		'estado'
	];

	public function tm_aper_cierres()
	{
		return $this->hasMany(\App\Models\TmAperCierre::class, 'id_caja');
	}
}
