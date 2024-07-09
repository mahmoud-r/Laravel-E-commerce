@extends('front.layouts.app')
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{ __('Login') }}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{ __('Login') }}</li>
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
                <div class="col-xl-6 col-md-10">
                    <div class="login_wrap">
                        <div class="padding_eight_all bg-white">
                            <div class="heading_s1">
                                <h3>{{ __('Login') }}</h3>
                            </div>
                            <form method="post" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input id="email" type="text"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{  old('email')}}" required autocomplete="email" autofocus  placeholder="Your Email or Your Phone ">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"  name="password"
                                           required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="login_footer form-group mb-3">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox"    id="remember" {{ old('remember') ? 'checked' : '' }} >
                                            <label class="form-check-label" for="remember"><span> {{ __('Remember Me') }}</span></label>
                                        </div>
                                    </div>
                                    <a href="{{ route('password.request') }}">Forgot password?</a>
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="login">  {{ __('Login') }}</button>
                                </div>
                            </form>
                            @if(config('services.facebook.status') == '1' || config('services.google.status') == '1')
                            <div class="different_login">
                                <span> or</span>
                            </div>
                            <ul class="btn-login list_none text-center">
                                @if(config('services.facebook.status') == '1')
                                <li><a href="{{route('redirectToFacebook') }}" class="btn btn-facebook"><i class="ion-social-facebook"></i>Facebook</a></li>
                                @endif
                                @if(config('services.google.status') == '1')
                                <li><a href="{{ route('redirectToGoogle') }}" class="btn btn-google"><i class="ion-social-googleplus"></i>Google</a></li>
                                 @endif
                            </ul>
                            @endif
                            <div class="form-note text-center">Don't Have an Account? <a href="{{route('register')}}">Register now</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
