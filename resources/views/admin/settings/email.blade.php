@extends('admin.master')

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('settings.index')}}">Settings</a></li>
    <li class="breadcrumb-item active">Email</li>
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
            <h2>Email</h2>
            <p class="text-muted">View and update your email settings</p>
        </div>

        <div class="col-12 col-md-9 mt-5">
            <form id="emailForm" method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 position-relative">
                            <label for="email_from_name" class="form-label">Sender name</label>
                            <input class="form-control" placeholder="Name" data-counter="60" name="email_from_name" type="text" value="{{ get_setting('email_from_name')}}" id="email_from_name">
                            <p class="error"></p>
                        </div>
                        <div class="mb-0">
                            <label for="email_from_address" class="form-label">Sender email</label>
                            <input class="form-control" placeholder="admin@example.com" data-counter="60" name="email_from_address" type="email" value="{{get_setting('email_from_address')}}" id="email_from_address">
                            <p class="error"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-9 ">
                        <button class="btn btn-primary" type="submit" >
                            <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M14 4l0 4l-6 0l0 -4"></path>
                            </svg>
                            Save settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-5 d-block d-md-flex">
        <div class="col-12 col-md-3 mt-5">
            <h2>Email status</h2>
            <p class="text-muted">Turn on/off email</p>
        </div>

        <div class="col-12 col-md-9 mt-5">
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        <h4 class="card-title">
                            User
                        </h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th class="w-25">Email</th>
                            <th>Description</th>
                            <th class="text-end"> Operations</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Registered</span>
                            </td>
                            <td>Send email to user when Register a new account </td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" {{get_setting('email_user_register') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  name="email_user_register" id="email_user_register">
                                    <label class="custom-control-label" for="email_user_register"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Order confirmation</span>
                            </td>
                            <td>Send email confirmation to customer when an order placed</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="email_user_new_order" id="email_user_new_order" {{get_setting('email_user_new_order') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  >
                                    <label class="custom-control-label" for="email_user_new_order"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Order confirmation</span>
                            </td>
                            <td>Send email to customer when they order was confirmed by admins</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="email_user_confirm_order" id="email_user_confirm_order" {{get_setting('email_user_confirm_order') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  >
                                    <label class="custom-control-label" for="email_user_confirm_order"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Order Delivering	</span>
                            </td>
                            <td>Send email to customer when their Order Delivering</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="email_user_order_delivering" id="email_user_order_delivering" {{get_setting('email_user_order_delivering') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  >
                                    <label class="custom-control-label" for="email_user_order_delivering"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Delivering confirmation</span>
                            </td>
                            <td>Send email to customer when order is delivering</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="email_user_order_delivering" id="email_user_order_delivering" {{get_setting('email_user_order_delivering') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  >
                                    <label class="custom-control-label" for="email_user_order_delivering"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Review Products</span>
                            </td>
                            <td>Send a notification to the customer to review the products when the order is completed</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="email_user_review_when_order_completed" id="email_user_review_when_order_completed" {{get_setting('email_user_review_when_order_completed') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  >
                                    <label class="custom-control-label" for="email_user_review_when_order_completed"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Review Products</span>
                            </td>
                            <td>Send a notification to the customer when write a Review</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="email_user_new_review" id="email_user_new_review" {{get_setting('email_user_new_review') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  >
                                    <label class="custom-control-label" for="email_user_new_review"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Review confirmation</span>
                            </td>
                            <td>Send a notification to the customer when his review is confirmed</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="email_user_confirm_review" id="email_user_confirm_review" {{get_setting('email_user_confirm_review') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  >
                                    <label class="custom-control-label" for="email_user_confirm_review"></label>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        <h4 class="card-title">
                            Admin
                        </h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                        <tr>
                            <th class="w-25">Email</th>
                            <th>Description</th>
                            <th class="text-end"> Operations</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Notice about new user</span>
                            </td>
                            <td>Send email to administrators when user Register a new account </td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" {{get_setting('email_user_register_admin') == true ?'checked':''}} class="custom-control-input form-switch " value="1"  name="email_user_register_admin" id="email_user_register_admin">
                                    <label class="custom-control-label" for="email_user_register_admin"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Notice about new order</span>
                            </td>
                            <td>Send email  to administrators when an order placed</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"  name="email_user_new_order_admin" id="email_user_new_order_admin" {{get_setting('email_user_new_order_admin') == true ?'checked':''}} class="custom-control-input form-switch " value="1" >
                                    <label class="custom-control-label" for="email_user_new_order_admin"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="template-name w-25">
                                <span class="">Notice about new Review</span>
                            </td>
                            <td>Send email to administrators when customer write new Review</td>

                            <td class="text-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"  name="email_user_new_review_admin" id="email_user_new_review_admin" {{get_setting('email_user_new_review_admin') == true ?'checked':''}} class="custom-control-input form-switch " value="1" >
                                    <label class="custom-control-label" for="email_user_new_review_admin"></label>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection







@section('script')
    <script>
        $('.form-switch').on('change',function () {
            var value = $(this).is(':checked') ? 1 : 0;
            var key = $(this).attr('name');
            var inputs = {};
            inputs[key] = value;
            setSettings(inputs)
        })
        $('#emailForm').submit(function (e){
            e.preventDefault();
            var inputs =$(this).serializeArray();

            setSettings(inputs)
        });

        function setSettings(inputs){
            $.ajax({
                url:'{{Route('settings.store')}}',
                type:'put',
                data:inputs,
                dataType:'json',
                success:function (response){
                    if(response['status'] === true){

                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        })

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')

                    }else {
                        handleErrors(response.errors);

                    }


                },error:function (xhr){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);
                }
            })
        }
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });}
    </script>
@endsection
