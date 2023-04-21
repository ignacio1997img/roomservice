<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomsFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'image',
        'deleted_at'
    ];
}
