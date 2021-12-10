@extends('layouts/contentLayoutMaster')

@section('title', 'Manage Users')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('content')



<section id="gradient-buttons">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#addAdvertisingModel">Add User</button>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Client ID</th>
                            <th>Status</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal to add new record -->
    <div class="modal modal-slide-in fade" id="addAdvertisingModel">
        <div class="modal-dialog sidebar-sm">
            <form class="add-new-record modal-content pt-0" method="post" action="{{route('admin.users.save')}}">
                @csrf
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                </div>
                <div class="modal-body flex-grow-1">

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Name</label>
                                <input type="text" id="first-name-vertical" class="form-control" name="name" placeholder="Name" value="">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Email</label>
                                <input type="email" id="first-name-vertical" class="form-control" name="email" placeholder="Email" value="">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Address</label>
                                <input type="text" id="first-name-vertical" class="form-control" name="address" placeholder="Address" value="">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Phone Number</label>
                                <input type="text" id="first-name-vertical" class="form-control" name="phone" placeholder="Phone Number" value="">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Client ID</label>
                                <input type="text" id="first-name-vertical" class="form-control" name="client_id" placeholder="Client ID" value="">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1">
                                <label class="form-label" for="first-name-vertical">Password</label>
                                <input type="text" id="first-name-vertical" class="form-control" name="password" placeholder="Password" value="">
                            </div>
                        </div>
                        <!-- <div class="demo-inline-spacing">
                            <div class="form-check form-check-success">
                                <input type="radio" id="customColorRadio1" name="status" class="form-check-input" value="1" >
                                <label class="form-check-label" for="customColorRadio1">Active </label>
                            </div>
                            <div class="form-check form-check-warning">
                                <input type="radio" id="customColorRadio2" name="status" class="form-check-input" value="0" >
                                <label class="form-check-label" for="customColorRadio2">In Active</label>
                            </div>
                        </div> -->


                        <button type="submit" class="btn btn-primary data-submit me-1">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
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
@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>

<script>
    $(function() {
        $('#users-table').DataTable({
            responsive: false,
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.users.users") !!}',
            columns: [

                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    render: function(data) {
                        return '<b>' + data + '</b>'
                    }
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'client_id',
                    name: 'client_id'
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
                    data: 'role',
                    render: function(data) {
                        return '<b>' + data + '</b>'
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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
@endsection