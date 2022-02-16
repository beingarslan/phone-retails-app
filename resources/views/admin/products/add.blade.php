@extends('layouts/contentLayoutMaster')

@section('title', 'Add Product')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
                    {{-- <h4 class="card-title">Add product<h4> --}}
                </div>
                <form id="editUserForm" class="row gy-1 pt-75" action="{{ route('admin.products.save') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-1">
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Title">
                                </div>
                            </div>

                            <div class="col-12 mb-1">
                                <div class="form-group">
                                    <label for="email">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-1">
                                <div class="form-group">
                                    <label for="email">Select Category</label>
                                    <select onchange="showAttributes(this)" class="form-control" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-1">
                                <div class="divider mb-0 mt-2">
                                    <div class="divider-text text-info">All Attributes are optional</div>
                                </div>
                            </div>
                            <div id="appendAttributes">

                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center mb-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">Save</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showAttributes(e) {
        var category_id = $(e).val();
        $.ajax({
            url: "/admin/attributes/get_attributes",
            type: "POST",
            data: {
                category_id: category_id,
            },
            success: function(data) {
                if (data.success == true) {
                    $('#appendAttributes').html('');
                    for (var i = 0; i < data.attributes.length; i++) {
                        if (data.attributes[i].type == 'select') {
                            var select_html = '<div class="col-12 mb-1">' +
                                '<div class="form-group">' +
                                '<label for="email">' + data.attributes[i].title + '</label>' +
                                '<select class="form-control" name="' + data.attributes[i].slug + '">' +
                                '<option value="">Select ' + data.attributes[i].title + '</option>';
                            var options = JSON.parse(data.attributes[i].options);
                            for (var j = 0; j < options.length; j++) {
                                select_html += '<option value="' + options[j].slug + '">' + options[j].title +
                                    '</option>';
                            }
                            select_html += '</select>' +
                                '</div>' +
                                '</div>';
                            $('#appendAttributes').append(select_html);
                        } else if (data.attributes[i].type == 'text') {
                            var input_html = '<div class="col-12 mb-1">' +
                                '<div class="form-group">' +
                                '<label for="email">' + data.attributes[i].title + '</label>' +
                                '<input type="text" class="form-control" name="' + data.attributes[i].slug + '" placeholder="' + data.attributes[i].title +
                                '">' +
                                '</div>' +
                                '</div>';
                            $('#appendAttributes').append(input_html);
                        }
                    }
                    console.log(data);
                }
            }
        });
    }
</script>
@endsection
