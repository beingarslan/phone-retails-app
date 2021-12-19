<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
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
        $this->brands = Brand::all();
        $this->categories = Category::all();
        $this->capacities = Capacity::all();
        $this->colors = Color::all();
    }
    public function manage(){
        
        $brands = $this->brands;
        $categories = $this->categories;
        $capacities = $this->capacities;
        $colors = $this->colors;

        return view('admin.products.manage', compact('brands', 'categories', 'capacities', 'colors'));
    }
}
