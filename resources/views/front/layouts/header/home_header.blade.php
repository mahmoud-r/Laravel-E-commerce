<header class="header_wrap">

{{--        START TOP HEADER--}}
    <div class="top-header d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="lng_dropdown me-2">
                            <select name="countries" class="custome_select">
                                <option value='en' data-image="{{asset('front_assets/images/eng.png')}}" data-title="English">English</option>
                                <option value='fn' data-image="{{asset('front_assets/images/fn.png')}}" data-title="France">France</option>
                                <option value='us' data-image="{{asset('front_assets/images/us.png')}}" data-title="United States">United States</option>
                            </select>
                        </div>
                        <div class="me-3">
                            <select name="countries" class="custome_select">
                                <option value='USD' data-title="USD">USD</option>
                                <option value='EUR' data-title="EUR">EUR</option>
                                <option value='GBR' data-title="GBR">GBR</option>
                            </select>
                        </div>
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-mobile"></i><span>123-456-7890</span></li>
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
                            <form action="{{route('logout')}}" method="post" class="">

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
                                            <a class="dropdown-item nav-link {{$category->subCategories->isNotEmpty() ? 'dropdown-toggler' : ''}} " href="{{route('front.shop',$category->slug)}}" data-bs-toggle="dropdown">
                                                <i class="flaticon-responsive"></i>

                                                <span>{{$category->name}}</span>
                                            </a>
                                            @if($category->subCategories->isNotEmpty())
                                            <div class="dropdown-menu">
                                                <ul class="mega-menu d-lg-flex">
                                                    <li class="mega-menu-col col-lg-7">
                                                        <ul class="d-lg-flex">
                                                            <li class="mega-menu-col col-lg-12">
                                                                <ul>
                                                                    <li class="dropdown-header"><a href="{{route('front.shop',[$category->slug])}}">{{$category->name}}</a></li>
                                                                        @foreach($category->subCategories->slice(0,6) as $subCategory )
                                                                            <li><a class="dropdown-item nav-link nav_item" href="{{route('front.shop',[$category->slug,$subCategory->slug])}}">{{$subCategory->name}}</a></li>
                                                                        @endforeach
                                                                </ul>
                                                            </li>
                                                            @if($category->subCategories->count() > 6)
                                                            <li class="mega-menu-col col-lg-6">
                                                                <ul>
{{--                                                                    <li class="dropdown-header">{{$category->name}}</li>--}}
                                                                    @foreach($category->subCategories->slice(6,12) as $subCategory )
                                                                        <li><a class="dropdown-item nav-link nav_item" href="{{route('front.shop',[$category->slug,$subCategory->slug])}}">{{$subCategory->name}}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-5">
                                                        <div class="header-banner2">
                                                            <a href="{{route('front.shop',[$category->slug])}}"><img src="{{asset('uploads/category/images/thumb/'.$category->image)}}" alt="{{$subCategory->name}}"></a>
                                                        </div>
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
                                                            <a class="dropdown-item nav-link {{$category->subCategories->isNotEmpty() ? 'dropdown-toggler' : ''}} " href="#" data-bs-toggle="dropdown">
                                                                <i class="flaticon-responsive"></i>

                                                                <span>{{$category->name}}</span>
                                                            </a>
                                                            @if($category->subCategories->isNotEmpty())
                                                                <div class="dropdown-menu">
                                                                    <ul class="mega-menu d-lg-flex">
                                                                        <li class="mega-menu-col col-lg-7">
                                                                            <ul class="d-lg-flex">
                                                                                <li class="mega-menu-col col-lg-12">
                                                                                    <ul>
                                                                                        <li class="dropdown-header">{{$category->name}}</li>
                                                                                        @foreach($category->subCategories->slice(0,6) as $subCategory )
                                                                                            <li><a class="dropdown-item nav-link nav_item" href="#">{{$subCategory->name}}</a></li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                                @if($category->subCategories->count() > 6)
                                                                                    <li class="mega-menu-col col-lg-6">
                                                                                        <ul>
                                                                                            @foreach($category->subCategories->slice(6,12) as $subCategory )
                                                                                                <li><a class="dropdown-item nav-link nav_item" href="#">{{$subCategory->name}}</a></li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </li>
                                                                        <li class="mega-menu-col col-lg-5">
                                                                            <div class="header-banner2">
                                                                                <a href="#"><img src="{{asset('uploads/category/images/thumb/'.$category->image)}}" alt="{{$category->name}}"></a>
                                                                            </div>
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
                                <li class="dropdown">
                                    <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle active" href="#">Home</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li><a class="dropdown-item nav-link nav_item" href="index.html">Fashion 1</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-2.html">Fashion 2</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-3.html">Furniture 1</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-4.html">Furniture 2</a></li>
                                            <li><a class="dropdown-item nav-link nav_item active" href="index-5.html">Electronics 1</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-6.html">Electronics 2</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Pages</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li><a class="dropdown-item nav-link nav_item" href="about.html">About Us</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="contact.html">Contact Us</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="faq.html">Faq</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="404.html">404 Error Page</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="login.html">Login</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="signup.html">Register</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="term-condition.html">Terms and Conditions</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Products</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Woman's</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">Vestibulum sed</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Donec porttitor</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Donec vitae facilisis</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">Curabitur tempus</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Vivamus in tortor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Men's</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="compare.html">Curabitur laoreet</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Vivamus in tortor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Kid's</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Donec vitae facilisis</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec porttitor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Accessories</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Donec vitae facilisis</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec porttitor</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <div class="d-lg-flex menu_banners row g-3 px-3">
                                            <div class="col-lg-6">
                                                <div class="header-banner">
                                                    <div class="sale-banner">
                                                        <a class="hover_effect1" href="#">
                                                            <img src="{{asset('front_assets/images/shop_banner_img7.jpg')}}" alt="shop_banner_img7">
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="header-banner">
                                                    <div class="sale-banner">
                                                        <a class="hover_effect1" href="#">
                                                            <img src="{{asset('front_assets/images/shop_banner_img8.jpg')}}" alt="shop_banner_img8">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Blog</a>
                                    <div class="dropdown-menu dropdown-reverse">
                                        <ul>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Grids</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-three-columns.html">3 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-four-columns.html">4 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-left-sidebar.html">Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-right-sidebar.html">right Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-standard-left-sidebar.html">Standard Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-standard-right-sidebar.html">Standard right Sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Masonry</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-three-columns.html">3 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-four-columns.html">4 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-left-sidebar.html">Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-right-sidebar.html">right Sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Single Post</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single.html">Default</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-left-sidebar.html">left sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-slider.html">slider post</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-video.html">video post</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-audio.html">audio post</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">List</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-list-left-sidebar.html">left sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-list-right-sidebar.html">right sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Shop</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-9">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Shop Page Layout</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">shop List view</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">shop List Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-right-sidebar.html">shop List Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Shop Load More</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Other Pages</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Cart</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Checkout</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="my-account.html">My Account</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Wishlist</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="compare.html">compare</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Order Completed</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Product Pages</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Default</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Thumbnails Left</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <div class="header_banner">
                                                    <div class="header_banner_content">
                                                        <div class="shop_banner">
                                                            <div class="banner_img overlay_bg_40">
                                                                <img src="{{asset('front_assets/images/shop_banner3.jpg')}}" alt="shop_banner"/>
                                                            </div>
                                                            <div class="shop_bn_content">
                                                                <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                                                <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                                                <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a class="nav-link nav_item" href="contact.html">Contact Us</a></li>
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
                                <li class="dropdown">
                                    <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle active" href="#">Home</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li><a class="dropdown-item nav-link nav_item" href="index.html">Fashion 1</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-2.html">Fashion 2</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-3.html">Furniture 1</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-4.html">Furniture 2</a></li>
                                            <li><a class="dropdown-item nav-link nav_item active" href="index-5.html">Electronics 1</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="index-6.html">Electronics 2</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Pages</a>
                                    <div class="dropdown-menu">
                                        <ul>
                                            <li><a class="dropdown-item nav-link nav_item" href="about.html">About Us</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="contact.html">Contact Us</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="faq.html">Faq</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="404.html">404 Error Page</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="login.html">Login</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="signup.html">Register</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="term-condition.html">Terms and Conditions</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Products</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Woman's</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">Vestibulum sed</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Donec porttitor</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Donec vitae facilisis</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">Curabitur tempus</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Vivamus in tortor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Men's</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="compare.html">Curabitur laoreet</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Vivamus in tortor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Kid's</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Donec vitae facilisis</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec porttitor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Accessories</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Donec vitae facilisis</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Donec porttitor</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <div class="d-lg-flex menu_banners row g-3 px-3">
                                            <div class="col-lg-6">
                                                <div class="header-banner">
                                                    <div class="sale-banner">
                                                        <a class="hover_effect1" href="#">
                                                            <img src="{{asset('front_assets/images/shop_banner_img7.jpg')}}" alt="shop_banner_img7">
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="header-banner">
                                                    <div class="sale-banner">
                                                        <a class="hover_effect1" href="#">
                                                            <img src="{{asset('front_assets/images/shop_banner_img8.jpg')}}" alt="shop_banner_img8">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Blog</a>
                                    <div class="dropdown-menu dropdown-reverse">
                                        <ul>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Grids</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-three-columns.html">3 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-four-columns.html">4 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-left-sidebar.html">Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-right-sidebar.html">right Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-standard-left-sidebar.html">Standard Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-standard-right-sidebar.html">Standard right Sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Masonry</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-three-columns.html">3 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-four-columns.html">4 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-left-sidebar.html">Left Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-right-sidebar.html">right Sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Single Post</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single.html">Default</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-left-sidebar.html">left sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-slider.html">slider post</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-video.html">video post</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-audio.html">audio post</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">List</a>
                                                <div class="dropdown-menu">
                                                    <ul>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-list-left-sidebar.html">left sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-list-right-sidebar.html">right sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Shop</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-9">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Shop Page Layout</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">shop List view</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html">shop List Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-right-sidebar.html">shop List Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Shop Load More</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Other Pages</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-cart.html">Cart</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="checkout.html">Checkout</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="my-account.html">My Account</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Wishlist</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="compare.html">compare</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="order-completed.html">Order Completed</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Product Pages</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.html">Default</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Thumbnails Left</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <div class="header_banner">
                                                    <div class="header_banner_content">
                                                        <div class="shop_banner">
                                                            <div class="banner_img overlay_bg_40">
                                                                <img src="{{asset('front_assets/images/shop_banner3.jpg')}}" alt="shop_banner"/>
                                                            </div>
                                                            <div class="shop_bn_content">
                                                                <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                                                <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                                                <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a class="nav-link nav_item" href="contact.html">Contact Us</a></li>
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
