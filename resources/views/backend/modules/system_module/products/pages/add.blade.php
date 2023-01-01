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
            <a class="breadcrumb-item active" href="#">Add new product</a>
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
                                </ul>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('products.add') }}" method="post" class="ajax-form">
                                    @csrf

                                    <div class="tab-content mt-4">

                                        <!-- TAB PANEL START -->
                                        <div class="tab-pane active" id="general">
                                            <div class="row">
                                                <!-- code -->
                                                <div class="col-md-3 form-group">
                                                    <label>Code</label>
                                                    <input type="text" class="form-control" name="code">
                                                </div>

                                                <!-- Name -->
                                                <div class="col-md-3 form-group">
                                                    <label>Name</label><span class="require-span">*</span>
                                                    <input type="text" class="form-control" name="name">
                                                </div>

                                                <!-- Factor -->
                                                <div class="col-md-2 form-group">
                                                    <label>Factor (pieces)</label>
                                                    <input type="number" class="form-control" name="factor" min="1">
                                                </div>

                                                <!-- Type -->
                                                <div class="col-md-2 form-group">
                                                    <label>Type</label><span class="require-span">*</span>
                                                    <select name="type" class="form-control">
                                                        <option value="Local">Local</option>
                                                        <option value="Export">Export</option>
                                                    </select>
                                                </div>

                                                <!-- Status -->
                                                <div class="col-md-2 form-group">
                                                    <label>Status</label><span class="require-span">*</span>
                                                    <select name="is_active" class="form-control">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- TAB PANEL END -->
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-warning">
                                                Add
                                            </button>
                                        </div>
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
    @endsection