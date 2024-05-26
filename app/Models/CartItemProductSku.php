<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemProductSku extends Model
{
    use HasFactory;

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class, 'products_sku_id');
    }
}
