<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ProductResource::collection(Product::all());
        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function getCategories()
    {
        return response()->json(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        if (auth()->user()->is_admin) {
            $product = Product::create($request->validated());

            $imageName = $product->slug . '.' . explode("/", $request->file('image')->getClientMimeType())[1];
            $request->file('image')->storeAs('images/products', $imageName);

            $imagePath = 'http://localhost:8000/storage/images/products/' . $imageName;
            $product->image = $imagePath;
            $product->save();

            if ($product) {
                return response()->json([
                    'message' => 'Product created successfully',
                    'product' => $product,
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => "Unauthorized"
        ], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = new ProductResource($product);
        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId)
    {
        $product = Product::find($productId);

        if (auth()->user()->is_admin) {
            if ($product->cartItems()->count() > 0 || $product->orderItems()->count() > 0) {
                return response()->json([
                    'message' => 'Cannot delete this product, it has related data in the cart or order.',
                ], 409);
            } else {
                $product->delete();
                Storage::delete($product->image);

                return response()->json([
                    'message' => "Product deleted successfully",
                ]);
            }
        }
    }
}
