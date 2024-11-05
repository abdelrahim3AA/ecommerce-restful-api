<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/products/{product}/reviews",
     *     operationId="getReviewsList",
     *     tags={"Reviews"},
     *     summary="Get list of reviews for a product",
     *     description="Returns a list of reviews for the specified product",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
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
     /**
     * @OA\Post(
     *     path="/api/products/{product}/reviews",
     *     operationId="storeReview",
     *     tags={"Reviews"},
     *     summary="Store a new review",
     *     description="Creates a new review for a product",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
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
    /**
     * @OA\Get(
     *     path="/api/products/{product}/reviews/{id}",
     *     operationId="showReview",
     *     tags={"Reviews"},
     *     summary="Show a review",
     *     description="Returns a single review for a product",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found"
     *     )
     * )
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
    /**
     * @OA\Put(
     *     path="/api/products/{product}/reviews/{id}",
     *     operationId="updateReview",
     *     tags={"Reviews"},
     *     summary="Update an existing review",
     *     description="Updates the review information",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Review")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found"
     *     )
     * )
     */
    public function update(UpdateReviewRequest $request, Product $product, Review $review)
    {
        if ($review->product_id != $product->id) {
            return response()->json(['error' => 'Review not found for this product'], Response::HTTP_NOT_FOUND);
        }
        $review->update($request->all());
        return response([
            'data' => new ReviewResource($review)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/products/{product}/reviews/{id}",
     *     operationId="destroyReview",
     *     tags={"Reviews"},
     *     summary="Delete a review",
     *     description="Deletes a review by ID",
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Review deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found"
     *     )
     * )
     */
    public function destroy(Product $product, Review $review)
    {
        if ($review->product_id != $product->id) {
            return response()->json(['error' => 'Review not found for this product'], Response::HTTP_NOT_FOUND);
        }
        $review->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
