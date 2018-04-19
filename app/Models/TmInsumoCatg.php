<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmInsumoCatg
 * 
 * @property int $id_catg
 * @property string $descripcion
 * @property string $estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_insumos
 *
 * @package App\Models
 */
class TmInsumoCatg extends Eloquent
{
	protected $table = 'tm_insumo_catg';
	protected $primaryKey = 'id_catg';
	public $timestamps = false;

	protected $fillable = [
		'descripcion',
		'estado'
	];

	public function tm_insumos()
	{
		return $this->hasMany(\App\Models\TmInsumo::class, 'id_catg');
	}
}
