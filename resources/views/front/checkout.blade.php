@extends('front.layouts.app')


@section('title')@endsection

@section('style')
<style>
    .product-title-container {
        display: flex;
        align-items: center;
    }

    .product-title {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        white-space: normal;
        text-transform: capitalize;
        margin-right: 10px;
    }

    .product-qty {
        white-space: nowrap;
    }

</style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Checkout</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.cart')}}">Cart</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')
    <div class="section" style="padding: 0">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="medium_divider"></div>
                    <div class="divider center_icon"><i class="linearicons-credit-card"></i></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <form method="post" id="processCheckout" action="{{route('front.process_checkout')}}"  >
                @csrf
                <div class="row" style="margin-bottom: 50px">
                    <div class="col-md-6">
                        <div class="heading_s1">
                            <h4>SHIPPING ADDRESS</h4>
                        </div>

                            <div class="tab-content mb-4" id="nav-tabContent">
                                <div class="tab-pane fade" id="tab-address" role="tabpanel" aria-labelledby="address-tab">
                                    <div class="card">
                                        <div class="card-header">
                                           <h4> Your addresses
                                               <a href="javascript:void(0)" class="btn btn-fill-out btn-sm float-end" data-bs-toggle="modal" data-bs-target="#create-user-address">Add New </a>

                                           </h4>
                                        </div>
                                        <div class="card-body" id="address-list">
                                            @include('front.checkout.address-list')
                                        </div>
                                        <div class="card-footer">
                                            <a href="javascript:void(0)" onclick="changeAddress()" class="btn btn-fill-out btn-sm float-end">Use this address</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                                @forelse(auth()->user()->addresses()->get() as $address)
                                    @if($address->is_primary == true)

                                        <div class="col-md-10" id="selected-address" >
                                            <input type="hidden" name="address" class="form-check-input" value="{{$address->id}}" id="{{$address->address_name}}" data-governorate="{{$address->governorate->id}}">
                                            <div class="card mb-3 mb-lg-4 {{$address->is_primary == true ? 'address-default' : ''}} " >
                                                <div class="card-header" role="tablist">
                                                    <h5>{{$address->address_name}}
                                                        <button  id="address-tab-button" data-bs-toggle="tab" data-bs-target="#tab-address" type="button" role="tab" aria-controls="tab-address" aria-selected="true" class="btn btn-fill-out btn-sm float-end">Change</button>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <address>{{$address->first_name}} {{$address->last_name}}</address>
                                                    <address>{{$address->building}},{{$address->street}},</address>
                                                    <address>{{$address->district}},{{$address->city->city_name_en}},{{$address->governorate->governorate_name_en}}</address>
                                                    <address>{{$address->nearest_landmark}}</address>
                                                    <address>{{$address->phone}} & {{$address->second_phone}}</address>
                                                </div>
                                            </div>
                                        </div>
                                        @else

                                            <div class="card-header" role="tablist">
                                                    <button  id="address-tab-button" data-bs-toggle="tab" data-bs-target="#tab-address" type="button" role="tab" aria-controls="tab-address" aria-selected="true" class="btn btn-fill-out btn-sm float-end d-none">Change</button>
                                            </div>

                                        @endif

                                @empty
                                @endforelse

                            <div id="selected"></div>

                            @if(auth()->user()->addresses()->count() == 0)
                                @include('front.checkout.address_form')
                            @endif

                                <div class="heading_s1">
                                <h4>Additional information</h4>
                            </div>
                            <div class="form-group mb-0">
                                <textarea rows="5" class="form-control @error('note') is-invalid @enderror" name="note" placeholder="Order notes">{{ old('district') }}</textarea>
                                @error('note')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                    </div>

                    <div class="col-md-6">
                        <div class="order_review">
                            <div class="heading_s1">
                                <h4>Your Orders</h4>
                            </div>
                            <div class="table-responsive order_table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="productTable">
                                    @foreach(Cart::content() as $item)
                                    <tr>
                                        <td class="product-title-container">
                                            <span class="product-title">{{$item->name}}</span>
                                            <span class="product-qty">x {{$item->qty}}</span>
                                        </td>
                                        <td>{{$item->total}} EGP</td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>SubTotal</th>
                                        <td class="product-subtotal">{{Cart::subtotal(2,'.','')}} EGP</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td class="product-subtotal" id="Discount">--</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <td id="total_shipping">--</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td class="product-subtotal" id="grand_total">{{Cart::total(2,'.','')}} EGP</td>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="coupon field_form input-group ">
                                <input type="text" value="" id="discount_code"  class="form-control" placeholder="Enter Coupon Code..">
                                <div class="input-group-append">
                                    <button class="btn btn-fill-out btn-sm" id="apply_discount" type="button">Apply Coupon</button>
                                </div>
                            </div>
                            <p class="error" id="discount_error"></p>

                            <div id="response_coupon"  style="padding: 10px;">
                            @if(session('code'))
                                <div class="coupon field_form input-group mt-1" >
                                    <strong class="text-primary" style="font-size: 16px;">{{session('code')->code}}</strong>
                                    <a href="javascript:void(0)" onclick="RemoveCoupon()"  class=""><i class="ti-close  text-black" style="font-size: 11px;margin-left: 5px"></i> </a>
                                </div>
                            @endif

                            </div>
                            <div class="payment_method mt-4">
                                <div class="heading_s1">
                                    <h4>Payment</h4>
                                </div>

                                <div class="payment_option">
                                    @if($codSettings['status'] == 1 )
                                    <div class="custome-radio">
                                        <input class="form-check-input" required="" checked type="radio" name="payment_method" id="cod" value="cod" >
                                        <label class="form-check-label" for="cod">{{$codSettings['payment_cod_name']}}</label>
                                        <p data-method="cod" class="payment-text">{!! $codSettings['payment_cod_description'] !!}</p>
                                    </div>
                                    @endif
                                        @if($bankTransferSettings['status'] == 1 )
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" >
                                                <label class="form-check-label" for="bank_transfer">{{$bankTransferSettings['payment_bank_transfer_name']}}</label>
                                                <p data-method="bank_transfer" class="payment-text">{!! $bankTransferSettings['payment_bank_transfer_description'] !!}</p>
                                            </div>
                                        @endif
                                        @if($stripeSettings['status'] == 1 )
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio" name="payment_method" id="stripe" value="stripe" >
                                                <label class="form-check-label" for="stripe">{{$stripeSettings['payment_stripe_name']}}</label>
                                                <p data-method="stripe" class="payment-text">{{$stripeSettings['payment_stripe_description']}}</p>
                                            </div>
                                        @endif
                                        @if($paypalSettings['status'] == 1 )
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio" name="payment_method" id="paypal" value="paypal" >
                                                <label class="form-check-label" for="paypal">{{$paypalSettings['payment_paypal_name']}}</label>
                                                <p data-method="paypal" class="payment-text">{{$paypalSettings['payment_paypal_description']}}</p>
                                            </div>
                                        @endif

                                </div>
                            </div>
                            <button type="submit" class="btn btn-fill-out btn-block">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @include('front.profile.addresses.create_model')

    <div id="edit_address"></div>

