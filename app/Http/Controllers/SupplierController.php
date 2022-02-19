<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public $user;
    public $suppliers;
    public $brand_options;
    public function __construct()
    {
        $this->suppliers = Supplier::all();
    }
    public function manage()
    {
        return view('admin.suppliers.manage');
    }
    public function suppliers()
    {
        try {
            return DataTables::of(Supplier::all())
                ->addColumn('action', function ($supplier) {
                    return '
                <div class="btn-group btn-group-sm">
                <a href="/admin/supplier-products/manage/' . $supplier->id . '" class="btn btn-outline-info waves-effect">Products</a>
                <button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#editModel' . $supplier->id . '">Edit</button>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $supplier->id . '">X</button>
                ' . $this->edit_user_form($supplier) . '
                ' . $this->remove_user_form($supplier) . '
                </div>
                ';
                })
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit_user_form($supplier)
    {

        return '
            <div class="modal fade" id="editModel' . $supplier->id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pb-5 px-sm-5 pt-50">
                        <div class="text-center mb-2">
                            <h1 class="mb-1">Update Brand</h1>
                            <!-- <p>Updating user details will receive a privacy audit.</p> -->
                        </div>
                        <form id="editUserForm" class="row gy-1 pt-75" action="' . route('admin.suppliers.edit') . '" method="POST">
                        ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $supplier->id . '">
                            <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="' . $supplier->name . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Short Name</label>
                                                <input type="text" class="form-control" id="name" name="short_name" placeholder="Short Name" value="' . $supplier->short_name . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Phone</label>
                                                <input type="text" class="form-control" id="name" name="phone" placeholder="Phone" value="' . $supplier->phone . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Email</label>
                                                <input type="text" class="form-control" id="name" name="email" placeholder="Email" value="' . $supplier->email . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Country</label>
                                                <input type="text" class="form-control" id="name" name="country" placeholder="Country" value="' . $supplier->country . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Contact Person Name</label>
                                                <input type="text" class="form-control" id="name" name="contact_person_name" placeholder="Contact Person Name" value="' . $supplier->contact_person_name . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Contact Person Phone</label>
                                                <input type="text" class="form-control" id="name" name="contact_person_phone" placeholder="Contact Person Phone" value="' . $supplier->contact_person_phone . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Contact Person Email</label>
                                                <input type="text" class="form-control" id="name" name="contact_person_email" placeholder="Contact Person Email" value="' . $supplier->contact_person_email . '">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">Address</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3" placeholder="Address">' . $supplier->address . '</textarea>
                                        </div>
                                    </div>

                            <div class="col-12">
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" ' . ($supplier->status ? 'checked' : '') . '>
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    <div class="form-check form-check-warning">
                                        <input class="form-check-input"  type="radio" name="status" id="inlineRadio2" value="0" ' . ($supplier->status ? '' : 'checked') . ' >
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


    public function remove_user_form($supplier)
    {
        return '
        <form action="' . route('admin.suppliers.remove') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $supplier->id . '">
                    <div class="modal fade" id="removeModel' . $supplier->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remove ' . $supplier->name . '</h5>
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
            'short_name' => 'required|max:100',
            'phone' => 'required|max:15',
            'address' => 'required|max:255',
            'email' => 'sometimes|email|max:255',
            'country' => 'required|max:255',
            'contact_person_name' => 'required|max:255',
            'contact_person_phone' => 'required|max:15',
            'contact_person_email' => 'sometimes|email|max:255',
            'status' => 'required|integer',
        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $brand = Supplier::find($request->id);
            $userupdate =  $brand->update([
                'name' => $request->input('name'),
                'short_name' => $request->input('short_name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'country' => $request->input('country'),
                'contact_person_name' => $request->input('contact_person_name'),
                'contact_person_phone' => $request->input('contact_person_phone'),
                'contact_person_email' => $request->input('contact_person_email'),
                'slug' => Str::slug($request->input('name')),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
            ]);

            Alert::success('Success', 'Supplier Updated Successfully!');

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
            $user = Supplier::where('id', $request->input('id'))->delete();

            return redirect()->back()->with('success', 'Supplier has been removed!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Try Again!');
        }
    }
    public function save(Request $request)
    {
        // Validate user data
        $validated = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'short_name' => 'required|max:100',
            'phone' => 'required|max:15',
            'address' => 'required|max:255',
            'email' => 'sometimes|email|max:255',
            'country' => 'required|max:255',
            'contact_person_name' => 'required|max:255',
            'contact_person_phone' => 'required|max:15',
            'contact_person_email' => 'sometimes|email|max:255',
        ]);

        // print validation error message
        if ($validated->fails()) {

            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $user =  Supplier::create([
                'name' => $request->input('name'),
                'short_name' => $request->input('short_name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'email' => $request->input('email'),
                'country' => $request->input('country'),
                'contact_person_name' => $request->input('contact_person_name'),
                'contact_person_phone' => $request->input('contact_person_phone'),
                'contact_person_email' => $request->input('contact_person_email'),
                'slug' => Str::slug($request->input('name')),
            ]);

            Alert::success('Success', 'Supplier Added Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }
}
