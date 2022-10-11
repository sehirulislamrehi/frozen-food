@extends("backend.template.layout")

@section('per_page_css')
<style>
    .data-indicator ul {
        padding-left: 15px;
    }

    .data-indicator ul li {
        display: inline;
    }

    .blast-freezer-entry {
        padding: 15px 0;
    }

    .blast-freezer-entry .card-item {
        background: white;
        padding: 5px;
    }

    .card-item{
        border: 2px solid white;
        margin-bottom: 15px;
    }
    .card-item .card-content{
        text-align: center;
        border-top: 2px solid #f1f1f1;
        padding: 15px;
    }
    .card-item .card-content p{
        margin-bottom: 10px;
    }
    .custom-popover{
        font-size: 10px;
        background: #7a7a7a;
        color: white;
        padding: 3px 6px;
        border-radius: 100%;
        cursor: pointer;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">

    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">Blast Freezer Entry ( Out trolleys )</a>
        </nav>
    </div>

    <div class="br-pagebody">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('blast.freezer.entry.all') }}" class="btn btn-success">See In Trolleys</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- freezer entry data row start -->
        <div class="row blast-freezer-entry">

            <!-- search box start -->
            <div class="col-md-12">
                <form action="{{ route('blast.freezer.entry.out.item') }}" method="GET">
                    @csrf
                    <div class="row search-box">

                        <!-- from -->
                        <div class="form-group col-md-2">
                            <label>From Date</label>
                            <input type="datetime-local" class="form-control" name="from_date" required value="{{ $from }}">
                        </div>

                        <!-- to -->
                        <div class="form-group col-md-2">
                            <label>To Date</label>
                            <input type="datetime-local" class="form-control" name="to_date" required value="{{ $to }}">
                        </div>

                        <!-- Search -->
                        <div class="form-group col-md-2">
                            <label>
                                Search
                                <i class="fas fa-info custom-popover" 
                                    data-toggle="popover" 
                                    data-placement="top"
                                    title="Search Fields" 
                                    data-content="Code, Device Manual Id, Trolley Code"
                                ></i>
                            </label>
                            <input type="search" class="form-control" name="search" value="{{ $search }}">
                        </div>

                        <!-- button -->
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-success mt-3">
                                Search
                            </button>
                            <a href="{{ route('blast.freezer.entry.out.item') }}" class="btn btn-info mt-3">
                                Clear Search
                            </a>
                        </div>
                    
                    </div>
                </form>
            </div>
            <!-- search box end -->

            <!-- card item start -->
            @foreach( $blast_freezer_entries as $key => $blast_freezer_entry )
            <div class="col-md-4">

                <div class="card-item">

                    <div class="card-content">
                        <p>
                            <strong>Code :</strong>
                            {{ $blast_freezer_entry->code }}
                        </p>
                        <p>
                            <strong>Device Manual ID :</strong>
                            {{ $blast_freezer_entry->device->device_manual_id }}
                        </p>
                        <p>
                            <strong>Trolley :</strong>
                            {{ $blast_freezer_entry->trolley->code }}
                        </p>
                        <p>
                            <strong>Product :</strong>
                            {{ $blast_freezer_entry->product_details->product->code }} - {{ $blast_freezer_entry->product_details->product->name }}
                        </p>
                        <p>
                            <strong>Lead Time :</strong>
                            {{ date("Y-m-d H:i", strtotime($blast_freezer_entry->lead_time)) }}
                        </p>
                        <p>
                            <strong>Trolley out at :</strong>
                            {{ $blast_freezer_entry->trolley_outed ? date("Y-m-d H:i", strtotime($blast_freezer_entry->trolley_outed)) : 'Currently In' }}
                        </p>
                        <p>
                            <strong>Quantity :</strong>
                            {{ $blast_freezer_entry->quantity }} / {{ $blast_freezer_entry->trolley->storage }} Kg
                        </p>
                        <p>
                            <strong>Status :</strong>
                            {{ $blast_freezer_entry->status }}
                        </p>
                        <p>
                            <strong>Created :</strong>
                            {{ $blast_freezer_entry->created_at->toDayDateTimeString() }}
                        </p>
                    </div>

                </div>
            </div>
            @endforeach
            <!-- card item end -->

        </div>
        <!-- freezer entry data row end -->

        <div class="row">
            {{ $blast_freezer_entries->links() }}
        </div>

    </div>


    @endsection

    @section('per_page_js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('backend/js/custom-script.min.js') }}"></script>
    <script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>
    <script>
        $(function () {
  $('[data-toggle="popover"]').popover()
})
    </script>
    @endsection