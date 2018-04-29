<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = [
	        'names',
	        'surnames',
	        'identity_number',
	        'email',
	        'phone',
	        'birthdate'
	    ];

	protected $casts = [
		'identity_number' => 'integer'
	];
}
