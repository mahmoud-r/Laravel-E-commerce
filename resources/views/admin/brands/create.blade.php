@extends('admin.master')

@section('title')  Brands  @endsection
@section('title-link')  {{route('brands.index')}}  @endsection
@section('sub-title')  Create  @endsection



@section('header_button')
    <a href="{{Route('brands.index')}}" class="btn btn-primary">Back</a>

@endsection
@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('brands.index')}}">Brands</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('brands.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="BrandForm" action="" id="BrandForm" >
            <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control " placeholder="Name">
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
                            <input type="hidden" value="" id="image_id" name="image_id">
                            <label for="image">Image</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>
                            </div>
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
                </div>
            </div>
        </div>

        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{Route('brands.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>


        </form>
    </div>

@endsection







@section('script')
<script>
    $('#BrandForm').submit(function (e){
        e.preventDefault();
        var form =$(this);
        $("button[type=submit]").prop('disabled',true);
        $.ajax({
            url:'{{Route('brands.store')}}',
            type:'post',
            data:form.serializeArray(),
            dataType:'json',
            success:function (response){
                $("button[type=submit]").prop('disabled',false);

                if(response['status'] === true){
                    window.location.href="{{route('brands.index')}}";

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


    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },
        url:  "{{ route('temp-images.create') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            console.log(response)
        }
    });

</script>
@endsection
