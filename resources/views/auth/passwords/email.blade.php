@extends('front.layouts.app')
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{ __('Reset Password') }}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ __('Reset Password') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection

@section('content')
    <!-- START LOGIN SECTION -->
    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>{{ __('Reset Password') }}</h3>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="post" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="email" autocomplete="email"  value="{{ old('email') }}" class="@error('email') is-invalid @enderror form-control"  required=""  name="email" placeholder="Enter Your Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-fill-out btn-block" >{{ __('Send Password Reset Link') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->
@endsection
