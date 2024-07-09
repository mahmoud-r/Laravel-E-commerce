@php
    $section5 = getPageContent('homeSections')['section5'];
@endphp

<section class="section  ">
    <div class="container">
        <div class="row">
            @forelse($section5['subsections'] as $key=>$subsections)

                @if(!empty($subsections['source_id'] || $subsections['source_type'] == 'top_rated'))

                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="heading_tab_header">
                                <div class="heading_s2">
                                    <h4>{{$subsections['title']}}</h4>
                                </div>
                                <div class="view_all">

                                    @if($subsections['source_type'] == 'category')
                                        @php
                                            $category = \App\Models\Category::select('slug')->find($subsections['source_id']);
                                            $productsURl = route('front.shop',$category->slug);
                                        @endphp
                                    @elseif($subsections['source_type'] == 'collection')
                                        @php
                                            $Collection = \App\Models\ProductCollection::select('slug')->find($subsections['source_id']);
                                           $productsURl = route('front.shop',['collection'=>$Collection->slug]);
                                        @endphp
                                    @elseif($subsections['source_type'] == 'top_rated')
                                        @php
                                            $productsURl = route('front.shop');
                                        @endphp
                                    @endif
                                    <a href={{$productsURl}} class="text_default" aria-label="{{$subsections['title']}}" title="{{$subsections['title']}}"><span>View All</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5"
                                 data-nav="true" data-dots="false" data-loop="true" data-margin="20"
                                 data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>

                                @if($subsections['source_type'] == 'category')
                                    @php
                                        $products = App\Models\Product::where('category_id', $subsections['source_id'])->IsActive()->take(9)->get();
                                    @endphp
                                @elseif($subsections['source_type'] == 'collection')
                                    @php
                                        $products = App\Models\Product::whereHas('collections', function($query) use ($subsections) {
                                            $query->where('product_collection_id', $subsections['source_id']);
                                        })->IsActive()->take(9)->get();
                                    @endphp
                                @elseif($subsections['source_type'] == 'top_rated')
                                    @php
                                        $products = App\Models\Product::wherehas('ratings' ,function($query) {
                                                $query->orderBy('rating', 'desc');
                                            })->IsActive()->take(9)->get();
                                    @endphp
                                @endif

                                    @for($i = 0; $i < $products->count(); $i += 3)
                                        <div class="item">
                                            @foreach($products->slice($i, 3) as $product)
                                                @include('front.product.product_box_left')
                                            @endforeach
                                        </div>
                                    @endfor
                            </div>
                        </div>
                    </div>
                </div>

                @endif

            @empty
            @endforelse

        </div>
    </div>
</section>
