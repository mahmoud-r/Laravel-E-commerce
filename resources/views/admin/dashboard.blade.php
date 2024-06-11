@extends('admin.master')


@section('style')
<style>
    .dashboard-widget-item .details {
        height: 9rem;
    }
    .dashboard-widget-item .details .desc {
        font-size: 18px;
        letter-spacing: 0;
    }
    .fw-medium {
        font-weight: 500 !important;
    }
    .dashboard-widget-item .details .number {
        font-size: 40px;
        line-height: 65px;
    }
    .fw-bolder {
        font-weight: bolder !important;
    }
    .ps-1 {
        padding-left: .25rem !important;
    }
    .end-0 {
        right: 0 !important;
    }
    .position-absolute {
        position: absolute !important;
    }
    .icon {
        --bb-icon-size: 1.25rem;
        stroke-width: 1.5;
        font-size: var(--bb-icon-size);
        height: var(--bb-icon-size);
        vertical-align: bottom;
        width: var(--bb-icon-size);
    }
</style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row row-cards">
                <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                    <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none" href="{{route('orders.index')}}" style="background-color: rgb(50, 197, 210);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                <div class="desc fw-medium">Orders</div>
                                <div class="number fw-bolder">
                                    <span>{{$totalOrders}}</span>
                                </div>
                            </div>
                            <div class="visual ps-1 position-absolute end-0">
                                <i class="fas fa-shopping-bag icon" style="opacity: 0.1; --bb-icon-size: 80px;"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                    <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none" href="{{route('products.index')}}" style="background-color: rgb(18, 128, 245);"><div class="d-flex justify-content-between align-items-center">
                            <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                <div class="desc fw-medium">Products</div>
                                <div class="number fw-bolder"
                                ><span>{{$productsCount}}</span>
                                </div>
                            </div>
                            <div class="visual ps-1 position-absolute end-0">
                                <svg class="icon me-n2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.1; --bb-icon-size: 80px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M17 17h-11v-14h-2"></path><path d="M6 5l14 1l-1 7h-13"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                    <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none" href="{{route('users.index')}}" style="background-color: rgb(117, 182, 249);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                <div class="desc fw-medium">Customers</div>
                                <div class="number fw-bolder">
                                    <span>{{$usersCount}}</span></div>
                            </div>
                            <div class="visual ps-1 position-absolute end-0">
                                <svg class="icon me-n2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.1; --bb-icon-size: 80px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col dashboard-widget-item col-12 col-md-6 col-lg-3">
                    <a class="text-white d-block rounded position-relative overflow-hidden text-decoration-none" href="{{route('orders.index')}}" style="background-color: rgb(7, 79, 157);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="details px-4 py-3 d-flex flex-column justify-content-between">
                                <div class="desc fw-medium">Total Sale</div>
                                <div class="number fw-bolder">
                                    <span>${{number_format($totalRevenue,2)}}</span>
                                </div>
                           </div>
                            <div class="visual ps-1 position-absolute end-0">
                                <i class="fas fa-dollar-sign icon me-n2" style="opacity: 0.1; --bb-icon-size: 80px;"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Monthly Revenue</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="revenueChart"></canvas>
                        </div>
                        <div class="col-md-4 "style="height: 100%; margin: auto;">
                            <canvas id="orderStatusChart"></canvas>
                            <div class="rp-card-status text-center mt-3">
                                <p>
                                    <svg class="icon icon-sm mb-0 me-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color: rgb(128, 188, 0);"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" stroke-width="0" fill="currentColor"></path></svg>
                                    <strong>${{number_format($completedOrders,2)}}</strong>
                                    <span class="ms-1 ">Completed this Month</span>
                                </p>
                                <p>
                                    <svg class="icon icon-sm mb-0 me-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color: rgb(233, 30, 99);"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" stroke-width="0" fill="currentColor"></path></svg>
                                    <strong>${{number_format($pendingOrders,2)}}</strong>
                                    <span class="ms-1">Pending this Month</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection








@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-doughnutlabel"></script>
<script>
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json( $data['labels']),
            datasets: [{
                label: 'Monthly Revenue',
                data: @json( $data['data']),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
    var ctx2 = document.getElementById('orderStatusChart').getContext('2d');
    var orderStatusChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {

            datasets: [{
                label: 'Order Statuses',
                data: [{{ $pendingOrders }}, {{ $completedOrders }}],
                backgroundColor: [
                    'rgb(233, 30, 99)', // Pending
                    'rgb(128, 188, 0)', // Completed

                ],
                borderColor: [
                    'rgb(233, 30, 99)', // Pending
                    'rgb(128, 188, 0)', // Completed
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            cutout: '100%',
            radius: '100%',
            plugins: {
                legend: {
                    position: 'bottom',

                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                },
                doughnutlabel: {
                    labels: [{
                        text: '${{ $pendingOrders + $completedOrders  }}',
                        font: {
                            size: 20,
                            weight: 'bold'
                        }
                    }, {
                        text: 'Revenue this Month',
                        size: 20,
                    }]
                }
            }
        }
    });
</script>
@endsection
