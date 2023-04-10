<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Attribute as ModelsAttribute;
use App\Models\Category;
use App\Models\Product;
use Attribute;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Customer::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password'=>bcrypt('123456'),
        // ]);

        $this->call(AdminTableSeeder::class);
        $this->call(CouriersTableSeeder::class);
        $this->call(LocationsTableSeeder::class);


        Product::factory(20)->create();

        Category::create([
            'name' => 'T-shirt',
            'slug' => 't-shirt',
            
        ]);
        Category::create([
            'name' => 'Jeans',
            'slug' => 'jeans',
            
        ]);
        Category::create([
            'name' => 'Hoodie',
            'slug' => 'hoodie',
            
        ]);

        ModelsAttribute::create([
            'name' => 'Size',
            'type' => implode(',', ['S', 'M', 'L', 'XL']),
        ]);
        ModelsAttribute::create([
            'name' => 'Color',
            'type' => implode(',', ['Red', 'Black']),
        ]);

    }
}
