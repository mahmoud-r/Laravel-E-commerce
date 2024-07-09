<!DOCTYPE html>
<html lang="en">
@include('front/layouts/include/head')
<body>

<!-- LOADER -->
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- END LOADER -->

{{--@include('front.popup.newsletter')--}}


<!-- START HEADER -->

@include('front.layouts.header.header')



<!-- END HEADER -->

<!-- START SECTION BREADCRUMB -->
@yield('breadcrumb')
<!-- END SECTION BREADCRUMB -->

<!-- END MAIN CONTENT -->
<div class="main_content">

    @yield('content')

    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    @include('front.layouts.include.newsletter')
    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
@include('front.layouts.include.footer')

<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

{{--mini Cart--}}
<div id="miniCartParent">
    @include('front.layouts.include.mini_cart')
</div>
{{--@include('front.popup.shop-quick-view')--}}

@include('front.layouts.include.script')
@include('front.layouts.include.cart-script')
@include('front.layouts.include.message')
<script>

    function addToWishlist(product) {
        $.ajax({
            url: '{{route('front.addToWishlist')}}',
            type: 'post',
            data: {product: product},
            dataType: 'json',
            success: function (response) {

                if (response.status == true) {

                    $('.wishlist_count').html(response.count)
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    })


                }
            }
        })
    }

    $(document).ready(function () {
        $('#category-search').on('change', function () {
            var categorySlug = $(this).val();
            var query = $('#search').val()
            var formAction;

            if (categorySlug) {
                formAction = "{{ route('front.shop', ':category') }}";
                formAction = formAction.replace(':category', categorySlug);
                search(query, categorySlug)
            } else {
                formAction = "{{ route('front.shop') }}";
                search(query, '')
            }

            $('#searchForm').attr('action', formAction);
        });
        $('#search').on('input', function () {
            var query = $(this).val();
            var category = $('#category-search').val();

            search(query, category)

        });

        function search(query, category) {
            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('front.search.products') }}",
                    type: "GET",
                    data: {
                        search: query,
                        category: category
                    },
                    success: function (response) {
                        $('#searchResults').addClass('active');
                        $('#searchResults').html(response);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#searchResults').removeClass('active')
                $('#searchResults').empty();
            }
        }

        $('#category').on('change', function () {
            var query = $('#search').val();
            var category = $(this).val();

            if (query.length > 2) {
                $.ajax({
                    url: "{{ route('front.search.products') }}",
                    type: "GET",
                    data: {
                        search: query,
                        category: category
                    },
                    success: function (response) {
                        $('#searchResults').addClass('active');
                        $('#searchResults').html(response);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#searchResults').removeClass('active')
                $('#searchResults').empty();
            }
        });
    });

    function deleteCompare(productId) {
        var url = '{{Route("front.compare.destroy","ID")}}';
        var newUrl = url.replace('ID', productId)
        $.ajax({
            url: newUrl,
            type: 'delete',
            data: '',
            dataType: 'json',
            success: function (response) {

                if (response.status == true) {
                    $('.product_' + response.productDeleted).fadeOut();
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    })
                }
            }
        })
    }

</script>
<script>
    $('#NewsletterForm').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: '{{Route('front.storeNewsletter')}}',
            type: 'post',
            data: form.serializeArray(),
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {
                    $('#NewsletterForm #email').val('')
                    Toast.fire({
                        icon: 'success',
                        title: 'Subscribe to newsletter successfully!'
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.errors.email
                    })
                }
            }, error: function (jqXHR, exception) {
                console.log('something went wrong')
            }
        })
    });
</script>
</body>
</html>
