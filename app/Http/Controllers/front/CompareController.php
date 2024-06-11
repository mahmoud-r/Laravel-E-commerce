<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Compare;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompareController extends Controller
{

    public function index()
    {
        $compares = Cart::instance('compare')->content();
        $productsCompare = $compares->map(function ($compare) {
            return Product::find($compare->id);
        })->filter()->all();

        return view('front.compare.index',compact('productsCompare'));
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        $compares = Cart::instance('compare')->content();
        $productInCompare = $compares->firstWhere('id', $product->id);

        $productsCompare = $compares->map(function ($compare) {
            return Product::find($compare->id);
        })->filter()->all();

        if (!$productInCompare) {
            Cart::instance('compare')->add($product->id, $product->title, 1, $product->price, [
                'productImage' => $product->images->first() ?? '',
            ], 0);
            $productsCompare[] = $product;
        }

        return view('front.popup.compare_box', compact('productsCompare'));
    }

    public function destroy( $productId)
    {
        $compares = Cart::instance('compare')->content();
        $productIncompare = $compares->firstWhere('id', $productId);

        if (!$productIncompare) {
            return response()->json([
                'status' => false,
                'msg' => 'Product not found in compare list',
            ]);
        }

        Cart::instance('compare')->remove($productIncompare->rowId);
        return response()->json([
            'status'=>true,
            'msg' => 'Product Deleted From compare Successfully',
            'productDeleted'=>$productId
        ]);
    }
}
