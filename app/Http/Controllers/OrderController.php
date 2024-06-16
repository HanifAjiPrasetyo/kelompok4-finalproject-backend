<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $order = Order::all();

        return response()->json([
            'orders' => $order
        ]);
    }

    public function userOrders()
    {
        $orders = Order::where('user_id', auth()->id())->get();

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getServices(Request $request)
    {
        return response()->json($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = User::find($request->user['data']['id']);

        $items = $request->items;

        if (auth()->id() === $user->id) {
            $order = $user->orders()->create([
                'order_id' => fake()->uuid(),
                'user_id' => $user->id,
                'status' => 'pending',
                'amount' => $request->amount,
            ]);

            if ($order) {
                foreach ($items as $item) {
                    $order->orderItems()->create([
                        'order_id' => $order->id,
                        'product_id' => $item['productId'],
                        'quantity' => $item['quantity'],
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'order' => [
                        'items' => $order->orderItems,
                        'user' => $user,
                        'amount' => $order->amount,
                    ],
                ], 201);
            }
        }

        return response()->json([
            'success' => false,
        ], 401);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
