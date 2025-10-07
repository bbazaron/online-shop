<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as BaseUser;
class User extends BaseUser
{
    /**
     * @property int $id
     * @property string $username
     * @property string $email
     * @property string $password
     * @property string $image
     */
    protected $fillable = [
        'username',
        'email',
        'password'
    ];

    public function userProducts()
    {
        return $this->hasMany(UserProduct::class, 'user_id', 'id');
    }

    public function products() //cart
    {
        return $this->hasManyThrough(
            Product::class,
            UserProduct::class,
            'user_id',
            'id',
            'id',
            'product_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

}
