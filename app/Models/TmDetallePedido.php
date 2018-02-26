<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmDetallePedido
 * 
 * @property int $id_pedido
 * @property int $id_prod
 * @property int $cantidad
 * @property int $cant
 * @property float $precio
 * @property string $comentario
 * @property \Carbon\Carbon $fecha_pedido
 * @property \Carbon\Carbon $fecha_envio
 * @property string $estado
 *
 * @package App\Models
 */
class TmDetallePedido extends Eloquent
{
	protected $table = 'tm_detalle_pedido';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_pedido' => 'int',
		'id_prod' => 'int',
		'cantidad' => 'int',
		'cant' => 'int',
		'precio' => 'float'
	];

	protected $dates = [
		'fecha_pedido',
		'fecha_envio'
	];

	protected $fillable = [
		'id_pedido',
		'id_prod',
		'cantidad',
		'cant',
		'precio',
		'comentario',
		'fecha_pedido',
		'fecha_envio',
		'estado'
	];
}
