
@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
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
        margin-bottom: 0;
    }

    .select2-container {
        z-index: 99999 !important;
    }

    .main-group {
        column-count: 3;
        column-gap: 0;
        margin: 0 15px;
    }

    .data-indicator ul {
        padding-left: 15px;
    }

    .data-indicator ul li {
        display: inline;
    }

    @media (min-width : 320px) and (max-width : 768px) {
        .main-group {
            column-count: 1;
            column-gap: 0
        }

        .permission_block {
            width: 100%;
        }
    }

    @media (min-width : 768px) and (max-width : 1024px) {
        .main-group {
            column-count: 2;
            column-gap: 0
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
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-11 col-12">
                                <form action="{{ route('role.all') }}" method="get">
                                    @csrf
                                    <div class="row">

                                        <!-- select group -->
                                        <div class="col-md-3 col-12 form-group">
                                            <label>Select Group</label><span class="require-span">*</span>
                                            <select name="group_id" class="form-control my_chosen_1" onchange="groupChange(this)">
                                                <option value="" disabled selected>Select group</option>
                                                @foreach( $groups as $group )
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- select company -->
                                        <div class="col-md-3 col-12 form-group select-company">
                                            <label>Select company</label><span class="require-span">*</span>
                                            <div class="company-block">
                                                <select name="company_id" class="form-control company_id my_chosen_1" onchange="companyChange(this)">
                                                    <option value="" selected disabled>Select company</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- select location -->
                                        <div class="col-md-3 col-12 form-group select-location">
                                            <label>Select location</label><span class="require-span">*</span>
                                            <div class="location-block">
                                                <select name="location_id" class="form-control location_id my_chosen_1" onchange="locationChange(this)">
                                                    <option value="" selected disabled>Select location</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- button -->
                                        <div class="col-md-3 col-12 form-group">
                                            <button type="submit" class="btn btn-success mt-3">
                                                Search
                                            </button>
                                            <a href="{{ route('role.all') }}" class="btn btn-danger mt-3">
                                                <i class="fas fa-sync"></i>
                                            </a>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <div class="col-md-1 col-12 text-right">
                                @if( can("add_roles") )
                                <button type="button" data-content="{{ route('role.add.modal') }}" data-target="#largeModal" class="btn btn-outline-dark mt-3" data-toggle="modal">
                                    Add
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped dataTable dtr-inline role-datatable" id="datatable">
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

<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>
<script>
    $(document).ready(function domReady() {
        $(".my_chosen_1").chosen();
    });
</script>

<script>
    $(function() {
        $('.role-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('role.data') }}",
                data:{
                    group_id : "{{$search_group ? $search_group->id : null}}",
                    company_id : "{{$search_company ? $search_company->id : null}}",
                    location_id : "{{$search_location ? $search_location->id : null}}",
                },
            },
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

<script>
    function groupChange(e) {
        let group_id = e.value
        $.ajax({
            type: "GET",
            url: "{{ route('group.wise.company') }}",
            data: {
                group_id: group_id,
            },
            success: function(response) {
                if (response.status == "success") {
                    $(".company-block").remove();
                    $(".select-company").append(`
                        <div class="company-block">
                            <select name="company_id" class="form-control company_id my_chosen_1" onchange="companyChange(this)">
                                <option value="" selected disabled>Select company</option>
                            </select>
                        </div>
                    `);

                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id my_chosen_1" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value) {
                        $(".company_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".my_chosen_1").chosen();
                }
            },
            error: function(response) {

            },
        })
    }

    function companyChange(e) {
        let company_id = Array();
        company_id.push(e.value)

        $.ajax({
            type: "GET",
            url: "{{ route('company.wise.location') }}",
            data: {
                company_ids: company_id,
            },
            success: function(response) {
                if (response.status == "success") {
                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id my_chosen_1" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value) {
                        $(".location_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".my_chosen_1").chosen();
                }
            },
            error: function(response) {

            },
        })
    }
</script>
@endsection