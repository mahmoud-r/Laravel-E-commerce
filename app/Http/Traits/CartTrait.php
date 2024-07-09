<?php

namespace App\Http\Traits;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

trait CartTrait
{


    public function checkCartUpdates()
    {
        $cartContent = Cart::instance('default')->content();
        $updated = false;
        $msg = '';

        $lastUpdate = Session::get('cart_last_update', Carbon::now());

        foreach ($cartContent as $item) {
            $product = Product::find($item->id);

            if ($product && $product->updated_at > $lastUpdate) {
                $updated = true;
                $msg = 'Cart updated due to changes in product details.';

                if (!$product || $product->status != 1 || $product->qty <= 0) {
                    Cart::instance('default')->remove($item->rowId);
                    $msg = 'Product Out of stock';

                    continue;
                }
                if ($product->price != $item->price) {
                    Cart::instance('default')->update($item->rowId, ['price' => $product->price]);
                }

                break;
            }
        }

        if ($updated) {
            Session::put('cart_last_update', Carbon::now());
        }
        $count = Cart::instance('default')->count();

        return [
            'updated' => $updated,
            'msg' => $msg,
            'count' =>$count
        ];
    }

}
