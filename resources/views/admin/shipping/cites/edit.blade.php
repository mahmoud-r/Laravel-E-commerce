@extends('admin.master')


@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
    </style>
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href=" {{route('cities.index',$city->governorate->id)}}">{{$city->governorate->governorate_name_en}}</a></li>
    <li class="breadcrumb-item active">{{$city->city_name_en}}</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$city->city_name_en}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('cities.index',$city->governorate->id)}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="cityForm" action="" id="cityForm" >
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="governorate_name_en">Governorates Name</label>
                                    <input type="text" disabled value="{{$city->governorate->governorate_name_en}}" class="form-control" placeholder="Name">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city_name_en">City Name</label>
                                    <input type="text" value="{{$city->city_name_en}}" name="city_name_en" id="city_name_en" class="form-control" placeholder="Name">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city_name_ar">City Name AR</label>
                                    <input type="text" value="{{$city->city_name_ar}}" name="city_name_ar" id="city_name_ar" class="form-control" placeholder="Name AR">
                                    <p class="error"></p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href=" {{route('cities.index',$city->governorate->id)}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>

        </form>
    </div>

@endsection







@section('script')
    <script>


        $('#cityForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{Route('cities.update',$city->id)}}',
                type:'put',
                data:form.serializeArray(),
                dataType:'json',
                success:function (response){
                    if(response['status'] === true){
                        window.location.href="{{route('cities.index',$city->governorate->id)}}";

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
