@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Category')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .bootstrap-tagsinput .tag {
        color: black;
        background-color: #89ceff;
        border-radius: 10%;
        border: 2px solid red;
        padding: 5px;
    }

    .bootstrap-tagsinput {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        display: block;
        padding: 10px 6px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
    }

    .bootstrap-tagsinput input {
        border: none;
        box-shadow: none;
        outline: none;
        background-color: transparent;
        padding: 0 6px;
        margin: 0;
        width: auto;
        max-width: inherit;
    }

    .bootstrap-tagsinput .tag [data-role="remove"] {
        margin-left: 8px;
        cursor: pointer;
        color: red;
    }
</style>
@endsection
@section('content')

<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$category->title}}</h4>
                </div>
                <div class="card-body">


                    <form id="editUserForm" class="row gy-1 pt-75" action="{{route('admin.categories.edit')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$category->id}}">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="name" name="title" value="{{$category->title}}" placeholder="Title">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3" placeholder="Description">{{$category->description}}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="divider mb-0 mt-2">
                                <div class="divider-text text-info">All Attributes are optional</div>
                            </div>
                        </div>
                        <div class="demo-inline-spacing">

                            @foreach($attributes as $attribute)

                            <div class="form-check form-check-primary">
                                <input type="checkbox" name="attributes[]" value="{{$attribute->id}}" {{in_array($attribute->id, array_column($category->categoryAttribute->toArray(), 'attribute_id')) ? 'checked' : ''}} class="form-check-input" id="colorCheck1{{$attribute->id}}" />
                                <label class="form-check-label" for="colorCheck1{{$attribute->id}}">{{$attribute->title}}</label>
                            </div>

                            @endforeach
                        </div>
                        <!-- status -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Status</label>
                                <select class="form-control" name="status">
                                    <option {{$category->status ? 'selected' : ''}} value="1">Active
                                    <option {{$category->status ? '' : 'selected'}} value="0">Inactive
                                </select>
                            </div>
                        </div>
                        <!-- status -->
                        {{-- categories --}}
                        <div class="col-6">
                            <div class="form-group">
                                <label for="Categories">
                                    Parent Category
                                    <small>There will be no parent if current category is a parent</small>
                                </label>
                                <select class="form-control" name="category">
                                    {{-- <option >Select Category</option> --}}
                                    @if($category->parent_id)
                                    <option value="{{$category->parent_id}}" selected>{{$category->parent->title}}</option>
                                    @endif
                                    @foreach($categories as $category)
                                    <option  value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                <div class="col-12 text-center mt-2 pt-50">
                    <button type="submit" class="btn btn-primary me-1">Save Changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- Basic Vertical form layout section end -->

@endsection



@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.js" integrity="sha512-SXJkO2QQrKk2amHckjns/RYjUIBCI34edl9yh0dzgw3scKu0q4Bo/dUr+sGHMUha0j9Q1Y7fJXJMaBi4xtyfDw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>
<script>
    function submit() {
        $('#edit_form').submit();
    }
</script>



<script>
    // on change  type_class
    $(document).on('change', '.type_class', function() {
        var type = $(this).val();
        if (type == 'select') {
            $('.select_class').show();
        } else {
            $('.select_class').hide();
        }
    });
</script>
@endsection
