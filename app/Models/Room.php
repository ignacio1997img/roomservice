<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoryFacility_id',
        'categoryRoom_id',
        'number',
        'amount',
        'status',
        'registerUser_id',
        'deletedUser_id',
        'deleted_at'
    ];

    public function categoryfacility()
    {
        return $this->belongsTo(CategoriesFacility::class, 'categoryFacility_id');
    }

    public function caregoryroom()
    {
        return $this->belongsTo(CategoriesRoom::class, 'categoryRoom_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'registerUser_id');
    }

    public function file()
    {
        return $this->hasMany(RoomsFile::class, 'room_id');
    }
}
