<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmGastosAdm
 * 
 * @property int $id_ga
 * @property int $id_tipo_gasto
 * @property int $id_tipo_doc
 * @property int $id_per
 * @property int $id_usu
 * @property int $id_apc
 * @property string $serie_doc
 * @property string $num_doc
 * @property \Carbon\Carbon $fecha_comp
 * @property float $importe
 * @property string $motivo
 * @property \Carbon\Carbon $fecha_registro
 * @property string $estado
 * 
 * @property \App\Models\TmTipoDoc $tm_tipo_doc
 * @property \App\Models\TmTipoGasto $tm_tipo_gasto
 *
 * @package App\Models
 */
class TmGastosAdm extends Eloquent
{
	protected $table = 'tm_gastos_adm';
	protected $primaryKey = 'id_ga';
	public $timestamps = false;

	protected $casts = [
		'id_tipo_gasto' => 'int',
		'id_tipo_doc' => 'int',
		'id_per' => 'int',
		'id_usu' => 'int',
		'id_apc' => 'int',
		'importe' => 'float'
	];

	protected $dates = [
		'fecha_comp',
		'fecha_registro'
	];

	protected $fillable = [
		'id_tipo_gasto',
		'id_tipo_doc',
		'id_per',
		'id_usu',
		'id_apc',
		'serie_doc',
		'num_doc',
		'fecha_comp',
		'importe',
		'motivo',
		'fecha_registro',
		'estado'
	];

	public function tm_tipo_doc()
	{
		return $this->belongsTo(\App\Models\TmTipoDoc::class, 'id_tipo_doc');
	}

	public function tm_tipo_gasto()
	{
		return $this->belongsTo(\App\Models\TmTipoGasto::class, 'id_tipo_gasto');
	}
}
