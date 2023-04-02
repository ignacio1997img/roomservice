<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkersRoom extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'worker_id',
        'room_id',
        'registerUser_id',
        'deletedUser_id',
        'deleted_at'
    ];

}
