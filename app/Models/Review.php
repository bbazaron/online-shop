<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * @property int $id
     * @property int $product_id
     * @property int $user_id
     * @property string $name
     * @property string $comment
     * @property int $rating
     */
    protected $fillable =
        [
            'product_id',
            'user_id',
            'name',
            'comment',
            'rating'
        ];
}
