<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egre extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'serviceRoom_id',
        'people_id',
        'amount',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];
}
