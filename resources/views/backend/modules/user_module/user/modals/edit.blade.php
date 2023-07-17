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

        <div class="col-md-12">
            <ul>
                <li>
                    <strong>Role :</strong>
                </li>
                <span>{{ $user->role->name }}</span>
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
            <div class="col-md-6 col-12 form-group">
                <label>Select Group</label><span class="require-span">*</span>
                <select name="group_id" class="form-control chosen" onchange="groupChange(this)">
                    @include("backend.modules.common.components.select_group",[
                        'group' => $groups
                    ])
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



@include("backend.modules.common.script.group_change",[
    'company_type' => 'multiple',
    'location_type' => 'multiple',
])
@include("backend.modules.common.script.company_change",[
    'location_type' => 'multiple',
])
@include("backend.modules.common.script.location_change",[
    "location_wise_role" => true,
    "location_wise_device" => false    
])