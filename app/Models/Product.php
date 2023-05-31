<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];
    protected $with = ['category'];

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function($query, $search){
            return $query->where('name','like','%' . $search . '%')
                        ->where('category_id', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? false, function($query, $category) {
            return $query->where('category_id', $category);
        });

        
        $query->when($filters['sort'] ?? false, function($query, $sort) {
            $sort = explode(' ', $sort);
            return $query->orderBy($sort[0], $sort[1]);
        });
        
        // $query->when($filters['author'] ?? false, fn($query, $author)=>
        //         $query->whereHas('author', fn($query) =>
        //                 $query->where('username', $author)
        //                 ) 
        //             );
    }
    
    public function updateStock($stock)
    {
        $this->stock += $stock;
        $this->save();
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product')->withPivot('price');
    }

    public function categories()
    {
        return $this->join('categories', 'products.category_id', '=', 'orders.id')
                    ->select('categories.name');
    }

}
