@extends('admin.master')


@section('header_button')
    <a href="{{route('sub_category.index',$category->id)}}" class="btn btn-primary">Back</a>

@endsection
@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('categories.index')}}">{{$category->name}}</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('title')Sub Categories - create @endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$category->name}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('sub_category.index',$category->id)}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="SubCategoryForm" action="" id="SubCategoryForm" >
            <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="category">Category</label>
                            <select name="category" class="form-control " readonly id="category"  >
                                <option value="{{$category->id}}"  selected>{{$category->name}}</option>
                            </select>
                            <p></p>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"  class="form-control " placeholder="Name">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug"  readonly id="slug"  class="form-control" placeholder="Slug">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">status</label>
                            <select name="status" id="status" class=" form-control"  >
                                <option value="1"> Publish</option>
                                <option value="0"> Draft</option>
                            </select>
                            <p></p>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="showHome">show on Home</label>
                            <select name="showHome" id="showHome" class=" form-control"  >
                                <option value="1"> Yes</option>
                                <option value="0" selected> No</option>
                            </select>
                            <p></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{Route('sub_category.index',$category->id)}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>


        </form>
    </div>

@endsection







@section('script')
<script>
    $('#SubCategoryForm').submit(function (e){
        e.preventDefault();
        var form =$(this);
        $("button[type=submit]").prop('disabled',true);
        $.ajax({
            url:'{{Route("sub_category.store")}}',
            type:'post',
            data:form.serializeArray(),
            dataType:'json',
            success:function (response){
                $("button[type=submit]").prop('disabled',false);

                if(response['status'] === true){
                    window.location.href="{{route('sub_category.index',$category->id)}}";

                    $('#category').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                }else {
                    var errors = response['errors'];

                    if(errors['name']){

                        $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html([errors['name']]);

                    }else {
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if(errors['slug']){

                        $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html([errors['slug']]);

                    }else {
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                    if(errors['category_id']){

                        $('#category').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html([errors['category_id']]);

                    }else {
                        $('#category').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    }
                }


            },error:function (jqXHR,exception){
            console.log('something went wrong')
            }
        })
    });

    $('#name').change(function (){
        var name = $(this);
        $("button[type=submit]").prop('disabled',true);

        $.ajax({
            url:'{{Route('getslug')}}',
            type:'get',
            data:{title:name.val()},
            dataType:'json',
            success:function (response){
                $("button[type=submit]").prop('disabled',false);

                if(response['status']===true){
                    $('#slug').val(response["slug"]);
                }

            }
        });
    })



</script>
@endsection
