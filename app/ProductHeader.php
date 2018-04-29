<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductHeader extends Model
{

	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [
    	'name', 'description', 'image', 'type'
    ];
}
