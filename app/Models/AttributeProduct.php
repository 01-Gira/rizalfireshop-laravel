<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
    
}
