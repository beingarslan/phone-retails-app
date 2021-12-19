<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CapacityController extends Controller
{
    public $user;
    public $colors;
    public $color_options;
    public function __construct()
    {
        $this->colors = Capacity::all();
    }
    public function manage()
    {
        return view('admin.capacities.manage');
    }

    public function capacities()
    {
        try {
            return DataTables::of(Capacity::all())
               
                ->addColumn('action', function ($capacity) {
                    return '
                <div class="btn-group">
                <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#editModel' . $capacity->id . '">Edit</button>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $capacity->id . '">X</button>
                ' . $this->edit_user_form($capacity) . '
                ' . $this->remove_user_form($capacity) . '
                </div>
                ';
                })
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit_user_form($capacity)
    {

        return '
            <div class="modal fade" id="editModel' . $capacity->id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Update Capacity</h1>
                            <!-- <p>Updating user details will receive a privacy audit.</p> -->
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" action="' . route('admin.capacities.edit') . '" method="POST">
                        ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $capacity->id . '">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="' . $capacity->name . '">
                                </div>
                            </div>
                            
                           
                            
                            <div class="col-12">
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" ' . ($capacity->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    <div class="form-check form-check-warning">
                                        <input class="form-check-input"  type="radio" name="status" id="inlineRadio2" value="0" ' . ($capacity->status ? '' : 'checked') . ' >
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


    public function remove_user_form($capacity)
    {
        return '
        <form action="' . route('admin.capacities.remove') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $capacity->id . '">
                    <div class="modal fade" id="removeModel' . $capacity->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remove ' . $capacity->name . '</h5>
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
        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $color = Capacity::find($request->id);
            $userupdate =  $color->update([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'status' => $request->input('status'),
            ]);

            Alert::success('Success', 'Capacity Updated Successfully!');

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
            $user = Capacity::where('id', $request->input('id'))->delete();

            return redirect()->back()->with('success', 'Capacity has been removed!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Try Again!');
        }
    }
    public function save(Request $request)
    {
        // Validate user data
        $validated = Validator::make($request->all(), [
            'name' => 'required|max:100',
            // 'description' => 'required|max:255',
        ]);

        // print validation error message
        if ($validated->fails()) {

            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $color = new Capacity();
            $color->name = $request->input('name');
            $color->slug = Str::slug($color->name);
            $color->save();
           

            Alert::success('Success', 'Capacity Added Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }
}
