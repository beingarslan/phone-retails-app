<?php

namespace App\Http\Controllers;

use App\Models\SupplierProduct;
use App\Http\Requests\StoreSupplierProductRequest;
use App\Http\Requests\UpdateSupplierProductRequest;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use RealRashid\SweetAlert\Toaster;

class SupplierProductController extends Controller
{
    public function manage(Request $request, $supplier_id){
        $supplier = Supplier::findOrFail($supplier_id);
        if(!$supplier){
            abort(404);
        }
        $supplierProducts = $supplier->supplierProducts;
        $supplierProductsIds = $supplierProducts->pluck('product_id')->toArray();

        $products = Product::whereNotIn('id', $supplierProductsIds)->orderBy('created_at', 'desc')->get();

        $supplier_products = $supplier->products;

        return view('admin.supplier_product.manage', compact('products', 'supplier_products', 'supplier'));
    }

    // save
    public function save(Request $request){
        try {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $supplier->products()->attach($request->product_id);
            Alert::success('Success', 'Product added successfully');
            return redirect()->back()->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong');
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Error', 'Something went wrong');
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
