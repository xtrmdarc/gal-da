<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTipoPedido
 * 
 * @property int $id_tipo_pedido
 * @property string $descripcion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_pedidos
 * @property \Illuminate\Database\Eloquent\Collection $tm_venta
 *
 * @package App\Models
 */
class TmTipoPedido extends Eloquent
{
	protected $table = 'tm_tipo_pedido';
	protected $primaryKey = 'id_tipo_pedido';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function tm_pedidos()
	{
		return $this->hasMany(\App\Models\TmPedido::class, 'id_tipo_pedido');
	}

	public function tm_venta()
	{
		return $this->hasMany(\App\Models\TmVentum::class, 'id_tipo_pedido');
	}
}
