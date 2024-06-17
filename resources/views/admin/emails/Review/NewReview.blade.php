@include('admin.emails.layout.header')

<div class="content">
    <h2>New Product Review Submitted</h2>
    <p>Hello,{{$admin}}</p>
    <p>A new review has been submitted for the product <strong>{{ $review->product->title }}</strong>.</p>
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
    <p>Please review the comment and approve it if it meets our guidelines.</p>
    <a href="{{route('reviews.index',$review->id)}}" class="button">View Review</a>

</div>
@include('admin.emails.layout.footer')
