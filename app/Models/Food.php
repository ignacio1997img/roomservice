<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\FuncCall;

class Food extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];
    
    public function menu()
    {
        return $this->belongsTo(FoodMenu::class, 'food_id');
    }
}
