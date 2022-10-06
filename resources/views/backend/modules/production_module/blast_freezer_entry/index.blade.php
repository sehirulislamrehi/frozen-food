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
        border: 2px solid white;
    }

    .timer span {
        font-size: 25px !important;
    }

    .timer span.separator {
        margin: 0 5px;
    }

    .time-over{
        border: 2px solid red!important;
        background: #ffeded!important;
    }
    .time-almost-over{
        border: 2px solid #ffcb8c;
        background: #ffe5bf;
    }
    .time-name{
        color: #5f55ff;
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
                        @if( can('add_freezer') )
                        <button type="button" data-content="{{ route('freezer.add.modal') }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
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
            @foreach( $datas as $data )
            <div class="col-md-4">
                <div class="card-item">
                    <div id="timer-1" class="timer">
                        <span>
                            <span class="hour">{{ $data['hour'] }}</span>
                            <span class="time-name">H</span>
                        </span>

                        <span class="separator">:</span>

                        <span>
                            <span class="minutes">{{ $data['min'] }}</span>
                            <span class="time-name">M</span>
                        </span>
                        
                        <span class="separator">:</span>

                        <span>
                            <span class="seconds">{{ $data['sec'] }}</span>
                            <span class="time-name">S</span>
                        </span>
                        
                    </div>
                </div>
            </div>
            @endforeach
            <!-- card item end -->

        </div>
        <!-- freezer entry data row end -->

    </div>


    @endsection

    @section('per_page_js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('backend/js/custom-script.min.js') }}"></script>
    <script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>
    <script>
        
        setInterval(function(){

            let timer = document.getElementsByClassName("timer")

            for( let i = 0 ; i < timer.length ; i++ ){

                let hour = document.getElementsByClassName("hour")[i];
                let minutes = document.getElementsByClassName("minutes")[i];
                let seconds = document.getElementsByClassName("seconds")[i];

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
                                timer[i].classList.remove("time-almost-over")
                                if( timer[i].classList.contains("time-over") ){
                                    timer[i].classList.remove("time-over")
                                }
                                else{
                                    timer[i].classList.add("time-over")
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

                        if( hour.innerHTML == 0 && minutes.innerHTML < 6 ){
                            if( timer[i].classList.contains("time-almost-over") ){
                                timer[i].classList.remove("time-almost-over")
                            }
                            else{
                                timer[i].classList.add("time-almost-over")
                            }
                        }

                        minutes.innerHTML = minutes_value;
                        seconds.innerHTML = 59;
                    }
                }
                else{
                    seconds.innerHTML = second_value

                    if( hour.innerHTML == 0 && minutes.innerHTML < 6 ){
                        if( timer[i].classList.contains("time-almost-over") ){
                            timer[i].classList.remove("time-almost-over")
                        }
                        else{
                            timer[i].classList.add("time-almost-over")
                        }
                    }

                }

            }

        },1000)
            
    </script>
    @endsection