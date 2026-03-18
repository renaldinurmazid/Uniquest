<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'description', 'image_path', 'price_coins', 'stock', 'type', 'is_active'];

    public function redemptions()
    {
        return $this->hasMany(ItemRedemption::class);
    }
}
