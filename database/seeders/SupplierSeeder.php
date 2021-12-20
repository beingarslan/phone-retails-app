<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i=0; $i < rand(10, 15); $i++) { 
            $supplier = new Supplier();
            $supplier->name = $faker->company;
            $supplier->short_name = $faker->word();
            $supplier->slug = Str::slug($supplier->name);
            $supplier->email = $faker->email;
            $supplier->phone = $faker->phoneNumber;
            $supplier->address = $faker->address;
            $supplier->status = rand(0, 1);
            $supplier->country = $faker->country;
            $supplier->contact_person_name = $faker->name;
            $supplier->contact_person_phone = $faker->phoneNumber;
            $supplier->contact_person_email = $faker->email;
            $supplier->logo = $faker->imageUrl(400, 400, 'technics');
            $supplier->save();
        }
    }
}
