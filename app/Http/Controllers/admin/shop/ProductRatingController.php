<?php

namespace App\Http\Controllers\admin\shop;

use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductRatingController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:reviews-list|reviews-publish|reviews-delete', ['only' => ['index','getAll'] ]);
        $this->middleware('permission:reviews-publish', ['only' => ['publishToggle']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);

    }

    public function index(){
        return view('admin.reviews.index');
    }

    public function getAll() {
        $reviews = ProductRating::orderBy('status', 'asc')
            ->with(['product.images', 'user'])
            ->get()
            ->map(function($review) {
                return [
                    'id' => $review->id,
                    'index' => $review->index,
                    'product' => [
                        'id' => $review->product->id,
                        'title' => $review->product->title,
                        'image' => $review->product->images->first()->image ?? null,
                    ],
                    'user' => [
                        'id' => $review->user->id,
                        'name' => $review->user->name,
                    ],
                    'rating_percentage' => $review->rating_percentage,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'status' => $review->status,
                    'created_at' => $review->created_at,
                ];
            });

        return response()->json($reviews);
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
