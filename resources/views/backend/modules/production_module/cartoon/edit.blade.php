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
            <a class="breadcrumb-item" href="{{ route('cartoon.list.all') }}">Cartool List</a>
            <a class="breadcrumb-item active" href="#">{{ $cartoon->cartoon_code }}</a>
        </nav>
    </div>

    <div class="br-pagebody">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        
                    </div>

                    <div class="card-content">
                        <form action="{{ route('edit.cartoon', $cartoon->cartoon_code) }}" method="POST" class="ajax-form">
                            @csrf
                            
                            @foreach( $cartoon->cartoon_details as $cartoon_detail )
                            <div class="row quantity-row">
                                <div class="col-md-2 form-group">
                                    <label> <strong>Trolley Code:</strong> {{ $cartoon_detail->blast_freezer_entry->trolley->code }}</label>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label> <strong>Product:</strong> {{ $cartoon->product->name }}</label>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label> <strong>Code:</strong> {{ $cartoon->product->code }}</label>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label> <strong>Type:</strong> {{ $cartoon->product->type }}</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Quantity (kg)</label>
                                    <input type="number" value="{{ $cartoon_detail->quantity }}" oninput="updateQuantity(this)" max="{{ $cartoon_detail->quantity + $cartoon_detail->blast_freezer_entry->remaining_quantity }}" min="0" name="quantity[]" class="form-control product_quantity">
                                </div>
                            </div>
                            <input type="hidden" value="{{ $cartoon_detail->blast_freezer_entry->code }}" name="blast_freezer_entries_code[]">
                            @endforeach

                            <div class="row mt-5">

                                <div class="col-md-3 form-group">
                                    <label>Cartoon Name</label>
                                    <input type="text" class="form-control" name="cartoon_name" value="{{ $cartoon->cartoon_name }}">
                                </div>

                                <div class="col-md-3 form-group ">
                                    <label>Cartoon Weight (kg)</label>
                                    <p class="form-control"> <span id="cartoon-weight">{{$cartoon->cartoon_weight}}</span> kg</p>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Packet Quantity (pieces)</label>
                                    <input type="number" min="1" class="form-control" name="packet_quantity" value="{{ $cartoon->packet_quantity }}">
                                </div>
                                
                                <div class="col-md-3 form-group">
                                    <label>Per Packet weight (kg)</label>
                                    <input type="text" class="form-control" name="per_packet_weight" value="{{ $cartoon->per_packet_weight }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Per packet items (pieces)</label>
                                    <input type="number" min="1" class="form-control" name="per_packet_item" value="{{ $cartoon->per_packet_item }}">
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>                        
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
    <script>
        function updateQuantity(e){

            if( e.value == 0 ){
                swal("","Quantity value 0 will works to delete a trolley","warning")
            }

            if( e.value > 0 ){
                let product_quantity = document.querySelectorAll(".product_quantity")
                let total_quantity = 0;

                for( let i = 0 ; i < product_quantity.length ; i++ ){
                    total_quantity += product_quantity[i].value ? parseInt(product_quantity[i].value) : 0
                }

                document.getElementById("cartoon-weight").innerHTML = total_quantity 
            }
            
        }
    </script>
    @endsection