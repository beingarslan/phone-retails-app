<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    // CONTRUCTOR
    public $brands;
    public $categories;
    public $capacities;
    public $colors;

    public function __construct()
    {
        $this->categories = Category::all();
    }
    public function manage(){
        
        $categories = $this->categories;

        return view('admin.products.manage', compact('categories'));
    }

    public function products(){
        $products = Product::all();
        return view('admin.products.products', compact('products'));
    }
}
