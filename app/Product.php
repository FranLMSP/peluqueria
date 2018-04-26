<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ProductHeader;

class Product extends Model
{

	protected $fillable = [
		'price', 'product_header_id'
	];

    protected $casts = [
    	'active' => 'boolean'
    ];

    public function definition()
    {
    	return $this->belongsTo(ProductHeader::class);
    }
}
