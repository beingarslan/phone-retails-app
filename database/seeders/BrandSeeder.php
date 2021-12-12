<?php

namespace Database\Seeders;

use App\Models\Brand;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Factory::create();

        for ($i=0; $i < rand(10,15); $i++) { 
            $brand = new Brand();
            $brand->name = $fake->company;
            $brand->description = $fake->text(rand(100,200));
            $brand->slug = Str::slug($brand->name);
            $brand->status = rand(0,1);
            $brand->save();
        }
    }
}
