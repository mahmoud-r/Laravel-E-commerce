@include('front.emails.layout.header')

<div class="content">
    <h2>Thank You for Your Order!</h2>
    <p>Hello, {{ $order->user->name }},</p>
    <p>We are pleased to inform you that your order number <strong>#{{ $order->order_number }}</strong> has been completed successfully.</p>
    <p>We hope you are happy with your purchase. We would love to hear your feedback and appreciate it if you could take a moment to review the products you bought.</p>

    <table class="table table-vcenter card-table table-bordered">
        <thead>
        <tr>
            <th>Product</th>
            <th>#</th>

        </tr>
        </thead>

        <tbody>
        @foreach ($order->items as $item)
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
                <td>
                    <a href="{{ route('front.product',$item->product->slug) }}" class="review-button">Leave a Review</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <p>Thank you for shopping with us!</p>
</div>

@include('front.emails.layout.footer')
