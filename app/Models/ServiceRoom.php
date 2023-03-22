<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'people_id',
        'number',
        'category',
        'facility',
        'amount',
        'observation',
        'status',
        'start',
        'finish',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function servicedetail()
    {
        return $this->hasMany(ServiceRoomsDetail::class, 'serviceRoom_id');
    }
}