<script>
    function locationChange(e){

        let location_wise_role = "{{$location_wise_role}}";
        let location_wise_device = "{{$location_wise_device}}";

        if( location_wise_role == true ){
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

        if( location_wise_device == true ){
            let location_id = Array();
            location_id.push(e.value)
            $.ajax({
                type : "GET",
                url : "{{ route('location.wise.device') }}",
                data: {
                    location_ids : location_id,
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
        
    }
</script>