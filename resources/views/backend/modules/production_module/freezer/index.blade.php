@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .data-indicator ul {
        padding-left: 15px;
    }

    .data-indicator ul li {
        display: inline;
    }
</style>
@endsection

@section('body-content')

<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">All Freezer</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline table-responsive">
                    <div class="card-header text-right">
                        @if( can('add_freezer') )
                        <button type="button" data-content="{{ route('freezer.add.modal') }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            Add
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped dataTable dtr-inline user-datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th>S.ID</th>
                                    <th>Freezer</th>
                                    <th>Group</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            {{--<tbody>
                                @forelse( $freezers as $key => $freezer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $freezer->name }}</td>
                                    <td>{{ $freezer->group->name }}</td>
                                    <td>{{ $freezer->company->name }}</td>
                                    <td>{{ $freezer->location->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown-{{ $key }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown-{{ $key }}">

                                                @if( can("edit_freezer") )
                                                <a class="dropdown-item" href="#" data-content="{{ route('freezer.edit.modal', encrypt($freezer->id)) }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                                                    <i class="fas fa-edit"></i>
                                                    Edit
                                                </a>
                                                @endif

                                                @if( can("delete_freezer") )
                                                <a class="dropdown-item" href="#" data-content="{{ route('freezer.delete.modal', encrypt($freezer->id)) }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
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
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                {{$freezers->links()}}
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
            ajax: "{{ route('freezer.data') }}",
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
                    data: 'name',
                    name: 'name'
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