<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlists =Wishlist::where('user_id',Auth::user()->id)->get();
        return view('front.wishlist',compact('wishlists'));
    }


    public function addToWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'msg' => 'You must log in first.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'product' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => 'Invalid product.',
                'errors' => $validator->errors()
            ]);
        }

        $user = Auth::id();
        $productId = $request->input('product');

        $wishlist = Wishlist::where('user_id', $user)->where('product_id', $productId)->first();
        if ($wishlist) {
            return response()->json([
                'status' => false,
                'msg' => 'This product already exists in the wishlist.'
            ]);
        }

       Wishlist::create([
            'user_id' => $user,
            'product_id' => $productId
        ]);
        $wishlist_count = $wishlist = Wishlist::where('user_id', $user)->count();

        return response()->json([
            'status' => true,
            'count'=>$wishlist_count,
            'msg' => 'Product added to wishlist successfully.'
        ]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::id();
        $productId = $request->input('product');

        $wishlist = Wishlist::where('user_id', $user)->where('product_id', $productId)->first();
        if (!$wishlist) {
            return response()->json([
                'status' => false,
                'msg' => 'This product already Removed From the wishlist.'
            ]);
        }

        $wishlist->delete();

        $wishlists =Wishlist::where('user_id',Auth::user()->id)->get();
        return response()->json([
            'status' => true,
            'msg' => 'Product Removed From wishlist successfully.',
            'wishlist'=>$wishlist->id,
            'wishlistCount'=>$wishlists->count(),
        ]);
    }
}
