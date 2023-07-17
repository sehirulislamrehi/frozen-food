<script>
    function locationChange(e){

        let location_type = "{{$location_type}}"
        let device = "{{$device}}"

        let location_ids = Array();
        if( location_type == "multiple" ){
            for( let i = 1 ; i <= e.length ; i++ ){
                if(e[i]){
                    if( e[i].selected == true ){
                        location_ids.push(e[i].value)
                    }
                }
            }
        }
        if( location_type == "single" ){
            location_ids.push(e.value)
        }

        $.ajax({
            type : "GET",
            url : "{{ route('location.wise.data') }}",
            data: {
                location_ids : location_ids,
            },
            success: function(response){
                if( response.status == "success" ){

                    //role
                    $(".role-block").remove();
                    $(".select-role").append(`
                        <div class="role-block">
                            <select name="role_id" class="form-control role_id chosen">
                                <option value="" selected disabled>Select role</option>
                            </select>
                        </div>
                    `);

                    $.each(response.role, function(key, value){
                        if( value.role.is_active == true ){
                            $(".role_id").append(`
                                <option value="${value.role.id}">${value.role.name}</option>
                            `);
                        }
                    })
                    

                    //device
                    $(".device-block").remove();

                    if(device == "single"){
                        $(".select-device").append(`
                            <div class="device-block">
                                <select name="device_id" class="form-control device_id chosen">
                                    <option value="" selected disabled>Select device</option>
                                </select>
                            </div>
                        `);
                    }
                    else{
                        $(".select-device").append(`
                            <div class="device-block">
                                <select name="device_ids[]" multiple class="form-control device_id chosen">
                                    <option value="" selected disabled>Select device</option>
                                </select>
                            </div>
                        `);
                    }
                    
                    $.each(response.device, function(key, value) {
                        $(".device_id").append(`
                            <option value="${value.id}">${value.device_manual_id}</option>
                        `);
                    })

                    //trolley
                    $(".trolley-block").remove();
                    $(".select-trolley").append(`
                        <div class="trolley-block">
                            <select name="trolley_id" class="form-control trolley_id chosen">
                                <option value="" selected disabled>Select trolley</option>
                            </select>
                        </div>
                    `);
                    $.each(response.trolley, function(key, value) {
                        $(".trolley_id").append(`
                            <option value="${value.id}">${value.name} - ${value.code}</option>
                        `);
                    })

                    //product_details
                    $(".product_details-block").remove();
                    $(".select-product_details").append(`
                        <div class="product_details-block">
                            <select name="product_details_id" class="form-control product_details_id chosen">
                                <option value="" selected disabled>Select product details</option>
                            </select>
                        </div>
                    `);
                    $.each(response.product_details, function(key, value) {
                        if(value.product){
                            $(".product_details_id").append(`
                                <option value="${value.id}">${value.product.name}</option>
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