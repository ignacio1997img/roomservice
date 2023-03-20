<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriesRoom extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'deleted_at',
        'registerUser_id',
        'deletedUser_id'
    ];

    public function part()
    {
        return $this->hasMany(CategoriesRoomsPart::class, 'categoryRoom_id');
    }
}
