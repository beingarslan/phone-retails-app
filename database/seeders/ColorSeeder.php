<?php

namespace Database\Seeders;

use App\Models\Color;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < rand(5, 10); $i++) {
            $color = new Color();
            $color->name = $faker->colorName();
            $color->slug = Str::slug($color->name);
            $color->save();
        }
    }
}
