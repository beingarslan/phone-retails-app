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

        $categories =  Category::where('status', 1)->get();
        foreach ($categories as $category) {
            for ($i = 0; $i < rand(1, 10); $i++) {
                $product = new Product();
                $product->model = $faker->word;
                $product->title = $faker->firstName();
                $product->slug = Str::slug($category->slug . '-' . $product->title);
                $product->description = $faker->paragraph(rand(3, 6));
                $product->status = rand(0, 1);
                $product->sku = $faker->ean8;
                $product->ean = $faker->ean13;
                $product->image = $faker->imageUrl(400, 400, 'technics');
                $product->meta_title = $faker->sentence(rand(3, 6));
                $product->category_id = $category->id;
                $product->save();
            }
        }
    }
}
