@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header">
                        <form action="{{ route('temperature.get.data') }}" method="GET">
                            @csrf
                            <div class="row">

                                <!-- from date time -->
                                <div class="col-md-6">
                                    <label>From Date</label><span class="require-span">*</span>
                                    <input type="datetime-local" class="form-control" name="from_date_time" required>
                                </div>

                                <!-- to date time -->
                                <div class="col-md-6">
                                    <label>To Date</label><span class="require-span">*</span>
                                    <input type="datetime-local" class="form-control" name="to_date_time" required>
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
@endsection