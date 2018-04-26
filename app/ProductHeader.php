<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductHeader extends Model
{
    protected $fillable = [
    	'name', 'description', 'image'
    ];
}
