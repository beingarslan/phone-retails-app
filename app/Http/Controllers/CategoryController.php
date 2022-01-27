<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables as DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public $user;
    public $categories;
    public $category_options;
    public $attributes;
    public function __construct()
    {
        // get categories which has no parent
        $this->categories = Category::whereNull('parent_id')->get();
        // processing the attributes
        $attributes = Attribute::where('status', 1)->orderBy('sort_order', 'desc')->get();
        $this->attributes = $attributes;
        // dd($this->attributes);

        $this->category_options = '';
        foreach ($this->categories as $category) {
            $this->category_options .= '<option value="' . $category->id . '">' . $category->title . '</option>';
        }
    }
    public function manage()
    {
        $categories = $this->categories;

        $attributes = $this->attributes;
        return view('admin.categories.manage', [
            'categories' => $categories,
            'attributes' => $attributes,
        ]);
    }

    public function categories()
    {
        try {
            return DataTables::of(Category::with('attributes')->get())
                ->addColumn('parent', function ($category) {
                    return $category->parent_id ? $category->parent->title : 'N/A';
                })
                ->addColumn('description', function ($category) {
                    return substr($category->description, 0, rand(30, 40));
                })
                ->addColumn('action', function ($category) {
                    return '
                <div class="btn-group">
                <a href="/admin/categories/update/' . $category->id . '" class="btn btn-outline-primary waves-effect" >Edit</a>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $category->id . '">X</button>
                ' . $this->remove_user_form($category) . '
                </div>
                ';
                })
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    public function remove_user_form($category)
    {
        return '
        <form action="' . route('admin.categories.remove') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $category->id . '">
                    <div class="modal fade" id="removeModel' . $category->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remove ' . $category->title . '</h5>
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
        $validated = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required|max:100',
            'description' => 'required|max:255',
            'status' => 'required|in:1,0',

        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $category = Category::find($request->id);
                $category->title = $request->title;
                $category->description = $request->description;
                $category->status = $request->status;
                $category->categoryAttribute()->delete();
                foreach ($request->input('attributes') as $attribute) {
                    $category->categoryAttribute()->create([
                        'attribute_id' => $attribute,
                    ]);
                }
                $category->save();
                Alert::success('Success', 'Category Created Successfully!');
            });

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
            $user = Category::where('id', $request->input('id'))->delete();
            Alert::success('Success', 'Category deleted Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());

            return redirect()->back();
        }
    }
    public function save(Request $request)
    {
        // Validate user data
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'required|max:255',
        ]);

        // print validation error message
        if ($validated->fails()) {

            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $category =  Category::create([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'parent_id' => $request->input('parent_id'),
                ]);
                foreach ($request->input('attributes') as $attribute) {
                    $category->categoryAttribute()->create([
                        'attribute_id' => $attribute,
                    ]);
                }

                Alert::success('Success', 'Category Created Successfully!');
            });


            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }


    public function update($id)
    {
        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }
        $category = Category::where('id', $id)->with('categoryAttribute')->first();
        $attributes = Attribute::where('status', 1)->orderBy('sort_order', 'desc')->get();
        return view('admin.categories.update', compact('category', 'attributes'));
    }
}
