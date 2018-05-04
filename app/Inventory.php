<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Inventory extends Model
{
    protected $fillable = [
    	'product_id',
    	'qty'
    ];

    protected $casts = [
    	'qty' => 'integer'
    ];

    public function product()
    {
    	return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
