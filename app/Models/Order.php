<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @property int $id
     * @property int $user_id
     * @property string $contact_name
     * @property string $contact_phone
     * @property string $address
     * @property string $comment
     */
    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_phone',
        'address',
        'comment'
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
