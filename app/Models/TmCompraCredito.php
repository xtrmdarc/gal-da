<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmCompraCredito
 * 
 * @property int $id_credito
 * @property int $id_compra
 * @property float $total
 * @property float $interes
 * @property \Carbon\Carbon $fecha
 * @property string $estado
 * 
 * @property \App\Models\TmCompra $tm_compra
 *
 * @package App\Models
 */
class TmCompraCredito extends Eloquent
{
	protected $table = 'tm_compra_credito';
	protected $primaryKey = 'id_credito';
	public $timestamps = false;

	protected $casts = [
		'id_compra' => 'int',
		'total' => 'float',
		'interes' => 'float'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'id_compra',
		'total',
		'interes',
		'fecha',
		'estado'
	];

	public function tm_compra()
	{
		return $this->belongsTo(\App\Models\TmCompra::class, 'id_compra');
	}
}
