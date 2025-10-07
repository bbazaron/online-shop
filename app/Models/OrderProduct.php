<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * @property int $id
     * @property int $order_id
     * @property int $product_id
     * @property int $amount
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'amount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
