@include('front.emails.layout.header')

<div class="content">
    <h1>Order Accepted</h1>
    <p>Hi {{ $order->user->name }},</p>
    <p>Your order with order number <strong>#{{ $order->order_number }}</strong> has been accepted and is now being prepared.</p>

    <table class="table table-vcenter card-table table-bordered">
        <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>

        <tbody>
        @forelse($order->items as $item)

            <tr>

                <td>
                    <div class="d-flex align-items-start gap-2">
                        @if(!empty($item->product->images->first()->image))
                            <img src="{{asset('uploads/products/images/thumb/'.$item->product->images->first()->image)}}" alt="{{$item->name}}" width="60">
                        @else
                            <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$item->name}}" width="60">

                        @endif

                        <div>
                            <a class="d-print-none" href="{{route('front.product',$item->product->slug)}}" target="_blank" title="{{$item->name}}">
                                {{$item->name}}
                            </a>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <strong>{{$item->qty}}</strong>
                    <span>×</span>
                    <strong>${{number_format($item->price,2)}}</strong>
                </td>
                <td class="text-center">
                    <span>${{number_format($item->total,2)}}</span>
                </td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>
    <table class="table table-vcenter card-table table-borderless text-center">
        <tbody>
        <tr>
            <hr class="my-0">
        </tr>
        <tr>
            <th >Sub amount</th>
            <td> ${{number_format($order->subtotal,2)}}</td>
        </tr>
        @if($order->discount)
            <tr>
                <th>Discount {{$order->coupon_code ?'('.$order->coupon_code.')' :''}}</th>
                <td>${{number_format($order->discount,2)}}</td>
            </tr>
        @endif
        <tr>
            <th>
                Shipping fee
            </th>
            <td>

                <span class="">${{number_format($order->shipping,2)}}</span>

            </td>
        </tr>
        <tr>
            <th>Total amount</th>
            <td>
                <span class="">${{number_format($order->grand_total,2)}}</span>
            </td>
        </tr>
        <tr>
            <th>Payment method</th>
            <td>
                {{\App\Models\PaymentMethod::getSettings($order->payment_method)['payment_'.$order->payment_method.'_name']}}

            </td>
        </tr>
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
        <tr>
            <th>Payment status</th>
            <td>
                <span class="badge {{$payment_class}}">{{$order->payment->status}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <hr class="my-0">
            </td>
        </tr>
        </tbody>
    </table>
    <h2>Shipping Information</h2>
    <p>
        {{ $order->address->first_name }} {{ $order->address->last_name }}<br>
        {{ $order->address->street }}, Building {{ $order->address->building }}<br>
        {{ $order->address->district ? $order->address->district . ', ' : '' }}{{ $order->address->city->name }}, {{ $order->address->governorate->name }}<br>
        {{ $order->address->phone }}{{ $order->address->second_phone ? ', ' . $order->address->second_phone : '' }}
    </p>

    <a href="{{route('front.showOrder',$order->getRouteKey())}}" class="button">View Order</a>

    <p>Thank you for shopping with us!</p>
</div>

@include('front.emails.layout.footer')
