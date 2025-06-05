<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as BaseUser;
class User extends BaseUser
{
    protected $fillable = [
        'username',
        'email',
        'password'
    ];

    public function userProducts()
    {
        return $this->hasMany(UserProduct::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            UserProduct::class,
            'user_id',
            'id',
            'id',
            'product_id');
    }
}
