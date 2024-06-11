@extends('admin.master')

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Payment methods</li>
@endsection
@section('style')
<style>
    .payment-content-item{
        display: none;
    }
    p{
        font-size: 0.9rem;
    }
    .form-fieldset {
        background: #f6f8fb;
        border: 1px solid #dce1e7;
        border-radius: 4px;
        margin-bottom: 1rem;
        padding: 1rem;
    }
    .fw-semibold {
        font-weight: 600 !important;
    }
    .fs-4 {
        font-size: 1rem !important;
    }
    .border-end {
        border-right: 1px solid #dce1e7 !important;
    }
</style>
@endsection



@section('content')
    <div class="row mb-5 d-block d-md-flex">
        <div class="col-12 col-md-3 mt-5">
            <h2>Payment methods</h2>

            <p class="text-muted">Setup payment methods for website</p>


        </div>

        <div class="col-12 col-md-9 mt-5">
            <div class="card mb-3">
                <table class="table table-vcenter card-table">
                    <tbody>
                    <tr>
                        <td class="border-end" style="width: 5%">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path>
                                <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                            </svg>
                        </td>
                        <td style="width: 20%">
                            <img src="{{asset('admin-assets/img')}}/stripe.svg" alt="Stripe" style="width: 8rem">
                        </td>
                        <td>
                            <a href="https://stripe.com" target="_blank">Stripe</a>
                            <p class="mb-0">Customer can buy product and pay directly using Visa, Credit card via Stripe</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="d-flex justify-content-end align-items-center">

                                <button class="btn   toggle-payment-item edit-payment-item-btn-trigger close-btn" type="button" id="edit-payment-stripe-btn-trigger">Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="payment-content-item" id="payment-stripe-content" >
                        <td colspan="3">
                            <form method="POST" action="{{route('payment-methods.update')}}" accept-charset="UTF-8">
                                @csrf
                                <input type="hidden" name="type" value="stripe" class="payment_type">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Configuration instruction for Stripe</label>
                                        <p class="mb-2">To use Stripe, you need:</p>
                                        <ol>
                                            <li>
                                                <p>
                                                    <a href="https://dashboard.stripe.com/register" target="_blank">
                                                        Register with Stripe
                                                    </a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>After registration at Stripe, you will have Public, Secret keys</p>
                                            </li>
                                            <li>
                                                <p>Enter Public, Secret keys into the box in right hand</p>
                                            </li>
                                        </ol>

                                        <h4>Stripe Webhook Setup Guide</h4>

                                        <p>Follow these steps to set up a Stripe webhook</p>

                                        <ol>
                                            <li>
                                                <p><strong>Login to the Stripe Dashboard:</strong> Access the <a href="https://dashboard.stripe.com/" target="_blank" rel="noreferrer noopener">Stripe Dashboard</a> and click on the "Add Endpoint" button in the "Webhooks" section of the "Developers" tab.</p>
                                            </li>

                                            <li>
                                                <p><strong>Select Event and Configure Endpoint:</strong> Select the "payment_intent.succeeded" event and enter the following URL in the "Endpoint URL" field: <code>{{env('APP_URL')}}/payment/stripe/webhook</code></p>
                                            </li>

                                            <li>
                                                <p><strong>Add Endpoint:</strong> Click the "Add Endpoint" button to save the webhook.</p>
                                            </li>

                                            <li>
                                                <p><strong>Copy Signing Secret:</strong> Copy the "Signing Secret" value from the "Webhook Details" section and paste it into the "Stripe Webhook Secret" field in the "Stripe" section of the "Payment" tab in the "Settings" page.</p>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="payment_stripe_name"> Method name </label>
                                            <input class="form-control" type="text" name="payment_stripe_name" id="payment_stripe_name" value="{{ $stripeSettings['payment_stripe_name']}}" data-counter="400">
                                        </div>

                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="payment_stripe_description">Description</label>

                                            <textarea class="form-control" name="payment_stripe_description" id="payment_stripe_description">{{$stripeSettings['payment_stripe_description']}}</textarea>
                                        </div>

                                        <fieldset class="form-fieldset">
                                            <div class="fs-4 fw-semibold mb-3">
                                                Please provide information
                                                <a href="https://stripe.com" target="_blank">Stripe</a>:
                                            </div>

                                            <div class="mb-3 position-relative">

                                                <label for="payment_stripe_client_id" class="form-label">Stripe Public Key</label>

                                                <input class="form-control" data-counter="400" name="payment_stripe_client_id" type="text" value="{{$stripeSettings['payment_stripe_client_id']}}" id="payment_stripe_client_id">

                                            </div>

                                            <div class="mb-3 position-relative">

                                                <label for="payment_stripe_secret" class="form-label">Stripe Private Key</label>

                                                <input class="form-control" data-counter="250" placeholder="sk_*************" name="payment_stripe_secret" type="password" value="*******************************" id="payment_stripe_secret">

                                            </div>


                                            <div class="mb-3 position-relative">

                                                <label for="payment_stripe_webhook_secret" class="form-label">Webhook Secret</label>

                                                <input class="form-control" data-counter="250" placeholder="whsec_*************" name="payment_stripe_webhook_secret" type="password" value="*******************************" id="payment_stripe_webhook_secret">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="btn-list d-flex gap-2 justify-content-end">
                                    @if($stripeSettings['status'] == 1)

                                        <button class="btn close-btn active-toggle" data-status="0" data-type="stripe" type="button">Deactivate</button>
                                    @endif
                                    @if($stripeSettings['status'] == 0)
                                        <button class="btn btn-info  btn-text-trigger-save active-toggle" data-status="1" data-type="stripe" type="button">Activate</button>
                                    @endif
                                    <button class="btn btn-info  save-payment-item btn-text-trigger-update" type="submit">Update</button>
                                </div>
                            </form>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card mb-3">
                <table class="table table-vcenter card-table">
                    <tbody>
                    <tr>
                        <td class="border-end" style="width: 5%">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path>
                                <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                            </svg>
                        </td>
                        <td style="width: 20%">
                            <img src="{{asset('admin-assets/img')}}/paypal.svg" alt="Paypal" style="width: 8rem">
                        </td>
                        <td>
                            <a href="https://paypal.com" target="_blank">Paypal</a>
                            <p class="mb-0">Customer can buy product and pay directly via PayPal</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="d-flex justify-content-end align-items-center">
                                <button class="btn close-btn  toggle-payment-item edit-payment-item-btn-trigger" id="edit-payment-paypal-btn-trigger" type="button">Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="payment-content-item " id="payment-content-paypal">
                        <td colspan="3">
                            <form method="POST" action="{{route('payment-methods.update')}}" accept-charset="UTF-8">
                                @csrf


                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Configuration instruction for Paypal</label>

                                        <p class="mb-2">To use Paypal, you need:</p>
                                        <ol>
                                            <li>
                                                <p>
                                                    <a href="https://www.paypal.com/merchantsignup/applicationChecklist?signupType=CREATE_NEW_ACCOUNT&amp;productIntentId=email_payments" target="_blank">
                                                        Register with PayPal
                                                    </a>
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    After registration at PayPal, you will have Client ID, Client Secret
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    Enter Client ID, Secret into the box in right hand
                                                </p>
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="payment_paypal_name">Method name </label>
                                            <input class="form-control" type="text" name="payment_paypal_name" id="payment_paypal_name" value="{{$paypalSettings['payment_paypal_name']}}" data-counter="400">
                                        </div>

                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="payment_paypal_description">Description</label>

                                            <textarea class="form-control " name="payment_paypal_description" id="payment_paypal_description">{{$paypalSettings['payment_paypal_description']}}</textarea>
                                        </div>

                                        <fieldset class="form-fieldset">
                                            <div class="fs-4 fw-semibold mb-3">
                                                Please provide information
                                                <a href="https://paypal.com" target="_blank">Paypal</a>:
                                            </div>

                                            <div class="mb-3 position-relative">
                                                <label for="payment_paypal_client_id" class="form-label">Client ID</label>

                                                <input class="form-control" data-counter="250" name="payment_paypal_client_id" type="text" value="{{$paypalSettings['payment_paypal_client_id']}}" id="payment_paypal_client_id">
                                            </div>

                                            <div class="mb-3 position-relative">
                                                <label for="payment_paypal_client_secret" class="form-label">Client Secret</label>

                                                <input class="form-control" data-counter="250" name="payment_paypal_client_secret" type="password" value="*******************************" id="payment_paypal_client_secret">

                                            </div>

                                            <div class="mb-3 position-relative">

                                                <input type="hidden" name="payment_paypal_mode" value="0">

                                                <label class="form-check">
                                                    <input type="checkbox"  name="payment_paypal_mode" class="form-check-input" value="1" {{$paypalSettings['payment_paypal_mode'] == 1 ?'checked':''}}>

                                                    <span class="form-check-label">Live mode </span>
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="paypal" class="payment_type">
                                <div class="btn-list justify-content-end d-flex gap-2">
                                    @if($paypalSettings['status'] == 1)

                                        <button class="btn close-btn active-toggle" data-status="0" data-type="paypal" type="button">Deactivate</button>
                                    @endif
                                    @if($paypalSettings['status'] == 0)
                                        <button class="btn btn-info  btn-text-trigger-save active-toggle" data-status="1" data-type="paypal" type="button">Activate</button>
                                    @endif
                                    <button class="btn btn-info  save-payment-item btn-text-trigger-update" type="submit">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card mb-3">
                <table class="table table-vcenter card-table">
                    <tbody>
                    <tr>
                        <td class="border-end">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path>
                                <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path>
                            </svg>
                        </td>
                        <td style="width: 20%">Payment methods </td>
                        <td>
                            <p class="mb-0">Guide customers to pay directly. You can choose to pay by delivery or bank transfer</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="payment-name-label-group">
                                        Use
                                        <span class="method-name-label">Cash on delivery (COD)</span>
                                    </div>
                                </div>

                                <button class="btn  close-btn toggle-payment-item edit-payment-item-btn-trigger" id="edit-payment-cod-btn-trigger" type="button">Edit</button>
                            </div>
                        </td>
                    </tr>
                    <tr id="payment-content-cod" class="payment-content-item hidden">
                        <td colspan="3">
                            <form method="POST" action="{{route('payment-methods.update')}}" accept-charset="UTF-8">
                                @csrf
                                <input class="payment_type" name="type" type="hidden" value="cod">
                                <div class="mb-3 position-relative">
                                    <label for="payment_cod_name" class="form-label">Method name</label>
                                    <input class="form-control" data-counter="400" name="payment_cod_name" type="text" value="{{$codSettings['payment_cod_name']}}" id="payment_cod_name">
                                </div>
                                <div class="mb-3 position-relative" style="max-width: 99.8%">
                                    <label for="payment_cod_description" class="form-label">Payment guide - (Displayed on the notice of successful purchase and payment page)</label>
                                    <textarea class="form-control form-control editor-ckeditor ays-ignore summernote" data-counter="100000" rows="4" id="payment_cod_description" name="payment_cod_description" cols="50">
                                            {{$codSettings['payment_cod_description']}}
                                        </textarea>

                                </div>
                                {{--                                    <div class="mb-3 position-relative">--}}

                                {{--                                        <label for="payment_cod_minimum_amount" class="form-label">Minimum order amount (Optional)</label>--}}
                                {{--                                        <input class="form-control" name="payment_cod_minimum_amount" type="number" value="{{$codSettings['payment_cod_minimum_amount']}}" id="payment_cod_minimum_amount" >--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="mb-3 position-relative">--}}

                                {{--                                        <label for="payment_cod_maximum_amount" class="form-label">Maximum order amount (Optional)</label>--}}
                                {{--                                        <input class="form-control" name="payment_cod_maximum_amount"  type="number" value="{{$codSettings['payment_cod_maximum_amount']}}" id="payment_cod_maximum_amount">--}}
                                {{--                                    </div>--}}
                                <div class="btn-list justify-content-end d-flex gap-2">
                                    @if($codSettings['status'] == 1)

                                        <button class="btn close-btn active-toggle" data-status="0" data-type="cod" type="button">Deactivate</button>
                                    @endif
                                    @if($codSettings['status'] == 0)
                                        <button class="btn btn-info  btn-text-trigger-save active-toggle" data-status="1" data-type="cod" type="button">Activate</button>
                                    @endif
                                    <button class="btn btn-info  save-payment-item btn-text-trigger-update" type="submit">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    </tbody>

                    <tbody>
                    <tr>
                        <td colspan="3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="payment-name-label-group">
                                        Use
                                        <span class="method-name-label">Bank transfer</span>
                                    </div>
                                </div>

                                <button class="btn close-btn  toggle-payment-item edit-payment-item-btn-trigger" id="edit-payment-transfer-btn-trigger" type="button">Edit</button>

                            </div>
                        </td>
                    </tr>
                    <tr id="payment-content-transfer" class="payment-content-item ">
                        <td colspan="3">
                            <form method="POST" action="{{route('payment-methods.update')}}" accept-charset="UTF-8">
                                @csrf
                                <input class="payment_type" name="type" type="hidden" value="bank_transfer">
                                <div class="mb-3 position-relative">
                                    <label for="payment_bank_transfer_name" class="form-label">Method name</label>
                                    <input class="form-control"  name="payment_bank_transfer_name" type="text" value="{{$bankTransferSettings['payment_bank_transfer_name']}}" id="payment_bank_transfer_name">
                                </div>
                                <div class="mb-3 position-relative" style="max-width: 99.8%">
                                    <label for="payment_bank_transfer_description" class="form-label">Payment guide - (Displayed on the notice of successful purchase and payment page)</label>


                                    <textarea class="form-control form-control editor-ckeditor ays-ignore summernote" data-counter="100000" rows="4" id="payment_bank_transfer_description" name="payment_bank_transfer_description" cols="50">
                                            {{$bankTransferSettings['payment_bank_transfer_description']}}
                                        </textarea>

                                </div>

                                <div class="mb-3 position-relative">

                                    <input type="hidden" name="payment_bank_transfer_display_bank_info" value="0">

                                    <label class="form-check">
                                        <input type="checkbox" id="payment_bank_transfer_display_bank_info" name="payment_bank_transfer_display_bank_info" class="form-check-input" value="1" {{$bankTransferSettings['payment_bank_transfer_display_bank_info'] == 1 ?'checked':''}}>

                                        <span class="form-check-label">
                                                Display bank info at the checkout success page?
                                            </span>

                                    </label>
                                </div>

                                <div class="btn-list justify-content-end d-flex gap-2">
                                    @if($bankTransferSettings['status'] == 1)

                                        <button class="btn close-btn active-toggle" data-status="0" data-type="bank_transfer" type="button">Deactivate</button>
                                    @endif
                                    @if($bankTransferSettings['status'] == 0)
                                        <button class="btn btn-info  btn-text-trigger-save active-toggle" data-status="1" data-type="bank_transfer" type="button">Activate</button>
                                    @endif
                                    <button class="btn btn-info  save-payment-item btn-text-trigger-update" type="submit">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection







@section('script')
<script>
    $('.active-toggle').on('click',function (){
        var type = $(this).data('type')
        var status = $(this).data('status')

        $.ajax({
            url:'{{route('payment-methods.updateStatus')}}',
            type:'post',
            data :{type:type,status:status},
            dataType:'json',
            success:function (response){
                if (response.status ==true){
                    window.location.href="{{route('payment_methods.index')}}";
                }

            },
            error:function (){
                console.log('something went wrong')
            }
        })
    })

    $('#edit-payment-stripe-btn-trigger').on('click',function (){
        $('#payment-stripe-content').fadeToggle('slow')
    })
    $('#edit-payment-cod-btn-trigger').on('click',function (){
        $('#payment-content-cod').fadeToggle('slow')
    })
    $('#edit-payment-transfer-btn-trigger').on('click',function (){
        $('#payment-content-transfer').fadeToggle('slow')
    })
    $('#edit-payment-paypal-btn-trigger').on('click',function (){
        $('#payment-content-paypal').fadeToggle('slow')
    })
</script>
@endsection
