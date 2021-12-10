<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables as Datatables;
use Spatie\Permission\Models\Role as Role;
use RealRashid\SweetAlert\Facades\Alert as Alert;

class UserController extends Controller
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
            return Datatables::of(User::all())
                ->addColumn('role', function ($user) {
                    return $user->getRoleNames()[0];
                })
                ->addColumn('action', function ($user) {
                    return '
                <div class="btn-group">
                <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#editModel' . $user->id . '">Edit</button>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $user->id . '">X</button>
                ' . $this->edit_user_form($user) . '
                ' . $this->remove_user_form($user) . '
                </div>
                ';
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at != null ? $user->created_at->format('h:i A,   d M, Y') : 'N/A';
                })


                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit_user_form($user)
    {

        return '
            <div class="modal fade" id="editModel' . $user->id . '" tabindex="-1" aria-hidden="true">
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
                        <form id="editUserForm" class="row gy-1 pt-75" action="' . route('admin.users.edit') . '" method="POST">
                        ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $user->id . '">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="' . $user->name . '">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" readonly class="form-control" id="email" name="email" placeholder="Email" value="' . $user->email . '" >
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-vertical">User Role</label>
                                    <select class="form-control" name="role">
                                        <option selected value="' . $user->getRoleNames()[0] . '">' . $user->getRoleNames()[0] . '</option>
                                        ' . $this->role_options . '
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" ' . ($user->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"  type="radio" name="status" id="inlineRadio2" value="0" ' . ($user->status ? '' : 'checked') . ' >
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


    public function remove_user_form($user)
    {
        return '
        <form action="' . route('admin.users.remove') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $user->id . '">
                    <div class="modal fade" id="removeModel' . $user->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remove ' . $user->name . '</h5>
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
            'name' => 'required|max:100',
            'status' => 'required|integer',
            'role' => 'required'

        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $user = User::find($request->id);
            $userupdate =  $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make('1234567890'),
                'status' => $request->input('status'),

            ]);
            $user->syncRoles([$request->input('role')]);
            Alert::success('Success', 'User Updated Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }

    public function edit_role(Request $request)
    {
        try {
            // dd($request->all());
            $user = User::where('id', $request->input('id'))->first();
            $user->syncRoles([$request->input('role_id')]);
            // $user = UserRole::where('user_id', $request->input('id'))->update([
            //     'role_id' => $request->input('role_id')
            // ]);

            return redirect()->back()->with('success', 'User Role has been updated!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Try Again!');
        }
    }

    public function remove(Request $request)
    {
        try {
            // dd($request->all());
            $user = User::where('id', $request->input('id'))->delete();

            return redirect()->back()->with('success', 'User Role has been removed!');
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
            $user =  User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make('1234567890')
            ]);
            $user->syncRoles([$request->input('role')]);
            Alert::success('Success', 'User Added Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }
}
