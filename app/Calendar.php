<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CalendarStatus;
use App\Employee;
use App\Product;
use App\Customer;

class Calendar extends Model
{
    protected $table = 'calendar';

    protected $fillable = [
        'status_id',
        'customer_id',
        'employee_id',
        'service_id',
        'date',
        'notes'
    ];

    protected $casts = [
    	'status_id' => 'integer',
    	'customer_id' => 'integer',
    	'employee_id' => 'integer',
    	'service_id' => 'integer',
    ];

    public function status() {
    	return $this->hasOne(CalendarStatus::class, 'id', 'status_id');
    }

    public function employee() {
    	return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function service() {
    	return $this->hasOne(Product::class, 'id', 'service_id');
    }

    public function customer() {
    	return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
