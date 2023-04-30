<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded =['id'];
    protected $table = 'order_products';

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
