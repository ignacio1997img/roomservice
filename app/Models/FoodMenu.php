<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\ErrorHandler\ErrorEnhancer\UndefinedFunctionErrorEnhancer;

class FoodMenu extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'food_id',
        'amount',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}
