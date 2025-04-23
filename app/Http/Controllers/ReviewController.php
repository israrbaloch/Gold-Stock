<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $order = ProductOrder::findOrFail($request->order_id);

        // dd($order->reviews->count());

        // Check 
        if ($order->reviews->count() > 0) {
            abort(403, 'You have already reviewed this order!');
        }

        return view('reviews.create', compact('order'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $request->validate([
            'order_id' => 'required|exists:product_orders,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.rating' => 'required|integer|min:1|max:5',
            'products.*.review' => 'nullable|string|max:1000',
        ]);

        // order
        $order = ProductOrder::findOrFail($request->order_id);

        if ($order->reviews->count() > 0) {
            abort(403, 'You have already reviewed this order!');
        }


        // Check if the order belongs to the authenticated user


        // dd($request->all());

        // Loop through the submitted reviews
        foreach ($request->products as $productReview) {
            // Create or update the review for each product
            Review::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'order_id' => $request->order_id,
                    'product_id' => $productReview['product_id'],
                ],
                [
                    'rating' => $productReview['rating'],
                    'review' => $productReview['review'] ?? null,
                ]
            );
        }

        // Redirect back with a success message
        return redirect()->route('home')->with('review_submit', 'Review submitted successfully!');
    }

    // fetchReviews
    public function fetchReviews(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    $reviews = $product->reviews()->with('user')->latest()->paginate(5); // 5 reviews per page

    if ($request->ajax()) {
        return view('product.partial-reviews', compact('reviews'))->render();
        // return view('partials.reviews', compact('reviews'))->render();
    }

    return response()->json(['error' => 'Bad Request'], 400);
}
}

