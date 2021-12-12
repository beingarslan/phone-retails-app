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
                    <!-- Add User Model -->
                    <div class="modal fade" id="addAdvertisingModel" tabindex="-1" aria-hidden="true">
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
                                    <form id="editUserForm" class="row gy-1 pt-75" action="{{route('admin.users.save')}}" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="first-name-vertical">User Role</label>
                                                <select class="form-control" name="role">
                                                    <option value="">Select User Role</option>
                                                    @foreach($roles as $role)
                                                    <option value="{{$role}}">{{$role}}</option>
                                                    @endforeach
                                                </select>
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
                            <th>Name</th>
                            <th>Email</th>
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
            order: [
                [0, "desc"]
        ],
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