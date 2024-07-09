<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="@yield('meta_index', "index")">

    <title>@yield('title', config('settings.store_name'))</title>
    <meta name="description" content="@yield('meta_description', config('settings.store_description'))">

    <link rel="canonical" href="@yield('canonical', url()->current())">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', config('settings.store_name'))">
    <meta property="og:site_name" content="@yield('og_title', config('settings.store_name'))">
    <meta property="og:description" content="@yield('og_description', config('settings.store_description'))">
    <meta property="og:image" content="@yield('og_image',config('settings.store_logo') ? asset('uploads/site/images/'.get_setting('store_logo')) : asset('/front_assets/images/logo_dark.png'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', config('settings.store_name'))">
    <meta name="twitter:description" content="@yield('twitter_description', config('settings.store_description'))">
    <meta name="twitter:image" content="@yield('twitter_image',config('settings.store_logo') ? asset('uploads/site/images/'.get_setting('store_logo')) : asset('/front_assets/images/logo_dark.png'))">

    @yield('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Favicon Icon -->
    @if(!empty(get_setting('favicon_icon')))
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads/site/images/'.get_setting('favicon_icon'))}}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('/front_assets/images/favicon.png')}}">
    @endif
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/animate.css')}}">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/bootstrap/css/bootstrap.min.css')}}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/linearicons.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/simple-line-icons.css')}}">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{asset('front_assets/owlcarousel/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/owlcarousel/css/owl.theme.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/owlcarousel/css/owl.theme.default.min.css')}}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/magnific-popup.css')}}">
    <!-- jquery-ui CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/jquery-ui.css')}}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/slick-theme.css')}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('front_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('front_assets/css/responsive.css')}}">
    <!-- RTL CSS -->
    <!-- <link rel="stylesheet" href="{{asset('front_assets/css/rtl-style2.css')}}"> -->
    <!-- dir="rtl" -->

    @yield('style')
</head>
