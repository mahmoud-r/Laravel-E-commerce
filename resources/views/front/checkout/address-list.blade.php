@forelse(auth()->user()->addresses()->get() as $address )
    <div class="form-check mb-4" id="{{$address->id}}">
        <label class="form-check-label" for="{{$address->address_name}}">
            <input type="radio" value="{{$address->id}}" name="address" class="form-check-input" id="{{$address->address_name}}" >
            <span><strong>{{$address->address_name}}</strong></span>,
            <span>{{$address->first_name}} {{$address->last_name}}</span>,
            <span>{{$address->building}}</span>,
            <span>{{$address->street}}</span>,
            <span>{{$address->district}},{{$address->city->city_name_en}},{{$address->governorate->governorate_name_en}}</span>,
            <span>{{$address->nearest_landmark}}</span>,
            <span>{{$address->phone}}</span>,
            <span>{{$address->second_phone}}</span>
            <a href="javascript:void(0)" onclick="editAddress({{$address->id}})" class="text-primary">Edit</a>

        </label>
    </div>

@empty
@endforelse
