<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmAreaProd
 * 
 * @property int $id_areap
 * @property int $id_alm
 * @property string $nombre
 * @property string $estado
 * 
 * @property \App\Models\TmAlmacen $tm_almacen
 * @property \Illuminate\Database\Eloquent\Collection $tm_productos
 *
 * @package App\Models
 */
class TmAreaProd extends Eloquent
{
	protected $table = 'tm_area_prod';
	protected $primaryKey = 'id_areap';
	public $timestamps = false;

	protected $casts = [
		'id_alm' => 'int'
	];

	protected $fillable = [
		'id_alm',
		'nombre',
		'estado'
	];

	public function tm_almacen()
	{
		return $this->belongsTo(\App\Models\TmAlmacen::class, 'id_alm');
	}

	public function tm_productos()
	{
		return $this->hasMany(\App\Models\TmProducto::class, 'id_areap');
	}
}
