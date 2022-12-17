<div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add New Roles</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
      </button>
 </div>

<div class="modal-body">

    <form class="ajax-form" method="post" action="{{ route('role.add') }}">
        @csrf
        <div class="row">

            <!-- name -->
            <div class="col-md-12 col-12 form-group">
                <label for="name">Role Name</label><span class="require-span">*</span>
                <input type="text" class="form-control" name="name" >
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


            <!-- permission -->
            <div class="col-md-12 form-group main-group mt-3" >
                <div class="row">

                    @foreach( $modules as $module )
                        @foreach( $module->permission as $module_permission )
                            @if($module->key == $module_permission->key )
                            <div class="permission_block" style="padding: 0">
                                <p style="
                                    border-bottom: 1px solid #e0d9d9;
                                    background: #323232;
                                    color: white;
                                    padding: 5px;
                                ">
                                    <label>
                                        <input type="checkbox" class="module_check" name="permission[]"
                                            value="{{ $module_permission->id }}" />
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
                                                    disabled value="{{ $sub_module_permission->id }}" />
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
                    Add
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
                            <select name="company_id[]" class="form-control company_id chosen" onchange="companyChange(this)">>
                                <option value="" selected disabled>Select company</option>
                            </select>
                        </div>
                    `);

                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id[]" class="form-control location_id chosen" multiple>
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
                            <select name="location_id[]" class="form-control location_id chosen" multiple>
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