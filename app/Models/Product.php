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
                    ->orWhere('category','like','%' . $search . '%');
        });

        // $query->when($filters['category'] ?? false, function($query, $category){
        //     return $query->whereHas('category', function($query) use ($category){
        //         $query->where('slug', $category);
        //     });
        // });
        
        // $query->when($filters['author'] ?? false, fn($query, $author)=>
        //         $query->whereHas('author', fn($query) =>
        //                 $query->where('username', $author)
        //                 ) 
        //             );
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    
    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = str_replace(' ', ', ', $value);
    }
    
    public function getColorAttribute($value)
    {
        return str_replace(' ', ', ', $value);
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
}
