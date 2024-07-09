
<div class="offcanvas offcanvas-end  " tabindex="-1" id="miniCart" aria-labelledby="offcanvasRightLabel" >
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Shopping Cart
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    @if(Cart::instance('default')->content()->isNotEmpty())

    <div class="offcanvas-body cart_box">
        <ul class="cart_list">
            @forelse(Cart::instance('default')->content() as $item)
              <li id="{{$item->rowId}}">
                <a href="javascript:void(0)" class="item_remove"><i class="ion-close" onclick="deleteItem('{{$item->rowId}}')"></i></a>
                <a href="{{route('front.product',$item->options->slug)}}">

                    @if(!empty($item->options->productImage->image))
                        <img src="{{asset('uploads/products/images/thumb/'.$item->options->productImage->image)}}" alt="{{$item->name}}">
                    @else
                        <img src="{{asset('front_assets/images/empty-img.png')}}" alt="{{$item->name}}">

                    @endif
                    <span class="mini-cart-title"> {{$item->name}}</span>
                </a>

                <div class="quantity ">
                    <input type="button" value="-" class=" minus-cart sub"  data-id="{{$item->id}}">
                    <input type="text" name="quantity" value="{{$item->qty}}" title="Qty" class="qty qty-{{$item->id}}" size="4">
                    <input type="button" value="+" class=" plus-cart add" data-id="{{$item->id}}">

                </div>

                <span class="cart_quantity">
                    <span class="cart_amount itemTotal-{{$item->id}}">
                            {{$item->total }} EGP
                    </span>
                </span>
            </li>
            @empty
            @endforelse
        </ul>

        <div class="cart_footer">
            <p class="cart_total">
                <strong class="">Items In Cart:</strong>
                <span class="cartCount">
                   {{Cart::instance('default')->count()}}
                </span>
            </p>
            <p class="cart_total">
                <strong>Subtotal:</strong>
                <span class="cart_price cartSubTotal">
                     {{Cart::instance('default')->subtotal()}} EGP
                </span>
            </p>
            <p class="cart_buttons">
                <a href="{{route('front.cart')}}" class="btn btn-fill-line view-cart">View Cart</a>
                <a href="{{route('front.checkout')}}" class="btn btn-fill-out checkout">Checkout</a></p>
        </div>
    </div>
    @else
        <div class="card text-center h-100">
            <div class="card-body d-flex align-items-center" >
                <h5 class="mt-5 mb-5">
                    Looks like your cart is empty. Keep <a href="{{route('front.shop')}}" class="text-primary">shopping</a> and fill it up!

                </h5>
            </div>

        </div>
    @endif
</div>


