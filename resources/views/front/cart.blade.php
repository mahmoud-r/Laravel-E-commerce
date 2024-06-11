@extends('front.layouts.app')


@section('title')@endsection

@section('style')
<style>
    .quantity .minus-cart, .quantity .plus-cart {
        background-color: #eee;
        display: block;
        float: left;
        border-radius: 50px;
        cursor: pointer;
        border: 0;
        padding: 0;
        width: 34px;
        height: 34px;
        line-height: 36px;
        text-align: center;
        font-size: 20px;
        margin: 4px;
    }
    .quantity .minus-cart {
        padding-left: 4px;
    }
</style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Shopping Cart</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Shopping Cart</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')
    <!-- START SECTION cart -->
    <div class="section">
        <div class="container">
            @if(Cart::count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shop_cart_table">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(Cart::content() as $item)

                                <tr id="{{$item->rowId}}">
                                    <td class="product-thumbnail">
                                        <a href="{{route('front.product',$item->options->slug)}}">

                                             @if(!empty($item->options->productImage->image))
                                            <img src="{{asset('uploads/products/images/thumb/'.$item->options->productImage->image)}}" alt="{{$item->name}}">
                                            @else
                                                <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$item->name}}">

                                            @endif
                                        </a>
                                    </td>

                                    <td class="product-name" data-title="Product"><a href="{{route('front.product',$item->options->slug)}}">{{$item->name}}</a></td>
                                    <td class="product-price itemPrice-{{$item->id}} " data-title="Price">${{$item->price}}</td>

                                    <td class="product-quantity" data-title="Quantity">
                                        <div class="quantity">
                                            <input type="button" value="-" class=" minus-cart sub" data-id="{{$item->id}}">
                                            <input type="text" name="quantity" value="{{$item->qty}}" title="Qty" class="qty qty-{{$item->id}}" size="4">
                                            <input type="button" value="+" class=" plus-cart add" data-id="{{$item->id}}">
                                        </div>
                                    </td>

                                    <td class="product-subtotal itemTotal-{{$item->id}}" data-title="Total">${{$item->total }}</td>
                                    <td class="product-remove" data-title="Remove"><a href="javascript:void(0)" onclick="deleteItem('{{$item->rowId}}')"><i class="ti-close"></i></a></td>
                                </tr>



                                @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="px-0">
                                    <div class="row g-0 align-items-center">

                                        <div class="col-lg-4 col-md-6 mb-3 mb-md-0">

                                        </div>
                                        <div class="col-lg-8 col-md-6  text-start  text-md-end">
                                            <a class="btn btn-line-fill btn-sm" href="{{route('home')}}">Continue shopping</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="medium_divider"></div>
                    <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="heading_s1 mb-3">
                        <h6>Calculate Shipping</h6>
                    </div>
                    <div class="field_form shipping_calculator">
                        <div class="form-row">
                            <div class="form-group col-lg-12 mb-3" >
                                <div class="custom_select">
                                    <select class="form-control first_null not_chosen" id="governorate_id" name="governorate_id">
                                        <option value="">Choose a option...</option>
                                        @forelse($governorates as $governorate)
                                        <option value="{{$governorate->id}}">{{$governorate->governorate_name_en}}</option>
                                        @empty
                                        @endforelse
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-12 mb-3">
                                <button class="btn btn-fill-line" type="button" id="shipping_calculator">Update Totals</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="border p-3 p-md-4">
                        <div class="heading_s1 mb-3">
                            <h6>Cart Totals</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody id="OrderSummery">
                                <tr>
                                    <td class="cart_total_label">Cart Subtotal</td>
                                    <td class="cart_total_amount cartSubTotal" >${{Cart::subtotal()}}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="product-subtotal" id="Discount">--</td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Shipping</td>
                                    <td class="cart_total_amount" id="total_shipping">Not calc yet</td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount "><strong class="cartTotal" id="grand_total">${{Cart::total()}}</strong></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <a href="{{route('front.checkout')}}" class="btn btn-fill-out">Proceed To CheckOut</a>
                    </div>
                </div>
            </div>
            @else

                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="mt-5 mb-5">
                            Looks like your cart is empty. Keep <a href="{{route('front.shop')}}" class="text-primary">shopping</a> and fill it up!

                        </h5>
                    </div>

                </div>
            @endif
        </div>
    </div>
    <!-- END SECTION cart -->
@endsection
@section('script')
<script>

    $(document).on('click', '#shipping_calculator', function (e) {
        e.preventDefault();
        var governorateId = $("#governorate_id").val()
        getOrderSummery(governorateId)
    });


    function getOrderSummery(governorateId){
        $.ajax({
            url:'{{route('front.getOrderSummery')}}',
            type:'post',
            data:{'governorateId':governorateId},
            dataType:'json',
            success:function (response){
                if(response.status == true){
                    $("#OrderSummery tr:not(:first)").remove()
                    $('#OrderSummery').append(`
                                 <tr>
                                    <td class="cart_total_label">Shipping</td>
                                    <td class="cart_total_amount" id="total_shipping">$${response.total_shipping}</td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount "><strong class="cartTotal" id="grand_total">$${response.grand_total}</strong></td>
                                </tr>
                    `)

                }
            }

        });
    }


</script>
@endsection


