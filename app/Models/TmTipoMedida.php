<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTipoMedida
 * 
 * @property int $id_med
 * @property string $descripcion
 * @property int $grupo
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_insumos
 *
 * @package App\Models
 */
class TmTipoMedida extends Eloquent
{
	protected $table = 'tm_tipo_medida';
	protected $primaryKey = 'id_med';
	public $timestamps = false;

	protected $casts = [
		'grupo' => 'int'
	];

	protected $fillable = [
		'descripcion',
		'grupo'
	];

	public function tm_insumos()
	{
		return $this->hasMany(\App\Models\TmInsumo::class, 'id_med');
	}
}
