<?php

namespace Database\Seeders;

use App\Http\Services\RajaOngkirService;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rajaOngkir = new RajaOngkirService();
        $provinces = $rajaOngkir->provinces();
       

        foreach($provinces as $province){
            Province::create([
                'province_id' => $province['province_id'],
                'title' => $province['province']
            ]);
            $cities = $rajaOngkir->cities($province['province_id']);
            foreach($cities as $city){
                City::create([
                    'province_id' => $province['province_id'],
                    'city_id' => $city['city_id'],
                    'title' => $city['city_name']
                ]);
            }
        }
    }
}
