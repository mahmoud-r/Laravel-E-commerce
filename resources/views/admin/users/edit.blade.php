@extends('admin.master')

@section('style')
    <style>
        .password-tab{
            display: none;
        }
        .markdown>table thead th, .table thead th {
            background: #f6f8fb;
            color: #6c7a91;
            font-size: .625rem;
            font-weight: 600;
            letter-spacing: .04em;
            line-height: 1rem;
            padding-bottom: .5rem;
            padding-top: .5rem;
            text-transform: uppercase;
            white-space: nowrap;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('users.index')}}">users</a></li>
    <li class="breadcrumb-item active">{{$user->name}}</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$user->name}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('users.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="UsersForm" action="" id="UsersForm" >
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{$user->name}}"  class="form-control " placeholder="Name">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{$user->phone}}"  class="form-control " placeholder="phone">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" value="{{$user->email}}"  class="form-control " placeholder="Email">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 custom-control custom-switch">
                                            <input name="is_change_password" type="hidden" value="0">
                                            <input class="custom-control-input" name="is_change_password" type="checkbox" value="1" id="is_change_password" data-bb-toggle="collapse" data-bb-target="#password-collapse">
                                        <label class="custom-control-label" for="is_change_password"><span class="form-check-label">Change password?</span></label>

                                    </div>
                                </div>
                                <div class="password-tab col-md-12">
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password"  class="form-control" placeholder="password">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"  class="form-control" placeholder="Confirm Password">
                                            <p class="error"></p>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                <div class="col-md-12">
                                    <div class="mb-3 position-relative">
                                        <label for="private_notes" class="form-label">Private notes</label>
                                        <textarea class="form-control" data-counter="1000" rows="2" name="note" cols="50" id="note">{{$user->note}}</textarea>
                                        <small class="form-hint">
                                            Private notes are only visible to admins.
                                        </small>
                                        <p class="error"></p>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">

                            <div class="card-header">
                                <h3 class="card-title"> Addresses</h3>
                                <div class="card-tools">
                                    <a href="javascript:void(0)" class="btn btn-primary"  data-toggle="modal" data-target="#create-user-address">New Address</a>
                                </div>
                            </div>

                        <div class="card-body">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>District</th>
                                    <th>City</th>
                                    <th>Governorate</th>
                                    <th width="100">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                @forelse($user->addresses as $i=>$address)
                                    <tr id="address_{{$address->id}}">
                                        <td>{{$i+1}}</td>
                                        <td> {{$address->address_name}}</td>
                                        <td style="max-width: 20%;white-space: normal">{{$address->building}},{{$address->street}},{{$address->street}}</td>
                                        <td>{{$address->district}}</td>
                                        <td>{{$address->city->city_name_en}} </td>
                                        <td>{{$address->governorate->governorate_name_en}}</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="editAddress({{$address->id}})">
                                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </a>
                                            <a href="javascript:void(0)" onclick="deleteAddress({{$address->id}},'{{$address->address_name}}')" class="text-danger w-4 h-4 mr-1">
                                                <svg  class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center"> Currently, there are no addresses yet.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card">

                            <div class="card-header">
                                <h3 class="card-title"> Orders</h3>
                            </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Total</th>
                                    <th>Date Purchased</th>
                                    <th width="100">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                @forelse($user->orders as $i=>$order)
                                    <tr>
                                        <td>{{ $i+1}}</td>
                                        <td><a href="{{route('order.view',$order->id)}}">{{$order->order_number}}</a></td>
                                        <td>{{$order->address->first_name}} {{$order->address->last_name}}</td>
                                        <td>{{$order->address->phone}}</td>
                                        <td>
                                            @php
                                                if ($order->status->status =='pending'){
                                                    $status_class = 'bg-warning text-warning-fg bg-secondary';
                                                }elseif ($order->status->status =='shipping'){
                                                    $status_class = 'bg-warning text-warning-fg';
                                                }elseif ($order->status->status =='completed'){
                                                    $status_class = 'bg-success text-success-fg';
                                                }elseif ($order->status->status =='processing'){
                                                    $status_class = 'bg-warning text-warning-fg bg-secondary';
                                                }elseif ($order->status->status =='cancelled'){
                                                    $status_class = 'bg-danger text-danger-fg';
                                                }else{
                                                    $status_class = 'bg-warning text-warning-fg bg-secondary';
                                                }
                                            @endphp
                                            <span class="badge {{$status_class}}">{{$order->status->status}}</span>

                                        </td>
                                        <td>
                                            @php
                                                if ($order->status->status =='pending'){
                                                    $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                                }elseif ($order->status->status =='completed'){
                                                    $payment_class = 'bg-success text-success-fg';
                                                }elseif ($order->status->status =='failed'){
                                                    $payment_class = 'bg-danger text-danger-fg';
                                                }else{
                                                    $payment_class = 'bg-warning text-warning-fg bg-secondary';
                                                }
                                            @endphp
                                            <span class="badge {{$payment_class}}">{{$order->payment->status}}</span>
                                        </td>
                                        <td>${{number_format($order->grand_total,2)}}</td>
                                        <td>{{\carbon\Carbon::parse($order->created_at)->format('d M,Y')}}</td>
                                        <td>
                                            <a href="{{route('order.view',$order->id)}}" >
                                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </a>

                                        </td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center"> Currently, there are no Orders yet.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card">

                            <div class="card-header">
                                <h3 class="card-title"> Wishlist</h3>
                            </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>CREATED AT</th>

                                </tr>
                                </thead>
                                <tbody>

                                @forelse($user->Wishlists as $i=>$Wishlist)
                                    <tr>
                                        <td>{{ $i+1}}</td>
                                        <td>
                                            <a href="{{route('products.edit',$Wishlist->product->id)}}" class="d-flex gap-2 align-items-center">

                                                @if(!empty($Wishlist->product->images->first()->image))
                                                    <img src="{{asset('uploads/products/images/thumb/'.$Wishlist->product->images->first()->image)}}" class="rounded" width="38" loading="lazy">
                                                @else
                                                    <img  src="{{asset('front_assets/images/empty-img.png')}}"   width="38" loading="lazy">

                                                @endif
                                                {{$Wishlist->product->title}}
                                            </a>
                                        </td>
                                        <td>{{$Wishlist->created_at}}</td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center"> No data to display</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="card">

                            <div class="card-header">
                                <h3 class="card-title"> Reviews</h3>
                            </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Star</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($user->ratings as $i=>$review)
                                    <tr id="review_{{ $review->id }}">
                                        <td>{{ $i+1}}</td>
                                        <td>
                                            <a href="{{route('products.edit',$review->product->id)}}" class="d-flex gap-2 align-items-center">

                                                @if(!empty($review->product->images->first()->image))
                                                    <img src="{{asset('uploads/products/images/thumb/'.$review->product->images->first()->image)}}" class="rounded" width="38" loading="lazy">
                                                @else
                                                    <img  src="{{asset('front_assets/images/empty-img.png')}}"   width="38" loading="lazy">

                                                @endif
                                                {{$review->product->title}}
                                            </a>
                                        </td>
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

                                                <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </td>
                                        <td>{{\carbon\Carbon::parse($review->created_at)->format('d M,Y')}}</td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center"> No data to display</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Publish
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="btn-list">
                                <button class="btn btn-primary" type="submit" value="apply" name="submitter">
                                    <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M14 4l0 4l-6 0l0 -4"></path>
                                    </svg>
                                    Save

                                </button>

                                <a href="{{Route('users.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>


                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Status
                            </h4>
                        </div>
                        <div class="card-body">
                            <select name="status" class="form-control" id="status">
                                <option value="1" {{$user->status == 1?'selected':''}}>Activated</option>
                                <option value="0" {{$user->status == 0?'selected':''}} >Locked</option>
                            </select>
                            <p class="error"></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@include('admin.users.create_address_model')
    <div id="edit_address"></div>
