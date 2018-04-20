<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 25 Feb 2018 16:39:48 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TmRol
 * 
 * @property int $id_rol
 * @property string $descripcion
 * 
 * @property \Illuminate\Database\Eloquent\Collection $tm_usuarios
 *
 * @package App\Models
 */
class TmRol extends Eloquent
{
	protected $table = 'tm_rol';
	protected $primaryKey = 'id_rol';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function tm_usuarios()
	{
		return $this->hasMany(\App\Models\TmUsuario::class, 'id_rol');
	}
}
