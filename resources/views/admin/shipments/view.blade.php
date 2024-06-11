@extends('admin.master')

@section('style')

@endsection



@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('categories.index')}}">Shipment</a></li>
    <li class="breadcrumb-item active">{{$shipment->shipment_number}}</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$shipment->shipment_number}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('shipments.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card order-card">
                    <div class="card-header justify-content-between d-flex">
                        <h4 class="card-title">
                            Shipment {{$shipment->shipment_number}}
                        </h4>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-vcenter card-table table-bordered">
                            <tbody>
                            @forelse($shipment->order->items as $item)
                                <tr>
                                    <td class="text-center" style="width: 5%">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                            <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5"></path>
                                            <path d="M3 9l4 0"></path>
                                        </svg>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-start gap-2">
                                            @if(!empty($item->product->images->first()->image))
                                                <img src="{{asset('uploads/products/images/thumb/'.$item->product->images->first()->image)}}" alt="{{$item->name}}" width="60">
                                            @else
                                                <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$item->name}}" width="60">

                                            @endif
                                            <div>
                                                <a class="d-print-none" href="{{route('products.edit',$item->product->id)}}" target="_blank" title="{{$item->name}}">
                                                    {{$item->name}}
                                                </a>
                                                <p class="small mb-0">
                                                    SKU: <strong>{{$item->product->sku}}</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{$item->qty}}</strong>
                                        <span>×</span>
                                        <strong>${{number_format($item->price,2)}}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span>${{number_format($item->total,2)}}</span>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="card-footer text-center py-2">
                        <a href="{{route('order.view',$shipment->order->id)}}" target="_blank">
                            View Order {{$shipment->order->order_number}}
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path>
                                <path d="M11 13l9 -9"></path>
                                <path d="M15 4h5v5"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="card-title">
                            Additional shipment information
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST"  id="shipment-info-form" class="js-base-form dirty-check" novalidate="novalidate">
                            <div class="mb-3 position-relative">
                                <label for="shipping_company_name" class="form-label">Shipping Company Name</label>
                                <input class="form-control"  value="{{ optional($shipment->info)->shipping_company_name }}" placeholder="Ex: DHL, AliExpress..." name="shipping_company_name" type="text"  id="shipping_company_name">
                                <p class="error"></p>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="tracking_id" class="form-label">Tracking ID</label>
                                <input class="form-control" value="{{optional($shipment->info)->tracking_id}}" placeholder="Ex: JJD0099999999" name="tracking_id" type="text"  id="tracking_id">
                                <p class="error"></p>
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="tracking_link" class="form-label">Tracking Link</label>
                                <input class="form-control" value="{{optional($shipment->info)->tracking_link}}" placeholder="Ex: https://mydhl.express.dhl/us/en/tracking.html#/track-by-reference" name="tracking_link" type="text"  id="tracking_link">
                                <p class="error"></p>
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="estimate_date_shipped" class="form-label">Estimate Date Shipped</label>
                                <div class="input-group datepicker flatpickr">
                                    <input class="form-control flatpickr-input  bg-white" value="{{optional($shipment->info)->estimate_date_shipped}}" placeholder="Y-m-d" readonly="readonly" name="estimate_date_shipped" type="text" id="estimate_date_shipped">
                                    <button class="btn btn-icon  input-button " style="margin-left: -2px" id="open-datepicker"  title="toggle"  type="button" >
                                        <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                            <path d="M16 3v4"></path>
                                            <path d="M8 3v4"></path>
                                            <path d="M4 11h16"></path>
                                            <path d="M11 15h1"></path>
                                            <path d="M12 15v3"></path>
                                        </svg>

                                    </button>
                                    <button class="btn btn-icon   text-danger" id="clear-datepicker" type="button" style="margin-left: -2px">
                                        <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M18 6l-12 12"></path>
                                            <path d="M6 6l12 12"></path>
                                        </svg>

                                    </button>
                                </div>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="note" class="form-label">Note</label>
                                <textarea class="form-control" rows="3" placeholder="Add note..." name="note" cols="50" id="note">{{optional($shipment->info)->note}}</textarea>

                            </div>
                            <button class="btn btn-primary" type="submit"><svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                    <path d="M9 12l2 2l4 -4"></path>
                                </svg> Save</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            History
                        </h4>
                    </div>

                    <div class="card-body">
                        <ul class="steps steps-vertical" id="order-history-wrapper">
                            @forelse($shipment->history()->orderBy('id', 'desc')->get() as $history)
                                <li class="step-item ">
                                    <div class="h4 m-0">
                                        {!! $history->description !!}
                                    </div>
                                    <div class="text-secondary">{{$history->created_at}}</div>
                                </li>
                            @empty
                            @endforelse

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="card-title">
                            Shipment information
                        </h4>
                    </div>

                    <div class="card-body">
                        <dl class="d-flex flex-column gap-2">
                            <div class="row">
                                <dt class="col">
                                    Order number
                                </dt>
                                <dd class="col-auto">
                                    <a href="{{route('order.view',$shipment->order->id)}}" target="_blank">
                                        {{$shipment->order->order_number}}
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path>
                                            <path d="M11 13l9 -9"></path>
                                            <path d="M15 4h5v5"></path>
                                        </svg>
                                    </a>

                                </dd>
                            </div>
                            <div class="row">
                                <dt class="col">
                                    Shipping method
                                </dt>
                                <dd class="col-auto">
                                    Default
                                    (Free delivery)
                                </dd>
                            </div>
                            <div class="row">
                                <dt class="col">
                                    Shipping fee
                                </dt>
                                <dd class="col-auto">
                                    ${{number_format($shipment->price,2)}}
                                </dd>
                            </div>
                            <div class="row">
                                <dt class="col">
                                    Shipping status
                                </dt>
                                <dd class="col-auto">
                                    @if($shipment->status == 'pending')
                                        <span class="badge bg-warning text-warning-fg bg-secondary">Pending</span>
                                    @elseif($shipment->status == 'Approved')
                                        <span class="badge bg-warning text-warning-fg" >Approved</span>
                                    @elseif($shipment->status == 'Not_approved')
                                        <span class="badge bg-warning text-warning-fg" >Not approved</span>
                                    @elseif($shipment->status == 'Delivering')
                                        <span class="badge bg-info text-info-fg" >Delivering</span>
                                    @elseif($shipment->status == 'Delivered')
                                        <span class="badge bg-success text-success-fg" >Delivered</span>
                                    @elseif($shipment->status == 'Canceled')
                                        <span class="badge bg-danger text-danger-fg">Canceled</span>
                                    @endif

                                </dd>
                                @if($shipment->status !='Canceled')
                                <a href="javascript:void(0)"  data-toggle="modal" data-target="#update-shipping-status-modal" class="fw-semibold d-inline-block small mt-n1">
                                    <svg class="icon icon-sm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                        <path d="M13.5 6.5l4 4"></path>
                                    </svg>
                                    Update shipping status
                                </a>
                                @endif
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Customer information
                        </h4>
                    </div>

                    <div class="card-body p-0">
                        <div class="p-3">
                            <dl class="shipping-address-info mb-0">
                                <dd>{{$shipment->order->address->first_name}} {{$shipment->order->address->last_name}}</dd>
                                <dd>
                                    <a href="tel:{{$shipment->order->address->phone}}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                        </svg>
                                        <span dir="ltr">{{$shipment->order->address->phone}}</span>
                                    </a>
                                </dd>
                                @if(!empty($shipment->order->address->second_phone))
                                    <dd>
                                        <a href="tel:{{$shipment->order->second_phone}}">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                            </svg>
                                            <span dir="ltr">{{$shipment->order->address->second_phone}}</span>
                                        </a>
                                    </dd>
                                @endif
                                <dd>{{$shipment->order->address->building}} {{$shipment->order->address->street}},{{$shipment->order->address->district}}</dd>
                                <dd>{{$shipment->order->address->city->city_name_en}}</dd>
                                <dd>{{$shipment->order->address->governorate->governorate_name_en}}</dd>
                                <dd>{{$shipment->order->address->nearest_landmark}}</dd>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade modal-blur" id="update-shipping-status-modal" tabindex="-1" aria-labelledby="update-shipping-status-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update shipping status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('shipment_Update_Status',$shipment->id)}}" >
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="order_id" value="{{$shipment->id}}">
                        <div class="mb-3 position-relative">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select custom-select" name="status" id="status">
                                <option value="pending" {{$shipment->status == 'pending'?'selected' :''}}>Pending</option>
                                <option value="Approved" {{$shipment->status == 'Approved'?'selected' :''}}>Approved</option>
                                <option value="Not_approved" {{$shipment->status == 'Not_approved'?'selected' :''}}>Not approved</option>
                                <option value="Delivering" {{$shipment->status == 'Delivering'?'selected' :''}}>Delivering</option>
                                <option value="Delivered" {{$shipment->status == 'Delivered'?'selected' :''}}>Delivered</option>
                                <option value="Canceled" {{$shipment->status == 'Canceled'?'selected' :''}}>Canceled</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary save-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection


@section('script')
    <script>
        $(document).ready(function (){
            const datePicker = flatpickr("#estimate_date_shipped", {
                dateFormat: "Y-m-d",
                enableTime: false,
                minDate: "today",
            });
            $('#open-datepicker').on('click', function () {
                datePicker.open();
            });

            $('#clear-datepicker').on('click', function () {
                datePicker.clear();
            });
        })

        $('#shipment-info-form').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();

            $.ajax({
                url:'{{route('shipmentUpdateInfo',$shipment->id)}}',
                type : 'post',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')

                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        });

                    }else {
                        handleErrors(response.errors);
                    }

                },error:function (xhr, status, error){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);
                    console.log('something went wrong');

                }
            })
        });


        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });}
    </script>
@endsection




