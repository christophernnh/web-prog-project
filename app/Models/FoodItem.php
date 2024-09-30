<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function itemType()
    {
        return $this->belongsTo(FoodItemType::class, 'item_type_id');
    }
    public function statusType()
    {
        return $this->belongsTo(StatusType::class, 'status_type_id');
    }
}
