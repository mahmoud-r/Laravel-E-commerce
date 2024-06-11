<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\CartTrait;
use App\Models\DiscountCoupon;
use App\Models\Governorate;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use CartTrait;

    public function cart(){

        $this->checkCartUpdates();
        $governorates = Governorate::get();

        return view('front.cart',compact('governorates'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::with('images')->find($request->id);
        $qty = $request->qty ?: 1;


        if (!$product || $product->status != 1 || $product->qty <= 0) {
            return [
                'status' => false,
                'msg' => 'Product Out of stock',
            ];
        }

        if ($product->max_order  !== 0){
            if ($qty > $product->max_order) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Please note that the maximum limit for adding this item is ' . $product->max_order,
                    'newQty' => $product->max_order
                ]);
            }
        }
        if ($qty > $product->qty) {
            return response()->json([
                'status' => false,
                'msg' => 'Please note that the maximum limit for adding this item is ' . $product->qty,
                'newQty' => $product->qty
            ]);
        }

        $cartContent = Cart::instance('default')->content();
        $productInCart = $cartContent->firstWhere('id', $product->id);

        if ($productInCart) {
            $qty += $productInCart->qty;
            return $this->update($product->id, $qty);
        } else {
            Cart::instance('default')->add($product->id, $product->title, $qty, $product->price, [
                'productImage' => $product->images->first() ?? '',
                'slug' => $product->slug
            ],0);
            Session::put('cart_last_update', Carbon::now());

            return response()->json([
                'status' => true,
                'msg' => $product->title . ' added to cart',
                'newQty' => $qty,
                'cartCount' => Cart::instance('default')->count(),

            ]);
        }
    }

    public function updateCart(Request $request){

       $response =  $this->update($request->itemId , $request->qty);

        return response()->json($response);
    }

    public function update($productId, $qty)
    {
        $cartItem = Cart::instance('default')->search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id == $productId;
        })->first();

        if (!$cartItem) {
            return [
                'status' => false,
                'msg' => 'Product not found in cart',
                'newQty' => 0
            ];
        }

        $product = Product::find($cartItem->id);

        if (!$product || $product->status != 1 || $product->qty <= 0) {
            Cart::instance('default')->remove($cartItem->rowId);
            return [
                'status' => false,
                'msg' => 'Product Out of stock',
                'newQty' => 0
            ];
        }


        if ($product->max_order  !== 0){
            if ($qty > $product->max_order) {
                return [
                    'status' => false,
                    'msg' => 'Please note that the maximum limit for adding this item is ' . $product->max_order,
                    'newQty' => $product->max_order
                ];
            }
        }

        if ($product->qty < $qty) {
            return [
                'status' => false,
                'msg' => 'Quantity (' . $qty . ') not available',
                'newQty' => $product->qty
            ];
        }

        if ($product->price != $cartItem->price) {
            Cart::instance('default')->update($cartItem->rowId, [
                'qty' => $qty,
                'price' => $product->price
            ]);
            Session::put('cart_last_update', Carbon::now());

            $priceChanged = true;
        } else {
            Cart::instance('default')->update($cartItem->rowId, $qty);
            Session::put('cart_last_update', Carbon::now());

            $priceChanged = false;

        }
        $price = $product->price;

        return [
            'status' => true,
            'msg' => $priceChanged ? 'Cart updated successfully. Price has changed.' : 'Cart updated successfully',
            'itemTotal' => Cart::instance('default')->get($cartItem->rowId)->total,
            'cartSubTotal' => Cart::instance('default')->subtotal(),
            'cartTotal' => Cart::instance('default')->total(),
            'cartCount' => Cart::instance('default')->count(),
            'newQty' => $qty,
            'price' =>$price

        ];
    }

    public function deleteItem(Request $request){

        $itemInfo = Cart::instance('default')->get($request->rowId);

        if ($itemInfo == null){

            return response()->json([
                'status' => false,
                'msg'=> 'Item Not found in cart',
                'cartCount' => Cart::instance('default')->count(),

            ]);
        }
        $rowId = $itemInfo->rowId;
        Cart::instance('default')->remove($request->rowId);

        $cartSubTotal =  Cart::instance('default')->subtotal();
        $cartTotal =  Cart::instance('default')->total();
        $cartCount =  Cart::instance('default')->count();

        return response()->json([
            'status' => true,
            'msg'=> 'Item removed from Cart Successfully',
            'rowId'=>$rowId,
            'cartSubTotal'=>$cartSubTotal,
            'cartTotal'=>$cartTotal,
            'cartCount'=>$cartCount,

        ]);
    }

    public function getMiniCart() {
        return view('front.layouts.include.mini_cart');
    }

    public function checkUpdates()
    {
        return response()->json($this->checkCartUpdates());
    }




}
