@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .data-indicator ul{
        padding-left: 15px;
    }
    .data-indicator ul li{
        display: inline;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">All Products</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header text-right">
                        @if( can('add_products') )
                        <a class="btn btn-outline-dark" href="{{ route('products.add.page') }}">
                            Add
                        </a>
                        @endif
                    </div>
                    <div class="card-body">

                        @if( can("add_products") )
                        <div class="row">
                            <div class="col-md-4 text-left">
                                <p>Import products (.csv)</p>
                                <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file" name="file" class="form-control" required accept=".csv">
                                        <small>
                                            <a href="{{ asset('images/sample_file/product_import.csv') }}" >Download sample file</a>
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">
                                            Upload
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-12 text-right">
                            <form action="{{ route('products.all') }}" method="get">
                                @csrf
                                <input type="search" name="search" value="{{ $search }}">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <table class="table table-bordered table-striped dataTable dtr-inline user-datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.ID</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Factor (pieces)</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( $products as $key => $product )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->factor }}</td>
                                    <td>{{ $product->type }}</td>
                                    <td>
                                        @if( $product->is_active == true )
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if( can("edit_products") )
                                        <a href="{{ route('products.edit.page', $product->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7">No data found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{ $products->links() }}
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