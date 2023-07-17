<div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
      </button>
 </div>

<div class="modal-body">
    <form class="ajax-form" method="post" action="{{ route('user.add') }}">
        @csrf

        <div class="row">

            <!-- Staff ID -->
            <div class="col-md-12 col-12 form-group">
                <label>Staff ID</label><span class="require-span">*</span>
                <input type="text" class="form-control" name="staff_id">
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
                        @if( isset($roles) )
                            @foreach( $roles as $role )
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-12 form-group text-right">
                <button type="submit" class="btn btn-outline-dark">
                    Add
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
    $(".show-password").click(function() {
        let $this = $(this)
        $this.closest(".password-box").find("#password-field").attr("type", "text")
        $this.closest(".password-box").find(".show-password").hide()
        $this.closest(".password-box").find(".hide-password").show()
    })

    $(".hide-password").click(function() {
        let $this = $(this)
        $this.closest(".password-box").find("#password-field").attr("type", "password")
        $this.closest(".password-box").find(".show-password").show()
        $this.closest(".password-box").find(".hide-password").hide()
    })
</script>

@include("backend.modules.common.script.group_change",[
    'company_type' => 'multiple',
    'location_type' => 'multiple',
])
@include("backend.modules.common.script.company_change",[
    'location_type' => 'multiple',
])
@include("backend.modules.common.script.location_change",[
    "location_type" => 'multiple',
    "device" => 'single'    
])
