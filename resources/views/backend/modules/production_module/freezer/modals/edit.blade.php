<div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit freezer</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
      </button>
 </div>

<div class="modal-body">

    <div class="row data-indicator">
        <ul>
            <li>{{ $freezer->group->name }}</li>
            <li>></li>
            <li>{{ $freezer->company->name }}</li>
            <li>></li>
            <li>{{ $freezer->location->name }}</li>
        </ul>
    </div>
    <div class="row data-indicator">
        <ul>
            <li><strong>Device number :</strong></li>
            @foreach( $freezer->details as $key => $details )
            <li>{{ $details->device->device_number }}, </li>
            @endforeach
        </ul>
    </div>

    <form class="ajax-form" method="post" action="{{ route('freezer.edit', encrypt($freezer->id)) }}">
        @csrf

        <div class="row">

            @if( auth('super_admin')->check() )
                @include("backend.modules.production_module.freezer.modals.includes.edit.super_admin")
            @else
                @include("backend.modules.production_module.freezer.modals.includes.edit.user")
            @endif

            <!-- Name -->
            <div class="col-md-12 col-12 form-group">
                <label>Name</label><span class="require-span">*</span>
                <input type="text" name="name" class="form-control" value="{{ $freezer->name }}">                
            </div>

            <!-- Select Device -->
            <div class="col-md-12 col-12 form-group select-device">
                <label>Select Device</label><span class="require-span">*</span>
                <div class="device-block">
                    <select name="device_ids[]" multiple class="form-control device_id chosen">
                        <option value="" selected disabled>Select device</option>
                        @if(isset($devices))
                            @foreach( $devices as $device )
                            <option value="{{ $device->id }}">{{ $device->device_number }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-12 form-group text-right">
                <button type="submit" class="btn btn-outline-dark">
                    Update
                </button>
            </div>

        </div>
    </form>
</div>
<div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 </div>


<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>

<script>
    $(document).ready(function domReady() {
        $(".chosen").chosen();
    });
</script>



<script>
    function groupChange(e){
        let group_id = e.value
        $.ajax({
            type : "GET",
            url : "{{ route('group.wise.company') }}",
            data: {
                group_id : group_id,
            },
            success: function(response){
                if( response.status == "success" ){
                    $(".company-block").remove();
                    $(".select-company").append(`
                        <div class="company-block">
                            <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">>
                                <option value="" selected disabled>Select company</option>
                            </select>
                        </div>
                    `);

                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);
                    
                    $.each(response.data, function(key, value){
                        $(".company_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response){

            },
        })
    }
    function companyChange(e){
        let company_id = e.value
        $.ajax({
            type : "GET",
            url : "{{ route('company.wise.location') }}",
            data: {
                company_id : company_id,
            },
            success: function(response){
                if( response.status == "success" ){
                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);
                    
                    $.each(response.data, function(key, value){
                        $(".location_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response){

            },
        })
    }

    function locationChange(e){
        let location_id = e.value
        $.ajax({
            type : "GET",
            url : "{{ route('location.wise.device') }}",
            data: {
                location_id : location_id,
            },
            success: function(response){
                if( response.status == "success" ){
                    $(".device-block").remove();
                    $(".select-device").append(`
                        <div class="device-block">
                            <select name="device_ids[]" multiple class="form-control device_id chosen">
                                <option value="" selected disabled>Select device</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value){
                        $(".device_id").append(`
                            <option value="${value.id}">${value.device_number}</option>
                        `);
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response){

            },
        })
    }
</script>