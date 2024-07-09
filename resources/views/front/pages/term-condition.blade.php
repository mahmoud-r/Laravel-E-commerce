@extends('front.layouts.app')

@section('title', $Page['title'])
@section('og_title',$Page['title'])
@section('og_url', url()->current())

@section('twitter_title',$Page['title'])


@section('style')
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{$Page['title']}}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$Page['title']}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')

    <!-- STAT SECTION term & Condition -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="term_conditions">
                        {!! $Page['content'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION term & Condition -->
@endsection
@section('script')

@endsection


