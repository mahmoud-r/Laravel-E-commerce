@php
    $categories = \App\Models\Category::where(['status' => '1', 'showHome' => '1'])
        ->whereNotNull('image')
        ->where(function($query) {
            $query->whereHas('products', function($q) {
                $q->IsActive();
            })->orWhereHas('subCategories.products', function($q) {
                $q->IsActive();
            });
        })
        ->latest()
        ->get();
    @endphp
<!-- START SECTION CATEGORIES -->
<section class="section small_pb small_pt">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>{{getPageContent('homeSections')['section1']['title']}}</h2>
                </div>
                <p class="text-center leads">
                    {{getPageContent('homeSections')['section1']['description']}}
                </p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="cat_slider cat_style1 mt-4 mt-md-0 carousel_slider owl-carousel owl-theme nav_style5" data-loop="true" data-dots="false" data-autoheight ="true" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "576":{"items": "4"}, "768":{"items": "5"}, "991":{"items": "6"}, "1199":{"items": "7"}}'>
                    @forelse($categories as $category)
                    <div class="item">
                        <div class="categories_box">
                            <a href="{{route('front.shop',$category->slug)}}" aria-label="{{$category->name}}" title="{{$category->name}}" >
                                <img src="{{asset('uploads/category/images/'.$category->image)}}" alt="{{$category->name}}" title="{{$category->name}}"/>
                                <span>{{$category->name}}</span>
                            </a>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END SECTION CATEGORIES -->
