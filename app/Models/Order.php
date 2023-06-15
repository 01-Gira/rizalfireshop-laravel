<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded =['id'];
    // protected $fillable = [
    //     'id','name', 'email','phone','courier','courier_service','address','message',
    //     'message','weight','total_price','order_status','customer_id'
    // ];

    protected $attributes = [
        'transaction_status' => 'unpaid', // nilai default untuk kolom payment_status
        'status_order' => 'new'
    ];
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('name','like', '%' . $search . '%')
                            ->where('order_id', 'like', '%' . $search . '%');
                            // ->where('email','like','%' . $search . '%')
                            // ->where('courier','like','%' . $search . '%')
                            // ->where('courier_service','like', '%' . $search . '%')
                            // ->where('weight','like','%' . $search . '%')
                            // ->where('transaction_status','like','%' . $search . '%')
                            // ->where('total_price','like','%' . $search . '%')
                            // ->where('order_status','like','%' . $search . '%');
        });

        
        $query->when($filters['status_transaction'] ?? false, function($query, $status_transaction) {
            return $query->where('status_transaction', $status_transaction);
        });

        $query->when($filters['sort'] ?? false, function($query, $sort) {
            $sort = explode(' ', $sort);
            return $query->orderBy($sort[0], $sort[1]);
        });

    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        // return $this->belongsToMany(Product::class,'order_products')->withPivot('quantity');
        return $this->belongsToMany(Product::class,'order_products');
    }

}
