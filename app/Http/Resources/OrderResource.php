<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $items = [];

        foreach ($this->orderItems as $item) {
            $items[] = $item;
        }

        $products = [];

        foreach ($items as $i) {
            $products[] = [
                'quantity' => $i->quantity,
                'id' => $i->product->id,
                'category' => $i->product->category->name,
                'title' => $i->product->title,
                'image' => $i->product->image,
                'size' => $i->product->size,
            ];
        }

        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'items' => $products,
            'user' => $this->user,
            'amount' => $this->amount,
            'status' => $this->status,
            'date' => Carbon::parse($this->created_at)->format('d F Y H:i'),
            'snap_token' => $this->snap_token,
        ];
    }
}
