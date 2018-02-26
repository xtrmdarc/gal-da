<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmCliente
 * 
 * @property int $id_cliente
 * @property string $dni
 * @property string $ruc
 * @property string $ape_paterno
 * @property string $ape_materno
 * @property string $nombres
 * @property string $razon_social
 * @property int $telefono
 * @property \Carbon\Carbon $fecha_nac
 * @property string $correo
 * @property string $direccion
 * @property string $estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_venta
 *
 * @package App\Models
 */
class TmCliente extends Eloquent
{
	protected $table = 'tm_cliente';
	protected $primaryKey = 'id_cliente';
	public $timestamps = false;

	protected $casts = [
		'telefono' => 'int'
	];

	protected $dates = [
		'fecha_nac'
	];

	protected $fillable = [
		'dni',
		'ruc',
		'ape_paterno',
		'ape_materno',
		'nombres',
		'razon_social',
		'telefono',
		'fecha_nac',
		'correo',
		'direccion',
		'estado'
	];

	public function tm_venta()
	{
		return $this->hasMany(\App\Models\TmVentum::class, 'id_cliente');
	}
}
