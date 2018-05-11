<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    public $timestamps = false;

    protected $casts = [
    	'sell' => 'boolean'
    ];

    protected $hidden = [
    	'sell'
    ];
}
