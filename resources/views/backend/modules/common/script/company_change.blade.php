<script>
    function companyChange(e){
        
        let company_ids = Array();
        let location_type = "{{$location_type}}";

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
                                <select name="location_id[]" class="form-control location_id chosen" onchange="locationChange(this)">
                                    <option value="" selected disabled>Select location</option>
                                </select>
                            </div>
                        `);
                    }
                    
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
</script>