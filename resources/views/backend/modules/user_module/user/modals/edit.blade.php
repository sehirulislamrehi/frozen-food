<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="row data-indicator">
    <div class="col-md-12">
            <ul>
                <li>
                    <strong>Group :</strong>
                </li>
                @foreach( $user->user_location->where("type","Group") as $group )
                <li>
                    {{ $group->location->name }}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12">
            <ul>
                <li>
                    <strong>Company :</strong>
                </li>
                @foreach( $user->user_location->where("type","Company") as $company )
                <li>
                    {{ $company->location->name }},
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12">
            <ul>
                <li>
                    <strong>Location :</strong>
                </li>
                @foreach( $user->user_location->where("type","Location") as $location )
                <li>
                    {{ $location->location->name }},
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <form class="ajax-form" method="post" action="{{ route('user.update', $user->id) }}">
        @csrf

        <div class="row">
            <!-- name -->
            <div class="col-md-6 col-12 form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            </div>

            <!-- email -->
            <div class="col-md-6 col-12 form-group">
                <label for="email">Email</label><span class="require-span">*</span>
                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">
            </div>

            <!-- phone number -->
            <div class="col-md-6 col-12 form-group">
                <label for="phone">Phone</label><span class="require-span">*</span>
                <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}">
            </div>

            <!-- select group -->
            <div class="col-md-12 col-12 form-group">
                <label>Select Group</label><span class="require-span">*</span>
                <select name="group_id" class="form-control chosen" onchange="groupChange(this)">
                    <option value="" disabled selected>Select group</option>
                    @foreach( $groups as $group )
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- select company -->
            <div class="col-md-12 col-12 form-group select-company">
                <label>Select company</label><span class="require-span">*</span>
                <div class="company-block">
                    <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)" multiple>
                        <option value="" selected disabled>Select company</option>
                    </select>
                </div>
            </div>

            <!-- select location -->
            <div class="col-md-12 col-12 form-group select-location">
                <label>Select location</label><span class="require-span">*</span>
                <div class="location-block">
                    <select name="location_id" class="form-control location_id chosen" multiple>
                        <option value="" selected disabled>Select location</option>
                    </select>
                </div>
            </div>

            <!-- select role -->
            <div class="col-md-12 col-12 form-group select-role">
                <label>Please select a user role</label><span class="require-span">*</span>
                <div class="role-block">
                    <select name="role_id" class="form-control role_id chosen">
                        <option value="" selected disabled>Select role</option>
                        @if( isset($users) )
                            @foreach( $users as $user )
                            <option value="{{ $user->id }}" @if( $user->role_id == $user->id ) selected @endif >{{ $user->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            
            <!-- user status -->
            <div class="col-md-12 col-12 form-group">
                <label>User Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" @if( $user->is_active == true ) selected @endif >Active
                    </option>
                    <option value="0" @if( $user->is_active == false ) selected @endif >Inactive
                    </option>
                </select>
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
                            <select name="company_id[]" class="form-control company_id chosen" multiple onchange="companyChange(this)">>
                                <option value="" selected disabled>Select company</option>
                            </select>
                        </div>
                    `);

                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id[]" class="form-control location_id chosen" multiple onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);
                    
                    $.each(response.data, function(key, value){
                        $(".company_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".role-block").remove();
                    $(".select-role").append(`
                        <div class="role-block">
                            <select name="role_id" class="form-control role_id chosen">
                                <option value="" selected disabled>Select role</option>
                            </select>
                        </div>
                    `);

                    $(".chosen").chosen();
                }
            },
            error: function(response){

            },
        })
    }
    function companyChange(e){
        
        let company_ids = Array();
        for( let i = 1 ; i <= e.length ; i++ ){
            if(e[i]){
                if( e[i].selected == true ){
                    company_ids.push(e[i].value)
                }
            }
        }

        $.ajax({
            type : "GET",
            url : "{{ route('company.wise.location') }}",
            data: {
                company_ids : company_ids,
            },
            success: function(response){
                if( response.status == "success" ){
                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id[]" class="form-control location_id chosen" multiple onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);
                    
                    $.each(response.data, function(key, value){
                        $(".location_id").append(`
                            <option value="${value.id}">${value.location_company.name} > ${value.name}</option>
                        `);
                    })

                    $(".role-block").remove();
                    $(".select-role").append(`
                        <div class="role-block">
                            <select name="role_id" class="form-control role_id chosen">
                                <option value="" selected disabled>Select role</option>
                            </select>
                        </div>
                    `);

                    $(".chosen").chosen();
                }
            },
            error: function(response){

            },
        })
    }
    function locationChange(e){

        let location_ids = Array();
        for( let i = 1 ; i <= e.length ; i++ ){
            if(e[i]){
                if( e[i].selected == true ){
                    location_ids.push(e[i].value)
                }
            }
        }

        $.ajax({
            type : "GET",
            url : "{{ route('location.wise.role') }}",
            data: {
                location_ids : location_ids,
            },
            success: function(response){
                if( response.status == "success" ){
                    $(".role-block").remove();
                    $(".select-role").append(`
                        <div class="role-block">
                            <select name="role_id" class="form-control role_id chosen">
                                <option value="" selected disabled>Select role</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value){
                        if( value.role.is_active == true ){
                            $(".role_id").append(`
                                <option value="${value.role.id}">${value.role.name}</option>
                            `);
                        }
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response){

            },
        })
    }
</script>