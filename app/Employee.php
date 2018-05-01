<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Occupation;

class Employee extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'names',
		'surnames',
		'identity_number',
		'email',
		'phone',
		'occupation_id',
		'profile_pic',
		'birthdate'
	];

	public function occupation()
	{
		return $this->hasOne(Occupation::class, 'id', 'occupation_id');
	}
}
