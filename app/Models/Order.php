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
     * @property string $yougile_task_id
     * @property float $totalSum
     * @property string $status
     */
    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_phone',
        'address',
        'comment',
        'yougile_task_id',
        'total_sum',
        'status',
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
