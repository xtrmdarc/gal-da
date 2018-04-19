<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:49 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmVentum
 * 
 * @property int $id_venta
 * @property int $id_pedido
 * @property int $id_tipo_pedido
 * @property int $id_cliente
 * @property int $id_tipo_doc
 * @property int $id_tipo_pago
 * @property int $id_usu
 * @property int $id_apc
 * @property string $serie_doc
 * @property string $nro_doc
 * @property float $pago_efe
 * @property float $pago_tar
 * @property float $descuento
 * @property float $igv
 * @property float $total
 * @property \Carbon\Carbon $fecha_venta
 * @property string $estado
 * @property string $observacion
 * 
 * @property \App\Models\TmAperCierre $tm_aper_cierre
 * @property \App\Models\TmCliente $tm_cliente
 * @property \App\Models\TmPedido $tm_pedido
 * @property \App\Models\TmTipoDoc $tm_tipo_doc
 * @property \App\Models\TmTipoPago $tm_tipo_pago
 * @property \App\Models\TmTipoPedido $tm_tipo_pedido
 * @property \App\Models\TmUsuario $tm_usuario
 *
 * @package App\Models
 */
class TmVentum extends Eloquent
{
	protected $primaryKey = 'id_venta';
	public $timestamps = false;

	protected $casts = [
		'id_pedido' => 'int',
		'id_tipo_pedido' => 'int',
		'id_cliente' => 'int',
		'id_tipo_doc' => 'int',
		'id_tipo_pago' => 'int',
		'id_usu' => 'int',
		'id_apc' => 'int',
		'pago_efe' => 'float',
		'pago_tar' => 'float',
		'descuento' => 'float',
		'igv' => 'float',
		'total' => 'float'
	];

	protected $dates = [
		'fecha_venta'
	];

	protected $fillable = [
		'id_pedido',
		'id_tipo_pedido',
		'id_cliente',
		'id_tipo_doc',
		'id_tipo_pago',
		'id_usu',
		'id_apc',
		'serie_doc',
		'nro_doc',
		'pago_efe',
		'pago_tar',
		'descuento',
		'igv',
		'total',
		'fecha_venta',
		'estado',
		'observacion'
	];

	public function tm_aper_cierre()
	{
		return $this->belongsTo(\App\Models\TmAperCierre::class, 'id_apc');
	}

	public function tm_cliente()
	{
		return $this->belongsTo(\App\Models\TmCliente::class, 'id_cliente');
	}

	public function tm_pedido()
	{
		return $this->belongsTo(\App\Models\TmPedido::class, 'id_pedido');
	}

	public function tm_tipo_doc()
	{
		return $this->belongsTo(\App\Models\TmTipoDoc::class, 'id_tipo_doc');
	}

	public function tm_tipo_pago()
	{
		return $this->belongsTo(\App\Models\TmTipoPago::class, 'id_tipo_pago');
	}

	public function tm_tipo_pedido()
	{
		return $this->belongsTo(\App\Models\TmTipoPedido::class, 'id_tipo_pedido');
	}

	public function tm_usuario()
	{
		return $this->belongsTo(\App\Models\TmUsuario::class, 'id_usu');
	}
}
