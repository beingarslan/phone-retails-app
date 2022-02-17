<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
       foreach($products as $product) {
           foreach($suppliers as $supplier) {
               if(rand(0,1)) {
                   $product->suppliers()->attach($supplier->id);
               }
           }
       }
    }
}
