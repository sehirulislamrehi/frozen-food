
@if( $auth->company_id == null && $auth->location_id == null )


<div class="col-md-12 data-indicator">
    <ul>
        <li>{{ $auth->group->name }}</li>
    </ul>
</div>

<!-- select company -->
<div class="col-md-12 col-12 form-group select-company">
    <label>Select company</label><span class="require-span">*</span>
    <div class="company-block">
        <select name="company_id" class="form-control company_id chosen" onchange="companyChange(this)">
            <option value="" selected disabled>Select company</option>
            @foreach( $companies as $company )
            <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
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

@elseif( $auth->location_id == null )

<div class="col-md-12 data-indicator">
    <ul>
        <li>{{ $auth->group->name }}</li>
        <li>></li>
        <li>{{ $auth->company->name }}</li>
    </ul>
</div>

<!-- select location -->
<div class="col-md-12 col-12 form-group select-location">
    <label>Select location</label><span class="require-span">*</span>
    <div class="location-block">
        <select name="location_id" class="form-control location_id chosen" onchange="locationChange(this)">
            <option value="" selected disabled>Select location</option>
            @foreach( $locations as $location )
            <option value="{{ $location->id }}">{{ $location->name }}</option>
            @endforeach
        </select>
    </div>
</div>

@else

<div class="col-md-12 data-indicator">
    <ul>
        <li>{{ $auth->group->name }}</li>
        <li>></li>
        <li>{{ $auth->company->name }}</li>
        <li>></li>
        <li>{{ $auth->location->name }}</li>
    </ul>
</div>

@endif