<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductCollection;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\ProductNotBelongsToUser; 
use Auth;
use OpenApi\Annotations as OA;

class ProductController extends Controller implements \Illuminate\Routing\Controllers\HasMiddleware
{
    // Define the middleware for the controller
    public static function middleware(): array
    {
        return [
            new Middleware(middleware: 'auth:api', except: ['index', 'show']),
        ];
    }
    




    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/products",
     *     operationId="getProductsList",
     *     tags={"Products"},
     *     summary="Get list of products",
     *     description="Returns a list of products",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    
    public function index()
    {
        return ProductCollection::collection(Product::paginate());
        // return Product::paginate();
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
     *     path="/api/products",
     *     operationId="storeProduct",
     *     tags={"Products"},
     *     summary="Store a new product",
     *     description="Creates a new product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product;
        $product->user_id = Auth::id();
        $product->name = $request->name;
        $product->detail = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->discount = $request->discount;

        $product->save();

        return response([
            'data' => new ProductResource($product),
            'message' => 'Product created successfully',
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     operationId="showProduct",
     *     tags={"Products"},
     *     summary="Show a product",
     *     description="Returns a single product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function show(Product $product)
    {
      
        return new ProductResource($product); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     summary="Update an existing product",
     *     description="Updates the product information",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Check if the product belongs to the authenticated user  // throw an exception if it doesn't belong to the user
        $this->ProductUserCheck($product);

        $product->detail = $request->description;
        unset($request->description);
        $product->update($request->all());

        return response([
            'data' => new ProductResource($product),
           'message' => 'Product updated successfully',
        ],Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     operationId="destroyProduct",
     *     tags={"Products"},
     *     summary="Delete a product",
     *     description="Deletes a product by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function destroy(Product $product)
    {
        // Check if the product belongs to the authenticated user  // throw an exception if it doesn't belong to the user
        $this->ProductUserCheck($product); 
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }

    public function ProductUserCheck($product) 
    {
        if (Auth::id() !== $product->user_id) 
        {
            throw new ProductNotBelongsToUser; 
        }
    }
}
 