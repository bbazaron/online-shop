<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @property int $id
     * @property string $name
     * @property string $description
     * @property int $price
     * @property string $image
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image'
    ];
    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
