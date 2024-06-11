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
    <li class="breadcrumb-item "><a href="{{route('governorate.index')}}">Governorate</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Governorate</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('governorate.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="governorateForm" action="" id="governorateForm" >
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="governorate_name_en">Governorates Name</label>
                                    <input type="text" name="governorate_name_en" id="governorate_name_en" class="form-control" placeholder="Name">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="governorate_name_ar">Governorates Name ar</label>
                                    <input type="text" name="governorate_name_ar" id="governorate_name_ar" class="form-control" placeholder="Name AR">
                                    <p class="error"></p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{Route('governorate.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>

        </form>
    </div>

@endsection







@section('script')
    <script>


        $('#governorateForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{Route('governorate.store')}}',
                type:'post',
                data:form.serializeArray(),
                dataType:'json',
                success:function (response){
                    if(response['status'] === true){
                        window.location.href="{{route('governorate.index')}}";

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
