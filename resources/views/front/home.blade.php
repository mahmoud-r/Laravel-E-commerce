@extends('front.layouts.app')

@section('title')@endsection
@section('style')
<style>
    .nav_cat.collapse:not(.show) {
        display: block;
    }
</style>
@endsection


@section('content')
    @include('front.layouts.header.home_banner')

    <!-- START SECTION SHOP -->
    @include('front.home.shop1')
    <!-- END SECTION SHOP -->

    <!-- START SECTION BANNER -->
    @include('front.home.banner')
    <!-- END SECTION BANNER -->

    <!-- START SECTION SHOP -->
    @include('front.home.shop2')

    <!-- END SECTION SHOP -->

    <!-- START SECTION SHOP -->
    @include('front.home.shop3')
    <!-- END SECTION SHOP -->

    <!-- START SECTION CLIENT LOGO -->
    @include('front.home.client')
    <!-- END SECTION CLIENT LOGO -->

    <!-- START SECTION SHOP -->
    @include('front.home.shop4')
    <!-- END SECTION SHOP -->

@endsection



@section('script')@endsection
