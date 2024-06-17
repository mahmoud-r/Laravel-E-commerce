@include('front.emails.layout.header')

<div class="content">
    <h2>Review Received</h2>
    <p>Hello, {{ $review->user->name }}</p>
    <p>Thank you for writing your review for the product <strong>{{ $review->product->title }}</strong>. Your feedback is important to us.</p>
    <p>Your review has been received and is currently under review by our team. We will notify you once your review has been published.</p>
</div>
<h2>Review Details:</h2>
<table class="table table-vcenter card-table table-bordered">
    <thead>
    <tr>
        <th>Product</th>
        <th>Rating</th>
        <th>Comment</th>
    </tr>
    </thead>

    <tbody>
        <tr>
            <td>
                <div class="d-flex align-items-start gap-2">
                    @if(!empty( $review->product->images->first()->image))
                        <img src="{{asset('uploads/products/images/thumb/'. $review->product->images->first()->image)}}" alt="{{$review->product->title}}" width="60">
                    @else
                        <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$review->product->title}}" width="60">

                    @endif

                    <div>
                        <a class="d-print-none" href="{{route('front.product',$review->product->slug)}}" target="_blank" title="{{$review->product->title}}">
                            {{ $review->product->title }}
                        </a>
                    </div>
                </div>
            </td>
            <td class="text-center">
                <strong>{{ $review->rating }} / 5</strong>
            </td>
            <td class="text-center">
                <span>{{ $review->comment }}</span>
            </td>
        </tr>

    </tbody>
</table>

<div class="content">
    <p>Thank you for choosing {{ get_setting('store_name') }}!</p>
</div>
@include('front.emails.layout.footer')
