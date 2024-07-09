<div class="product_wrap">
    @if($product->qty <= 0 || $product->status == 0 )

        <span class="pr_flash bg-danger">Out of Stock</span>
    @elseif(!empty($product->compare_price )&& $product->compare_price > $product->price)
        <span class="pr_flash bg-danger">Hot</span>

    @endif

    <div class="product_img">
        <a href="{{route('front.product',$product->slug)}}" title="{{$product->title}}" aria-label="{{$product->title}}">
            @if($product->images->isNotEmpty())
                <img src="{{asset('uploads/products/images/thumb/'.$product->images->first()->image)}}" alt="{{$product->title}}" title="{{$product->title}}" aria-label="{{$product->title}}" >
            @else
                <img src="{{asset('front_assets/images/default-300x300.jpg')}}" alt="{{$product->title}}" title="{{$product->title}}" aria-label="{{$product->title}}">
            @endif

            @if($product->images->count() > 1)
             <img src="{{ asset('uploads/products/images/thumb/' . $product->images[1]->image) }}" class="product_hover_img" alt="{{ $product->title }}" title="{{ $product->title }}" aria-label="{{ $product->title }}">
            @endif

        </a>
    </div>

        <div class="product_info">
            <h6 class="product_title"><a href="{{route('front.product',$product->slug)}}" aria-label="{{$product->title}}" title="{{$product->title}}">{{$product->title}}</a></h6>
            <div class="product_price">
                <span class="price" aria-label="Product Price" title="{{$product->price}} EGP">{{$product->price}} EGP</span>
                @if(!empty($product->compare_price && $product->compare_price > $product->price && $product->qty > 0))
                    <del>{{$product->compare_price}} EGP</del>
                    <div class="on_sale">
                        <span>{{$product->discountPercentage()}}% Off</span>
                    </div>
                @endif
            </div>
            <div class="rating_wrap">
                <div class="rating">
                    <div class="product_rate" style="width:{{$product->average_rating_percentage}}%"></div>
                </div>
                <span class="rating_num">({{$product->rating_count}})</span>
            </div>
            <div class="pr_desc">
                <p>{!! $product->short_description !!}</p>
            </div>
            <div class="list_product_action_box">
                <ul class="list_none pr_action_btn">
                    <li class="add-to-cart"><a href="javascript:void(0)" onclick="addToCart({{$product->id}})" aria-label="add to Cart" title="add to Cart" ><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                    <li><a class="add_compare popup-ajax" href="{{route('front.compare.show',$product->id)}}" aria-label="add to compare" title="add to compare"><i class="icon-shuffle"></i></a></li>
                    <li><a href="{{ route('front.quick-view', ['id' => $product->id]) }}" class="popup-ajax" aria-label="Quick view" title="Quick view"><i class="icon-magnifier-add"></i></a></li>
                    <li><a  href="javascript:void(0)" onclick="addToWishlist({{$product->id}})" aria-label="add To Wishlist" title="add To Wishlist"><i class="icon-heart"></i></a></li>
                </ul>
            </div>
        </div>

</div>
