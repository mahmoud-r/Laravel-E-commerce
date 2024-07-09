@php
    $section4 = getPageContent('homeSections')['section4'];
@endphp
@if(!empty($section4['subsections'][0]['source_id'] || $section4['subsections'][0]['source_type'] == 'top_rated'))

<section class="section small_pt small_pb">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4>{{$section4['title']}}</h4>
                            </div>
                            <div class="view_all">
                                @if($section4['subsections'][0]['source_type'] == 'category')
                                    @php
                                        $category = \App\Models\Category::select('slug')->find($section4['subsections'][0]['source_id']);
                                        $productsURl = route('front.shop',$category->slug);
                                    @endphp
                                @elseif($section4['subsections'][0]['source_type'] == 'collection')
                                    @php
                                        $Collection = \App\Models\ProductCollection::select('slug')->find($section4['subsections'][0]['source_id']);
                                       $productsURl = route('front.shop',['collection'=>$Collection->slug]);
                                    @endphp
                                @elseif($section4['subsections'][0]['source_type'] == 'top_rated')
                                    @php
                                        $productsURl = route('front.shop');
                                    @endphp
                                @endif
                                <a href="{{$productsURl}}" class="text_default" aria-label="{{$section4['title']}}" title="{{$section4['title']}}">
                                    <i class="linearicons-power"></i>
                                    <span>View All</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @forelse($section4['subsections'] as $key=>$subsections)
                            @if(!empty($subsections['source_id'] || $subsections['source_type'] == 'top_rated'))
                                <div class="tab-pane fade  {{$key == 0 ?' show active':''}}" id="section4_{{$key}}" role="tabpanel"
                                     aria-labelledby="arrival-tab">
                                    <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1"
                                         data-loop="true" data-margin="20"
                                         data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                        @if($subsections['source_type'] == 'category')
                                            @php
                                                $products = App\Models\Product::where('category_id', $subsections['source_id'])->IsActive()->get();
                                            @endphp
                                        @elseif($subsections['source_type'] == 'collection')
                                            @php
                                                $products = App\Models\Product::whereHas('collections', function($query) use ($subsections) {
                                                    $query->where('product_collection_id', $subsections['source_id']);
                                                })->IsActive()->get();
                                            @endphp
                                        @elseif($subsections['source_type'] == 'top_rated')
                                            @php
                                                $products = App\Models\Product::wherehas('ratings' ,function($query) {
                                                        $query->orderBy('rating', 'desc');
                                                    })->IsActive()->take(10)->get();
                                            @endphp
                                        @endif

                                        @forelse($products as $product)
                                            <div class="item">
                                                <div class="product_wrap">

                                                    @include('front.product.product_box_top')

                                                </div>
                                            </div>
                                        @empty
                                        @endforelse

                                    </div>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
