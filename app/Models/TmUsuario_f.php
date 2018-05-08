<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmUsuario
 * 
 * @property int $id_usu
 * @property int $id_rol
 * @property int $id_areap
 * @property int $dni
 * @property string $ape_paterno
 * @property string $ape_materno
 * @property string $nombres
 * @property string $email
 * @property string $usuario
 * @property string $contrasena
 * @property string $estado
 * @property string $imagen
 * 
 * @property \App\Models\TmRol $tm_rol
 * @property \Illuminate\Database\Eloquent\Collection $tm_aper_cierres
 * @property \Illuminate\Database\Eloquent\Collection $tm_compras
 * @property \App\Models\TmCreditoDetalle $tm_credito_detalle
 * @property \Illuminate\Database\Eloquent\Collection $tm_pedidos
 * @property \App\Models\TmPedidoMesa $tm_pedido_mesa
 * @property \Illuminate\Database\Eloquent\Collection $tm_venta
 *
 * @package App\Models
 */
class TmUsuario_f extends Eloquent
{
	protected $table = 'tm_usuario';
	protected $primaryKey = 'id_usu';
	public $timestamps = false;

	protected $casts = [
		'id_rol' => 'int',
		'id_areap' => 'int',
		'dni' => 'int'
	];

	protected $fillable = [
		'id_rol',
		'id_areap',
		'dni',
		'ape_paterno',
		'ape_materno',
		'nombres',
		'email',
		'usuario',
		'contrasena',
		'estado',
		'imagen'
	];

	public function tm_rol()
	{
		return $this->belongsTo(\App\Models\TmRol::class, 'id_rol');
	}

	public function tm_aper_cierres()
	{
		return $this->hasMany(\App\Models\TmAperCierre::class, 'id_usu');
	}

	public function tm_compras()
	{
		return $this->hasMany(\App\Models\TmCompra::class, 'id_usu');
	}

	public function tm_credito_detalle()
	{
		return $this->hasOne(\App\Models\TmCreditoDetalle::class, 'id_usu');
	}

	public function tm_pedidos()
	{
		return $this->hasMany(\App\Models\TmPedido::class, 'id_usu');
	}

	public function tm_pedido_mesa()
	{
		return $this->hasOne(\App\Models\TmPedidoMesa::class, 'id_mozo');
	}

	public function tm_venta()
	{
		return $this->hasMany(\App\Models\TmVentum::class, 'id_usu');
	}
}
