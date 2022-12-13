<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Inserting a Trolley into the blast freezer.</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form class="ajax-form" method="post" action="{{ route('blast.freezer.entry') }}">
        @csrf

        <div class="row">

            <!-- select group -->
            <div class="col-md-6 col-12 form-group">
                <label>Select Group</label><span class="require-span">*</span>
                <select name="group_id" class="form-control chosen" onchange="groupChange(this)">
                    <option value="" disabled selected>Select group</option>
                    @foreach( $groups as $group )
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- select company -->
            <div class="col-md-6 col-12 form-group select-company">
                <label>Select company</label><span class="require-span">*</span>
                <div class="company-block">
                    <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">
                        <option value="" selected disabled>Select company</option>
                    </select>
                </div>
            </div>

            <!-- select location -->
            <div class="col-md-6 col-12 form-group select-location">
                <label>Select location</label><span class="require-span">*</span>
                <div class="location-block">
                    <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                        <option value="" selected disabled>Select location</option>
                    </select>
                </div>
            </div>

            <!-- select device -->
            <div class="col-md-6 col-12 form-group select-device">
                <label>Select device</label><span class="require-span">*</span>
                <div class="device-block">
                    <select name="device_id" class="form-control device_id chosen">
                        <option value="" selected disabled>Select device</option>
                    </select>
                </div>
            </div>

            <!-- select trolley -->
            <div class="col-md-6 col-12 form-group select-trolley">
                <label>Select trolley</label><span class="require-span">*</span>
                <div class="trolley-block">
                    <select name="trolley_id" class="form-control trolley_id chosen">
                        <option value="" selected disabled>Select trolley</option>
                    </select>
                </div>
            </div>

            <!-- select product details -->
            <div class="col-md-6 col-12 form-group select-product_details">
                <label>Select product details</label><span class="require-span">*</span>
                <div class="product_details-block">
                    <select name="product_details_id" class="form-control product_details_id chosen">
                        <option value="" selected disabled>Select product details</option>
                    </select>
                </div>
            </div>

            <!-- Lead Time -->
            <div class="col-md-6 col-12 form-group">
                <label>Lead Time</label>
                <input type="time" class="form-control" name="lead_time">
            </div>

            <!-- Quantity -->
            <div class="col-md-6 col-12 form-group">
                <label>Quantity</label>
                <input type="number" class="form-control" step="0.01" name="quantity">
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
    function groupChange(e) {
        let group_id = e.value
        $.ajax({
            type: "GET",
            url: "{{ route('group.wise.company') }}",
            data: {
                group_id: group_id,
            },
            success: function(response) {
                if (response.status == "success") {
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
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value) {
                        $(".company_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response) {

            },
        })
    }

    function companyChange(e) {
        let company_id = Array();

        company_id.push(e.value)

        $.ajax({
            type: "GET",
            url: "{{ route('company.wise.location') }}",
            data: {
                company_ids: company_id,
            },
            success: function(response) {
                if (response.status == "success") {
                    $(".location-block").remove();
                    $(".select-location").append(`
                        <div class="location-block">
                            <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
                                <option value="" selected disabled>Select location</option>
                            </select>
                        </div>
                    `);

                    $.each(response.data, function(key, value) {
                        $(".location_id").append(`
                            <option value="${value.id}">${value.name}</option>
                        `);
                    })

                    $(".chosen").chosen();
                }
            },
            error: function(response) {

            },
        })
    }


    function locationChange(e){
        let location_id = Array();

        location_id.push(e.value)

        $.ajax({
            type: "GET",
            url: "{{ route('location.wise.data') }}",
            data: {
                location_ids: location_id,
            },
            success: function(response) {
                if (response.status == "success") {

                    //device
                    $(".device-block").remove();
                    $(".select-device").append(`
                        <div class="device-block">
                            <select name="device_id" class="form-control device_id chosen">
                                <option value="" selected disabled>Select device</option>
                            </select>
                        </div>
                    `);
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
                            <option value="${value.id}">${value.code} ( ${value.name} )</option>
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
                        $(".product_details_id").append(`
                            <option value="${value.id}">${value.product.name}</option>
                        `);

                    })


                    $(".chosen").chosen();
                }
            },
            error: function(response) {

            },
        })
    }
</script>


