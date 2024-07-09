@extends('admin.master')


@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
        .card-header{
            border-bottom: 1px solid rgba(4,32,69,.1);
        }
    </style>
@endsection

@section('title')Pages - term & condition @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('pages.index')}}">Pages</a></li>
    <li class="breadcrumb-item active">term & condition</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>term & condition</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('pages.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <form name="aboutForm"  action="" id="aboutForm" method="post">
        <div class="container-fluid layout-navbar-fixed">
            <div class="row">
                <div class="col-md-9">

                    <!--Basic -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Basic</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="term-condition[title]" id="title" value="{{$page['title']}}" class="form-control " placeholder="Title">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 input-group">
                                        <label for="slug">Permalink<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-flat" >
                                            <span class="input-group-text slug-text">{{url('/')}}/</span>
                                            <input type="text" name="term-condition[slug]" value="{{$page['slug']}}" id="slug" class="form-control slug-input" placeholder="Slug">
                                            <span class="input-group-text slug-actions">
                                            <a href="javascript:void(0)" class="link-secondary" id="generate-slug">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                  <path d="M6 21l15 -15l-3 -3l-15 15l3 3"></path>
                                                  <path d="M15 6l3 3"></path>
                                                  <path d="M9 3a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2"></path>
                                                  <path d="M19 13a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2"></path>
                                                </svg>
                                            </a>
                                        </span>
                                        </div>
                                        <small class="form-hint mt-2 text-truncate">Preview: <a href="{{route('front.page.term-condition')}}" target="_blank">{{route('front.page.term-condition')}}</a></small>
                                        <p class="error"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Page Content</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="term-condition[content]"  id="term-condition[content]" cols="30" rows="10" class="summernote" placeholder="Content">
                                        {{$page['content']}}
                                    </textarea>

                                        <p class="error"></p>
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

                                <a href="{{Route('pages.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </form>


@endsection







@section('script')

    <script>
        $('#aboutForm').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();

            $.ajax({
                url:'{{route('pages.store')}}',
                type : 'post',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')

                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        })

                    }else {
                        handleErrors(response.errors);
                    }

                },error:function (xhr, status, error){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);
                    console.log('Error:', response.errors);

                }
            })
        });
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                var nameKey = key.replace('.', '][');

                nameKey = nameKey.replace(/\./g, '][');

                nameKey = nameKey.replace('contact]', 'contact');

                if (nameKey.match(/\]$/) == null) {
                    nameKey += ']';
                }


                var $input = $(`[name='${nameKey}']`);
                $input.addClass('is-invalid');
                $input.siblings('p').addClass('invalid-feedback').html(`${value}`);
            });
        }


        //Generate Slug
        $(document).on('click','#generate-slug',function (){
            var name = $('#title').val()
            $.ajax({
                url:'{{Route('getslug')}}',
                type:'get',
                data:{title:name},
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
