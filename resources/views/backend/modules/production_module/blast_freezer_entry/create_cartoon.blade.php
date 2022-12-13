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
                                        $type = "";
                                        $life_time = 0;
                                    @endphp
                                    @foreach( $blast_freezer_entries as $blast_freezer_entry )
                                        @php
                                            $cartoon_weight += $blast_freezer_entry->remaining_quantity;
                                            $type = $blast_freezer_entry->product_details->product->type;
                                            $life_time = product_life_time($type);
                                        @endphp
                                        {{ $blast_freezer_entry->trolley->code }},
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">
                        <form action="{{ route('create.cartoon') }}" method="POST" class="ajax-form">
                            @csrf

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
                                    {{--@if( $blast_freezer_entry->product_details->product->type == "Local" )--}}
                                    <input type="number" value="{{ $blast_freezer_entry->remaining_quantity }}" oninput="updateQuantity(this)" max="{{ $blast_freezer_entry->remaining_quantity }}" @if($blast_freezer_entry->remaining_quantity < 1 ) min="0" @else min="1" @endif step="0.01" name="remaining_quantity[]" class="form-control product_quantity">
                                    {{-- @else
                                    <p class="form-control">{{ $blast_freezer_entry->remaining_quantity }}</p>
                                    @endif --}}
                                </div>
                            </div>
                            <input type="hidden" value="{{ $blast_freezer_entry->code }}" name="blast_freezer_entries_code[]">
                            @endforeach

                            <div class="row mt-5">

                                <div class="col-md-3 form-group">
                                    <label>Cartoon Name</label><span class="require-span">*</span>
                                    <input type="text" class="form-control" name="cartoon_name">
                                </div>

                                <div class="col-md-3 form-group ">
                                    <label>Cartoon Weight (kg)</label><span class="require-span">*</span>
                                    <input type="number" min="1" step="0.01" class="form-control" name="cartoon_weight" id="cartoon-weight" value="{{$cartoon_weight}}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Packet Quantity (pieces)</label><span class="require-span">*</span>
                                    <input type="number" min="1" class="form-control" name="packet_quantity">
                                </div>
                                
                                <div class="col-md-3 form-group">
                                    <label>Per Packet weight (kg)</label><span class="require-span">*</span>
                                    <input type="number" min="0" step="0.01" class="form-control" name="per_packet_weight">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Per packet items (pieces)</label>
                                    <input type="number" class="form-control" name="per_packet_item">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Sample items (pieces)</label><span class="require-span">*</span>
                                    <input type="number" min="0" class="form-control" name="sample_item" value="0">
                                </div>

                                <!-- Manufacture Date -->
                                <div class="col-md-3 form-group">
                                    <label>Manufacture Date</label><span class="require-span">*</span>
                                    <input type="date" class="form-control" name="manufacture_date" id="manufacture_date">
                                </div>

                                <!-- Expiry Date -->
                                <div class="col-md-3 form-group">
                                    <label>Expiry Date</label><span class="require-span">*</span>
                                    <input type="date" readonly class="form-control" name="expiry_date" id="expiry_date">
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success">Create</button>
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

            if( e.value > 0 ){
                let product_quantity = document.querySelectorAll(".product_quantity")
                let total_quantity = 0;

                for( let i = 0 ; i < product_quantity.length ; i++ ){
                    total_quantity += product_quantity[i].value ? parseFloat(product_quantity[i].value) : 0
                }

                document.getElementById("cartoon-weight").value = total_quantity.toFixed(2)
            }
            
        }
    </script>

    <script>
        $(document).on('change','#manufacture_date', function(){
            let $this = $(this)
            let type = "{{ $type }}"
            let life_time = "{{ $life_time }}";
            const  manufacture_date = $this.val()
            let split_value = manufacture_date.split("-");

            if( type == "Local" ){
                let year =  parseInt(split_value[0]) + parseInt(life_time)
                let new_date = year +'-'+ split_value[1] +'-'+ split_value[2];
                $("#expiry_date").val(new_date);
            }
            else{
                let year =  parseInt(split_value[0]) + parseInt(life_time)
                let new_date = year +'-'+ split_value[1] +'-'+ split_value[2];
                $("#expiry_date").val(new_date);
            }

        })
    </script>
    @endsection