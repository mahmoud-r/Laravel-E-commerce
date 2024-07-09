@extends('admin.master')
@section('title')Settings - Social Login @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('settings.index')}}">Settings</a></li>
    <li class="breadcrumb-item active">Social Login Api</li>
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
        .card-header {
            border-bottom: 1px solid rgba(4, 32, 69, .1);
        }
    </style>
@endsection



@section('content')
    <div class="row mb-5 d-block d-md-flex">
        <div class="col-12 col-md-3 mt-5">
            <h2>Social Login Api</h2>
            <p class="text-muted">Configure social login options .</p>
        </div>

        <div class="col-12 col-md-9 mt-5">
            <form id="facebookLoginForm" method="post">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Facebook</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 position-relative">
                            <input type="hidden" name="facebook_redirect" value="{{route('handleFacebookCallback')}}">

                            <label for="facebook_client_id" class="form-label">Facebook client id</label>
                            <input class="form-control" placeholder="Facebook client id"  name="facebook_client_id" type="text" value="{{ get_setting('facebook_client_id')}}" id="facebook_client_id">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="facebook_client_secret" class="form-label">Facebook Secret</label>
                            <input class="form-control" placeholder="Facebook Secret"   name="facebook_client_secret" type="password" value="*************" id=facebook_client_secret">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="facebook_login_status" value="0">
                                <input type="checkbox" class="custom-control-input form-switch " value="1" {{ get_setting('facebook_login_status') =='1' ?'checked':''}} name="facebook_login_status" id="facebook_login_status">
                                <label class="custom-control-label" for="facebook_login_status">Enable Facebook Login</label>
                                <p class="error"></p>

                            </div>
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
            <form id="googleLoginForm" class="mt-5 mb-5" method="post">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Google</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 position-relative">
                            <input type="hidden" name="google_redirect" value="{{route('handleGoogleCallback')}}">
                            <label for="google_client_id" class="form-label">Google client id</label>
                            <input class="form-control" placeholder="Google client id"  name="google_client_id" type="text" value="{{ get_setting('google_client_id')}}" id="google_client_id">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="google_client_secret" class="form-label">Google Secret</label>
                            <input class="form-control" placeholder="Google Secret"  name="google_client_secret" type="password" value="*************" id=google_client_secret">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <div class="custom-control custom-switch">
                                <input type="hidden" name="google_login_status" value="0">
                                <input type="checkbox" class="custom-control-input form-switch " value="1" {{ get_setting('google_login_status') =='1' ?'checked':''}} name="google_login_status" id="google_login_status">
                                <label class="custom-control-label" for="google_login_status">Enable Google Login</label>
                                <p class="error"></p>

                            </div>
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

@endsection







@section('script')
    <script>

        $('#facebookLoginForm').submit(function (e){
            e.preventDefault();
            var inputs =$(this).serializeArray();

            setSettings(inputs)
        });
        $('#googleLoginForm').submit(function (e){
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
