<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmProductoCatg
 * 
 * @property int $id_catg
 * @property string $descripcion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_productos
 *
 * @package App\Models
 */
class TmProductoCatg extends Eloquent
{
	protected $table = 'tm_producto_catg';
	protected $primaryKey = 'id_catg';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function tm_productos()
	{
		return $this->hasMany(\App\Models\TmProducto::class, 'id_catg');
	}
}
