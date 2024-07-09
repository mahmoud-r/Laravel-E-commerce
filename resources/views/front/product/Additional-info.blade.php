
<table class="table table-bordered">
    @forelse($product->productAttributes as $attribute)
        <tr>
            <td>{{$attribute->attribute->name}}</td>
            <td> {{$attribute->attributeValue->value}}</td>
        </tr>
    @empty
    @endforelse
</table>
