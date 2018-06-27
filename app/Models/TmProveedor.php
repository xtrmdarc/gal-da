<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmProveedor
 * 
 * @property int $id_prov
 * @property string $ruc
 * @property string $razon_social
 * @property string $direccion
 * @property int $telefono
 * @property string $email
 * @property string $contacto
 * @property string $estado
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_compras
 *
 * @package App\Models
 */
class TmProveedor extends Eloquent
{
	protected $table = 'tm_proveedor';
	protected $primaryKey = 'id_prov';
	public $timestamps = false;

	protected $casts = [
		'telefono' => 'int'
	];

	protected $fillable = [
		'ruc',
		'razon_social',
		'direccion',
		'telefono',
		'email',
		'contacto',
		'estado',
		'id_sucursal'
	];

	public function tm_compras()
	{
		return $this->hasMany(\App\Models\TmCompra::class, 'id_prov');
	}
}
