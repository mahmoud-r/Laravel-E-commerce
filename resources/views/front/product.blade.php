@extends('front.layouts.app')


@section('title')@endsection

@section('style')
<style>
    .page-title-mini .page-title h1{
        font-size: 20px;
    }



</style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{$product->title}}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.shop')}}">Shop</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.shop',$product->category->slug)}}">{{$product->category->name}}</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('front.shop',[$product->category->slug,$product->subCategory->slug])}}">{{$product->subCategory->name}}</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="product-image vertical_gallery">
                        <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-vertical="true" data-vertical-swiping="true" data-slides-to-show="5" data-slides-to-scroll="1" data-infinite="false">

                            @if($product->images->isNotEmpty())

                                @foreach($product->images as $key=>$img)

                                    <div class="item">
                                        <a href="#" class="product_gallery_item  {{$key == 0?'active':''}}" data-image="{{asset('uploads/products/images/'.$img->image)}}" data-zoom-image="{{asset('uploads/products/images/'.$img->image)}}">
                                            <img src="{{asset('uploads/products/images/'.$img->image)}}" alt="{{$product->title}}" />
                                        </a>
                                    </div>
                                @endforeach


                        </div>

                        <div class="product_img_box">
                            @if($product->qty <= 0 || $product->status == 0)

                                <span class="pr_flash bg-danger">Out of Stock</span>
                            @endif

                            <img id="product_img" src='{{asset('uploads/products/images/'.$product->images->first()->image)}}' data-zoom-image="{{asset('uploads/products/images/'.$product->images->first()->image)}}" alt="{{$product->title}}" />
                            <a href="#" class="product_img_zoom" title="Zoom">
                                <span class="linearicons-zoom-in"></span>
                            </a>
                        </div>
                        @else
                                <div class="item">
                                    <a href="#" class="product_gallery_item  active" data-image="{{asset('front_assets/images/empty-img.png')}}" data-zoom-image="{{asset('front_assets/images/empty-img.png')}}">
                                        <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$product->title}}" />
                                    </a>
                                </div>

                        </div>
                        <div class="product_img_box">
                            <img id="product_img" src='{{asset('front_assets/images/empty-img.png')}}' data-zoom-image="{{asset('front_assets/images/empty-img.png')}}" alt="{{$product->title}}" />
                            <a href="#" class="product_img_zoom" title="Zoom">
                                <span class="linearicons-zoom-in"></span>
                            </a>
                        </div>

                    @endif


                </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="pr_detail">
                        <div class="product_description">
                            <h4 class="product_title"><a href="#">{{$product->title}}</a></h4>
                            <div class="product_price">
                                <span class="price">{{$product->price}}</span>

                                @if(!empty($product->compare_price )&& $product->compare_price > $product->price)
                                    <del>${{$product->compare_price}}</del>
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
                                    @if($product->qty > 0 && $product->status !=0)

                                    <button class="btn btn-fill-out btn-addtocart" onclick="addToCartWithQty({{$product->id}});" type="button"><i class="icon-basket-loaded"></i> Add to cart</button>
                                    @else
                                        <button  disabled class="btn  btn-addtocart"  type="button"><i class="icon-basket-loaded"></i> out of stock</button>

                                    @endif

{{--                                    <a class="add_compare" href="javascript:void(0)" onclick="addToCompare({{$product->id}})"><i class="icon-shuffle"></i></a>--}}
                                    <a class="add_compare popup-ajax" href="{{route('front.compare.show',$product->id)}}" ><i class="icon-shuffle"></i></a>
                                    <a class="add_wishlist" href="javascript:void(0)" onclick="addToWishlist({{$product->id}})"><i class="icon-heart"></i></a>
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
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
                                <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="large_divider clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-style3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Additional info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Reviews {{$product->rating_count >0 ? '('.$product->rating_count .')':''}}</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab">
                            <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                {!! $product->description !!}
                            </div>
                            <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Capacity</td>
                                        <td>5 Kg</td>
                                    </tr>
                                    <tr>
                                        <td>Color</td>
                                        <td>Black, Brown, Red,</td>
                                    </tr>
                                    <tr>
                                        <td>Water Resistant</td>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <td>Material</td>
                                        <td>Artificial Leather</td>
                                    </tr>
                                </table>
                            </div>
                            @include('front.product.reviews_tab')
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="small_divider"></div>
                    <div class="divider"></div>
                    <div class="medium_divider"></div>
                </div>
            </div>

        @if(!empty($relatedProducts))
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h3>Related Products</h3>
                    </div>
                    <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                        @foreach($relatedProducts as $relatedProduct)

                            <div class="item">
                                <div class="product">
                                    @if($relatedProduct->qty <= 0 || $relatedProduct->status == 0)

                                        <span class="pr_flash bg-danger">Out of Stock</span>
                                    @elseif(!empty($relatedProduct->compare_price )&& $relatedProduct->compare_price > $relatedProduct->price)
                                        <span class="pr_flash bg-danger">Hot</span>

                                    @endif
                                    <div class="product_img">
                                        <a href="{{route('front.product',$relatedProduct->slug)}}">
                                            @if(!empty($relatedProduct->images->first()->image))
                                                <img src="{{asset('uploads/products/images/thumb/'.$relatedProduct->images->first()->image)}}" alt="{{$relatedProduct->title}}">
                                            @else
                                                <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$relatedProduct->title}}">

                                            @endif
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="javascript:void(0)" onclick="addToCart({{$relatedProduct->id}})" ><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a class="add_compare popup-ajax" href="{{route('front.compare.show',$relatedProduct->id)}}" ><i class="icon-shuffle"></i></a></li>
                                                <li><a href="{{ route('front.quick-view', ['id' => $relatedProduct->id]) }}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a  href="javascript:void(0)" onclick="addToWishlist({{$relatedProduct->id}})"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="{{route('front.product',$relatedProduct->slug)}}">{{$relatedProduct->title}}</a></h6>
                                        <div class="product_price">
                                            <span class="price">${{$relatedProduct->price}}</span>
                                            @if(!empty($relatedProduct->compare_price && $relatedProduct->compare_price > $relatedProduct->price && $relatedProduct->qty > 0))
                                                <del>${{$relatedProduct->compare_price}}</del>
                                                <div class="on_sale">
                                                    <span>{{$relatedProduct->discountPercentage()}}% Off</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:{{$relatedProduct->average_rating_percentage}}%"></div>
                                            </div>
                                            <span class="rating_num">({{$relatedProduct->rating_count}})</span>
                                        </div>
                                        <div class="pr_desc">
                                            {{$relatedProduct->short_description}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>

        @endif
        </div>
    </div>

@endsection
@section('script')
    <script>

        $('#RatingForm').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();
            $.ajax({
                url:'{{route('front.saveRating',$product->id)}}',
                type : 'post',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status === true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        window.location.href ='{{route('front.reviews')}}';

                    }else if(response.rated_before === true){
                        window.location.reload();
                    }else {
                        handleErrors(response)
                    }

                }
            })
        });

        function handleErrors(response) {
            var errors = response['errors'];
            if (errors['rating']) {
                $('#error-rating').addClass('invalid-feedback').html(errors['rating']);
            } else {
                $('#error-rating').removeClass('invalid-feedback').html('');
            }
            if (errors['comment']) {
                $('#error-comment').addClass('invalid-feedback').html(errors['comment']);
            } else {
                $('#error-comment').removeClass('invalid-feedback').html('');
            }
        }


    </script>
@endsection


