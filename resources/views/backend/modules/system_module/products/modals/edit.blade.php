<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="row data-indicator">
        <ul>
            <li>{{ $product_details->group->name }}</li>
            <li>></li>
            <li>{{ $product_details->company->name }}</li>
            <li>></li>
            <li>{{ $product_details->location->name }}</li>
        </ul>
    </div>

    <form class="ajax-form" method="post" action="{{ route('products.details.edit', encrypt($product_details->id)) }}">
        @csrf

        <div class="row">

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
                    <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">
                        <option value="" selected disabled>Select company</option>
                    </select>
                </div>
            </div>

            <!-- select location -->
            <div class="col-md-12 col-12 form-group select-location">
                <label>Select location</label><span class="require-span">*</span>
                <div class="location-block">
                    <select name="location_id" class="form-control location_id chosen">
                        <option value="" selected disabled>Select location</option>
                    </select>
                </div>
            </div>

            <!-- Manufacture Date -->
            <div class="col-md-6 form-group">
                <label>Manufacture Date</label>
                <input type="date" class="form-control" name="manufacture_date" id="manufacture_date" value="{{ $product_details->manufacture_date }}">
            </div>

            <!-- Expiry Date -->
            <div class="col-md-6 form-group">
                <label>Expiry Date</label>
                <input type="date" readonly class="form-control" name="expiry_date" id="expiry_date" value="{{ $product_details->expiry_date }}">
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
                            <select name="location_id" class="form-control location_id chosen">
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
                            <select name="location_id" class="form-control location_id chosen">
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
</script>

<script>
    $(document).on('change', '#manufacture_date', function() {
        let $this = $(this)
        let type = "{{ $product->type }}"
        let life_time = "{{ $product->life_time }}";
        const manufacture_date = $this.val()
        let split_value = manufacture_date.split("-");

        if (type == "Local") {
            let year = parseInt(split_value[0]) + parseInt(life_time)
            let new_date = year + '-' + split_value[1] + '-' + split_value[2];
            $("#expiry_date").val(new_date);
        } else {
            let year = parseInt(split_value[0]) + parseInt(life_time)
            let new_date = year + '-' + split_value[1] + '-' + split_value[2];
            $("#expiry_date").val(new_date);
        }

    })
</script>