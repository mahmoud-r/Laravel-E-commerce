@extends('front.layouts.app')
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{ __('Verify Your Email Address') }}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ __('Verify Your Email Address') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection

@section('content')

    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>{{ __('Verify Your Email Address') }}</h3>
                            </div>
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{--{{ route('verification.resend') }} --}}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-link p-0 m-0 align-baseline text-primary">{{ __('click here to request another') }}</button>
                                .
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
