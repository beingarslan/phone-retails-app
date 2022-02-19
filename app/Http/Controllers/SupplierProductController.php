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
    public function manage(Request $request, $supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);
        if (!$supplier) {
            abort(404);
        }
        $supplierProducts = $supplier->supplierProducts;
        $supplierProductsIds = $supplierProducts->pluck('product_id')->toArray();

        $products = Product::whereNotIn('id', $supplierProductsIds)->orderBy('created_at', 'desc')->get();

        $supplier_products = $supplier->products;

        return view('admin.supplier_product.manage', compact('products', 'supplier_products', 'supplier'));
    }

    // save
    public function save(Request $request)
    {
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
    public function remove(Request $request)
    {
        try {
            // dd($request->id);
            $supplierProduct = SupplierProduct::where('product_id', $request->id);
            $supplierProduct->delete();
            Alert::success('Success', 'Product removed successfully');
            return response()->json(['success' => 'Product removed successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function manageProductSuppliers(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        if (!$product) {
            abort(404);
        }
        $productSuppliers = $product->suppliers;
        $productSuppliersIds = $productSuppliers->pluck('id')->toArray();
        $suppliers = Supplier::whereNotIn('id', $productSuppliersIds)->orderBy('created_at', 'desc')->get();
        $product_suppliers = $product->suppliers;

        return view('admin.product_suppliers.manage', compact('suppliers', 'product_suppliers', 'product'));
    }
    public function saveProductSuppliers(Request $request)
    {
        try {
            $supplier = Product::findOrFail($request->product_id);
            $supplier->suppliers()->attach($request->suppliers_id);
            Alert::success('Success', 'Supplier added successfully');
            return redirect()->back()->with('success', 'Supplier added successfully');
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong');
            return redirect()->back()->with('error', 'Something went wrong');
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Error', 'Something went wrong');
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function removeProductSuppliers(Request $request)
    {
        try {
            // dd($request->id);
            $productSupplier = SupplierProduct::where('supplier_id', $request->id);
            $productSupplier->delete();
            Alert::success('Success', 'Supplier removed successfully');
            return response()->json(['success' => 'Supplier removed successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => 'Something went wrong']);
        }
    }
}
