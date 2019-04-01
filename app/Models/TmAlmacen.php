<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmAlmacen
 * 
 * @property int $id_alm
 * @property string $nombre
 * @property string $estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_area_prods
 *
 * @package App\Models
 */
class TmAlmacen extends Eloquent
{
	protected $table = 'tm_almacen';
	protected $primaryKey = 'id_alm';
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'estado',
		'id_sucursal',
		'id_usu',
		'plan_estado',
		'id_empresa'
	];

	public function tm_area_prods()
	{
		return $this->hasMany(\App\Models\TmAreaProd::class, 'id_alm');
	}
}
