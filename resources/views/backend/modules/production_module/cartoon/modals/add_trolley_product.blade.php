<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add trolley products into the cartoon</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="border-right: none;">Trolleys into the blast freezer</th>
                        <th style="border-left: none;"> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $blast_freezer_entries as $key => $blast_freezer_entry )
                    <tr>
                        <th scope="row">
                            <input type="checkbox" class="check_to_add_trolley selected_codes" onclick="selectCode(this)" data-code="{{ $blast_freezer_entry->code }}" value="{{ $blast_freezer_entry->code }}">
                        </th>
                        <td style="border-right: none;">
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
                        </td>
                        <td style="border-left: none;">
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
                                {{ $blast_freezer_entry->remaining_quantity }} / {{ $blast_freezer_entry->quantity }} Kg
                            </p>
                            <p>
                                <strong>Status :</strong>
                                {{ $blast_freezer_entry->status }}
                            </p>
                            <p>
                                <strong>Created :</strong>
                                {{ $blast_freezer_entry->created_at->toDayDateTimeString() }}
                            </p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-right">
            <button type="button" onclick="addAndClose(this)" class="btn btn-sm btn-success">
                Add and close
            </button>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
<script>
    localStorage.removeItem("stored_codes")
</script>
<script>
    if( JSON.parse(localStorage.getItem("stored_codes"))  ){
        let selected_codes = document.querySelectorAll(".selected_codes")

        for( let i = 0 ; i < selected_codes.length ; i++ ){
            let blast_freezer_entries_code = selected_codes[i].dataset.code;

            if(JSON.parse(localStorage.getItem("stored_codes")) .indexOf(blast_freezer_entries_code) !== -1 ){
                selected_codes[i].checked = true;
            }
            
        }
    }
</script>

<script>
    function selectCode(e){
        let blast_freezer_entries_code = e.dataset.code;
        let stored_codes = JSON.parse(localStorage.getItem("stored_codes")) 
        let codes_array = Array();

        if( stored_codes ){
            if( e.checked == true ){
                if(stored_codes.indexOf(blast_freezer_entries_code) !== -1 ){
                    //Value exists!
                } 
                else{
                    stored_codes.push(blast_freezer_entries_code)
                    localStorage.setItem("stored_codes",JSON.stringify(stored_codes))
                }
            }
            else{
                let index = stored_codes.indexOf(blast_freezer_entries_code);
                stored_codes.splice(index, 1);
                localStorage.setItem("stored_codes",JSON.stringify(stored_codes))
            }
        }
        else{
            codes_array.push(blast_freezer_entries_code)
            localStorage.setItem("stored_codes",JSON.stringify(codes_array))
        }
    }
</script>