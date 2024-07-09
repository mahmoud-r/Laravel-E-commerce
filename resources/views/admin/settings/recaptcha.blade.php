@extends('admin.master')
@section('title')Settings - Recaptcha @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('settings.index')}}">Settings</a></li>
    <li class="breadcrumb-item active">Recaptcha v3 Api</li>
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
            <h2>Recaptcha v3 Api</h2>
            <p class="text-muted">Obtain your Google reCAPTCHA credentials <a href="https://www.google.com/recaptcha/admin#list">here</a>.</p>
        </div>

        <div class="col-12 col-md-9 mt-5">
            <form id="socialForm" method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 position-relative">
                            <label for="recaptcha_site_key" class="form-label">Recaptcha Site Key</label>
                            <input class="form-control" placeholder="Recaptcha Site Key"  name="recaptcha_site_key" type="text" value="{{ get_setting('recaptcha_site_key')}}" id="recaptcha_site_key">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="recaptcha_secret" class="form-label">Recaptcha Secret</label>
                            <input class="form-control" placeholder="Recaptcha Secret"  name="recaptcha_secret" type="text" value="{{get_setting('recaptcha_secret')}}" id=recaptcha_secret">
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


@endsection







@section('script')
    <script>

        $('#socialForm').submit(function (e){
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
