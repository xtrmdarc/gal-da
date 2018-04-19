<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmPedidoDelivery
 * 
 * @property int $id_pedido
 * @property string $nro_pedido
 * @property string $nomb_cliente
 * @property string $direccion
 * @property string $telefono
 * @property string $comentario
 *
 * @package App\Models
 */
class TmPedidoDelivery extends Eloquent
{
	protected $table = 'tm_pedido_delivery';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_pedido' => 'int'
	];

	protected $fillable = [
		'id_pedido',
		'nro_pedido',
		'nomb_cliente',
		'direccion',
		'telefono',
		'comentario'
	];
}
