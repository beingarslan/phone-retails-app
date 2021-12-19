<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i=0; $i < rand(10,15); $i++) { 
            $color = Color::all()->random();
            $capacity = Capacity::all()->random();
            $category = Category::all()->random();
            $brand = Brand::all()->random();

            $product = new Product();
            $product->model = $faker->word;
            $product->title = $brand->name. ' '.$product->model. ' '.$capacity->name. ' '.$color->name;
            $product->slug = Str::slug($product->title);
            $product->description = $faker->paragraph(rand(3,6));
            $product->price = $faker->randomFloat(2, 10, 100);
            $product->discount = $faker->randomFloat(2, 0, $product->price);
            $product->status = rand(0,1);
            $product->sku = $faker->ean8;
            $product->ean = $faker->ean13;
            $product->image = $faker->imageUrl(400, 400, 'technics');
            $product->meta_title = $faker->sentence(rand(3,6));
            $product->brand_id = $brand->id;
            $product->category_id = $category->id;
            $product->capacity_id = $capacity->id;
            $product->color_id = $color->id;
            $product->save();
        }
    }
}
