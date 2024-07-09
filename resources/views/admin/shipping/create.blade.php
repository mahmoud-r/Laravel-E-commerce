@extends('admin.master')
@section('title')Shipping Zones - Create @endsection

@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('shipping.index')}}">Shipping</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Shipping Zone</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('shipping.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="ShippingZoneForm" action="" id="ShippingZoneForm" >
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Zone Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="delivery_time">Delivery Time</label>
                                    <input type="text" name="delivery_time" id="delivery_time" class="form-control" placeholder="Delivery Time">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="weight_to">weight To</label>
                                            <input type="number" name="weight_to" id="weight_to" class="form-control" placeholder="KG">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="weight_from">Additional Weight Price</label>
                                            <input type="number" name="additional_weight_price" id="additional_weight_price" class="form-control" placeholder="$">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="governorates">Governorates</label>
                                    <select multiple class="governorates w-100" name="governorates[]" id="governorates">
                                        @forelse($governorates as $governorate)
                                            <option value="{{$governorate->id}}">{{$governorate->governorate_name_en}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <p class="error"></p>
                                </div>

                            </div>

                        </div>
                        </div>
                    </div>
                </div>


            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{Route('shipping.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>

        </form>
    </div>

@endsection







@section('script')
    <script>
        $('.governorates').select2({
            closeOnSelect: false
        });

        $('#ShippingZoneForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{Route('shipping.store')}}',
                type:'post',
                data:form.serializeArray(),
                dataType:'json',
                success:function (response){
                    if(response['status'] === true){
                        window.location.href="{{route('shipping.index')}}";

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')

                    }else {
                        handleErrors(response.errors);

                    }


                },error:function (xhr){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);
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
