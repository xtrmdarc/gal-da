<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmPedidoMesa
 * 
 * @property int $id_pedido
 * @property int $id_mesa
 * @property int $id_mozo
 * @property string $nomb_cliente
 * @property int $nro_personas
 * @property string $comentario
 * 
 * @property \App\Models\TmMesa $tm_mesa
 * @property \App\Models\TmUsuario $tm_usuario
 * @property \App\Models\TmPedido $tm_pedido
 *
 * @package App\Models
 */
class TmPedidoMesa extends Eloquent
{
	protected $table = 'tm_pedido_mesa';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_pedido' => 'int',
		'id_mesa' => 'int',
		'id_mozo' => 'int',
		'nro_personas' => 'int'
	];

	protected $fillable = [
		'id_pedido',
		'id_mesa',
		'id_mozo',
		'nomb_cliente',
		'nro_personas',
		'comentario'
	];

	public function tm_mesa()
	{
		return $this->belongsTo(\App\Models\TmMesa::class, 'id_mesa');
	}

	public function tm_usuario()
	{
		return $this->belongsTo(\App\Models\TmUsuario::class, 'id_mozo');
	}

	public function tm_pedido()
	{
		return $this->belongsTo(\App\Models\TmPedido::class, 'id_pedido');
	}
}
