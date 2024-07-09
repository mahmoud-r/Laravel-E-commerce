@php
    $section3 = getPageContent('homeSections')['section3'];
@endphp
<section class="section small_pt ">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4>{{$section3['title']}}</h4>
                            </div>
                            <div class="tab-style2">
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#tabmenubar" aria-expanded="false">
                                    <span class="ion-android-menu"></span>
                                </button>
                                <ul class="nav nav-tabs justify-content-center justify-content-md-end"
                                    id="tabmenubar" role="tablist">
                                    @forelse($section3['subsections'] as $key=>$subsections)
                                        @if(!empty($subsections['source_id'] || $subsections['source_type'] == 'top_rated'))
                                         <li class="nav-item">
                                            <a class="nav-link {{$key == 0 ?'active':''}}" id="section3_{{$key}}-tab" data-bs-toggle="tab"
                                               href="#section3_{{$key}}" role="tab" aria-controls="section3_{{$key}}" aria-selected="true"
                                               title="{{$subsections['title']}}" aria-label="{{$subsections['title']}}">
                                                {{$subsections['title']}}
                                            </a>
                                        </li>
                                        @endif
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab_slider">
                            @forelse($section3['subsections'] as $key=>$subsections)
                                @if(!empty($subsections['source_id'] || $subsections['source_type'] == 'top_rated'))
                                   <div class="tab-pane fade  {{$key == 0 ?' show active':''}}" id="section3_{{$key}}" role="tabpanel"
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
    </div>
</section>
