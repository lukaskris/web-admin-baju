<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
	public function customer()
    {
        return $this->belongsTo(Customer::class,'user_id');
    }
}
