<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductHeader;

class Product extends Model
{

	protected $fillable = [
		'price', 'product_header_id'
	];

    protected $casts = [
        'active' => 'boolean',
    	'product_header_id' => 'integer',
        'price' => 'float'
    ];

    protected $hidden = [
        'active'
    ];

    public function definition()
    {
    	return $this->belongsTo(ProductHeader::class, 'product_header_id', 'id');
    }
}
