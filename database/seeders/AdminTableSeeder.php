<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        $adminRecords = [
            [
                'name' => 'Gira',
                'mobile' => '081234567890', // Nomor telepon seluler dengan 13 digit
                'email' => 'admin@admin.com',
                'password' => $password,
                'image' => '',
                'status' => 0,
                'role' => 'superadmin',
                'remember_token' => Str::random(10),

            ]
        ];
        Admin::insert($adminRecords);
        
    }
}
