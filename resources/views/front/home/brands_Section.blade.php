@php
    $brands = \App\Models\Brand::where(['status'=>'1'])->whereNotNull('image')->latest()->get();
@endphp
<section class="section pt-0 small_pb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading_tab_header">
                    <div class="heading_s2">
                        <h4>Our Brands</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="client_logo carousel_slider owl-carousel owl-theme nav_style3" data-dots="false"
                     data-nav="true" data-margin="30" data-loop="true" data-autoplay="true" data-autoheight ="true"
                     data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "767":{"items": "4"}, "991":{"items": "5"}, "1199":{"items": "6"}}'>

                    @forelse($brands as $brand)
                        <div class="item">
                            <div class="cl_logo">
                                <a href="{{route('front.shop',['brand'=>$brand->slug])}}">
                                 <img src="{{asset('uploads/brands/images/'.$brand->image)}}" alt="{{$brand->name}}"/>
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
<style>
    .cl_logo img {
        width: 100%;
        height: auto;
        max-height: 100px;
        object-fit: contain;
    }

    .cl_logo {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
    }
</style>
