<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRoomsDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'serviceRoom_id',
        'name',
        'amount',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function serviceroom()
    {
        return $this->belongsTo('serviceRoom_id');
    }
}
