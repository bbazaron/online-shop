<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_phone',
        'address',
        'comment'
    ];
}
