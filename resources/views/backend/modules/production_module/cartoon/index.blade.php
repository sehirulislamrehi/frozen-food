@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">

<style>
    .data-indicator ul {
        padding-left: 15px;
    }

    .data-indicator ul li {
        display: inline;
    }

    .custom-popover {
        font-size: 10px;
        background: #7a7a7a;
        color: white;
        padding: 3px 6px;
        border-radius: 100%;
        cursor: pointer;
    }

    .form-control,
    .dataTables_filter input {
        height: calc(2.6125rem + -5px);
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
                <div class="card card-primary card-outline">

                    <div class="card-body">

                        <div class="col-md-12">
                            <form action="{{ route('cartoon.list.all') }}" method="get">
                                @csrf
                                <div class="row">

                                    <div class="col-md-2 form-group">
                                        <label>
                                            Search
                                            <i class="fas fa-info custom-popover" data-toggle="popover" data-placement="top" title="Search Fields" data-content="Cartoon code, Name"></i>
                                        </label>
                                        <input type="search" class="form-control" name="search" value="{{ isset($search) ? $search : '' }}">
                                    </div>

                                    <!-- select group -->
                                    <div class="col-md-2 col-12 form-group">
                                        <label>Select Group</label>
                                        <select name="group_id" class="form-control chosen" onchange="groupChange(this)">
                                            <option value="" disabled selected>Select group</option>
                                            @foreach( $groups as $group )
                                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- select company -->
                                    <div class="col-md-2 col-12 form-group select-company">
                                        <label>Select company</label>
                                        <div class="company-block">
                                            <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">
                                                <option value="" selected disabled>Select company</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- select location -->
                                    <div class="col-md-2 col-12 form-group select-location">
                                        <label>Select location</label>
                                        <div class="location-block">
                                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                                <option value="" selected disabled>Select location</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Select Product -->
                                    <div class="col-md-2 select-product">
                                        <label>Select Product</label>
                                        <div class="product-block">
                                            <select name="product_id" class="form-control product_id chosen">
                                                <option value="" selected disabled>Select product</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <button type="submit" class="btn btn-info btn-sm mt-4">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="{{ route('cartoon.list.all') }}" class="btn btn-success btn-sm mt-4">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><strong>Group result for </strong> @if( $search_group ) {{$search_group->name}} @else All @endif</p>
                                        <p><strong>Company result for </strong> @if( $company ) {{$company->name}} @else All @endif</p>
                                        <p><strong>Location result for </strong> @if( $location ) {{$location->name}} @else All @endif</p>
                                        <p><strong>Product result for </strong> @if( $product ) {{$product->name}} @else All @endif</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
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
                                    @php
                                        $actual_weight = 0;
                                        $weight = 0;
                                    @endphp
                                    @forelse( $cartoons as $key => $cartoon )
                                        @php
                                            $actual_weight += $cartoon->actual_cartoon_weight;
                                            $weight += $cartoon->cartoon_weight;
                                        @endphp
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
                                        <td colspan="10" class="text-center">No data found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>{{$actual_weight}} kg</td>
                                        <td>{{$weight}} kg</td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <p>{{ ($check_search == true) ? null : $cartoons->links() }}</p>
                        </div>
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
<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>
<script>
    $(document).ready(function domReady() {
        $(".chosen").chosen();
    });
</script>
<script>
    $(function() {
        $('[data-toggle="popover"]').popover()
    })
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
                            <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">
                                <option value="" selected disabled>Select company</option>
                            </select>
                        </div>
                    `);

                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value) {
                        $(".company_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".chosen").chosen();
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
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value) {
                        $(".location_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response) {

            },
        })
    }


    function locationChange(e) {

        let location_id = Array();

        location_id.push(e.value)

        $.ajax({
            type: "GET",
            url: "{{ route('location.wise.data') }}",
            data: {
                location_ids: location_id,
            },
            success: function(response) {
                if (response.status == "success") {
                    $(".product-block").remove();
                    $(".select-product").append(`
                        <div class="product-block">
                            <select name="product_id" class="form-control product_id chosen">
                                <option value="" selected disabled>Select product</option>
                            </select>
                        </div>
                    `);

                    $.each(response.product_details, function(key, value) {
                        $(".product_id").append(`
                            <option value="${value.product.id}">${value.product.name}</option>
                        `);
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response) {

            },
        })
    }
</script>
@endsection