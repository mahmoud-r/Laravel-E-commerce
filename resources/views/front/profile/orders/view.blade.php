

@extends('front.layouts.app')


@section('title')@endsection

@section('style')
<style>
    .dashboard_content .table tbody tr td {
        vertical-align: middle;
        white-space: normal;
    }
    table tr:last-child td,
    table tr:last-child th {
        border-bottom-color: transparent;
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
                        <li class="breadcrumb-item"><a href="{{route('front.orders')}}">Orders</a></li>
                        <li class="breadcrumb-item active" >#{{$order->id}}</li>
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
                        <div class="customer-order-detail">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="customer-order-detail">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>
                                                    <span class="d-inline-block me-1">Order number: </span>
                                                    <strong>{{$order->order_number}}1</strong>
                                                </p>
                                                <p>
                                                    <span class="d-inline-block me-1">Date: </span>
                                                    <strong>{{\carbon\Carbon::parse($order->created_at)->format('d M,Y')}}</strong>
                                                </p>
                                                <p>
                                                    <span class="d-inline-block me-1">Order status: </span>
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
                                                </p>
                                                @php
                                                    $payment_method = getPaymentMethod($order->payment_method)
                                                @endphp
                                                <p>

                                                    <span class="d-inline-block me-1">Payment method: </span>
                                                    <strong class="text-info">{{$payment_method['payment_'.$order->payment_method.'_name']}}</strong>
                                                </p>
                                                <p>
                                                    <span class="d-inline-block me-1">Payment status: </span>
                                                    @php
                                                        if ($order->payment->status =='pending'){
                                                            $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                                        }elseif ($order->payment->status =='completed'){
                                                            $payment_class = 'bg-success text-success-fg';
                                                        }elseif ($order->payment->status =='failed'){
                                                            $payment_class = 'bg-danger text-danger-fg';
                                                        }else{
                                                            $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                                        }
                                                    @endphp
                                                    <span class="badge {{$payment_class}}">{{$order->payment->status}}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <span class="d-inline-block me-1">Full Name: </span>
                                                    <strong>{{$order->address->first_name}} {{$order->address->last_name}}</strong>
                                                </p>
                                                <p>
                                                    <span class="d-inline-block me-1">Phone: </span>
                                                    <strong>
                                                        {{$order->phone}}
                                                        {{!empty($order->address->second_phone) ? '&'.$order->address->second_phone :''}}
                                                    </strong>
                                                </p>
                                                <p>
                                                    <span class="d-inline-block me-1">Address: </span>
                                                <address>{{$order->address->building}},{{$order->address->street}},</address>
                                                <address>{{$order->address->district}},{{$order->address->city->city_name_en}},{{$order->address->governorate->governorate_name_en}}</address>
                                                <address>{{$order->address->nearest_landmark}}</address>
                                                </p>
                                            </div>
                                        </div>
                                        <br>
                                        <h5 class="mb-3">Products</h5>
                                        <div>
                                            <div class="table-responsive mb-3 table-vcenter card-table table-bordered">
                                                <table class="table table-vcenter card-table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="product-thumbnail">#</th>
                                                        <th class="product-name">Product</th>
                                                        <th class="product-price">Price</th>
                                                        <th class="product-price">Quantity</th>
                                                        <th class="product-subtotal">Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($order->items as $i=>$item)
                                                        <tr>
                                                            <td>{{$i+1}}</td>
                                                            <td>
                                                                <div class="d-flex align-items-start gap-2">
                                                                    @if(!empty($item->product->images->first()->image))
                                                                        <img src="{{asset('uploads/products/images/thumb/'.$item->product->images->first()->image)}}" alt="{{$item->name}}" width="60">
                                                                    @else
                                                                        <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$item->name}}" width="60">

                                                                    @endif
                                                                    <div style="    padding-bottom: 0.5em;">
                                                                        <a class="d-print-none" href="{{route('front.product',$item->product->slug)}}" target="_blank" title="{{$item->name}}">
                                                                            {{$item->name}}
                                                                        </a>
                                                                        <p class="small mb-0">
                                                                            SKU: <strong>{{$item->product->sku}}</strong>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">

                                                                <span>{{number_format($item->price,2)}} EGP</span>
                                                            </td>
                                                            <td class="text-center">{{$item->qty}}</td>
                                                            <td class="text-center">
                                                                <strong>{{number_format($item->total,2)}} EGP</strong>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="border p-3 p-md-4">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="cart_total_label">Subtotal</td>
                                                                    <td class="cart_total_amount cartSubTotal" >{{number_format($order->subtotal,2)}} EGP</td>
                                                                </tr>
                                                                @if($order->discount)
                                                                    <tr>
                                                                        <td>Discount({{$order->coupon_code}})</td>
                                                                        <td class="product-subtotal" id="Discount">{{number_format($order->discount,2)}} EGP</td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td class="cart_total_label">Shipping</td>
                                                                    <td class="cart_total_amount" id="total_shipping">{{number_format($order->shipping,2)}} EGP</td>
                                                                </tr>
                                                                <tr style="    border-color: transparent;">
                                                                    <td class="cart_total_label">Total</td>
                                                                    <td class="cart_total_amount ">
                                                                        <strong class="cartTotal" id="grand_total">{{number_format($order->grand_total,2)}} EGP</strong>
                                                                    </td>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($order->status->status !='cancelled')
                                                <h5 class="mb-3 mt-3">Shipping Information:</h5>
                                                <div class="col-md-12 ">
                                                    <div class="border p-3 p-md-4">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tbody id="OrderSummery">
                                                                <tr>
                                                                    <td class="cart_total_label">Shipping Status:</td>
                                                                    <td class="cart_total_amount cartSubTotal" >
                                                                        @if($order->shipment->status == 'pending')
                                                                            <span class="badge bg-warning text-warning-fg bg-secondary">Pending</span>
                                                                        @elseif($order->shipment->status == 'Approved')
                                                                            <span class="badge bg-warning text-warning-fg" >Approved</span>
                                                                        @elseif($order->shipment->status == 'Not_approved')
                                                                            <span class="badge bg-warning text-warning-fg" >Not approved</span>
                                                                        @elseif($order->shipment->status == 'Delivering')
                                                                            <span class="badge bg-info text-info-fg" >Delivering</span>
                                                                        @elseif($order->shipment->status == 'Delivered')
                                                                            <span class="badge bg-success text-success-fg" >Delivered</span>
                                                                        @elseif($order->shipment->status == 'Canceled')
                                                                            <span class="badge bg-danger text-danger-fg">Canceled</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @if(optional($order->shipment->info)->shipping_company_name)
                                                                    <tr>
                                                                        <td>Shipping Company Name:</td>
                                                                        <td class="product-subtotal" >{{$order->shipment->info->shipping_company_name}}</td>
                                                                    </tr>
                                                                @endif
                                                                @if(optional($order->shipment->info)->tracking_id)
                                                                    <tr>
                                                                        <td>Tracking ID:</td>
                                                                        <td class="product-subtotal" >{{$order->shipment->info->tracking_id}}</td>
                                                                    </tr>
                                                                @endif
                                                                @if(optional($order->shipment->info)->tracking_link)
                                                                    <tr>
                                                                        <td>Tracking Link:</td>
                                                                        <td class="product-subtotal" ><a href="{{$order->shipment->info->tracking_link}}">{{$order->shipment->info->tracking_link}}</a></td>
                                                                    </tr>
                                                                @endif
                                                                @if(optional($order->shipment->info)->note)
                                                                    <tr>
                                                                        <td>Delivery Notes:</td>
                                                                        <td class="product-subtotal" >{{$order->shipment->info->note}}</td>
                                                                    </tr>
                                                                @endif
                                                                @if(optional($order->shipment->info)->estimate_date_shipped)
                                                                    <tr style="    border-color: transparent;">
                                                                        <td>Estimate Date Shipped:</td>
                                                                        <td class="product-subtotal" >{{\carbon\Carbon::parse($order->shipment->info->estimate_date_shipped)->format('d M,Y')}}</td>
                                                                    </tr>
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>


                                        </div>
                                        <br>

                                    </div>
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





