<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmDatosEmpresa
 * 
 * @property int $id
 * @property string $razon_social
 * @property string $abrev_rs
 * @property string $ruc
 * @property string $direccion
 * @property string $telefono
 * @property string $logo
 * @property float $igv
 * @property string $moneda
 *
 * @package App\Models
 */
class TmDatosEmpresa extends Eloquent
{
	protected $table = 'tm_datos_empresa';
	public $timestamps = false;

	protected $casts = [
		'igv' => 'float'
	];

	protected $fillable = [
		'razon_social',
		'abrev_rs',
		'ruc',
		'direccion',
		'telefono',
		'logo',
		'igv',
		'moneda'
	];
}
