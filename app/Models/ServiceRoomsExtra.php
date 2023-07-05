<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRoomsExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'serviceRoom_id',
        'detail',
        'amount',
        'registerUser_id',
        'registerRol',
        'deleted_at',
        'deleteUser_id',
        'deleteRol'
    ];
}
