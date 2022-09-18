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
        <select name="location_id" class="form-control location_id chosen">
            <option value="" selected disabled>Select location</option>
        </select>
    </div>
</div>