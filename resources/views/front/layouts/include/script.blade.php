<!-- Latest jQuery -->
<script src="{{asset('front_assets/js/jquery-3.7.0.min.js')}}"></script>
<!-- jquery-ui -->
<script src="{{asset('front_assets/js/jquery-ui.js')}}"></script>
<!-- popper min js -->
<script src="{{asset('front_assets/js/popper.min.js')}}"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="{{asset('front_assets/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- owl-carousel min js  -->
<script src="{{asset('front_assets/owlcarousel/js/owl.carousel.min.js')}}"></script>
<!-- magnific-popup min js  -->
<script src="{{asset('front_assets/js/magnific-popup.min.js')}}"></script>
<!-- waypoints min js  -->
<script src="{{asset('front_assets/js/waypoints.min.js')}}"></script>
<!-- parallax js  -->
<script src="{{asset('front_assets/js/parallax.js')}}"></script>
<!-- countdown js  -->
<script src="{{asset('front_assets/js/jquery.countdown.min.js')}}"></script>
<!-- imagesloaded js -->
<script src="{{asset('front_assets/js/imagesloaded.pkgd.min.js')}}"></script>
<!-- isotope min js -->
<script src="{{asset('front_assets/js/isotope.min.js')}}"></script>
<!-- jquery.dd.min js -->
<script src="{{asset('front_assets/js/jquery.dd.min.js')}}"></script>
<!-- slick js -->
<script src="{{asset('front_assets/js/slick.min.js')}}"></script>
<!-- sweetalert2 -->
{{--<script src="{{asset('front_assets/js/sweetalert2.all.min.js')}}"></script>--}}
<!-- elevatezoom js -->
<script src="{{asset('front_assets/js/jquery.elevatezoom.js')}}"></script>




<!-- scripts js -->
<script src="{{asset('front_assets/js/scripts.js')}}"></script>

<script>
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    })
</script>
@yield('script')
