<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmCompra
 * 
 * @property int $id_compra
 * @property int $id_prov
 * @property int $id_tipo_compra
 * @property int $id_tipo_doc
 * @property int $id_usu
 * @property \Carbon\Carbon $fecha_c
 * @property string $hora_c
 * @property string $serie_doc
 * @property string $num_doc
 * @property float $igv
 * @property float $total
 * @property float $descuento
 * @property string $estado
 * @property string $observaciones
 * @property \Carbon\Carbon $fecha_reg
 * 
 * @property \App\Models\TmProveedor $tm_proveedor
 * @property \App\Models\TmTipoCompra $tm_tipo_compra
 * @property \App\Models\TmTipoDoc $tm_tipo_doc
 * @property \App\Models\TmUsuario $tm_usuario
 * @property \Illuminate\Database\Eloquent\Collection $tm_compra_creditos
 *
 * @package App\Models
 */
class TmCompra extends Eloquent
{
	protected $table = 'tm_compra';
	protected $primaryKey = 'id_compra';
	public $timestamps = false;

	protected $casts = [
		'id_prov' => 'int',
		'id_tipo_compra' => 'int',
		'id_tipo_doc' => 'int',
		'id_usu' => 'int',
		'igv' => 'float',
		'total' => 'float',
		'descuento' => 'float'
	];

	protected $dates = [
		'fecha_c',
		'fecha_reg'
	];

	protected $fillable = [
		'id_prov',
		'id_tipo_compra',
		'id_tipo_doc',
		'id_usu',
		'fecha_c',
		'hora_c',
		'serie_doc',
		'num_doc',
		'igv',
		'total',
		'descuento',
		'estado',
		'observaciones',
		'fecha_reg'
	];

	public function tm_proveedor()
	{
		return $this->belongsTo(\App\Models\TmProveedor::class, 'id_prov');
	}

	public function tm_tipo_compra()
	{
		return $this->belongsTo(\App\Models\TmTipoCompra::class, 'id_tipo_compra');
	}

	public function tm_tipo_doc()
	{
		return $this->belongsTo(\App\Models\TmTipoDoc::class, 'id_tipo_doc');
	}

	public function tm_usuario()
	{
		return $this->belongsTo(\App\Models\TmUsuario::class, 'id_usu');
	}

	public function tm_compra_creditos()
	{
		return $this->hasMany(\App\Models\TmCompraCredito::class, 'id_compra');
	}
}
