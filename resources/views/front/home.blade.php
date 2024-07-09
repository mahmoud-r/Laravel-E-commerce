@extends('front.layouts.app')
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "{{ url('/') }}",
  "logo": "{{ config('settings.store_logo') ? asset('uploads/site/images/'.get_setting('store_logo')) : asset('/front_assets/images/logo_dark.png') }}",
  "name": "{{ config('settings.store_name') }}",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "{{ config('settings.store_phone') }}",
    "contactType": "Customer Service"
  }
}
</script>
@section('style')
    <style>
        .nav_cat.collapse:not(.show) {
            display: block;
        }
    </style>
@endsection


@section('content')

    <!-- START SECTION Slider Section -->
    @include('front.home.slider_section')
    <!-- END SECTION Slider Section -->


    <!-- START SECTION Categories -->
    @include('front.home.categories_Section')
    <!-- END SECTION Categories -->



    <!-- START SECTION flash sale -->
    @include('front.home.section2')
    <!-- END SECTION flash sale -->


    <!-- START SECTION 3 -->
    @include('front.home.section3')
    <!-- END SECTION 3 -->

    <!-- START SECTION BANNER -->
    @include('front.home.banner')
    <!-- END SECTION BANNER -->


    <!-- START SECTION SECTION 4 -->
    @include('front.home.section4')
    <!-- END SECTION SECTION 4 -->


    <!-- START SECTION Icons  -->
    @include('front.home.icons-section')
    <!-- END SECTION Icons  -->

    <!-- START SECTION SECTION 5 -->
    @include('front.home.section5')
    <!-- END SECTION SECTION 5 -->

    <!-- START SECTION CLIENT LOGO -->
    @include('front.home.brands_Section')
    <!-- END SECTION CLIENT LOGO -->

@endsection



@section('script')@endsection
