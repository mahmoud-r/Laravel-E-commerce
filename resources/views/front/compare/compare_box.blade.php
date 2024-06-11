
<div class="compare_box">
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tbody>
            <tr class="pr_image">
                <td class="row_title">Product Image</td>
                @foreach($productsCompare as $productCompare)
                    <td class="row_img product_{{$productCompare->id}}">
                        <a href="{{route('front.product',$productCompare->slug)}}">

                            @if(!empty($productCompare->productImage->image))
                                <img src="{{asset('uploads/products/images/thumb/'.$productCompare->productImage->image)}}" alt="{{$productCompare->title}}">
                            @else
                                <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$productCompare->title}}">

                            @endif
                        </a>
                    </td>

                @endforeach
            </tr>
            <tr class="pr_title">
                <td class="row_title">Product Name</td>
                @foreach($productsCompare as $productCompare)
                <td class="product_name product_{{$productCompare->id}}"><a href="{{route('front.product',$productCompare->slug)}}">{{$productCompare->title}}</a></td>
                @endforeach
            </tr>
            <tr class="pr_price">
                <td class="row_title">Price</td>
                @foreach($productsCompare as $productCompare)
                <td class="product_price product_{{$productCompare->id}}">
                    <span class="price">{{$productCompare->price}}</span>

                    @if(!empty($productCompare->compare_price )&& $productCompare->compare_price > $productCompare->price)
                        <del>${{$productCompare->compare_price}}</del>
                        <div class="on_sale">
                            <span>{{$productCompare->discountPercentage()}}% Off</span>
                        </div>
                    @endif
                </td>
                @endforeach
            </tr>
            <tr class="pr_rating">
                <td class="row_title ">Rating</td>
                @foreach($productsCompare as $productCompare)
                <td class="product_{{$productCompare->id}}">
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:{{$productCompare->average_rating_percentage}}%"></div>
                        </div>
                        <span class="rating_num">({{$productCompare->rating_count}})</span>
                    </div>
                </td>
                @endforeach
            </tr>
            <tr class="pr_add_to_cart">
                <td class="row_title">Add To Cart</td>
                @foreach($productsCompare as $productCompare)
                <td class="row_btn product_{{$productCompare->id}}"><a href="javascript:void(0)" class="btn btn-fill-out btn-addtocart"  onclick="addToCart({{$productCompare->id}})" ><i class="icon-basket-loaded"></i> Add To Cart</a></td>
                @endforeach
            </tr>
            <tr class="description">
                <td class="row_title ">Description</td>
                @foreach($productsCompare as $productCompare)
                    <td class="row_text product_{{$productCompare->id}}"><p> {!! $productCompare->short_description !!} </p></td>
                @endforeach
            </tr>
            <tr class="pr_stock">
                <td class="row_title ">Item Availability</td>
                @foreach($productsCompare as $productCompare)
                    @if($productCompare->qty > 0 && $productCompare->status !=0)
                        <td class="row_stock product_{{$productCompare->id}}"><span class="in-stock">In Stock</span></td>
                    @else
                        <td class="row_stock product_{{$productCompare->id}}"><span class="out-stock">Out Of Stock</span></td>
                    @endif
                @endforeach
            </tr>
            <tr class="pr_remove">
                <td class="row_title"></td>
                @foreach($productsCompare as $productCompare)
                <td class="row_remove product_{{$productCompare->id}}">
                    <a href="javascript:void(0)" onclick="deleteCompare({{$productCompare->id}})" ><span>Remove</span> <i class="fa fa-times"></i></a>
                </td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
</div>


