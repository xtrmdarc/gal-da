<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmTipoPago
 * 
 * @property int $id_tipo_pago
 * @property string $descripcion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_venta
 *
 * @package App\Models
 */
class TmTipoPago extends Eloquent
{
	protected $table = 'tm_tipo_pago';
	protected $primaryKey = 'id_tipo_pago';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function tm_venta()
	{
		return $this->hasMany(\App\Models\TmVentum::class, 'id_tipo_pago');
	}
}
