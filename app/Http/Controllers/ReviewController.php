<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use Symfony\Component\HttpFoundation\Response;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        if ($product->reviews->isEmpty()) {
            return response()->json(['message' => 'No Reviews Yet'], Response::HTTP_NO_CONTENT);
        }

        return ReviewResource::collection($product->reviews);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request, Product $product)
    {
        $review = new Review($request->all()); 
        $product->reviews()->save($review);
        return response([
            'data' => new ReviewResource($review)
        ], Response::HTTP_CREATED); 

    }

    /**
     * Display the specified resource.
     */
    public function show($productId, Review $review)
    {
        if ($review->product_id != $productId) {
            return response()->json(['error' => 'Review not found for this product'], Response::HTTP_NOT_FOUND);
        }
    
        return new ReviewResource($review);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
