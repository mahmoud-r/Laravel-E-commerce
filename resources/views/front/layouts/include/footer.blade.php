<footer class="footer_dark">
    <div class="footer_top small_pt pb_20">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <div class="widget">
                        <div class="footer_logo">
                            <a href="{{url('/')}}" title="{{config('settings.store_name')}}" aria-label="{{config('settings.store_name')}}">

                                @if(!empty(config('settings.store_logo_white')))
                                    <div>
                                        <img src="{{asset('uploads/site/images/'.config('settings.store_logo_white'))}}" alt="{{config('settings.store_logo_white')}}">
                                    </div>
                                @else
                                    <img src="{{asset('/front_assets/images/logo_light.png')}}" alt="{{config('settings.store_name')}}" title="{{config('settings.store_name')}}" aria-label="{{config('settings.store_name')}}">
                                @endif
                            </a>
                        </div>
                        <p class="mb-3">{{config('settings.store_description')}}</p>
                        <div class="widget mb-lg-0">
                            <ul class="social_icons text-center text-lg-start">
                                @include('front.layouts.include.social')
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widget">
                        @php
                        $footerOne = getMenu(2)
                        @endphp
                        <h6 class="widget_title">{{$footerOne['title']}}</h6>
                        <ul class="widget_links">
                            @forelse($footerOne['items'] as $item)
                            <li><a href="{{$item->slug}}" target="{{$item->target}}">@if($item->name == NULL) {{$item->title}} @else {{$item->name}} @endif</a></li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widget">
                        @php
                        $footerOne = getMenu(3)
                        @endphp
                        <h6 class="widget_title">{{$footerOne['title']}}</h6>
                        <ul class="widget_links">
                            @forelse($footerOne['items'] as $item)
                            <li><a href="{{$item->slug}}" target="{{$item->target}}">@if($item->name == NULL) {{$item->title}} @else {{$item->name}} @endif</a></li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="widget">
                        @php
                        $footerOne = getMenu(4)
                        @endphp
                        <h6 class="widget_title">{{$footerOne['title']}}</h6>
                        <ul class="widget_links">
                            @forelse($footerOne['items'] as $item)
                            <li><a href="{{$item->slug}}" target="{{$item->target}}">@if($item->name == NULL) {{$item->title}} @else {{$item->name}} @endif</a></li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="widget">
                        <h6 class="widget_title">Contact Info</h6>
                        <ul class="contact_info">
                            <li>
                                <i class="ti-location-pin"></i>
                                <p>{{config('settings.store_address') }}</p>
                            </li>
                            <li>
                                <i class="ti-email"></i>
                                <a href="mailto:{{config('settings.store_email')}}">{{ config('settings.store_email')}}</a>
                            </li>
                            <li>
                                <i class="ti-mobile"></i>
                                <p>{{config('settings.store_phone')}}</p>
                            </li>
                        </ul>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row d-flex justify-content-between" >
                <div class="col-lg-4">
                    <p class="mb-lg-0 text-center">© 2024 All Rights Reserved by <a href="https://mahmoud-ramadan.com/">Mahmoud Ramadan</a></p>
                </div>
                <div class="col-lg-4">
                    <ul class="footer_payment  text-lg-end">
                        <li><a href="#"><img src="{{asset('front_assets/images/visa.png')}}" alt="visa"></a></li>
                        <li><a href="#"><img src="{{asset('front_assets/images/discover.png')}}" alt="discover"></a></li>
                        <li><a href="#"><img src="{{asset('front_assets/images/master_card.png')}}" alt="master_card"></a></li>
                        <li><a href="#"><img src="{{asset('front_assets/images/paypal.png')}}" alt="paypal"></a></li>
                        <li><a href="#"><img src="{{asset('front_assets/images/amarican_express.png')}}" alt="amarican_express"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
