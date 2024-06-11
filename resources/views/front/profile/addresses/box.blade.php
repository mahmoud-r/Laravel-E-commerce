
<div class="col-md-10" id="selected-address">
    <input type="hidden" name="address" class="form-check-input" value="{{$address->id}}" id="{{$address->address_name}}" data-governorate="{{$address->governorate->id}}">
    <div class="card mb-3 mb-lg-4 {{$address->is_primary == true ? 'address-default' : ''}} " >
        <div class="card-header" role="tablist">
            <h5>{{$address->address_name}}
                <button  id="address-tab-button" data-bs-toggle="tab" data-bs-target="#tab-address" type="button" role="tab" aria-controls="tab-address" aria-selected="true" class="btn btn-fill-out btn-sm float-end">Change</button>
            </h5>
        </div>
        <div class="card-body">
            <address>{{$address->first_name}} {{$address->last_name}}</address>
            <address>{{$address->building}},{{$address->street}},</address>
            <address>{{$address->district}},{{$address->city->city_name_en}},{{$address->governorate->governorate_name_en}}</address>
            <address>{{$address->nearest_landmark}}</address>
            <address>{{$address->phone}} & {{$address->second_phone}}</address>
        </div>
    </div>
</div>
