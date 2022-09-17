<div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">{{ $device->device_id }}</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
      </button>
 </div>

<div class="modal-body">    

    <div class="row data-indicator">
        <ul>
            <li>{{ $device->group->name }}</li>
            <li>></li>
            <li>{{ $device->company->name }}</li>
            <li>></li>
            <li>{{ $device->location->name }}</li>
        </ul>
    </div>

    <form class="ajax-form" method="post" action="{{ route('device.update', encrypt($device->id)) }}">
        @csrf

        <div class="row">

            @if( auth('super_admin')->check() )
                @include("backend.modules.system_module.device.modals.includes.add.super_admin")
            @else
                @include("backend.modules.system_module.device.modals.includes.add.user")
            @endif

            <!-- Device id -->
            <div class="col-md-12 col-12 form-group">
                <label>Device id</label><span class="require-span">*</span>
                <input type="text" name="device_id" class="form-control" value="{{ $device->device_id }}">                
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
                            <select name="location_id" class="form-control location_id chosen">
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
                            <select name="location_id" class="form-control location_id chosen">
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
</script>


