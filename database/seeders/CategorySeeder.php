<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $attributes = Attribute::where('status', 1)->get();
        // create category
        Category::create([
            'title' => 'Laravel',
            'slug' => 'laravel',
            'description' => $faker->text(100),
            'status' => 1,
        ]);
        // get all langaues
        for ($i = 0; $i < rand(10, 15); $i++) {
            $parent = rand(0, 1);
            $category = new Category();
            $category->title = $faker->name;
            $category->slug = Str::slug($category->title);
            $category->description = $faker->sentence;
            $category->status = rand(0, 1);
            $category->parent_id = $parent ? Category::all()->random()->id : null;
            $category->save();
            // create category attributes
            $attributes->each(function ($attribute) use ($category, $faker) {
                $options = $attribute->options ? json_decode($attribute->options)[rand(0, (sizeof(json_decode($attribute->options))-1))] : $faker->word;
                $categoryAttribute = $category->categoryAttribute()->create([
                    'attribute_id' => $attribute->id,
                    'value' => $attribute->type == 'select' ? $options->title : $options,
                ]);
                $category->slug .='-'. Str::slug($categoryAttribute->value);
            });
            $category->save();

            
        }
    }
}
