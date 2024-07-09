

@extends('front.layouts.app')


@section('title')@endsection

@section('style')
    <style>
        .dashboard_content td, .dashboard_content th {
            border: 1px solid #dee2e6 !important;
        }
        .table td, .table th {
            padding: .75rem !important;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .dashboard_content thead td, .dashboard_content thead th {
            border-bottom-width: 2px;
        }

    </style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Orders</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.profile')}}">My Account</a></li>
                        <li class="breadcrumb-item active" >Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                @include('front.profile.menu')

                <div class="col-lg-9 col-md-8">
                    <div class=" dashboard_content">
                        <div class="card">
                            <div class="card-header">
                                <h3>Orders</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if($orders->isNotEmpty())
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Payment</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{$order->order_number}}</td>
                                                    <td>{{\carbon\Carbon::parse($order->created_at)->format('d M,Y')}}</td>
                                                    <td>
                                                        @php
                                                            if ($order->status->status =='pending'){
                                                                $status_class = 'bg-warning text-warning-fg bg-secondary';
                                                            }elseif ($order->status->status =='shipping'){
                                                                $status_class = 'bg-warning text-warning-fg';
                                                            }elseif ($order->status->status =='completed'){
                                                                $status_class = 'bg-success text-success-fg';
                                                            }elseif ($order->status->status =='processing'){
                                                                $status_class = 'bg-warning text-warning-fg bg-secondary';
                                                            }elseif ($order->status->status =='cancelled'){
                                                                $status_class = 'bg-danger text-danger-fg';
                                                            }else{
                                                                $status_class = 'bg-warning text-warning-fg bg-secondary';
                                                            }
                                                        @endphp
                                                      <span class="badge {{$status_class}}">{{$order->status->status}}</span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            if ($order->status->status =='pending'){
                                                                $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                                            }elseif ($order->status->status =='completed'){
                                                                $payment_class = 'bg-success text-success-fg';
                                                            }elseif ($order->status->status =='failed'){
                                                                $payment_class = 'bg-danger text-danger-fg';
                                                            }else{
                                                                $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                                            }
                                                        @endphp
                                                        <span class="badge {{$payment_class}}">{{$order->payment->status}}</span>
                                                    </td>
                                                    <td>{{number_format($order->grand_total,0)}} EGP</td>
                                                    <td><a href="{{route('front.showOrder',$order->getRouteKey())}}" class="btn btn-fill-out btn-sm">View</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else

                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

@endsection
@section('script')@endsection





