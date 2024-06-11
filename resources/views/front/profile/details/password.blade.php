@extends('front.layouts.app')


@section('title')@endsection

@section('style')
    <style>
        .nav-tabs {
            padding-bottom: 15px;
        }
        .nav-tabs .nav-item {
            flex: none;
        }
        .nav-tabs .nav-item .nav-link {
            background-color: #f8f8f8;
            border-radius: 0;
            color: var(--text-primary);
            margin: unset;
            padding: 5px 10px;
            width: auto;
        }
        .dashboard_content .nav-tabs .nav-item .nav-link {
            padding: 10px 20px !important;
        }
        .nav-tabs .nav-item .nav-link.active {
            background-color: var(--text-primary);
            color: #fff;
        }

    </style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Change Password</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.profile')}}">My Account</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                @include('front.profile.menu')
                <div class="col-lg-9 col-md-8">
                    <div class=" dashboard_content">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{route('front.accountDetail')}}" class="nav-link " role="tab" aria-controls="profile-tab-pane" aria-selected="true"> Profile </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{route('front.change-password')}}" class="nav-link active" role="tab" aria-controls="change-password-tab-pane" aria-selected="false"> Change Password </a>
                            </li>
                        </ul>

                        <div class="row" >
                            <div class="card">
                                <div class="card-header">
                                    <h3>Change Password</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{route('front.changePassword')}}">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-3">
                                                <label>Current Password <span class="required">*</span></label>
                                                <input required="" class="form-control" name="password" type="password">
                                            </div>
                                            <div class="form-group col-md-12 mb-3">
                                                <label>New Password <span class="required">*</span></label>
                                                <input required="" class="form-control @error('newpassword') is-invalid @enderror " name="newpassword" type="password">
                                                @error('newpassword')
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-12 mb-3">
                                                <label>Confirm Password <span class="required">*</span></label>
                                                <input required="" class="form-control @error('newpassword_confirmation') is-invalid @enderror" name="newpassword_confirmation" type="password">
                                                @error('newpassword_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

@endsection
@section('script')

@endsection




