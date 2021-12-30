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
                'type' => 'select',
                'options' => json_encode( Array(
                    [
                        'title' => 'Red',
                        'slug' => 'red',
                        'description' => 'Red color',
                        'status' => 1,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Blue',
                        'slug' => 'blue',
                        'description' => 'Blue color',
                        'status' => 1,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Green',
                        'slug' => 'green',
                        'description' => 'Green color',
                        'status' => 1,
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'Yellow',
                        'slug' => 'yellow',
                        'description' => 'Yellow color',
                        'status' => 1,
                        'sort_order' => 4,
                    ],
                    [
                        'title' => 'Black',
                        'slug' => 'black',
                        'description' => 'Black color',
                        'status' => 1,
                        'sort_order' => 5,
                    ],
                    [
                        'title' => 'White',
                        'slug' => 'white',
                        'description' => 'White color',
                        'status' => 1,
                        'sort_order' => 6,
                    ],
                )),
            ],
            [
                'title' => 'Size',
                'slug' => 'size',
                'description' => 'Size of the product',
                'status' => 1,
                'sort_order' => 2,
                'type' => 'select',
                'options' => json_encode( Array(
                    [
                        'title' => 'Small',
                        'slug' => 'small',
                        'description' => 'Small size',
                        'status' => 1,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Medium',
                        'slug' => 'medium',
                        'description' => 'Medium size',
                        'status' => 1,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Large',
                        'slug' => 'large',
                        'description' => 'Large size',
                        'status' => 1,
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'X-Large',
                        'slug' => 'x-large',
                        'description' => 'X-Large size',
                        'status' => 1,
                        'sort_order' => 4,
                    ],
                    [
                        'title' => 'XX-Large',
                        'slug' => 'xx-large',
                        'description' => 'XX-Large size',
                        'status' => 1,
                        'sort_order' => 5,
                    ],
                ))
            ],
            [
                'title' => 'Weight',
                'slug' => 'weight',
                'description' => 'Weight of the product',
                'status' => 1,
                'sort_order' => 3,
                'type' => 'select',
                'options' => json_encode( Array(
                    [
                        'title' => 'Light',
                        'slug' => 'light',
                        'description' => 'Light weight',
                        'status' => 1,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Medium',
                        'slug' => 'medium',
                        'description' => 'Medium weight',
                        'status' => 1,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Heavy',
                        'slug' => 'heavy',
                        'description' => 'Heavy weight',
                        'status' => 1,
                        'sort_order' => 3,
                    ],
                ))
            ],
            [
                'title' => 'Brand',
                'slug' => 'brand',
                'description' => 'Brand of the product',
                'status' => 1,
                'sort_order' => 4,
                'type' => 'select',
                'options' => json_encode( Array(
                    [
                        'title' => 'Apple',
                        'slug' => 'apple',
                        'description' => 'Apple brand',
                        'status' => 1,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Samsung',
                        'slug' => 'samsung',
                        'description' => 'Samsung brand',
                        'status' => 1,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Nokia',
                        'slug' => 'nokia',
                        'description' => 'Nokia brand',
                        'status' => 1,
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'Sony',
                        'slug' => 'sony',
                        'description' => 'Sony brand',
                        'status' => 1,
                        'sort_order' => 4,
                    ],
                    [
                        'title' => 'LG',
                        'slug' => 'lg',
                        'description' => 'LG brand',
                        'status' => 1,
                        'sort_order' => 5,
                    ],
                ))
            ],
            [
                'title' => 'Model',
                'slug' => 'model',
                'description' => 'Model of the product',
                'status' => 1,
                'sort_order' => 5,
                'type' => 'select',
                'options' => json_encode( Array(
                    [
                        'title' => 'iPhone X',
                        'slug' => 'iphone-x',
                        'description' => 'iPhone X model',
                        'status' => 1,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'iPhone 8',
                        'slug' => 'iphone-8',
                        'description' => 'iPhone 8 model',
                        'status' => 1,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'iPhone 7',
                        'slug' => 'iphone-7',
                        'description' => 'iPhone 7 model',
                        'status' => 1,
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'iPhone 6',
                        'slug' => 'iphone-6',
                        'description' => 'iPhone 6 model',
                        'status' => 1,
                        'sort_order' => 4,
                    ],
                    [
                        'title' => 'iPhone 5',
                        'slug' => 'iphone-5',
                        'description' => 'iPhone 5 model',
                        'status' => 1,
                        'sort_order' => 5,
                    ],
                ))
            ],
            [
                'title' => 'Material',
                'slug' => 'material',
                'description' => 'Material of the product',
                'status' => 1,
                'sort_order' => 6,
                'type' => 'select',
                'options' => json_encode( Array(
                    [
                        'title' => 'Plastic',
                        'slug' => 'plastic',
                        'description' => 'Plastic material',
                        'status' => 1,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Metal',
                        'slug' => 'metal',
                        'description' => 'Metal material',
                        'status' => 1,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Wood',
                        'slug' => 'wood',
                        'description' => 'Wood material',
                        'status' => 1,
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'Leather',
                        'slug' => 'leather',
                        'description' => 'Leather material',
                        'status' => 1,
                        'sort_order' => 4,
                    ],
                )),
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
