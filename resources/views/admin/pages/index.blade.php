@extends('admin.master')


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('pages.index')}}">Pages</a></li>
    <li class="breadcrumb-item active">list</li>
@endsection
@section('title')Pages @endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pages</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @can('pages-home-page')
                    <tr>
                        <td>1</td>
                        <td><a href="{{route('pages.home')}}">Home Page</a></td>
                        <td>
                            <a href="{{route('pages.home')}}">
                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endcan

                    @can('pages-home-banners')
                    <tr>
                        <td>2</td>
                        <td><a href="{{route('pages.HomeBanners')}}">Home Banners</a></td>

                        <td>
                            <a href="{{route('pages.HomeBanners')}}">
                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endcan

                    @can('pages-home-slider')
                    <tr>
                        <td>3</td>
                        <td><a href="{{route('HomeSlider.index')}}">Home Slider</a></td>

                        <td>
                            <a href="{{route('HomeSlider.index')}}">
                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endcan

                    @can('pages-contact-page')
                    <tr>
                        <td>4</td>
                        <td><a href="{{route('pages.contactPage')}}">Contact Page</a></td>

                        <td>
                            <a href="{{route('pages.contactPage')}}">
                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endcan

                    @can('pages-about-page')
                    <tr>
                        <td>5</td>
                        <td><a href="{{route('pages.aboutPage')}}">About Page</a></td>

                        <td>
                            <a href="{{route('pages.aboutPage')}}">
                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endcan

                    @can('pages-term-condition-page')
                    <tr>
                        <td>6</td>
                        <td><a href="{{route('pages.termConditionPage')}}">term & Condition</a></td>

                        <td>
                            <a href="{{route('pages.termConditionPage')}}">
                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endcan
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection







@section('script')


@endsection
