<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables as Datatables;
use Spatie\Permission\Models\Role as Role;

class UserController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    public function manage()
    {
        return view('admin.users.manage');
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
                <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#editroleModel' . $user->id . '">Role</button>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $user->id . '">X</button>
                ' . $this->edit_user_form($user) . '
                ' . $this->edit_user_role_form($user) . '
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
        <form action="' . route('admin.users.edit') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $user->id . '">
                    <div class="modal fade" id="editModel' . $user->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit ' . $user->name . '</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <div class="row">
                                <div class="col-12">
                                  <div class="mb-1">
                                    <label class="form-label" for="first-name-vertical">Name</label>
                                    <input type="text" id="first-name-vertical" class="form-control" name="name" placeholder="Name" value="' . $user->name . '">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="mb-1">
                                    <label class="form-label" for="first-name-vertical">Email</label>
                                    <input type="text" id="first-name-vertical" class="form-control" name="email" placeholder="Email" value="' . $user->email . '">
                                  </div>
                                </div>
                                <div class="col-12">
                                <div class="mb-1">
                                        <label class="form-label" for="first-name-vertical">Address</label>
                                        <input type="text" id="first-name-vertical" class="form-control" name="address" placeholder="Address" value="' . $user->address . '">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="first-name-vertical">Phone Number</label>
                                        <input type="text" id="first-name-vertical" class="form-control" name="phone" placeholder="Phone Number" value="' . $user->phone . '">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="first-name-vertical">Client ID</label>
                                        <input type="text" id="first-name-vertical" class="form-control" name="client_id" placeholder="Client ID" value="' . $user->client_id . '">
                                    </div>
                                </div>
                               
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-success">
                                        <input type="radio" id="customColorRadio1" name="status" class="form-check-input" value="1" ' . ($user->status == 1 ? 'checked' : '') . '>
                                        <label class="form-check-label" for="customColorRadio1">Active </label>
                                    </div>
                                    <div class="form-check form-check-warning">
                                        <input type="radio" id="customColorRadio2" name="status" class="form-check-input" value="0" ' . ($user->status == 0 ? 'checked' : '') . '>
                                        <label class="form-check-label" for="customColorRadio2">In Active</label>
                                    </div>                       
                                </div>   
                                
                              </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        
        ';
    }
    public function edit_user_role_form($user)
    {
        $roles = Role::all()->pluck('name');
        $radio = "";
        foreach ($roles as $role) {
            $radio .= '
            <div class="form-check form-check-primary">
            <input type="radio" id="customColorRadio4" name="role_id" class="form-check-input" value="' . $role . '" ' . ($user->getRoleNames()[0] == $role ? 'checked' : '') . '>
            <label class="form-check-label" for="customColorRadio4">' . $role . '</label>
        </div>
            ';
        }
        return '
        <form action="' . route('admin.users.edit.role') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $user->id . '">
                    <div class="modal fade" id="editroleModel' . $user->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Role of ' . $user->name . '</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="demo-inline-spacing">
                                        ' . $radio . '
                                    </div>          
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        
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
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'status' => 'required'
        ]);

        try {
            $user = User::where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'status' => $request->input('status'),
            ]);

            return redirect()->back()->with('success', 'User has been updated!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Try Again!');
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
        $validated = $request->validate([
            'name' => 'required|max:50',
            'phone' => 'required',
            'address' => 'required|max:150',
            'email' => 'required|email|max:150',
            'client_id' => 'max:150',
        ]);



        try {



            $user =  User::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'client_id' => $request->input('client_id'),
                'password' => Hash::make('1234567890')
            ]);
            $user->assignRole('User');
            // UserRole::create([
            //     'user_id' => $user->id, 
            //     'role_id' => Role::IS_USER 
            // ]);



            return redirect()->back()->with('success', 'User has been added!');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', $th->getMessage());
            // throw $th;
        }
    }
}
