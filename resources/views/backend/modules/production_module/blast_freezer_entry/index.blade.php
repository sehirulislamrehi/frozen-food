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
        border: 2px solid white;
        margin-bottom: 15px;
    }
    .timer span {
        font-size: 25px !important;
    }

    .timer span.separator {
        margin: 0 5px;
    }

    .time-over{
        border: 2px solid red!important;
        /* background: #ffeded!important; */
    }
    .time-almost-over{
        border: 2px solid #ffcb8c;
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
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">

    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">Blast Freezer Entry</a>
        </nav>
    </div>

    <div class="br-pagebody">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header text-right">
                        @if( can('add_blast_freezer_entry') )
                        <button type="button" data-content="{{ route('blast.freezer.entry.modal') }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            Add
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- freezer entry data row start -->
        <div class="row blast-freezer-entry">

            <!-- card item start -->
            @foreach( $blast_freezer_entries as $key => $blast_freezer_entry )
            <div class="col-md-4">
                @php
                    $different_in_hour = $current_time->diffInHours($blast_freezer_entry->lead_time);

                    if( $different_in_hour == 0 ){
                        if( $current_min < date('i',strtotime($blast_freezer_entry->lead_time)) ){
                            $different_in_min = date('i',strtotime($blast_freezer_entry->lead_time)) - $current_min - 1;
                        }
                        else{
                            $different_in_min = 60 - ($current_min - date('i',strtotime($blast_freezer_entry->lead_time))) - 1;
                        }
                    }
                    else{
                        if( $current_min < date('i',strtotime($blast_freezer_entry->lead_time)) ){
                            $different_in_min = date('i',strtotime($blast_freezer_entry->lead_time)) - $current_min - 1;
                        }
                        else{
                            $different_in_min = 60 - ($current_min - date('i',strtotime($blast_freezer_entry->lead_time))) - 1;
                        }
                    }
                    
                @endphp

                <div class="card-item">

                    @if( date('Y-m-d H:i:s') > $blast_freezer_entry->lead_time )
                        <div id="timer-{{ $key + 1 }}" class="timer">
                            @if( $blast_freezer_entry->status == "In" )
                                <span>
                                    <span class="hour" id="hour-{{ $key + 1 }}">0</span>
                                    <span class="time-name">H</span>
                                </span>

                                <span class="separator">:</span>

                                <span>
                                    <span class="minutes" id="minutes-{{ $key + 1 }}">0</span>
                                    <span class="time-name">M</span>
                                </span>
                                
                                <span class="separator">:</span>

                                <span>
                                    <span class="seconds" id="seconds-{{ $key + 1 }}">0</span>
                                    <span class="time-name">S</span>
                                </span>
                            @else
                                <p class="alert alert-success mb-0" style="padding: 8px;">Trolley out from the blast freeze</p>
                            @endif
                        </div>
                    @else
                        <div id="timer-{{ $key + 1 }}" class="timer">
                            <span>
                                <span class="hour" id="hour-{{ $key + 1 }}">{{ $different_in_hour }}</span>
                                <span class="time-name">H</span>
                            </span>

                            <span class="separator">:</span>

                            <span>
                                <span class="minutes" id="minutes-{{ $key + 1 }}">{{ $different_in_min }}</span>
                                <span class="time-name">M</span>
                            </span>
                            
                            <span class="separator">:</span>

                            <span>
                                <span class="seconds" id="seconds-{{ $key + 1 }}">{{ $current_second }}</span>
                                <span class="time-name">S</span>
                            </span>
                        </div>
                    @endif

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
                            {{ $blast_freezer_entry->product_details->product->name }}
                        </p>
                        <p>
                            <strong>Lead Time :</strong>
                            {{ date("H:i", strtotime($blast_freezer_entry->lead_time)) }}
                        </p>
                        <p>
                            <strong>Trolley out at :</strong>
                            {{ $blast_freezer_entry->trolley_outed ? date("H:i", strtotime($blast_freezer_entry->trolley_outed)) : 'Currently In' }}
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
            <script>
        
                setInterval(function(){

                    let id = "{{ $key + 1 }}"
                    let timer = document.getElementById(`timer-${id}`)
                    let hour = document.getElementById(`hour-${id}`);
                    let minutes = document.getElementById(`minutes-${id}`);
                    let seconds = document.getElementById(`seconds-${id}`);

                    if( hour ){

                        let second_value = seconds.innerHTML - 1;
                    
                        if( second_value < 0 ){

                            let minutes_value = minutes.innerHTML - 1;

                            if( minutes_value < 0 ){

                                let hour_value = hour.innerHTML - 1;

                                if( hour_value < 0 ){

                                    hour.innerHTML = 0;
                                    minutes.innerHTML = 0;
                                    seconds.innerHTML = 0;

                                    if( hour.innerHTML == 0 && minutes.innerHTML == 0 && seconds.innerHTML == 0 ){
                                        timer.parentElement.classList.remove("time-almost-over")
                                        if( timer.parentElement.classList.contains("time-over") ){
                                            timer.parentElement.classList.remove("time-over")
                                        }
                                        else{
                                            timer.parentElement.classList.add("time-over")
                                        }
                                    }
                                }
                                else{
                                    hour.innerHTML = hour_value;

                                    minutes.innerHTML = 59;
                                    seconds.innerHTML = 59;
                                }
                            }
                            else{

                                
                                minutes.innerHTML = minutes_value;
                                seconds.innerHTML = 59;

                                if( hour.innerHTML == 0 && minutes.innerHTML < 6 ){
                                    if( timer.parentElement.classList.contains("time-almost-over") ){
                                        timer.parentElement.classList.remove("time-almost-over")
                                    }
                                    else{
                                        timer.parentElement.classList.add("time-almost-over")
                                    }
                                }

                            }
                        }
                        else{
                            seconds.innerHTML = second_value

                            if( hour.innerHTML == 0 && minutes.innerHTML < 6 ){
                                if( timer.parentElement.classList.contains("time-almost-over") ){
                                    timer.parentElement.classList.remove("time-almost-over")
                                }
                                else{
                                    timer.parentElement.classList.add("time-almost-over")
                                }
                            }

                        }

                    }

                },1000)
                    
            </script>
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
    
    @endsection