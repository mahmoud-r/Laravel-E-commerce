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
