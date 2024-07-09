
@php
    $sliders = \App\Models\HomeSlider::where(['status'=>'1'])->whereNotNull('image')->orderByRaw('sort = 0, sort')->get();
@endphp
<section class="mt-4 staggered-animation-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
                <div class="banner_section shop_el_slider">
                    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow"
                         data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @forelse($sliders as $key =>$slider)
                             <div class="carousel-item  {{$key == 0 ?'active':''}} background_bg"
                                  data-img-src="{{asset('uploads/home_slider/images/'.$slider->image)}}">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-7 col-10">
                                        <div class="banner_content3 overflow-hidden">
                                            @if(!empty($slider->subtitle))
                                                <p class="mb-3 staggered-animation font-weight-light slider-subtitle"
                                                    data-animation="slideInRight" data-animation-delay="0.5s">
                                                    {{$slider->subtitle}}
                                                </p>
                                            @endif
                                            @if(!empty($slider->title))

                                                <h2 class="staggered-animation" data-animation="slideInRight"
                                                data-animation-delay="1s">
                                                    {{$slider->title}}
                                                 </h2>
                                            @endif

                                             @if(!empty($slider->button_text))
                                            <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase"
                                               href="{{$slider->link}}" data-animation="slideInRight"
                                               data-animation-delay="1.5s">
                                                {{$slider->button_text}}
                                            </a>
                                           @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                        <ol class="carousel-indicators indicators_style3">
                            @forelse($sliders as $key =>$slider)

                            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="{{$key}}" class="{{$key == 0 ?'active':''}}"></li>

                            @empty
                            @endforelse
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