@endsection
@section('script')
<script>
    $(document).ready(function (){
        var governorateId = $('#selected-address input[name="address"]').data('governorate');
        if (governorateId) {
            getOrderSummery(governorateId);
        }else {
            var someTabTriggerEl = document.querySelector('#address-tab-button');
            if (someTabTriggerEl) {
                var tab = new bootstrap.Tab(someTabTriggerEl);
                tab.show();
            }
        }
    });

    //change address
    function changeAddress(){
        var selected_address = $('input[name="address"]:checked').val();
        var url ='{{route('front.getaddress','ID')}}';
        var newUrl =url.replace('ID',selected_address);
        $.ajax({
            url: newUrl,
            type: 'get',
            data:'',
            success: function (response) {
                $('#selected').html(response);
                $('#tab-address').fadeOut(1000, function() {
                    $('#selected').fadeIn(1000);
                });
                var governorateId = $('#selected-address input[name="address"]').data('governorate');
                getOrderSummery(governorateId);
            }
        });
    }
    //show model create address
    $('#create-user-address').on('shown.bs.modal', function () {
        $('.error').removeClass('invalid-feedback').html('');
        $("input[type='text'],input[type='number'],select").removeClass('is-invalid');
    })


    //show model edit address
    function editAddress(id){
        var url ='{{route('front.address.edit','ID')}}';
        var newUrl =url.replace('ID',id);
        $.ajax({
            url: newUrl,
            type: 'get',
            data:id,
            success: function (response) {
                $('#create-user-address').modal('dispose');
                $('#edit_address').html(response);
                $('#edit-user-address').modal('show');

            }
        });
    }

    //update address
    $(document).on('submit', '#AddressUpdateForm', function (e) {
        e.preventDefault();
        var formArray = $(this).serializeArray();
        var addressId = formArray.find(item => item.name === 'address_id').value;
        var url = '{{ route('front.address.update', 'ID') }}';
        var newUrl = url.replace('ID', addressId);

        $.ajax({
            url: newUrl,
            type: 'PUT',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('.error').removeClass('invalid-feedback').html('');
                    $("input[type='text'], input[type='number'], select").removeClass('is-invalid');
                    $('#edit-user-address').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    });
                    var address =response.address
                    var city =response.city ;
                    var governorate =response.governorate ;

                    $('#'+address.id).html(`
                               <label class="form-check-label" for="${address.address_name}">
                                 <input type="radio" value="${address.id}" name="address" class="form-check-input" id="${address.address_name}">
                                  <span><strong>${address.address_name}</strong></span>,
                                  <span>${address.first_name} ${address.last_name}</span>,
                                   <span>${address.building}</span>,
                                    <span>${address.street}</span>,
                                    <span>${address.district},${city},${governorate}</span>,
                                    <span>${address.nearest_landmark}</span>,
                                    <span>${address.phone}</span>,
                                     <span>${address.second_phone}</span>
                                     <a href="javascript:void(0)" onclick="editAddress(${address.id})" class="text-primary">Edit</a>

                                     </label>

                    `);

                } else {

                    handleErrors(response.errors);
                }
            },
            error: function (jqXHR) {
                handleErrors(jqXHR.responseJSON.errors);
            }
        });
    });

    //create address
    $('#AddressCreateForm').submit(function (e){
        e.preventDefault();
        var form =$(this);
        $.ajax({
            url:'{{ route('front.address.store') }}',
            type:'post',
            data:form.serializeArray(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function (response){
                if(response.status == true){

                    $('.error').removeClass('invalid-feedback').html('');
                    $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                    $('#create-user-address').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })
                    var address =response.address ;
                    var city =response.city ;
                    var governorate =response.governorate ;

                    $('#address-list').append(`
                            <div class="form-check mb-4">
                               <label class="form-check-label" for="${address.address_name}">
                                 <input type="radio" value="${address.id}" name="address" class="form-check-input" id="${address.address_name}">
                                  <span><strong>${address.address_name}</strong></span>,
                                  <span>${address.first_name} ${address.last_name}</span>,
                                   <span>${address.building}</span>,
                                    <span>${address.street}</span>,
                                    <span>${address.district},${city},${governorate}</span>,
                                    <span>${address.nearest_landmark}</span>,
                                    <span>${address.phone}</span>,
                                     <span>${address.second_phone}</span>
                                     <a href="javascript:void(0)" onclick="editAddress(${address.id})" class="text-primary">Edit</a>

                                     </label>
                            </div>
                        `);
                }else {
                    handleErrors(response.errors);
                }


            },error:function (jqXHR){
                handleErrors(jqXHR.responseJSON.errors);
            }
        })
    });


    //get cities dynamic
    $(document).ready(function () {
        var oldGovernorateId = "{{ old('governorate_id') }}";
        var oldCityId = "{{ old('city_id') }}";

        if (oldGovernorateId) {
            $('.governorate_id').val(oldGovernorateId).trigger('change');
            fetchCities(oldGovernorateId, oldCityId);
            getOrderSummery(oldGovernorateId)
        }

        function fetchCities(governorateId, selectedCityId) {
            $.ajax({
                url: '{{ route('front.getCities') }}',
                type: 'get',
                data: { governorate_id: governorateId },
                dataType: 'json',
                success: function (response) {
                    $('.city_id').find('option').not(':first').remove();
                    $.each(response['cities'], function (key, item) {
                        $('.city_id').append('<option value="' + item.id + '" >' + item.city_name_en + '</option>');
                    });
                    if (selectedCityId) {
                        $('.city_id').val(selectedCityId);
                    }
                }
            });
        }

        $(document).on('change', '.governorate_id', function () {
            var governorateId = $(this).val();
            fetchCities(governorateId);
            getOrderSummery(governorateId)
        });
    });

    //shipping
    function getOrderSummery(governorateId){
        $.ajax({
            url:'{{route('front.getOrderSummery')}}',
            type:'post',
            data:{'governorateId':governorateId},
            dataType:'json',
            success:function (response){
                if(response.status == true){
                    $('#total_shipping').html(response.total_shipping + ' EGP')
                    $('#grand_total').html(response.grand_total + ' EGP')
                    $('#Discount').html(response.discount + ' EGP')

                }
            }

        });
    }

    //apply discount
    $(document).on('click','#apply_discount',function (){
        var code = $('#discount_code').val()
        var governorateId = $('#selected-address input[name="address"]').data('governorate') || $('.governorate_id').val();
        $.ajax({
            url:'{{route('front.applyDiscount')}}',
            type:'post',
            data:{'code':code,'governorateId':governorateId},
            dataType:'json',
            success:function (response){
                if(response.status == true){
                    $('#discount_error').removeClass('invalid-feedback').html('');
                    $('#total_shipping').html(response.total_shipping + ' EGP')
                    $('#grand_total').html(response.grand_total + ' EGP')
                    $('#Discount').html(response.discount + ' EGP')
                    $('#discount_code').val('')
                    $('#response_coupon').html(response.discountString )

                    Toast.fire({
                        icon: 'success',
                        title: 'Coupon has been applied successfully.'
                    })
                }else {
                    $('#discount_error').addClass('invalid-feedback').show().html(response.msg);

                }
            }

        });

    })

    //RemoveCoupon

    function RemoveCoupon(){
        var governorateId = $('#selected-address input[name="address"]').data('governorate') || $('.governorate_id').val();
        $.ajax({
            url:'{{route('front.RemoveCoupon')}}',
            type:'post',
            data:{'governorateId':governorateId},
            dataType:'json',
            success:function (response){
                if(response.status == true){
                    $('#total_shipping').html(response.total_shipping + ' EGP')
                    $('#grand_total').html(response.grand_total + ' EGP')
                    $('#Discount').html(response.discount + ' EGP')
                    $('#response_coupon').html('')
                }
            }

        });
    }
    //show tab
    $(document).on('click', '#address-tab-button', function () {
        $('#tab-address').fadeIn(1000, function() {
            // $('#selected-address').fadeOut(100);
            // $('#selected').fadeOut(100);
            $('#selected-address').remove();
        });
    });

    //handel errors
    function handleErrors(errors) {
        $('.error').removeClass('invalid-feedback').html('');
        $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

        $.each(errors, function (key, value) {
            $(`.${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
        });
    }


</script>

@endsection


