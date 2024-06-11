@extends('admin.master')


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('shipping.index')}}">Shipping Zones</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Zones</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('shipping.create')}}" class="btn btn-primary">New Zone</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">


            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>weight to</th>
                        <th >Additional Weight Price</th>
                        <th>Delivery Time</th>
                        <th width="100">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($zones as $i=> $zone)

                        <tr id="zone_{{ $zone->id }}" style="{{$zone->name =='Default' ?'background: beige;':''}}">
                            <td>{{  $i +1 }}</td>
                            <td>{{$zone->name}}</td>
                            <td>${{$zone->price}}</td>
                            <td>{{$zone->weight_to}} KG</td>
                            <td>${{$zone->additional_weight_price}}</td>
                            <td>{{$zone->delivery_time}}</td>
                            <td>
                                <a href="{{route('shipping.edit',$zone->id)}}">
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>
                                <a href="#" onclick="ZoneDelete({{$zone->id}},'{{$zone->name}}')" class="text-danger w-4 h-4 mr-1">
                                    <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center"> Currently, there are no Zones. <a href="{{ route('shipping.create') }}">Add one?</a> </td>
                        </tr>
                    @endforelse



                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection







@section('script')

    <script>
        function ZoneDelete(id,name) {
            Swal.fire({
                title: "Do you want to Delete "+name+"?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{Route("shipping.destroy","ID")}}';
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
                                $('#zone_' + id).remove();
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
