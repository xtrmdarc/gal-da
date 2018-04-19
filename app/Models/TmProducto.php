<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmProducto
 * 
 * @property int $id_prod
 * @property int $id_tipo
 * @property int $id_catg
 * @property int $id_areap
 * @property string $nombre
 * @property string $descripcion
 * @property string $estado
 * 
 * @property \App\Models\TmAreaProd $tm_area_prod
 * @property \App\Models\TmProductoCatg $tm_producto_catg
 *
 * @package App\Models
 */
class TmProducto extends Eloquent
{
	protected $table = 'tm_producto';
	protected $primaryKey = 'id_prod';
	public $timestamps = false;

	protected $casts = [
		'id_tipo' => 'int',
		'id_catg' => 'int',
		'id_areap' => 'int'
	];

	protected $fillable = [
		'id_tipo',
		'id_catg',
		'id_areap',
		'nombre',
		'descripcion',
		'estado'
	];

	public function tm_area_prod()
	{
		return $this->belongsTo(\App\Models\TmAreaProd::class, 'id_areap');
	}

	public function tm_producto_catg()
	{
		return $this->belongsTo(\App\Models\TmProductoCatg::class, 'id_catg');
	}
}
