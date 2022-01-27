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

        $categories =  Category::where('status', 1)->with('attributes')->get();
        foreach ($categories as $category) {
            for ($i = 0; $i < rand(1, 10); $i++) {
                $product = $category->products()->create([
                    'title' => $faker->text(rand(5, 10)),
                    'slug' => Str::slug($faker->text(rand(5, 10))),
                    'description' => $faker->paragraph(rand(3, 6)),
                    'status' => rand(0, 1),
                    'image' => $faker->imageUrl(400, 400, 'technics'),
                    'meta_title' => $faker->sentence(rand(3, 6))
                ]);

                $product->attributes()->sync($category->attributes->pluck('id')->toArray());
            }
        }
    }
}
