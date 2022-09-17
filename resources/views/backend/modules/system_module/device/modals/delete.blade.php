<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Are you sure, you want to delete the device id : {{ $device->device_id }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-footer">
    <form action="{{ route('device.delete', encrypt($device->id)) }}" method="post" class="ajax-form">
        @csrf
        <button type="submit" class="btn btn-danger">Yes</button>
    </form>
    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
</div>