@extends('admin.master')



@section('title')Governorate @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('governorate.index')}}">Governorate</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Governorate</h1>
                </div>
                @can('locations-create')
                    <div class="col-sm-6 text-right">
                        <a href="{{Route('governorate.create')}}" class="btn btn-primary">New Governorate</a>
                    </div>
                @endcan
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
                        <button type="button" onclick="window.location.href='{{route('governorate.index')}}'" class="btn btn-default btn-sm">Reset</button>
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
                        <th width="60">#</th>
                        <th>Name</th>
                        <th>Name AR</th>
                        <th>Cities</th>
                        <th width="100">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($governorates as $i=> $governorate)

                        <tr id="governorate_{{ $governorate->id }}">
                            <td>{{ $governorates->firstItem() + $i }}</td>
                            <td>{{$governorate->governorate_name_en}}</td>
                            <td>{{$governorate->governorate_name_ar}}</td>
                            <td><a href="{{route('cities.index',$governorate->id)}}" class="btn btn-primary">cities</a></td>
                            <td>
                                @can('locations-edit')
                                <a href="{{route('governorate.edit',$governorate->id)}}">
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                @endcan
                                @can('locations-edit')
                                    <a href="#" onclick="GovernorateDelete({{$governorate->id}},'{{$governorate->governorate_name_en}}')" class="text-danger w-4 h-4 mr-1">
                                        <svg  class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @endcan
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center"> Currently, there are no categories. <a href="{{ route('governorate.create') }}">Add one?</a> </td>
                        </tr>
                    @endforelse



                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{$governorates->links()}}
            </div>
        </div>
    </div>

@endsection







@section('script')

    <script>
        @can('locations-delete')
         function GovernorateDelete(id,name) {
            Swal.fire({
                title: "Do you want to Delete "+name+"?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{Route("governorate.destroy","ID")}}';
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
                                $('#governorate_' + id).remove();
                            }else {
                                console.log('something went wrong')
                            }
                        }

                    });
                }
            });
        }
        @endcan
    </script>
@endsection
