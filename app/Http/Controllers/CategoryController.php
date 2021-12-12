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
    public $role;
    public $role_options;
    public function __construct()
    {
        $this->roles = Role::all()->pluck('name');
        $this->role_options = '';
        foreach ($this->roles as $role) {
            $this->role_options .= '<option value="' . $role . '">' . $role . '</option>';
        }
    }
    public function manage()
    {
        // roles
        $roles = $this->roles;

        return view('admin.users.manage', [
            'roles' => $roles,
        ]);
    }

    public function users()
    {
        try {
            return DataTables::of(Category::all())
                ->addColumn('role', function ($category) {
                    return $category->getRoleNames()[0];
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
                ->addColumn('created_at', function ($category) {
                    return $category->created_at != null ? $category->created_at->format('h:i A,   d M, Y') : 'N/A';
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
                            <h1 class="mb-1">Add User</h1>
                            <!-- <p>Updating user details will receive a privacy audit.</p> -->
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" action="' . route('admin.categories.edit') . '" method="POST">
                        ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $category->id . '">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="title" placeholder="Name" value="' . $category->title . '">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-vertical">User Role</label>
                                    <select class="form-control" name="role">
                                        <option selected value="' . $category->getRoleNames()[0] . '">' . $category->getRoleNames()[0] . '</option>
                                        ' . $this->role_options . '
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" ' . ($category->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
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
            'role' => 'required'

        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $category = Category::find($request->id);
            $userupdate =  $category->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'status' => $request->input('status'),

            ]);
            $category->syncRoles([$request->input('role')]);
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
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);

        // print validation error message
        if ($validated->fails()) {
            // foreach ($validated->messages()->getMessages() as $field_name => $messages) {
            //     foreach ($messages as $message) {
            //         $errors[] = $message;
            //     }
            // }
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $user =  Category::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);
            $user->syncRoles([$request->input('role')]);
            Alert::success('Success', 'Category Added Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }
}
