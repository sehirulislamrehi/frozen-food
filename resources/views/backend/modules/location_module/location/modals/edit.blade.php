<div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">{{ $location->name }}</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
      </button>
 </div>

<div class="modal-body">
    <form class="ajax-form" method="post" action="{{ route('location.update', encrypt($location->id)) }}">
        @csrf

        <div class="row">

            <!-- select Company -->
            <div class="col-md-12 col-12 form-group">
            <label>Select Company</label><span class="require-span">*</span>
                <select name="location_id" class="form-control chosen">
                    @foreach( $companies as $company )
                    <option value="{{ $company->id }}" @if( $location->location_id == $company->id ) selected @endif >{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Location name -->
            <div class="col-md-12 col-12 form-group">
                <label>Location name</label><span class="require-span">*</span>
                <input type="text" class="form-control" name="name" value="{{ $location->name }}">
            </div>

            <!-- Status -->
            <div class="col-md-12 col-12 form-group">
            <label>Status</label><span class="require-span">*</span>
                <select name="is_active" class="form-control chosen">
                    <option value="1" @if( $location->is_active == true ) selected @endif >Active</option>
                    <option value="0" @if( $location->is_active == false ) selected @endif >Inactive</option>
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



