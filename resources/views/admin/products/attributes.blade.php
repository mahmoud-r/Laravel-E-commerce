@forelse($attributes as $i=> $attribute)
<tr>
    <td>
        {{$i+1}}
    </td>
    <td>
        <input type="text" readonly required  class="form-control" value="{{ $attribute->name }}">
        <input type="hidden" name="attributes[{{ $attribute->id }}]" value="{{ $attribute->id }}">

    </td>
    <td>
        <select class="form-control"  name="attributes[{{ $attribute->id }}]">
            <option value="">Select Value</option>
            @foreach($attribute->values as $value)
                <option value="{{ $value->id }}">
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
        <a href="javascript:(0)" class="remove-item text-decoration-none text-danger remove-attribute">
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
@endforelse
