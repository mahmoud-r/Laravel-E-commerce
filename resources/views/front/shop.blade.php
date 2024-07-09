@extends('front.layouts.app')

@section('title')
    {{ !empty($categorySelected) ? $categoreis->where('id', $categorySelected)->first()->name : 'Shop' }}
@endsection



@section('og_title')
    {{ !empty($categorySelected) ? $categoreis->where('id', $categorySelected)->first()->name : 'Shop' }}
@endsection

@section('og_image')
    {{ !empty($categorySelected) ? asset('uploads/categories/'.$categoreis->where('id', $categorySelected)->first()->image) : asset('uploads/site/images/'.get_setting('store_logo'))  }}
@endsection

@section('style')
    <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "CollectionPage",
  "mainEntity": {
    "@type": "ItemList",
    "itemListElement": [
      @foreach($products as $product)
            {
              "@type": "Product",
              "name": "{{ $product->title }}",
        "image": "{{ !empty($product->images->first()) ? asset('uploads/products/images/'.$product->images->first()->image) : asset('front_assets/images/empty-img.png') }}",
        "description": "{{ $product->seo_description }}",
        "sku": "{{ $product->sku }}",
        "mpn": "{{ $product->sku }}",
        "brand": {
            "@type": "Thing",
            "name": "{{ $product->brand->name }}"
        },
        "offers": {
            "@type": "Offer",
            "url": "{{ route('front.product', $product->slug) }}",
            "priceCurrency": "EGP",
            "price": "{{ $product->price }}",
            "itemCondition": "http://schema.org/NewCondition",
            "availability": "http://schema.org/{{ $product->qty >0 && $product->status ==1 ? 'InStock' : 'OutOfStock' }}"
        }
      } @if (!$loop->last) , @endif
        @endforeach
        ]
      }
    }
</script>
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
                                    @include('front.product.product_box_top')
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
                    @include('front.shop.Filter')
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

@endsection
@section('script')
<script>
    $('.brand-label, .attribute-label,.collection-label').change(function() {
        apply_filters();
    });

    $('#sort').change(function (){
        apply_filters();

    })
    $('#Showing').change(function (){
        apply_filters();

    })
    function apply_filters(){
        let brands = [];
        let collections = [];
        let attributes = {};
        let price_min = $('#price_first').val();
        let price_max = $('#price_second').val();
        let url= '{{url()->current()}}?'

        $('.brand-label').each(function (){
           if($(this).is(":checked") == true){

            brands.push($(this).val());

           }
        });

        $('.collection-label').each(function (){
           if($(this).is(":checked") == true){

             collections.push($(this).val());

           }
        });

        $('.attribute-label').each(function () {
            if ($(this).is(":checked")) {
                // let attributeId = $(this).attr('name').match(/\d+/)[0];
                let valueId = $(this).val();
                let attributeName = $(this).closest('.widget').find('.widget_title').data('attribute');
                if (!attributes[attributeName]) {
                    attributes[attributeName] = [];
                }
                attributes[attributeName].push(valueId);
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

        //collections Filter
        if (collections.length >0){
            url+='&collection='+collections.toString()
        }

        // Attributes Filter
        if (Object.keys(attributes).length > 0) {
            for (const [attributeName, valueIds] of Object.entries(attributes)) {
                url += `&${attributeName}=${valueIds}`;
            }
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


