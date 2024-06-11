<div class="modal fade modal-blur" id="edit-user-address" tabindex="-1" aria-labelledby="edit-user-address" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit {{ $address->address_name }} address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="AddressUpdateForm" >
                <input type="hidden" name="address_id" value="{{$address->id}}">
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label for="address_name" class="form-label ">Address Name<span class="text-danger">*</span></label>
                        <input id="address_name" type="text"
                               value="{{$address->address_name}}"
                               class="form-control address_name" name="address_name" required  autofocus placeholder="Like 'Home'">

                        <p class="error"></p>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="first_name" class="form-label">First Name<span class="text-danger">*</span></label>
                                <input id="first_name" type="text"
                                       value="{{$address->first_name}}"
                                       class="form-control first_name" name="first_name"
                                       required  placeholder="">

                                <p class="error"></p>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="last_name" class="form-label ">Last Name<span class="text-danger">*</span></label>
                                <input id="last_name" type="text"
                                       value="{{$address->last_name}}"
                                       class="form-control last_name" name="last_name"
                                       required  placeholder="">
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
                                       value="{{$address->phone}}"
                                       class="form-control" name="phone"
                                       placeholder="01xxxxxxxxx">
                                <p class="error"></p>

                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="second_phone" class="form-label">Second Phone Number</label>

                                <input id="second_phone" type="number"
                                       value="{{$address->second_phone}}"
                                       class="form-control second_phone" name="second_phone"
                                       placeholder="01xxxxxxxxx">
                                <p class="error"></p>

                            </div>

                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="street" class="form-label">Street Name<span class="text-danger">*</span></label>

                        <input id="street" type="text"
                               required
                               value="{{$address->street}}"
                               class="form-control" name="street"
                               placeholder="Talaat Harb Street">
                        <p class="error"></p>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="building" class="form-label">Building name/no<span class="text-danger">*</span></label>

                                <input id="building" type="text"
                                       required
                                       value="{{$address->building}}"
                                       class="form-control" name="building"
                                       placeholder="Princess Tower">
                                <p class="error"></p>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="district" class="form-label">District</label>
                                <input id="district" type="text"
                                       value="{{$address->district}}"
                                       class="form-control district" name="district"
                                       placeholder="7th District">
                                <p class="error"></p>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="governorate_id" class="form-label">Governorate<span class="text-danger">*</span></label>

                                <select id="governorate_id" type="text" required class="form-control form-select governorate_id" name="governorate_id">

                                    <option value="">Select Governorate</option>
                                    @forelse($governorates as $governorate)
                                        <option value="{{$governorate->id}}" {{$address->governorate->id == $governorate->id ?'selected':''}}>{{$governorate->governorate_name_en}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <p class="error"></p>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="city_id" class="form-label">City<span class="text-danger">*</span></label>

                                <select id="city_id" type="text" required class="form-control city_id" name="city_id">
                                    <option value="">Select City</option>
                                    @forelse($cities as $city)
                                       <option value="{{$city->id}}" {{$address->city_id == $city->id ? 'selected' :''}} >{{$city->city_name_en}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <p class="error"></p>

                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nearest_landmark" class="form-label">Nearest Landmark</label>
                        <input id="nearest_landmark" type="text"
                               value="{{$address->nearest_landmark}}"
                               class="form-control nearest_landmark" name="nearest_landmark"
                               placeholder="Cairo festival city">

                        <p class="error"></p>

                    </div>
                    <div class="form-check mb-3">
                       <label for="is_primary" class="form-check-label ">
                           <input id="is_primary"
                                  type="checkbox"
                                  class="form-check-input" value="1" {{$address->is_primary == 1 ? 'checked':''}} name="is_primary">

                           set as default</label>
                        <p class="error"></p>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-fill-out">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

