@if($products->isNotEmpty())
<div class="panel__content">
    <div class="row mx-0">
        @foreach($products as $product)
        <div class="col-12 px-1 px-md-2 py-1 product_wrap mb-0 border border-top-0 border-gray shadow-none rounded-0">
            <div class="row mx-md-2 gx-md-2 gx-1 justify-content-center align-items-center">
                <div class="col-xl-2 col-3" >
                    <div class="product-img">
                        <a href="{{route('front.product',$product->slug)}}">
                            @if(!empty($product->images->first()->image))
                                <img src="{{asset('uploads/products/images/thumb/'.$product->images->first()->image)}}" alt="{{$product->title}}">
                            @else
                                <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$product->title}}">

                            @endif                        </a>
                    </div>
                </div>
                <div class="col-xl-10 col-9">
                    <div class="product_info">
                        <div class="product_title">
                            <a href="{{route('front.product',$product->slug)}}">
                                {{$product->title}}
                            </a>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width: 64%"></div>
                            </div>
                            <span class="rating_num">(10)</span>
                        </div>
                        <div class="product_price">
                            <span class="price">${{number_format($product->price,2)}}</span>
                            @if(!empty($product->compare_price && $product->compare_price > $product->price && $product->qty > 0))
                                <del>${{$product->compare_price}}</del>
                                <div class="on_sale">
                                    <span>{{$product->discountPercentage()}}% Off</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="panel__footer text-center">
    <a class="text-primary" href="{{route('front.shop',[$categorySlug,'search' => $query])}}">See all results</a>
</div>
@else
    <div class="panel__content py-2 px-2 row mx-0 bg-white w-100 text-center">
        <div class="text-center">No products found.</div>
    </div>
@endif





