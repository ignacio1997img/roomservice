<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartsHotel extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'id',
        'name',
        'description',
        'deleted_at'
    ];
}
