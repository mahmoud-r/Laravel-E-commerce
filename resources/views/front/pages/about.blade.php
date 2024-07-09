@extends('front.layouts.app')

@section('title', $aboutPage['title'])
@section('og_title',$aboutPage['title'])
@section('og_url', url()->current())

@section('twitter_title',$aboutPage['title'])


@section('style')
<style>
    .why-choose-us .icon_box_style4 .icon {
        background-color: #FF324D;
        width: 60px;
        height: 60px;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center
    }
   .why-choose-us .icon_box{
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
</style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>{{$aboutPage['title']}}</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">{{$aboutPage['title']}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')

    <!-- STAT SECTION ABOUT -->
    <div class="section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about_img scene mb-4 mb-lg-0">
                        <img src="{{asset('uploads/pages/images/'.$aboutPage['section1']['img'])}}" alt="{{$aboutPage['section1']['title']}}" title="{{$aboutPage['section1']['title']}}" aria-label="{{$aboutPage['section1']['title']}}" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="heading_s1">
                        <h2>{{$aboutPage['section1']['title']}}</h2>
                    </div>
                    {{$aboutPage['section1']['description']}}
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION ABOUT -->

    <!-- START SECTION WHY CHOOSE -->
    <div class="section bg_light_blue2 pb_70 why-choose-us">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="heading_s1 text-center">
                        <h2>{{$aboutPage['section2']['title']}}</h2>
                    </div>
                    <p class="text-center leads"> {{$aboutPage['section2']['description']}}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                @forelse($aboutPage['section2']['subsections'] as  $key=>$box)
                    <div class="col-lg-4 col-sm-6">
                        <div class="icon_box icon_box_style4 box_shadow1">
                            <div class="icon">
                                <img src="{{asset('uploads/pages/images/'.$box['icon'])}}" alt="{{$box['title']}}" title="{{$box['title']}}" aria-label="{{$box['title']}}" />

                            </div>
                            <div class="icon_box_content">
                                <h5>{{$box['title']}}</h5>
                                <p>{{$box['description']}}</p>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    </div>
    <!-- END SECTION WHY CHOOSE -->

@endsection
@section('script')

@endsection


