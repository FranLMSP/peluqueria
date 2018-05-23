<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarStatus extends Model
{
    public $timestamps = false;

    protected $casts = [
    	'active' => 'boolean'
    ];
}
