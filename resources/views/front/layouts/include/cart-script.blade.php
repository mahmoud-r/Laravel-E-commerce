<script type="text/javascript">

    var miniCart = new bootstrap.Offcanvas(document.getElementById('miniCart'));

    $(document).on('click', '.plus-cart', function() {
        var QtyElement = $(this).prev();
        var QtyValue = parseInt(QtyElement.val());

        if (QtyElement) {
            var rowId = $(this).data('id');

            QtyElement.val(QtyValue + 1);

            var newQty = parseInt(QtyElement.val());
            updateCart(rowId, newQty);
        }
    });
    $(document).on('click', '.minus-cart', function() {
        var QtyElement = $(this).next();
        var QtyValue = parseInt(QtyElement.val());

        if (QtyElement) {
            if (QtyValue > 1) {
                var rowId = $(this).data('id');

                QtyElement.val(QtyValue - 1);

                var newQty = parseInt(QtyElement.val());
                updateCart(rowId, newQty);
            }
        }
    });

    function addToCart(id) {
        $.ajax({
            url: '{{route('front.addToCart')}}',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (response) {

                if (response.status == true) {

                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })
                    $('.cart_count').html(response.cartCount);
                    $('.cartCount').html(response.cartCount);

                    updateMiniCart();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    })
                    $('.qty-'+id).val(response.newQty)

                }
            }
        })
    }
    function addToCartWithQty(id) {
        var qty = $("input[name='quantity']").val() ? $("input[name='quantity']").val() : '1';

        $.ajax({
            url: '{{route('front.addToCart')}}',
            type: 'post',
            data: {id: id, qty: qty},
            dataType: 'json',
            success: function (response) {

                if (response.status == true) {

                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })
                    $('.cart_count').html(response.cartCount);
                    $('.cartCount').html(response.cartCount);

                    updateMiniCart();


                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    })
                    $('.qty-'+id).val(response.newQty)

                }
            }
        })
    }

    function deleteItem(rowId){
        $.ajax({
            url :'{{route('front.deleteItem')}}',
            type : 'post',
            data:{rowId:rowId},
            dataType :'json',
            success:function (response){

                if(response.status == true){
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })
                    if (response.cartCount === 0) {
                        location.reload();
                    }else {
                        $('.cartSubTotal').html('$'+response.cartSubTotal)
                        $('.cartTotal').html('$'+response.cartTotal)
                        $('#'+response.rowId).remove();
                        $('.cart_count').html(response.cartCount);
                        $('.cartCount').html(response.cartCount);

                    }

                }else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    })
                }
            }
        })
    }
    function updateCart(itemId, qty) {
        $.ajax({
            url: '{{ route('front.updateCart') }}',
            type: 'post',
            data: { itemId: itemId, qty: qty },
            dataType: 'json',
            success: function (response) {
                if (response.status ==true) {
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    });
                    $('.itemTotal-' + itemId).html('$' + response.itemTotal);
                    $('.itemPrice-' + itemId).html('$' + response.price);
                    $('.cartSubTotal').html('$' + response.cartSubTotal);
                    $('.cartTotal').html('$' + response.cartTotal);
                    $('.cartCount').html(response.cartCount);
                    $('.cart_count').html(response.cartCount);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.msg
                    });
                    $('.qty-' + itemId).val(response.newQty);
                }
            }
        });
    }

    function updateMiniCart() {
        $.ajax({
            url: '{{route('front.getMiniCart')}}', // Route to get the mini cart content
            type: 'get',
            success: function (response) {
                $('#miniCartParent').html(response); // Replace the mini cart content
                var miniCart = new bootstrap.Offcanvas(document.getElementById('miniCart'));
                miniCart.show();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Get the last update check from localStorage
        var lastCheck = localStorage.getItem('lastCartUpdateCheck');

        // Get today's date as a string (e.g., '2024-05-18')
        var today = new Date().toISOString().split('T')[0];

        // If last check was not today, perform the check
        if (lastCheck !== today) {
            checkCartUpdates();
            // Update localStorage with today's date
            localStorage.setItem('lastCartUpdateCheck', today);
        }
    });
    function checkCartUpdates() {
        $.ajax({
            url: '{{ route('front.checkCartUpdates') }}',
            type: 'get',
            success: function(response) {
                if (response.updated) {
                    updateMiniCart();
                    Toast.fire({
                        icon: 'info',
                        title: response.msg
                    });
                }
            }
        });
    }


</script>
