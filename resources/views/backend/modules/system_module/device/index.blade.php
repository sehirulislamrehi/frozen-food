@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .data-indicator ul{
        padding-left: 15px;
    }
    .data-indicator ul li{
        display: inline;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">All Device</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header text-right">
                        @if( can('add_device') )
                        <button type="button" data-content="{{ route('device.add.modal') }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            Add
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped dataTable dtr-inline user-datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.ID</th>
                                    <th>Device number</th>
                                    <th>Device Manual Id</th>
                                    <th>Type</th>
                                    <th>Group</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            {{--<tbody>
                                @forelse( $devices as $key => $device )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $device->device_number }}</td>
                                    <td>{{ $device->device_manual_id }}</td>
                                    <td>{{ $device->type }}</td>
                                    <td>{{ $device->group->name }}</td>
                                    <td>{{ $device->company->name }}</td>
                                    <td>{{ $device->location->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown-{{ $key }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown-{{ $key }}">

                                                @if( can("edit_device") )
                                                <a class="dropdown-item" href="#" data-content="{{ route('device.edit.modal', encrypt($device->id)) }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                @endif

                                                @if( can("delete_device") )
                                                <a class="dropdown-item" href="#" data-content="{{ route('device.delete.modal', encrypt($device->id)) }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                                    <i class="fas fa-trash"></i>
                                                    Delete
                                                </a>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data found</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                {{$devices->links()}}
                            </tfoot>--}}
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('per_page_js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('backend/js/custom-script.min.js') }}"></script>
<script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>

<script src="{{ asset('backend/js/datatable/jquery.validate.js') }}"></script>
<script src="{{ asset('backend/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/js/datatable/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(function() {
        $('.user-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('device.data') }}",
            order: [
                [0, 'Desc']
            ],
            columns: [{ 
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false 
                },
                {
                    data: 'device_number',
                    name: 'device_number'
                },
                {
                    data: 'device_manual_id',
                    name: 'device_manual_id'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'group',
                    name: 'group'
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                },
            ]
        });
    });
</script>
@endsection