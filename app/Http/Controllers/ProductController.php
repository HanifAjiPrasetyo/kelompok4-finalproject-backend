<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    // Create new Category
    public function storeCategory(Request $request)
    {
        if (auth()->user()->is_admin) {
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            $categories = Category::all();

            foreach ($categories as $category) {
                $categoryNames[] = $category->name;
            }

            if (in_array(ucwords($request->name), $categoryNames)) {
                $validator->addRules([
                    'name' => 'unique:categories'
                ]);
            }

            if ($validator->fails()) {
                return response()->json($validator->messages(), 422);
            }

            $category = Category::create([
                'name' => ucwords($request->name),
                'description' => $request->description ?  $request->description : null
            ]);

            if ($category) {
                return response()->json([
                    'message' => 'Category created successfully'
                ], 201);
            }
        }

        return response()->json([
            'success' => false,
            'message' => "Unauthorized"
        ], 401);
    }

    public function updateCategory(Request $request, $categoryId)
    {
        if (auth()->user()->is_admin) {
            $category = Category::find($categoryId);

            $validator = Validator::make($request->all(), []);

            if ($request->name) {
                $validator->addRules(['name' => 'unique:categories']);
            }

            if ($validator->fails()) {
                return response()->json($validator->messages(), 422);
            }

            $updated = $category->update([
                'name' => $request->name ? $request->name : $category->name,
                'description' => $request->description ? $request->description : $category->description
            ]);

            if ($updated) {
                return response()->json([
                    'message' => 'Category updated successfully'
                ], 201);
            }
        }

        return response()->json([
            'success' => false,
            'message' => "Unauthorized"
        ], 401);
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
    public function updateProduct(Request $request, $productId)
    {
        if (auth()->user()->is_admin) {
            $product = Product::find($productId);

            $validator = Validator::make($request->all(), []);

            if ($request->file('image')) {
                $validator->addRules([
                    'image' => 'file|image|max:2048'
                ]);

                if ($validator->fails()) {
                    return response()->json($validator->messages(), 422);
                }

                Storage::delete($product->image);

                $image = $request->file('image');
                $imageName = $product->slug . '.' . explode("/", $image->getClientMimeType())[1];
                $image->storeAs('images/products', $imageName);
                $imagePath = 'http://localhost:8000/storage/images/products/' . $imageName;
                $product->image = $imagePath;
                $product->save();
            }

            $updated = $product->update([
                'category_id' => $request->category_id === "null" || !$request->category_id ? $product->category_id : $request->category_id,
                'title' => $request->title === "null" || !$request->title ? $product->title : $request->title,
                'size' => $request->size === "null" || !$request->size ? $product->size : $request->size,
                'price' => $request->price === "null" || !$request->price ? $product->price : $request->price,
                'weight' => $request->weight === "null" || !$request->weight ? $product->weight : $request->weight,
                'year' => $request->year === "null" || !$request->year ? $product->year : $request->year,
                'description' => $request->description === "null" || !$request->description ? $product->description : $request->description,
            ]);

            if ($updated) {
                return response()->json([
                    'message' => 'Product updated successfully',
                    'product' => $product,
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => "Unauthorized"
        ], 401);
    }

    public function updateActiveProduct(Request $request)
    {
        if (auth()->user()->is_admin) {
            $product = Product::find($request->productId);

            if ($request->isChecked == "false") {
                $product->update([
                    'is_active' => false,
                ]);

                return response()->json([
                    'message' => 'Product has been inactivated',
                ]);
            } else {
                $product->update([
                    'is_active' => true,
                ]);

                return response()->json([
                    'message' => 'Product has been activated',
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => "Unauthorized"
        ], 401);
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
