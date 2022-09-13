@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .sub_module_block ul {
        padding-left: 15px !important;
    }

    .sub_module_block ul p {
        margin-bottom: 5px !important;
    }

    .permission_block {
        width: 90%;
        border-right: 1px solid #e0d9d9;
        margin-bottom: -6px;
    }
    .select2-container {
        z-index: 99999 !important;
    }
    .main-group{
        column-count: 3; 
        column-gap : 0;
        margin: 0 15px;
    }

    @media ( min-width : 320px ) and ( max-width : 768px ){
        .main-group{
            column-count: 1; 
            column-gap : 0
        }
        .permission_block {
            width: 100%;
        }
    }

    @media ( min-width : 768px ) and ( max-width : 1024px ){
        .main-group{
            column-count: 2; 
            column-gap : 0
        }
        .permission_block {
            width: 95%;
        }
    }

</style>
@endsection

@section('body-content')
<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">All Role</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header text-right">
                        <button type="button" data-content="{{ route('role.add.modal') }}" data-target="#largeModal"
                            class="btn btn-outline-dark" data-toggle="modal">
                            Add
                        </button>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped dataTable dtr-inline role-datatable"
                            id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('per_page_js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('backend/js/custom-script.min.js') }}"></script>

<script src="{{ asset('backend/js/datatable/jquery.validate.js') }}"></script>
<script src="{{ asset('backend/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/js/datatable/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>


<script>
    $(function () {
        $('.role-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('role.data') }}",
            order: [
                [0, 'Desc']
            ],
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                },
            ]
        });
    });

</script>
@endsection
