@extends('layouts/contentLayoutMaster')

@section('title', 'Manage Categories')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

@endsection

@section('content')



<section id="gradient-buttons">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#addAdvertisingModel">Add Category</button>
                    <!-- Add User Model -->
                    <div class="modal fade" id="addAdvertisingModel" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header bg-transparent">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-5 px-sm-5 pt-50">
                                    <div class="text-center mb-2">
                                        <h1 class="mb-1">Add Category</h1>
                                        <!-- <p>Updating user details will receive a privacy audit.</p> -->
                                    </div>
                                    <form id="editUserForm" class="row gy-1 pt-75" action="{{route('admin.categories.save')}}" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" class="form-control" id="name" name="title" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">Description</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="divider mb-0 mt-2">
                                                <div class="divider-text text-info">All Attributes are optional</div>
                                            </div>
                                        </div>
                                        @foreach($attributes as $attribute)
                                        @if($attribute->type == 'select')
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">{{$attribute->title}}</label>
                                                <select class="form-control" name="{{$attribute->slug}}">
                                                    <option value="">Select</option>
                                                    @foreach(json_decode($attribute->options) as $option)
                                                    <option value="{{$option->slug}}">{{$option->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">{{$attribute->title}}</label>
                                                <input type="text" class="form-control" id="name" name="{{$attribute->slug}}" placeholder="{{$attribute->title}}">
                                            </div>
                                        </div>

                                        @endif
                                        @endforeach

                                        <div class="col-12 ">
                                            <div class="divider mb-0 mt-2">
                                                <div class="divider-text text-info">Parent Category is optional</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="demo-inline-spacing">
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input" id="customSwitch1">
                                                        <label class="form-check-label" for="customSwitch1">Child Category?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div id="chilediv" style="display: none;">
                                            <!-- EAN -->
                                            <!-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="ean">EAN</label>
                                                    <input type="text" class="form-control" id="ean" name="ean" placeholder="EAN">
                                                </div>
                                            </div> -->
                                            <!-- SKU -->
                                            <!-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="sku">SKU</label>
                                                    <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU">
                                                </div>
                                            </div> -->

                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="select2-basic">Parent Category</label>
                                                    <select name="parent_id" class="select2 form-select" id="select2-basic">
                                                        <option value="">Select Parent Category</option>
                                                        @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-2 pt-50">
                                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                                Discard
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add User Model End -->
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Basic table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card table-responsive">
                <table class="table" style="width: 100%; " id="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Parent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



</section>
<!--/ Basic table -->



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

@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>

<script>
    $(function() {
        $('#users-table').DataTable({
            responsive: false,
            processing: true,
            serverSide: true,
            order: [
                [0, "desc"]
            ],
            ajax: '{!! route("admin.categories.categories") !!}',
            columns: [

                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    render: function(data) {
                        return '<b>' + data + '</b>'
                    }
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },

                {
                    data: 'status',
                    render: function(data) {
                        if (data === 1) {
                            return '<span class="badge badge-glow bg-success">Active</span>'
                        } else {
                            return '<span class="badge badge-glow bg-warning">In Active</span>'
                        }
                    }
                },
                {
                    data: 'parent',
                    render: function(data) {
                        return '<b>' + data + '</b>'
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }

            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        // #customSwitch1 change event
        $('#chilediv').hide();
        $('#customSwitch1').change(function() {
            if ($(this).is(':checked')) {
                // #chilediv show
                $('#chilediv').show();

            } else {
                // #chilediv hide
                $('#chilediv').hide();
            }
        });
    });
</script>
@endsection