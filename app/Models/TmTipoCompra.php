<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTipoCompra
 * 
 * @property int $id_tipo_compra
 * @property string $descripcion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_compras
 *
 * @package App\Models
 */
class TmTipoCompra extends Eloquent
{
	protected $table = 'tm_tipo_compra';
	protected $primaryKey = 'id_tipo_compra';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function tm_compras()
	{
		return $this->hasMany(\App\Models\TmCompra::class, 'id_tipo_compra');
	}
}
