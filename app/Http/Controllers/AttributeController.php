<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function update($id){
        $attribute = Attribute::find($id);
        if(!$attribute){
            Alert::error('Error', 'Attribute not found');
            return redirect()->back();
        }
        $options = null;
        if(!empty($attribute->options)){
            $new = [];
            $options = json_decode($attribute->options);
            foreach ($options as $key => $value) {
               $new[] = $value->title;
            }
            $options = implode(',', $new);
        }

        return view('admin.attributes.update', compact('attribute', 'options'));

    }
    public $user;
    public $attributes;
    public $attributes_options;
    public function __construct()
    {
        $this->attributes = Attribute::all();
    }
    public function manage()
    {
        return view('admin.attributes.manage');
    }

    public function attributes()
    {
        try {
            return DataTables::of(Attribute::all())

                ->addColumn('action', function ($attribute) {
                    return '
                <div class="btn-group">
                <a href="/admin/attributes/update/' . $attribute->id . '" class="btn btn-outline-primary waves-effect" >Edit</a>
                <button type="button" class="btn btn-outline-danger waves-effect" data-bs-toggle="modal" data-bs-target="#removeModel' . $attribute->id . '">X</button>
                ' . $this->edit_user_form($attribute) . '
                ' . $this->remove_user_form($attribute) . '
                </div>
                ';
                })
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit_user_form($attribute)
    {
        $options = null;
        if(!empty($attribute->options)){
            $new = [];
            $options = json_decode($attribute->options);
            foreach ($options as $key => $value) {
               $new[] = $value->title;
            }
            $options = implode(',', $new);
        }

        return '
        
        <div class="modal fade" id="editModel' . $attribute->id . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Add Attribute</h1>
                                        <!-- <p>Updating user details will receive a privacy audit.</p> -->
                                    </div>
                                    <form id="add_form" class="row gy-1 pt-75" action="' . route('admin.attributes.edit') . '" method="POST">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="id" value="' . $attribute->id . '">
                                    <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" class="form-control" id="name"value="' . $attribute->title . '" name="title" placeholder="Title">
                                            </div>
                                        </div>
                                        <!-- sort_order -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="sort_order">Sort Order</label>
                                                <input type="number" class="form-control" id="sort_order" value="' . $attribute->sort_order . '" name="sort_order" placeholder="Sort Order">
                                            </div>
                                        </div>
                                        <!-- Type radio -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <div class="demo-inline-spacing">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input type_class" type="radio" name="type"  id="inlineRadio1" value="text" '.($attribute->type == 'text' ? 'checked' : '' ).' />
                                                        <label class="form-check-label" for="inlineRadio1">Text</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input type_class" type="radio" name="type" id="inlineRadio2" value="select" '.($attribute->type == 'select' ? 'checked' : '' ).' />
                                                        <label class="form-check-label" for="inlineRadio2">Select</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="select_class" style="display: '.($attribute->type == 'select' ? 'none' : 'block' ).' ;">
                                            <!-- multiple inputs -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="options">Options</label>
                                                    <input type="text" class="form-control " id="options" name="options" value="'.$options.'" data-role="tagsinput" placeholder="Options">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="button" onclick="submit()" class="btn btn-primary me-1">Submit</button>
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


    public function remove_user_form($attribute)
    {
        return '
        <form action="' . route('admin.attributes.remove') . '" method="post">
                ' . csrf_field() . '
                    <input name="id" type="hidden" value="' . $attribute->id . '">
                    <div class="modal fade" id="removeModel' . $attribute->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remove ' . $attribute->title . '</h5>
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
            'sort_order' => 'required|integer',
        ]);

        // print validation error message
        if ($validated->fails()) {
            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $attribute = Attribute::find($request->id);
            $userupdate =  $attribute->update([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),
                'status' => $request->input('status'),
                'sort_order' => $request->input('sort_order'),
            ]);

            Alert::success('Success', 'Attribute Updated Successfully!');

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
            $user = Attribute::where('id', $request->input('id'))->delete();

            return redirect()->back()->with('success', 'Attribute has been removed!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Try Again!');
        }
    }
    public function save(Request $request)
    {

        // Validate user data
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:100',
            // 'description' => 'required|max:255',
            'type' => 'required',
            'sort_order' => 'required|integer',

        ]);

        // print validation error message
        if ($validated->fails()) {

            Alert::warning('Input Error', $validated->errors()->all());
            return redirect()->back()->withErrors($validated)->withInput();
        }

        try {
            $attribute = new Attribute();
            $attribute->title = $request->input('title');
            $attribute->slug = Str::slug($attribute->title);
            $attribute->type = $request->input('type');
            $attribute->sort_order = $request->input('sort_order');
            if ($request->input('type') == 'select') {
                $options = $request->input('options');
                $new = [];
                $i=0;
                foreach (explode(',', $options) as $key => $value) {
                    $new[$key]['slug'] = Str::slug($value);
                    $new[$key]['title'] = ($value);
                    $new[$key]['status'] = true;
                    $new[$key]['sort_order'] = $key;
                    $new[$key]['description'] = $value;
                }
                $attribute->options = json_encode($new);
            } else {
                $attribute->options = null;
            }
            $attribute->save();

            Alert::success('Success', 'Attribute Added Successfully!');

            return redirect()->back();
        } catch (\Exception $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
            // throw $th;
        }
    }
}