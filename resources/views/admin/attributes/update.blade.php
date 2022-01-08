@extends('layouts/contentLayoutMaster')

@section('title', 'Edit Attribute')

@section('content')

<!-- Basic Vertical form layout section start -->
<section id="basic-vertical-layouts">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$attribute->title}}</h4>
                </div>
                <div class="card-body">

                    <form id="edit_form" class="row gy-1 pt-75" action="{{route('admin.attributes.edit')}}" method="POST">
                        @csrf
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="name" name="title" placeholder="Title" value="{{$attribute->title}}">
                            </div>
                        </div>
                        <!-- sort_order -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{$attributr->sort_order}}" placeholder="Sort Order">
                            </div>
                        </div>
                        <!-- Type radio -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input type_class" type="radio" name="type" id="inlineRadio1" value="text" ($attribute->type == 'text' ? 'checked' : '' ) />
                                        <label class="form-check-label" for="inlineRadio1">Text</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input type_class" type="radio" name="type" id="inlineRadio2" value="select"($attribute->type == 'select' ? 'checked' : '' ) />
                                        <label class="form-check-label" for="inlineRadio2">Select</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="select_class" style="display:{{$attribute->type == 'select' ? 'none' : 'block' }};">
                            <!-- multiple inputs -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="options">Options</label>
                                    <input type="text" class="form-control " id="options" value="{{$options}}" name="options" data-role="tagsinput" placeholder="Options">
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