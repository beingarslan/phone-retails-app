<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables as DataTables;

class CategoryController extends Controller
{
    public $user;
    public $categories;
    public $category_options;
    public function __construct()
    {
        // get categories which has no parent
        $this->categories = Category::whereNull('parent_id')->get();
        $this->category_options = '';
        foreach ($this->categories as $category) {
            $this->category_options .= '<option value="' . $category->id . '">' . $category->title . '</option>';
        }
    }
    public function manage()
    {
        $categories = $this->categories;

        return view('admin.categories.manage', [
            'categories' => $categories,
        ]);
    }

    public function categories()
    {
        try {
            return DataTables::of(Category::all())
                ->addColumn('parent', function ($category) {
                    return $category->parent_id ? $category->parent->title : 'N/A';
                })
                ->addColumn('description', function ($category) {
                    return substr($category->description, 0, rand(30, 40));
                })
                ->addColumn('action', function ($category) {
                    return '
                <div class="btn-group">
                <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#editModel' . $category->id . '">Edit</button>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $category->id . '">X</button>
                ' . $this->edit_user_form($category) . '
                ' . $this->remove_user_form($category) . '
                </div>
                ';
                })
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit_user_form($category)
    {

        return '
            <div class="modal fade" id="editModel' . $category->id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Update Category</h1>
                            <!-- <p>Updating user details will receive a privacy audit.</p> -->
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" action="' . route('admin.categories.edit') . '" method="POST">
                        ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $category->id . '">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" class="form-control" id="name" name="title" placeholder="Title" value="' . $category->title . '">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description">' . $category->description . '</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="parent">Parent</label>
                                    <select class="form-control select2" id="parent" name="parent_id">
                                        <option selected value="' . ($category->parent_id ? $category->parent_id : '') . '">' . ($category->parent_id ? $category->parent->title : 'Select Parent Category') . '</option>
                                        ' . $this->category_options . '
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" ' . ($category->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    <div class="form-check form-check-warning">
                                        <input class="form-check-input"  type="radio" name="status" id="inlineRadio2" value="0" ' . ($category->status ? '' : 'checked') . ' >
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
        // Validate user data
        $validated = Validator::make($request->all(), [
            'id' => 'required|integer',
            'title' => 'required|max:100',
            'status' => 'required|integer',
            'description' => 'required|max:255',
        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $category = Category::find($request->id);
            $userupdate =  $category->update([
                'title' => $request->input('title'),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
                'parent_id' => $request->input('parent_id'),
            ]);

            Alert::success('Success', 'Category Updated Successfully!');

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

            return redirect()->back()->with('success', 'Category has been removed!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Try Again!');
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
            $user =  Category::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'parent_id' => $request->input('parent_id'),
            ]);

            Alert::success('Success', 'Category Added Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }
}
