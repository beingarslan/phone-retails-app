<?php

namespace Database\Seeders;

use App\Models\Capacity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CapacitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $size = [4, 8, 16, 32, 64, 128, 256, 512];

        for ($i=0; $i < rand(5,10); $i++) { 
           $capacity = new Capacity();
           $capacity->name = $size[rand(0, sizeof($size)-1)].' GB';
           $capacity->slug = Str::slug($capacity->name);
           $capacity->save();

        }
    }
}
