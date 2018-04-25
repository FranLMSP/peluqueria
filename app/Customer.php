<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $fillable = [
	        'names',
	        'surnames',
	        'identity_number',
	        'email',
	        'phone',
	        'birthdate'
	    ];
}
