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
    .table-bordered{
        border: 1px solid #dfe2e6!important;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">Stock Summary</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <a href="{{ route('products.edit.page', $product->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-angle-left"></i>
                            Back
                        </a>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td> <strong>Group:</strong> {{ $product_details->group->name }}</td>
                                            <td> <strong>Company:</strong> {{ $product_details->company->name }}</td>
                                            <td> <strong>Location:</strong> {{ $product_details->location->name }}</td>
                                        </tr>
                                        <tr>
                                            <td> <strong>Product Code:</strong> {{ $product->code }} </td>
                                            <td> <strong>Product Name:</strong> {{ $product->name }} </td>
                                            <td> <strong>Product Stock:</strong> {{ $stock[0]->stock ?? 0 }} kg </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SID.</th>
                                                <th>Status</th>
                                                <th>Cartoon</th>
                                                <th>In Quantity (kg)</th>
                                                <th>Out Quantity (kg)</th>
                                                <th>MF. Date</th>
                                                <th>Exp. Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach( $cartoon_details as $key => $cartoon_detail )
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $cartoon_detail->cartoon->status }}</td>
                                                <td>{{ $cartoon_detail->cartoon->cartoon_code }}</td>
                                                @if( $cartoon_detail->cartoon->status == "In" )
                                                    @php
                                                        $in_quantity += $cartoon_detail->quantity;
                                                    @endphp
                                                    <td>{{ $cartoon_detail->quantity }} kg</td>
                                                    <td>0</td>
                                                @else
                                                    @php
                                                        $out_quantity += $cartoon_detail->quantity;
                                                    @endphp
                                                    <td>0</td>
                                                    <td>{{ $cartoon_detail->quantity }} kg</td>
                                                @endif
                                                <td>{{ $cartoon_detail->cartoon->manufacture_date }}</td>
                                                <td>{{ $cartoon_detail->cartoon->expiry_date }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>{{$in_quantity}} kg</td>
                                                <td>{{$out_quantity}} kg</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    {{ $cartoon_details->links() }}
                                </div>
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