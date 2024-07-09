@extends('front.layouts.app')


@section('title')@endsection

@section('style')
<style>
    .order_complete i{
        padding-inline-end: 10px;
        font-size: 65px;
    }
    .order-customer-info {
        margin: 20px 0;
        padding: 15px 0;
    }
    .order-customer-info .h3, .order-customer-info h3 {
        color: #000;
        font-size: 18px;
        font-weight: 400;
        margin-top: 0;
    }
    .order-customer-info p {
        color: #737373;
        font-size: 14px;
        margin-bottom: 3px;
    }
    .order-customer-info .order-customer-info-meta {
        color: black;
        padding-left: 20px;
    }
    .table tbody tr td {
        vertical-align: middle;
        white-space: normal;
    }
    .checkout-quantity {
        background: #a2a2a2;
        border: 1px solid #a2a2a2;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        color: #fff;
        height: 25px;
        line-height: 22px;
        position: absolute;
        right: -7px;
        text-align: center;
        top: -7px;
        width: 25px;
    }
    .checkout-product-img-wrapper {
        position: relative;
    }
    .cart-item {
        margin-bottom: 10px;
        margin-top: 10px;
    }
    .float-end {
        float: right !important;
    }
    .price-text, .total-text {
        color: #4b4b4b;
        float: right;
        font-weight: 700;
    }
    p {

        margin-bottom: 15px;
    }
    .item-name{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        white-space: normal;
        text-transform: capitalize;
    }
</style>
@endsection

@section('content')
    <div class="section">
        <div class="container">
            <div class="row ">
                <div class=" col-lg-7 col-md-6 col-12">
                    <div class=" order_complete d-flex ">
                        <i class="fas fa-check-circle" ></i>
                            <div class="d-inline-block ">
                                <div class="">
                                    <h3>Your order is completed!</h3>
                                </div>
                                <p>Thank you for purchasing our products!</p>

                            </div>
                        </div>
                    <div class="order-customer-info">
                        <h3>Your information</h3>
                        <p>
                            <span class="d-inline-block">Full name:</span>
                            <span class="order-customer-info-meta">{{$order->address->first_name}} {{$order->address->last_name}}</span>
                        </p>

                        <p>
                            <span class="d-inline-block">Phone:</span>
                            <span class="order-customer-info-meta">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                        </svg>
                                        <span dir="ltr">{{$order->address->phone}}</span>
                            </span>
                        </p>
                        <p>
                        @if(!empty($order->address->second_phone))
                                <span class="d-inline-block">Second Phone:</span>
                                <span class="order-customer-info-meta">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                    </svg>
                                    <span dir="ltr">{{$order->address->second_phone}}</span>
                             </span>
                            @endif
                        </p>
                        @php
                            $payment_method = getPaymentMethod($order->payment_method)
                        @endphp
                        <p>
                            <span class="d-inline-block">Payment method:</span>
                            <span class="order-customer-info-meta">
                                {{$payment_method['payment_'.$order->payment_method.'_name']}}

                            </span>
                        </p>
                        <p>
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
                            <span class="d-inline-block">Payment status:</span>
                            <span class="order-customer-info-meta" style="text-transform: uppercase">
                                <span class="badge {{$payment_class}}">{{$order->payment->status}}</span>
                             </span>
                        </p>

                    </div>
                    @if($order->payment_method == 'bank_transfer' && $payment_method['payment_bank_transfer_display_bank_info'] ==1)
                        @if(1)
                    <div class="alert alert-info mt-3">

                        {{$payment_method['payment_bank_transfer_description']}}
                        <br><span>Bank transfer amount: <strong>{{number_format($order->grand_total,2)}} EGP</strong></span>
                        <br><span>Bank transfer description: <strong>Payment for order {{$order->order_number}} </strong></span>
                    </div>
                    @endif
                    @endif
                    <a href="{{route('home')}}" class="btn btn-fill-out">Continue Shopping</a>
                </div>
                <div class="col-lg-5 col-md-6 d-none d-md-block mt-5 mt-md-0">

                    <div class="pt-3 mb-5">
                        <div class="align-items-center">
                            <h6 class="d-inline-block mb-3" style="font-size: 1rem">Order number: {{$order->order_number}}</h6>
                        </div>

                        <div class="checkout-success-products">
                            <div>
                                @forelse($order->items as $i=>$item)
                                <div class="row cart-item">
                                    <div class="col-lg-3 col-md-3">
                                        <div class="checkout-product-img-wrapper d-inline-block">
                                            @if(!empty($item->product->images->first()->image))
                                            <img class="item-thumb img-thumbnail img-rounded mb-2 mb-md-0" src="{{asset('uploads/products/images/thumb/'.$item->product->images->first()->image)}}" alt="{{$item->name}}">
                                            @else
                                                <img class="item-thumb img-thumbnail img-rounded mb-2 mb-md-0" src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$item->name}}">

                                            @endif
                                            <span class="checkout-quantity">{{$item->qty}}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 " >
                                        <p class="mb-2 mb-md-0 item-name"><a href="{{route('front.product',$item->product->slug)}}">{{$item->name}}</a></p>
                                        <p class="mb-2 mb-md-0">
                                            <small></small>
                                        </p>

                                    </div>
                                    <div class="col-lg-3 col-md-3 col-3 float-md-end text-md-end">
                                        <p>{{number_format($item->total,2)}} EGP</p>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p>Subtotal:</p>
                        </div>
                        <div class="col-6 float-end">
                            <p class="price-text text-end"> {{number_format($order->subtotal,2)}} EGP</p>
                        </div>
                        <div class="col-6">
                            <p>Shipping fee:</p>
                        </div>
                        <div class="col-6 float-end">
                            <p class="price-text text-end"> {{number_format($order->shipping,2)}} EGP </p>
                        </div>
                        @if($order->discount)
                        <div class="col-6">
                            <p>Discount({{$order->coupon_code}}):</p>
                        </div>
                        <div class="col-6 float-end">
                            <p class="price-text text-end"> {{number_format($order->discount,2)}} EGP </p>
                        </div>
                        @endif
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <p>Total:</p>
                        </div>
                        <div class="col-6 float-end">
                            <p class="total-text raw-total-text"> {{number_format($order->grand_total,2)}} EGP</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')@endsection


