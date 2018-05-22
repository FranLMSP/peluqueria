<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Region;

class Commune extends Model
{
    public $timestamps = false;

    public $casts = [
    	'region_id' => 'integer'
    ];

    public function region()
    {
    	return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
