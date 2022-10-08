<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Code : {{ $blast_freezer_entry->code }}. Are you sure you want to delete this item?</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-footer">
    <form class="ajax-form" method="post" action="{{ route('blast.freezer.entry.delete', encrypt($blast_freezer_entry->id)) }}">
        @csrf

        <button type="submit" class="btn btn-danger">
            Yes
        </button>

    </form>
    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
</div>



