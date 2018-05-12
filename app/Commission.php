<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;
use App\Employee;

class Commission extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'percentage',
    	'service_id',
    	'employee_id'
    ];

    protected $casts = [
    	'percentage' => 'integer',
    	'service_id' => 'integer',
    	'employee_id' => 'integer',
    ];

    public function service()
    {
    	return $this->hasOne(Product::class, 'id', 'service_id');
    }

    public function employee()
    {
    	return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
}
