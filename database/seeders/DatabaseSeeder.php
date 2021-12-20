<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            CapacitySeeder::class,
            ColorSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
