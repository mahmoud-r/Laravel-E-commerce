@extends('front.layouts.app')


@section('title')Shop @endsection

@section('style')

<style>
    .accordion-item{
        border: none !important;
    }
    .accordion-body {
        transition: max-height 0.1s ease-out;
    }
.sub_category_name:before{
    content: ''!important;
}
</style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        @if(!empty($searchQuery))
                            <h1>Search Result For "{{$searchQuery}}"</h1>
                        @else
                            <h1>{{ $categorySelected ? $categoreis->where('id', $categorySelected)->first()->name : 'ALL Categories' }}</h1>

                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.shop')}}">Shop</a></li>
                        @if(!empty($searchQuery))
                            <li class="breadcrumb-item active">Search</li>

                        @else
                            <li class="breadcrumb-item active">{{ $categorySelected ? $categoreis->where('id', $categorySelected)->first()->name : 'ALL Categories' }}</li>

                        @endif
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
                <div class="col-lg-9">
                    <div class="row align-items-center mb-4 pb-1">
                        <div class="col-12">
                            <div class="product_header">
                                <div class="product_header_left">
                                    <div class="custom_select">
                                        <select class="form-control form-control-sm" name="sort" id="sort">
                                            <option value="latest" >Default sorting</option>
                                            <option value="latest" {{$sort == 'latest'? 'selected':''}}>Sort by newness</option>
                                            <option value="price-asc"{{$sort == 'price-asc'? 'selected':''}}>Sort by price: low to high</option>
                                            <option value="price-desc"{{$sort == 'price-desc'? 'selected':''}}>Sort by price: high to low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="product_header_right">
                                    <div class="products_view">
                                        <a href="javascript:;" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                        <a href="javascript:;" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                    </div>
                                    <div class="custom_select">
                                        <select class="form-control form-control-sm" name="Showing" id="Showing">
                                            <option value="">Showing</option>
                                            <option value="9" {{$Showing == 9? 'selected':''}}>9</option>
                                            <option value="12" {{$Showing == 12? 'selected':''}}>12</option>
                                            <option value="18" {{$Showing == 18? 'selected':''}}>18</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row shop_container">
                        @forelse($products as $product)
                            <div class="col-md-4 col-6">
                                <div class="product">
                                    @if($product->qty <= 0 || $product->status == 0 )

                                    <span class="pr_flash bg-danger">Out of Stock</span>
                                    @elseif(!empty($product->compare_price )&& $product->compare_price > $product->price)
                                        <span class="pr_flash bg-danger">Hot</span>

                                    @endif

                                    <div class="product_img">
                                        <a href="#">
                                            @if($product->images->isNotEmpty())
                                                <img src="{{asset('uploads/products/images/thumb/'.$product->images->first()->image)}}" alt="{{$product->title}}">
                                            @else
                                                <img src="{{asset('front_assets/images/default-300x300.jpg')}}" alt="{{$product->title}}">
                                            @endif
                                        </a>


                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="javascript:void(0)" onclick="addToCart({{$product->id}})"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a class="add_compare popup-ajax" href="{{route('front.compare.show',$product->id)}}" ><i class="icon-shuffle"></i></a></li>
                                                <li><a href="{{ route('front.quick-view', ['id' => $product->id]) }}" class="popup-ajax "><i class="icon-magnifier-add"></i></a></li>
                                                <li><a  href="javascript:void(0)" onclick="addToWishlist({{$product->id}})"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="{{route('front.product',$product->slug)}}">{{$product->title}}</a></h6>
                                        <div class="product_price">
                                            <span class="price">${{$product->price}}</span>
                                            @if(!empty($product->compare_price && $product->compare_price > $product->price && $product->qty > 0))
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
                                            <p>{{$product->short_description}}</p>
                                        </div>
                                        <div class="list_product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="javascript:void(0)" onclick="addToCart({{$product->id}})" ><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="{{ route('front.quick-view', ['id' => $product->id]) }}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{$products->withQueryString()->links()}}
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                    <div class="sidebar">
                        <input type="hidden" value="{{$searchQuery}}" id="search-q">
                        <div class="widget accordion" id="accordion">
                            <h5 class="widget_title">Categories</h5>
                            <ul class="widget_categories">
                                @forelse($categoreis as $key=>$category)

                                    <li class="accordion-item">
                                        <div class="accordion-header" data-bs-toggle="collapse" data-bs-target="#collapse-{{$key}}">
                                            <a href="{{route('front.shop',[$category->slug,'search' => $searchQuery])}}" class="{{$categorySelected == $category->id ? 'text-primary':''}}">
                                                <span class="categories_name">{{$category->name}}</span>
                                                <span class="categories_num">({{$category->products->count()}})</span>
                                            </a>
                                        </div>
                                        @if($category->subCategories->isNotEmpty())
                                            <div id="collapse-{{$key}}" class="accordion-collapse collapse {{$categorySelected == $category->id ? 'show':''}}" aria-labelledby="{{$category->name}}" data-bs-parent="#accordionExample" aria-controls="{{$category->name}}">

                                                <div  class="accordion-body ">
                                                    <ul>
                                                        @forelse($category->subCategories as $subCategory)
                                                            <li><a href="{{route('front.shop',[$category->slug,$subCategory->slug,'search' => $searchQuery])}}" class="sub_category_name  {{$subCategorySelected == $subCategory->id ? 'text-primary':''}}"><span class="sub_category_name">{{$subCategory->name}}</span></a></li>
                                                        @empty
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>

                                        @endif
                                    </li>

                                @empty
                                @endforelse
                            </ul>
                        </div>
                        <div class="widget">
                            <h5 class="widget_title">Filter</h5>
                            <div class="filter_price">
                                <div id="price_filter" data-min="{{$minPrice !='' ? $minPrice :0 }}" data-max="{{$maxPrice !='' ? $maxPrice :100000 }}" data-min-value="{{$minPrice !='' ? $minPrice :0 }}" data-max-value="{{$maxPrice !='' ? $maxPrice :100000 }}" data-price-sign="$"></div>
                                <div class="price_range d-grid gap-2 align-items-center">
                                    <span>Price: <span id="flt_price"></span></span>
                                    <button class="btn btn-fill-out  text-uppercase btn-sm mt-2" type="button" onclick="apply_filters()">Filter</button>

                                    <input type="hidden" id="price_first" value="">
                                    <input type="hidden" id="price_second" value="">


                                </div>

                            </div>
                        </div>
                        <div class="widget">
                            <h5 class="widget_title">Brand</h5>
                            <ul class="list_brand">
                                @forelse($brands as $brand)
                                    <li>
                                        <div class="custome-checkbox">
                                            <input {{in_array($brand->id,$brandArray) ?'checked' : '' }} class="form-check-input brand-label" type="checkbox" name="brands[]" id="brand-{{$brand->id}}" value="{{$brand->id}}">
                                            <label class="form-check-label" for="brand-{{$brand->id}}"><span>{{$brand->name}}</span></label>
                                        </div>
                                    </li>
                                @empty
                                @endforelse


                            </ul>
                        </div>
                        <div class="widget">
                            <div class="shop_banner">
                                <div class="banner_img overlay_bg_20">
                                    <img src="{{asset('front_assets/images/sidebar_banner_img.jpg')}}" alt="sidebar_banner_img">
                                </div>
                                <div class="shop_bn_content2 text_white">
                                    <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                    <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                    <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

@endsection
@section('script')
<script>
    $('.brand-label').change(function (){
        apply_filters();
    })
    $('#sort').change(function (){
        apply_filters();

    })
    $('#Showing').change(function (){
        apply_filters();

    })
    function apply_filters(){
        let brands = [];
        let price_min = $('#price_first').val();
        let price_max = $('#price_second').val();
        let url= '{{url()->current()}}?'

        $('.brand-label').each(function (){
           if($(this).is(":checked") == true){

            brands.push($(this).val());

           }
        });

        //Price Range Filter
        if(price_min !=''&& price_max !=''){

            url += '&price_min='+price_min+'&price_max='+price_max
        }

        //Brands Filter
        if (brands.length >0){
            url+='&brand='+brands.toString()
        }
        //sort Filter
        url += '&sort='+$('#sort').val()

        //Showing
        if ($('#Showing').val() != ''){
            url += '&Showing='+$('#Showing').val()
        }
        //search
        if ($('#search-q').val() != ''){
            url += '&search='+$('#search-q').val()
        }

        window.location.href=url
    }
</script>
@endsection


