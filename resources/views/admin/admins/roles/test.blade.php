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
    <li class="breadcrumb-item "><a href="{{route('roles.index')}}">Roles</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Role</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('roles.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <form name="DiscountForm"  action="" id="RoleForm" method="post">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="code" id="name" class="form-control name" placeholder="Name">
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permission as $value)
                                    <label>
                                        <input type="checkbox" name="permission[]" value="{{$value->name}}" class="name">
                                        {{ $value->name }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{Route('roles.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </div>
    </form>
@endsection







@section('script')
    <script>

        $('#RoleForm').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();

            $.ajax({
                url:'{{route('roles.store')}}',
                type : 'post',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        window.location.href="{{route('roles.index')}}";


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
