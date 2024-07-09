<header class="header_wrap">
{{--        START TOP HEADER--}}
    <div class="top-header d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
{{--                        <div class="lng_dropdown me-2">--}}
{{--                            <select name="countries" class="custome_select">--}}
{{--                                <option value='en' data-image="{{asset('front_assets/images/eng.png')}}" data-title="English">English</option>--}}
{{--                                <option value='fn' data-image="{{asset('front_assets/images/fn.png')}}" data-title="France">France</option>--}}
{{--                                <option value='us' data-image="{{asset('front_assets/images/us.png')}}" data-title="United States">United States</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="me-3">--}}
{{--                            <select name="countries" class="custome_select">--}}
{{--                                <option value='USD' data-title="USD">USD</option>--}}
{{--                                <option value='EUR' data-title="EUR">EUR</option>--}}
{{--                                <option value='GBR' data-title="GBR">GBR</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-email"></i><span>{{ config('settings.store_email')}}</span></li>
                        </ul>
                        <ul class="contact_detail text-center text-lg-start " style="margin-left: 20px">
                            <li><i class="ti-mobile"></i><span>{{config('settings.store_phone')}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-end">
                        <ul class="header_list">
                            <li><a href="{{route('front.compare.index')}}"><i class="ti-control-shuffle"></i><span>Compare</span></a></li>
                            <li>
                                @if(!Auth::check())
                                <a href="{{route('login')}}">
                                    <i class="ti-user"></i>
                                    <span>Login</span>
                                </a>
                                @else
                                    <a href="{{route('front.profile')}}">
                                        <i class="ti-user"></i>
                                        <span style="text-transform: capitalize">{{Auth::user()->name}}</span>
                                    </a>
                                @endif
                            </li>
                            @if(Auth::check())
                            <li>
                            <form action="{{route('logout')}}" method="post" class="" style="margin: 0">

                                        @csrf

                                        <button class="nav-link d-flex align-items-center">
                                            <i class="ti-lock"></i>
                                            Logout
                                        </button>
                            </form>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{--        END TOP HEADER--}}


{{--        START TOP MIDDLE HEADER--}}
    <div class="middle-header dark_skin">
        <div class="container">
            <div class="nav_block">
                <a class="navbar-brand" href="{{route('home')}}">
                    @if(!empty(get_setting('store_logo_white')))
                        <div>
                            <img class="logo_light" src="{{asset('uploads/site/images/'.get_setting('store_logo_white'))}}" alt="{{get_setting('store_name')}}" >
                        </div>
                    @else
                        <img class="logo_light" src="{{asset('/front_assets/images/logo_light.png')}}" alt="{{get_setting('store_name')}}" >
                    @endif
                        @if(!empty(get_setting('store_logo')))
                            <div>
                                <img class="logo_dark" src="{{asset('uploads/site/images/'.get_setting('store_logo'))}}" alt="{{get_setting('store_name')}}">
                            </div>
                        @else
                            <img class="logo_dark" src="{{asset('/front_assets/images/logo_dark.png')}}" alt="{{get_setting('store_name')}}">
                        @endif
                </a>
                @include('front.layouts.header.search')
                <div class="contact_phone contact_support">
                    <i class="linearicons-phone-wave"></i>
                    <span>{{ get_setting('store_phone')}}</span>
                </div>

            </div>
        </div>
    </div>

{{--        END TOP MIDDLE HEADER--}}



{{--        START TOP BOTTOM HEADER AND CATEGORIES LIST--}}

    <div class="bottom_header light_skin bg_dark main_menu_uppercase border-top border-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-3">

                    <div class="categories_wrap">
                        <button type="button"  data-bs-toggle="collapse" data-bs-target="#navCatContent" aria-expanded="false" class="categories_btn " style="">
                            <i class="linearicons-menu"></i><span>All Categories </span>
                        </button>
                        <div id="navCatContent" class="navbar nav collapse {{ Route::currentRouteName() == 'home' ? 'nav_cat' : '' }}">

                            <ul>
                                @if(getCategories()->isNotEmpty())
                                    @foreach(getCategories()->slice(0,10) as $category)

                                        <li class="dropdown dropdown-mega-menu">
                                            <a class="dropdown-item nav-link {{$category->subCategories->isNotEmpty() ? 'dropdown-toggler' : ''}} " href="{{route('front.shop',$category->slug)}}"  {{$category->subCategories->isNotEmpty() ? 'data-bs-toggle="dropdown"' : ''}}>
{{--                                                <i class="flaticon-responsive"></i>--}}
                                                <img src="{{asset('uploads/category/images/thumb/'.$category->image)}}" width="30" alt="{{$category->name}}"/>

                                                <span>{{$category->name}}</span>
                                            </a>
                                            @if($category->subCategories->isNotEmpty())
                                            <div class="dropdown-menu" style="min-width: 0">
                                                <ul class="mega-menu d-lg-flex">
                                                    <li class="mega-menu-col col-lg-12">
                                                        <ul class="d-lg-flex">
                                                            <li class="mega-menu-col col-lg-12">
                                                                <ul>
                                                                    <li class="dropdown-header">
                                                                        <a href="{{route('front.shop',[$category->slug])}}">All {{$category->name}}</a>
                                                                    </li>
                                                                        @foreach($category->subCategories as $subCategory )
                                                                            <li><a class="dropdown-item nav-link nav_item" href="{{route('front.shop',[$category->slug,$subCategory->slug])}}">{{$subCategory->name}}</a></li>
                                                                        @endforeach
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                            @endif
                                        </li>

                                    @endforeach
                                        @if(getCategories()->count() > 10)
                                            <li>
                                                <ul class="more_slide_open">
                                                    @foreach(getCategories()->slice(10) as $category)
                                                        <li class="dropdown dropdown-mega-menu">
                                                            <a class="dropdown-item nav-link {{$category->subCategories->isNotEmpty() ? 'dropdown-toggler' : ''}} " href="{{route('front.shop',$category->slug)}}" {{$category->subCategories->isNotEmpty() ? 'data-bs-toggle="dropdown"' : ''}}>
                                                                {{--                                                <i class="flaticon-responsive"></i>--}}
                                                                <img src="{{asset('uploads/category/images/thumb/'.$category->image)}}" width="30" alt="{{$category->name}}"/>

                                                                <span>{{$category->name}}</span>
                                                            </a>
                                                            @if($category->subCategories->isNotEmpty())
                                                                <div class="dropdown-menu" style="min-width: 0">
                                                                    <ul class="mega-menu d-lg-flex">
                                                                        <li class="mega-menu-col col-lg-12">
                                                                            <ul class="d-lg-flex">
                                                                                <li class="mega-menu-col col-lg-12">
                                                                                    <ul>
                                                                                        <li class="dropdown-header">
                                                                                            <a href="{{route('front.shop',[$category->slug])}}">All {{$category->name}}</a>
                                                                                        </li>
                                                                                        @foreach($category->subCategories as $subCategory )
                                                                                            <li><a class="dropdown-item nav-link nav_item" href="{{route('front.shop',[$category->slug,$subCategory->slug])}}">{{$subCategory->name}}</a></li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </li>

                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif

                                @endif

                            </ul>
                            <div class="more_categories">More Categories</div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-9 col-md-8 col-sm-6 col-9">

                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler side_navbar_toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSidetoggle" aria-expanded="false">
                            <span class="ion-android-menu"></span>
                        </button>

                        <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">

                            <ul class="navbar-nav">

                                @forelse(getMenu(1)['items'] as $nav)
                                    @if(!empty($nav->children))
                                        <li class="dropdown">
                                            <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="{{$nav->slug}}" target="{{$nav->target}}">@if($nav->name == NULL) {{$nav->title}} @else {{$nav->name}} @endif</a>

                                            <div class="dropdown-menu dropdown-reverse">
                                                <ul>
                                                    @forelse($nav->children as $child)
                                                    <li>
                                                        @if(!empty($child->children))
                                                            <a class="dropdown-item menu-link dropdown-toggler"  href="{{$child->slug}}" target="{{$child->target}}">@if($child->name == NULL) {{$child->title}} @else {{$child->name}} @endif</a>

                                                            <div class="dropdown-menu">
                                                                <ul>
                                                                    @forelse($child->children as $childTow)
                                                                        <li><a class="dropdown-item nav-link nav_item" href="{{$childTow->slug}}" target="{{$childTow->target}}">@if($childTow->name == NULL) {{$childTow->title}} @else {{$childTow->name}} @endif</a></li>

                                                                    @empty
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        @else
                                                            <a class="dropdown-item menu-link "  href="{{$child->slug}}" target="{{$child->target}}">@if($child->name == NULL) {{$child->title}} @else {{$child->name}} @endif</a>

                                                        @endif

                                                    </li>
                                                    @empty
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </li>
                                    @else
                                        <li><a class="nav-link nav_item" href="{{$nav->slug}}" target="{{$nav->target}}">@if($nav->name == NULL) {{$nav->title}} @else {{$nav->name}} @endif</a></li>


                                    @endif
                                @empty

                                    <li><a class="nav-link nav_item" href="{{url('/')}}">Home</a></li>
                                @endforelse
                            </ul>



                        </div>
                        <ul class="navbar-nav attr-nav align-items-center">
                            <li>
                                <a href="{{route('front.profile')}}" class="nav-link">
                                    <i class="linearicons-user"></i>
                                </a>

                            </li>
                            <li>
                                <a href="{{route('front.wishlist.index')}}" class="nav-link"><i class="linearicons-heart"></i>
                                    <span class="wishlist_count">{{getWishlistCount()}}</span>
                                </a>
                            </li>
                            <li class="dropdown cart_dropdown">
                                <a class="nav-link cart_trigger" href="#" data-bs-toggle="offcanvas" data-bs-target="#miniCart" >
                                    <i class="linearicons-cart"></i>
                                    <span class="cart_count">{{Cart::instance('default')->count()}}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="pr_search_icon">
                            <a href="javascript:;" class="nav-link pr_search_trigger">
                                <i class="linearicons-magnifier"></i>
                            </a>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </div>

{{--        END TOP BOTTOM HEADER--}}

    <div class="bottom_header bottom_header_sticky light_skin main_menu_uppercase bg_dark fixed-top header_with_topbar d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                    <a class="navbar-brand" href="{{route('home')}}">
                        @if(!empty(get_setting('store_logo_white')))
                            <div>
                                <img class="logo_light" src="{{asset('uploads/site/images/'.get_setting('store_logo_white'))}}" alt="{{get_setting('store_name')}}" >
                            </div>
                        @else
                            <img class="logo_light" src="{{asset('/front_assets/images/logo_light.png')}}" alt="{{get_setting('store_name')}}" >
                        @endif
                        @if(!empty(get_setting('store_logo')))
                            <div>
                                <img class="logo_dark" src="{{asset('uploads/site/images/'.get_setting('store_logo'))}}" alt="{{get_setting('store_name')}}">
                            </div>
                        @else
                            <img class="logo_dark" src="{{asset('/front_assets/images/logo_dark.png')}}" alt="{{get_setting('store_name')}}">
                        @endif
                    </a>

                </div>
                <div class="col-lg-9 col-md-8 col-sm-6 col-9">

                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler side_navbar_toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSidetoggle" aria-expanded="false">
                            <span class="ion-android-menu"></span>
                        </button>

                        <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                            <ul class="navbar-nav">
                                @forelse(getMenu(1)['items'] as $nav)
                                    @if(!empty($nav->children))
                                        <li class="dropdown">
                                            <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="{{$nav->slug}}" target="{{$nav->target}}">@if($nav->name == NULL) {{$nav->title}} @else {{$nav->name}} @endif</a>

                                            <div class="dropdown-menu dropdown-reverse">
                                                <ul>
                                                    @forelse($nav->children as $child)
                                                        <li>
                                                            @if(!empty($child->children))
                                                                <a class="dropdown-item menu-link dropdown-toggler"  href="{{$child->slug}}" target="{{$child->target}}">@if($child->name == NULL) {{$child->title}} @else {{$child->name}} @endif</a>

                                                                <div class="dropdown-menu">
                                                                    <ul>
                                                                        @forelse($child->children as $childTow)
                                                                            <li><a class="dropdown-item nav-link nav_item" href="{{$childTow->slug}}" target="{{$childTow->target}}">@if($childTow->name == NULL) {{$childTow->title}} @else {{$childTow->name}} @endif</a></li>

                                                                        @empty
                                                                        @endforelse
                                                                    </ul>
                                                                </div>
                                                            @else
                                                                <a class="dropdown-item menu-link "  href="{{$child->slug}}" target="{{$child->target}}">@if($child->name == NULL) {{$child->title}} @else {{$child->name}} @endif</a>

                                                            @endif

                                                        </li>
                                                    @empty
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </li>
                                    @else
                                        <li><a class="nav-link nav_item" href="{{$nav->slug}}" target="{{$nav->target}}">@if($nav->name == NULL) {{$nav->title}} @else {{$nav->name}} @endif</a></li>


                                    @endif
                                @empty

                                    <li><a class="nav-link nav_item" href="{{url('/')}}">Home</a></li>
                                @endforelse
                            </ul>
                        </div>
                        <ul class="navbar-nav attr-nav align-items-center">
                            <li>
                                <a href="{{route('front.profile')}}" class="nav-link">
                                    <i class="linearicons-user"></i>
                                </a>

                            </li>
                            <li>
                                <a href="{{route('front.wishlist.index')}}" class="nav-link"><i class="linearicons-heart"></i>
                                    <span class="wishlist_count">{{getWishlistCount()}}</span>
                                </a>
                            </li>
                            <li class="dropdown cart_dropdown">
                                <a class="nav-link cart_trigger" href="#" data-bs-toggle="offcanvas" data-bs-target="#miniCart" >
                                    <i class="linearicons-cart"></i>
                                    <span class="cart_count">{{Cart::instance('default')->count()}}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="pr_search_icon">
                            <a href="javascript:;" class="nav-link pr_search_trigger">
                                <i class="linearicons-magnifier"></i>
                            </a>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</header>