@endsection







@section('script')
    <script>
        $('#create-user-address').on('shown.bs.modal', function () {
            console.log( $('.error'))
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');
        })
        $('#is_change_password').on('change',function (){
            if(this.checked) {
                $('.password-tab').fadeIn()
            }else {
                $('.password-tab').fadeOut()
            }
        })
        $('#UsersForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{Route('users.update',$user->id)}}',
                type:'put',
                data:form.serializeArray(),
                dataType:'json',
                success:function (response){

                    if(response.status == true){
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        window.location.href="{{route('users.index')}}";
                    }else {
                        handleErrors(response.errors);
                    }
                },error:function (jqXHR,exception){
                    console.log('something went wrong')
                }
            })
        });

        $(document).ready(function () {
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
        });

        $('#AddressCreateForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{ route('createAddress',$user->id) }}',
                type:'post',
                data:form.serializeArray(),
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        $('#create-user-address').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        })
                        window.location.reload();
                    }else {
                        handleErrors(response.errors);
                    }


                },error:function (jqXHR){
                    handleErrors(jqXHR.responseJSON.errors);
                }
            })
        });

        function editAddress(id){
            var url ='{{route('editUserAddress','ID')}}';
            var newUrl =url.replace('ID',id);
            $.ajax({
                url: newUrl,
                type: 'get',
                data:id,
                success: function (response) {
                    $('#create-user-address').modal('dispose');
                    $('#edit_address').html(response);
                    $('#edit-user-address').modal('show');

                }
            });
        }
        $(document).on('submit', '#AddressUpdateForm', function (e) {
            e.preventDefault();
            var formArray = $(this).serializeArray();
            var addressId = formArray.find(item => item.name === 'address_id').value;
            var url = '{{ route('updateUserAddress', 'ID') }}';
            var newUrl = url.replace('ID', addressId);

            $.ajax({
                url: newUrl,
                type: 'PUT',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], input[type='number'], select").removeClass('is-invalid');
                        $('#edit-user-address').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        });
                        window.location.reload();
                    } else {

                        handleErrors(response.errors);
                    }
                },
                error: function (jqXHR) {
                    handleErrors(jqXHR.responseJSON.errors);
                }
            });
        });
        function deleteAddress(id,name) {
            Swal.fire({
                title: "Do you want to Delete "+name+"?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{Route("deleteUserAddress","ID")}}';
                    var newUrl =url.replace('ID',id)
                    $.ajax({
                        url: newUrl,
                        type: 'DELETE',
                        data: '',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },success: function (response) {

                            if(response['status'] === true){
                                Swal.fire("Deleted!", "", "success");
                                $('#address_' + id).remove();
                            }else {
                                console.log('something went wrong')
                            }
                        }

                    });
                }
            });
        }
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`.${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });
        }

    </script>
@endsection
