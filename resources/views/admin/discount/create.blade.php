@extends('admin.master')


@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
    </style>
@endsection

@section('title')Discount - create @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('discount.index')}}">Discount Coupons</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Coupon</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('discount.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <form name="DiscountForm"  action="" id="DiscountForm" method="post">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code">Code</label>
                                        <input type="text" name="code" id="code" class="form-control code" placeholder="Code">
                                        <p class="error"></p>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text"  name="name" id="name" class="form-control name" placeholder="name">
                                        <p class="error"></p>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type">Type</label>
                                        <select name="type" id="type" class="type form-control ">
                                            <option value="fixed">Fixed</option>
                                            <option value="percent">Percent</option>
                                        </select>
                                        <p class="error"></p>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="discount_amount">Discount amount</label>
                                        <input type="number"  name="discount_amount" id="discount_amount" class="form-control discount_amount" placeholder="Discount amount">
                                        <p class="error"></p>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_uses">Max Uses</label>
                                        <input type="number"  name="max_uses" id="max_uses" class="form-control max_uses" placeholder="Max Uses">
                                        <p class="error"></p>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_uses_user">Max Uses User</label>
                                        <input type="number"  name="max_uses_user" id="max_uses_user" class="form-control max_uses_user" placeholder="Max Uses User">
                                        <p class="error"></p>

                                    </div>


                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="20" rows="10"  class="form-control description" placeholder="Description"></textarea>
                                        <p class="error"></p>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Coupon status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                    <p class="error"></p>

                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Time</h2>
                            <div class="mb-3">
                                <label for="starts_at">Starts Date</label>
                                <input type="text" autocomplete="off" name="starts_at" id="starts_at" class="form-control starts_at" >
                                <p class="error"></p>

                            </div>
                            <div class="mb-3">
                                <label for="expires_at">Expires Date</label>
                                <input type="text" autocomplete="off"  name="expires_at" id="expires_at" class="form-control expires_at" >
                                <p class="error"></p>

                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Min amount</h2>
                            <div class="mb-3">
                                <input type="text"  name="min_amount" id="min_amount" class="form-control min_amount" >
                                <p class="error"></p>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{Route('discount.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </form>
@endsection







@section('script')
    <script>
        $(document).ready(function (){

            flatpickr("#starts_at", {
                dateFormat: "Y-m-d H:i:s",
                enableTime: true,
                minDate: "today",
            });
            flatpickr("#expires_at", {
                dateFormat: "Y-m-d H:i:s",
                enableTime: true,
                minDate: "today",
            });

        })

        $('#DiscountForm').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();

            $.ajax({
                url:'{{route('discount.store')}}',
                type : 'post',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        window.location.href="{{route('discount.index')}}";


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
