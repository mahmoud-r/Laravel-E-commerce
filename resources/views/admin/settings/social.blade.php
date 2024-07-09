@extends('admin.master')
@section('title')Settings - Social links @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('settings.index')}}">Settings</a></li>
    <li class="breadcrumb-item active">Social links</li>
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
            <h2>Social links</h2>
            <p class="text-muted">View and update your Social links </p>
        </div>

        <div class="col-12 col-md-9 mt-5">
            <form id="socialForm" method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 position-relative">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input class="form-control" placeholder="https://www.facebook.com"  name="facebook" type="text" value="{{ get_setting('facebook')}}" id="facebook">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="x" class="form-label">x</label>
                            <input class="form-control" placeholder="https://x.com"  name="x" type="text" value="{{get_setting('x')}}" id=x">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="x" class="form-label">instagram</label>
                            <input class="form-control" placeholder="https://instagram.com"  name="instagram" type="text" value="{{get_setting('instagram')}}" id=instagram">
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="youtube" class="form-label">youtube</label>
                            <input class="form-control" placeholder="https://youtube.com"  name="youtube" type="text" value="{{get_setting('youtube')}}" id=youtube">
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
