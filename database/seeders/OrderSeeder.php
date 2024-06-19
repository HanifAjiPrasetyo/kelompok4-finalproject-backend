<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::create([
            'order_id' => fake()->uuid(),
            'user_id' => 2,
            'status' => 'pending',
            'amount' => 0,
        ]);

        $orderItems = [
            [
                'order_id' => $order->id,
                'product_id' => 2,
                'quantity' => 2,
            ],
            [
                'order_id' => $order->id,
                'product_id' => 3,
                'quantity' => 5,
            ],
        ];

        $totalAmount = 0;
        foreach ($orderItems as $item) {
            $orderItem = OrderItem::create($item);
            $totalAmount += $orderItem->product->price * $orderItem->quantity;
        }

        $order->update(['amount' => $totalAmount]);
    }
}
