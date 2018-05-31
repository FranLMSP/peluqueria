<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MailStatus;

class Mail extends Model
{
    protected $fillable = [
    	'customer_id',
    	'status_id',
    	'subject',
    	'message',
    	'email'
    ];

    protected $casts = [
    	'customer_id' => 'integer',
    	'status_id' => 'integer',
    ];

    public function status()
    {
    	return $this->hasOne(MailStatus::class, 'id', 'status_id');
    }

    public function customer()
    {
    	return $this->hasOne(MailStatus::class, 'id', 'customer_id');
    }
}
