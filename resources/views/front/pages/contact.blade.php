@extends('front.layouts.app')

@section('title', $contactPage['title'])
@section('og_title',$contactPage['title'])
@section('og_url', url()->current())

@section('twitter_title',$contactPage['title'])


@section('style')
    <!-- Google Map Js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTxj-OuCytjZNOXF91Cabzy4NfxIhUAvw"></script>
    {!! RecaptchaV3::initJs() !!}

    <style>
    #alert-msg{
        display: none;
    }
</style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{$contactPage['title']}}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$contactPage['title']}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')

    <!-- START SECTION CONTACT -->
    <div class="section pb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-map2"></i>
                        </div>
                        <div class="contact_text">
                            <span>Address</span>
                            <p>{{!empty($contactPage['address']) ? $contactPage['address'] :  get_setting('store_address')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-envelope-open"></i>
                        </div>
                        <div class="contact_text">
                            <span>Email Address</span>
                            @php
                              $email = !empty($contactPage['email']) ? $contactPage['email'] :  get_setting('store_email')
                            @endphp
                            <a href="to:{{$email}}" title="{{$email}}" aria-label="{{$email}}">{{$email}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-tablet2"></i>
                        </div>
                        <div class="contact_text">
                            <span>Phone</span>
                            <p>{{!empty($contactPage['phone']) ? $contactPage['phone'] :  get_setting('store_phone')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION CONTACT -->

    <!-- START SECTION CONTACT -->
    <div class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="heading_s1">
                        <h2>{{$contactPage['form_title']}}</h2>
                    </div>
                    <p class="leads">{{$contactPage['description']}}</p>
                    <div class="field_form">
                        <form method="post" name="ContactForm" id="ContactForm">
                            {!! RecaptchaV3::field('recaptcha') !!}
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                    <input required placeholder="Enter Name *" id="name" class="form-control" name="name" type="text">
                                    <p class="error"></p>
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <input required placeholder="Enter Email *" id="email" class="form-control" name="email" type="email">
                                    <p class="error"></p>
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <input required placeholder="Enter Phone No. " id="phone" class="form-control" name="phone">
                                    <p class="error"></p>
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                    <input  required placeholder="Enter Subject" id="subject" class="form-control" name="subject">
                                    <p class="error"></p>
                                </div>
                                <div class="form-group col-md-12 mb-3">
                                    <textarea required placeholder="Message *" id="message" class="form-control" name="message" rows="4"></textarea>
                                    <p class="error"></p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" title="Submit Your Message!"  class="btn btn-fill-out" id="submitButton" name="submit" value="recaptcha">Send Message</button>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div id="alert-msg" class="alert-msg text-center alert alert-success " ></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 pt-2 pt-lg-0 mt-4 mt-lg-0">
                    <div id="map" class="contact_map2" data-zoom="{{$contactPage['zoom']}}" data-latitude="{{$contactPage['map_latitude']}}" data-longitude="{{$contactPage['map_longitude']}}" data-icon="{{asset('front_assets/images/marker.png')}}"></div>

                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION CONTACT -->

@endsection
@section('script')
<script>
    //create product

    $('#ContactForm').submit(function (e){
        e.preventDefault();
        var formArray =$(this).serializeArray();

        $.ajax({
            url:'{{route('front.storeContactForm')}}',
            type : 'post',
            data:formArray,
            dataType:'json',
            success:function (response){
                if(response.status == true){

                    $('.error').removeClass('invalid-feedback').html('');

                    $('.form-control').removeClass('is-invalid')
                    $('.form-control').val('');
                    $('#alert-msg').show()
                    $('#alert-msg').html(response.msg)


                }else {
                    handleErrors(response.errors);
                }

            },error:function (xhr, status, error){
                var response = JSON.parse(xhr.responseText);
                handleErrors(response.errors);

            }
        })
    });
    function handleErrors(errors) {
        $('.error').removeClass('invalid-feedback').html('');
        $(".form-control").removeClass('is-invalid');
        $('#alert-msg').hide()
        $('#alert-msg').html('')
        $.each(errors, function (key, value) {

            if (key === 'g-recaptcha-response'){
                $('#alert-msg').removeClass('alert-success').addClass('alert-danger')
                $('#alert-msg').show()
                $('#alert-msg').html(value)
            }else {
                $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            }

        });}



</script>
@endsection


