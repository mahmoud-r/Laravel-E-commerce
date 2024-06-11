@extends('front.layouts.app')


@section('title')@endsection

@section('style')
    <style>
        .address-default{
            border: 1px solid var(--text-primary) !important;
        }
        .dashboard_content .card{
            border-radius: 15px;
        }
        .default-badge{
            background-color: var(--text-primary) !important;
            border-radius: 5px;
        }
        .select2-selection__choice{
            background-color: var(--bs-gray-200);
            border: none !important;
            font-size: 12px;
            font-size: 0.85rem !important;
        }
        .add-card{
            height: 290px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #565959;
            border-style: dashed;
            border-width: 2px;
            box-sizing: border-box;
            border-color: #C7C7C7;
            border-radius: 15px;


        }
        .ti-plus{
            font-size: 50px;
            color: #565959;
            font-weight: 800;
        }
    </style>
@endsection
@section('breadcrumb')
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Address</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('front.profile')}}">My Account</a></li>
                        <li class="breadcrumb-item active">Address</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>

@endsection
@section('content')

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                @include('front.profile.menu')
                <div class="col-lg-9 col-md-8">
                    <div class=" dashboard_content">
                        <div class="row" id="addresses">
                            @forelse($addresses as $address)
                                <div class="col-lg-6 " id="address_{{$address->id}}" style="{{$address->is_primary == true ? '    order: -1' : ''}} ">
                                    <div class="card mb-3 mb-lg-4 {{$address->is_primary == true ? 'address-default' : ''}} " >
                                        <div class="card-header">
                                            @if($address->is_primary == true)
                                                <span class="pr_flash default-badge" style="right: 10px;left: unset ">Default</span>
                                            @endif

                                            <h3>{{$address->address_name}}</h3>
                                        </div>
                                        <div class="card-body">
                                            <address>{{$address->first_name}} {{$address->last_name}}</address>
                                            <address>{{$address->building}},{{$address->street}},</address>
                                            <address>{{$address->district}},{{$address->city->city_name_en}},{{$address->governorate->governorate_name_en}}</address>
                                            <address>{{$address->nearest_landmark}}</address>
                                            <address>{{$address->phone}} & {{$address->second_phone}}</address>
                                            <a href="javascript:void(0)" onclick="editAddress({{$address->id}})" class="btn btn-fill-out">Edit</a>
                                            <a href="javascript:void(0)" onclick="deleteAddress({{$address->id}},'{{$address->address_name}}')" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @empty

                            @endforelse
                                <div class="col-lg-6  " id="" style="order: -2">
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#create-user-address">

                                        <div class="card mb-3 mb-lg-4" >

                                            <div class="card-body add-card">
                                                <i class="ti-plus mb-3" ></i>
                                                <h3 class="">Add Address</h3>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->
    @include('front.profile.addresses.create_model')
    <div id="edit_address"></div>
@endsection
@section('script')
    <script>
        $('#create-user-address').on('shown.bs.modal', function () {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');
        })

        $('#AddressCreateForm').submit(function (e){
            e.preventDefault();
            var form =$(this);
            $.ajax({
                url:'{{ route('front.address.store') }}',
                type:'post',
                data:form.serializeArray(),
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function (response){
                    if(response.status == true){

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                        $('#create-user-address').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        })
                        $('#addresses').html(response.view);
                        document.documentElement.scrollTop = 100;
                    }else {
                        handleErrors(response.errors);
                    }


                },error:function (jqXHR){
                    handleErrors(jqXHR.responseJSON.errors);
                }
            })
        });

        function editAddress(id){
            var url ='{{route('front.address.edit','ID')}}';
            var newUrl =url.replace('ID',id);
            $.ajax({
                url: newUrl,
                type: 'get',
                data:id,
                success: function (response) {
                    $('#create-user-address').modal('dispose');
                    $('#edit_address').html(response);
                    $('#edit-user-address').modal('show');

                }
            });
        }

        $(document).on('submit', '#AddressUpdateForm', function (e) {
            e.preventDefault();
            var formArray = $(this).serializeArray();
            var addressId = formArray.find(item => item.name === 'address_id').value;
            var url = '{{ route('front.address.update', 'ID') }}';
            var newUrl = url.replace('ID', addressId);

            $.ajax({
                url: newUrl,
                type: 'PUT',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], input[type='number'], select").removeClass('is-invalid');
                        $('#edit-user-address').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        });

                        $('#addresses').html(response.view);
                        document.documentElement.scrollTop = 100;
                    } else {

                        handleErrors(response.errors);
                    }
                },
                error: function (jqXHR) {
                    handleErrors(jqXHR.responseJSON.errors);
                }
            });
        });
        function handleErrors(errors) {
            $('.error').removeClass('invalid-feedback').html('');
            $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

            $.each(errors, function (key, value) {
                $(`.${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
            });
        }

        function deleteAddress(id,name) {
            Swal.fire({
                title: "Do you want to Delete "+name+"?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{Route("front.address.destroy","ID")}}';
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
                                $('#address_' + id).remove();
                            }else {
                                console.log('something went wrong')
                            }
                        }

                    });
                }
            });
        }




        $(document).ready(function () {
            function fetchCities(governorateId, selectedCityId) {
                $.ajax({
                    url: '{{ route('front.getCities') }}',
                    type: 'get',
                    data: { governorate_id: governorateId },
                    dataType: 'json',
                    success: function (response) {
                        $('.city_id').find('option').not(':first').remove();
                        $.each(response['cities'], function (key, item) {
                            $('.city_id').append('<option value="' + item.id + '">' + item.city_name_en + '</option>');
                        });
                        if (selectedCityId) {
                            $('#city_id').val(selectedCityId);
                        }
                    }
                });
            }

            $(document).on('change', '.governorate_id', function () {
                var governorateId = $(this).val();
                fetchCities(governorateId);
            });
        });


    </script>

@endsection




