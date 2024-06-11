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
    <li class="breadcrumb-item "><a href="{{route('shipments.index')}}">Shipments</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipments</h1>
                </div>
                <div class="col-sm-6 text-right">
                    {{--    <a href="{{Route('orders.create')}}" class="btn btn-primary">New order</a>--}}
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
                        <button type="button" onclick="window.location.href='{{route('shipments.index')}}'" class="btn btn-default btn-sm">Reset</button>
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
                        <th>Shipment Number</th>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>amount</th>
                        <th>Status</th>
                        <th>Date </th>
                        <th width="100">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @forelse($shipments as $i=>$shipment)
                        <tr>
                            <td>{{ $shipments->firstItem() + $i }}</td>
                            <td> <a href="{{route('shipment.view',$shipment->id)}}">{{$shipment->shipment_number}}</a> </td>
                            <td><a href="{{route('order.view',$shipment->order_id)}}">{{$shipment->order->order_number}} <i class="fa fa-external-link-alt"></i></a> </td>
                            <td>{{$shipment->order->address->first_name}} {{$shipment->order->address->last_name}}</td>
                            <td><strong>{{number_format($shipment->price,2)}}</strong></td>
                            <td>
                                @if($shipment->status == 'pending')
                                    <span class="badge bg-warning text-warning-fg bg-secondary">Pending</span>
                                @elseif($shipment->status == 'Approved')
                                    <span class="badge bg-warning text-warning-fg" >Approved</span>
                                @elseif($shipment->status == 'Not_approved')
                                    <span class="badge bg-warning text-warning-fg" >Not approved</span>
                                @elseif($shipment->status == 'Delivering')
                                    <span class="badge bg-info text-info-fg" >Delivering</span>
                                @elseif($shipment->status == 'Delivered')
                                    <span class="badge bg-success text-success-fg" >Delivered</span>
                                @elseif($shipment->status == 'Canceled')
                                    <span class="badge bg-danger text-danger-fg">Canceled</span>
                                @endif
                            </td>
                            <td>{{\carbon\Carbon::parse($shipment->created_at)->format('d M,Y')}}</td>
                            <td>
                                <a href="{{route('shipment.view',$shipment->id)}}" >
                                    <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                </a>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center"> Currently, there are no Orders yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{$shipments->links()}}
            </div>
        </div>
    </div>

@endsection







@section('script')
@endsection
