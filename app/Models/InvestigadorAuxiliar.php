<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class InvestigadorAuxiliar
 * 
 * @property int $id
 * @property int $investigador_id
 * @property int|null $pueblo_indigena_id
 * @property int|null $tipo_dedicacion_id
 * @property int|null $tiempo_dedicacion_id
 * @property int|null $organizacion_social_id
 * @property int|null $area_local_id
 * 
 * @property Investigadore $investigadore
 * @property PuebloIndigena|null $pueblo_indigena
 * @property TipoDedicacion|null $tipo_dedicacion
 * @property TiempoDedicacion|null $tiempo_dedicacion
 * @property OrganizacionesSociale|null $organizaciones_sociale
 *
 * @package App\Models
 */
class InvestigadorAuxiliar extends Model
{
    use SoftDeletes;
	protected $table = 'investigador_auxiliar';
	public $timestamps = false;

	protected $casts = [
		'investigador_id' => 'int',
		'pueblo_indigena_id' => 'int',
		'tipo_dedicacion_id' => 'int',
		'tiempo_dedicacion_id' => 'int',
		'organizacion_social_id' => 'int',
		'area_local_id' => 'int'
	];

	protected $fillable = [
		'investigador_id',
		'pueblo_indigena_id',
		'tipo_dedicacion_id',
		'tiempo_dedicacion_id',
		'organizacion_social_id',
		'area_local_id'
	];

    protected $dates = ['deleted_at'];

	public function investigadore()
	{
		return $this->belongsTo(Investigadore::class, 'investigador_id');
	}

	public function pueblo_indigena()
	{
		return $this->belongsTo(PuebloIndigena::class);
	}

	public function tipo_dedicacion()
	{
		return $this->belongsTo(TipoDedicacion::class);
	}

	public function tiempo_dedicacion()
	{
		return $this->belongsTo(TiempoDedicacion::class);
	}

	public function organizaciones_sociale()
	{
		return $this->belongsTo(OrganizacionesSociale::class, 'organizacion_social_id');
	}
}
