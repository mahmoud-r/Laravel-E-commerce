@extends('admin.master')

@section('title')  Attributes  @endsection
@section('title-link')  {{route('attributes.index')}}  @endsection
@section('sub-title')  Create  @endsection



@section('header_button')
    <a href="{{Route('brands.index')}}" class="btn btn-primary">Back</a>

@endsection
@section('breadcrumb')
    <li class="breadcrumb-item "><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="{{route('attributes.index')}}">Attribute Groups</a></li>
    <li class="breadcrumb-item active">{{$category->name}}</li>
@endsection

@section('title')Attribute - create @endsection

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$category->name}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{Route('attributes.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
@section('content')
    <div class="container-fluid">
        <form method="post" name="AttributeForm" action="" id="AttributeForm" >
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="hidden" name="category_id" value="{{$category->id}}">
                                <label for="Attributes">Attributes</label>
                                <select name="attribute" id="Attributes" class=" form-control">
                                    <option value=""> Create new</option>
                                    @forelse($category->attributes as $attribute)
                                        <option value="{{$attribute->id}}"> {{$attribute->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <p class="error"></p>

                            </div>
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name"  id="name" class="form-control " placeholder="Name">
                                <p class="error"></p>
                            </div>

                            <div class="pt-3">
                                @can('attribute-create')
                                <button type="submit" class="btn btn-primary">Create</button>
                                @endcan
                                <a href="{{Route('attributes.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title">
                                        Values list
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <p class="error"></p>
                        <table class="table table-vcenter card-table table-hover table-striped swatches-container text-center">
                            <thead class="header">
                            <tr>
                                <th>Value </th>
                                <th width="5%"> Remove</th>
                            </tr>
                            </thead>

                            <tbody class="ui-sortable" id="values_section">

                            <tr>
                                <td>
                                    <input type="text" required name="values[]" class="form-control" value="">
                                </td>
                                <td>
                                    <a href="javascript:(0)" class="remove-item text-decoration-none text-danger" onclick="removeValue(this)">
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
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <div class="card-actions">
                                    <button  class="dt-button btn dt-btn m-3 "  onclick="addValue()" type="button">
                                        Add new Value
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </form>
    </div>

@endsection







@section('script')
    <script>
        @can('attribute-create')
        $('#AttributeForm').submit(function (e){
            e.preventDefault();
            var formArray =$(this).serializeArray();
            $.ajax({
                url:'{{route('attributes.store')}}',
                type : 'post',
                data:formArray,
                dataType:'json',
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        var attributeUrl = '{{ route("attributes.edit", ":id") }}'.replace(':id', response.id);

                        window.location.href = attributeUrl

                    }else {
                        handleErrors(response.errors);
                    }

                },error:function (xhr, status, error){
                    var response = JSON.parse(xhr.responseText);
                    handleErrors(response.errors);
                    $("button[type=submit]").prop('disabled', false);
                    console.log('something went wrong');

                }
            })
        });
        @endcan
        $('#Attributes').on('change',function (){
            var Attribute = this.value

            if (Attribute){
                var attributeUrl = '{{ route("attributes.edit", ":id") }}'.replace(':id', Attribute);
            }else {
                var attributeUrl = '{{ route("attributes.create",$category->id ) }}';
            }
            window.location.href = attributeUrl


        })

        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });}

        function addValue() {
            var valuesSection = document.getElementById('values_section');
            var input = `<tr>
                    <td>
                        <input type="text" required name="values[]" class="form-control" value="">
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="remove-item text-decoration-none text-danger" onclick="removeValue(this)">
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
                </tr>`;
            valuesSection.insertAdjacentHTML('beforeend', input);
        }
        function removeValue(element) {
            element.closest('tr').remove();
        }
    </script>
@endsection
