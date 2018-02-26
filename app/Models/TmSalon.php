<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmSalon
 * 
 * @property int $id_catg
 * @property string $descripcion
 * @property string $estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_mesas
 *
 * @package App\Models
 */
class TmSalon extends Eloquent
{
	protected $table = 'tm_salon';
	protected $primaryKey = 'id_catg';
	public $timestamps = false;

	protected $fillable = [
		'descripcion',
		'estado'
	];

	public function tm_mesas()
	{
		return $this->hasMany(\App\Models\TmMesa::class, 'id_catg');
	}
}
