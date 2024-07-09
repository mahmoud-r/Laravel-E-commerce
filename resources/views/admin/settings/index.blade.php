@extends('admin.master')

@section('title')Settings @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Settings</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><a style="color: black" href="">Settings</a></h1>
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>
    </section>
@endsection


@section('style')
<style>
    .card-header {
        border-bottom: 1px solid rgba(4,32,69,.1);
        margin-bottom: 0;
        padding: 1rem 1.25rem;
    }
    .panel-section .panel-section-item .panel-section-item-icon {
        background-color: #f6f8fb;
        border-radius: 4px;
        height: 40px;
        padding: 4px;
        width: 40px;
    }
    .panel-section .panel-section-item .panel-section-item-icon .icon {
        color: #8a97ab;
    }

</style>
@endsection

@section('header_button')

@endsection


@section('content')
    <div class="container-fluid">
        <div class="card mb-4 panel-section panel-section-settings.common panel-section-priority-0" id="panel-section-settings-settings.common" data-priority="0" data-id="settings.common" data-group-id="settings">
            <div class="card-header">
                <div>
                    <h4 class="card-title">
                        Common
                    </h4>

                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    @can('settings-general')
                      <div class="col-12 col-sm-6 col-md-4 panel-section-item mt-3">
                        <div class="row g-3 align-items-start">
                            <div class="col-auto">
                                <div class="d-flex align-items-center justify-content-center panel-section-item-icon">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                    </svg>            </div>
                            </div>
                            <div class="col">
                                <div class="d-block mb-1 panel-section-item-title">
                                    <a class="text-decoration-none text-primary fw-bold" href="{{route('settings.general')}}">

                                        General

                                    </a>
                                </div>

                                <div class="text-secondary mt-n1">View and update your general settings.</div>
                            </div>
                        </div>
                    </div>
                    @endcan

                     @can('settings-payment-methods')
                      <div class="col-12 col-sm-6 col-md-4 panel-section-item mt-3">
                        <div class="row g-3 align-items-start">
                            <div class="col-auto">
                                <div class="d-flex align-items-center justify-content-center panel-section-item-icon">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                        <path d="M3 10l18 0"></path>
                                        <path d="M7 15l.01 0"></path>
                                        <path d="M11 15l2 0"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-block mb-1 panel-section-item-title">
                                    <a class="text-decoration-none text-primary fw-bold" href="{{route('payment_methods.index')}}">

                                        Payment Methods

                                    </a>
                                </div>

                                <div class="text-secondary mt-n1">View and update your Payment Methods.</div>
                            </div>
                        </div>
                    </div>
                     @endcan

                     @can('settings-email')
                    <div  class="col-12 col-sm-6 col-md-4 panel-section-item mt-3">
                        <div class="row g-3 align-items-start">
                            <div class="col-auto">
                                <div class="d-flex align-items-center justify-content-center panel-section-item-icon">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                        <path d="M3 7l9 6l9 -6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-block mb-1 panel-section-item-title">
                                    <a class="text-decoration-none text-primary fw-bold" href="{{route('settings.email')}}">
                                        Email
                                    </a>
                                </div>

                                <div class="text-secondary mt-n1">View and update your email settings </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                     @can('settings-social')
                    <div  class="col-12 col-sm-6 col-md-4 panel-section-item mt-3">
                        <div class="row g-3 align-items-start">
                            <div class="col-auto">
                                <div class="d-flex align-items-center justify-content-center panel-section-item-icon">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M5 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M19 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M12 14m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        <path d="M12 7l0 4"></path>
                                        <path d="M6.7 17.8l2.8 -2"></path>
                                        <path d="M17.3 17.8l-2.8 -2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-block mb-1 panel-section-item-title">
                                    <a class="text-decoration-none text-primary fw-bold" href="{{route('settings.social')}}">
                                        Social links
                                    </a>
                                </div>

                                <div class="text-secondary mt-n1">View and update your Social links.</div>
                            </div>
                        </div>
                    </div>
                    @endcan

                     @can('settings-social-login')
                    <div  class="col-12 col-sm-6 col-md-4 panel-section-item mt-3">
                        <div class="row g-3 align-items-start">
                            <div class="col-auto">
                                <div class="d-flex align-items-center justify-content-center panel-section-item-icon">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 5m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M5 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M19 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M12 14m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                        <path d="M12 7l0 4"></path>
                                        <path d="M6.7 17.8l2.8 -2"></path>
                                        <path d="M17.3 17.8l-2.8 -2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-block mb-1 panel-section-item-title">
                                    <a class="text-decoration-none text-primary fw-bold" href="{{route('settings.social_login')}}">
                                        Social Login
                                    </a>
                                </div>

                                <div class="text-secondary mt-n1">Enable and update your Social Login.</div>
                            </div>
                        </div>
                    </div>
                     @endcan

                     @can('settings-recaptcha')
                    <div  class="col-12 col-sm-6 col-md-4 panel-section-item mt-3">
                        <div class="row g-3 align-items-start">
                            <div class="col-auto">
                                <div class="d-flex align-items-center justify-content-center panel-section-item-icon">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-block mb-1 panel-section-item-title">
                                    <a class="text-decoration-none text-primary fw-bold" href="{{route('settings.recaptcha')}}">
                                        Recaptcha
                                    </a>
                                </div>

                                <div class="text-secondary mt-n1">View and update your Recaptcha v3 Api.</div>
                            </div>
                        </div>
                    </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
@endsection







@section('script')

@endsection
