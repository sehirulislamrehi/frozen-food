<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $trolley->code }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="row data-indicator">
        <ul>
            <li>{{ $trolley->group->name }}</li>
            <li>></li>
            <li>{{ $trolley->company->name }}</li>
            <li>></li>
            <li>{{ $trolley->location->name }}</li>
        </ul>
    </div>

    <form class="ajax-form" method="post" action="{{ route('trolley.edit', encrypt($trolley->id)) }}">
        @csrf

        <div class="row">

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

            <!-- Trolley Name -->
            <div class="col-md-12 col-12 form-group">
                <label>Trolley Name</label><span class="require-span">*</span>
                <input type="text" name="name" class="form-control" value="{{ $trolley->name }}">
            </div>

            <!-- Trolley Storage ( Pieces ) -->
            <!-- <div class="col-md-12 col-12 form-group">
                <label>Trolley Storage (kg)</label><span class="require-span">*</span>
                <input type="number" name="storage" class="form-control" value="{{ $trolley->storage }}">
            </div> -->

            <!-- Status -->
            <div class="col-md-12 col-12 form-group">
                <label>Status</label><span class="require-span">*</span>
                <select name="is_active" class="form-control">
                    <option value="1" @if( $trolley->is_active == true ) selected @endif >Active</option>
                    <option value="0" @if( $trolley->is_active == false ) selected @endif >Inactive</option>
                </select>
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