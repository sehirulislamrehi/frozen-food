@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .data-indicator ul {
        padding-left: 15px;
    }

    .data-indicator ul li {
        display: inline;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ route('products.all') }}">All Product</a>
            <a class="breadcrumb-item active" href="#">{{ $product->name }}</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <a href="{{ route('products.all') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-angle-left"></i>
                            All Products
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#general" data-toggle="tab">
                                            General Information
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" href="#details" data-toggle="tab">
                                            Details
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('products.edit', encrypt($product->id)) }}" method="post" class="ajax-form">
                                    @csrf

                                    <div class="tab-content mt-4">

                                        <!-- TAB PANEL START -->
                                        <div class="tab-pane active" id="general">
                                            <div class="row">
                                                <!-- code -->
                                                <div class="col-md-3 form-group">
                                                    <label>Code</label>
                                                    <input type="text" class="form-control" name="code" value="{{ $product->code }}">
                                                </div>

                                                <!-- Name -->
                                                <div class="col-md-3 form-group">
                                                    <label>Name</label><span class="require-span">*</span>
                                                    <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                                                </div>

                                                <!-- Factor -->
                                                <div class="col-md-2 form-group">
                                                    <label>Factor (pieces)</label>
                                                    <input type="number" class="form-control" name="factor" min="1" value="{{ $product->factor }}">
                                                </div>

                                                <!-- Type -->
                                                <div class="col-md-2 form-group">
                                                    <label>Type</label><span class="require-span">*</span>
                                                    <select name="type" class="form-control">
                                                        <option value="Local" @if( $product->type == "Local" ) selected @endif >Local</option>
                                                        <option value="Export" @if( $product->type == "Export" ) selected @endif >Export</option>
                                                    </select>
                                                </div>

                                                <!-- Status -->
                                                <div class="col-md-2 form-group">
                                                    <label>Status</label><span class="require-span">*</span>
                                                    <select name="is_active" class="form-control">
                                                        <option value="1" @if( $product->is_active == 1 ) selected @endif >Active</option>
                                                        <option value="0" @if( $product->is_active == 0 ) selected @endif >Inactive</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12 text-right">
                                                    <button type="submit" class="btn btn-warning">
                                                        Update
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- TAB PANEL END -->

                                        <!-- TAB PANEL START -->
                                        <div class="tab-pane" id="details">

                                            <div class="row">
                                                <div class="col-md-12 text-right" style="border-top: 2px solid #e9e7e7;">
                                                    @if( can('add_products') )
                                                    <button type="button" data-content="{{ route('products.details.add.modal', encrypt($product->id)) }}" data-target="#myModal" class="btn btn-outline-dark mt-3 mb-3" data-toggle="modal">
                                                        Add
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-striped dataTable dtr-inline user-datatable w-100" id="datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>S.ID</th>
                                                                <th>Group</th>
                                                                <th>Company</th>
                                                                <th>Location</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- TAB PANEL END -->

                                    </div>

                                </form>
                            </div>
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
    <script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>

    <script src="{{ asset('backend/js/datatable/jquery.validate.js') }}"></script>
    <script src="{{ asset('backend/js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/js/datatable/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(function() {
            $('.user-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.details.data', $product->id) }}",
                order: [
                    [0, 'Desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'group',
                        name: 'group'
                    },
                    {
                        data: 'company',
                        name: 'company'
                    },
                    {
                        data: 'location',
                        name: 'location'
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