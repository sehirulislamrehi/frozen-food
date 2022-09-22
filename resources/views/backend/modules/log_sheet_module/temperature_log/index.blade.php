@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
@endsection

@section('body-content')

<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">Temperature log</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <form action="{{ route('temperature.get.data') }}" method="GET">
                            @csrf
                            <div class="row">

                                @if( auth('super_admin')->check() )
                                    @include('backend.modules.log_sheet_module.temperature_log.includes.super_admin')
                                @else
                                    @include('backend.modules.log_sheet_module.temperature_log.includes.user')
                                @endif

                                <!-- Select Freezer/Room -->
                                <div class="col-md-3 select-freezer">
                                    <label>Select Freezer/Room</label><span class="require-span">*</span>
                                    <div class="freezer-block">
                                        <select name="freezer_id" class="form-control freezer_id" required>
                                            <option value="" selected disabled>Select freezer/room</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Device type -->
                                <div class="col-md-3">
                                    <label>Device type</label><span class="require-span">*</span>
                                    <select name="type" class="form-control">
                                        <option value="All">All</option>
                                        <option value="Blast Freeze">Blast Freeze</option>
                                        <option value="Pre Cooler">Pre Cooler</option>
                                    </select>
                                </div>

                                <!-- from date time -->
                                <div class="col-md-3">
                                    <label>From Date</label><span class="require-span">*</span>
                                    <input type="datetime-local" class="form-control" name="from_date_time" @if( isset($from) ) value="{{ $from }}" @endif required>
                                </div>

                                <!-- to date time -->
                                <div class="col-md-3">
                                    <label>To Date</label><span class="require-span">*</span>
                                    <input type="datetime-local" class="form-control" name="to_date_time" @if( isset($to) ) value="{{ $to }}" @endif required>
                                </div>

                                <div class="col-md-12 text-right">
                                    <button class="btn btn-success mt-2">
                                        Search
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-body">
                        @if( isset($from) && isset($to) )
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="text-center">Search result for date range : {{ $from }} to {{ $to }} </p>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SId.</th>
                                            <th>Temperature (°C)</th>
                                            <th>Date & Time</th>
                                            <th>Device Manual Id</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if( isset($temperature_logs) )
                                            @forelse( $temperature_logs as $key => $temperature_log )
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $temperature_log->temperature }}</td>
                                                <td>{{ $temperature_log->date_time }}</td>
                                                <td>{{ $temperature_log->device_manual_id }}</td>
                                                <td>{{ $temperature_log->type }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No data found</td>
                                            </tr>
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
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

<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>
<script>
    $(document).ready(function domReady() {
        $(".chosen").chosen();
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
                            <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)" required>
                                <option value="" selected disabled>Select company</option>
                            </select>
                        </div>
                    `);

                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)" required>
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
        let company_id = e.value
        $.ajax({
            type: "GET",
            url: "{{ route('company.wise.location') }}",
            data: {
                company_id: company_id,
            },
            success: function(response) {
                if (response.status == "success") {
                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)" required>
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


    function locationChange(e){
        let location_id = e.value

        $.ajax({
            type: "GET",
            url: "{{ route('location.wise.freezer') }}",
            data: {
                location_id: location_id,
            },
            success: function(response) {
                if (response.status == "success") {
                    $(".freezer-block").remove();
                    $(".select-freezer").append(`
                        <div class="freezer-block">
                            <select name="freezer_id" class="form-control freezer_id chosen">
                                <option value="" selected disabled>Select freezer</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value) {
                        $(".freezer_id").append(`
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
</script>
@endsection