<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Commune;

class Region extends Model
{
    public $timestamps = false;

    public function communes()
    {
    	return $this->hasMany(Commune::class, 'region_id');
    }
}
