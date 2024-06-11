<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductRatingController extends Controller
{
    public function index(){
        $reviews =ProductRating::orderBy('status', 'asc')->paginate(25);
        return view('admin.reviews.index',compact('reviews'));
    }
    public function publishToggle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'review_id' => 'required|exists:product_ratings,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());

        }

        $review = ProductRating::findOrFail($request->review_id);

        $review->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', $review->status == 1 ? 'Review Published Successfully' : 'Review Unpublished Successfully');
    }

    public function destroy($id){
        $review = ProductRating::findOrFail($id);

        if ($review->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Review Deleted Successfully',
                'deleted_id' => $id
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong',
            ], 500);
        }
    }
}
