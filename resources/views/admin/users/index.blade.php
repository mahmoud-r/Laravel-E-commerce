@extends('admin.master')


@section('style')
    <style>
        .badge {
            font-size: 80%;
            padding: .35em .8em;
            letter-spacing: .04em;
        }
    </style>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('users.index')}}">Users</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('users.create')}}" class="btn btn-primary">New User</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <form action="" method="get">

                <div class="card-header">
                    <div class="card-title">
                        <button type="button" onclick="window.location.href='{{route('users.index')}}'" class="btn btn-default btn-sm">Reset</button>
                    </div>
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="keyword" value="{{Request::get('keyword')}}" class="form-control  float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th> Created Date </th>
                        <th width="100">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @forelse($users as $i=>$user)
                        <tr id="user_{{$user->id}}">
                            <td>{{ $users->firstItem() + $i }}</td>
                            <td> {{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                                @if($user->status == 1)
                                    <span class="badge bg-success text-success-fg">Activated</span>
                                @elseif($user->status == 0)
                                    <span class="badge bg-danger text-danger-fg" >Locked</span>
                                @endif
                            </td>
                            <td>{{\carbon\Carbon::parse($user->created_at)->format('d M,Y')}}</td>
                            <td>
                                <a href="{{route('users.edit',$user->id)}}" >
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                <a href="#" onclick="UserDelete({{$user->id}},'{{$user->name}}')" class="text-danger w-4 h-4 mr-1">
                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center"> Currently, there are no Users yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{$users->links()}}
            </div>
        </div>
    </div>

@endsection







@section('script')
    <script>
        function UserDelete(id,name) {
            Swal.fire({
                title: "Do you want to Delete "+name+"?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{Route("users.destroy","ID")}}';
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
                                $('#user_' + id).remove();
                            }else {
                                console.log('something went wrong')
                            }
                        }

                    });
                }
            });
        }

    </script>
@endsection