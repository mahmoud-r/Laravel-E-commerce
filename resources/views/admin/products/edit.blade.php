@extends('admin.master')

@section('style')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
            color:#000;
        }
        .card-header{
            border-bottom: 1px solid rgba(4,32,69,.1);
        }
        .card-img-top{
            max-height: 200px;
            object-fit: contain;
        }
    </style>
@endsection


@section('title')Products - {{$product->title}} @endsection

@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('products.index')}}">Products</a></li>
    <li class="breadcrumb-item active">{{$product->title}}</li>
@endsection
@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$product->title}}</h1>
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
            <div class="col-md-9">
                <!-- basic data -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="{{$product->title}}" id="title" class="form-control" placeholder="Title">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 input-group">
                                    <label for="slug">Permalink<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-flat" >
                                        <span class="input-group-text slug-text">{{url('/')}}/prodcut/</span>
                                        <input type="text" name="slug" value="{{$product->slug}}" id="slug" class="form-control slug-input" placeholder="Slug">
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
                                    <small class="form-hint mt-2 text-truncate">Preview: <a href="{{route('front.product',$product->slug)}}" target="_blank">{{route('front.product',$product->slug)}}</a></small>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description"  id="short_description" cols="25" rows="10" class="summernote" placeholder="short Description">
                                        {{$product->short_description}}
                                    </textarea>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description<span class="text-danger">*</span></label>
                                    <textarea name="description"  id="description" cols="30" rows="10" class="summernote" placeholder="Description">
                                        {{$product->description}}
                                    </textarea>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Attributes -->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Product Attributes</h4>
                            </div>
                        </div>
                    </div>
                    <p class="error"></p>
                    <table class="table table-vcenter card-table table-hover table-striped swatches-container text-center">
                        <thead class="header">
                        <tr>
                            <th width="3%">#</th>
                            <th width="30%">Attribute </th>
                            <th>Value </th>
                            <th width="3%">New </th>
                            <th width="3%"> Remove</th>
                        </tr>
                        </thead>

                        <tbody id="attributesSection">
                        @forelse($attributes as $i => $attribute)
                            @php
                                $productAttribute = $product->productAttributes->firstWhere('attribute_id', $attribute->id);
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <input type="text" readonly class="form-control" value="{{ $attribute->name }}">
                                </td>
                                <td>
                                    <select class="form-control" name="attributes[{{ $attribute->id }}]">
                                        <option value="">Select Value</option>
                                        @foreach($attribute->values as $value)
                                            <option value="{{ $value->id }}" {{ $productAttribute && $productAttribute->attribute_value_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-attrname="{{ $attribute->name }}" data-attrid="{{ $attribute->id }}" class="addNewAttrValue">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                    </a>
                                </td>
                                <td>

                                    <a href="javascript:void(0)" class="remove-item text-decoration-none text-danger remove-attribute" >
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 7l16 0"></path>
                                            <path d="M10 11l0 6"></path>
                                            <path d="M14 11l0 6"></path>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No attributes available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <div class="card-actions">
                                <button  class="dt-button btn dt-btn m-3 "  data-toggle="modal" data-target="#Add_new_Attribute" type="button">
                                    Add new Attribute
                                </button>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Product Media -->
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
                    @forelse($product->images as $image)
                        <div class="col-md-3" id="image-row-{{$image->id}}"><div class="card" >
                                <input type="hidden" name="images_array[]" value="{{$image->id}}">
                                <img src="{{asset('uploads/products/images/'.$image->image)}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <a href="javascript:void(0)" onclick="deleteImage({{$image->id}})" class="btn btn-danger">Delete</a>
                                </div>
                            </div></div>
                    @empty
                    @endforelse
                </div>

                <!-- Product Pricing -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h2 class="card-title" style="font-weight: 700">Pricing</h2>
                        <div class="card-actions float-right" >
                            <a href="javascript:void(0)" class="btn-trigger-show-flash-sale">
                                Flash Sale
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price<span class="text-danger">*</span></label>
                                    <input type="text" name="price" value="{{$product->getRawOriginal('price')}}" id="price" class="form-control" placeholder="Price">
                                    <p class="error"></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="compare_price">Compare at Price</label>
                                    <input type="text" name="compare_price" value="{{$product->getRawOriginal('compare_price')}}" id="compare_price" class="form-control" placeholder="Compare Price">
                                    <p class="text-muted mt-3">
                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                    </p>
                                    <p class="error"></p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Flash Sale -->
                <div class="card mb-3 flash-sale-section" style="display:none;">
                    <div class="card-body">
                        <h2 class="h4 mb-3 ">Flash Sale</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="flash_sale_price">Sale Price<span class="text-danger">*</span></label>
                                    <input type="text" name="flash_sale_price" value="{{$product->flash_sale_price}}" id="flash_sale_price" class="form-control" placeholder="Sale Price">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="flash_sale_expiry_date">Price expiry Date</label>
                                    <input type="text" name="flash_sale_expiry_date" value="{{$product->flash_sale_expiry_date}}" id="flash_sale_expiry_date" class="form-control" placeholder="Price expiry Date">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="flash_sale_qty">Quantity For Sale</label>
                                    <input type="number" min="0" name="flash_sale_qty" value="{{$product->flash_sale_qty}}" id="flash_sale_qty" class="form-control" placeholder="Quantity For Sale">
                                    <p class="error"></p>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="flash_sale_qty_solid">Quantity solid</label>
                                    <input type="number" min="0" name="flash_sale_qty_solid" value="{{$product->flash_sale_qty_solid}}" id="flash_sale_qty_solid" class="form-control" placeholder="Start Quantity solid">
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Inventory -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Inventory</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sku">SKU (Stock Keeping Unit)<span class="text-danger">*</span></label>
                                    <input type="text" value="{{$product->sku}}" name="sku" id="sku" class="form-control" placeholder="sku">
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weight">Weight(g)</label>
                                    <input type="number" min="0" name="weight" value="{{$product->weight}}" id="weight" class="form-control" placeholder="weight">
                                    <p class="error"></p>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty">Quantity<span class="text-danger">*</span></label>
                                    <input type="number" min="0" value="{{$product->getRawOriginal('qty')}}" name="qty" id="qty" class="form-control" placeholder="Qty">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_order">Maximum Quantity per Order</label>
                                    <input type="number" min="0" value="{{$product->max_order}}" {{$product->max_order ==0?'readonly': ''}}  name="max_order" id="max_order" class="form-control" placeholder="Maximum Quantity per Order">
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input"  {{$product->max_order ==0?'checked': ''}} id="max_check" >
                                    <label for="max_check" class="custom-control-label">Use Qty as the maximum quantity per order.</label>
                                    </div>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Products -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Related Products</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                <select multiple class="relatedProducts w-100" name="relatedProducts[]" id="relatedProducts">
                                    @if(!empty($relatedProduct))
                                        @foreach($relatedProduct as $relProduct)
                                            <option selected value="{{$relProduct->id}}">{{$relProduct->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                    <p class="text-muted mt-3">
                                        If you leave this field empty, products within the same category will be considered as related products.

                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Seo -->
                <div class="card mb-3" id="seo_wrap">
                    <div class="card-header">
                        <h4 class="card-title">Search Engine Optimize</h4>
                        <div class="card-actions float-right" >
                            <a href="javascript:void(0)" class="btn-trigger-show-seo-detail">
                                Edit SEO meta
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="seo-preview" v-pre="">
                            <div class="existed-seo-meta">
                                <h4 class="page-title-seo text-truncate">
                                    {{$product->seo_title}}
                                </h4>
                                <div class="page-url-seo">
                                    <p>{{route('front.product',$product->slug)}}</p>
                                </div>

                                <div>
                                <span style="color: #70757a;">{{\carbon\Carbon::parse($product->created_at)->format('M d,Y')}}- </span>
                                    <span class="page-description-seo">
                                        {{$product->seo_description}}
                                     </span>
                                </div>
                            </div>
                        </div>

                        <div class="seo-edit-section" v-pre="" style="display:none;">
                            <hr class="my-4">
                            <div class="mb-3 position-relative">
                                <label for="seo_title" class="form-label">SEO Title</label>
                                <input class="form-control" data-counter="70" value="{{$product->getRawOriginal('seo_title')}}" placeholder="SEO Title" data-allow-over-limit="" name="seo_title" type="text" id="seo_title">
                                <small class="charcounter"></small>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="seo_description" class="form-label">SEO description</label>
                                <textarea class="form-control" data-counter="160" rows="3" placeholder="SEO description" data-allow-over-limit="" name="seo_description" cols="50" id="seo_description">{{$product->getRawOriginal('seo_description')}}</textarea>
                                <small class="charcounter"></small>
                                <p class="error"></p>
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="seo_meta[index]" class="form-label">Index</label>
                                <div class="position-relative form-check-group mb-3">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" id="seo_index" type="radio" name="seo_index" value="index" {{$product->seo_index == 'index'?'checked':''}}>
                                        <span class="form-check-label">Index</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" id="seo_noindex" type="radio" name="seo_index" value="noindex" {{$product->seo_index == 'noindex'?'checked':''}}>
                                        <span class="form-check-label">No index</span>
                                    </label>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- sidebar-->
            <div class="col-md-3">

                <!-- Publish-->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Publish</h4>
                    </div>
                    <div class="card-body">
                        <div class="btn-list">
                            @can('product-edit')
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
                            <a href="{{Route('products.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                        </div>
                    </div>
                </div>

                <!-- Product status-->
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product status</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{$product->status == 1 ? 'selected' :''}}>Publish</option>
                                <option value="0" {{$product->status == 0 ? 'selected' :''}}>Draft</option>
                                <p class="error"></p>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Product category-->
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4  mb-3">Product category</h2>
                        <div class="mb-3">
                            <label for="category">Category<span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @forelse($categories as $category)
                                    <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' :''}}>{{$category->name}}</option>
                                @empty
                                    <option disabled value="">Please add Category First</option>
                                @endforelse
                            </select>
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="category">Sub category<span class="text-danger">*</span></label>
                            <select name="sub_category_id" id="sub_category_id" class="form-control">
                                <option value="">Select Sub category</option>
                                @forelse($subCategories as $subCategory)

                                    <option value="{{$subCategory->id}}" {{$product->sub_category_id == $subCategory->id ? 'selected' :''}}>{{$subCategory->name}}</option>

                                @empty
                                    <option disabled value="">Please add Category First</option>
                                @endforelse
                            </select>
                            <p class="error"></p>

                        </div>
                    </div>
                </div>

                <!-- Product brand-->
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product brand<span class="text-danger">*</span></h2>
                        <div class="mb-3">
                            <select name="brand_id" id="brand_id" class="form-control">
                                <option value="">Select Brand</option>
                                @forelse($brands as $brand)
                                    <option value="{{$brand->id}}" {{$product->brand_id == $brand->id ? 'selected' : ''}}>{{$brand->name}}</option>
                                @empty
                                    <option disabled value="">Please add Brand First</option>
                                @endforelse
                            </select>
                            <p class="error"></p>

                        </div>
                    </div>
                </div>

                <!-- Product collections-->
                <div class="card">
                    <div class="card-header">
                        <label for="product_collections[]">Product collections</label>
                    </div>
                    <div class=" card-body">
                        <fieldset class="form-fieldset fieldset-for-multi-check-list">
                            <div class="multi-check-list-wrapper">
                                @forelse($collections as $collection)
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input" id="product-collections-item-{{$collection->id}}" value="{{$collection->id}}" name="product_collections[]" {{in_array($collection->id,$product->collections->pluck('id')->toArray())? 'checked':''}}>
                                        <label for="product-collections-item-{{$collection->id}}" class="custom-control-label">{{$collection->name}}</label>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </fieldset>
                    </div>
                </div>

                <!-- Product More Info-->
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4  mb-3">More Info</h2>
                        <div class="mb-3">
                            <label for="warranty">Warranty</label>
                            <input type="text" name="warranty" value="{{$product->warranty}}" id="warranty" class="form-control" placeholder="warranty">
                            <p class="error"></p>

                        </div>
                        <div class="mb-3">
                            <label for="return">Return Policy</label>
                            <input type="text" name="return" value="{{$product->return}}" id="return" class="form-control" placeholder="return">

                            <p class="error"></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    @include('admin.products.models.AddNewAttribute')
    @include('admin.products.models.AddNewValue')

@endsection







@section('script')

    <script>
        @can('product-edit')
            //update product
            $('#ProductForm').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();

            $.ajax({
                url:'{{route('products.update',$product->id)}}',
                type : 'put',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status == true){
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        window.location.href="{{route('products.index')}}";


                    }else {
                        handleErrors(response.errors);
                    }


                },error:function (xhr, status, error){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);


                }
            })
        });

            //upload Images
            Dropzone.autoDiscover = false;
            const dropzone = $("#image").dropzone({

                url:  "{{ route('product_update_images') }}",
                maxFiles: 10,
                paramName: 'image',
                params:{'product_id' :'{{$product->id}}'},
                addRemoveLinks: true,
                acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
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

            //Delete Images
            function deleteImage(id){
                Swal.fire({
                    title: "Do you want to Delete This Image ?",
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                    confirmButtonColor: "#dc3545",
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = '{{Route("product_delete_images")}}';
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data :{id:id},
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            },success: function (response) {

                                if(response['status'] === true){
                                    Swal.fire("Deleted!", "", "success");
                                    $("#image-row-"+id).remove();
                                }else {
                                    console.log('something went wrong')
                                }
                            }

                        });
                    }
                });
            }
        @endcan
</script>
    <!-- Product Script-->
    @include('admin.products.productScript')
@endsection
