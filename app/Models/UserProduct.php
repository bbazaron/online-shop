<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    /**
     * @property int $id
     * @property int $user_id
     * @property int $product_id
     * @property int $amount
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'amount'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function sum() {
        return $this->amount*$this->product()->first()->price;
    }

}
