<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Attribute as ModelsAttribute;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
 
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password'=>bcrypt('123456'),
        // ]);

        $this->call(AdminTableSeeder::class);
        $this->call(CouriersTableSeeder::class);
        $this->call(LocationsTableSeeder::class);


        Product::factory(100)->create();
        Customer::factory(5)->create();

        Customer::create([
            'name' => 'Gira',
            'email' => '123@gmail.com',
            'mobile' => fake()->phoneNumber(),
            'password' => bcrypt('123456'), // password default 'password'
            'remember_token' => Str::random(10),
        ]);


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

    }
}
