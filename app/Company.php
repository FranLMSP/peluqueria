<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Commune;

class Company extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'name',
		'address',
		'phone',
		'secondary_phone',
		'email',
		'website',
		'shortname',
		'boxes',
		'color',
		'image',
		'main',
		'commune_id',
	];

	protected $casts = [
		'boxes' => 'integer',
		'commune_id' => 'integer',
		'main' => 'boolean'
	];

	public function commune() {
		return $this->hasOne(Commune::class, 'id', 'commune_id');
	}
}
