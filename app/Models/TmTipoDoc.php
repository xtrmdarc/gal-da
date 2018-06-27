<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTipoDoc
 * 
 * @property int $id_tipo_doc
 * @property string $descripcion
 * @property string $serie
 * @property string $numero
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_compras
 * @property \Illuminate\Database\Eloquent\Collection $tm_gastos_adms
 * @property \Illuminate\Database\Eloquent\Collection $tm_venta
 *
 * @package App\Models
 */
class TmTipoDoc extends Eloquent
{
	protected $table = 'tm_tipo_doc';
	protected $primaryKey = 'id_tipo_doc';
	public $timestamps = false;

	protected $fillable = [
		'descripcion',
		'serie',
		'numero',
		'id_sucursal'
	];

	public function tm_compras()
	{
		return $this->hasMany(\App\Models\TmCompra::class, 'id_tipo_doc');
	}

	public function tm_gastos_adms()
	{
		return $this->hasMany(\App\Models\TmGastosAdm::class, 'id_tipo_doc');
	}

	public function tm_venta()
	{
		return $this->hasMany(\App\Models\TmVentum::class, 'id_tipo_doc');
	}
}
