<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesRoomsPart extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoryRoom_id',
        'partHotel_id',
        'observation',
        'registerUser_id',
        'deletedUser_id',
        'deleted_at'
    ];
}
