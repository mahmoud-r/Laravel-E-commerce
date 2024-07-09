@php
    $Products = \App\Models\Product::InFlashSale()->IsActive()->latest()->get();
@endphp

@if($Products->isNotEmpty())
<section class="section ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h4> {{getPageContent('homeSections')['section2']['title']}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product_slider carousel_slider owl-carousel owl-theme nav_style3" data-loop="true"
                     data-dots="false" data-nav="true" data-margin="30"
                     data-responsive='{"0":{"items": "1"}, "650":{"items": "2"}, "1199":{"items": "2"}}'>
                    @forelse($Products as $product)
                    <div class="item">
                        <div class="deal_wrap">
                            <div class="product_img">
                                <a href="{{route('front.product',$product->slug)}}" title="{{$product->title}}" aria-label="{{$product->title}}">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{asset('uploads/products/images/thumb/'.$product->images->first()->image)}}" alt="{{$product->title}}" title="{{$product->title}}" aria-label="{{$product->title}}" >
                                    @else
                                        <img src="{{asset('front_assets/images/default-300x300.jpg')}}" alt="{{$product->title}}" title="{{$product->title}}" aria-label="{{$product->title}}">
                                    @endif
                                </a>
                            </div>
                            <div class="deal_content">
                                <div class="product_info">
                                    <h6 class="product_title"><a href="{{route('front.product',$product->slug)}}" aria-label="{{$product->title}}" title="{{$product->title}}">{{$product->title}}</a></h6>
                                    <div class="product_price">
                                        <span class="price" aria-label="Product Price" title="{{$product->price}}">{{$product->price}} EGP</span>
                                        @if(!empty($product->compare_price && $product->compare_price > $product->price && $product->qty > 0))
                                            <del>{{$product->compare_price}} EGP</del>
                                            <div class="on_sale">
                                                <span>{{$product->discountPercentage()}}% Off</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="deal_progress">
                                    <span class="stock-sold">Already Sold: <strong>{{$product->flash_sale_qty_solid}}</strong></span>
                                    <span class="stock-available">Available: <strong>{{$product->flash_sale_qty}}</strong></span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             aria-valuenow="{{ ($product->flash_sale_qty + $product->flash_sale_qty_solid) > 0 ? (($product->flash_sale_qty_solid / ($product->flash_sale_qty + $product->flash_sale_qty_solid)) * 100) : 0 }}"
                                             aria-valuemin="0" aria-valuemax="{{ $product->flash_sale_qty + $product->flash_sale_qty_solid }}"
                                             style="width: {{ ($product->flash_sale_qty + $product->flash_sale_qty_solid) > 0 ? (($product->flash_sale_qty_solid / ($product->flash_sale_qty + $product->flash_sale_qty_solid)) * 100) : 0 }}%">
                                            {{ ($product->flash_sale_qty + $product->flash_sale_qty_solid) > 0 ? round(($product->flash_sale_qty_solid / ($product->flash_sale_qty + $product->flash_sale_qty_solid)) * 100) : 0 }}%
                                        </div>

                                    </div>
                                </div>

                                <div class="countdown_time countdown_style4 mb-4"
                                     data-time="{{$product->flash_sale_expiry_date}}"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endif
