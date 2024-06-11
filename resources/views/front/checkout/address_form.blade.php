<div class="form-group mb-3">
    <label for="address_name" class="form-label ">Address Name<span class="text-danger">*</span></label>
    <input id="address_name" type="text"
           class="form-control address_name @error('address_name') is-invalid @enderror" name="address_name"
           value="{{ old('address_name') }}" required  autofocus placeholder="Like 'Home'">
    @error('address_name')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
    <p class="error"></p>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="first_name" class="form-label">First Name<span class="text-danger">*</span></label>
            <input id="first_name" type="text"
                   value="{{ old('first_name') }}"
                   class="form-control first_name @error('first_name') is-invalid @enderror" name="first_name"
                   required  placeholder="">
            @error('first_name')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <p class="error"></p>

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="last_name" class="form-label ">Last Name<span class="text-danger">*</span></label>
            <input id="last_name" type="text"
                   value="{{ old('last_name') }}"
                   class="form-control last_name @error('last_name') is-invalid @enderror" name="last_name"
                   required  placeholder="">
            @error('last_name')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <p class="error"></p>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-md-6">

        <div class="form-group mb-3">
            <label for="phone" class="form-label phone">Phone Number<span class="text-danger">*</span></label>
            <input id="phone" type="number"
                   required
                   value="{{ old('phone') }}"
                   class="form-control @error('phone') is-invalid @enderror" name="phone"
                   placeholder="01xxxxxxxxx">
            @error('phone')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <p class="error"></p>

        </div>


    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="second_phone" class="form-label">Second Phone Number</label>

            <input id="second_phone" type="number"
                   value="{{ old('second_phone') }}"
                   class="form-control second_phone @error('second_phone') is-invalid @enderror" name="second_phone"
                   placeholder="01xxxxxxxxx">
            @error('second_phone')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <p class="error"></p>

        </div>

    </div>
</div>
<div class="form-group mb-3">
    <label for="street" class="form-label">Street Name<span class="text-danger">*</span></label>

    <input id="street" type="text"
           value="{{ old('street') }}"

           required
           class="form-control @error('street') is-invalid @enderror" name="street"
           placeholder="Talaat Harb Street">
    @error('street')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
    <p class="error"></p>

</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="building" class="form-label">Building name/no<span class="text-danger">*</span></label>

            <input id="building" type="text"
                   required
                   value="{{ old('building') }}"
                   class="form-control @error('building') is-invalid @enderror" name="building"
                   placeholder="Princess Tower">
            @error('building')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <p class="error"></p>

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="district" class="form-label">District</label>
            <input id="district" type="text"
                   value="{{ old('district') }}"
                   class="form-control district @error('district') is-invalid @enderror" name="district"
                   placeholder="7th District">
            @error('district')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <p class="error"></p>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="governorate_id" class="form-label">Governorate<span class="text-danger">*</span></label>

            <select id="governorate_id" type="text" required class=" @error('governorate_id') is-invalid @enderror form-control form-select governorate_id" name="governorate_id">

                <option value="">Select Governorate</option>
                @forelse($governorates as $governorate)
                    <option value="{{$governorate->id}}" >{{$governorate->governorate_name_en}}</option>
                @empty
                @endforelse
            </select>
            <p class="error"></p>
            @error('governorate_id')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror

        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="city_id" class="form-label">City<span class="text-danger">*</span></label>

            <select id="city_id" type="text" required class="@error('city_id') is-invalid @enderror form-control city_id" name="city_id">
                <option value="">Select City</option>
            </select>
            @error('city_id')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
            <p class="error"></p>

        </div>
    </div>
</div>
<div class="form-group mb-3">
    <label for="nearest_landmark" class="form-label">Nearest Landmark</label>
    <input id="nearest_landmark" type="text"
           value="{{ old('nearest_landmark') }}"
           class="form-control nearest_landmark @error('nearest_landmark') is-invalid @enderror" name="nearest_landmark"
           placeholder="Cairo festival city">
    @error('nearest_landmark')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
    <p class="error"></p>

</div>
<div class="form-check mb-3">
    <input id="is_primary"
           type="hidden" value="0" name="is_primary">
    <input id="is_primary"
           type="checkbox"
           {{ old('is_primary') ==1 ? 'checked' : '' }}
           class="form-check-input @error('is_primary') is-invalid @enderror" value="1" name="is_primary">
    <label for="is_primary" class="form-check-label ">  set as default</label>
    <p class="error"></p>
    @error('is_primary')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror

</div>
