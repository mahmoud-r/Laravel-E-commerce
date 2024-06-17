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
    <li class="breadcrumb-item "><a href="{{route('products.index')}}">Products</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('products.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <form name="ProductForm"  action="" id="ProductForm" method="post">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                    <p class="error"></p>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="short_description">short Description</label>
                                    <textarea name="short_description" id="short_description" cols="20" rows="10" class="summernote" placeholder="short Description"></textarea>
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                    <p class="error"></p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Media</h2>
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                                <br>Drop files here or click to upload.<br><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="product_gallary">

                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Pricing</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="compare_price">Compare at Price</label>
                                    <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                    <p class="text-muted mt-3">
                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                    </p>
                                    <p class="error"></p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Inventory</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weight">Weight(G)</label>
                                    <input type="number" min="0" value="0" name="weight" id="weight" class="form-control" placeholder="G">
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty">Quantity</label>

                                    <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_order">Maximum Quantity per Order</label>
                                    <input type="number" min="0" value="0" readonly  name="max_order" id="max_order" class="form-control" placeholder="Maximum Quantity per Order">
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input"  checked id="max_check" >
                                        <label for="max_check" class="custom-control-label">Use Qty as the maximum quantity per order.</label>
                                    </div>
                                    <p class="error"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Related Products</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <select multiple class="relatedProducts w-100" name="relatedProducts[]" id="relatedProducts">
                                    </select>
                                    <p class="text-muted mt-3">
                                        If you leave this field empty, products within the same category will be considered as related products.

                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product status</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="1"> Publish</option>
                                <option value="0"> Draft</option>
                                <p class="error"></p>

                            </select>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4  mb-3">Product category</h2>
                        <div class="mb-3">
                            <label for="category">Category</label>
                            <select name="category_id" id="category_id" class="form-control">

                                <option value="">Select Category</option>

                            @forelse($categories as $category)

                                    <option value="{{$category->id}}">{{$category->name}}</option>

                                @empty
                                    <option disabled value="">Please add Category First</option>
                                @endforelse

                            </select>
                            <p class="error"></p>

                        </div>
                        <div class="mb-3">
                            <label for="category">Sub category</label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control">
                                <option value="">Select Sub category</option>

                            </select>
                            <p class="error"></p>

                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product brand</h2>
                        <div class="mb-3">
                            <select name="brand_id" id="brand_id" class="form-control">
                                <option value="">Select Brand</option>

                                @forelse($brands as $brand)

                                    <option value="{{$brand->id}}">{{$brand->name}}</option>

                                @empty
                                    <option disabled value="">Please add Brand First</option>
                                @endforelse
                            </select>
                            <p class="error"></p>

                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Featured product</h2>
                        <div class="mb-3">
                            <select name="is_featured" id="status" class="form-control">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <p class="error"></p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4  mb-3">More Info</h2>
                        <div class="mb-3">
                            <label for="warranty">Warranty</label>
                            <input type="text" name="warranty" value="1 Year Warranty" id="warranty" class="form-control" placeholder="warranty">
                            <p class="error"></p>

                        </div>
                        <div class="mb-3">
                            <label for="return">Return Policy</label>
                            <input type="text" name="return" value="30 Day Return Policy" id="return" class="form-control" placeholder="return">

                            <p class="error"></p>

                        </div>
                        <div class="mb-3">
                            <label for="cachDelivery">Cash on Delivery available</label>
                            <select name="cachDelivery" id="cachDelivery" class="form-control">

                                <option value="1" >Yes</option>
                                <option value="0" >No</option>
                            </select>
                            <p class="error"></p>


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{Route('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
    </form>
@endsection







@section('script')
<script>
    $('#max_check').on('change',function (){
        if(this.checked) {
            $('#max_order').val(0)
            $('#max_order').prop('readonly',true)
        }else {
            $('#max_order').prop('readonly',false)
        }

    })
    $('.relatedProducts').select2({
        ajax: {
            url: '{{ route('products.getProducts')}}',
            dataType: 'json',
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
    $('#ProductForm').submit(function (e){
        e.preventDefault();
        var formArray =$(this).serializeArray();
        $("button[type=submit]").prop('disabled',true);

        $.ajax({
            url:'{{route('products.store')}}',
            type : 'post',
            data:formArray,
            dataType:'json',
            success:function (response){
                $("button[type=submit]").prop('disabled',false);
                if(response.status == true){

                    $('.error').removeClass('invalid-feedback').html('');
                    $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                    window.location.href="{{route('products.index')}}";


                }else {
                    handleErrors(response.errors);
                    $("button[type=submit]").prop('disabled', false);
                }

            },error:function (xhr, status, error){
                var response = JSON.parse(xhr.responseText);
                handleErrors(response.errors);
                $("button[type=submit]").prop('disabled', false);
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

    $('#title').change(function (){
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

        url:  "{{ route('temp-images.create') }}",
        maxFiles: 10,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            // $("#image_id").val(response.image_id);

            var html = `<div class="col-md-3" id="image-row-${response.image_id}"><div class="card" >
                <input type="hidden" name="images_array[]" value="${response.image_id}">
                <img src="${response.ImagePath}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                    </div>
            </div></div>`;

            $('#product_gallary').append(html);

        },
        complete:function(file){
            this.removeFile(file)
        }
    });
    function deleteImage(id){
        $("#image-row-"+id).remove();
    }

    $('#category_id').change(function (){

        var category_id = $(this).val();
        $.ajax({
            url:'{{route('getsubcategory')}}',
            type:'get',
            data:{category_id :category_id},
            dataType: 'json',
            success:function (response){
                $('#sub_category__id').find('option').not(':first').remove();
                $.each(response['subCategory'],function (key,item){

                    $('#sub_category_id').append('<option value="' + item.id + '">' + item.name +'</option>');

                })
            },
            error:function (){
                console.log('something went wrong')
            }

        })
    })

</script>
@endsection
