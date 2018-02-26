<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmPedido
 * 
 * @property int $id_pedido
 * @property int $id_tipo_pedido
 * @property int $id_usu
 * @property \Carbon\Carbon $fecha_pedido
 * @property string $estado
 * 
 * @property \App\Models\TmTipoPedido $tm_tipo_pedido
 * @property \App\Models\TmUsuario $tm_usuario
 * @property \App\Models\TmPedidoLlevar $tm_pedido_llevar
 * @property \App\Models\TmPedidoMesa $tm_pedido_mesa
 * @property \Illuminate\Database\Eloquent\Collection $tm_venta
 *
 * @package App\Models
 */
class TmPedido extends Eloquent
{
	protected $table = 'tm_pedido';
	protected $primaryKey = 'id_pedido';
	public $timestamps = false;

	protected $casts = [
		'id_tipo_pedido' => 'int',
		'id_usu' => 'int'
	];

	protected $dates = [
		'fecha_pedido'
	];

	protected $fillable = [
		'id_tipo_pedido',
		'id_usu',
		'fecha_pedido',
		'estado'
	];

	public function tm_tipo_pedido()
	{
		return $this->belongsTo(\App\Models\TmTipoPedido::class, 'id_tipo_pedido');
	}

	public function tm_usuario()
	{
		return $this->belongsTo(\App\Models\TmUsuario::class, 'id_usu');
	}

	public function tm_pedido_llevar()
	{
		return $this->hasOne(\App\Models\TmPedidoLlevar::class, 'id_pedido');
	}

	public function tm_pedido_mesa()
	{
		return $this->hasOne(\App\Models\TmPedidoMesa::class, 'id_pedido');
	}

	public function tm_venta()
	{
		return $this->hasMany(\App\Models\TmVentum::class, 'id_pedido');
	}
}
