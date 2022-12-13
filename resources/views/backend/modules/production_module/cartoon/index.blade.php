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
            <a class="breadcrumb-item active" href="#">Cartoon List</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    
                    <div class="card-body">

                        <div class="col-md-12 text-right">
                            <form action="" method="get">
                                @csrf
                                <input type="search" name="search" value="">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <table class="table table-bordered table-striped dataTable dtr-inline user-datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.ID</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Product</th>
                                    <th>Actual Weight (kg)</th>
                                    <th>Weight (kg)</th>
                                    <th>Packet ( pieces )</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( $cartoons as $key => $cartoon )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $cartoon->cartoon_name }}</td>
                                    <td>{{ $cartoon->cartoon_code }}</td>
                                    <td>{{ $cartoon->product->name }}</td>
                                    <td>{{ $cartoon->actual_cartoon_weight }}</td>
                                    <td>{{ $cartoon->cartoon_weight }}</td>
                                    <td>{{ $cartoon->packet_quantity }}</td>
                                    <td>{{ $cartoon->status }}</td>
                                    <td>{{ $cartoon->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown-{{ $cartoon->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown-{{ $cartoon->id }}">

                                                @if( can("edit_cartoon") )
                                                <a class="dropdown-item" href="{{ route('edit.cartoon.page', $cartoon->cartoon_code) }}" class="btn btn-outline-dark">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9">No data found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
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