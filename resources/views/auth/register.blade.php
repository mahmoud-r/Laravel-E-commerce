@extends('front.layouts.app')
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Create an Account</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Create an Account</li>
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
                                <h3>Create an Account</h3>
                            </div>
                            <form method="post" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text"  value="{{ old('name') }}" class="@error('name') is-invalid @enderror form-control" required=""   name="name" placeholder="Enter Your Name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" autocomplete="email"  value="{{ old('email') }}" class="@error('email') is-invalid @enderror form-control"  required=""  name="email" placeholder="Enter Your Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" autocomplete="phone"  value="{{ old('phone') }}" class="@error('phone') is-invalid @enderror form-control"  required=""  name="phone" placeholder="Enter Your Phone Number">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }} </strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input   value="{{ old('password') }}" class="@error('password') is-invalid @enderror form-control" required="" type="password" name="password" placeholder="Password" autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <input   class="@error('password') is-invalid @enderror form-control" required="" type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="login_footer form-group mb-3">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                            <label class="form-check-label" for="exampleCheckbox2"><span>I agree to terms &amp; Policy.</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="register">Register</button>
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
                            <div class="form-note text-center">Already have an account? <a href="{{route('login')}}">Log in</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->
@endsection
