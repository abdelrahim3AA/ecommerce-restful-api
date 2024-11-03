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
    public function store(StoreProductRequest $request)
    {
        $product = new Product;

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
 