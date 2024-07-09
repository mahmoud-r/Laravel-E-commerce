@extends('admin.master')

@section('title')Settings - General @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('settings.index')}}">Settings</a></li>
    <li class="breadcrumb-item active">General</li>
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
            <h2>General</h2>
            <p class="text-muted">View and update your Shop settings</p>
        </div>

        <div class="col-12 col-md-9 mt-5">

                <div class="card">
                    <div class="card-body">
                        <div class="row row-cols-lg-12">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="logo">Logo</label>
                                    <div id="logo" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            @if(!empty(get_setting('store_logo')))
                                                <div>
                                                    <img src="{{asset('uploads/site/images/'.get_setting('store_logo'))}}" alt="{{get_setting('store_name')}}">
                                                </div>
                                            @else
                                                <img src="{{asset('/front_assets/images/logo_dark.png')}}" alt="{{get_setting('store_name')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="logo_white">Logo White</label>
                                    <div id="logo_white" class="dropzone dz-clickable" style="background-color: #3a4859">
                                        <div class="dz-message needsclick">
                                            @if(!empty(get_setting('store_logo_white')))
                                                <div>
                                                    <img src="{{asset('uploads/site/images/'.get_setting('store_logo_white'))}}" alt="{{get_setting('store_name')}}">
                                                </div>
                                            @else
                                                <img src="{{asset('/front_assets/images/logo_light.png')}}" alt="{{get_setting('store_name')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="favicon_icon">favicon icon</label>
                                    <div id="favicon_icon" class="dropzone dz-clickable" >
                                        <div class="dz-message needsclick">
                                            @if(!empty(get_setting('favicon_icon')))
                                                <div>
                                                    <img src="{{asset('uploads/site/images/'.get_setting('favicon_icon'))}}" alt="{{get_setting('store_name')}}">
                                                </div>
                                            @else
                                                <div>
                                                    <img src="{{asset('/front_assets/images/favicon.png')}}" alt="{{get_setting('store_name')}}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <form class="form mb-5" method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="row row-cols-lg-6">
                            <div class="col-lg-6">
                                <div class="mb-3 position-relative">
                                    <label for="store_name" class="form-label">Shop name </label>
                                    <input class="form-control" placeholder="Shop name" data-counter="60" name="store_name" type="text" value="{{get_setting('store_name')}}" id="store_name">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 position-relative">
                                    <label for="store_phone" class="form-label">Store Phone</label>
                                    <input class="form-control" placeholder="01xxxxxxxxx" data-counter="60" name="store_phone" type="text" value="{{ get_setting('store_phone') }}" id="store_phone">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 position-relative">
                                    <label for="store_email" class="form-label">Store Email</label>
                                    <input class="form-control" placeholder="admin@example.com" data-counter="60" name="store_email" type="email" value="{{ get_setting('store_email')}}" id="store_email">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 position-relative">
                                    <label for="store_address" class="form-label">Store Address</label>
                                    <input class="form-control" placeholder="Store Address" data-counter="60" name="store_address" type="text" value="{{ get_setting('store_address')}}" id="store_address">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3 position-relative">
                                    <label for="store_description" class="form-label">Store Description</label>
                                    <textarea class="form-control" placeholder="Store Description" data-counter="60" name="store_description" type="text"  id="store_description">{{ get_setting('store_description')}}</textarea>
                                    <p class="error"></p>
                                </div>
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
                            Save settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection







@section('script')
    <script>
        $('.form').submit(function (e){
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
                        $("input[type='text'],input[type='number'],select,textarea,input[type='email']").removeClass('is-invalid')

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
            $("input[type='text'],input[type='number'],select,textarea,input[type='email']").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });}

        Dropzone.autoDiscover = false;
        $("#logo").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url:  "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: false,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                var inputs = {};
                inputs['store_logo'] = response.image_id;
                setSettings(inputs)

            }
        });

         $("#logo_white").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url:  "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: false,
             acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                 var inputs = {};
                 inputs['store_logo_white'] = response.image_id;
                 setSettings(inputs)
            }
        });
         $("#favicon_icon").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url:  "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: false,
             acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                 var inputs = {};
                 inputs['favicon_icon'] = response.image_id;
                 setSettings(inputs)
            }
        });

    </script>
@endsection
