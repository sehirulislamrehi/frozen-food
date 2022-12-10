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
    #clear-selected-trolleys{
        cursor: pointer;
        margin-bottom: 15px;
        background: red;
        color: white;
        padding: 5px 10px;
        display: inline-block;
    }
    #clear-selected-trolleys:hover{
        background: #f18080;
    }
    #create-new-cartoon{
        display: inline-block;
        background: #40a1b8;
        color: white;
        padding: 5px 10px;
        margin: 0 0 0 10px;
        cursor: pointer;
    }
    .card-content{
        padding: 15px;
    }
    .quantity-row{
        border: 1px solid #d7d7d7;
        margin: 10px 5px;
        padding: 10px 0;
        box-shadow: black 1px 1px 3px -2px;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">

    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ route('blast.freezer.entry.out.item') }}">Out Trolleys</a>
            <a class="breadcrumb-item active" href="#">Create Cartoon</a>
        </nav>
    </div>

    <div class="br-pagebody">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <p> 
                                    <strong>Trolley codes are:</strong> 
                                    @php
                                        $cartoon_weight = 0;
                                    @endphp
                                    @foreach( $blast_freezer_entries as $blast_freezer_entry )
                                        @php
                                            $cartoon_weight += $blast_freezer_entry->quantity;
                                        @endphp
                                        {{ $blast_freezer_entry->trolley->code }},
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">
                        
                        @foreach( $blast_freezer_entries as $blast_freezer_entry )
                        <div class="row quantity-row">
                            <div class="col-md-2 form-group">
                                <label> <strong>Trolley Code:</strong> {{ $blast_freezer_entry->trolley->code }}</label>
                            </div>
                            <div class="col-md-2 form-group">
                                <label> <strong>Product:</strong> {{ $blast_freezer_entry->product_details->product->name }}</label>
                            </div>
                            <div class="col-md-2 form-group">
                                <label> <strong>Code:</strong> {{ $blast_freezer_entry->product_details->product->code }}</label>
                            </div>
                            <div class="col-md-2 form-group">
                                <label> <strong>Type:</strong> {{ $blast_freezer_entry->product_details->product->type }}</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Quantity (kg)</label>
                                @if( $blast_freezer_entry->product_details->product->type == "Local" )
                                <input type="number" value="{{ $blast_freezer_entry->remaining_quantity }}" max="{{ $blast_freezer_entry->remaining_quantity }}" min="1" class="form-control">
                                @else
                                <p class="form-control">{{ $blast_freezer_entry->remaining_quantity }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach

                        <div class="row mt-5">

                            <div class="col-md-3 form-group">
                                <label>Cartoon Name</label>
                                <input type="text" class="form-control" name="cartoon_name">
                            </div>

                            <div class="col-md-3 form-group ">
                                <label>Cartoon Weight (kg)</label>
                                <p class="form-control">{{$cartoon_weight}} kg</p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Packet Quantity (pieces)</label>
                                <input type="number" min="1" class="form-control" name="packet_quantity">
                            </div>
                            
                            <div class="col-md-3 form-group">
                                <label>Per Packet weight (kg)</label>
                                <input type="text" class="form-control" name="packet_weight">
                            </div>

                            <div class="col-md-3 form-group">
                                <label>Per packet items (pieces)</label>
                                <input type="number" min="1" class="form-control" name="items_per_packet">
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