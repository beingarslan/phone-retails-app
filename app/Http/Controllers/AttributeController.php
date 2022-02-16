<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function update($id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            abort(404);
        }
        $options = null;
        if (!empty($attribute->options)) {
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
                ' . $this->remove_user_form($attribute) . '
                </div>
                ';
                })
                ->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
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
            'id' => 'required',
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
            $attribute = Attribute::find($request->id);
            if (!$attribute) {
                Alert::error('Error', 'Attribute not found');
                return redirect()->back();
            }
            // $attribute = new Attribute();
            $attribute->title = $request->input('title');
            $attribute->slug = Str::slug($attribute->title);
            $attribute->type = $request->input('type');
            $attribute->sort_order = $request->input('sort_order');
            if ($request->input('type') == 'select') {
                $options = $request->input('options');
                if (empty($options)) {
                    Alert::error('Error', 'Options are required');
                    return redirect()->back();
                }
                $new = [];
                $i = 0;
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
                $i = 0;
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
    public function getAttributes(Request $request)
    {
        $attribute = CategoryAttribute::where('category_id', $request->category_id)->get();
        $attributes = $attribute->toArray();
        $attribute_ids = array_column($attributes, 'attribute_id');
        $attributes = Attribute::whereIn('id', $attribute_ids)->get();
        $attributes = $attributes->toArray();
        return response()->json(['success' => true, 'attributes' => $attributes]);
    }
}
