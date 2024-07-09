@extends('admin.master')


@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
        .card-actions {
            margin: -.5rem -.5rem -.5rem auto;
            padding-left: .5rem;
        }
        .card-header{
            align-items: center;
            display: flex;
        }
        .custom-control-input:disabled~.custom-control-label, .custom-control-input[disabled]~.custom-control-label {
             color: black;
        }
    </style>

@endsection

@section('title')Roles - {{$role->name}} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('roles.index')}}">Roles</a></li>
    <li class="breadcrumb-item active">Show</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$role->name}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('roles.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">
        <form name="DiscountForm"  action="" id="RoleForm" method="post">

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" disabled value="{{$role->name}}" name="name" id="name" class="form-control name" placeholder="Name">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="card-title" style="font-size: 1.5rem">
                        Permissions:
                    </h6>


                    <div class="d-flex ml-auto">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input toggleAllPermissions" disabled type="checkbox" id="toggleAllPermissions" >
                            <label for="toggleAllPermissions" class="custom-control-label">All Permissions</label>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3">
                                @foreach($groupedPermissions as $group => $permissions)
                                    <div class="mb-3 col-md-4">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input class="custom-control-input toggleGroupPermissions" type="checkbox"  disabled id="{{ ucfirst($group) }}">
                                            <label for="{{ ucfirst($group) }}" class="custom-control-label"> {{ ucfirst($group) }}</label>
                                        </div>
                                        @foreach($permissions as $permission)
                                            <div class="ml-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input permission-checkbox" disabled {{in_array($permission->id, $rolePermissions) ? 'checked':'' }} type="checkbox" name="permission[]" id="{{ $permission->name }}" value="{{ $permission->name}}">
                                                    <label for="{{ $permission->name }}" class="custom-control-label" >{{ $permission->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>


@endsection







@section('script')

    <script>
        $(document).ready(function() {
            function updateToggleAllPermissions() {
                var allGroupsChecked = $('.toggleGroupPermissions').length === $('.toggleGroupPermissions:checked').length;
                $('#toggleAllPermissions').prop('checked', allGroupsChecked);
            }

            function updateGroupCheckbox(groupDiv) {
                var allChecked = groupDiv.find('.permission-checkbox').length === groupDiv.find('.permission-checkbox:checked').length;
                groupDiv.find('.toggleGroupPermissions').prop('checked', allChecked);
                updateToggleAllPermissions();
            }

            $('#toggleAllPermissions').change(function() {
                var isChecked = $(this).is(':checked');
                $('input.permission-checkbox').prop('checked', isChecked);
                $('.toggleGroupPermissions').prop('checked', isChecked);
            });

            $('.permission-checkbox').change(function() {
                var groupDiv = $(this).closest('.col-md-4');
                updateGroupCheckbox(groupDiv);
            });

            $('.toggleGroupPermissions').change(function() {
                var isChecked = $(this).is(':checked');
                $(this).closest('.col-md-4').find('input.permission-checkbox').prop('checked', isChecked);
                var allGroupsChecked = $('.toggleGroupPermissions').length === $('.toggleGroupPermissions:checked').length;
                $('#toggleAllPermissions').prop('checked', allGroupsChecked);
            });

            $('.col-md-4').each(function() {
                updateGroupCheckbox($(this));
            });
        });
    </script>

@endsection
