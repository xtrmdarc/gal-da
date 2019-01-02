<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTipoGasto
 * 
 * @property int $id_tipo_gasto
 * @property string $descripcion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_gastos_adms
 *
 * @package App\Models
 */
class TmTipoGasto extends Eloquent
{
	protected $table = 'tm_tipo_gasto';
	protected $primaryKey = 'id_tipo_gasto';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function tm_gastos_adms()
	{
		return $this->hasMany(\App\Models\TmGastosAdm::class, 'id_tipo_gasto');
	}
}
