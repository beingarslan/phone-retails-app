<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeSeeder extends Seeder
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
            $attribute = new Attribute();
            $attribute->title = $faker->word();
            $attribute->description = $faker->sentence();
            $attribute->status = rand(0, 1);
            $attribute->slug = Str::slug($attribute->title);
            $attribute->save();
        }
    }
}
