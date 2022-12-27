@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
<style>
    .data-indicator ul{
        padding-left: 15px;
    }
    .data-indicator ul li{
        display: inline;
    }
    td.even,
    th.even{
        background: whitesmoke;
    }
    table thead tr td{
        font-weight: bold;
    }
</style>
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
                                    @if( isset($temperature_logs) )
                                    <input class="btn btn-info mt-2 mr-2" type="button" id="download-button" name="submit" value="Download as csv" >
                                    @endif
                                    <input class="btn btn-success mt-2" type="submit" name="submit" value="Search">
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
                                <p class="text-center">Search result for date range : <span id="from">{{ $from }}</span> to <span id="to">{{ $to }}</span> </p>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="border: 1px solid #dfe2e6;">
                                    <thead>
                                        <tr>
                                            <td>SId.</td>
                                            <td>Date & Time</td>

                                            @for( $i = 0 ; $i < $total_freezer ; $i++ )
                                                @php
                                                    $mod_value = $i % 2;
                                                @endphp
                                            <td @if( $mod_value == 0 ) class="even" @endif >Temp. (°C)</td>
                                            <td @if( $mod_value == 0 ) class="even" @endif >D. Manual Id</td>
                                            <td @if( $mod_value == 0 ) class="even" @endif >Type</td>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if( isset($temperature_logs) )

                                            @php
                                                $i = 1;
                                                $count = 1;
                                            @endphp
                                            @forelse( $temperature_logs as $key => $temperature_log )
                                                
                                                @if( $i == 1 || $i % 30 == 1 )
                                                <tr>
                                                    <td>{{ $count }}</td>
                                                    <td>{{ $key }}</td>

                                                    @foreach( $temperature_log as $key => $log )
                                                        @php
                                                            $mod_value = $key % 2;
                                                        @endphp
                                                    <td @if( $mod_value == 0 ) class="even" @endif >{{ $log->temperature }}</td>
                                                    <td @if( $mod_value == 0 ) class="even" @endif >{{ $log->device_manual_id }}</td>
                                                    <td @if( $mod_value == 0 ) class="even" @endif >{{ $log->type }}</td>
                                                    @endforeach
                                                </tr>
                                                    @php
                                                        $count++;
                                                    @endphp
                                                @endif

                                                @php
                                                    $i++;
                                                @endphp
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


<script>
    function htmlToCSV(html, filename) {
        var data = [];
        var rows = document.querySelectorAll("table tr");
            
        for (var i = 0; i < rows.length; i++) {

            var row = [], cols = rows[i].querySelectorAll("td");

            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }
                     
            data.push(row.join(",")); 
            
        }


        downloadCSVFile(data.join("\n"), filename);
    }
    function downloadCSVFile(csv, filename) {
        var csv_file, download_link;

        let option = {
            type: "text/csv"
        };
        csv_file = new Blob([csv],option);

        download_link = document.createElement("a");

        download_link.download = filename;

        download_link.href = window.URL.createObjectURL(csv_file);

        download_link.style.display = "none";

        document.body.appendChild(download_link);

        download_link.click();
    }

    document.getElementById("download-button").addEventListener("click", function () {
        var html = document.querySelector("table").outerHTML;

        let from = $("#from").html();
        let to = $("#to").html();

        htmlToCSV(html, `temperature_log_${from}_to_${to}.csv`);
    });
</script>
@endsection