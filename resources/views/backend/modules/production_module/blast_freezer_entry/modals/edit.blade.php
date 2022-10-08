<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Code : {{ $blast_freezer_entry->code }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form class="ajax-form" method="post" action="{{ route('blast.freezer.entry.edit', encrypt($blast_freezer_entry->id)) }}">
        @csrf

        <div class="row">

            <!-- Status -->
            <div class="col-md-12 col-12 form-group">
                <label>Status</label><span class="require-span">*</span>
                <select name="status" class="form-control">
                    <option value="In" @if( $blast_freezer_entry->status == "In" ) selected @endif >In</option>
                    <option value="Out" @if( $blast_freezer_entry->status == "Out" ) selected @endif >Out</option>
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



