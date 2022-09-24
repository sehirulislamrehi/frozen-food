<!-- select group -->
<div class="col-md-4 col-12 form-group">
    <label>Select Group</label><span class="require-span">*</span>
    <select name="group_id" class="form-control chosen" onchange="groupChange(this)">
        <option value="" disabled selected>Select group</option>
        @foreach( $groups as $group )
        <option value="{{ $group->id }}">{{ $group->name }}</option>
        @endforeach
    </select>
</div>

<!-- select company -->
<div class="col-md-4 col-12 form-group select-company">
    <label>Select company</label><span class="require-span">*</span>
    <div class="company-block">
        <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">
            <option value="" selected disabled>Select company</option>
        </select>
    </div>
</div>

<!-- select location -->
<div class="col-md-4 col-12 form-group select-location">
    <label>Select location</label><span class="require-span">*</span>
    <div class="location-block">
        <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
            <option value="" selected disabled>Select location</option>
        </select>
    </div>
</div>

<!-- Select Freezer/Room -->
<div class="col-md-3 select-freezer">
    <label>Select Freezer/Room</label><span class="require-span">*</span>
    <div class="freezer-block">
        <select name="freezer_id" class="form-control freezer_id" required>
            <option value="" selected disabled>Select freezer/room</option>
        </select>
    </div>
</div>