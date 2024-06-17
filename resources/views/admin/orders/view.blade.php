@extends('admin.master')


@section('style')

@endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('orders.index')}}">Orders</a></li>
    <li class="breadcrumb-item active">{{$order->order_number}}</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$order->order_number}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('orders.index')}}" class="btn btn-primary">Back</a>
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
                            Order information {{$order->order_number}}
                        </h4>
                        @php
                            if ($order->status->status =='pending'){
                                $status_class = 'bg-warning text-warning-fg bg-secondary';
                            }elseif ($order->status->status =='shipping'){
                                $status_class = 'bg-warning text-warning-fg';
                            }elseif ($order->status->status =='completed'){
                                $status_class = 'bg-info text-info-fg';
                            }elseif ($order->status->status =='processing'){
                                $status_class = 'bg-warning text-warning-fg bg-secondary';
                            }elseif ($order->status->status =='cancelled'){
                                $status_class = 'bg-danger text-danger-fg';
                            }else{
                                $status_class = 'bg-warning text-warning-fg bg-secondary';
                            }
                        @endphp

                        <span class="badge {{$status_class}} d-flex align-items-center gap-1 ms-auto">

                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                      <path d="M11.5 17h-5.5v-14h-2"></path>
                      <path d="M6 5l14 1l-1 7h-13"></path>
                      <path d="M15 19l2 2l4 -4"></path>
                    </svg>
                            {{$order->status->status}}
                        </span>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-vcenter card-table table-bordered">
                            <tbody>
                            @forelse($order->items as $item)
                                <tr>

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
                        <div class="row">
                            <div class="col-md-6 offset-md-6 mt-4">
                                <table class="table table-vcenter card-table table-borderless text-center">
                                    <tbody>
                                    <tr>
                                        <hr class="my-0">
                                    </tr>
                                    <tr>
                                        <th>Sub amount</th>
                                        <td> ${{number_format($order->subtotal,2)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount {{$order->coupon_code ?'('.$order->coupon_code.')' :''}}</th>
                                        <td>${{number_format($order->discount,2)}}</td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <p class="mb-1">Shipping fee</p>
                                        </th>
                                        <td>

                                            <span class="">${{number_format($order->shipping,2)}}</span>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total amount</th>
                                        <td>
                                             <span class="">${{number_format($order->grand_total,2)}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment method</th>
                                        <td>
                                            <a href="#" target="_blank">
                                                {{\App\Models\PaymentMethod::getSettings($order->payment_method)['payment_'.$order->payment_method.'_name']}}
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path>
                                                    <path d="M11 13l9 -9"></path>
                                                    <path d="M15 4h5v5"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        if ($order->payment->status =='pending'){
                                            $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                        }elseif ($order->payment->status =='completed'){
                                            $payment_class = 'bg-success text-success-fg';
                                        }elseif ($order->payment->status =='failed'){
                                            $payment_class = 'bg-danger text-danger-fg';
                                        }else{
                                            $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                        }
                                    @endphp
                                    <tr>
                                        <th>Payment status</th>
                                        <td>
                                            <span class="badge {{$payment_class}}">{{$order->payment->status}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr class="my-0">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>


                                <form action="{{route('updateOrderNote')}}" method="post">
                                    @csrf
                                    <input name="order_id" value="{{$order->id}}" type="hidden">
                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="description">
                                            Note
                                        </label>

                                        <textarea class="form-control textarea-auto-height" name="admin_note" id="description" placeholder="Add note...">{{$order->status->admin_note}}</textarea>
                                    </div>

                                    <button class="btn   btn-update-order" type="submit">

                                        Save

                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">

                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <div class="text-uppercase">


                                @if($order->status->status == 'pending' )
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                    CONFIRM ORDER
                                @elseif($order->status->status =='cancelled')
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                     ORDER CANCELlED
                                @else
                                    <svg class="icon text-success" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                    Order was confirmed
                                @endif
                            </div>
                            @if($order->status->status =='pending')
                                <div class="btn-list">
                                    <form method="post" action="{{route('OrderConfirm')}}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                        <button class="btn btn-info  btn-trigger-confirm-payment save-btn" type="submit" >
                                            Confirm order
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <div class="text-uppercase">

                                @if($order->Payment->status =='pending')
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                        <path d="M3 10l18 0"></path>
                                        <path d="M7 15l.01 0"></path>
                                        <path d="M11 15l2 0"></path>
                                    </svg>
                                    PENDING PAYMENT
                                @elseif($order->Payment->status =='completed')

                                    <svg class="icon text-success" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>

                                    Payment ${{number_format($order->grand_total,2)}} was accepted
                                @elseif($order->Payment->status =='failed')

                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                        <path d="M3 10l18 0"></path>
                                        <path d="M7 15l.01 0"></path>
                                        <path d="M11 15l2 0"></path>
                                    </svg>

                                    Payment  was failed
                                @endif

                            </div>
                            @if($order->Payment->status =='pending')
                            <div class="btn-list">
                                @if($order->status->status !='cancelled')
                                <button class="btn btn-info  btn-trigger-confirm-payment save-btn" type="button" data-toggle="modal" data-target="#confirm-payment-modal" >

                                    Confirm payment

                                </button>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="p-3 d-flex justify-content-between align-items-center">
                            <div class="text-uppercase">
                                <svg class="icon text-success" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                                <span>Delivery</span>
                            </div>
                        </div>

                        <div class="card-body d-print-none">
                            <div class="datagrid">
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Shipping</div>
                                    <div class="datagrid-content">
                                        <a href="{{route('shipment.view',$order->Shipment->id)}}" target="_blank">
                                            <h4>{{$order->Shipment->shipment_Number}}</h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Status</div>
                                    <div class="datagrid-content">
                                        @php
                                        $orderStatus = $order->Shipment->status;
                                        @endphp
                                        @include('admin.orders.status')
                                    </div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Shipping method</div>
                                    <div class="datagrid-content">Free delivery</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Weight (g)</div>
                                    <div class="datagrid-content">{{$order->Shipment->weight}}g</div>
                                </div>
                                <div class="datagrid-item">
                                    <div class="datagrid-title">Last Update</div>
                                    <div class="datagrid-content">{{$order->Shipment->updated_at}}</div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer shipment-actions-wrapper btn-list">
                            @if($order->status->status !='cancelled')
                            <button class="btn   btn-trigger-update-shipping-status" type="button" data-toggle="modal" data-target="#update-shipping-status-modal">
                                <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5"></path>
                                    <path d="M3 9l4 0"></path>
                                </svg>
                                Update shipping status
                            </button>
                            @endif
                        </div>
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
                            @forelse($order->history()->orderBy('id', 'desc')->get() as $history)
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Customer
                        </h4>
                    </div>

                    <div class="card-body p-0">
                        <div class="p-3">
                            <div class="mb-3">
                                <span class="avatar avatar-lg avatar-rounded" style="background-image: url('https://shopwise.botble.com/storage/customers/3-150x150.jpg')"></span>
                            </div>
                            <p class="mb-1">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M4 13h3l3 3h4l3 -3h3"></path>
                                </svg> {{$order->user->orders()->count()}} order(s)
                            </p>

                            <p class="mb-1 fw-semibold">{{$order->user->name}}</p>

                            <p class="mb-1">
                                <a href="mailto:dasia.dach@example.com">
                                    {{$order->user->email}}
                                </a>
                            </p>


                        </div>

                        <div class="hr my-1"></div>

                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>Shipping information</h4>
                                <a class="btn-trigger-update-shipping-address btn-action text-decoration-none" href="#" data-toggle="modal" data-target="#update-shipping-address-modal">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path>
                                        <path d="M13.5 6.5l4 4"></path>
                                    </svg>
                                </a>
                            </div>

                            <dl class="shipping-address-info mb-0">
                                <dd>{{$order->address->first_name}} {{$order->address->last_name}}</dd>
                                <dd>
                                    <a href="tel:{{$order->address->phone}}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                        </svg>
                                        <span dir="ltr">{{$order->address->phone}}</span>
                                    </a>
                                </dd>
                                @if(!empty($order->address->second_phone))
                                <dd>
                                    <a href="tel:{{$order->second_phone}}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                        </svg>
                                        <span dir="ltr">{{$order->address->second_phone}}</span>
                                    </a>
                                </dd>
                                @endif
                                <dd>{{$order->address->building}} {{$order->address->street}},{{$order->address->district}}</dd>
                                <dd>{{$order->address->city->city_name_en}}</dd>
                                <dd>{{$order->address->governorate->governorate_name_en}}</dd>
                                <dd>{{$order->address->nearest_landmark}}</dd>
                            </dl>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Customer Note
                        </h4>
                    </div>

                    <div class="card-body p-0">
                    <div class="mb-3">
                        <textarea readonly class="form-control">{{$order->note}}</textarea>
                    </div>
                    </div>

                </div>
                @if($order->status->status !='cancelled')
                <div class="d-flex justify-content-end">
                    <button class="btn btn-danger  btn-trigger-confirm-payment bg-danger  " type="button"  data-target="#cancel-order-modal" data-toggle="modal">
                        Cancel order
                    </button>
                </div>
                @endif
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
                <form method="POST" action="{{route('shipment_update_status',$order->Shipment->id)}}" >
                    @csrf
                <div class="modal-body">

                        <input type="hidden" name="order_id" value="{{$order->id}}">
                        <div class="mb-3 position-relative">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select custom-select" name="status" id="status">
                                <option value="pending" {{$order->Shipment->status == 'pending'?'selected' :''}}>Pending</option>
                                <option value="Approved" {{$order->Shipment->status == 'Approved'?'selected' :''}}>Approved</option>
                                <option value="Not_approved" {{$order->Shipment->status == 'Not_approved'?'selected' :''}}>Not approved</option>
                                <option value="Delivering" {{$order->Shipment->status == 'Delivering'?'selected' :''}}>Delivering</option>
                                <option value="Delivered" {{$order->Shipment->status == 'Delivered'?'selected' :''}}>Delivered</option>
                                <option value="Canceled" {{$order->Shipment->status == 'Canceled'?'selected' :''}}>Canceled</option>
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
    <div class="modal fade modal-blur" id="confirm-payment-modal" tabindex="-1" aria-labelledby="confirm-payment-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 380px">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                    <div class="modal-status bg-info"></div>

                    <div class="modal-body text-center py-4">

                        <div class="mb-2">
                            <svg class="icon icon-lg text-info" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                <path d="M12 9h.01"></path>
                                <path d="M11 12h1v4h1"></path>
                            </svg>
                        </div>

                        <h5 class="mb-3">Confirm payment</h5>

                        <div class="text-muted text-break">
                            Processed by <strong>Cash on delivery (COD)</strong>. Did you receive payment outside the system?
                        </div>
                    </div>

                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <form method="post" action="{{route('payment_update_status',$order->Payment->id)}}">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <input type="hidden" name="price" value="{{$order->grand_total}}">
                                <button type="submit" class=" btn btn-info w-100">Confirm Payment</button>
                                </form>

                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary close-btn w-100" data-dismiss="modal">Cancel</button>

                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
    <div class="modal fade modal-blur " id="update-shipping-address-modal" tabindex="-1" aria-labelledby="confirm-payment-modal" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update address</h5>
                    <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="" accept-charset="UTF-8" id="AddressUpdateForm">

                <div class="modal-body">
                    @csrf
                        <input name="address_id" type="hidden" value="{{$order->address->id}}">
                        @php
                            $address = $order->address;
                        @endphp

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name" class="form-label">First Name<span class="text-danger">*</span></label>
                                    <input id="first_name" type="text"
                                           value="{{$address->first_name}}"
                                           class="form-control first_name" name="first_name"
                                           required  placeholder="">

                                    <p class="error"></p>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="last_name" class="form-label ">Last Name<span class="text-danger">*</span></label>
                                    <input id="last_name" type="text"
                                           value="{{$address->last_name}}"
                                           class="form-control last_name" name="last_name"
                                           required  placeholder="">
                                    <p class="error"></p>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label phone">Phone Number<span class="text-danger">*</span></label>
                                    <input id="phone" type="number"
                                           required
                                           value="{{$address->phone}}"
                                           class="form-control" name="phone"
                                           placeholder="01xxxxxxxxx">
                                    <p class="error"></p>

                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="second_phone" class="form-label">Second Phone Number</label>

                                    <input id="second_phone" type="number"
                                           value="{{$address->second_phone}}"
                                           class="form-control second_phone" name="second_phone"
                                           placeholder="01xxxxxxxxx">
                                    <p class="error"></p>

                                </div>

                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="street" class="form-label">Street Name<span class="text-danger">*</span></label>

                            <input id="street" type="text"
                                   required
                                   value="{{$address->street}}"
                                   class="form-control" name="street"
                                   placeholder="Talaat Harb Street">
                            <p class="error"></p>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="building" class="form-label">Building name/no<span class="text-danger">*</span></label>

                                    <input id="building" type="text"
                                           required
                                           value="{{$address->building}}"
                                           class="form-control" name="building"
                                           placeholder="Princess Tower">
                                    <p class="error"></p>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="district" class="form-label">District</label>
                                    <input id="district" type="text"
                                           value="{{$address->district}}"
                                           class="form-control district" name="district"
                                           placeholder="7th District">
                                    <p class="error"></p>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="governorate_id" class="form-label">Governorate<span class="text-danger">*</span></label>

                                    <select id="governorate_id" type="text" required class="form-control form-select governorate_id" name="governorate_id">

                                        <option value="">Select Governorate</option>
                                        @forelse($governorates as $governorate)
                                            <option value="{{$governorate->id}}" {{$address->governorate->id == $governorate->id ?'selected':''}}>{{$governorate->governorate_name_en}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="city_id" class="form-label">City<span class="text-danger">*</span></label>

                                    <select id="city_id" type="text" required class="form-control city_id" name="city_id">
                                        <option value="">Select City</option>
                                        @forelse($cities as $city)
                                            <option value="{{$city->id}}" {{$address->city_id == $city->id ? 'selected' :''}} >{{$city->city_name_en}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <p class="error"></p>

                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nearest_landmark" class="form-label">Nearest Landmark</label>
                            <input id="nearest_landmark" type="text"
                                   value="{{$address->nearest_landmark}}"
                                   class="form-control nearest_landmark" name="nearest_landmark"
                                   placeholder="Cairo festival city">

                            <p class="error"></p>

                        </div>
                </div>


                <div class="modal-footer">
                    <button class="btn close-btn"  type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary  ms-auto" type="submit" id="confirm-update-shipping-address-button">Update</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade modal-blur" id="cancel-order-modal" tabindex="-1" aria-labelledby="cancel-order-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 380px">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-status bg-danger"></div>

                <div class="modal-body text-center py-4">

                    <div class="mb-2">
                        <svg class="icon icon-lg text-danger" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                            <path d="M12 9h.01"></path>
                            <path d="M11 12h1v4h1"></path>
                        </svg>
                    </div>

                    <h5 class="mb-3">Cancel order</h5>

                    <div class="text-muted text-break">
                        Are you sure you want to cancel this order? This will also cancel the shipment. Please confirm your decision.?

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <form method="post" action="{{route('orderCancel',$order->id)}}">
                                    @csrf
                                    <input type="hidden" value="{{$order->id}}" name="order_id">
                                    <button type="submit" class=" btn btn-danger bg-danger w-100">Cancel order</button>
                                </form>

                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary close-btn w-100" data-dismiss="modal">Cancel</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection







@section('script')
<script>
    function fetchCities(governorateId, selectedCityId) {
        $.ajax({
            url: '{{ route('front.getCities') }}',
            type: 'get',
            data: { governorate_id: governorateId },
            dataType: 'json',
            success: function (response) {
                $('.city_id').find('option').not(':first').remove();
                $.each(response['cities'], function (key, item) {
                    $('.city_id').append('<option value="' + item.id + '">' + item.city_name_en + '</option>');
                });
                if (selectedCityId) {
                    $('#city_id').val(selectedCityId);
                }
            }
        });
    }

    $(document).on('change', '.governorate_id', function () {
        var governorateId = $(this).val();
        fetchCities(governorateId);
    });
    $(document).on('submit', '#AddressUpdateForm', function (e) {
        e.preventDefault();
        var formArray = $(this).serializeArray();
        var addressId = formArray.find(item => item.name === 'address_id').value;
        var url = '{{ route('UpdateAddress', 'ID') }}';
        var newUrl = url.replace('ID', addressId);

        $.ajax({
            url: newUrl,
            type: 'PUT',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    window.location.href="{{route('order.view',$order->id)}}";
                } else {

                    handleErrors(response.errors);
                }
            },
            error: function (jqXHR) {
                handleErrors(jqXHR.responseJSON.errors);
            }
        });
    });
    function handleErrors(errors) {
        $('.error').removeClass('invalid-feedback').html('');
        $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

        $.each(errors, function (key, value) {
            $(`.${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
        });
    }

</script>
@endsection
