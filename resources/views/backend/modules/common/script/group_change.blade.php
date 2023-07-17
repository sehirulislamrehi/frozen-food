
<script>
    function groupChange(id = null, e){
        let group_id = 1;
        if(id == null){
            group_id = e.value
        }
        else{
            group_id = id
        }
        let company_type = "{{$company_type}}";
        let location_type = "{{$location_type}}";

        $.ajax({
            type : "GET",
            url : "{{ route('group.wise.company') }}",
            data: {
                group_id : group_id,
            },
            success: function(response){
                if( response.status == "success" ){
                    $(".company-block").remove();

                    if( company_type == "multiple" ){
                        $(".select-company").append(`
                            <div class="company-block">
                                <select name="company_id[]" class="form-control company_id chosen" multiple onchange="companyChange(this)">>
                                    <option value="" selected disabled>Select company</option>
                                </select>
                            </div>
                        `);
                    }
                    else{
                        $(".select-company").append(`
                            <div class="company-block">
                                <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">>
                                    <option value="" selected disabled>Select company</option>
                                </select>
                            </div>
                        `);
                    }

                    $(".location-block").remove();

                    if( location_type == "multiple" ){
                        $(".select-location").append(`
                            <div class="location-block">
                                <select name="location_id[]" class="form-control location_id chosen" multiple onchange="locationChange(this)">
                                    <option value="" selected disabled>Select location</option>
                                </select>
                            </div>
                        `);
                    }
                    else{
                        $(".select-location").append(`
                            <div class="location-block">
                                <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                    <option value="" selected disabled>Select location</option>
                                </select>
                            </div>
                        `);
                    }
                    
                    
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
    groupChange(1,this)
</script>

