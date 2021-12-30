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
        $attributes = array(
            [
                'title' => 'Color',
                'slug' => 'color',
                'description' => 'Color of the product',
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'title' => 'Size',
                'slug' => 'size',
                'description' => 'Size of the product',
                'status' => 1,
                'sort_order' => 2,
            ],
            [
                'title' => 'Weight',
                'slug' => 'weight',
                'description' => 'Weight of the product',
                'status' => 1,
                'sort_order' => 3,
            ],
            [
                'title' => 'Brand',
                'slug' => 'brand',
                'description' => 'Brand of the product',
                'status' => 1,
                'sort_order' => 4,
            ],
            [
                'title' => 'Model',
                'slug' => 'model',
                'description' => 'Model of the product',
                'status' => 1,
                'sort_order' => 5,
            ],
            [
                'title' => 'Material',
                'slug' => 'material',
                'description' => 'Material of the product',
                'status' => 1,
                'sort_order' => 6,
            ],
        );
        Attribute::insert($attributes);
        // for ($i = 0; $i < rand(5, 10); $i++) {
        //     $attribute = new Attribute();
        //     $attribute->title = $faker->word();
        //     $attribute->description = $faker->sentence();
        //     $attribute->status = rand(0, 1);
        //     $attribute->slug = Str::slug($attribute->title);
        //     $attribute->save();
        // }
    }
}
