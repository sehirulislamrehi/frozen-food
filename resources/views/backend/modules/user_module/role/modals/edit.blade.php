<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Role : {{ $role->name }}</h5>
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
                @foreach( $role->role_location->where("type","Group") as $group )
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
                @foreach( $role->role_location->where("type","Company") as $company )
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
                @foreach( $role->role_location->where("type","Location") as $location )
                <li>
                    {{ $location->location->name }},
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <form class="ajax-form" method="post" action="{{ route('role.update', $role->id) }}">
        @csrf
        <div class="row">

            <!-- name -->
            <div class="col-md-12 col-12 form-group">
                <label for="name">Role Name</label><span class="require-span">*</span>
                <input type="text" class="form-control" name="name" value="{{ $role->name }}">
            </div>

            <!-- select group -->
            <div class="col-md-12 col-12 form-group">
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
                    <select name="company_id[]" class="form-control company_id chosen" onchange="companyChange(this)">
                        <option value="" selected disabled>Select company</option>
                    </select>
                </div>
            </div>

            <!-- select location -->
            <div class="col-md-12 col-12 form-group select-location">
                <label>Select location</label><span class="require-span">*</span>
                <div class="location-block">
                    <select name="location_id[]" class="form-control location_id chosen" multiple>
                        <option value="" selected disabled>Select location</option>
                    </select>
                </div>
            </div>


            <!-- status -->
            <div class="col-md-12 col-12 form-group" >
                <label>Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" @if( $role->is_active == true ) selected @endif >Active</option>
                    <option value="0" @if( $role->is_active == false ) selected @endif >Inactive</option>
                </select>
            </div>

            <!-- permission -->
            <div class="col-md-12 form-group main-group">
                <div class="row">

                    @foreach( $modules as $index => $module )
                    @foreach( $module->permission as $index_2 => $module_permission )
                        @if($module->key == $module_permission->key )
                        <div class="permission_block" style="padding: 0;">
                            <p style="
                                    border-bottom: 1px solid #e0d9d9;
                                    background: #323232;
                                    color: white;
                                    padding: 5px;
                                ">
                                <label>
                                    <input type="checkbox" class="module_check" name="permission[]"
                                        value="{{ $module_permission->id }}"
                                         
                                        @php $i=0; @endphp 
                                        @foreach($role->permission as $role_permission)
                                            @if( $role_permission->id == $module_permission->id )
                                                {{ $i++ }}
                                            @endif
                                        @endforeach

                                        @if( $i != 0 )
                                            checked
                                        @endif
                                    >
                                    <span>{{ $module->name }}</span>
                                </label>
                            </p>
                            <div class="sub_module_block">
                                <ul>
                                    @foreach( $module->permission as $sub_module_permission )
                                    @if( $sub_module_permission->key != $module->key )
                                    <p>
                                        <label>
                                            <input type="checkbox" class="sub_module_check" name="permission[]"
                                                value="{{ $sub_module_permission->id }}"
                                                 
                                                @php 
                                                    $j=0; 
                                                @endphp 
                                                
                                                @foreach( $role->permission as $role_permission )
                                                    @if( $role_permission->id == $sub_module_permission->id )
                                                        {{ $j++ }}
                                                    @endif
                                                @endforeach

                                                @if( $i == 0 )
                                                    disabled
                                                @endif
                                                @if( $j > 0 )
                                                    checked
                                                @endif
                                                
                                            />
                                            <span>{{ $sub_module_permission->display_name }}</span>
                                        </label>
                                    </p>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @endforeach
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




<script>
    $(".module_check").click(function (e) {
        let $this = $(this);
        if (e.target.checked == true) {
            $this.closest(".permission_block").find(".sub_module_block").find(".sub_module_check").removeAttr(
                "disabled")
        } else {
            $this.closest(".permission_block").find(".sub_module_block").find(".sub_module_check").attr(
                "disabled", "disabled")
        }
    })
</script>




<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>

<script>
    $(document).ready(function domReady() {
        $(".chosen").chosen();
    });
</script>

@include("backend.modules.common.script.group_change",[
    'company_type' => 'single',
    'location_type' => 'multiple',
])
@include("backend.modules.common.script.company_change",[
    'location_type' => 'multiple',
])
@include("backend.modules.common.script.location_change",[
    "location_type" => 'single',
    "device" => 'single'    
])