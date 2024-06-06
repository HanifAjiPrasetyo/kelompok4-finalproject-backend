<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with('cartItems.product')->where('user_id', auth()->id())->get();
        return response()->json($carts);
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
    public function store(StoreCartRequest $request)
    {
        $cart = Cart::create([
            'user_id' => auth()->id(),
            'total_price' => 0,
            'total_quantity' => 0,
        ]);

        $product = Product::findOrFail($request->product_id);

        $cartItem = $cart->cartItems()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        $cart->total_price += $cartItem->price * $cartItem->quantity;
        $cart->total_quantity += $cartItem->quantity;
        $cart->save();

        return response()->json(['message' => 'Cart item added successfully.', 'cart' => $cart, 'cartItem' => $cartItem]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first();
        if ($cartItem) {
            $oldQuantity = $cartItem->quantity;
            $cartItem->update(['quantity' => $request->quantity]);
            $cart->total_price -= $cartItem->price * $oldQuantity;
            $cart->total_price += $cartItem->price * $request->quantity;
            $cart->total_quantity -= $oldQuantity;
            $cart->total_quantity += $request->quantity;
            $cart->save();

            return response()->json(['message' => 'Cart item updated successfully.', 'cart' => $cart]);
        }

        return response()->json(['message' => 'Cart item not found.', 'cart' => $cartItem], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart, $productId)
    {
        $cartItem = $cart->cartItems()->where('product_id', $productId)->firstOrFail();
        $cartItem->delete();
        $cart->delete();

        // $cart->total_price -= $cartItem->price * $cartItem->quantity;
        // $cart->total_quantity -= $cartItem->quantity;
        // $cart->save();
        // $cartItem->save();

        return response()->json(['message' => 'Cart item removed successfully.']);
    }
}
