<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRedemption extends Model
{
    protected $fillable = [
        'user_id', 'item_id', 'quantity', 'total_price_coins', 
        'status', 'verified_at', 'verified_by', 'redemption_code'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
