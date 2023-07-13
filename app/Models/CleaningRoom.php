<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleaningRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'cleaningAsignation_id',
        'room_id',
        'date',
        'start',
        'finish',
        'observation',
        'starUser_id',
        'finishUser_id',
        'deleted_at'
    ];


    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function startUser()
    {
        return $this->belongsTo(User::class, 'starUser_id');
    }
    public function finishUser()
    {
        return $this->belongsTo(User::class, 'finishUser_id');
    }

    public function cleaningRoomProduct()
    {
        return $this->hasMany(CleaningRoomsProduct::class, 'cleaningRoom_id');
    }
}
