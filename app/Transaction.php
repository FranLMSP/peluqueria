<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Customer;
use App\Provider;
use App\Inventory;
use App\TransactionType;

class Transaction extends Model
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'customer_id',
    	'provider_id',
    	'description',
    	'transaction_type_id',
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'provider_id' => 'integer',
        'transaction_type_id' => 'integer'
    ];

    public function customer()
    {
    	return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function provider()
    {
    	return $this->hasOne(Provider::class, 'id', 'provider_id');
    }

    public function type()
    {
    	return $this->hasOne(TransactionType::class, 'id', 'transaction_type_id');
    }

    public function products()
    {
    	return $this->hasMany(Inventory::class, 'transaction_id');
    }
}
