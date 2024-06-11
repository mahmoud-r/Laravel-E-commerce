@extends('front.layouts.app')


@section('title')@endsection

@section('style')@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Wishlist</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Wishlist</li>
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
                <div class="col-12">
                    @if($wishlists->isNotEmpty())
                    <div class="table-responsive wishlist_table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-stock-status">Stock Status</th>
                                <th class="product-add-to-cart"></th>
                                <th class="product-remove">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($wishlists as $wishlist)
                               <tr id="wishlist-{{$wishlist->id}}">
                                <td class="product-thumbnail" >
                                    <a href="{{route('front.product',$wishlist->product->slug)}}">
                                        @if(!empty($wishlist->product->images->first()))
                                            <img src="{{asset('uploads/products/images/thumb/'.$wishlist->product->images->first()->image)}}" alt="{{$wishlist->product->title}}">
                                        @else
                                            <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$wishlist->product->title}}">

                                        @endif
                                    </a>
                                </td>
                                <td class="product-name" >
                                    <a href="{{route('front.product',$wishlist->product->slug)}}">{{$wishlist->product->title}}</a>
                                </td>
                                <td class="product-price" data-title="Price">${{number_format($wishlist->product->price,2)}}
                                    @if(!empty($wishlist->product->compare_price && $wishlist->product->compare_price > $wishlist->product->price && $wishlist->product->qty > 0))
                                        <del>${{$wishlist->product->compare_price}}</del>
                                        <div class="on_sale">
                                            <span>{{$wishlist->product->discountPercentage()}}% Off</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="product-stock-status" data-title="Stock Status">
                                    @if($wishlist->product->qty >= 1)
                                    <span class="badge rounded-pill text-bg-success">In Stock</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-danger">Out of Stock</span>
                                    @endif

                                </td>
                                <td class="product-add-to-cart">
                                    @if($wishlist->product->qty >= 1)
                                        <a href="javascript:void(0)" class="btn btn-fill-out " onclick="addToCartWithQty({{$wishlist->product->id}});">
                                            <i class="icon-basket-loaded"></i>
                                            Add to Cart
                                        </a>

                                    @endif

                                </td>
                                <td class="product-remove" data-title="Remove">
                                    <a href="javascript:void(0)" onclick="removeFromWishlist({{$wishlist->product->id}})" >
                                        <i class="ti-close"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="card text-center">
                        <div class="card-body">
                            <h5 class="mt-5 mb-5">
                                Your Wishlist is empty. Start <a href="{{route('front.shop')}}" class="text-primary">shopping</a> now to add your favorite items!

                            </h5>
                        </div>

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
@endsection
@section('script')
<script>
    function removeFromWishlist(product){
        $.ajax({
            url: '{{route('front.removeFromWishlist')}}',
            type: 'delete',
            data: {product: product},
            dataType: 'json',
            success: function (response) {

                if (response.status == true) {
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })
                    $('.wishlist_count').html(response.wishlistCount)
                    $('#wishlist-'+response.wishlist).fadeOut()
                    if (response.wishlistCount === 0) {
                        location.reload();
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    })


                }
            }
        })

    }
</script>
@endsection


