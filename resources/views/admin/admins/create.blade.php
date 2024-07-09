@extends('admin.master')

@section('style')
    <style>
        .password-tab{
            display: none;
        }
    </style>
@endsection
@section('title')Admins - Create @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('admins.index')}}">Admins</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Admin</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('admins.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="AdminsForm" action="" id="AdminsForm" >
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control " placeholder="Name">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone"  class="form-control " placeholder="phone">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email"   class="form-control " placeholder="Email">
                                        <p class="error"></p>
                                    </div>
                                </div>
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
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <strong>Role:</strong>
                                        <select class="form-control multiple" multiple name="roles[]">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}" >{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
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

                                <a href="{{Route('admins.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>


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
                                <option value="1">Activated</option>
                                <option value="0">Locked</option>
                            </select>
                            <p class="error"></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Notification
                            </h4>
                        </div>
                        <div class="card-body">
                            <select name="notification" class="form-control" id="notification">
                                <option value="1">ON</option>
                                <option value="0">OFF</option>
                            </select>
                            <p class="error"></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection







@section('script')
    <script>
        $('#AdminsForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{Route('admins.store')}}',
                type:'post',
                data:form.serializeArray(),
                dataType:'json',
                success:function (response){

                    if(response.status == true){
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        window.location.href="{{route('admins.index')}}";
                    }else {
                        handleErrors(response.errors);
                    }
                },error:function (jqXHR,exception){
                    console.log('something went wrong')
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
