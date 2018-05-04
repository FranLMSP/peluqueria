<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\Provider;
use App\Inventory;
use App\TransactionType;

class Transaction extends Model
{
    $fillable = [
    	'customer_id',
    	'provider_id',
    	'description',
    	'transaction_type_id',
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
    	return $this->hasOne(TransactionType::class, 'id', 'Transaction');
    }

    public function products()
    {
    	return $this->hasMany(Inventory::class, 'transaction_id');
    }
}
