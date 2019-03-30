<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmMesa
 * 
 * @property int $id_mesa
 * @property int $id_catg
 * @property string $nro_mesa
 * @property string $estado
 * 
 * @property \App\Models\TmSalon $tm_salon
 * @property \App\Models\TmPedidoMesa $tm_pedido_mesa
 *
 * @package App\Models
 */
class TmMesa extends Eloquent
{
	protected $table = 'tm_mesa';
	protected $primaryKey = 'id_mesa';
	public $timestamps = false;

	protected $casts = [
		'id_catg' => 'int'
	];

	protected $fillable = [
		'id_catg',
		'nro_mesa',
		'estado',
		'plan_estado',
		'id_empresa',
		'id_usu'
	];

	public function tm_salon()
	{
		return $this->belongsTo(\App\Models\TmSalon::class, 'id_catg');
	}

	public function tm_pedido_mesa()
	{
		return $this->hasOne(\App\Models\TmPedidoMesa::class, 'id_mesa');
	}
}
