<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    public $timestamps = false;

    public function region()
    {
    	return $this->hasOne(Customer::class, 'id', 'region_id');
    }
}
