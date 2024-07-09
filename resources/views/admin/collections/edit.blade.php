@extends('admin.master')

@section('style')
    <style>
    .select2-selection__choice{
        display: none;
    }
    .list-group-item.active, .list-group-item:active, .list-group-item:focus, .list-group-item:hover {
        background-color: rgba(108, 122, 145, .08);
    }
    </style>
@endsection
@section('title')Collections - {{$Collection->name}} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('collections.index')}}">Collections</a></li>
    <li class="breadcrumb-item active">{{$Collection->name}}</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$Collection->name}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('collections.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')

    <div class="container-fluid">
        <form method="post" name="CollectionForm" action="" id="CollectionForm" >
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="{{$Collection->name}}" id="name" class="form-control" placeholder="Name">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" value="{{$Collection->slug}}" readonly id="slug" class="form-control" placeholder="Slug">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Products</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select multiple class="Products w-100" name="products[]" id="Products" >
                                            @if(!empty($Collection->products))
                                                @foreach($Collection->products as $product)
                                                    <option selected value="{{$product->id}}">{{$product->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        <div class="list-group list-group-flush list-group-hoverable list-selected-products mt-3" style="">
                                            <label class="form-label">Selected products</label>

                                            @forelse($Collection->products as $product)
                                            <div class="list-group-item" data-product-id="{{$product->id}}">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="avatar" style="background-image: url('{{!empty($product->images->first()) ? asset('uploads/products/images/thumb/'.$product->images->first()->image):  asset('front_assets/images/empty-img.png')}}')"></span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        <a href="{{route('products.edit',$product->id)}}" class="text-body d-block" target="_blank">{{$product->title}}</a>
                                                        <div class="text-secondary text-truncate">
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="javascript:void(0)" data-bb-toggle="product-delete-item" data-bb-target="{{$product->id}}" class="text-decoration-none list-group-item-actions btn-trigger-remove-selected-product" title="Delete">
                                                            <svg class="icon text-secondary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M18 6l-12 12"></path>
                                                                <path d="M6 6l12 12"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
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
                                @can('collection-edit')
                                <button class="btn btn-primary" type="submit" value="apply" name="submitter">
                                    <svg class="icon icon-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M14 4l0 4l-6 0l0 -4"></path>
                                    </svg>
                                    Save
                                </button>
                                @endcan
                                <a href="{{Route('collections.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>


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
                                <option value="1" {{$Collection->status == 1 ? 'selected':''}}>Published</option>
                                <option value="0" {{$Collection->status == 0 ? 'selected':''}}>Draft</option>
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
        @can('collection-edit')
        $('#CollectionForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{Route('collections.update',$Collection->id)}}',
                type:'put',
                data:form.serializeArray(),
                dataType:'json',
                success:function (response){

                    if(response.status == true){
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        window.location.href="{{route('collections.index')}}";
                    }else {
                        handleErrors(response.errors);
                    }
                },error:function (jqXHR,exception){
                    console.log('something went wrong')
                }
            })
        });

        @endcan
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });}

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
        $('.Products').select2({
            ajax: {
                url: '{{ route('collections.getProducts')}}',
                dataType: 'json',
                placeholder:'Search Products',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function (data) {
                    return {
                        results: data.tags
                    };
                }
            }

        });


        $('.Products').on('select2:select', function (e) {
            var product = e.params.data;
            addProductToList(product);
        });

        $('.Products').on('select2:unselect', function (e) {
            var product = e.params.data;
            removeProductFromList(product.id);
        });

        function addProductToList(product) {
            var listGroup = $('.list-selected-products');
            var productUrl = '{{ route("products.edit", ":id") }}'.replace(':id', product.id);
            var item = `
        <div class="list-group-item" data-product-id="${product.id}">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="avatar" style="background-image: url('${product.img}')"></span>
                </div>
                <div class="col text-truncate">
                    <a href="${productUrl}" class="text-body d-block" target="_blank">${product.text}</a>
                    <div class="text-secondary text-truncate">
                    </div>
                </div>
                <div class="col-auto">
                    <a href="javascript:void(0)" data-bb-toggle="product-delete-item" data-bb-target="${product.id}" class="text-decoration-none list-group-item-actions btn-trigger-remove-selected-product" title="Delete">
                        <svg class="icon text-secondary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 6l-12 12"></path>
                            <path d="M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    `;
            listGroup.append(item);
        }

        function removeProductFromList(productId) {
            $(`.list-selected-products .list-group-item[data-product-id="${productId}"]`).remove();
        }

        $(document).on('click', '.btn-trigger-remove-selected-product', function () {
            var productId = $(this).data('bb-target');
            var select2Element = $('.Products');
            var selectedValues = select2Element.val();

            if (selectedValues.includes(productId.toString())) {
                select2Element.val(selectedValues.filter(id => id != productId.toString())).trigger('change');
            }

            removeProductFromList(productId);
        });


    </script>

@endsection
