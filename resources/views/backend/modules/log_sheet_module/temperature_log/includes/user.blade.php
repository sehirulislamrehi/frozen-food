<div class="col-md-12 data-indicator">
    <ul>
        <li>
            <strong>User for :</strong>
        </li>
        <li>{{ $auth->group->name }}</li>
        <li>></li>
        <li>{{ $auth->company_id ? $auth->company->name : "All" }}</li>
        <li>></li>
        <li>{{ $auth->location_id ? $auth->location->name : "All" }}</li>
    </ul>
</div>

<!-- Select Freezer/Room -->
<div class="col-md-3 select-freezer">
    <label>Select Freezer/Room</label><span class="require-span">*</span>
    <div class="freezer-block">
        <select name="freezer_id" class="form-control freezer_id" required>
            <option value="" selected disabled>Select freezer/room</option>
            @foreach( $freezers as $freezer )
            <option value="{{ $freezer->id }}">{{ $freezer->name }}</option>
            @endforeach
        </select>
    </div>
</div>