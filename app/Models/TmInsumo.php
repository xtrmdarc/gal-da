<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmInsumo
 * 
 * @property int $id_ins
 * @property int $id_catg
 * @property int $id_med
 * @property string $cod_ins
 * @property string $nomb_ins
 * @property int $stock_min
 * @property string $estado
 * 
 * @property \App\Models\TmInsumoCatg $tm_insumo_catg
 * @property \App\Models\TmTipoMedida $tm_tipo_medida
 *
 * @package App\Models
 */
class TmInsumo extends Eloquent
{
	protected $table = 'tm_insumo';
	protected $primaryKey = 'id_ins';
	public $timestamps = false;

	protected $casts = [
		'id_catg' => 'int',
		'id_med' => 'int',
		'stock_min' => 'int'
	];

	protected $fillable = [
		'id_catg',
		'id_med',
		'cod_ins',
		'nomb_ins',
		'stock_min',
		'estado'
	];

	public function tm_insumo_catg()
	{
		return $this->belongsTo(\App\Models\TmInsumoCatg::class, 'id_catg');
	}

	public function tm_tipo_medida()
	{
		return $this->belongsTo(\App\Models\TmTipoMedida::class, 'id_med');
	}
}
