@extends("backend.template.layout")

@section('per_page_css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
        padding: 0 20px;
    }
    .quantity-row .quantity-col{
        border: 1px solid #d7d7d7;
        margin: 10px 5px;
        padding: 10px;
        box-shadow: black 1px 1px 3px -2px;
    }
    .add-new-trolley{
        display: initial;
        background: #d5d5d5;
    }
    .remove-item{
        background: red;
        border: none;
        color: white;
        cursor: pointer;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">

    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item" href="{{ route('cartoon.list.all') }}">Cartool List</a>
            <a class="breadcrumb-item active">{{ $cartoon->cartoon_code }}</a>
        </nav>
    </div>

    <div class="br-pagebody">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        @if( can("create_cartoon") )
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a class="dropdown-item add-new-trolley" href="#" data-content="{{ route('add.trolley_product.cartoon.modal',[
                                    'code' => $cartoon->cartoon_code,
                                    'product_details_id' => $product_details_id ? $product_details_id : 'null'  
                                ]) }}" data-target="#largeModal" data-toggle="modal">
                                    <i class="fas fa-plus"></i>
                                    Add Trolley 
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="card-content">
                        <form action="{{ route('edit.cartoon', $cartoon->cartoon_code) }}" method="POST" class="ajax-form">
                            @csrf
                            
                            
                            <div class="row quantity-row">
                                @foreach( $cartoon->cartoon_details as $cartoon_detail )
                                <div class="col-md-12 quantity-col">
                                    <div class="row">
                                        <div class="col-md-2 form-group">
                                            <label> <strong>Trolley Code:</strong> {{ $cartoon_detail->blast_freezer_entry->trolley->code }}</label>
                                            <label> <strong>Blast freezer entry Code:</strong> {{ $cartoon_detail->blast_freezer_entry->code }}</label>
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
                                            <input type="number" value="{{ $cartoon_detail->quantity }}" step="0.01" oninput="updateQuantity(this)" max="{{ $cartoon_detail->quantity + $cartoon_detail->blast_freezer_entry->remaining_quantity }}" min="0" name="quantity[]" class="form-control product_quantity">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="{{ $cartoon_detail->blast_freezer_entry->code }}" name="blast_freezer_entries_code[]">
                                @endforeach 
                            </div>
                            
                            <div class="row mt-5">

                                <div class="col-md-3 form-group">
                                    <label>Cartoon Name</label><span class="require-span">*</span>
                                    <input type="text" class="form-control" name="cartoon_name" value="{{ $cartoon->cartoon_name }}">
                                </div>

                                <div class="col-md-3 form-group ">
                                    <label>Cartoon Weight (kg)</label><span class="require-span">*</span>
                                    <input type="number" min="1" step="0.01" class="form-control" name="cartoon_weight" id="cartoon-weight" value="{{$cartoon->actual_cartoon_weight}}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Packet Quantity (pieces)</label><span class="require-span">*</span>
                                    <input type="number" min="1" class="form-control" name="packet_quantity" value="{{ $cartoon->packet_quantity }}">
                                </div>
                                
                                <div class="col-md-3 form-group">
                                    <label>Per Packet weight (kg)</label><span class="require-span">*</span>
                                    <input type="number" min="0" step="0.01" class="form-control" name="per_packet_weight" value="{{ $cartoon->per_packet_weight }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Per packet items (pieces)</label>
                                    <input type="number" min="1" class="form-control" name="per_packet_item" value="{{ $cartoon->per_packet_item }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label>Sample items (pieces)</label><span class="require-span">*</span>
                                    <input type="number" min="0" class="form-control" name="sample_item" value="{{ $cartoon->sample_item }}">
                                </div>

                                <!-- Manufacture Date -->
                                <div class="col-md-3 form-group">
                                    <label>Manufacture Date</label><span class="require-span">*</span>
                                    <input type="date" class="form-control" name="manufacture_date" id="manufacture_date" value="{{ $cartoon->manufacture_date }}">
                                </div>

                                <!-- Expiry Date -->
                                <div class="col-md-3 form-group">
                                    <label>Expiry Date</label><span class="require-span">*</span>
                                    <input type="date" readonly class="form-control" name="expiry_date" id="expiry_date" value="{{ $cartoon->expiry_date }}">
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
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    
    <script>
        function updateQuantity(e){

            if( e.value == 0 ){
                swal("","Quantity value 0 will works to delete a trolley","warning")
                
                let product_quantity = document.querySelectorAll(".product_quantity")
                let total_quantity = 0;

                for( let i = 0 ; i < product_quantity.length ; i++ ){
                    total_quantity += product_quantity[i].value ? parseFloat(product_quantity[i].value) : 0
                }

                document.getElementById("cartoon-weight").value = ( total_quantity.toFixed(2) < 1 ) ? 1 : total_quantity.toFixed(2)
            }

            if( e.value > 0 ){
                let product_quantity = document.querySelectorAll(".product_quantity")
                let total_quantity = 0;

                for( let i = 0 ; i < product_quantity.length ; i++ ){
                    total_quantity += product_quantity[i].value ? parseFloat(product_quantity[i].value) : 0
                }

                document.getElementById("cartoon-weight").value = ( total_quantity.toFixed(2) < 1 ) ? 1 : total_quantity.toFixed(2)
            }
            
        }
    </script>

    <script>
        function addAndClose(e){
            let stored_codes = JSON.parse(localStorage.getItem("stored_codes")) 
            if( stored_codes && stored_codes.length != 0 ){
                $.ajax({
                    method : "GET",
                    url: "{{ route('add.trolley.cartoon.validate') }}",
                    data: { 
                        codes: stored_codes 
                    },
                    success: function(response){
                        if( response.status != 'success' ){
                            swal('',`${response.data}`,`${response.status}`)
                        }
                        else{
                            $(".quantity-row .quantity-col.new").remove()
                            
                            $.each(response.data, function(key, value){
                                $(".quantity-row").append(`
                                    <div class="col-md-12 quantity-col new">
                                        <div class="row">
                                            <div class="col-md-2 form-group">
                                                <label> <strong>Trolley Code:</strong>${value.trolley.code}</label>
                                                <label> <strong>Blast freezer entry Code:</strong> ${value.code}</label>
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label> <strong>Product:</strong> ${value.product_details.product.name}</label>
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label> <strong>Code:</strong> ${value.product_details.product.code}</label>
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label> <strong>Type:</strong> ${value.product_details.product.type}</label>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label>Quantity (kg)</label>
                                                <input type="number" value="${value.remaining_quantity}" oninput="updateQuantity(this)" max="${value.remaining_quantity}" min="1" step="0.01" name="new_quantity[]" class="form-control product_quantity">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="remove-item"> <i class="fas fa-trash"></i> Delete</button>
                                            </div>
                                        </div>
                                        <input type="hidden" value="${value.code}" name="new_blast_freezer_entries_code[]">
                                    </div>
                                    
                                `);
                            })

                            let product_quantity = document.getElementsByClassName("product_quantity")
                            let cartoon_weight = 0;
                            for( let i = 0 ; i < product_quantity.length ; i++ ){
                                cartoon_weight += parseFloat(product_quantity[i].value)
                            }

                            document.getElementById("cartoon-weight").value = cartoon_weight.toFixed(2)
                            $('#largeModal').modal('toggle');

                        }
                        
                    },
                    error: function(response){

                    },
                })
            }
            else{
                swal("","Please select at least one trolley","warning")
            }
        }
    </script>
    <script>
        $(document).on('click','.remove-item', function(){
            let $this = $(this);
            $this.closest(".quantity-col.new").remove()

            let product_quantity = document.getElementsByClassName("product_quantity")
            let cartoon_weight = 0;
            for( let i = 0 ; i < product_quantity.length ; i++ ){
                cartoon_weight += parseFloat(product_quantity[i].value)
            }
            document.getElementById("cartoon-weight").value = cartoon_weight.toFixed(2)

        })
    </script>

    @endsection