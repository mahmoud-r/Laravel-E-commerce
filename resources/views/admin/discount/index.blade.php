@extends('admin.master')


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('discount.index')}}">Discount Coupons</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection

@section('title')Discount @endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Discount Coupona</h1>
                </div>
                @can('discount-create')
                    <div class="col-sm-6 text-right">
                        <a href="{{Route('discount.create')}}" class="btn btn-primary">New Coupon</a>
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
                        <button type="button" onclick="window.location.href='{{route('discount.index')}}'" class="btn btn-default btn-sm">Reset</button>
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
                        <th>Code</th>
                        <th>Name</th>
                        <th>Discount</th>
                        <th>Starts Date</th>
                        <th>Expires Date</th>
                        <th width="100">Status</th>
                        <th width="100">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($Coupons as $i=> $Coupon)

                            <tr id="copon_{{ $Coupon->id }}">
                                <td>{{ $Coupons->firstItem() + $i }}</td>
                                <td>{{$Coupon->code}}</td>
                                <td>{{$Coupon->name}}</td>
                                @if($Coupon->type == 'percent')
                                    <td>{{$Coupon->discount_amount}}%</td>
                                @else
                                    <td>${{$Coupon->discount_amount}}</td>

                                @endif
                                <td>{{!empty($Coupon->starts_at) ? \Carbon\Carbon::parse($Coupon->starts_at)->format('Y-m-d H:i:s'):''}}</td>
                                <td>{{!empty($Coupon->expires_at) ? \Carbon\Carbon::parse($Coupon->expires_at)->format('Y-m-d H:i:s')  :''}}</td>
                                <td>
                                    @if($Coupon->status == 1 )

                                    <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    @else
                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </td>
                                <td>
                                    @can('discount-edit')
                                    <a href="{{route('discount.edit',$Coupon->id)}}">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    @endcan
                                    @can('discount-delete')
                                        <a href="#" onclick="CategoryDelete({{$Coupon->id}},'{{$Coupon->name}}')" class="text-danger w-4 h-4 mr-1">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    @endcan
                                </td>
                            </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="text-center"> Currently, there are no categories. <a href="{{ route('discount.create') }}">Add one?</a> </td>
                        </tr>
                        @endforelse



                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{$Coupons->links()}}
            </div>
        </div>
    </div>

@endsection







@section('script')

<script>
    @can('discount-delete')
     function CategoryDelete(id,name) {
        Swal.fire({
            title: "Do you want to Delete "+name+"?",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#dc3545",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{Route("discount.destroy","ID")}}';
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
                            $('#copon_' + id).remove();
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
