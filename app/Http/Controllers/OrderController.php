<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');

        return $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = OrderResource::collection(Order::all());

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
        $response = Http::withHeaders([
            'key' => Config::get('app.rajaongkir_key')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ])->json();

        return response()->json([
            $response['rajaongkir']['results'][0]
        ]);
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
            }

            $payload = [
                'transaction_details' => [
                    'order_id'     => $order->order_id,
                    'gross_amount' => $request->amount,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email'      => $order->user->email,
                ],
                'item_details' => [],
            ];

            $itemDetails = [];

            foreach ($order->orderItems as $item) {
                $itemDetails[] = [
                    'id' => $item->product->slug,
                    'name' => $item->product->title,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'merchant_name' => "JOE CAPE"
                ];
            }

            $payload['item_details'] = $itemDetails;

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $snapUrl = \Midtrans\Snap::getSnapUrl($payload);
            $order->snap_token = $snapToken;
            $order->save();

            $products = [];

            foreach ($order->orderItems as $i) {
                $products[] = [
                    'quantity' => $i->quantity,
                    'id' => $i->product->id,
                    'category' => $i->product->category->name,
                    'title' => $i->product->title,
                    'image' => $i->product->image,
                    'size' => $i->product->size,
                ];
            }

            $userCart = Cart::where('user_id', $user->id)->get();

            foreach ($userCart as $item) {
                $item->cartItems()->delete();
                $item->delete();
            }

            return response()->json([
                'status' => 'success',
                'order' => [
                    'id' => $order->id,
                    'order_id' => $order->order_id,
                    'items' => $products,
                    'user' => $order->user,
                    'status' => $order->status,
                    'amount' => $order->amount,
                    'snap_token' => $order->snap_token,
                    'date' => Carbon::parse($order->created_at)->format('d F Y H:i'),
                ],
                'snapUrl' => $snapUrl,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 401);
    }

    public function callback($userId)
    {

        $orders = Order::where(['user_id' => $userId, 'status' => 'pending'])->get();

        $response = [];

        foreach ($orders as $order) {
            $response[] = Http::withHeaders([
                'Authorization' => base64_encode(config('services.midtrans.serverKey') . ":"),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->get("https://api.sandbox.midtrans.com/v2/$order->order_id/status")->json();
        }

        dd($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
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
