@extends('admin.master')


@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
        .card-header{
            border-bottom: 1px solid rgba(4,32,69,.1);
        }
        .dropzone .dz-message {
             margin: 0;
        }
        .dropzone .dz-message div img{
            max-width: 100%;
        }

    </style>
@endsection

@section('title')Pages - Home Banners @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('pages.index')}}">Pages</a></li>
    <li class="breadcrumb-item active">Home Banners</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Home Banners</h1>
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
    <form name="HomeBannersForm"  action="" id="HomeBannersForm" method="post">
        <div class="container-fluid layout-navbar-fixed">
            <div class="row">
               <div class="col-md-9">
                   <div class="row">
                       @foreach($homeBanners as $key => $banner)
                           <div class="col-md-6">
                               <div class="card mb-3">
                                   <div class="card-header">
                                       <h5>{{$key}}</h5>
                                   </div>
                                   <div class="card-body">
                                       <div class="row">
                                           <div class="col-md-12">
                                               <div class="mb-3">
                                                   <label for="homeBanners[{{$key}}][link]">Url</label>
                                                   <input type="url" name="homeBanners[{{$key}}][link]" id="homeBanners[{{$key}}][link]" value="{{$homeBanners[$key]['link']}}" class="form-control " placeholder="Url">
                                                   <p class="error"></p>

                                               </div>
                                           </div>
                                           <div class="col-md-12">
                                               <div class="mb-3">
                                                   <label for="homeBanners[{{$key}}][status]">Status</label>
                                                   <select name="homeBanners[{{$key}}][status]" id="homeBanners[{{$key}}][status]" class="form-control">
                                                       <option value="1" {{$homeBanners[$key]['status'] == 1 ? 'selected' :''}}>Publish</option>
                                                       <option value="0" {{$homeBanners[$key]['status'] == 0 ? 'selected' :''}}>Draft</option>
                                                       <p class="error"></p>

                                                   </select>
                                                   <p class="error"></p>

                                               </div>
                                           </div>
                                           <div class="col-lg-12">
                                               <div class="mb-3">
                                                   <input type="hidden" value="{{$homeBanners[$key]['img']}}" class="image_id" name="homeBanners[{{$key}}][img]">

                                                   <label for="homeBanners[{{$key}}][img]">Image</label>
                                                   <div id="homeBanners[{{$key}}][img]" class="dropzone dz-clickable slider_img">
                                                       <div class="dz-message needsclick">
                                                           @if(!empty($homeBanners[$key]['img']))
                                                               <div>
                                                                   <img src="{{asset('uploads/home_banners/images/'.$homeBanners[$key]['img'])}}" alt="{{$key}}"  title="{{$key}}">
                                                               </div>
                                                           @else
                                                               <br>Drop files here or click to upload.<br><br>
                                                           @endif
                                                       </div>

                                                   </div>

                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       @endforeach
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
        Dropzone.autoDiscover = false;
        $(".slider_img").dropzone({
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
            addRemoveLinks: false,
            uploadMultiple: false,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                var parentElement = $(file.previewElement).closest('.dropzone').parent();
                var img = parentElement.find('.image_id')
                var name= img.attr('name');
                var inputs = {};
                inputs[name] = response.image_id;
                setSettings(inputs,img)
            },

        });
    </script>
    <script>
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                var nameKey = key.replace('.', '][');

                nameKey = nameKey.replace(/\./g, '][');

                nameKey = nameKey.replace('homeBanners]', 'homeBanners');

                if (nameKey.match(/\]$/) == null) {
                    nameKey += ']';
                }

                var $input = $(`[name='${nameKey}']`);
                $input.addClass('is-invalid');
                $input.siblings('p').addClass('invalid-feedback').html(`${value}`);
            });
        }
        function setSettings(inputs,img){
            $.ajax({
                url:'{{Route('pages.HomeBannersStore')}}',
                type:'post',
                data:inputs,
                dataType:'json',
                success:function (response){
                    if(response['status'] === true){

                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        })
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select,textarea,input[type='email']").removeClass('is-invalid')
                        img.val(response.img);
                    }else {
                        handleErrors(response.errors);

                    }
                },error:function (xhr){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);
                }
            })
        }

        $('#HomeBannersForm').submit(function (e){
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

    </script>


@endsection
