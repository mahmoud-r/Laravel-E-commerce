@extends('admin.master')

@section('style')
    <style>

        .markdown>table thead th, .table thead th {
            background: #f6f8fb;
            color: #6c7a91;
            font-size: .625rem;
            font-weight: 600;
            letter-spacing: .04em;
            line-height: 1rem;
            padding-bottom: .5rem;
            padding-top: .5rem;
            text-transform: uppercase;
            white-space: nowrap;
        }
    </style>
@endsection
@section('title')Pages - Home Slider @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('pages.index')}}">Pages</a></li>
    <li class="breadcrumb-item active">Home Slider</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Home Slider</h1>
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

    <div class="container-fluid">
        <form method="post" name="SliderForm" action="" id="SliderForm" >
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"> Home Slider</h3>
                                <div class="card-tools">
                                    <a href="javascript:void(0)" class="btn btn-primary"  data-toggle="modal" data-target="#create-slide">New Slide</a>
                                </div>
                            </div>

                        <div class="card-body">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Sort</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                @forelse($sliders as $i=>$slider)
                                    <tr id="slider_{{$slider->id}}">
                                        <td>{{$i+1}}</td>
                                        <td> {{$slider->title ?:'Not set'}}</td>
                                        <td>{{$slider->sort}}</td>
                                        <td>
                                            @if($slider->status == '1')
                                            <span class="badge bg-success text-success-fg">Published</span>
                                            @else
                                            <span class="badge bg-secondary text-secondary-fg">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="editSlide({{$slider->id}})">
                                                <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                            </a>
                                            <a href="javascript:void(0)" onclick="deleteSlide({{$slider->id}},'slide')" class="text-danger w-4 h-4 mr-1">
                                                <svg  class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path	ath fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center"> Currently, there are no Slider yet.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer clearfix">
                            {{$sliders->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@include('admin.slider.create')
    <div id="edit_slide_parent"></div>
@endsection







@section('script')
    <script>
        $('#SliderCreateForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{ route('HomeSlider.store') }}',
                type:'post',
                data:form.serializeArray(),
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (response){
                    if(response.status == true){
                        window.location.reload();
                    }else {
                        handleErrors(response.errors);
                    }


                },error:function (jqXHR){
                    handleErrors(jqXHR.responseJSON.errors);
                }
            })
        });
        function editSlide(id){
            var url ='{{route('HomeSlider.edit','ID')}}';
            var newUrl =url.replace('ID',id);
            $.ajax({
                url: newUrl,
                type: 'get',
                data:id,
                success: function (response) {
                    $('#create-slide').modal('dispose');
                    $('#edit_slide_parent').html(response);
                    $('#edit_slide').modal('show');
                    initializeDropzone(".image_dropzone");
                }
            });
        }
        $(document).on('submit', '#SliderUpdateForm', function (e) {
            e.preventDefault();
            var formArray = $(this).serializeArray();
            var sliderId = formArray.find(item => item.name === 'slider_id').value;
            var url = '{{ route('HomeSlider.update', 'ID') }}';
            var newUrl = url.replace('ID', sliderId);

            $.ajax({
                url: newUrl,
                type: 'PUT',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        window.location.reload();
                    } else {

                        handleErrors(response.errors);
                    }
                },
                error: function (jqXHR) {
                    handleErrors(jqXHR.responseJSON.errors);
                }
            });
        });
        function deleteSlide(id,name) {
            Swal.fire({
                title: "Do you want to Delete "+name+"?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{Route("HomeSlider.destroy","ID")}}';
                    var newUrl =url.replace('ID',id)
                    $.ajax({
                        url: newUrl,
                        type: 'DELETE',
                        data: '',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },success: function (response) {

                            if(response['status'] === true){
                                Swal.fire("Deleted!", "", "success");
                                $('#slider_' + id).remove();
                            }else {
                                console.log('something went wrong')
                            }
                        }

                    });
                }
            });
        }
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`.${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });
        }

        Dropzone.autoDiscover = false;

        function initializeDropzone(selector) {
            $(selector).each(function() {
                if (!$(this)[0].dropzone) { // تحقق من عدم وجود Dropzone على العنصر
                    $(this).dropzone({
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
                        acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(file, response) {
                            var parentElement = $(file.previewElement).closest('.dropzone').parent();
                            var img = parentElement.find('.image_id');
                            img.val(response.image_id);
                        }
                    });
                }
            });
        }
        $(document).ready(function() {
            initializeDropzone(".image_dropzone");
        });

    </script>
@endsection
