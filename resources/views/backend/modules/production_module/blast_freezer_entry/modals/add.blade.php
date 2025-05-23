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
                    @include("backend.modules.common.components.select_group",[
                        'group' => $groups
                    ])
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


@include("backend.modules.common.script.group_change",[
    'company_type' => 'single',
    'location_type' => 'single',
])
@include("backend.modules.common.script.company_change",[
    'location_type' => 'single',
])

@include("backend.modules.common.script.location_change",[
    "location_type" => 'single',
    "device" => 'single'    
])





