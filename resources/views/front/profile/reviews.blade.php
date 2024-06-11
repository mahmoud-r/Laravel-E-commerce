

@extends('front.layouts.app')


@section('title')@endsection

@section('style')
    <style>
        .dashboard_content td, .dashboard_content th {
            border: 1px solid #dee2e6 !important;
        }
        .table td, .table th {
            padding: .75rem !important;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .dashboard_content thead td, .dashboard_content thead th {
            border-bottom-width: 2px;
        }

    </style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Reviews</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.profile')}}">My Account</a></li>
                        <li class="breadcrumb-item active" >Reviews</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h3>Reviews</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Star</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($reviews as $i=> $review)

                                            <tr >
                                                <td>{{ $i+1 }}</td>
                                                <td style="white-space: normal;"><a href="{{route('front.product',$review->product->slug)}}">{{$review->product->title}}</a></td>
                                                <td>{{\carbon\Carbon::parse($review->created_at)->format('d M,Y')}}</td>

                                                <td>
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:{{$review->rating_percentage}}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="white-space: normal;">{{$review->comment}}</td>
                                                <td>
                                                    @if($review->status == 1 )

                                                        <span class="badge bg-success text-success-fg">Published</span>
                                                    @else
                                                        <span class="badge bg-secondary text-secondary-fg">Waiting</span>
                                                    @endif
                                                </td>


                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center"> No reviews!</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>

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
@section('script')@endsection





