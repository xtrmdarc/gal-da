<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmPedidoLlevar
 * 
 * @property int $id_pedido
 * @property string $nro_pedido
 * @property string $nomb_cliente
 * @property string $comentario
 * 
 * @property \App\Models\TmPedido $tm_pedido
 *
 * @package App\Models
 */
class TmPedidoLlevar extends Eloquent
{
	protected $table = 'tm_pedido_llevar';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_pedido' => 'int'
	];

	protected $fillable = [
		'id_pedido',
		'nro_pedido',
		'nomb_cliente',
		'comentario'
	];

	public function tm_pedido()
	{
		return $this->belongsTo(\App\Models\TmPedido::class, 'id_pedido');
	}
}
