<div class="ajax_quick_view">
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
            <div class="product-image">
                @if($product->images->isNotEmpty())

                <div class="product_img_box">
                    <img id="product_img" src="{{asset('uploads/products/images/'.$product->images->first()->image)}}" data-zoom-image="{{asset('uploads/products/images/'.$product->images->first()->image)}}" alt="product_img1">
                </div>
                <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                    @foreach($product->images as $key=>$img)

                    <div class="item">
                        <a href="#" class="product_gallery_item {{$key == 0?'active':''}}" data-image="{{asset('uploads/products/images/'.$img->image)}}" data-zoom-image="{{asset('uploads/products/images/'.$img->image)}}">
                            <img src="{{asset('uploads/products/images/'.$img->image)}}" alt="{{$product->title}}">
                        </a>
                    </div>

                    @endforeach

                </div>
                @else
                    <div class="product_img_box">
                        <img id="product_img" src="{{asset('front_assets/images/empty-img.png')}}" data-zoom-image="{{asset('front_assets/images/empty-img.png')}}" alt="product_img1">
                    </div>
                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">

                            <div class="item">
                                <a href="#" class="product_gallery_item active" data-image="{{asset('front_assets/images/empty-img.png')}}" data-zoom-image="{{asset('front_assets/images/empty-img.png')}}">
                                    <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$product->title}}">
                                </a>
                            </div>


                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="pr_detail">
                <div class="product_description">
                    <h4 class="product_title"><a href="#">{{$product->title}}</a></h4>
                    <div class="product_price">
                        <span class="price">{{$product->price}} EGP</span>

                        @if(!empty($product->compare_price && $product->compare_price > $product->price))
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
                    <div class="clearfix"></div>
                    <div class="pr_desc">
                        <p>
                            {!! $product->short_description !!}
                        </p>
                    </div>
                    <div class="product_sort_info">
                        <ul>
                            @if(!empty($product->warranty))
                                <li><i class="linearicons-shield-check"></i> {{$product->warranty}}</li>
                            @endif
                            @if(!empty($product->warranty))
                                <li><i class="linearicons-sync"></i> {{$product->return}}</li>
                            @endif
                            @if($product->cachDelivery ==1 )
                                <li><i class="linearicons-bag-dollar"></i> Cash on Delivery available</li>
                            @endif

                        </ul>
                    </div>
                </div>
                <hr />
                <div class="cart_extra">
                    <div class="cart-product-quantity">
                        <div class="quantity">
                            <input type="button" value="-" class="minus" data-id="{{$product->id}}">
                            <input type="text" name="quantity" value="1" title="Qty" class="qty" size="4">
                            <input type="button" value="+" class="plus" data-id="{{$product->id}}">
                        </div>
                    </div>

                    <div class="cart_btn">
                        <button class="btn btn-fill-out btn-addtocart" onclick="addToCartWithQty({{$product->id}});" type="button"><i class="icon-basket-loaded"></i> Add to cart</button>
                        <a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                        <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                    </div>

                </div>
                <hr />
                <ul class="product-meta">
                    <li>SKU: <a href="#">{{$product->sku}}</a></li>
                    <li>Category: <a href="{{route('front.shop',$product->category->slug)}}">{{$product->category->name}}</a></li>
                </ul>

                <div class="product_share">
                    <span>Share:</span>
                    <ul class="social_icons">
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($product->title) }}" target="_blank"><i class="ion-social-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(Request::fullUrl()) }}&title={{ urlencode($product->title) }}" target="_blank"><i class="ion-social-linkedin"></i></a></li>
                        <li><a href="https://pinterest.com/pin/create/button/?url={{ urlencode(Request::fullUrl()) }}&media={{ urlencode($product->image_url) }}&description={{ urlencode($product->title) }}" target="_blank"><i class="ion-social-pinterest"></i></a></li>
                        <li><a href="https://api.whatsapp.com/send?text={{ urlencode(Request::fullUrl()) }}" target="_blank"><i class="ion-social-whatsapp"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
