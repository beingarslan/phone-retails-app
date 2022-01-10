<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public $user;
    public $products;
    public $categories;
    public $category_options;
    public function __construct()
    {
        $this->products = Product::all();
        $this->categories = Category::where('status', 1)->get();
        $this->category_options = '';
        foreach($this->categories as $category){
            $this->category_options.='<option value="'.$category->id.'">'.$category->title.'</option>';
        }
    }
    public function manage()
    {
        $categories = $this->categories;
        return view('admin.products.manage', [
            'categories' => $categories
        ]);
    }

    public function products()
    {
        try {
            return DataTables::of(Product::with('category')->get())

                ->addColumn('action', function ($product) {
                    return '
                <div class="btn-group">
                <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#editModel' . $product->id . '">Edit</button>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $product->id . '">X</button>
                ' . $this->edit_user_form($product) . '
                ' . $this->remove_user_form($product) . '
                </div>
                ';
                })
                ->addColumn('category', function ($product) {
                    return $product->category->title;
                })
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit_user_form($product)
    {

        return '
            <div class="modal fade" id="editModel' . $product->id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Update Product</h1>
                            <!-- <p>Updating user details will receive a privacy audit.</p> -->
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" action="' . route('admin.products.edit') . '" method="POST">
                        ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $product->id . '">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" class="form-control" id="name" name="title" placeholder="Title" value="' . $product->title . '">
                                </div>
                            </div>
                            <div class="col-12 mb-0">
                                <div class="form-group">
                                <label class="form-label">Model</label>
                                <input type="text" class="form-control" name="model" value="' . $product->model . '" placeholder="Enter Model">
                                </div>
                            </div>
                            <!-- sku -->
                            <div class="col-12 mb-0">
                                <div class="form-group">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" value="' . $product->sku . '" placeholder="Enter SKU">
                                </div>
                            </div>
                            <!-- ean -->
                            <div class="col-12 mb-0">
                                <div class="form-group">
                                <label class="form-label">EAN</label>
                                <input type="text" class="form-control" name="ean" value="' . $product->ean . '" placeholder="Enter EAN">
                                </div>
                            </div>
                            <!-- image -->
                            <!-- <div class="col-12 mb-0">
                                <div class="form-group">
                                <label class="form-label">Image</label>
                                <input type="text" class="form-control" name="image" placeholder="Enter Image">
                                </div>
                            </div> -->

                            
                        
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Description</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3" placeholder="Description">'.$product->description.'</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Meta Title</label>
                                    <input type="text" class="form-control" id="email" name="meta_title" placeholder="Meta Title" value="' . $product->meta_title . '">
                                </div> 
                            </div>   

                            <div class="col-md-12 mb-0">
                                <label class="form-label" for="select2-basic">Category</label>
                                <select name="category_id" class="category form-select" id="select2-basic">
                                    <option selected value="'.$product->category_id.'">'.$product->category->title.'</option>
                                    '.$this->category_options.'
                                </select>
                            </div>
                           
                            
                            <div class="col-12">
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" ' . ($product->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    <div class="form-check form-check-warning">
                                        <input class="form-check-input"  type="radio" name="status" id="inlineRadio2" value="0" ' . ($product->status ? '' : 'checked') . ' >
                                        <label class="form-check-label" for="inlineRadio2">In-Active</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-2 pt-50">
                                <button type="submit" class="btn btn-primary me-1">Save Changes</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                    Discard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ';
    }


    public function remove_user_form($product)
    {
        return '
        <form action="' . route('admin.products.remove') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $product->id . '">
                    <div class="modal fade" id="removeModel' . $product->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remove ' . $product->name . '</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <h1 class="text-danger">Are you sure?</h1>
                                      
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        
        ';
    }


    public function edit(Request $request)
    {
        // Validate user data
        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            'title' => 'required|max:100',
            'model' => 'required|max:100',
            'sku' => 'required|max:100',
            'ean' => 'required|max:100',
            'category_id' => 'required|max:100',
            'status' => 'required|integer',
            'description' => 'sometimes|max:255',
        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $product = Product::find($request->id);
            $category = Category::find($request->category_id)->first();
            $userupdate =  $product->update([
                'title' => $request->input('title'),
                'model' => $request->input('model'),
                'sku' => $request->input('sku'),
                'ean' => $request->input('ean'),
                'category_id' => $request->input('category_id'),
                'slug' =>  Str::slug($category->slug.'-'.$request->input('title'). '-'.$request->input('model')),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
            ]);

            Alert::success('Success', 'Product Updated Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }


    public function remove(Request $request)
    {
        try {
            // dd($request->all());
            $user = Product::where('id', $request->input('id'))->delete();

            return redirect()->back()->with('success', 'Product has been removed!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Try Again!');
        }
    }
    public function save(Request $request)
    {
        // Validate user data
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'model' => 'required|max:100',
            'sku' => 'required|max:100',
            'ean' => 'required|max:100',
            'category_id' => 'required|max:100',
            'description' => 'sometimes|max:255',
        ]);

        // print validation error message
        if ($validated->fails()) {

            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $product = new Product();
            $category = Category::find($request->category_id)->first();
            $product->title = $request->input('title');
            $product->model = $request->input('model');
            $product->sku = $request->input('sku');
            $product->ean = $request->input('ean');
            $product->category_id = $request->input('category_id');
            $product->slug =  Str::slug($category->slug.'-'.$request->input('title'). '-'.$request->input('model'));  
            $product->status = $request->input('status');
            $product->description = $request->input('description');
            $product->save();


            Alert::success('Success', 'Product Added Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }
}
