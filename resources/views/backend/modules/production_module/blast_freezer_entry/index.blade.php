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

    .timer {
        text-align: center;
        padding: 15px;
    }

    .card-item{
        border: 4px solid white;
        margin-bottom: 15px;
    }
    .timer span {
        font-size: 25px !important;
    }

    .timer span.separator {
        margin: 0 5px;
    }

    .time-over{
        border: 4px solid red!important;
        /* background: #ffeded!important; */
    }
    .time-almost-over{
        border: 4px solid #ffb55d;
        /* background: #ffc107!important; */
    }
    .time-name{
        color: #5f55ff;
    }
    .card-item .card-content{
        text-align: center;
        border-top: 2px solid #f1f1f1;
        padding: 15px;
    }
    .card-item .card-content p{
        margin-bottom: 10px;
    }
    .timer-countdown{
        font-size: 25px!important;
        margin: -10px;
    }
    .timer-countdown small{
        font-size: 20px;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">

    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">Blast Freezer Entry ( In trolleys )</a>
        </nav>
    </div>

    <div class="br-pagebody">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('blast.freezer.entry.out.item') }}" class="btn btn-success">See Out Trolleys</a>
                            </div>
                            <div class="col-md-6 text-right">
                                @if( can('add_blast_freezer_entry') )
                                <button type="button" data-content="{{ route('blast.freezer.entry.modal') }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                    Add
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- freezer entry data row start -->
        <div class="row blast-freezer-entry">

            @php
                $sum_quantity = 0;
            @endphp
            <!-- card item start -->
            @foreach( $blast_freezer_entries as $key => $blast_freezer_entry )
                @php
                    $sum_quantity += $blast_freezer_entry->quantity;
                @endphp
            
                <div class="col-md-4">
                    {{--@php
                        $different_in_hour = $current_time->diffInHours($blast_freezer_entry->lead_time);
                        
                        if( $current_min < date('i',strtotime($blast_freezer_entry->lead_time)) ){
                            $different_in_min = date('i',strtotime($blast_freezer_entry->lead_time)) - $current_min - 1;
                        }
                        else{
                            $different_in_min = 60 - ($current_min - date('i',strtotime($blast_freezer_entry->lead_time))) - 1;
                        }
                    @endphp--}}

                    <div class="card-item">

                        
                        <div id="timer-{{ $key + 1 }}" class="timer">
                            @if( date('Y-m-d H:i:s') > $blast_freezer_entry->lead_time )
                                <p id="demo-{{ $key + 1 }}" class="timer-countdown"></p>
                            @else
                                <p id="demo-{{ $key + 1 }}" class="timer-countdown"></p>
                            @endif
                        </div>
                        <script>
                            // Update the count down every 1 second
                            setInterval(function() {

                                let id = "{{ $key + 1 }}"

                                let lead_time = "{{ $blast_freezer_entry->lead_time }}";

                                let countDownDate = new Date(`${lead_time}`).getTime();

                                // Get today's date and time
                                let now = new Date().getTime();
                                    
                                // Find the distance between now and the count down date
                                let distance = countDownDate - now;

                                let timer = document.getElementById(`demo-${id}`);

                                if( distance < 0 ){
                                    document.getElementById(`demo-${id}`).innerHTML = "<small>Time over. Please out the trolley</small>";

                                    if( timer.parentElement.parentElement.classList.contains("time-almost-over") ){
                                        timer.parentElement.parentElement.classList.remove("time-almost-over")
                                    }

                                    if( timer.parentElement.parentElement.classList.contains("time-over") ){
                                        timer.parentElement.parentElement.classList.remove("time-over")
                                    }
                                    else{
                                        timer.parentElement.parentElement.classList.add("time-over")
                                    }
                                }
                                else{
                                    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                        
                                    
                                    timer.innerHTML = hours + " <span class='time-name'>H : </span> "
                                    + minutes + " <span class='time-name'>M : </span> " + seconds + " <span class='time-name'>S</span> ";

                                    if( hours == 0 && minutes < 5 ){
                                        if( timer.parentElement.parentElement.classList.contains("time-almost-over") ){
                                            timer.parentElement.parentElement.classList.remove("time-almost-over")
                                        }
                                        else{
                                            timer.parentElement.parentElement.classList.add("time-almost-over")
                                        }
                                    }
                                }
                            }, 1000);
                        </script>

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
                                {{ $blast_freezer_entry->quantity }} Kg
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

                        <div class="card-footer text-center">

                            @if( can("edit_blast_freezer_entry") )
                            <button type="button" data-content="{{ route('blast.freezer.entry.edit.modal', encrypt($blast_freezer_entry->id)) }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                Edit
                            </button>
                            @endif

                            @if( can("delete_blast_freezer_entry") )
                            <button type="button" data-content="{{ route('blast.freezer.entry.delete.modal', encrypt($blast_freezer_entry->id)) }}" data-target="#myModal" class="btn btn-danger" data-toggle="modal">
                                Delete
                            </button>
                            @endif

                        </div>

                    </div>
                </div>
            @endforeach
            <!-- card item end -->

        </div>
        <!-- freezer entry data row end -->

        <div class="row mt-3 mb-3">
            <div class="col-md-12">
                <p>Total quantity: <strong>{{ $sum_quantity }} kg</strong>  </p>
            </div>
        </div>

        <div class="row">
            {{ $blast_freezer_entries->links() }}
        </div>

    </div>


    @endsection

    @section('per_page_js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('backend/js/custom-script.min.js') }}"></script>
    <script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>

    @endsection