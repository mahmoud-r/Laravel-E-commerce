@extends('admin.master')


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('discount.index')}}">Role Management</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Role Management</h1>
                </div>
                <div class="col-sm-6 text-right">
                    @can('role-create')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create New Role</a>
                    @endcan
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card mb-3 table-configuration-wrap" id="filter-card" style="display: none " >
            <div class="card-body" id="searchBuilder" >

            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-title d-flex justify-content-end align-items-center" id="card-title">

                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <div class="card-tools" id="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="myTable" style="width: 100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="50%" class="text-center">Name</th>
                        <th>Created at</th>
                        <th width="250px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $i=> $role)

                        <tr id="role_{{ $role->id }}">
                            <td>{{ $i +1 }}</td>
                            <td class="text-center">{{ $role->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($role->created_at)->format('Y-m-d')}}</td>
                            <td>
                                <a  href="{{ route('roles.show',$role->id) }}">
                                    <svg class="icon" data-bs-toggle="tooltip" data-bs-title="View" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                    </svg>
                                </a>
                                @can('role-edit')
                                    <a href="{{route('roles.edit',$role->id)}}">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                @endcan
                                @can('role-delete')
                                    <a href="#" onclick="RoleDelete({{$role->id}},'{{$role->name}}')" class="text-danger w-4 h-4 mr-1">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @endcan
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center"> Currently, there are no Roles. <a href="{{ route('roles.create') }}">Add one?</a> </td>
                        </tr>
                    @endforelse



                    </tbody>
                </table>
            </div>

    </div>

@endsection







@section('script')

    <script>
        function RoleDelete(id,name) {
            Swal.fire({
                title: "Do you want to Delete "+name+"?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{Route("roles.destroy","ID")}}';
                    var newUrl =url.replace('ID',id)
                    $.ajax({
                        url: newUrl,
                        type: 'DELETE',
                        data: '',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },success: function (response) {

                            if(response['status'] === true){
                                Swal.fire("Deleted!", "", "success");
                                $('#role_' + id).remove();
                            }else {
                                console.log('something went wrong')
                            }
                        }

                    });
                }
            });
        }
        $(document).ready(function() {

            var table = $('#myTable').DataTable({
                rowReorder: true,
                responsive: true,
                autoWidth: false,
                language: {
                    searchBuilder: {
                        add: '+',
                        condition: 'Comparator',
                        clearAll: 'Reset',
                        delete: 'Delete',
                        deleteTitle: 'Delete Title',
                        data: 'Column',
                        left: 'Left',
                        leftTitle: 'Left Title',
                        logicAnd: 'AND',
                        logicOr: 'Or',
                        right: 'Right',
                        rightTitle: 'Right Title',
                        title: {
                            0: 'Filters',
                            _: 'Filters (%d)'
                        },
                        value: 'Option',
                        valueJoiner: 'et'
                    }
                },
                dom: '<"top"Ql>rt<"bottom"ip><"clear">',
                searchBuilder: {
                    columns: [0, 1, 2],
                    preDefined: {
                        criteria: [
                            {
                                condition: 'contains',
                                value: 'Published',
                            },
                        ]
                    },
                }
            });
            // Add filter button next to the search input
            $('#card-tools .input-group ').append('<button id="filter-btn" class="dt-button btn dt-btn ml-2">Filter</button>');

            table.buttons().container().appendTo('#card-tools .input-group');

            $('.dataTables_length').appendTo('#card-title');

            $('.dataTables_filter').appendTo('#card-title');
            $('#myTable_length label').contents().filter(function() {
                return this.nodeType === Node.TEXT_NODE;
            }).remove();

            $('.dataTables_filter label').contents().filter(function() {
                return this.nodeType === Node.TEXT_NODE;
            }).remove();
            $('.dataTables_filter input').attr('placeholder', 'Search...');

            $('.dataTables_filter').addClass('input-group').contents().unwrap();

            // Show filter card on button click
            $('#filter-btn').on('click', function() {
                $('#filter-card').fadeToggle();
            });

            // Initialize SearchBuilder
            table.searchBuilder.container().appendTo('#searchBuilder');

        });

    </script>
@endsection
