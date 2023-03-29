<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EgresMenu extends Model
{
    use HasFactory;
    protected $fillable = [
        'food_id',
        'room_id',
        'serviceRoom_id',
        'people_id',
        'price',
        'cant',
        'amount',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}
